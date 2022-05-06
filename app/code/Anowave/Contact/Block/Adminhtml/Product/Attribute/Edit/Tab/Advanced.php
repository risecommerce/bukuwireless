<?php
namespace Anowave\Contact\Block\Adminhtml\Product\Attribute\Edit\Tab;

class Advanced extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Edit\Tab\Advanced
{
	protected function _prepareForm()
	{
		parent::_prepareForm();
		
		/**
		 * Advanced fieldset 
		 */
		$fieldset = $this->getForm()->getElement('advanced_fieldset');
		
		$fieldset->removeField('is_used_in_grid');
		$fieldset->removeField('is_visible_in_grid');
		$fieldset->removeField('is_filterable_in_grid');
		
		return $this;
	}
}