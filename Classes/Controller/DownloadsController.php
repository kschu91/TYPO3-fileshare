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

namespace I4W\Fileshare\Controller;

use I4W\Fileshare\Domain\Model\Share;
use I4W\Fileshare\Domain\Repository\ShareRepository;
use TYPO3\CMS\Core\Error\Http\PageNotFoundException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Web\Response;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * @package I4W\Fileshare\Controller
 */
class DownloadsController extends ActionController
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @var \I4W\Fileshare\Domain\Repository\ShareRepository
     */
    protected $shareRepository;

    /**
     * @var \TYPO3\CMS\Core\Resource\StorageRepository
     */
    protected $storageRepository;

    /**
     * @param \I4W\Fileshare\Domain\Repository\ShareRepository $shareRepository
     */
    public function injectShareRepository(\I4W\Fileshare\Domain\Repository\ShareRepository $shareRepository)
    {
        $this->shareRepository = $shareRepository;
    }

    /**
     * @param \TYPO3\CMS\Core\Resource\StorageRepository $storageRepository
     */
    public function injectStorageRepository(\TYPO3\CMS\Core\Resource\StorageRepository $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    /**
     * @return string
     */
    public function indexAction()
    {
        $this->view->assign('share', $this->shareRepository->findByUid(1));
    }

    /**
     * @param \I4W\Fileshare\Domain\Model\Share $share
     * @param integer $fileId
     * @throws \TYPO3\CMS\Core\Error\Http\PageNotFoundException
     * @return string
     */
    public function downloadAction(\I4W\Fileshare\Domain\Model\Share $share, $fileId)
    {
        foreach ($this->getFilesFromShare($share) as $file) {
            DebuggerUtility::var_dump($file);
            /** @var File $file */
            if ($file->getUid() == $fileId) {
                $this->response->setHeader('Cache-control', 'public', true);
                $this->response->setHeader('Content-Description', 'File transfer', true);
                $this->response->setHeader('Content-Disposition', 'attachment; filename=' . $file->getName(), true);
                $this->response->setHeader('Content-Type', $file->getMimeType(), true);
                $this->response->setHeader('Content-Transfer-Encoding', 'binary', true);
                $this->response->sendHeaders();
                ob_clean();
                echo $file->getContents();
                ob_flush();
                exit;
            }
        }
        throw new PageNotFoundException(
            sprintf('Could not find file with uid "%s" and share with uid "%s"', $fileId, $share->getUid()),
            1435839990
        );
    }

    /**
     * @param \I4W\Fileshare\Domain\Model\Share $share
     * @throws \TYPO3\CMS\Core\Error\Http\PageNotFoundException
     * @return string
     */
    public function listAction(\I4W\Fileshare\Domain\Model\Share $share)
    {
        $share = $this->shareRepository->findByUid($share->getUid());
        if (false === $share instanceof Share) {
            throw new PageNotFoundException(
                sprintf('Could not find  share with uid "%s"', $share->getUid()),
                1435840244
            );
        }
        $this->view->assign('files', $this->getFilesFromShare($share));
        $this->view->assign('share', $share);
    }

    /**
     * @param Share $share
     * @return \TYPO3\CMS\Core\Resource\File[]
     */
    private function getFilesFromShare(Share $share)
    {
        $storage = $this->storageRepository->findByUid($share->getStorage());
        $folder = $storage->getFolder($share->getFolder());
        return $folder->getFiles();
    }
}