<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Store\Api\Data\StoreInterface;
use Rezolve\InstantCheckout\Model\ButtonStyles;
use Rezolve\InstantCheckout\Model\Config;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonWidth;

class ButtonPreview extends Field
{
    public const DETAIL_BUTTON_PREVIEW = 'button_detail_preview';
    public const LISTING_BUTTON_PREVIEW = 'button_listing_preview';
    protected StoreInterface $store;

    public function __construct(
        protected Context $context,
        protected Config $config,
        protected ButtonStyles $buttonStyles,
        protected ?SecureHtmlRenderer $secureRenderer = null,
        array $data = []
    ) {
        $this->store = $context->getStoreManager()->getStore();
        parent::__construct($context, $data, $secureRenderer);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function getButtonPlace(AbstractElement $element): string
    {
        return $element->getOriginalData('id') ?? '';
    }

    /**
     * @return int
     */
    protected function getStoreId(): int
    {
        return (int) $this->store->getId();
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function getClasses(AbstractElement $element): string
    {
        $colour = '';
        $height = '';
        $corners = '';
        $width = '';

        if ($this->getButtonPlace($element) === self::DETAIL_BUTTON_PREVIEW) {
            $colour = $this->config->getProductDetailButtonColour($this->getStoreId());
            $height = $this->config->getProductDetailButtonHeight($this->getStoreId());
            $corners = $this->config->getProductDetailButtonCorners($this->getStoreId());
            $width = $this->config->getProductDetailButtonWidth($this->getStoreId());
        } elseif ($this->getButtonPlace($element) === self::LISTING_BUTTON_PREVIEW) {
            $colour = $this->config->getListingButtonColour($this->getStoreId());
            $height = $this->config->getListingButtonHeight($this->getStoreId());
            $corners = $this->config->getListingButtonCorners($this->getStoreId());
            $width = $this->config->getListingButtonWidth($this->getStoreId());
        }

        return $this->buttonStyles->prepareClasses(
            $colour,
            $height,
            $corners,
            $width
        );
    }

    /**
     * Render element value
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _renderValue(AbstractElement $element)
    {
        if ($element->getTooltip()) {
            $html = '<td class="value with-tooltip">';
            $html .= $this->getPreviewButtonElementHtml($element);
            $html .= '<div class="tooltip"><span class="help"><span></span></span>';
            $html .= '<div class="tooltip-content">' . $element->getTooltip() . '</div></div>';
        } else {
            $html = '<td class="value">';
            $html .= $this->getPreviewButtonElementHtml($element);
        }
        if ($element->getComment()) {
            $html .= '<p class="note"><span>' . $element->getComment() . '</span></p>';
        }
        $html .= '</td>';
        return $html;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function getPreviewButtonElementHtml(AbstractElement $element): string
    {
        $buttonClasses = $this->getClasses($element);
        $directStyle = '';
        $imgStyle = '';
        if ($this->getButtonPlace($element) === self::DETAIL_BUTTON_PREVIEW) {
            $colour = $this->config->getProductDetailButtonColour($this->getStoreId());
            $buttonWidth = $this->config->getProductDetailButtonWidth($this->getStoreId());
            $customWidthValue =  $this->config->getProductDetailCustomWidth($this->getStoreId());
            $buttonStyle = $this->config->getProductDetailButtonStyle($this->getStoreId());
            $imgStyleValue = $this->config->getProductDetailButtonImageStyle($this->getStoreId());
        } else {
            $colour = $this->config->getListingButtonColour($this->getStoreId());
            $buttonWidth = $this->config->getListingButtonWidth($this->getStoreId());
            $customWidthValue =  $this->config->getListingCustomWidth($this->getStoreId());
            $buttonStyle = $this->config->getListingButtonStyle($this->getStoreId());
            $imgStyleValue = $this->config->getListingButtonImageStyle($this->getStoreId());
        }
        $logoSrc = ($colour === 'dark') ? $this->getLogoSrcForDark() : $this->getLogoSrcForLight();

        if ($buttonWidth === ButtonWidth::CUSTOM_WIDTH && $customWidthValue > 0) {
            $directStyle .= 'width:' . $customWidthValue . 'px;';
        }

        if (!empty($buttonStyle)) {
            $directStyle .= $buttonStyle;
        }

        if ($imgStyleValue) {
            $imgStyle = 'style="' . $imgStyleValue . '"';
        }

        return '<button class="instant-button ' . $buttonClasses . '" type="button" style="' . $directStyle . '">' .
            '<img alt="Rezolve Logo" src="' . $logoSrc . '" class="ml-2 mr-2 image_style" ' . $imgStyle . ' /></button>';
    }

    /**
     * @return string
     */
    public function getLogoSrcForDark(): string
    {
        return $this->getViewFileUrl('Rezolve_InstantCheckout::images/dark.svg');
    }

    /**
     * @return string
     */
    public function getLogoSrcForLight(): string
    {
        return $this->getViewFileUrl('Rezolve_InstantCheckout::images/light.svg');
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
        return '<tr id="row_' . $element->getHtmlId() . '" class="row-ic-button">' .
            '<script>' .
            'window.rezolveBtnLightSrc = \''. $this->getLogoSrcForLight(). '\';' .
            'window.rezolveBtnDarkSrc = \''. $this->getLogoSrcForDark(). '\';' .
            '</script>' .
            $html . '</tr>';
    }
}
