<?php
namespace Anowave\Contact\Block;

class View extends \Magento\Framework\View\Element\Template
{
	/**
	 * @var \Anowave\Contact\Model\FormFactory
	 */
	protected $factory = null;
	
	/**
	 * @var \Anowave\Contact\Model\ResourceModel\Field\CollectionFactory
	 */
	protected $factoryCollection = null;
	
	/**
	 * 
	 * @var Form
	 */
	private $form = null;
	
	/**
	 * @var \Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory
	 */
	protected $eav = null;
	
	/**
	 * @var \Magento\Framework\Data\Form\Element\Factory
	 */
	protected $elementFactory;
	
	/**
	 * @var \Magento\Framework\Data\FormFactory
	 */
	protected $formFactory = null;
	
	public function __construct
	(
		\Magento\Framework\View\Element\Template\Context $context,
		\Anowave\Contact\Model\FormFactory $factory,
		\Anowave\Contact\Model\ResourceModel\Field\CollectionFactory $factoryCollection,
		\Anowave\Contact\Model\ResourceModel\Eav\AttributeFactory $eav,
		\Magento\Framework\Data\Form\Element\Factory $elementFactory,
		\Magento\Framework\Data\FormFactory $formFactory,
		array $data = []
	)
	{
		parent::__construct($context, $data);
		
		$this->eav 					= $eav;
		$this->factory 				= $factory;
		$this->factoryCollection 	= $factoryCollection;
		$this->elementFactory 		= $elementFactory;
		$this->formFactory			= $formFactory;
	
		try 
		{
			$args = new \Magento\Framework\DataObject($data);

			if ((int) $args->getFormId() > 0)
			{
				$this->form = $this->factory->create()->load($args->getFormId());
				
				/**
				 * Set product. Used in product enquiry form(s)
				 */
				if ($args->getProduct())
				{
					$this->form->setProduct
					(
						$args->getProduct()
					);
				}

				if (!$this->form->getId())
				{
					throw new \Exception
					(
						__('Form with ID:' . $args->getFormId() . ' does NOT exist.')
					);
				}
			}
		}
		catch (\Exception $e)
		{
			throw new \Exception($e->getMessage());
		}
	}
	
	public function _construct()
	{
		parent::_construct();
		
		/**
		 * Set template
		 */
		$this->setTemplate('Anowave_Contact::form.phtml');
	}
	
	public function getFormName()
	{
		if ($this->form)
		{
			return $this->form->getFormName();
		}
		
		return null;
	}
	
	public function getFormId()
	{
		if ($this->form)
		{
			return $this->form->getId();
		}
		
		return null;
	}
	
	public function getForm()
	{
		/**
		 * Create form 
		 */
		$form = $this->formFactory->create();
		
		/**
		 * Create fieldset 
		 * @var unknown
		 */
		$fieldset = $form->addFieldset
		(
			'general',
			[
				'legend' => '', 'collapsable' => false
			]
		);
		
		try 
		{
			if ($this->form->getProduct())
			{
				$fieldset->addField('form_product_id', 'hidden' , array
				(
					'name'  	=> 'form_product_id',
					'label' 	=> __('Product'),
					'value' 	=> $this->form->getProduct()->getId()
				));
			}
			
			foreach($this->getFormFields() as $field)
			{
				if (!$form->getElement($field->getAttributeCode()))
				{
					if ($field->usesSource())
					{
						$values = $field->getSource()->getAllOptions(true, true);
					}
					else 
					{
						$values = [];
					}
						
					switch ($field->getFrontendInput())
					{
						case 'boolean':
							$type = 'radios';
							break;
						default:
							$type = $field->getFrontendInput();
							break;
					}
					
					$fieldset->addField($field->getAttributeCode(), $type , array
					(
						'name'  	=> $field->getAttributeCode(),
						'label' 	=> $field->getFrontendLabel(),
						'value' 	=> $field->getDefaultValue(),
						'values' 	=> $values
					));
				}
			}
			
			$submit = $fieldset->addField('submit', 'submit', array
			(
				'name' 	=> 'submit',
				'value' => __('Send Enquiry')
			));
			
			$submit->setRenderer
			(
				$this->getLayout()->createBlock('Anowave\Contact\Block\View\Submit')
			);
		}
		catch (\Exception $e)
		{
			
		}
		return $form;
	}
	
	public function getFormFields()
	{
		$fields = [];
		
		foreach ($this->factoryCollection->create()->addForm($this->form->getId()) as $field)
		{
			$fields[] = $this->eav->create()->load
			(
				$field->getFieldFormAttributeId()
			);
		}

		return $fields;
	}
}