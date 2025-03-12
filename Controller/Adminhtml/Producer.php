<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

abstract class Producer extends \Magento\Backend\App\Action
{

    /**
     * @var Registry
     */
    protected Registry $_coreRegistry;
    public const ADMIN_RESOURCE = 'Hieunv_WineProducer::top_level';

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::ADMIN_RESOURCE)
            ->addBreadcrumb(__('Producer'), __('Producer'));
        return $resultPage;
    }
}
