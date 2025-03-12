<?php

namespace Hieunv\WineProducer\Console;

use Hieunv\WineProducer\Model\ImageUploader;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File as FileDriver;
use Hieunv\WineProducer\Logger\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Filesystem\Io\File as IoFile;
use Magento\Framework\File\Csv;

class ProducerImport extends Command
{
    public const TABLE_PRODUCER = 'hieunv_wine_producer';
    public const PRODUCER_FILE_FOLDER = 'import/producer/';
    public const PRODUCER_IMAGE_FOLDER = 'import/producer/images';
    public const PRODUCER_FILE_NAME = 'producer.csv';

    /**
     * @var ResourceConnection
     */
    protected ResourceConnection $resource;
    /**
     * @var AdapterInterface
     */
    protected AdapterInterface $connection;
    /**
     * @var Logger
     */
    protected Logger $logger;
    /**
     * @var FileDriver
     */
    protected FileDriver $fileDriver;
    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;
    /**
     * @var string
     */
    protected string $file;
    /**
     * @var IoFile
     */
    protected IoFile $ioFile;
    /**
     * @var Csv
     */
    protected Csv $csv;

    /**
     * @param ResourceConnection $resource
     * @param Logger $logger
     * @param FileDriver $fileDriver
     * @param Filesystem $filesystem
     * @param IoFile $ioFile
     * @param Csv $csv
     */
    public function __construct(
        ResourceConnection $resource,
        Logger $logger,
        FileDriver $fileDriver,
        Filesystem $filesystem,
        IoFile $ioFile,
        Csv $csv
    ) {
        parent::__construct();
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->logger = $logger;
        $this->fileDriver = $fileDriver;
        $this->filesystem = $filesystem;
        $this->ioFile = $ioFile;
        $this->csv = $csv;
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {

        $this->setName('hieunv:producer:import')
            ->setDescription(__('Import wine producer'));

        $this->addArgument('file', InputArgument::OPTIONAL, __('Type a custom csv file path'));
        $this->addOption(
            'clean-table',
            'c',
            InputOption::VALUE_NONE,
            'Skip Remove All Old Record before Import New Record'
        );
        parent::configure();
    }

    /**
     * Import producer executing
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws FileSystemException
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->info('---Start importing producer session---');
        $output->writeln('Importing...');
        $file = $input->getArgument('file');
        $removeOldRecord = $input->getOption('clean-table');
        $connection = $this->connection;

        if (!$file) {
            $file = self::PRODUCER_FILE_NAME;
        }
        $filePath = $this->filesystem
                ->getDirectoryRead(DirectoryList::VAR_DIR)
                ->getAbsolutePath(). self::PRODUCER_FILE_FOLDER. $file;

        $producerTable = $connection->getTableName(self::TABLE_PRODUCER);
        $i = 0;
        if ($this->fileDriver->isExists($filePath)) {
            $dataProducer = $this->csv->getData($filePath);

            if (!empty($dataProducer) && $removeOldRecord) {
                $connection->delete($producerTable);
                // @todo: Handle product attribute after removing producer
            }

            $n = 0;

            foreach ($dataProducer as $row) {
                $n++;
                if ($row[0] === "enable") {
                    // skip header row
                    continue;
                }
                if (empty($row[1])) {
                    $output->writeln(__('Cannot insert row %1. "name" are required field.', $n));
                    $this->logger->info(__('Cannot insert row %1. "name" are required field.', $n));
                    continue;
                }

                if (empty($row[3])) {
                    $output->writeln(__('Cannot insert row %1. "image" are required field.', $n));
                    $this->logger->info(__('Cannot insert row %1. "image" are required field.', $n));
                    continue;
                }

                try {
                    $enable = !empty($row[0]) ? 1 : 0;
                    $website = (filter_var($row[4], FILTER_VALIDATE_URL) !== false) ? $row[4] : '';
                    $maxId = (int) $connection->fetchOne(
                        $connection->select()->from(
                            self::TABLE_PRODUCER,
                            new \Zend_Db_Expr("MAX(producer_id) AS maxId")
                        )
                    );
                    $newId = $maxId + 1;
                    $mediaFile = $this->moveProducerImage($row[3], $newId);

                    if (empty($mediaFile)) {
                        $output->writeln(__('Cannot insert row %1. Image does not exist or is not supported.', $n));
                        $this->logger->info(__('Cannot insert row %1. Image does not exist or is not supported.', $n));
                        continue;
                    }

                    $rowInsert = [
                        'enable' => $enable,
                        'name' => $row[1],
                        'description' => $row[2],
                        'image' => $mediaFile,
                        'website' => $website
                    ];

                    $connection->insert(
                        $producerTable,
                        $rowInsert
                    );
                    $output->writeln(__('Inserted row %1 successfully!', $n));
                    $i++;
                } catch (\Exception $e) {
                    $output->writeln(__('Cannot insert row %1 - Info: %2', $n, $e->getMessage()));
                    $this->logger->info(__('Cannot insert row %1 - Info: %2', $n, $e->getMessage()));
                }
            }

        } else {
            $output->writeln(__('Could not found input file.'));
        }

        $this->logger->info(__('Imported %1 producer record successfully.', $i));
        $this->logger->info('---End importing producer session---');
        return $i;
    }

    /**
     * Move producer image to media
     *
     * @param string $imageName
     * @param int $producerId
     * @return false|string
     */
    private function moveProducerImage(string $imageName, int $producerId): false|string
    {
        try {
            $mediaFile = false;
            $absImgFolder = $this->filesystem
                    ->getDirectoryRead(DirectoryList::VAR_DIR)
                    ->getAbsolutePath(). self::PRODUCER_IMAGE_FOLDER.'/';

            $absDestinaionFolder = $this->filesystem
                    ->getDirectoryRead(DirectoryList::MEDIA)
                    ->getAbsolutePath(). ImageUploader::BASE_PRODUCER_IMAGE_PATH . '/';

            $originalFile = $absImgFolder.$imageName;

            if ($this->fileDriver->isExists($originalFile)) {

                $extension = $this->ioFile->getPathInfo($originalFile)['extension'];
                if (in_array($extension, ImageUploader::ALLOWED_EXTENSIONS)) {
                    $moved = $this->fileDriver->rename($originalFile, $absDestinaionFolder. 'p'.$producerId.$imageName);
                    if ($moved) {
                        $producerPath = '/media/'.ImageUploader::BASE_PRODUCER_IMAGE_PATH.'/';
                        $mediaFile =  $producerPath . 'p'.($producerId++).$imageName;
                    }
                }
            }
        } catch (\Exception $e) {
            return false;
        }
        return $mediaFile;
    }
}
