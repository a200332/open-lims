<?php
/**
 * @package base
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
 * Base Wrapper Interface
 * @package base
 */ 		 
interface Base_WrapperInterface
{
	/**
     * Returns a list of log-entries
     * @param integer $type_id
     * @param string $order_by
     * @param string $order_method
     * @param integer $start
     * @param integer $end
     * @return array
     */
	public static function list_system_log($type_id, $order_by, $order_method, $start, $end);
	
	/**
     * Returns the number of log-entries
     * @param integer $type_id
     * @return integer
     */
	public static function count_list_system_log($type_id);
	
	/**
	 * @param integer $start
	 * @param integer $end
	 * @return array
	 */
	public static function list_base_module_navigation($start, $end);
	
	/**
	 * @return integer
	 */
	public static function count_base_module_navigation();
	
	/**
	 * @param string $order_by
	 * @param string $order_method
	 * @param integer $start
	 * @param integer $end
	 * @return array
	 */
	public static function list_base_module($order_by, $order_method, $start, $end);
	
	/**
	 * @return integer
	 */
	public static function count_base_module();
	
	/**
	 * @param string $order_by
	 * @param string $order_method
	 * @param integer $start
	 * @param integer $end
	 * @return array
	 */
	public static function list_base_include($order_by, $order_method, $start, $end);
	
	/**
	 * @return integer
	 */
	public static function count_base_include();
	
	/**
	 * @param string $order_by
	 * @param string $order_method
	 * @param integer $start
	 * @param integer $end
	 * @return array
	 */
	public static function list_languages($order_by, $order_method, $start, $end);
	
	/**
	 * @return integer
	 */
	public static function count_languages();
	
	/**
	 * @param string $order_by
	 * @param string $order_method
	 * @param integer $start
	 * @param integer $end
	 * @return array
	 */
	public static function list_timezones($order_by, $order_method, $start, $end);
	
	/**
	 * @todo implementation
	 * @return integer
	 */
	public static function count_timezones();
	
	/**
	 * @param string $order_by
	 * @param string $order_by
	 * @param integer $start
	 * @param integer $end
	 * @return array
	 */
	public static function list_paper_sizes($order_by, $order_method, $start, $end);
	
	/**
	 * @return integer
	 */
	public static function count_paper_sizes();
	
	/**
	 * @param string $order_by
	 * @param string $order_method
	 * @param integer $start
	 * @param integer $end
	 * @return array
	 */
	public static function list_measuring_units($order_by, $order_method, $start, $end);
	
	/**
	 * @return integer
	 */
	public static function count_measuring_units();
	
	/**
	 * @param string $order_by
	 * @param string $order_method
	 * @param integer $start
	 * @param integer $end
	 * @return array
	 */
	public static function list_currencies($order_by, $order_method, $start, $end);
	
	/**
	 * @return integer
	 */
	public static function count_currencies();
}
?>