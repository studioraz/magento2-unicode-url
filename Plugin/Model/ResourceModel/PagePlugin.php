<?php
/**
 * Copyright © 2019 Studio Raz. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace SR\UnicodeUrl\Plugin\Model\ResourceModel;

use Magento\Cms\Model\ResourceModel\Page;
use Magento\Framework\Model\AbstractModel;

/**
 * Class PagePlugin
 * @package SR\UnicodeUrl\Plugin\Model\ResourceModel
 */
class PagePlugin extends Page
{

    /**
     *  Check whether page identifier is valid
     *
     * @param AbstractModel $object
     * @return bool
     */
    protected function isValidPageIdentifier(AbstractModel $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)|(?:\p{Hebrew}+|\w+)+?$/iu', $object->getData('identifier'));
    }
}