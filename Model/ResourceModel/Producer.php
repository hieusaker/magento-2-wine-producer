<?php
declare(strict_types=1);

namespace Hieunv\WineProducer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Producer extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('hieunv_wine_producer', 'producer_id');
    }
}
