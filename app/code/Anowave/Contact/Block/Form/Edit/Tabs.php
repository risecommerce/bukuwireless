<?php
namespace Anowave\Contact\Block\Form\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
   
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle
        (
        	__('Form Options')
        );
    }
}