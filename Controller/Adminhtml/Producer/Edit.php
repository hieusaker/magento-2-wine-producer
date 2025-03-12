<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Controller\Adminhtml\Producer;

use Hieunv\WineProducer\Model\Producer;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Hieunv\WineProducer\Controller\Adminhtml\Producer
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('producer_id');
        $model = $this->_objectManager->create(Producer::class);

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Producer no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('hieunv_wine_producer', $model);

        // 3. Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Producer') : __('New Producer'),
            $id ? __('Edit Producer') : __('New Producer')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Producers'));
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId() ? __('Edit Producer %1', $model->getId()) : __('New Producer')
        );
        return $resultPage;
    }
}
