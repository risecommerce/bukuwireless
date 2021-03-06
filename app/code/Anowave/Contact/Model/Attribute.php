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
 * @package 	Anowave_Status
 * @copyright 	Copyright (c) 2016 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */
 
namespace Anowave\Contact\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Catalog\Api\Data\EavAttributeInterface;
use Magento\Framework\Stdlib\DateTime\DateTimeFormatterInterface;

/**
 * Form attribute model
 *
 * @method int getSortOrder()
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Attribute extends \Magento\Eav\Model\Attribute
{
    /**
     * Name of the module
     */
    const MODULE_NAME = 'Anowave_Contact';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'form_entity_attribute';

    /**
     * Prefix of model events object
     *
     * @var string
     */
    protected $_eventObject = 'attribute';

    /**
     * @var \Magento\Framework\Indexer\IndexerRegistry
     */
    protected $indexerRegistry;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param \Magento\Eav\Model\Entity\TypeFactory $eavTypeFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Eav\Model\ResourceModel\Helper $resourceHelper
     * @param \Magento\Framework\Validator\UniversalFactory $universalFactory
     * @param \Magento\Eav\Api\Data\AttributeOptionInterfaceFactory $optionDataFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Catalog\Model\Product\ReservedAttributeList $reservedAttributeList
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     * @param DateTimeFormatterInterface $dateTimeFormatter
     * @param \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct
    (
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Eav\Model\Entity\TypeFactory $eavTypeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Eav\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        \Magento\Eav\Api\Data\AttributeOptionInterfaceFactory $optionDataFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Catalog\Model\Product\ReservedAttributeList $reservedAttributeList,
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        DateTimeFormatterInterface $dateTimeFormatter,
        \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) 
    {
        $this->indexerRegistry = $indexerRegistry;
        
        parent::__construct
        (
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $eavConfig,
            $eavTypeFactory,
            $storeManager,
            $resourceHelper,
            $universalFactory,
            $optionDataFactory,
            $dataObjectProcessor,
            $dataObjectHelper,
            $localeDate,
            $reservedAttributeList,
            $localeResolver,
            $dateTimeFormatter,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * Init resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Anowave\Contact\Model\ResourceModel\Attribute');
    }

    /**
     * Processing object after save data
     *
     * @return $this
     */
    public function afterSave()
    {
        if ($this->isObjectNew() && (bool)$this->getData(EavAttributeInterface::IS_USED_IN_GRID)) 
        {
            $this->_getResource()->addCommitCallback([$this, 'invalidate']);
        } 
        elseif (!$this->isObjectNew() && $this->dataHasChangedFor(EavAttributeInterface::IS_USED_IN_GRID)) 
        {
            $this->_getResource()->addCommitCallback([$this, 'invalidate']);
        }
        
        return parent::afterSave();
    }

    /**
     * Init indexing process after form delete
     *
     * @return \Magento\Framework\Model\AbstractModel
     */
    public function afterDeleteCommit()
    {
        if ($this->getData(EavAttributeInterface::IS_USED_IN_GRID) == true) 
        {
            $this->invalidate();
        }
        return parent::afterDeleteCommit();
    }

    /**
     * Init indexing process after form save
     *
     * @return void
     */
    public function invalidate()
    {
       	/**
       	 * @todo Implement invalidation
       	 */
    }

    /**
     * Check whether attribute is searchable in admin grid and it is allowed
     *
     * @return bool
     */
    public function canBeSearchableInGrid()
    {
        return $this->getData('is_searchable_in_grid') && in_array($this->getFrontendInput(), ['text', 'textarea']);
    }

    /**
     * Check whether attribute is filterable in admin grid and it is allowed
     *
     * @return bool
     */
    public function canBeFilterableInGrid()
    {
        return $this->getData('is_filterable_in_grid') && in_array($this->getFrontendInput(), ['text', 'date', 'select', 'boolean']);
    }
}
