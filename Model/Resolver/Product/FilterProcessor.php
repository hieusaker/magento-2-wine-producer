<?php
namespace Hieunv\WineProducer\Model\Resolver\Product;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;

class FilterProcessor implements CustomFilterInterface
{
    /**
     * Apply custom_attribute filter to product collection
     *
     * @param FilterProcessor $filter
     * @param Collection $collection
     * @return bool
     */
    public function apply(Filter $filter, $collection)
    {
        // @Todo: handle case attribute text
        $collection->addAttributeToFilter('producer', $filter->getValue());
        return true;
    }
}
