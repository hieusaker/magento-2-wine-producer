<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Block\Adminhtml\Producer\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
