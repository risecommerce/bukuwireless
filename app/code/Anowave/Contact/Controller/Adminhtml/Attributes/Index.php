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
 
namespace Anowave\Contact\Controller\Adminhtml\Attributes;


class Index extends \Magento\Catalog\Controller\Adminhtml\Product\Attribute
{
	protected $entity = null;
	
	/**
	 * Constructor
	 *
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Magento\Framework\Cache\FrontendInterface $attributeLabelCache
	 * @param \Magento\Framework\Registry $coreRegistry
	 * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
	 */
	public function __construct
	(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\Cache\FrontendInterface $attributeLabelCache,
		\Magento\Framework\Registry $coreRegistry,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Anowave\Contact\Model\EntityFactory $entity
	) 
	{
		parent::__construct($context, $attributeLabelCache, $coreRegistry, $resultPageFactory);
		
		$this->entity = $entity;
	}
	
    public function execute()
    {	
    	/**
    	 * Create action page
    	 */
    	$resultPage = $this->createActionPage();
    	
    	/**
    	 * Update title
    	 */
    	$resultPage->getConfig()->getTitle()->prepend(__('Form Attributes'));
    	
    	/**
    	 * Add Content
    	 */
        $resultPage->addContent
        (
            $resultPage->getLayout()->createBlock('Anowave\Contact\Block\Adminhtml\Product\Attribute')
        );
        
        return $resultPage;
    }
}