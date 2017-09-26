<?php
/**
 * FullNextSearch - Full Text Search your Nextcloud.
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 * @copyright 2017
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 */

namespace OCA\FullNextSearch\Provider\Files\Service;


use OCA\FullNextSearch\Provider\Files\NextSearch\FilesDocument;
use OCA\FullNextSearch\Service\MiscService;
use OCP\Files\FileInfo;
use OCP\Files\Folder;
use OCP\Files\Node;

class FilesService {

	/** @var MiscService */
	private $miscService;


	/**
	 * ProviderService constructor.
	 *
	 * @param MiscService $miscService
	 */
	function __construct(MiscService $miscService) {
		$this->miscService = $miscService;
	}


	/**
	 * @param $userId
	 *
	 * @return FilesDocument[]
	 */
	public function getFiles($userId) {
		/** @var Folder $root */
		$root = \OC::$server->getUserFolder($userId)
							->get('/');

		$result = $this->getFilesFromDirectory($root);

		return $result;
	}


	/**
	 * @param Folder $node
	 *
	 * @return FilesDocument[]
	 */
	public function getFilesFromDirectory(Folder $node) {
		$files = $node->getDirectoryListing();

		$result = [];
		foreach ($files as $file) {

			$result[] = $this->generateFilesIndexFromFile($file);
			if ($file->getType() === FileInfo::TYPE_FOLDER) {
				/** @var $file Folder */
				$result = array_merge($result, $this->getFilesFromDirectory($file));
			}
		}

		return $result;
	}


	/**
	 * @param Node $file
	 *
	 * @return FilesDocument
	 */
	private function generateFilesIndexFromFile(Node $file) {

		$index = new FilesDocument($file->getId());
		$index->setType($file->getType())
			  ->setPath($file->getInternalPath())
			  ->setFilename($file->getName());

		return $index;
	}

	/**
	 * @param FilesDocument[] $files
	 *
	 * @return FilesDocument[]
	 */
	public function indexFiles($files) {

		$index = [];
		foreach ($files as $file) {
			if ($file->getType() === FileInfo::TYPE_FOLDER) {
				continue;
			}

//			echo $file->getId() . ' ' . $file->getPath() . "\n";
			$index[] = $file;
		}

		return $index;
	}


}