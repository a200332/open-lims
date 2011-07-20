<?php
/**
 * @package project
 * @version 0.4.0.0
 * @author Roman Quiring
 * @copyright (c) 2008-2010 by Roman Quiring
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
$GLOBALS['autoload_prefix'] = "../";
require_once("../../base/ajax.php");

/**
 * Project AJAX IO Class
 * @package project
 */
class ProjectAjax extends Ajax
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	private function get_name()
	{
		echo "Project";
	}
	
	/**
	 * Should return HTML of Menu
	 */
	private function get_html()
	{
		$template = new Template("../../../../template/projects/navigation/left.html");
		
		$template->output();
	}
	
	
	public function get_array()
	{
	global $session;
	
		$return_array = array();
								
		$project_array = Project::list_user_related_projects(null,false);
		
		if (is_array($project_array) and count($project_array) >= 1)
		{
			$counter = 0;
			
			foreach($project_array as $key => $value)
			{
				$project = new Project($value);

				$return_array[$counter][0] = 0;
				$return_array[$counter][1] = $value;
				$return_array[$counter][2] = $project->get_name();
				$return_array[$counter][3] = "project.png";
				$return_array[$counter][4] = true; // Permission
				$return_array[$counter][5] = true;
				$return_array[$counter][6] = ""; //link
				$return_array[$counter][7] = false; //open
				
				$counter++;
			}
			
		echo json_encode($return_array);
	}
	}
	
	public function set_array($array)
	{
		$var = json_decode($array);
		echo count($var);
	}
	
	public function get_children($id)
	{
		$return_array = array();
		$project = new Project($_GET[project_id]);
		$project_array = $project->list_project_related_projects();
		if (is_array($project_array) and count($project_array ) >= 1)
		{
			$counter = 0;
			
			foreach($project_array as $key => $value)
			{
				$project = new Project($value);
					
				$return_array[$counter][0] = -1;
				$return_array[$counter][1] = $value;
				$return_array[$counter][2] = $project->get_name();
				$return_array[$counter][3] = "project.png";
				$return_array[$counter][4] = true; // Permission
				$return_array[$counter][5] = true;
				$return_array[$counter][6] = ""; //link
				$return_array[$counter][7] = false; //open
				$counter++;
			}
			echo json_encode($return_array);
		}
	}
	
	public function method_handler()
	{
		global $session;
		
		if ($session->is_valid())
		{
			switch($_GET[run]):	
				case "get_name":
					$this->get_name();
				break;
				
				case "get_html":
					$this->get_html();
				break;
				
				case "get_array":
					$this->get_array();
				break;
				
				case "set_array":
					$this->set_array($_POST['array']);
				break;
				
				case "get_children":
					$this->get_children($_GET['id']);
				break;
			endswitch;
		}
	}
}

$organisation_unit_ajax = new ProjectAjax;
$organisation_unit_ajax->method_handler();

?>