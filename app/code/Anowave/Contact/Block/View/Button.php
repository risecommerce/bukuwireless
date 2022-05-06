<?php
namespace Anowave\Contact\Block\View;

class Button extends \Magento\Backend\Block\Template
{
	public function _construct()
	{
		parent::_construct();
		
		$this->setTemplate('button.phtml');
	}
}