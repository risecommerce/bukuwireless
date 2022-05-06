<?php
namespace Anowave\Contact\Block\Adminhtml\Product\Attribute\Edit\Tab;

class Main extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Edit\Tab\Main
{
	protected function _prepareForm()
	{
		parent::_prepareForm();
		
		$frontend = $this->getForm()->getElement('frontend_input');
		
		$values = [];

		foreach ($frontend->getValues() as $value)
		{
			if (in_array($value['value'], ['text','select','textarea','boolean','multiselect','radios','radio','checkbox','checkboxes']))
			{
				$values[] = $value;
			}
		}
		
		$frontend->setValues($values);
		
		return $this;
	}
}
