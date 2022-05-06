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

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

    	$sql = array();

		$sql[] = "SET foreign_key_checks = 0";
		
		/**
		 * Create schema
		 */
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms') . " (form_id int(6) NOT NULL AUTO_INCREMENT,form_name varchar(255) DEFAULT NULL,form_recipient text,form_subject varchar(255) DEFAULT NULL,form_autoreply text,form_template varchar(255) DEFAULT NULL,PRIMARY KEY (form_id)) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_eav_attribute') . " (attribute_id smallint(5) unsigned NOT NULL COMMENT 'Attribute ID',frontend_input_renderer varchar(255) DEFAULT NULL COMMENT 'Frontend Input Renderer',is_global smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Is Global',is_visible smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Is Visible',is_searchable smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Searchable',is_filterable smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Filterable',is_comparable smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Comparable',is_visible_on_front smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Visible On Front',is_html_allowed_on_front smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is HTML Allowed On Front',is_used_for_price_rules smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used For Price Rules',is_filterable_in_search smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Filterable In Search',used_in_product_listing smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used In Product Listing',used_for_sort_by smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used For Sorting',apply_to varchar(255) DEFAULT NULL COMMENT 'Apply To',is_visible_in_advanced_search smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Visible In Advanced Search',position int(11) NOT NULL DEFAULT '0' COMMENT 'Position',is_wysiwyg_enabled smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is WYSIWYG Enabled',is_used_for_promo_rules smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used For Promo Rules',is_required_in_admin_store smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Required In Admin Store',is_used_in_grid smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used in Grid',is_visible_in_grid smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Visible in Grid',is_filterable_in_grid smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Filterable in Grid',search_weight float NOT NULL DEFAULT '1' COMMENT 'Search Weight',additional_data text COMMENT 'Additional swatch attributes data',PRIMARY KEY (attribute_id),KEY CATALOG_EAV_ATTRIBUTE_USED_FOR_SORT_BY (used_for_sort_by),KEY CATALOG_EAV_ATTRIBUTE_USED_IN_PRODUCT_LISTING (used_in_product_listing)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Form EAV Attribute Table'";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_entity') . " (entity_id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Entity Id',website_id smallint(5) unsigned DEFAULT NULL COMMENT 'Website Id',store_id int(6) DEFAULT NULL,PRIMARY KEY (entity_id)) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Form Entity'";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_entity_datetime') . " (value_id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value Id',attribute_id smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',entity_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Id',value datetime(6) DEFAULT NULL COMMENT 'Value',PRIMARY KEY (value_id),UNIQUE KEY CUSTOMER_ENTITY_VARCHAR_ENTITY_ID_ATTRIBUTE_ID (entity_id,attribute_id),KEY CUSTOMER_ENTITY_VARCHAR_ATTRIBUTE_ID (attribute_id),KEY CUSTOMER_ENTITY_VARCHAR_ENTITY_ID_ATTRIBUTE_ID_VALUE (entity_id,attribute_id,value),CONSTRAINT ae_forms_entity_datetime_ibfk_1 FOREIGN KEY (entity_id) REFERENCES " . $setup->getTable('ae_forms_entity') . " (entity_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Form Entity Varchar'";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_entity_decimal') . " (value_id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value Id',attribute_id smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',entity_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Id',value decimal(10,2) DEFAULT NULL COMMENT 'Value',PRIMARY KEY (value_id),UNIQUE KEY CUSTOMER_ENTITY_VARCHAR_ENTITY_ID_ATTRIBUTE_ID (entity_id,attribute_id),KEY CUSTOMER_ENTITY_VARCHAR_ATTRIBUTE_ID (attribute_id),KEY CUSTOMER_ENTITY_VARCHAR_ENTITY_ID_ATTRIBUTE_ID_VALUE (entity_id,attribute_id,value),CONSTRAINT ae_forms_entity_decimal_ibfk_1 FOREIGN KEY (entity_id) REFERENCES " . $setup->getTable('ae_forms_entity') . " (entity_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Form Entity Varchar'";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_entity_int') . " (value_id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value Id',attribute_id smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',entity_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Id',value int(11) NOT NULL DEFAULT '0' COMMENT 'Value',PRIMARY KEY (value_id),UNIQUE KEY CUSTOMER_ENTITY_INT_ENTITY_ID_ATTRIBUTE_ID (entity_id,attribute_id),KEY CUSTOMER_ENTITY_INT_ATTRIBUTE_ID (attribute_id),KEY CUSTOMER_ENTITY_INT_ENTITY_ID_ATTRIBUTE_ID_VALUE (entity_id,attribute_id,value),CONSTRAINT ae_forms_entity_int_ibfk_1 FOREIGN KEY (entity_id) REFERENCES " . $setup->getTable('ae_forms_entity') . " (entity_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Form Entity Int'";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_entity_text') . " (value_id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value Id',attribute_id smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',entity_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Id',value text NOT NULL COMMENT 'Value',PRIMARY KEY (value_id),UNIQUE KEY CUSTOMER_ENTITY_TEXT_ENTITY_ID_ATTRIBUTE_ID (entity_id,attribute_id),KEY CUSTOMER_ENTITY_TEXT_ATTRIBUTE_ID (attribute_id),CONSTRAINT ae_forms_entity_text_ibfk_1 FOREIGN KEY (entity_id) REFERENCES " . $setup->getTable('ae_forms_entity') . " (entity_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Form Entity Text'";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_entity_varchar') . " (value_id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Value Id',attribute_id smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',entity_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Id',value varchar(255) DEFAULT NULL COMMENT 'Value',PRIMARY KEY (value_id),UNIQUE KEY CUSTOMER_ENTITY_VARCHAR_ENTITY_ID_ATTRIBUTE_ID (entity_id,attribute_id),KEY CUSTOMER_ENTITY_VARCHAR_ATTRIBUTE_ID (attribute_id),KEY CUSTOMER_ENTITY_VARCHAR_ENTITY_ID_ATTRIBUTE_ID_VALUE (entity_id,attribute_id,value),CONSTRAINT ae_forms_entity_varchar_ibfk_1 FOREIGN KEY (entity_id) REFERENCES " . $setup->getTable('ae_forms_entity') . " (entity_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='Form Entity Varchar'";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_fields') . " (field_id int(11) NOT NULL AUTO_INCREMENT,field_form_id int(6) NOT NULL,field_form_attribute_id smallint(5) unsigned NOT NULL,PRIMARY KEY (field_id),KEY form_id (field_form_id),KEY form_eav_attribute_id (field_form_attribute_id),CONSTRAINT ae_forms_fields_ibfk_1 FOREIGN KEY (field_form_id) REFERENCES " . $setup->getTable('ae_forms') . " (form_id) ON DELETE CASCADE ON UPDATE CASCADE,CONSTRAINT ae_forms_fields_ibfk_2 FOREIGN KEY (field_form_attribute_id) REFERENCES " . $setup->getTable('eav_attribute') . " (attribute_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $setup->getTable('ae_forms_product_enquiry_config') . " (enquiry_id int(6) NOT NULL AUTO_INCREMENT,enquiry_product_id int(10) unsigned NOT NULL,enquiry_form_id int(6) NOT NULL,PRIMARY KEY (enquiry_id),UNIQUE KEY enquiry_product_id (enquiry_product_id,enquiry_form_id),KEY enquiry_form_id (enquiry_form_id),CONSTRAINT ae_forms_product_enquiry_config_ibfk_2 FOREIGN KEY (enquiry_product_id) REFERENCES catalog_product_entity (entity_id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8";
		
		/**
		 * Insert entity type
		 */
		$sql[] = "REPLACE INTO " . $setup->getTable('eav_entity_type') . " SET entity_type_code = 'form',entity_model = 'Anowave\\\Contact\\\Model\\\ResourceModel\\\Entity',attribute_model	= 'Anowave\\\Contact\\\Model\\\Attribute',entity_table = 'ae_forms_entity',is_data_sharing = 1,data_sharing_key = 'default',default_attribute_set_id = 1,increment_model = 'Magento\\\Eav\\\Model\\\Entity\\\Increment\\\NumericValue',increment_per_store = 0,increment_pad_length = 8,additional_attribute_table	= 'ae_forms_eav_attribute',entity_attribute_collection = 'Anowave\\\Contact\\\Model\\\ResourceModel\\\Attribute\\\Collection'";
						
		$sql[] = "SET foreign_key_checks = 1";
		
		foreach ($sql as $query)
		{
			$setup->run($query);
		}
		        

        $setup->endSetup();
    }
}


