<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'I4W.' . $_EXTKEY,
    'downloads',
    array('Share' => 'index,list,download', '')
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['fileshare'] = 'EXT:fileshare/Configuration/Code/RealUrl.php:RealUrlConfig->realUrlConfig';