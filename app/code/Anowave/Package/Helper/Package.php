<?php
/**
 * Anowave Magento 2 Package
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
 * @package 	Anowave_Package
 * @copyright 	Copyright (c) 2016 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */


namespace Anowave\Package\Helper;

use Magento\Store\Model\Store;
use Magento\Framework\App\Helper\AbstractHelper;

class Package extends Base
{
	public function getConfig($config)
	{
		return $this->_context->getScopeConfig()->getValue($config);
	}
}