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
 
namespace Anowave\Contact\Model;

class Entity extends \Magento\Framework\Model\AbstractModel
{
	const ENTITY = 'form';
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\Model\Context $context
	 * @param \Magento\Framework\Registry $registry
	 * @param \Anowave\Contact\Model\ResourceModel\Entity $resource
	 * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
	 * @param array $data
	 */
	public function __construct
	(
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $registry,
		\Anowave\Contact\Model\ResourceModel\Entity $resource,
		\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
		array $data = []
	)
	{
		parent::__construct($context, $registry, $resource, $resourceCollection);
	}
	
	/**
	 * Initialize customer model
	 *
	 * @return void
	 */
	public function _construct()
	{
		$this->_init('Anowave\Contact\Model\ResourceModel\Entity');
	}
	
	/**
	 * Validate
	 */
	public function validate()
	{
		return [];
	}
}
