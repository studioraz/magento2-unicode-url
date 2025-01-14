<?php

namespace SR\UnicodeUrl\Plugin\Product;

use Magento\Framework\Filter\FilterManager;

class Url
{
    public function __construct(
        private FilterManager $filter
    )
    {

    }

    public function aroundFormatUrlKey(
        \Magento\Catalog\Model\Product\Url $subject,
        callable $proceed,
                                           $str
    ) {
        return $this->filter->translitUrlProduct($str);
    }
}
