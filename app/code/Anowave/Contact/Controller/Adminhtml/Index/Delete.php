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

class Delete extends \Anowave\Contact\Controller\Adminhtml\Index
{
    /**
     * Init actions
     *
     * @return $this
     */
    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Anowave_Contact::anowave')->_addBreadcrumb(__('Contact Forms'),__('Contact Forms'));
        
        return $this;
    }
    /**
     * Edit CMS page
     *
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('form_id');

        if ($id) 
        {
        	$model = $this->formFactory->create()->load($id);
            $model->delete();
            
            $this->messageManager->addSuccess(__('Form was removed successfully.'));
            $this->_redirect('*/*/');
        }
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
    	return $this->_authorization->isAllowed('Anowave_Contact::save');
    }
}