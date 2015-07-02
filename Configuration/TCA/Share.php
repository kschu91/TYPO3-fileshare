<?php

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$TCA['tx_fileshare_domain_model_share'] = array(
    'ctrl' => $TCA['tx_fileshare_domain_model_share']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'hidden,label,token',
    ),
    'types' => array(
        '1' => array('showitem' => 'hidden;;1;;1-1-1, label, token, storage, folder'),
    ),
    'columns' => array(
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        ),
        'label' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:fileshare/Resources/Private/Language/locallang_db.xml:tx_fileshare_domain_model_share.label',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'token' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:fileshare/Resources/Private/Language/locallang_db.xml:tx_fileshare_domain_model_share.token',
            'config' => array(
                'type' => 'user',
                'size' => 30,
                'userFunc' => 'I4W\\Fileshare\\TYPO3\\UserFunctions\\Token->renderTokenField',
            ),
        ),
        'storage' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:lang/locallang_tca.xlf:sys_file_collection.storage',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0)
                ),
                'foreign_table' => 'sys_file_storage',
                'foreign_table_where' => 'ORDER BY sys_file_storage.name',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'eval' => 'required',
            )
        ),
        'folder' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:lang/locallang_tca.xlf:sys_file_collection.folder',
            'config' => array(
                'type' => 'select',
                'items' => array(),
                'minitems' => 1,
                'maxitems' => 1,
                'eval' => 'required',
                'itemsProcFunc' => 'typo3/sysext/core/Classes/Resource/Service/UserFileMountService.php:TYPO3\CMS\Core\Resource\Service\UserFileMountService->renderTceformsSelectDropdown',
            )
        ),
    ),
);