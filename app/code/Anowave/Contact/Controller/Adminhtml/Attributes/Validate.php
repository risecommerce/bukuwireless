<?php
namespace Anowave\Contact\Controller\Adminhtml\Attributes;

class Validate extends \Magento\Catalog\Controller\Adminhtml\Product\Attribute\Validate
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
	
	/**
	 * @return \Magento\Framework\Controller\ResultInterface
	 */
	public function execute()
	{
		$response = new \Magento\Framework\DataObject();
		
		$response->setError(false);
	
		$attributeCode = $this->getRequest()->getParam('attribute_code');
		$frontendLabel = $this->getRequest()->getParam('frontend_label');
		$attributeCode = $attributeCode ?: $this->generateCode($frontendLabel[0]);
		$attributeId = $this->getRequest()->getParam('attribute_id');
		$attribute = $this->_objectManager->create('Anowave\Contact\Model\ResourceModel\Eav\Attribute')->loadByCode($this->_entityTypeId,$attributeCode);
	
		if ($attribute->getId() && !$attributeId) 
		{
			if (strlen($this->getRequest()->getParam('attribute_code'))) 
			{
				$response->setMessage
				(
					__('An attribute with this code already exists.')
				);
			} 
			else 
			{
				$response->setMessage
				(
					__('An attribute with the same code (%1) already exists.', $attributeCode)
				);
			}
			$response->setError(true);
		}
		
		if ($this->getRequest()->has('new_attribute_set_name')) 
		{
			$setName = $this->getRequest()->getParam('new_attribute_set_name');
			
			/** @var $attributeSet \Magento\Eav\Model\Entity\Attribute\Set */
			$attributeSet = $this->_objectManager->create('Magento\Eav\Model\Entity\Attribute\Set');
			$attributeSet->setEntityTypeId($this->_entityTypeId)->load($setName, 'attribute_set_name');
			
			if ($attributeSet->getId()) 
			{
				$setName = $this->_objectManager->get('Magento\Framework\Escaper')->escapeHtml($setName);
				
				$this->messageManager->addError(__('An attribute set named \'%1\' already exists.', $setName));
	
				$layout = $this->layoutFactory->create();
				$layout->initMessages();
				$response->setError(true);
				$response->setHtmlMessage($layout->getMessagesBlock()->getGroupedHtml());
			}
		}
		return $this->resultJsonFactory->create()->setJsonData($response->toJson());
	}
}
