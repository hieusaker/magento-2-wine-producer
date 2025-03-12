<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Model\Product\Attribute\Source;

use Hieunv\WineProducer\Model\ResourceModel\Producer\CollectionFactory;

class Producer extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions(): array
    {
        $producerCollection = $this->collectionFactory->create();
        $producerCollection->addFieldToFilter('enable', 1);
        $options = $producerCollection->load()->toOptionArray();
        return $options;
    }
}
