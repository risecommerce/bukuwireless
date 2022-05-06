<?php
namespace Anowave\Contact\Block\Adminhtml\Product\Attribute\Edit\Tab;

use Magento\Backend\Block\Widget\Form;
use Magento\Framework\Data\FormFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Eav\Block\Adminhtml\Attribute\PropertyLocker;
use Magento\Framework\Registry;

class Front extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Edit\Tab\Front
{
	protected $propertyLockerLocal = null;
	
	/**
	 * Constructor 
	 * 
	 * @param Context $context
	 * @param Registry $registry
	 * @param FormFactory $formFactory
	 * @param Yesno $yesNo
	 * @param PropertyLocker $propertyLocker
	 * @param array $data
	 */
	public function __construct
	(
		Context $context,
		Registry $registry,
		FormFactory $formFactory,
		Yesno $yesNo,
		PropertyLocker $propertyLocker,
		array $data = []
	) 
	{
		parent::__construct($context, $registry, $formFactory, $yesNo, $propertyLocker);
		
		$this->propertyLockerLocal = $propertyLocker;
	}
	
	protected function _prepareForm()
	{
		/** @var Attribute $attributeObject */
		$attributeObject = $this->_coreRegistry->registry('entity_attribute');
	
		/** @var \Magento\Framework\Data\Form $form */
		$form = $this->_formFactory->create
		(
			['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
		);
	
		$fieldset = $form->addFieldset
		(
			'front_fieldset',['legend' => __('Storefront Properties'), 'collapsable' => $this->getRequest()->has('popup')]
		);
	
		$this->_eventManager->dispatch('form_attribute_form_build_front_tab', ['form' => $form]);
	
		$this->_eventManager->dispatch
		(
			'adminhtml_catalog_form_attribute_edit_frontend_prepare_form',['form' => $form, 'attribute' => $attributeObject]
		);
		
		// define field dependencies
		$this->setChild
		(
            'form_after',
            $this->getLayout()->createBlock
			(
                'Magento\Backend\Block\Widget\Form\Element\Dependence'
            )->addFieldMap
			(
                "frontend_input",
                'frontend_input_type'
            )->addFieldMap
			(
                "is_searchable",
                'searchable'
            )
        );
		
		$this->setForm($form);
		$form->setValues($attributeObject->getData());
		$this->propertyLockerLocal->lock($form);
		
		return $this;
	}
}