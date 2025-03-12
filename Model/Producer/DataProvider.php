<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Model\Producer;

use Hieunv\WineProducer\Model\ImageUploader;
use Hieunv\WineProducer\Model\ResourceModel\Producer\Collection;
use Hieunv\WineProducer\Model\ResourceModel\Producer\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{

    /**
     * @var array
     */
    protected array $loadedData;

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {

            if ($model->getData('image')) {
                $image = $model->getData('image');
                $model->setData('producer_image', [
                    [
                        'name' => str_replace('/media/'. ImageUploader::BASE_PRODUCER_IMAGE_PATH.'/', '', $image),
                        'url' => $image,
                        'type' => 'image',
                    ]
                ]);
            }
            $this->loadedData[$model->getId()] = $model->getData();
        }
        $data = $this->dataPersistor->get('hieunv_wine_producer');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('hieunv_wine_producer');
        }

        return $this->loadedData;
    }
}
