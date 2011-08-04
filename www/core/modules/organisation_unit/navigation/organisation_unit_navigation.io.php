<?php 
/**
 * @package organisation unit
 * @version 0.4.0.0
 * @author Roman Konertz <konertz@open-lims.org>
 * @author Roman Quiring <quiring@open-lims.org>
 * @copyright (c) 2008-2011 by Roman Konertz, Roman Quiring
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
 * Organisation Unit Navigation IO Class
 * @package organisation unit
 */
class OrganisationUnitNavigationIO
{	
	public static function get_active() 
	{
		return true;
	}
	
	public static function get_icon()
	{
		return "images/icons/organisation_unit.png";
	}
	
	public static function get_ajax_url()
	{
		return "core/modules/organisation_unit/navigation/organisation_unit_navigation.ajax.php";
	}
}

?>