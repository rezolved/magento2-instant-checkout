<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class InstalledVersionField extends Field
{
    public const INSTALLED_VERSION = '1.0.1';

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $element->setValue(self::INSTALLED_VERSION);

        return '<strong>'
            . $element->getEscapedValue()
            . '</strong> - [<a href="https://github.com/rezolved/magento2-instant-checkout/releases">'
            . 'View Releases'
            . '</a>]';
    }
}
