<?php

namespace SR\UnicodeUrl\Plugin\Product;

class Url
{
    public function __construct(
        \Magento\Framework\Filter\FilterManager $filter
    )
    {
        $this->filter = $filter;
    }

    public function aroundFormatUrlKey(
        \Magento\Catalog\Model\Product\Url $subject,
        callable $proceed,
        $str
    ) {
        return $this->filter->translitUrlProduct($str);
    }
}