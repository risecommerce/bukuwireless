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

class Save extends \Anowave\Contact\Controller\Adminhtml\Index
{
    public function execute()
    {
    	$data = $this->getRequest()->getPost();
    	
        if ($data) 
        {
            $model = $this->formFactory->create();
            
            $id = $this->getRequest()->getParam('form_id');
            
            if ($id) 
            {
                $model->load($id);
            }
            
            $model->addData($data->toArray());

            try 
            {
                $model->save();
                
                if ($model->getId())
                {
                	/**
                	 * Delete previous attributes  
                	 */ 
                	
                	foreach ($this->fieldCollectionFactory->create()->addForm($model->getId()) as $entity)
                	{
                		$entity->delete();
                	}
                	
                	foreach ((array) @$data->field_form_attribute_id as $entity)
                	{
                		$a = $this->fieldFactory->create();
                			
                		$a->setFieldFormId($model->getId());
                		$a->setFieldFormAttributeId($entity);
                			
                		$a->save();
                	}
                }
                
                $this->messageManager->addSuccess(__('The Contact Form has been saved.'));
                
                $this->_getSession()->setFormData(false);
                
                if ($this->getRequest()->getParam('back')) 
                {
                    $this->_redirect('*/*/edit', ['form_id' => $model->getId(), '_current' => true]);
                    
                    return;
                }
                
                $this->_redirect('*/*/');
                
                return;
            } 
            catch (\Magento\Framework\Model\Exception $e) 
            {
                $this->messageManager->addError($e->getMessage());
            } 
            catch (\RuntimeException $e) 
            {
                $this->messageManager->addError($e->getMessage());
            } 
            catch (\Exception $e) 
            {
                $this->messageManager->addException($e, __('Something went wrong while saving the contact form.'));
            }
            
            $this->_getSession()->setFormData($data);
            
            $this->_redirect('*/*/edit', ['form' => $this->getRequest()->getParam('form_id')]);
            
            return;
        }
        $this->_redirect('*/*/');
    }
	    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
    	return $this->_authorization->isAllowed('Anowave_Contact::save');
    }
}