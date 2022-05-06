<?php

namespace Buku\Custom\Model\Product\Type;

class Buyback extends \Magento\Catalog\Model\Product\Type\AbstractType
{
    const TYPE_ID = 'buyback';

    /**
     * {@inheritdoc}
     */
    public function deleteTypeSpecificData(\Magento\Catalog\Model\Product $product)
    {
        // method intentionally empty
    }
}