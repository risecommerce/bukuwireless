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

class Edit extends \Anowave\Contact\Controller\Adminhtml\Index
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
        
        $model = $this->_objectManager->create('Anowave\Contact\Model\Form');
        
        if ($id) 
        {
            $model->load($id);
            
            if (!$model->getId()) 
            {
                $this->messageManager->addError(__('This form no longer exists.'));
                $this->_redirect('*/*/');
                
                return;
            }
        }
        
        $data = $this->_getSession()->getFormData(true);
        
        if (!empty($data)) 
        {
            $model->setData($data);
        }

        $this->_coreRegistry->register('form', $model);


        $this->_initAction()->_addBreadcrumb
        (
            $id ? __('Edit Form') : __('New Form'),
            $id ? __('Edit Form') : __('New Form')
        );
        
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Form'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Form'));
        
        $this->_view->renderLayout();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
    	return $this->_authorization->isAllowed('Anowave_Contact::save');
    }
}