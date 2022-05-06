<?php
namespace Anowave\Contact\Block;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;

/**
 * Product Review Tab
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Tab extends Template implements IdentityInterface
{
	protected $faqs = array();
	
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Review resource model
     *
     * @var \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    protected $factory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct
    (
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Anowave\Contact\Model\ResourceModel\Form\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_coreRegistry 	= $registry;
        $this->factory 			= $collectionFactory;
        
        parent::__construct($context, $data);

        $this->setTabTitle();
    }
    
    public function setTabTitle()
    {
    	$this->setTitle
    	(
    		__('Buyback Form')
    	);
    }

    /**
     * Get current product id
     *
     * @return null|int
     */
    public function getProductId()
    {
        $product = $this->_coreRegistry->registry('product');
        
        return $product ? $product->getId() : null;
    }
    
    public function getForm()
    {
    	if ($this->getProductId())
    	{
    		$enquiry_form_id = (int) $this->_coreRegistry->registry('product')->getEnquiryFormId();
    		
    		if ($enquiry_form_id)
    		{
    			try 
    			{
    				$block = $this->getLayout()->createBlock('Anowave\Contact\Block\View', 'product_enquiry', 
    				[
    					'data' => 
    					[
    						'form_id' => $enquiry_form_id,
    						'product' => $this->_coreRegistry->registry('product')
    					]
    				]);
    				
    				return $block->toHtml();
    			}
    			catch (\Exception $e)
    			{
    				
    			}
    		}
    		else 
    		{
    			return false;
    		}
    	}
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return ['contact_form_block'];
    }
}
