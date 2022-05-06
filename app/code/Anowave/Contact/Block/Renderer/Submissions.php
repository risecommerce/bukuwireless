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
 
namespace Anowave\Contact\Block\Renderer;

use Magento\Framework\Data\Form;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Escaper;

class Submissions extends \Magento\Framework\Data\Form\Element\AbstractElement
{
	/**
	 * @var \Anowave\Contact\Model\ResourceModel\Field\CollectionFactory
	 */
	protected $factory = null;
	
	/**
	 * @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory
	 */
	protected $factoryAttributes = null;
	
	/**
	 * @var \Anowave\Contact\Model\ResourceModel\Field\CollectionFactory
	 */
	protected $fieldCollectionFactory = null;
	
	/**
	 * @var \Magento\Framework\App\RequestInterface
	 */
	protected $request = null;
	
	/**
	 * @var \Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory
	 */
	protected $eav;
	
	/**
	 * 
	 * @var \Anowave\Contact\Model\EntityFactory
	 */
	protected $entityFactory = null;
	
	/** 
	 * @var \Anowave\Contact\Model\FormFactory
	 */
	protected $formFactory = null;
	
	/**
	 * @param Factory $factoryElement
	 * @param CollectionFactory $factoryCollection
	 * @param Escaper $escaper
	 * @param array $data
	 */
	public function __construct
	(
		Factory $factoryElement,
		CollectionFactory $factoryCollection,
		Escaper $escaper,
		\Anowave\Contact\Model\ResourceModel\Field\CollectionFactory $factory,
		\Anowave\Contact\Model\ResourceModel\Attribute\CollectionFactory $factoryAttributes,
		\Anowave\Contact\Model\ResourceModel\Field\CollectionFactory $fieldCollectionFactory,
		\Magento\Framework\App\RequestInterface $request,
		\Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory $eav,
		\Anowave\Contact\Model\EntityFactory $entityFactory,
		\Anowave\Contact\Model\FormFactory $formFactory,
		$data = []
	) 
	{
		parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
		
		$this->factory 			 		= $factory;
		$this->factoryAttributes 		= $factoryAttributes;
		$this->fieldCollectionFactory 	= $fieldCollectionFactory;
		$this->request 					= $request;
		$this->eav 						= $eav;
		$this->entityFactory 			= $entityFactory;
		$this->formFactory 				= $formFactory;
	}
	
	public function getElementHtml()
	{
		$data = [];
		
		
		
		$form = $this->formFactory->create()->load($this->request->getParam('form_id'));
		
		
		
		if ($form->getId())
		{
			$fields = $this->getFormFields($form);
			
			$entities = $this->entityFactory->create()->getCollection()->addFieldToFilter('entity_form_id', $form->getId());
			
			foreach ($entities as $entity)
			{
				$submission = @$this->entityFactory->create()->load($entity->getEntityId());
				
				$data[] = $submission->getData();
			}
			
			/**
			 * Convert submissions to human readable format.
			 * 
			 * @var array
			 */
			$data = array_map(function($entity) use ($fields)
			{
				$submission = [];
				
				foreach ($fields as $field)
				{
					if (isset($entity[$field->getAttributeCode()]))
					{
						$value = $entity[$field->getAttributeCode()];
						
						if ($field->usesSource())
						{
							$options = $field->getSource()->getAllOptions(true, true);
							
							foreach ($options as $option)
							{
								if ($option['value'] == $value)
								{
									$value = $option['label'];
									
									break;
								}
							}
						}
						
						$submission[$field->getAttributeCode()] = array
						(
							'field' => $field->getFrontendLabel(),
							'value' => $value
						);
					}
				}
				
				return $submission;
			}, $data);
		
		}
		
		return $this->getForm()->getLayout()->createBlock('Anowave\Contact\Block\Submissions')->setData(
		[
			'submissions' => $data
		])->toHtml();
	}
	
	public function getFormFields($form)
	{
		$fields = [];
	
		foreach ($this->factory->create()->addForm($form->getId()) as $field)
		{
			$fields[] = $this->eav->create()->load
			(
				$field->getFieldFormAttributeId()
			);
		}
	
		return $fields;
	}
}