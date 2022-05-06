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


namespace Anowave\Contact\Helper;

use Magento\Store\Model\Store;
use Anowave\Package\Helper\Base;
use Anowave\Package\Helper\Package;
use Magento\Framework\Registry;

class Data extends Package
{
	/**
	 * Package name
	 * 
	 * @var string
	 */
	protected $package = 'MAGE2-CF';
	
	/**
	 * Config path 
	 * 
	 * @var string
	 */
	protected $config = 'cf/general/license';
	
	/**
	 * Check if module is active
	 * 
	 * @return boolean
	 */
	public function isActive()
	{
		return 1 === (int) $this->getConfig('cf/general/active');
	}
}
