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
 
namespace Anowave\Contact\Controller\Index;


class Index extends \Magento\Framework\App\Action\Action
{
	/**
	 * @var \Magento\Framework\Mail\Template\TransportBuilder
	 */
	protected $transport = null;
	
	/**
	 * @var \Magento\Framework\Controller\Result\JsonFactory
	 */
	protected $resultJsonFactory = null;
	
	/**
	 * @var \Magento\Store\Model\StoreManagerInterface
	 */
	protected $storeManager = null;
	
	/**
	 * @var \Magento\Framework\App\Config\ScopeConfigInterface
	 */
	protected $scopeConfig = null;
	
	/**
	 * @var \Anowave\Contact\Model\EntityFactory
	 */
	protected $entityFactory = null;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\App\Action\Context $context
	 * @param \Anowave\Contact\Model\FormFactory $factory
	 * @param \Anowave\Contact\Model\ResourceModel\Field\CollectionFactory $factoryCollection
	 * @param \Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory $eav
	 * @param \Magento\Framework\Data\Form\Element\Factory $elementFactory
	 * @param \Magento\Framework\Data\FormFactory $formFactory
	 * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
	 * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
	 * @param \Magento\Store\Model\StoreManagerInterface $storeManager
	 * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	 * @param \Anowave\Contact\Model\EntityFactory $entityFactory
	 * @param array $data
	 */
	public function __construct
	(
		\Magento\Framework\App\Action\Context $context,
		\Anowave\Contact\Model\FormFactory $factory,
		\Anowave\Contact\Model\ResourceModel\Field\CollectionFactory $factoryCollection,
		\Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory $eav,
		\Magento\Framework\Data\Form\Element\Factory $elementFactory,
		\Magento\Framework\Data\FormFactory $formFactory,
		\Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
		\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Anowave\Contact\Model\EntityFactory $entityFactory,
		array $data = []
	) 
	{
		parent::__construct($context, $data);
		
		$this->eav 					= $eav;
		$this->factory 				= $factory;
		$this->factoryCollection 	= $factoryCollection;
		$this->elementFactory 		= $elementFactory;
		$this->formFactory			= $formFactory;
		$this->resultFactory		= $resultJsonFactory;
		$this->transport			= $transportBuilder;
		$this->storeManager 		= $storeManager;
		$this->scopeConfig			= $scopeConfig;
		$this->entityFactory		= $entityFactory;
	}

	public function execute()
	{
		/**
		 * Create form 
		 * 
		 * @var unknown
		 */
		$form = $this->factory->create()->load($this->getRequest()->getParam('form_id'));

		/**
		 * Request 
		 */
		$request = $this->getRequest();
		
		if ($form)
		{
			$errors = array();
			
			/**
			 * Get form fields
			 * 
			 * @var arra
			 */
			$fields = $this->getFormFields($form);
			
			/**
			 * Validate fields
			 */
			$valid = function(\Anowave\Contact\Model\ResourceModel\Eav\Attribute $field) use ($request)
			{
				$value = $request->getParam
				(
					$field->getAttributeCode()
				);

				if ($field->getIsRequired())
				{
					switch ($field->getFrontendInput())
					{
						case 'text':
							if ('' === $value)
							{
								return $field->getFrontendLabel() . chr(32) . __('is invalid.');
							}
							break;
						case 'select':
							break;
					}
				}
				
				return false;
			};
			
			foreach ($fields as $field)
			{
				if (false !== $error = $valid($field))
				{
					$errors[] = $error;
				}
			}
			
			$errors = array_filter($errors);
			
			/**
			 * Create result 
			 * 
			 * @var \Magento\Framework\Controller\Result\JsonFactory
			 */
			$result = $this->resultFactory->create();
			
			/**
			 * Response array 
			 * 
			 * @var string
			 */
			$response = [];
			
			if (!count($fields))
			{
				$errors[] = (string) __('This form has no fields. Please define at least one field.');
			}
			
			
			if (!$errors)
			{
				/**
				 * Determine sender 
				 */
				
				$sender = $this->scopeConfig->getValue('trans_email/ident_general/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
				
				foreach ($fields as $field)
				{
					$value = $request->getParam($field->getAttributeCode());
					
					if (filter_var($value, FILTER_VALIDATE_EMAIL))
					{
						$sender = $value;
					}
				}

				/**
				 * Create entity
				 */
				try 
				{
					/**
					 * Create new form entity 
					 */
					$entity = $this->entityFactory->create();
					
					$entity->setStoreId($this->storeManager->getStore()->getId());
					$entity->setWebsiteId($this->storeManager->getStore()->getWebsiteId());
					
					$entity->setData('entity_form_id', $form->getId());
					
					foreach ($fields as $field)
					{
						$entity->setData($field->getAttributeCode(), $request->getParam($field->getAttributeCode()));
					}
					
					/**
					 * Save entity to database
					 */
					$entity->save();
					
					
				}
				catch (\Exception $e)
				{
					$errors[] = $e->getMessage();
				}
				
				/**
				 * Data object 
				 * 
				 * @var \stdClass
				 */
				$data = (object) array
				(
					'variables' => array
					(
						'form_id' => $form->getId()
					),
					'to' 		=> $form->getFormRecipient(),
					'from' 		=> array
					(
						'name' 	=> $form->getFormSubject(),
						'email' => $sender
					)
				);
				
				try 
				{
					/**
					 * Get current store
					 * 
					 * @var int
					 */
					$store = $this->storeManager->getStore()->getId();
					
					/**
					 * Get email transport 
					 * 
					 * @var mixed
					 */
					$transport = $this->transport->setTemplateIdentifier('form')->setTemplateOptions(['area' =>  \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $store])->setTemplateVars($data->variables)->setFrom($data->from)->addTo($data->to)->setReplyTo($data->from['email'])->getTransport();
					
					/**
					 * Send message
					 * 
					 */
					if (1)
					{
						$transport->sendMessage();
					}
					
					/**
					 * Set confirmation message
					 * 
					 * @var string
					 */
					$response['message'] = (string) __('Thank you. Message has been sent.');
				}
				catch (\Exception $e)
				{
					$errors[] = $e->getMessage();
				}
			}
			
			$response['errors'] = $errors;
			
			return $result->setData($response);
		}
	}
	
	public function getFormFields($form)
	{
		$fields = [];
	
		foreach ($this->factoryCollection->create()->addForm($form->getId()) as $field)
		{
			$fields[] = $this->eav->create()->load
			(
				$field->getFieldFormAttributeId()
			);
		}
	
		return $fields;
	}
}