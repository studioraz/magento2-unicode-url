<?php

namespace SR\UnicodeUrl\Plugin\Model;

use Magento\Framework\Filter\FilterManager;
use Magento\Catalog\Model\Category;

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
        Category $subject,
        callable $proceed,
        string $str
    ): string {
        return $this->filter->translitUrlCategory($str);
    }
}
