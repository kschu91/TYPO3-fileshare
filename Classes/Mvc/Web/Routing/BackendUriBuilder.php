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

namespace I4W\Fileshare\Mvc\Web\Routing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

/**
 * @package I4W\Fileshare\TYPO3\UserFunctions
 */
class BackendUriBuilder extends UriBuilder
{
    /**
     * initialize dependencies
     */
    public function initializeObject()
    {
        /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj */
        $cObj = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
        $this->contentObject = $cObj;
    }

    /**
     * @param string $actionName Name of the action to be called
     * @param array $controllerArguments Additional query parameters. Will be "namespaced" and merged with $this->arguments.
     * @param string $controllerName Name of the target controller. If not set, current ControllerName is used.
     * @param string $extensionName Name of the target extension, without underscores. If not set, current ExtensionName is used.
     * @param string $pluginName Name of the target plugin. If not set, current PluginName is used.
     * @return string the rendered URI
     * @api
     * @see \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder::uriFor()
     */
    public function uriFor(
        $actionName = null,
        $controllerArguments = array(),
        $controllerName = null,
        $extensionName = null,
        $pluginName = null
    ) {
        if ($actionName !== null) {
            $controllerArguments['action'] = $actionName;
        }
        if ($controllerName !== null) {
            $controllerArguments['controller'] = $controllerName;
        } else {
            $controllerArguments['controller'] = $this->request->getControllerName();
        }
        if ($extensionName === null) {
            $extensionName = $this->request->getControllerExtensionName();
        }
        if ($pluginName === null && $this->environmentService->isEnvironmentInFrontendMode()) {
            $pluginName = $this->extensionService->getPluginNameByAction(
                $extensionName,
                $controllerArguments['controller'],
                $controllerArguments['action']
            );
        }
        if ($pluginName === null) {
            $pluginName = $this->request->getPluginName();
        }
        if ($this->environmentService->isEnvironmentInFrontendMode() && $this->configurationManager->isFeatureEnabled(
                'skipDefaultArguments'
            )
        ) {
            $controllerArguments = $this->removeDefaultControllerAndAction(
                $controllerArguments,
                $extensionName,
                $pluginName
            );
        }
        if ($this->targetPageUid === null && $this->environmentService->isEnvironmentInFrontendMode()) {
            $this->targetPageUid = $this->extensionService->getTargetPidByPlugin($extensionName, $pluginName);
        }
        if ($this->format !== '') {
            $controllerArguments['format'] = $this->format;
        }
        if ($this->argumentPrefix !== null) {
            $prefixedControllerArguments = array($this->argumentPrefix => $controllerArguments);
        } else {
            $pluginNamespace = $this->extensionService->getPluginNamespace($extensionName, $pluginName);
            $prefixedControllerArguments = array($pluginNamespace => $controllerArguments);
        }
        \TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
            $this->arguments,
            $prefixedControllerArguments
        );
    }
}