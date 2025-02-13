<?php

namespace SR\UnicodeUrl\Plugin\Product;

use Magento\Framework\Filter\FilterManager;
use Magento\Catalog\Model\Product\Url as ProductUrl;

class Url
{
    private FilterManager $filter;

    public function __construct(FilterManager $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Plugin per modificare il metodo formatUrlKey nel prodotto
     *
     * @param ProductUrl $subject
     * @param callable $proceed
     * @param string $str
     * @return string
     */
    public function aroundFormatUrlKey(
        ProductUrl $subject,
        callable $proceed,
        string $str
    ): string {
        return $this->filter->translitUrlProduct($str);
    }
}
