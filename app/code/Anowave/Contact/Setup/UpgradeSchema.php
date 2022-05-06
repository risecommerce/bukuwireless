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
 * @package 	Anowave_Contact
 * @copyright 	Copyright (c) 2016 Anowave (http://www.anowave.com/)
 * @license  	http://www.anowave.com/license-agreement/
 */
namespace Anowave\Contact\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
	/**
	 * Upgrade schema
	 * 
	 * @see \Magento\Framework\Setup\UpgradeSchemaInterface::upgrade()
	 */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        if (version_compare($context->getVersion(), '2.0.1') == 0) 
        {
            $sql = array();
            
            $sql[] = "ALTER TABLE " . $setup->getTable('ae_forms_entity') . " ADD entity_form_id INT(6) NULL DEFAULT NULL AFTER entity_id, ADD INDEX form_id (entity_form_id)";
            
            foreach ($sql as $query)
            {
            	$setup->run($query);
            }
        }
        
        /**
         * Drop redundant foreign key(s)
         */
        if (version_compare($context->getVersion(), '2.0.2') == 0)
        {
        	$sql = array();
        
        	$sql[] = "ALTER TABLE " . $setup->getTable('ae_forms_product_enquiry_config') . " DROP FOREIGN KEY ae_forms_product_enquiry_config_ibfk_1";
        	
        	foreach ($sql as $query)
        	{
        		$setup->run($query);
        	}
        }
        
        /**
         * Add missing form ID to submissions
         */
        if (version_compare($context->getVersion(), '2.0.3') == 0)
        {
        	$sql = array();
        
        	$sql[] = "ALTER TABLE " . $setup->getTable('ae_forms_entity') . " ADD entity_form_id INT(6) NULL DEFAULT NULL AFTER entity_id, ADD INDEX form_id (entity_form_id)";
  
        	foreach ($sql as $query)
        	{
        		$setup->run($query);
        	}
        }

        /**
         * Add timetamp to submissions
         */
        
        if (version_compare($context->getVersion(), '2.0.6') < 0)
        {
        	$sql = array();
        
        	$sql[] = "ALTER TABLE " . $setup->getTable('ae_forms_entity') . " ADD entity_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
        	 
        	foreach ($sql as $query)
        	{
        		$setup->run($query);
        	}
        }
        
        $setup->endSetup();
    }
}