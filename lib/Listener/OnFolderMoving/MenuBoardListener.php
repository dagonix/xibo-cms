<?php
/**
 * Copyright (C) 2022 Xibo Signage Ltd
 *
 * Xibo - Digital Signage - http://www.xibo.org.uk
 *
 * This file is part of Xibo.
 *
 * Xibo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Xibo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Xibo.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Xibo\Listener\OnFolderMoving;

use Xibo\Event\FolderMovingEvent;
use Xibo\Factory\MenuBoardFactory;

class MenuBoardListener
{
    /**
     * @var MenuBoardFactory
     */
    private $menuBoardFactory;

    public function __construct(MenuBoardFactory $menuBoardFactory)
    {
        $this->menuBoardFactory = $menuBoardFactory;
    }

    public function __invoke(FolderMovingEvent $event)
    {
        $folder = $event->getFolder();
        $newFolder = $event->getNewFolder();

        foreach ($this->menuBoardFactory->getbyFolderId($folder->getId()) as $menuBoard) {
            $menuBoard->folderId = $newFolder->getId();
            $menuBoard->permissionsFolderId = $newFolder->getPermissionFolderIdOrThis();
            $menuBoard->updateFolders('menu_board');
        }
    }
}
