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

use TYPO3\CMS\Backend\Form\FormEngine;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * @package I4W\Fileshare\TYPO3\UserFunctions
 */
class Token
{
    /**
     * @param array $PA
     * @param FormEngine $fObj
     * @return string
     */
    public function renderTokenField(array $PA, FormEngine $fObj)
    {
        $token = '&nbsp;';
        if (isset($PA['row']['uid']) && $PA['row']['uid'] > 0) {
            $token = $this->generateToken($PA);
            $PA['itemFormElValue'] = $token;
        }

        $formField = '<div style="overflow:hidden; width:614px;" class="t3-tceforms-fieldReadOnly" title="">';
        $formField .= '<span class="nobr">' . $token . '</span>';

        $formField .= '<input type="hidden" name="' . $PA['itemFormElName'] . '"';
        $formField .= ' value="' . htmlspecialchars($PA['itemFormElValue']) . '"';
        $formField .= ' onchange="' . htmlspecialchars(implode('', $PA['fieldChangeFunc'])) . '"';
        $formField .= $PA['onFocus'];
        $formField .= ' />';

        $formField .= '<span class="t3-icon t3-icon-status t3-icon-status-status t3-icon-status-readonly">&nbsp;</span>';
        $formField .= '</div>';
        return $formField;
    }

    /**
     * @param array $PA
     * @return string
     */
    private function generateToken(array $PA)
    {
        return sha1($PA['row']['uid'] . $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']);
    }
} 