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
 * @package 	Anowave_Status
 * @copyright 	Copyright (c) 2016 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */
 
namespace Anowave\Contact\Model\Config\Source;

class Form implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * @var \Magento\Cms\Model\Resource\Page\Grid\CollectionFactory
	 */
	protected $_collectionFactory;
	 
	/**
	 * Constructor 
	 * 
	 * @param \Anowave\Contact\Model\ResourceModel\Form\CollectionFactory $collectionFactory
	 * @param array $data
	 */
	public function __construct
	(
		\Anowave\Contact\Model\ResourceModel\Form\CollectionFactory $collectionFactory,
		array $data = []
	)
	{
		$this->_collectionFactory = $collectionFactory;
	}
	
	/**
	 * Get available forms 
	 * 
	 * @see \Magento\Framework\Data\OptionSourceInterface::toOptionArray()
	 */
    public function toOptionArray()
    {
    	$forms = [];
    	
    	$collection = $this->_collectionFactory->create();
    	
    	foreach ($collection as $form)
    	{
    		$forms[] = 
    		[
    			'value' => $form->getFormId(),
    			'label' => $form->getFormName()
    		];
    	}
    	
    	return $forms;
    }
}