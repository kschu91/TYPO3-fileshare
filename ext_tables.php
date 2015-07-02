<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'I4W.'.$_EXTKEY,
    'downloads',
    'LLL:EXT:fileshare/Resources/Private/Language/locallang_db.xml:plugin.downloads'
);

$TCA['tx_fileshare_domain_model_share'] = array(
    'ctrl' => array(
        'title' => 'LLL:EXT:fileshare/Resources/Private/Language/locallang_db.xml:tx_fileshare_domain_model_share',
        'label' => 'label',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'delete' => 'deleted',
        'requestUpdate' => 'storage',
        'typeicon_column' => 'type',
        'typeicon_classes' => array(
            'default' => 'apps-filetree-folder-media',
            'folder' => 'apps-filetree-folder-media'
        ),
        'enablecolumns' => array (
            'disabled' => 'hidden',
        ),
        'dividers2tabs' => TRUE,
        'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Share.php',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/TCA/Share.gif'
    ),
);