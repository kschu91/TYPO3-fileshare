<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'I4W.' . $_EXTKEY,
    'downloads',
    array('Downloads' => 'index,list,download'),
    array()
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['fileshare'] = 'EXT:fileshare/Classes/TYPO3/Hooks/RealUrlConfig.php:RealUrlConfig->realUrlConfig';