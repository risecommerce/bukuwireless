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
 
namespace Anowave\Contact\Block\Adminhtml\Tab;

class Enquiry extends \Magento\Backend\Block\Template
{
	public function toHtml()
	{
		return $this->getLayout()->createBlock('Anowave\Contact\Block\Enquiry')->toHtml();
	}
}