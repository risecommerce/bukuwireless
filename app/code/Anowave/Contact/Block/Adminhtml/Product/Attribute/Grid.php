<?php
namespace Anowave\Contact\Block\Adminhtml\Product\Attribute;

class Grid extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Grid
{
	public function __construct
	(
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Backend\Helper\Data $backendHelper,
		\Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $collectionFactory,
		\Anowave\Contact\Model\ResourceModel\Attribute\CollectionFactory $collectionFactoryAttributes,
		array $data = []
	) 
	{
		parent::__construct($context, $backendHelper, $collectionFactory);
		
		/**
		 * Change collection 
		 */
		$this->_collectionFactory = $collectionFactoryAttributes;
		
		$this->_module = 'forms';
	}
	
	/**
	 * Return url of given row
	 *
	 * @param \Magento\Framework\DataObject $row
	 * @return string
	 */
	public function getRowUrl($row)
	{
		return $this->getUrl($this->_module . '/attributes/edit', 
		[
			'attribute_id'  => $row->getAttributeId(),
			'_current'		=> true
		]);
	}
}