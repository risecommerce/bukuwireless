<?php
namespace Anowave\Contact\Controller\Adminhtml\Attributes;

class Edit extends \Magento\Catalog\Controller\Adminhtml\Product\Attribute\Edit
{
	/**
	 * Dispatch request
	 *
	 * @param \Magento\Framework\App\RequestInterface $request
	 * @return \Magento\Framework\App\ResponseInterface
	 */
	public function dispatch(\Magento\Framework\App\RequestInterface $request)
	{
		$this->_entityTypeId = $this->_objectManager->create('Magento\Eav\Model\Entity')->setType('form')->getTypeId();
		
		return \Magento\Backend\App\Action::dispatch($request);
	}
	
	public function execute()
	{
		$id = $this->getRequest()->getParam('attribute_id');
		
		/** @var $model \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
		$model = $this->_objectManager->create('Anowave\Contact\Model\ResourceModel\Eav\Attribute')->setEntityTypeId($this->_entityTypeId);
		
		if ($id) 
		{
			$model->load($id);
			
			if (!$model->getId()) 
			{
				$this->messageManager->addError(__('This attribute no longer exists.'));
				$resultRedirect = $this->resultRedirectFactory->create();
				return $resultRedirect->setPath('forms/attributes/index');
			}
	
			// entity type check
			if ($model->getEntityTypeId() != $this->_entityTypeId) 
			{
				$this->messageManager->addError(__('This attribute cannot be edited.'));
				$resultRedirect = $this->resultRedirectFactory->create();
				
				return $resultRedirect->setPath('forms/attributes/index');
			}
		}
	
		// set entered data if was error when we do save
		$data = $this->_objectManager->get('Magento\Backend\Model\Session')->getAttributeData(true);
		
		if (!empty($data)) 
		{
			$model->addData($data);
		}
		$attributeData = $this->getRequest()->getParam('attribute');
		
		if (!empty($attributeData) && $id === null) 
		{
			$model->addData($attributeData);
		}
	
		$this->_coreRegistry->register('entity_attribute', $model);
	
		$item = $id ? __('Edit Form Attribute') : __('New Form Attribute');
	
		$resultPage = $this->createActionPage($item);
		$resultPage->getConfig()->getTitle()->prepend($id ? $model->getName() : __('New Form Attribute'));
		$resultPage->getLayout()->getBlock('attribute_edit_js')->setIsPopup((bool)$this->getRequest()->getParam('popup'));
		
		return $resultPage;
	}
}
