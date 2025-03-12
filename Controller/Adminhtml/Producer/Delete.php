<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Controller\Adminhtml\Producer;

class Delete extends \Hieunv\WineProducer\Controller\Adminhtml\Producer
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('producer_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Hieunv\WineProducer\Model\Producer::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Producer.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['producer_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Producer to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
