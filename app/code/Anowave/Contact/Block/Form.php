<?php
namespace Anowave\Contact\Block;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Element\Template\Context;


class Form extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller 		= 'form';
        $this->_blockGroup 		= 'Anowave_Contact';
        $this->_headerText 		= __('Contact Forms');
        $this->_addButtonLabel 	= __('Add Contact Form');
        
        parent::_construct();
    }
    
    /**
     * @return string
     */
    public function getCreateUrl()
    {
    	return $this->getUrl('*/*/add');
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}