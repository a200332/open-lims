<?php
/**
 * @package project
 * @version 0.4.0.0
 * @author Roman Konertz <konertz@open-lims.org>
 * @copyright (c) 2008-2016 by Roman Konertz
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
 * Project Log Access Class
 * @package project
 */
class ProjectLog_Access
{
	const PROJECT_LOG_PK_SEQUENCE = 'core_project_log_id_seq';

	private $log_id;

	private $project_id;
	private $datetime;
	private $content;
	private $cancel;
	private $important;
	private $owner_id;

	/**
	 * @param integer $log_id
	 */
	function __construct($log_id)
	{
		global $db;
			
		if ($log_id == null)
		{
			$this->log_id = null;
		}
		else
		{
			$sql = "SELECT * FROM ".constant("PROJECT_LOG_TABLE")." WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $log_id, PDO::PARAM_INT);
			$db->execute($res);	
			$data = $db->fetch($res);
			
			if ($data['id'])
			{
				$this->log_id 			= $log_id;
				
				$this->project_id		= $data['project_id'];
				$this->datetime			= $data['datetime'];
				$this->content			= $data['content'];
				$this->owner_id			= $data['owner_id'];
				$this->action_checksum	= $data['action_checksum'];
				$this->cancel			= $data['cancel'];
				$this->important		= $data['important'];
			}
			else
			{
				$this->log_id = null;
			}
		}
	}
	
	function __destruct()
	{
		if ($this->log_id)
		{
			unset($this->log_id);
			unset($this->project_id);
			unset($this->datetime);
			unset($this->content);
			unset($this->cancel);
			unset($this->important);
			unset($this->owner_id);
			unset($this->action_checksum);
		}
	}
	
