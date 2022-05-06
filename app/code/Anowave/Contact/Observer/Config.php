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

class Config implements ObserverInterface
{
	/**
	 * Helper
	 * 
	 * @var \Anowave\Contact\Helper\Data $helper
	 */
	protected $_helper = null;
	
	/**
	 * Message Manager 
	 * 
	 * @var \Magento\Framework\Message\ManagerInterface
	 */
	protected $_messageManager 	= null;

	/**
	 * Constrcutor 
	 * 
	 * @param \Anowave\Contact\Helper\Data $helper
	 * @param \Magento\Framework\Message\ManagerInterface $messageManager
	 */
	public function __construct
	(
		\Anowave\Contact\Helper\Data $helper, 
		\Magento\Framework\Message\ManagerInterface $messageManager
	)
	{
		$this->_helper 			= $helper;
		$this->_messageManager 	= $messageManager;
	}
	
	public function execute(EventObserver $observer)
	{
		$this->_helper->notify($this->_messageManager);
	}
}
