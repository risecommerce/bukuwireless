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

namespace Anowave\Contact\Block\Widget;

class Form extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
	public function _construct()
	{
		$this->setTemplate('widget.phtml');
	}
	
	/**
	 * Display form
	 * 
	 * @return string
	 */
	public function displayForm()
	{
		return $this->getLayout()->createBlock('Anowave\Contact\Block\View','form.view.widget',
		[
			'data' => 
			[
				'form_id' => $this->getForm()
			]
		])->toHtml();
	}
}