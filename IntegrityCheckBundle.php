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

namespace IntegrityCheckBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class IntegrityCheckBundle extends AbstractPimcoreBundle
{
    public function getJsPaths()
    {
        return [
            '/bundles/integritycheck/js/pimcore/startup.js'
        ];
    }
}
