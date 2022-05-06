<?php
namespace Anowave\Contact\Block\Form\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) 
    {
        $this->_systemStore = $systemStore;
        
        parent::__construct($context, $registry, $formFactory, $data);
    }
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('form');


        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('form_main_');
        
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Form Options')]);
        
        if ($model->getId()) 
        {
            $fieldset->addField('form_id', 'hidden', ['name' => 'form_id']);
        }
        
        $fieldset->addField('form_name','text',
            [
                'name' 		=> 'form_name',
                'label' 	=> __('Form name'),
                'title' 	=> __('Form name'),
                'required' 	=> true
            ]
        );
        
        $fieldset->addField('form_subject','text',
        	[
        		'name' 		=> 'form_subject',
        		'label' 	=> __('Subject'),
        		'title' 	=> __('Subject'),
        		'required' 	=> true
        	]
        );
        
        $fieldset->addField('form_recipient','text',
        	[
        		'name' 		=> 'form_recipient',
        		'label' 	=> __('Recipient'),
        		'title' 	=> __('Recipient'),
        		'class' 	=> 'validate-email',
        		'required' 	=> true
        	]
        );
        
        $fieldset->addField('form_template','select',
        	[
        		'name' 		=> 'form_template',
        		'label' 	=> __('Use template'),
        		'title' 	=> __('Use template'),
        		'values'	=> array
        		(
        			array
        			(
        				'label' => 'Form',
        				'value' => 'form'
        			)
        		),
        		'required' => true
        	]
        );

        /**
         * Set form values
         */
        $form->setValues($model->getData());
        
        /**
         * Set form
         */
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Form Options');
    }
    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Form Options');
    }
    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}