<?php
namespace Anowave\Contact\Block\Form\Edit\Tab;

class Fields extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param array $data
     */
    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) 
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        
        parent::__construct($context, $registry, $formFactory, $data);
    }
    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('form');
        

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('form_fields_');
        
        $fieldset = $form->addFieldset
        (
            'fields_fieldset',
            [
            	'legend' => __('Fields'), 
            	'class' => 'fieldset-wide'
            ]
        );
        
        $fieldset->addType('fields', 'Anowave\Contact\Block\Renderer\Fields');
        
        $field = $fieldset->addField
        (
        	'fields', 'fields',
        	[
        		'name' 		=> 'fields',
        		'label' 	=> __('Select form fields'),
        		'title' 	=> __('Fields')
        	]
        );
        

        $form->setValues($model->getData());
        $form->setLayout($this->getLayout());
        
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
        return __('Fields');
    }
    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Fields');
    }
    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }
    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
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