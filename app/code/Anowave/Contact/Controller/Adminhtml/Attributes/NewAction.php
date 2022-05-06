<?php
namespace Anowave\Contact\Controller\Adminhtml\Attributes;

class NewAction extends \Magento\Catalog\Controller\Adminhtml\Product\Attribute\NewAction
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
}
