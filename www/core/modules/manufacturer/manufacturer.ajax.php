<?php
/**
 * @package manufacturer
 * @version 0.4.0.0
 * @author Roman Konertz
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
 * 
 */
require_once("../base/ajax.php");

/**
 * Manufacturer AJAX IO Class
 * @package manufacturer
 */
class ManufacturerAjax extends Ajax
{
	function __construct()
	{
		parent::__construct();
	}

	public function exist_name($name)
	{
		if (Manufacturer::exist_name($name))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	public function add_entry($name)
	{
		if ($name)
		{
			$manufacturer = new Manufacturer(null);
			if ($manufacturer->create($name) == true)
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
		else
		{
			echo 0;
		}
	}
	
	public function get_number_of_entries($string)
	{
		echo Manufacturer::count_entries($string);
	}
	
	public function get_name($id)
	{
		if (is_numeric($id))
		{
			$manufacturer = new Manufacturer($id);
			echo $manufacturer->get_name();
		}
	}
	
	public function get_next_entries($number_of_entries, $start_entry, $start_string)
	{
		$manufacturer_array = Manufacturer::list_manufacturers($number_of_entries, $start_entry, $start_string);
				
		if (is_array($manufacturer_array) and count($manufacturer_array) >= 1)
		{
			$content_array = array();
			$counter = 0;
			
			$template = new Template("../../../languages/en-gb/template/manufacturer/ajax/dialog_list.html");
		
			foreach($manufacturer_array as $key => $value)
			{
				if ($counter%2)
				{
					$content_array[$counter][style] = "background-color: white;";
				}
				else
				{
					$content_array[$counter][style] = "background-color: #D0D0D0;";	
				}
				$content_array[$counter][id] = $value[id];
				$content_array[$counter][name] = $value[name];
				$counter++;
			}

			$template->set_var("manufacturer", $content_array);
			$template->output();
		}
	}
	
	public function method_handler()
	{
		global $session;
		
		if ($session->is_valid())
		{
			switch($_GET[run]):
	
				case "exist_name":
					$this->exist_name($_POST[name]);
				break;
				
				case "add_entry":
					$this->add_entry($_POST[name]);
				break;
			
				case "get_number_of_entries":
					$this->get_number_of_entries($_GET[string]);
				break;
				
				case "get_name":
					$this->get_name($_GET[id]);
				break;
				
				case "get_next_entries":
					$this->get_next_entries($_GET[number], $_GET[start], $_GET[string]);
				break;
				
				default:
				break;
			
			endswitch;
		}
	}
}

$manufacturer_ajax = new ManufacturerAjax;
$manufacturer_ajax->method_handler();
?>