<?php
namespace Anowave\Contact\Block\Form;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Element\Template\Context;


class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Cms\Model\Resource\Page\Grid\CollectionFactory
     */
    protected $_collectionFactory;
   
    /**
     * Constructor 
     * 
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Anowave\Contact\Model\ResourceModel\FormCollection $collectionFactory
     * @param array $data
     */
    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Anowave\Contact\Model\ResourceModel\Form\CollectionFactory $collectionFactory,
        array $data = []
    ) 
    {
        $this->_collectionFactory = $collectionFactory;

        parent::__construct($context, $backendHelper, $data);
    }
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        
        $this->setId('formGrid');
        $this->setDefaultSort('form_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();

        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }
    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn('form_name',
        [
        	'header'    => __('Form name'),
        	'index'     => 'form_name',
        	'type'		=> 'text'
        ]);
        
        return parent::_prepareColumns();
    }
    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['form_id' => $row->getId()]);
    }
    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
