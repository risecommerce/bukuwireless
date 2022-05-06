<?php
namespace Anowave\Contact\Block\Adminhtml\Product;

class Attribute extends \Magento\Catalog\Block\Adminhtml\Product\Attribute
{
    protected function _construct()
    {
        $this->_controller 		= 'adminhtml_product_attribute';
        $this->_blockGroup 		= 'Anowave_Contact';
        $this->_headerText 		= __('Form Attributes');
        $this->_addButtonLabel 	= __('Add New Attribute');
        
        \Magento\Backend\Block\Widget\Grid\Container::_construct();
    }
}