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
     * @param string|null $str
     * @return string
     */
    public function aroundFormatUrlKey(
        ProductUrl $subject,
        callable $proceed,
        ?string $str = null
    ): string {
        if ($str === null || trim($str) === '') {
            return ''; // Oppure un valore predefinito, come 'default-url-key'
        }

        return $this->filter->translitUrlProduct($str);
    }
}
