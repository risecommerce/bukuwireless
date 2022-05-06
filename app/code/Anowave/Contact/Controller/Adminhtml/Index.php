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
 
namespace Anowave\Contact\Controller\Adminhtml;

abstract class Index extends \Magento\Backend\App\Action
{
	/**
	 * @var \Anowave\Contact\Model\FormFactory
	 */
	protected $formFactory = null;
	
	/**
	 * @var \Anowave\Contact\Model\FieldFactory
	 */
	protected $fieldFactory = null;
	
	/**
	 * @var \Anowave\Contact\Model\ResourceModel\Field\CollectionFactory
	 */
	protected $fieldCollectionFactory = null;
	
    public function __construct
    (
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
    	\Anowave\Contact\Model\FormFactory $formFactory,
    	\Anowave\Contact\Model\FieldFactory $fieldFactory,
    	\Anowave\Contact\Model\ResourceModel\Field\CollectionFactory $fieldCollectionFactory
    ) 
    {
    	$this->_coreRegistry 			= $coreRegistry;
        $this->resultLayoutFactory 		= $resultLayoutFactory;
        $this->formFactory				= $formFactory;
        $this->fieldFactory				= $fieldFactory;
        $this->fieldCollectionFactory 	= $fieldCollectionFactory;

        parent::__construct($context);
    }

    /**
     * Add errors messages to session.
     *
     * @param array|string $messages
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function _addSessionErrorMessages($messages)
    {
        $messages = (array) $messages;
        
        $session = $this->_getSession();

        $callback = function ($error) use ($session) 
        {
            if (!$error instanceof Error) 
            {
                $error = new Error($error);
            }
            
            $this->messageManager->addMessage($error);
        };
        
        array_walk_recursive($messages, $callback);
    }

    /**
     * Form access rights checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Anowave_Contact::anowave');
    }
}
