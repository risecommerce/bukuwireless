<?php
namespace Anowave\Contact\Model\ResourceModel\Attribute;

class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection
{
	/**
	 * Resource model initialization
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Anowave\Contact\Model\ResourceModel\Eav\Attribute','Magento\Eav\Model\ResourceModel\Entity\Attribute');
	}
	
	/**
	 * Initialize select object
	 *
	 * @return $this
	 */
	protected function _initSelect()
	{
		$entityTypeId = (int)$this->_eavEntityFactory->create()->setType('form')->getTypeId();
		
		$columns = $this->getConnection()->describeTable($this->getResource()->getMainTable());
		
		unset($columns['attribute_id']);
		
		$retColumns = [];
		
		foreach ($columns as $labelColumn => $columnData) 
		{
			$retColumns[$labelColumn] = $labelColumn;
			
			if ($columnData['DATA_TYPE'] == \Magento\Framework\DB\Ddl\Table::TYPE_TEXT) 
			{
				$retColumns[$labelColumn] = 'main_table.' . $labelColumn;
			}
		}
		
		$this->getSelect()->from(['main_table' => $this->getResource()->getMainTable()],$retColumns)->join
		(
			[
				'additional_table' => $this->getTable('ae_forms_eav_attribute')
			],
			'additional_table.attribute_id = main_table.attribute_id'
		)->where
		(
			'main_table.entity_type_id = ?', $entityTypeId
		);
		
		return $this;
	}
	
}
