<?php
namespace Hieunv\WineProducer\Model\Resolver\Product;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Catalog\Model\ProductFactory;

class Producer implements ResolverInterface
{
    /**
     * @var ProductFactory
     */
    protected ProductFactory $productFactory;

    /**
     * @param ProductFactory $productFactory
     */
    public function __construct(
        ProductFactory $productFactory
    ) {
        $this->productFactory = $productFactory;
    }

    // phpcs:disable
    /**
     * Producer attribute value resolver
     *
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return \Magento\Framework\GraphQl\Query\Resolver\Value|mixed|null
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($value['model'])) {
            return null;
        }
        $product = $value['model'];
        $product = $this->productFactory->create()->load($product->getId());
        // return $product->getAttributeText('producer');  // in the case need to return attribute text
        return $product->getData('producer');
    }
}