	/**
	 * @param integer $project_id
	 * @param string $content
	 * @param bool $cancal
	 * @param bool $important
	 * @param integer $owner_id
	 * @param string $action_checksum
	 * @return integer
	 */
	public function create($project_id, $content, $cancel, $important, $owner_id)
	{
		global $db;
		
		if (is_numeric($project_id) and $owner_id)
		{
			$datetime = date("Y-m-d H:i:s");
			
			$sql_write = "INSERT INTO ".constant("PROJECT_LOG_TABLE")." (id, project_id, datetime, content, cancel, important, owner_id) " .
					"VALUES (nextval('".self::PROJECT_LOG_PK_SEQUENCE."'::regclass), :project_id, :datetime, :content, :cancel, :important, :owner_id)";
			
			$res_write = $db->prepare($sql_write);
			$db->bind_value($res_write, ":project_id", $project_id, PDO::PARAM_INT);
			$db->bind_value($res_write, ":datetime", $datetime, PDO::PARAM_STR);
			$db->bind_value($res_write, ":cancel", $cancel, PDO::PARAM_BOOL);
			$db->bind_value($res_write, ":important", $important, PDO::PARAM_BOOL);
			$db->bind_value($res_write, ":owner_id", $owner_id, PDO::PARAM_INT);
						
			if (isset($content))
			{
				$db->bind_value($res_write, ":content", $content, PDO::PARAM_STR);
			}
			else
			{
				$db->bind_value($res_write, ":content", null, PDO::PARAM_NULL);
			}
			
			$db->execute($res_write);
			
			if ($db->row_count($res_write) == 1)
			{
				$sql_read = "SELECT id FROM ".constant("PROJECT_LOG_TABLE")." WHERE id = currval('".self::PROJECT_LOG_PK_SEQUENCE."'::regclass)";
				$res_read = $db->prepare($sql_read);
				$db->execute($res_read);
				$data_read = $db->fetch($res_read);
				
				self::__construct($data_read['id']);
				
				return $data_read['id'];
			}
			else
			{
				return null;
			}	
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return bool
	 */
	public function delete() 
	{
		global $db;
		
		if ($this->log_id)
		{
			$tmp_log_id = $this->log_id;
			
			$this->__destruct();
						
			$sql = "DELETE FROM ".constant("PROJECT_LOG_TABLE")." WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $tmp_log_id, PDO::PARAM_INT);
			$db->execute($res);
			
			if ($db->row_count($res) == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;	
		}
	}
	
	/**
	 * @return integer
	 */
	public function get_project_id()
	{
		if ($this->project_id)
		{
			return $this->project_id;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return string
	 */
	public function get_datetime() {
		if ($this->datetime) {
			return $this->datetime;
		}else{
			return null;
		}
	}
	
	/**
	 * @return string
	 */
	public function get_content()
	{
		if ($this->content)
		{
			return $this->content;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return bool
	 */
	public function get_cancel() {
		if (isset($this->cancel)) {
			return $this->cancel;
		}else{
			return false;
		}
	}
	
	/**
	 * @return bool
	 */
	public function get_important()
	{
		if (isset($this->important))
		{
			return $this->important;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @return integer
	 */
	public function get_owner_id()
	{
		if ($this->owner_id)
		{
			return $this->owner_id;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @param integer $project_id
	 * @return bool
	 */
	public function set_project_id($project_id)
	{	
		global $db;
		
		if ($this->log_id and is_numeric($project_id))
		{
			$sql = "UPDATE ".constant("PROJECT_LOG_TABLE")." SET project_id = :project_id WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->log_id, PDO::PARAM_INT);
			$db->bind_value($res, ":project_id", $project_id, PDO::PARAM_INT);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->project_id = $project_id;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}	
	}
	
	/**
	 * @param string $datetime
	 * @return bool
	 */
	public function set_datetime($datetime)
	{
		global $db;

		if ($this->log_id and $datetime)
		{
			$sql = "UPDATE ".constant("PROJECT_LOG_TABLE")." SET datetime = :datetime WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->log_id, PDO::PARAM_INT);
			$db->bind_value($res, ":datetime", $datetime, PDO::PARAM_STR);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->datetime = $datetime;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}	
	}
	
	/**
	 * @param string $content
	 * @return bool
	 */
	public function set_content($content)
	{
		global $db;
	
		if ($this->log_id and $content)
		{
			$sql = "UPDATE ".constant("PROJECT_LOG_TABLE")." SET content = :content WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->log_id, PDO::PARAM_INT);
			$db->bind_value($res, ":content", $content, PDO::PARAM_STR);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->content = $content;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @param bool $cancel
	 * @return bool
	 */
	public function set_cancel($cancel)
	{
		global $db;

		if ($this->log_id and isset($cancel))
		{
			$sql = "UPDATE ".constant("PROJECT_LOG_TABLE")." SET cancel = :cancel WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->log_id, PDO::PARAM_INT);
			$db->bind_value($res, ":cancel", $cancel, PDO::PARAM_BOOL);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->cancel = $cancel;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @param bool $important
	 * @return bool
	 */
	public function set_important($important)
	{
		global $db;

		if ($this->log_id and isset($important))
		{
			$sql = "UPDATE ".constant("PROJECT_LOG_TABLE")." SET important = :important WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->log_id, PDO::PARAM_INT);
			$db->bind_value($res, ":important", $important, PDO::PARAM_BOOL);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->important = $important;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}	
	}
	
	/**
	 * @param integer $owner_id
	 * @return bool
	 */	
	public function set_owner_id($owner_id)
	{
		global $db;

		if ($this->log_id and is_numeric($owner_id))
		{
			$sql = "UPDATE ".constant("PROJECT_LOG_TABLE")." SET owner_id = :owner_id WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->log_id, PDO::PARAM_INT);
			$db->bind_value($res, ":owner_id", $owner_id, PDO::PARAM_INT);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->owner_id = $owner_id;
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	 * @param integer $id
	 * @return bool
	 */
	public static function exist_id($id)
	{
		global $db;

		if (is_numeric($id))
		{
			$sql = "SELECT id FROM ".constant("PROJECT_LOG_TABLE")." WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $id, PDO::PARAM_INT);
			$db->execute($res);
			$data = $db->fetch($res);
			
			if ($data['id'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @param integer $project_id
	 * @return array
	 */
	public static function list_entries_by_project_id($project_id)
	{	
		global $db;

		if (is_numeric($project_id))
		{
			$return_array = array();
			
			$sql = "SELECT id FROM ".constant("PROJECT_LOG_TABLE")." WHERE project_id = :project_id ORDER BY datetime DESC, id DESC";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":project_id", $project_id, PDO::PARAM_INT);
			$db->execute($res);
			
			while ($data = $db->fetch($res))
			{
				array_push($return_array,$data['id']);
			}
			
			if (is_array($return_array))
			{
				return $return_array;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @param integer $owner_id
	 * @return array
	 */
	public static function list_entries_by_owner_id($owner_id)
	{
		global $db;
	
		if (is_numeric($owner_id))
		{
			$return_array = array();
			
			$sql = "SELECT id FROM ".constant("PROJECT_LOG_TABLE")." WHERE owner_id = :owner_id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":owner_id", $owner_id, PDO::PARAM_INT);
			$db->execute($res);
			
			while ($data = $db->fetch($res))
			{
				array_push($return_array,$data['id']);
			}
			
			if (is_array($return_array))
			{
				return $return_array;
			}
			else
			{
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return array
	 */
	public static function list_entries()
	{
		global $db;
				
		$return_array = array();
		
		$sql = "SELECT id FROM ".constant("PROJECT_LOG_TABLE")."";
		$res = $db->prepare($sql);
		$db->execute($res);
		
		while ($data = $db->fetch($res))
		{
			array_push($return_array,$data['id']);
		}
		
		if (is_array($return_array))
		{
			return $return_array;
		}
		else
		{
			return null;
		}
	}
	
}
?>
