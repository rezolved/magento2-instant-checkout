<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Escaper;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Store\Api\Data\StoreConfigInterface;
use Rezolve\InstantCheckout\Model\Config;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonColour;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonCorners;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonHeight;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonWidth;

class ButtonRadioField extends Field
{
    public function __construct(
        Context $context,
        protected Escaper $escaper,
        protected ButtonWidth $buttonWidth,
        protected ButtonCorners $buttonCorners,
        protected ButtonHeight $buttonHeight,
        protected ButtonColour $buttonColour,
        protected Config $config,
        protected StoreConfigInterface $storeConfig,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        $secureRenderer = $secureRenderer ?? ObjectManager::getInstance()->get(SecureHtmlRenderer::class);
        parent::__construct($context, $data, $secureRenderer);
    }

    /**
     * Render element value
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _renderValue(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        if ($element->getTooltip()) {
            $html = '<td class="value with-tooltip">';
            $html .= $this->_getElementHtml($element);
            $html .= '<div class="tooltip"><span class="help"><span></span></span>';
            $html .= '<div class="tooltip-content">' . $element->getTooltip() . '</div></div>';
        } else {
            $html = '<td class="value radio-icons-list">';
            $html .= $this->_getElementHtml($element);
        }
        $selectedLabel = '';
        foreach ($element->getValues() as $option) {
            if ($option['value'] === $element->getValue()) {
                $selectedLabel = (string) $option['label'];
            }
        }
        $html .= '<div class="field-value">' . $selectedLabel . '</div>';
        $html .= '</td>';
        return $html;
    }

    /**
     * Decorate field row html
     *
     * @param AbstractElement $element
     * @param string $html
     * @return string
     */
    protected function _decorateRowHtml(AbstractElement $element, $html)
    {
        return '<tr id="row_' . $element->getHtmlId() . '" class="row-ic-button">' . $html . '</tr>';
    }
}
