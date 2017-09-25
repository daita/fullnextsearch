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

namespace OCA\FullNextSearch;

use OCA\FullNextSearch\Exceptions\NoResultException;

interface INextSearchProvider {


	/**
	 * must returns a unique Id
	 *
	 * @return string
	 */
	public function getId();

	/**
	 * Init the search provider
	 */
	public function init();


	/**
	 * Close the search provider
	 */
	public function end();


	/**
	 * index everything related to index
	 *
	 * @param string $userId
	 * @param int $start
	 * @param int $size
	 *
	 * @return INextSearchIndex[]
	 * @throws NoResultException when no result are available.
	 */
	public function index($userId, $start, $size);


	/**
	 * searching string regarding userId
	 *
	 * @param string $userId
	 * @param string $needle
	 * @param int $start
	 * @param int $size
	 *
	 * @return INextSearchResult[]
	 * @throws NoResultException when no result are available.
	 */
	public function search($userId, $needle, $start, $size);

}