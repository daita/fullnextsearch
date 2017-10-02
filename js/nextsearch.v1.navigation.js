/*
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

/** global: api */
/** global: search */


var nav = {

	displayResult: function (res) {

		if (Number(res.meta.size) < 1) {
			OCA.notification.onFail('Search returned no result');
			return;
		}

		var searchResult = res.result;

		for (var i = 0; i < searchResult.length; i++) {
			nav.displayProviderResult(searchResult[i]);
		}

		OCA.notification.onSuccess('Search returned ' + res.meta.size + ' result(s)');
	},


	displayResultFail: function () {
		console.log('failed !');
	},


	displayProviderResult: function (result) {
		console.log('>> ' + JSON.stringify(result));

	}


};
