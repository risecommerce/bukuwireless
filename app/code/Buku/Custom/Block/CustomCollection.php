<?php
namespace Buku\Custom\Block;
class CustomCollection extends \Magento\Framework\View\Element\Template
{    
    protected $productCollection;
        
	public function __construct(
	  \Magento\Framework\View\Element\Template\Context $context,
	  \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
	  array $data = []
	) {
	  $this->_productCollection = $productCollection;
	  parent::__construct($context);
	}    
	
	public function getProductCollection($field, $value)
	{
	    $collection = $this->_productCollection;
	    $collection->addFilter($field, $value);
	    return $collection;
	}
}
?>