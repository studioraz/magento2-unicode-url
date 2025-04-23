<?php

namespace SR\UnicodeUrl\Plugin\Model;

use Magento\Framework\Filter\FilterManager;

class Category
{
    private $filter; // https://php.watch/versions/8.2/dynamic-properties-deprecated
    
    public function __construct(
        private FilterManager $filter
    ) {

    }

    public function aroundFormatUrlKey(
        \Magento\Catalog\Model\Category $subject,
        callable $proceed,
                                        $str
    ) {
        return $this->filter->translitUrlCategory($str);
    }
}
