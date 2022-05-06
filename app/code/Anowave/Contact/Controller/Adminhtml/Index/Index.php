<?php
/**
 * Anowave Magento 2 Contact Form
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Anowave license that is
 * available through the world-wide-web at this URL:
 * http://www.anowave.com/license-agreement/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category 	Anowave
 * @package 	Anowave_Contact
 * @copyright 	Copyright (c) 2016 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */
 
namespace Anowave\Contact\Controller\Adminhtml\Index;

class Index extends \Anowave\Contact\Controller\Adminhtml\Index
{
    public function execute()
    {
	    $this->_view->loadLayout();
	    
        $this->_setActiveMenu('Anowave_Contact::anowave')->_addBreadcrumb(__('Contact Forms'),__('Contact Forms'))->_addBreadcrumb
        (
            __('Manage Contact Forms'),
            __('Manage Contact Form')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Contact Forms'));
        $this->_view->renderLayout();
    }
}