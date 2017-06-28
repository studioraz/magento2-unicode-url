<?php

namespace SR\UnicodeUrl\Plugin\Model;

class Category
{
    public function __construct(
        \Magento\Framework\Filter\FilterManager $filter
    ) {
        $this->filter = $filter;
    }

    public function aroundFormatUrlKey(
        \Magento\Catalog\Model\Category $subject,
        callable $proceed,
        $str
    ) {
        return $this->filter->translitUrlCategory($str);
    }
}
