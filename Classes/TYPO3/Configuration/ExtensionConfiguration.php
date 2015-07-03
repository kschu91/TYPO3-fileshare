<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Kevin Schu <kevin.schu@innovations4web.de>, innovations4web
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace I4W\Fileshare\TYPO3\Configuration;

use TYPO3\CMS\Core\SingletonInterface;

/**
 * @package I4W\Fileshare\TYPO3\Configuration
 */
class ExtensionConfiguration implements SingletonInterface
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * load configuration
     */
    public function __construct()
    {
        $this->configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fileshare']);
    }

    /**
     * @return integer
     */
    public function getPageId()
    {
        return (integer)$this->get('pageId');
    }

    /**
     * @param string $key
     * @return string
     */
    private function get($key)
    {
        return $this->configuration[$key];
    }
}