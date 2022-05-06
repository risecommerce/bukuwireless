<?php

namespace Buku\Custom\Block\Product\Type;

class ListProductTypes
{
	
	public function __construct(
	  \Magento\Framework\App\Helper\Context $context,
	  \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
	  array $data = []
	) {
	  $this->_productCollection = $productCollection;
	  parent::__construct($context);
	}	
	
	/**
	 * Get the product collection filtered by field
	 *
	 * @param $field
	 * @param $value
	 * @return $this
	 */
	public function getProductCollection($field, $value)
	{
	    $collection = $this->_productCollection;
	    $collection->addFilter($field, $value);
	    return $collection;
	}	
	
}