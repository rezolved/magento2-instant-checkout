<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ButtonHeight implements OptionSourceInterface
{
    public const VALUE_HEIGHT_LARGE = 'height-large';
    public const VALUE_HEIGHT_SMALL = 'height-small';

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::VALUE_HEIGHT_LARGE,
                'label'=> __('Height Large')
            ],
            [
                'value' => self::VALUE_HEIGHT_SMALL,
                'label' => __('Height Small')
            ]
        ];
    }
}
