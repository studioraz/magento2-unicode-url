<?php

namespace SR\UnicodeUrl\Plugin\Model;

use Magento\Framework\Filter\FilterManager;

class Category
{
    private FilterManager $filter;

    public function __construct(FilterManager $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Plugin per modificare il metodo formatUrlKey nella categoria
     *
     * @param Category $subject
     * @param callable $proceed
     * @param string $str
     * @return string
     */
    public function aroundFormatUrlKey(
        \Magento\Catalog\Model\Category $subject,
        callable $proceed,
        string $str
    ): string {
        return $this->filter->translitUrlCategory($str);
    }
}
