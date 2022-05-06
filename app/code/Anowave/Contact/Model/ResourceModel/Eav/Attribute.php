<?php
namespace Anowave\Contact\Model\ResourceModel\Eav;

class Attribute extends \Magento\Catalog\Model\ResourceModel\Eav\Attribute
{
	/**
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Anowave\Contact\Model\ResourceModel\Attribute');
	}
}
