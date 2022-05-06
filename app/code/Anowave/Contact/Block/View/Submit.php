<?php
namespace Anowave\Contact\Block\View;

use Magento\Backend\Block\Widget;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Backend\Block\Template;


class Submit extends Widget implements RendererInterface
{
    /**
     * Render form element as HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
    	return $this->getLayout()->createBlock('Anowave\Contact\Block\View\Button')->toHtml();
    }
}