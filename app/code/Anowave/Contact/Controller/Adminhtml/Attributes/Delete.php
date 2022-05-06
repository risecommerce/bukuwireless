<?php
namespace Anowave\Contact\Controller\Adminhtml\Attributes;

class Delete extends \Magento\Catalog\Controller\Adminhtml\Product\Attribute\Delete
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
	 * @return \Magento\Backend\Model\View\Result\Redirect
	 */
	public function execute()
	{
		$id = $this->getRequest()->getParam('attribute_id');
		
		$resultRedirect = $this->resultRedirectFactory->create();
		
		if ($id) 
		{
			$model = $this->_objectManager->create('Anowave\Contact\Model\ResourceModel\Eav\Attribute');
	
			// entity type check
			$model->load($id);
			
			if ($model->getEntityTypeId() != $this->_entityTypeId) 
			{
				$this->messageManager->addError(__('We can\'t delete the attribute.'));
				
				return $resultRedirect->setPath('forms/*/');
			}
	
			try 
			{
				$model->delete();
				$this->messageManager->addSuccess(__('You deleted the form attribute.'));
				return $resultRedirect->setPath('forms/*/');
			} 
			catch (\Exception $e) 
			{
				$this->messageManager->addError($e->getMessage());
				
				return $resultRedirect->setPath
				(
					'forms/*/edit',
					['attribute_id' => $this->getRequest()->getParam('attribute_id')]
				);
			}
		}
		
		$this->messageManager->addError(__('We can\'t find an attribute to delete.'));
		
		return $resultRedirect->setPath('forms/*/');
	}
}
