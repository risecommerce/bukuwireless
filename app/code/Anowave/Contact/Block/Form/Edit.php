<?php
namespace Anowave\Contact\Block\Form;
/**
 * Admin CMS page
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct
    (
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) 
    {
        $this->_coreRegistry = $registry;
        
        parent::__construct($context, $data);
    }
    /**
     * Initialize cms page edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId 	= 'form_id';
        $this->_blockGroup 	= 'Anowave_Contact';
        $this->_controller 	= 'form';
        
        parent::_construct();
        
        if ($this->_isAllowedAction('Anowave_Contact::save')) 
        {
            $this->buttonList->update('save', 'label', __('Save Contact Form'));
            
            $this->buttonList->add
            (
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => 
                	[
                        'mage-init' => 
                		[
                            'button' => 
                			[
                            	'event' => 'saveAndContinueEdit', 
                				'target' => '#edit_form'
                			]
                        ]
                    ]
                ],
                -100
            );
        } 
        else 
        {
            $this->buttonList->remove('save');
        }
        
        if ($this->_isAllowedAction('Anowave_Contact::form_delete')) 
        {
            $this->buttonList->update('delete', 'label', __('Delete Contact Form'));
        } 
        else 
        {
            $this->buttonList->remove('delete');
        }
    }
    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('news')->getId()) 
        {
            return __("Edit Contact Form '%1'", $this->escapeHtml($this->_coreRegistry->registry('form')->getTitle()));
        } 
        else 
        {
            return __('New Contact Form');
        }
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
    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('forms/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }
}