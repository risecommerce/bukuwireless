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

class Fields extends \Magento\Framework\Data\Form\Element\AbstractElement
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
	
	protected $request = null;
	
	protected $eav;
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
		$data = []
		
	) 
	{
		parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
		
		$this->factory 			 		= $factory;
		$this->factoryAttributes 		= $factoryAttributes;
		$this->fieldCollectionFactory 	= $fieldCollectionFactory;
		
		$this->request = $request;
		
		$this->eav = $eav;
	}
	
	public function getElementHtml()
	{
		/**
		 * Get all attributes 
		 * @var array
		 */
		$attributes = [];
		
		foreach ($this->factoryAttributes->create() as $attribute)
		{
			$attributes[$attribute->getId()] = $attribute->getFrontendLabel();
		}
		
		/**
		 * Get current fields
		 */
		$attributes_current = [];
		

		foreach (@$this->fieldCollectionFactory->create()->addForm($this->request->getParam('form_id')) as $field)
		{
			$attribute = $this->eav->create()->load
			(
				$field->getFieldFormAttributeId()
			);
			
			$attributes_current[$attribute->getAttributeId()] = $attribute->getFrontendLabel();
		}
		
		return $this->getForm()->getLayout()->createBlock('Anowave\Contact\Block\Fields')->setData(array
		(
			'attributes_current' 	=> $attributes_current,
			'attributes' 			=> $attributes
		))->toHtml();
	}
}