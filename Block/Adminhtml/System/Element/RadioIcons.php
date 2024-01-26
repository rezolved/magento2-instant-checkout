<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Block\Adminhtml\System\Element;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Radios;
use Magento\Framework\DataObject;
use Magento\Framework\Escaper;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Store\Api\Data\StoreConfigInterface;
use Rezolve\InstantCheckout\Model\Config;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonColour;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonCorners;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonHeight;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonWidth;

class RadioIcons extends Radios
{
    /**
     * @var SecureHtmlRenderer
     */
    private $secureRenderer;

    public function __construct(
        protected Factory $factoryElement,
        protected CollectionFactory $factoryCollection,
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
        $this->secureRenderer = $secureRenderer = $secureRenderer ?? ObjectManager::getInstance()->get(SecureHtmlRenderer::class);
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data, $secureRenderer);
        $this->setType('radio-icons');
    }

//    protected function getStoreId(): int
//    {
//        return (int) $this->_storeManager->getStore()->getId();
//    }

    /**
     * Render choices.
     *
     * @param array $option
     * @param string[] $selected
     * @return string
     */
    protected function _optionToHtml($option, $selected)
    {
        $fieldConfig = $this->getFieldConfig();
        $fieldId = $fieldConfig['id'] ? $fieldConfig['id'] . '-' . $option['value'] : '';

        $html = '<div class="row-field-option ' . $fieldId . '">' .
            '<input type="radio"' . $this->getRadioButtonAttributes($option);
        if (is_array($option)) {
            $option = new DataObject($option);
            $optionId = $this->getHtmlId() . $option['value'];
            $html .= 'value="' . $this->_escape(
                    $option['value']
                ) . '" class="control-radio" id="' .$optionId  .'"';
            if ($option['value'] == $selected) {
                $html .= ' checked="checked"';
            }
            $html .= ' />';
            $html .= '<label class="control-field-label" for="' .
                $this->getHtmlId() . $option['value'] .
                '"><span class="icon-' . $fieldId . '" data-type="' . $fieldConfig['id'] . '"'.
                'data-value="' . $option['value'] . '">' . $option['label'] .
                '</span></label>';
        } elseif ($option instanceof DataObject) {
            $optionId = $this->getHtmlId() . $option->getValue();
            $html .= 'id="' .$optionId  .'"' .$option->serialize(
                    ['label', 'title', 'value', 'class']
                );
            if (in_array($option->getValue(), $selected)) {
                $html .= ' checked="checked"';
            }
            $html .= ' />';
            $html .= '<label class="inline" for="' .
                $this->getHtmlId() .
                $option->getValue() .
                '">' .
                $option->getLabel() .
                '</label>';
        }

        if ($option->getStyle()) {
            $html .= $this->secureRenderer->renderStyleAsTag($option->getStyle(), "#$optionId");
        }
        if ($option->getOnclick()) {
            $this->secureRenderer->renderEventListenerAsTag('onclick', $option->getOnclick(), "#$optionId");
        }
        if ($option->getOnchange()) {
            $this->secureRenderer->renderEventListenerAsTag('onchange', $option->getOnchange(), "#$optionId");
        }
        $html .= '</div>';

        return $html;
    }
}
