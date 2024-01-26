<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class   ButtonWidth implements OptionSourceInterface
{
    public const BUTTON_NAME = 'width';
    public const VALUE_NARROW = 'narrow';
    public const VALUE_WIDE = 'wide';
    public const CUSTOM_WIDTH = 'custom-width';

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::VALUE_NARROW,
                'label' => __('Narrow')
            ],
            [
                'value' => self::VALUE_WIDE,
                'label' => __('Wide')],
            [
                'value' => self::CUSTOM_WIDTH,
                'label' => __('Custom Width')
            ]
        ];
    }
}
