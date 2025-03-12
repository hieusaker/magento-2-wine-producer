<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Api\Data;

interface ProducerSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Producer list.
     *
     * @return \Hieunv\WineProducer\Api\Data\ProducerInterface[]
     */
    public function getItems();

    /**
     * Set enable list.
     *
     * @param \Hieunv\WineProducer\Api\Data\ProducerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
