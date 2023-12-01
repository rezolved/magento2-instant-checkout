<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Rezolve\InstantCheckout\Model\Config;

class HeaderCode extends Template
{
    public const BUTTON_PAGE_TYPE = 'button_page_type';

    /**
     * @param Context $context
     * @param Config $instantCheckoutConfig
     * @param array $data
     */
    public function __construct(
        protected Context $context,
        protected Config $instantCheckoutConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * The default environment value should be "production".
     * Other values are only used for development, testing, etc.
     *
     * @return string
     */
    public function getRezolveEnvironment(): string
    {
        $env = getenv(Config::ENVIRONMENT_KEY);
        return $env ?? 'production';
    }

    /**
     * @return string
     */
    public function getScriptUrl(): string
    {
        $env = $this->getRezolveEnvironment();
        switch ($env) {
            case 'development':
                $url = 'https://instantweb-cdn.dev.eu.rezolve.com/icv2-web-components/ic-web-components/ic-web-components.esm.js';
                break;
            case 'staging':
                $url = 'https://instantweb-cdn.stg.eu.rezolve.com/icv2-web-components/ic-web-components/ic-web-components.esm.js';
                break;
            case 'production':
                echo 'https://instantweb-cdn.eu.rezolve.com/icv2-web-components/ic-web-components/ic-web-components.esm.js';
                break;
            case 'demo':
                $url = 'https://instantweb-cdn.demo.eu.rezolve.com/icv2-web-components/ic-web-components/ic-web-components.esm.js';
                break;
            default:
                $url = '';
        }

        return $url ?? '';
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        $pageType = $this->getData(self::BUTTON_PAGE_TYPE);
        switch ($pageType) {
            case Config::BUTTON_PAGE_TYPE_DETAIL:
                $isEnabled = $this->instantCheckoutConfig->isProductDetailEnabled($this->getCurrentStoreId());
                break;
            case Config::BUTTON_PAGE_TYPE_LISTING:
                $isEnabled = $this->instantCheckoutConfig->isProductListingEnabled($this->getCurrentStoreId());
                break;
            default:
                $isEnabled = false;
        }

        return $isEnabled;
    }

    /**
     * Returns active store view identifier.
     *
     * @return int
     */
    private function getCurrentStoreId(): int
    {
        return (int) $this->_storeManager->getStore()->getId();
    }
}
