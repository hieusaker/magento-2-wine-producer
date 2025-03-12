<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Controller\Adminhtml\Producer;

use Hieunv\WineProducer\Model\Producer;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Hieunv\WineProducer\Model\ImageUploader;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('producer_id');

            $model = $this->_objectManager->create(Producer::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Producer no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            if (!empty($data['producer_image'])) {
                $producerImage = $data['producer_image'][0];
                $imagePath = '/media/'. ImageUploader::BASE_PRODUCER_IMAGE_PATH .'/'.  $producerImage['name'];
                $data['image'] = $imagePath;
            }
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Producer.'));
                $this->dataPersistor->clear('hieunv_wine_producer');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['producer_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Producer.'));
            }

            $this->dataPersistor->set('hieunv_wine_producer', $data);
            return $resultRedirect->setPath(
                '*/*/edit',
                ['producer_id' => $this->getRequest()->getParam('producer_id')]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }
}
