<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Kevin Schu <kevin.schu@innovations4web.de>
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

namespace I4W\Fileshare\TYPO3\UserFunctions;

use I4W\Fileshare\Mvc\Web\Routing\BackendUriBuilder;
use I4W\Fileshare\TYPO3\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Backend\Form\FormEngine;
use TYPO3\CMS\Core\TimeTracker\TimeTracker;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * @package I4W\Fileshare\TYPO3\UserFunctions
 */
class LinkGeneration
{
    /**
     * @var BackendUriBuilder
     */
    private $uriBuilder;

    /**
     * @var ExtensionConfiguration
     */
    private $configuration;

    /**
     * initialize dependencies an build TSFE
     */
    public function __construct()
    {
        $objectManager = new ObjectManager();
        /** @var BackendUriBuilder $viewHelper */
        $this->uriBuilder = $objectManager->get('I4W\\Fileshare\\Mvc\\Web\\Routing\\BackendUriBuilder');
        $this->configuration = $objectManager->get('I4W\\Fileshare\\TYPO3\\Configuration\\ExtensionConfiguration');

        $this->buildTSFE();
    }

    /**
     * @param array $PA
     * @param FormEngine $fObj
     * @return string
     */
    public function renderLink(array $PA, FormEngine $fObj)
    {
        if ($PA['row']['uid'] <= 0) {
            return '&nbsp;';
        }
        $this->uriBuilder->reset();
        $this->uriBuilder->setCreateAbsoluteUri(true);
        $this->uriBuilder->setTargetPageUid($this->configuration->getPageId());
        $this->uriBuilder->uriFor('list', array('share' => $PA['row']['uid']), 'Download', 'fileshare', 'downloads');
        $uri = $this->uriBuilder->buildFrontendUri();
        return '<a href="' . $uri . '" target="_blank">' . $uri . '</a>';
    }

    /**
     * @return void
     */
    private function buildTSFE()
    {
        if (false === $GLOBALS['TT'] instanceof TimeTracker) {
            $GLOBALS['TT'] = new TimeTracker;
            $GLOBALS['TT']->start();
        }
        $GLOBALS['TSFE'] = new TypoScriptFrontendController(
            $GLOBALS['TYPO3_CONF_VARS'],
            $this->configuration->getPageId(),
            '0',
            1,
            '',
            '',
            '',
            ''
        );
        $GLOBALS['TSFE']->initFEuser();
        $GLOBALS['TSFE']->fetch_the_id();
        $GLOBALS['TSFE']->getPageAndRootline();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->tmpl->getFileName_backPath = PATH_site;
        $GLOBALS['TSFE']->forceTemplateParsing = 1;
        $GLOBALS['TSFE']->getConfigArray();
    }
}