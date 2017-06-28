<?php

namespace SR\UnicodeUrl\Filter;

/**
 * Judaica custom filter factory
 */
class Factory extends \Magento\Framework\Filter\AbstractFactory
{
    /**
     * Set of filters
     *
     * @var array
     */
    protected $invokableClasses = [
        'translitUrlCategory' => 'SR\UnicodeUrl\Filter\TranslitUrlCategory',
        'translitUrlProduct' => 'SR\UnicodeUrl\Filter\TranslitUrlProduct',
    ];
}
