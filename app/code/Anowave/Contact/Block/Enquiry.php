<?php
/**
 * Anowave Magento 2 Contact Forms
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Anowave license that is
 * available through the world-wide-web at this URL:
 * http://www.anowave.com/license-agreement/
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category 	Anowave
 * @package 	Anowave_Contact
 * @copyright 	Copyright (c) 2016 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */

namespace Anowave\Contact\Block;

use Magento\Framework\Registry;
class Enquiry extends \Magento\Backend\Block\Widget\Form\Generic
{
	protected $locale = null;
	
	protected $factory = null;
	
    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
    	\Anowave\Contact\Model\FormFactory $factory,
        array $data = []
    ) 
    {  
        parent::__construct($context, $registry, $formFactory, $data);
        
        $this->locale 		= $context->getLocaleDate();
        $this->factory 		= $factory;
        
        $this->setProductId
        (
        	$this->getRequest()->getParam('id')
        );
    }

    /**
     * Prepare form for render
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', 
        [
        	'legend' => __('Select enquiry form')
        ]);
        
        $collection = $this->factory->create()->getCollection();
        
        $forms = array();
        
        $forms[] = array
        (
        	'value' => 0,
        	'label' => __('Do not use enquiry form')
        );
        
        foreach ($collection as $entity)
        {
        	$forms[] = array
        	(
        		'value' => $entity->getFormId(),
        		'label' => $entity->getFormName()
        	);
        }
        
        if ($this->getProductId())
        {
        	$value = (int) \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Catalog\Model\Product')->load($this->getProductId())->getData('enquiry_form_id');
        }
        else 
        {
        	$value = 0;
        }
        
        $fieldset->addField
        (
        	'enquiry_form_id', 'select',
        	[
        		'name' 		=> 'enquiry_form_id',
        		'label' 	=> __('Select form'),
        		'title' 	=> __('Select form'),
        		'note' 		=> __('Choose form from the list of contact forms'),
        		'values'	=> $forms,
        		'value'		=> $value,
        		'required' 	=> false
        	]
        );
     
        $form->setUseContainer(false);
        $form->setMethod('post');
        $this->setForm($form);
    }
}