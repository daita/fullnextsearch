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

namespace OCA\FullNextSearch\Service;

use OCA\FullNextSearch\Model\DocumentsAccess;
use OCA\FullNextSearch\NextSearchDocument;

class SearchService {


	/** @var ConfigService */
	private $configService;

	/** @var ProviderService */
	private $providerService;

	/** @var PlatformService */
	private $platformService;

	/** @var MiscService */
	private $miscService;


	/**
	 * IndexService constructor.
	 *
	 * @param ConfigService $configService
	 * @param ProviderService $providerService
	 * @param PlatformService $platformService
	 * @param MiscService $miscService
	 */
	function __construct(
		ConfigService $configService, ProviderService $providerService, PlatformService $platformService,
		MiscService $miscService
	) {
		$this->configService = $configService;
		$this->providerService = $providerService;
		$this->platformService = $platformService;
		$this->miscService = $miscService;
	}

//				echo memory_get_usage() . "\n";


	/**
	 * @param string $providerId
	 * @param string $userId
	 * @param string $search
	 *
	 * @return NextSearchDocument[]
	 */
	public function search($providerId, $userId, $search) {
		$providers = $this->providerService->getFilteredProviders($providerId);
		$platform = $this->platformService->getPlatform();

		$access = $this->getDocumentsAccessFromUser($userId);
		$result = [];
		foreach ($providers AS $provider) {
			$result = array_merge($result, $platform->search($provider, $access, $search));
		}

		return $result;
	}


	/**
	 * @param $userId
	 *
	 * @return DocumentsAccess
	 */
	private function getDocumentsAccessFromUser($userId) {
		$rights = new DocumentsAccess($userId);

		$rights->setCircles(['qwe234drf']);
		$rights->setGroups(['test']);

		return $rights;
	}


}