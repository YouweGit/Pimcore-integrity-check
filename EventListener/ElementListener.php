<?php
/**
 * Integrity Check
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2018-2019 Youwe (https://www.youwe.nl)
 * @license    https://github.com/YouweGit/pimcore-integrity-check/blob/master/LICENSE.md     GNU General Public License version 3 (GPLv3)
 */

namespace IntegrityCheckBundle\EventListener;

use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\DocumentEvent;
use Pimcore\Event\Model\ElementEventInterface;


class ElementListener
{
    public function onPreDelete(ElementEventInterface $event)
    {
        if($event instanceof AssetEvent) {
            $element = $event->getAsset();
        } else if ($event instanceof DocumentEvent) {
            $element = $event->getDocument();
        } else if ($event instanceof DataObjectEvent) {
            $element = $event->getObject();
        }

        if (!$element) {
            return null
        }
        
        if ($element->getDependencies()->getRequiredByTotalCount() > 0) {
            throw new \RuntimeException('Sorry your object is linked to other objects');
        }
    }
}
