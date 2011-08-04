<?php
/**
 * @package equipment
 * @version 0.4.0.0
 * @author Roman Konertz <konertz@open-lims.org>
 * @copyright (c) 2008-2011 by Roman Konertz
 * @license GPLv3
 * 
 * This file is part of Open-LIMS
 * Available at http://www.open-lims.org
 * 
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * version 3 of the License.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, see <http://www.gnu.org/licenses/>.
 */


/**
 * Equipment Management Interface
 * @package equipment
 */ 		 
interface EquipmentInterface
{
	function __construct($equipment_id);
	
	public function create($type_id, $owner_id);
	public function delete();
	public function get_type_id();
	public function get_owner_id();
	public function get_datetime();
	
	public static function list_entries_by_user_id($user_id);
	public static function list_entries_by_type_id($type_id);
}

?>
