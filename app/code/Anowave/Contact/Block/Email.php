<?php
/**
 * Anowave Magento 2 Custom Stock Status
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
 * @package 	Anowave_Status
 * @copyright 	Copyright (c) 2016 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */

namespace Anowave\Contact\Block;

use Magento\Backend\Block\Template;

class Email extends \Magento\Backend\Block\Template
{
	/**
	 * @var \Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory
	 */
	protected $eav;
	
	/**
	 * @var \Anowave\Contact\Model\FormFactory
	 */
	protected $factory;
	
	/**
	 * @var \Anowave\Contact\Model\ResourceModel\Field\CollectionFactory
	 */
	protected $factoryCollection;
	
	/**
	 * @var \Magento\Framework\Data\Form\Element\Factory
	 */
	protected $elementFactory;
	
	/**
	 * @var \Magento\Framework\Data\FormFactory
	 */
	protected $formFactory;
	
	/**
	 * @var \Magento\Catalog\Model\ProductFactory
	 */
	protected $productFactory;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Backend\Block\Template\Context $context
	 * @param \Anowave\Contact\Model\FormFactory $factory
	 * @param \Anowave\Contact\Model\ResourceModel\Field\CollectionFactory $factoryCollection
	 * @param \Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory $eav
	 * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
	 * @param \Magento\Framework\Data\FormFactory $formFactory
	 * @param \Magento\Catalog\Model\ProductFactory $productFactory
	 * @param array $data
	 */
	public function __construct
	(
		\Magento\Backend\Block\Template\Context $context,
		\Anowave\Contact\Model\FormFactory $factory,
		\Anowave\Contact\Model\ResourceModel\Field\CollectionFactory $factoryCollection,
		\Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory $eav,
		\Magento\Framework\Data\Form\Element\Factory $elementFactory,
		\Magento\Framework\Data\FormFactory $formFactory,
		\Magento\Catalog\Model\ProductFactory $productFactory,
		array $data = [])
	{
		parent::__construct($context, $data);
		
		$this->eav 					= $eav;
		$this->factory 				= $factory;
		$this->factoryCollection 	= $factoryCollection;
		$this->elementFactory 		= $elementFactory;
		$this->formFactory			= $formFactory;
		$this->productFactory		= $productFactory;
	}
	
	/**
	 * Set template 
	 * 
	 * @see \Magento\Framework\View\Element\Template::_construct()
	 */
	public function _construct()
	{
		$this->setTemplate('email.phtml');
	}
	
	public function getFormFields()
	{
		$fields = [];
		
		foreach ($this->factoryCollection->create()->addForm($this->getFormId()) as $field)
		{
			$fields[] = $this->eav->create()->load
			(
				$field->getFieldFormAttributeId()
			);
		}

		return $fields;
	}
	
	/**
	 * Transform data into readable message
	 * 
	 * @return array
	 */
	public function getMessage()
	{
		$message = array();
		
		$data = $_POST;
		
		$f = function(\Anowave\Contact\Model\ResourceModel\Eav\Attribute $field) use ($data)
		{
			$label = $field->getFrontendLabel();
			$value = $data[$field->getAttributeCode()];
			
			switch ($field->getFrontendInput())
			{
				case 'text':
				case 'textarea':
					if ('' === $value)
					{
						return array();
					}
					
					return (object) array
					(
						'label' => $label,
						'value' => nl2br($value)
					);
					break;
				case 'multiselect':
					
					$options = array();
					
					foreach ($field->getOptions() as $option)
					{
						if (in_array($option['value'], $value))
						{
							$options[] = $option['label'];
						}
					}
						
					return (object) array
					(
						'label' => $label,
						'value' => join('<br />', $options)
					);
					
					break;
				case 'select':
					
					foreach ($field->getOptions() as $option)
					{
						if ($option['value'] == $value)
						{
							return (object) array
							(
								'label' => $label,
								'value' => $option['label']
							);
						}
					}
					
					return (object) array
					(
						'label' => $label,
						'value' => $value
					);
					
					break;
				default:
					return (object) array
					(
						'label' => $label,
						'value' => $value
					);
					break;
			}
		};
		

		/**
		 * Check for enquiry product.
		 */
		try
		{
			if (isset($_POST['form_product_id']))
			{
				/**
				 * Create product model
				 */
				$product = $this->productFactory->create()->load((int) $_POST['form_product_id']);
		
				if ($product->getId())
				{
					$message[] = (object) array
					(
						'label' => __('Enquiry for product'),
						'value'	=> $product->getName()
					);
				}
			}
		}
		catch (\Exception $e)
		{
		
		}
		
		foreach ($this->getFormFields() as $field) 
		{
			$message[] = $f($field);
		}

		$message = array_filter($message);

		
		return $message;
	}
}