<?php

namespace Hieunv\WineProducer\Setup;

use Hieunv\WineProducer\Setup\Patch\Data\AddProducerProductAttribute;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface as UninstallInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class Uninstall implements UninstallInterface
{

    /**
     * @var AddProducerProductAttribute
     */
    private AddProducerProductAttribute $producerProductAttributePatch;

    /**
     * @param AddProducerProductAttribute $producerProductAttributePatch
     */
    public function __construct(
        AddProducerProductAttribute $producerProductAttributePatch
    ) {
        $this->producerProductAttributePatch = new AddProducerProductAttribute();
    }

    /**
     * Uninstall product attribute
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $this->producerProductAttributePatch->revert();
    }
}
