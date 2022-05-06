<?php
/**
 * Anowave Magento 2 Contact Form
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
 
namespace Anowave\Contact\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class Product implements ObserverInterface
{
	/**
	 * Request
	 */
	protected $request = null;
	
	/**
	 * @var\Anowave\Contact\Model\FormFactory 
	 */
	protected $factory = null;
	
	public function __construct
	(
		\Magento\Framework\View\Element\Context $context,
		\Anowave\Contact\Model\EnquiryFactory $factory,
		array $data = []
	) 
	{
		$this->request 	= $context->getRequest();
		$this->factory	= $factory;
	}
	
	public function execute(EventObserver $observer)
	{
		$enquiry_form_id = (int) $this->request->getParam('enquiry_form_id');
		
		if (true)
		{
			/**
			 * Delete existing data
			 */
			$collection = $this->factory->create()->getCollection()->addFieldToFilter('enquiry_product_id', $observer->getProduct()->getId());
			
			foreach ($collection as $entity)
			{
				$entity->delete();
			}
			
			/**
			 * Delete previous data 
			 * 
			 * @var string
			 */
			$enquiry = $this->factory->create();
			
			$enquiry->setEnquiryProductId($observer->getProduct()->getId());
			$enquiry->setEnquiryFormId($enquiry_form_id);
			
			$enquiry->save();
		}
		
		return true;
	}
}