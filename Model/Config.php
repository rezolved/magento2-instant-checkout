<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Rezolve Instant Checkout configuration.
 */
class Config
{
    public const BUTTON_PAGE_TYPE_DETAIL = 'detail';
    public const BUTTON_PAGE_TYPE_LISTING = 'listing';
    public const REZOLVE_MERCHANT_ID_PATH = 'rezolve_ic_button/general/merchant_id';
    public const PRODUCT_DETAIL_PAGE_ACTIVE_PATH = 'rezolve_ic_button/ic_button_on_product_page/enabled';
    public const PRODUCT_DETAIL_BUTTON_WIDTH_PATH = 'rezolve_ic_button/ic_button_on_product_page/button_width';
    public const PRODUCT_DETAIL_CUSTOM_WIDTH_PATH = 'rezolve_ic_button/ic_button_on_product_page/button_custom_width';
    public const PRODUCT_DETAIL_BUTTON_CORNERS_PATH = 'rezolve_ic_button/ic_button_on_product_page/button_corners';
    public const PRODUCT_DETAIL_BUTTON_COLOUR_PATH = 'rezolve_ic_button/ic_button_on_product_page/button_colour';
    public const PRODUCT_DETAIL_BUTTON_HEIGHT_PATH = 'rezolve_ic_button/ic_button_on_product_page/button_height';
    public const PRODUCT_DETAIL_BUTTON_STYLE_PATH = 'rezolve_ic_button/ic_button_on_product_page/button_style';
    public const PRODUCT_DETAIL_BUTTON_IMAGE_STYLE_PATH = 'rezolve_ic_button/ic_button_on_product_page/image_style';
    public const LISTING_PAGE_ACTIVE_PATH = 'rezolve_ic_button/ic_button_on_product_listing/enabled';
    public const LISTING_BUTTON_WIDTH_PATH = 'rezolve_ic_button/ic_button_on_product_listing/button_width';
    public const LISTING_CUSTOM_WIDTH_PATH = 'rezolve_ic_button/ic_button_on_product_listing/button_custom_width';
    public const LISTING_BUTTON_CORNERS_PATH = 'rezolve_ic_button/ic_button_on_product_listing/button_corners';
    public const LISTING_BUTTON_COLOUR_PATH = 'rezolve_ic_button/ic_button_on_product_listing/button_colour';
    public const LISTING_BUTTON_HEIGHT_PATH = 'rezolve_ic_button/ic_button_on_product_listing/button_height';
    public const LISTING_BUTTON_STYLE_PATH = 'rezolve_ic_button/ic_button_on_product_listing/button_style';
    public const LISTING_BUTTON_IMAGE_STYLE_PATH = 'rezolve_ic_button/ic_button_on_product_listing/image_style';

    /**
     * Data constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Defines is feature enabled.
     *
     * @param int $storeId
     * @return bool
     */
    public function isProductDetailEnabled(int $storeId): bool
    {
        return $this->isSetFlag(self::PRODUCT_DETAIL_PAGE_ACTIVE_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getMerchantIdValue(int $storeId): string
    {
        return $this->getValue(self::REZOLVE_MERCHANT_ID_PATH, $storeId) ?? '';
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getProductDetailButtonWidth(int $storeId): string
    {
        return $this->getValue(self::PRODUCT_DETAIL_BUTTON_WIDTH_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return int
     */
    public function getProductDetailCustomWidth(int $storeId): int
    {
        $value = $this->getValue(self::PRODUCT_DETAIL_CUSTOM_WIDTH_PATH, $storeId);
        if (is_numeric($value)) {
            return (int) $value;
        }
        return 0;
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getProductDetailButtonColour(int $storeId): string
    {
        return $this->getValue(self::PRODUCT_DETAIL_BUTTON_COLOUR_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getProductDetailButtonCorners(int $storeId): string
    {
        return $this->getValue(self::PRODUCT_DETAIL_BUTTON_CORNERS_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getProductDetailButtonHeight(int $storeId): string
    {
        return $this->getValue(self::PRODUCT_DETAIL_BUTTON_HEIGHT_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getProductDetailButtonStyle(int $storeId): string
    {
        return $this->getValue(self::PRODUCT_DETAIL_BUTTON_STYLE_PATH, $storeId) ?? '';
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getProductDetailButtonImageStyle(int $storeId): string
    {
        return $this->getValue(self::PRODUCT_DETAIL_BUTTON_IMAGE_STYLE_PATH, $storeId) ?? '';
    }

    /**
     * Defines is listing feature enabled.
     *
     * @param int $storeId
     * @return bool
     */
    public function isProductListingEnabled(int $storeId): bool
    {
        return $this->isSetFlag(self::LISTING_PAGE_ACTIVE_PATH, $storeId);
    }


    /**
     * @param int $storeId
     * @return string
     */
    public function getListingButtonWidth(int $storeId): string
    {
        return $this->getValue(self::LISTING_BUTTON_WIDTH_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return int
     */
    public function getListingCustomWidth(int $storeId): int
    {
        $value = $this->getValue(self::LISTING_CUSTOM_WIDTH_PATH, $storeId);
        if (is_numeric($value)) {
            return (int) $value;
        }
        return 0;
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getListingButtonColour(int $storeId): string
    {
        return $this->getValue(self::LISTING_BUTTON_COLOUR_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getListingButtonCorners(int $storeId): string
    {
        return $this->getValue(self::LISTING_BUTTON_CORNERS_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getListingButtonHeight(int $storeId): string
    {
        return $this->getValue(self::LISTING_BUTTON_HEIGHT_PATH, $storeId);
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getListingButtonStyle(int $storeId): string
    {
        return $this->getValue(self::LISTING_BUTTON_STYLE_PATH, $storeId) ?? '';
    }

    /**
     * @param int $storeId
     * @return string
     */
    public function getListingButtonImageStyle(int $storeId): string
    {
        return $this->getValue(self::LISTING_BUTTON_IMAGE_STYLE_PATH, $storeId) ?? '';
    }

    /**
     * @return array
     */
    public function getAllowedProductTypes(): array
    {
        return [
            \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE,
            \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE,
        ];
    }

    /**
     * Fetches value from generic config.
     *
     * @param string $path
     * @param int|null $storeId
     * @return mixed
     */
    private function getValue(string $path, int $storeId = null): ?string
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Fetches switcher value from generic config.
     *
     * @param string $path
     * @param int $storeId
     * @return bool
     */
    private function isSetFlag(string $path, int $storeId): bool
    {
        return $this->scopeConfig->isSetFlag(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
