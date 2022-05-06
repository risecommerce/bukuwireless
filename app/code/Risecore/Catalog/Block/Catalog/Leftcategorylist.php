<?php

namespace Risecore\Catalog\Block\Catalog;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Helper\Category;

class Leftcategorylist extends \Magento\Framework\View\Element\Template
{
    const CATEGOEY_ID = 2;
    
    public function __construct(
        Context $context,
        Registry $registry,
        CollectionFactory $categoryCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectmanager, 
        array $data = []
    ) {
        $this->registry = $registry;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->_objectManager = $objectmanager;
        parent::__construct($context, $data);
    }

    
    public function getCategoryListing() {
        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection->addAttributeToSelect('*');
        $categoryCollection->addIsActiveFilter();
        $categoryCollection->addAttributeToFilter('level', array('neq' => 1));
        return $categoryCollection;
    }

    public function getFirstLevelCategories()
    {
        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection->addAttributeToSelect('*');
        $categoryCollection->addIsActiveFilter();
        $categoryCollection->addAttributeToFilter('entity_id', array('eq' => self::CATEGOEY_ID));
        return $categoryCollection->getFirstItem();
    }

    public function getCurrentCategory()
    {        
        return $this->registry->registry('current_category');
    }

    public function getProduct()
    {
       $product = $this->registry->registry('current_product');
       return $product; 
    }


    public function getProductCategory() {   

        $product = $this->registry->registry('current_product'); 

        $_categoryFactory = $this->_objectManager->create('Magento\Catalog\Model\CategoryFactory');

        // for multiple categories, select only the first one
        // remember, index = 0 is 'Default' category
        if (!$product->getCategoryIds())
            return null;

        if (isset ( $product->getCategoryIds()[1]))
            $categoryId = $product->getCategoryIds()[1] ;
        else
            $categoryId = $product->getCategoryIds()[0] ;

        // Additionally for other types of attributes (select, multiselect, ..)
        $category = $_categoryFactory->create()->load($categoryId);

        return $category;
        
    }
}
