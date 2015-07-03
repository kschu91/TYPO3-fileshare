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

namespace I4W\Fileshare\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * @package I4W\Fileshare\Domain\Repository
 */
class ShareRepository extends Repository
{
    /**
     * @return void
     */
    public function initializeObject()
    {
        /** @var $defaultQuerySettings Typo3QuerySettings */
        $defaultQuerySettings = $this->objectManager->get(
            'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings'
        );
        // don't add sys_language_uid constraint
        $defaultQuerySettings->setRespectSysLanguage(false);
        $defaultQuerySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }

    /**
     * @param string $token
     * @return \I4W\Fileshare\Domain\Model\Share
     */
    public function findByToken($token)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('token', $token));
        return $query->execute()->getFirst();
    }

    /**
     * @param integer $uid
     * @return \I4W\Fileshare\Domain\Model\Share
     */
    public function findByUid($uid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching($query->equals('uid', $uid));
        return $query->execute()->getFirst();
    }
}