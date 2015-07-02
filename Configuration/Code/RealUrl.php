<?php
return array(
    'postVarSets' => array(
        '_DEFAULT' => array(
            'token' => array(
                array(
                    'GETvar' => 'tx_fileshare_downloads[controller]',
                    'noMatch' => 'bypass',
                ),
                array(
                    'GETvar' => 'tx_fileshare_downloads[action]',
                    'valueMap' => array(
                        'INDEX' => 'index',
                        'LIST' => 'list',
                    ),
                    'noMatch' => 'bypass',
                ),
                array(
                    'GETvar' => 'tx_fileshare_downloads[token]',
                    'lookUpTable' => array(
                        'table' => 'tx_fileshare_domain_model_share',
                        'id_field' => 'uid',
                        'alias_field' => 'token',
                        'addWhereClause' => ' AND deleted = 0 AND hidden = 0',
                        'useUniqueCache' => 1,
                        'useUniqueCache_conf' => array(
                            'strtolower' => 1,
                            'spaceCharacter' => '-',
                        ),
                    ),
                ),
            ),
        ),
    ),
);