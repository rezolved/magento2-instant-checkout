<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Block\ProductListing;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Rezolve\InstantCheckout\Model\Config;
use Rezolve\InstantCheckout\Model\Config\Source\ButtonWidth;
use Magento\Catalog\Block\Product\AwareInterface as ProductAwareInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context as TemplateContext;

class View extends Template implements ProductAwareInterface
{
    /**
     * @var ProductInterface
     */
    private ProductInterface $product;

    /**
     * @param TemplateContext $context
     * @param Config $instantCheckoutConfig
     * @param array $data
     */
    public function __construct(
        protected TemplateContext $context,
        protected Config $instantCheckoutConfig,
        array $data = []
    ) {
        parent::__construct($context,$data);
    }
    /**
     * Set product
     *
     * @param ProductInterface $product
     * @return $this
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Retrieve product object
     *
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
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
     * Checks if button enabled on product listing page.
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isProductListingEnabled(): bool
    {
        return $this->instantCheckoutConfig->isProductListingEnabled($this->getCurrentStoreId());
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getListingClasses(): string
    {
        $colour = $this->instantCheckoutConfig->getListingButtonColour($this->getCurrentStoreId());
        $height = $this->instantCheckoutConfig->getListingButtonHeight($this->getCurrentStoreId());
        $corners = $this->instantCheckoutConfig->getListingButtonCorners($this->getCurrentStoreId());
        $width = $this->instantCheckoutConfig->getListingButtonWidth($this->getCurrentStoreId());

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
     * @throws NoSuchEntityException
     */
    public function getListingCustomWidthStyleValue(): string
    {
        $value = $this->instantCheckoutConfig->getListingCustomWidth($this->getCurrentStoreId());
        $isCustomWidthEnabled = $this->isListingButtonCustomWidthEnabled();

        return ($isCustomWidthEnabled && $value > 0) ? 'style="width:' . $value . 'px"' : '';
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getListingButtonStyle(): string
    {
        return $this->instantCheckoutConfig->getListingButtonStyle($this->getCurrentStoreId()) ?? '';
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getListingImageStyle(): string
    {
        return $this->instantCheckoutConfig->getListingButtonImageStyle($this->getCurrentStoreId()) ?? '';
    }

    /**
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isListingButtonCustomWidthEnabled(): bool
    {
        $width = $this->instantCheckoutConfig->getListingButtonWidth($this->getCurrentStoreId());

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

    /**
     * Returns active store view identifier.
     *
     * @return int
     * @throws NoSuchEntityException
     */
    private function getCurrentStoreId(): int
    {
        return (int) $this->getStoreManager()->getStore()->getId();
    }

    /**
     * @return StoreManagerInterface
     */
    protected function getStoreManager(): StoreManagerInterface
    {
        return $this->_storeManager;
    }
}
