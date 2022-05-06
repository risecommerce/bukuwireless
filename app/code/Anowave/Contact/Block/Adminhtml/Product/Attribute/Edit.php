<?php
namespace Anowave\Contact\Block\Adminhtml\Product\Attribute;

class Edit extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Edit
{
	/**
	 * Block group name
	 *
	 * @var string
	 */
	protected $_blockGroup = 'Anowave_Contact';
	
	protected function _construct()
	{
		$this->_objectId = 'attribute_id';
		$this->_controller = 'adminhtml_forms_attributes';
	
		parent::_construct();
	
		if ($this->getRequest()->getParam('popup')) 
		{
			$this->buttonList->remove('back');
			
			if ($this->getRequest()->getParam('product_tab') != 'variations') 
			{
				$this->addButton
				(
					'save_in_new_set',
					[
						'label' => __('Save in New Attribute Set'),
						'class' => 'save',
						'onclick' => 'saveAttributeInNewSet(\'' . __('Enter Name for New Attribute Set') . '\')'
					],
					100
				);
			}
		} 
		else 
		{
			$this->addButton
			(
				'save_and_edit_button',
				[
					'label' => __('Save and Continue Edit'),
					'class' => 'save',
					'data_attribute' => [
						'mage-init' => [
							'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
						],
					]
				]
			);
		}
	
		$this->buttonList->update('save', 'label', __('Save Attribute'));
		$this->buttonList->update('save', 'class', 'save primary');
		$this->buttonList->update
		(
			'save',
			'data_attribute',
			[
				'mage-init' => 
				[
					'button' => 
					[
						'event' => 'save', 
						'target' => '#edit_form'
					]
				]
			]
		);
	
		$entityAttribute = $this->_coreRegistry->registry('entity_attribute');

		if (!$entityAttribute || !$entityAttribute->getIsUserDefined()) 
		{
			$this->buttonList->remove('delete');
		} 
		else 
		{
			$this->buttonList->update('delete', 'label', __('Delete Attribute'));
		}
	}

	/**
	 * Retrieve header text
	 *
	 * @return \Magento\Framework\Phrase
	 */
	public function getHeaderText()
	{
		if ($this->_coreRegistry->registry('entity_attribute')->getId()) 
		{
			$frontendLabel = $this->_coreRegistry->registry('entity_attribute')->getFrontendLabel();
			
			if (is_array($frontendLabel)) 
			{
				$frontendLabel = $frontendLabel[0];
			}
			return __('Edit Form Attribute "%1"', $this->escapeHtml($frontendLabel));
		}
		
		return __('New Form Attribute');
	}
	
	/**
	 * Retrieve URL for validation
	 *
	 * @return string
	 */
	public function getValidationUrl()
	{
		return $this->getUrl('forms/attributes/validate', ['_current' => true]);
	}
	
	/**
	 * Retrieve URL for save
	 *
	 * @return string
	 */
	public function getSaveUrl()
	{
		return $this->getUrl
		(
			'forms/attributes/save', ['_current' => true, 'back' => null, 'product_tab' => $this->getRequest()->getParam('product_tab')]
		);
	}
}