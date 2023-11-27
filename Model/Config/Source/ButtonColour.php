<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ButtonColour implements OptionSourceInterface
{
    public const VALUE_DARK = 'dark';
    public const VALUE_LIGHT= 'light';

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::VALUE_DARK,
                'label'=> __('Dark')
            ],
            [
                'value' => self::VALUE_LIGHT,
                'label' => __('Light')
            ]
        ];
    }
}
