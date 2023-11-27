<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Block\ProductDetail;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry as CoreRegistry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Rezolve\InstantCheckout\Model\Config;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonWidth;

class Button extends Template
{
    /**
     * @var ProductInterface|null
     */
    protected ?ProductInterface $_product = null;

    /**
     * @param Context $context
     * @param Config $instantCheckoutConfig
     * @param CoreRegistry $coreRegistry
     * @param array $data
     */
    public function __construct(
        protected Context $context,
        private Config $instantCheckoutConfig,
        protected CoreRegistry $coreRegistry,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getMerchantId(): string
    {
        return trim($this->instantCheckoutConfig->getMerchantIdValue($this->getCurrentStoreId())) ?? '';
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return (int) $this->getProduct()->getId();
    }

    /**
     * @return ProductInterface|null
     */
    public function getProduct(): ?ProductInterface
    {
        if (!$this->_product) {
            $this->_product = $this->coreRegistry->registry('product');
        }

        return $this->_product;
    }

    /**
     * Checks if button enabled on product detail page.
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isProductDetailEnabled(): bool
    {
        return $this->instantCheckoutConfig->isProductDetailEnabled($this->getCurrentStoreId());
    }

    /**
     * Returns active store view identifier.
     *
     * @return int
     * @throws NoSuchEntityException
     */
    private function getCurrentStoreId(): int
    {
        return (int) $this->_storeManager->getStore()->getId();
    }

    /**
     * @return string
     */
    public function getClasses(): string
    {
        $colour = $this->instantCheckoutConfig->getProductDetailButtonColour($this->getCurrentStoreId());
        $height = $this->instantCheckoutConfig->getProductDetailButtonHeight($this->getCurrentStoreId());
        $corners = $this->instantCheckoutConfig->getProductDetailButtonCorners($this->getCurrentStoreId());
        $width = $this->instantCheckoutConfig->getProductDetailButtonWidth($this->getCurrentStoreId());

        $classes = [];
        if (!empty($colour)) {
            $classes[] = $colour;
        }
        if (!empty($height)) {
            $classes[] = $height;
        }
        if (!empty($corners)) {
            $classes[] = $corners;
        }
        if (!empty($width)) {
            $classes[] = $width;
        }

        return implode(' ', $classes);
    }

    /**
     * @return string
     */
    public function getCustomWidthStyleValue(): string
    {
        $value = $this->instantCheckoutConfig->getProductDetailCustomWidth($this->getCurrentStoreId());
        $isCustomWidthEnabled = $this->isProductButtonCustomWidthEnabled();

        return ($isCustomWidthEnabled && $value > 0) ? 'style="width:' . $value . 'px"' : '';
    }

    /**
     * @return string
     */
    public function getProductButtonStyle(): string
    {
        return $this->instantCheckoutConfig->getProductDetailButtonStyle($this->getCurrentStoreId()) ?? '';
    }

    /**
     * @return string
     */
    public function getProductImageStyle(): string
    {
        return $this->instantCheckoutConfig->getProductDetailButtonImageStyle($this->getCurrentStoreId()) ?? '';
    }

    /**
     * @return bool
     */
    public function isProductButtonCustomWidthEnabled(): bool
    {
        $width = $this->instantCheckoutConfig->getProductDetailButtonWidth($this->getCurrentStoreId());

        return ($width === ButtonWidth::CUSTOM_WIDTH);
    }

    /**
     * @return bool
     */
    public function isAllowedProductType(): bool
    {
        $productType = $this->getProduct()->getTypeId();
        $allowedTypes = $this->instantCheckoutConfig->getAllowedProductTypes();

        return in_array($productType, $allowedTypes);
    }
}
