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

/**
 * @package I4W\Fileshare\TYPO3\Hooks
 */
class RealUrlConfig
{
    /**
     * @param $params
     * @param $pObj
     * @return array
     */
    public function realUrlConfig($params, &$pObj)
    {
        return array_merge_recursive(
            $params['config'],
            array(
                'postVarSets' => array(
                    '_DEFAULT' => array(
                        'share' => array(
                            array(
                                'GETvar' => 'tx_fileshare_downloads[controller]',
                                'noMatch' => 'bypass',
                            ),
                            array(
                                'GETvar' => 'tx_fileshare_downloads[action]',
                                'valueMap' => array(
                                    'list' => 'list',
                                    'download' => 'download',
                                    'download-all-files-as-zip' => 'downloadAll',
                                ),
                                'noMatch' => 'bypass',
                            ),
                            array(
                                'GETvar' => 'tx_fileshare_downloads[share]',
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
                            array(
                                'GETvar' => 'tx_fileshare_downloads[fileId]',
                                'lookUpTable' => array(
                                    'table' => 'sys_file',
                                    'id_field' => 'uid',
                                    'alias_field' => 'identifier_hash',
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
            )
        );
    }
}