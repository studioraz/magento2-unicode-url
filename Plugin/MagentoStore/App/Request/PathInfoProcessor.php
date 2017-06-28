<?php

namespace SR\UnicodeUrl\Plugin\MagentoStore\App\Request;

class PathInfoProcessor
{
    /**
     *
     * Handle UTF-8 URL keys before app resolve the path info
     *
     * @param \Magento\Store\App\Request\PathInfoProcessor $subject
     * @param \Magento\Framework\App\RequestInterface $request
     * @param $pathInfo
     * @return array
     */
    public function beforeProcess(
        \Magento\Store\App\Request\PathInfoProcessor $subject,
        \Magento\Framework\App\RequestInterface $request,
        $pathInfo
    )
    {
        // handle UTF-8 url keys
        $pathInfo = urldecode($pathInfo);

        // return the modified parameters
        return array(
            $request,
            $pathInfo
        );
    }
}