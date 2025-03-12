<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Model\ResourceModel\Producer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'producer_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Hieunv\WineProducer\Model\Producer::class,
            \Hieunv\WineProducer\Model\ResourceModel\Producer::class
        );
    }
}
