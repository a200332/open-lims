<?php
/**
 * @package sample
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
 * Sample Access Class
 * @package sample
 */
class Sample_Access
{
	const SAMPLE_PK_SEQUENCE = 'core_samples_id_seq';
	
	private $sample_id;
	
	private $name;
	private $datetime;
	private $owner_id;
	private $template_id;
	private $available;
	private $deleted;
	private $comment;
	private $language_id;
	private $date_of_expiry;
	private $expiry_warning;
	private $manufacturer_id;
	
	/**
	 * @param integer $sample_id
	 */
	function __construct($sample_id)
	{
		global $db;
			
		if ($sample_id == null)
		{
			$this->sample_id = null;
		}
		else
		{
			$sql = "SELECT * FROM ".constant("SAMPLE_TABLE")." WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $sample_id, PDO::PARAM_INT);
			$db->execute($res);			
			$data = $db->fetch($res);
			
			if ($data['id'])
			{
				$this->sample_id 		= $sample_id;
				
				$this->name				= $data['name'];
				$this->datetime			= $data['datetime'];
				$this->owner_id			= $data['owner_id'];
				$this->template_id		= $data['template_id'];
				$this->comment			= $data['comment'];
				$this->language_id		= $data['language_id'];
				$this->date_of_expiry	= $data['date_of_expiry'];
				$this->expiry_warning	= $data['expiry_warning'];
				$this->manufacturer_id	= $data['manufacturer_id'];
				$this->deleted			= $data['deleted'];
				$this->available		= $data['available'];
			}
			else
			{
				$this->sample_id = null;
			}
		}
	}
	
	function __destruct()
	{
		if ($this->sample_id)
		{
			unset($this->sample_id);
	
			unset($this->name);
			unset($this->datetime);
			unset($this->owner_id);
			unset($this->template_id);
			unset($this->available);
			unset($this->deleted);
			unset($this->comment);
			unset($this->language_id);
			unset($this->date_of_expiry);
			unset($this->expiry_warning);
			unset($this->manufacturer_id);
		}
	}
	
	/**
	 * @param string $name
	 * @param integer $owner_id
	 * @param integer $template_id
	 * @param string $manufacturer_id
	 * @param string $comment
	 * @param integer $language_id
	 * @param string $date_of_expiry
	 * @param integer $expiry_warning
	 * @return integer
	 */
	public function create($name, $owner_id, $template_id, $manufacturer_id, $comment, $language_id, $date_of_expiry, $expiry_warning)
	{
		global $db;
		
		if ($name and is_numeric($owner_id) and is_numeric($template_id))
		{

			$datetime = date("Y-m-d H:i:s");
			
			$sql_write = "INSERT INTO ".constant("SAMPLE_TABLE")." (id, name, datetime, owner_id, template_id, available, deleted, comment, language_id, date_of_expiry, expiry_warning, manufacturer_id) " .
					"VALUES (nextval('".self::SAMPLE_PK_SEQUENCE."'::regclass), :name, :datetime, :owner_id, :template_id, 't', 'f', :comment, :language_id, :date_of_expiry, :expiry_warning, :manufacturer_id)";
			
			$res_write = $db->prepare($sql_write);
			$db->bind_value($res_write, ":name", $name, PDO::PARAM_STR);
			$db->bind_value($res_write, ":datetime", $datetime, PDO::PARAM_INT);
			$db->bind_value($res_write, ":owner_id", $owner_id, PDO::PARAM_INT);
			$db->bind_value($res_write, ":template_id", $template_id, PDO::PARAM_INT);
				
			if (isset($comment))
			{
				$db->bind_value($res_write, ":comment", $comment, PDO::PARAM_STR);
			}
			else
			{
				$db->bind_value($res_write, ":comment", null, PDO::PARAM_NULL);
			}
				
			if (is_numeric($language_id))
			{
				$db->bind_value($res_write, ":language_id", $language_id, PDO::PARAM_INT);
			}
			else
			{
				$db->bind_value($res_write, ":language_id", 1, PDO::PARAM_INT);
			}
				
			if (isset($date_of_expiry) and isset($expiry_warning))
			{
				$db->bind_value($res_write, ":date_of_expiry", $date_of_expiry, PDO::PARAM_STR);
				$db->bind_value($res_write, ":expiry_warning", $expiry_warning, PDO::PARAM_INT);
			}
			else
			{
				$db->bind_value($res_write, ":date_of_expiry", null, PDO::PARAM_NULL);
				$db->bind_value($res_write, ":expiry_warning", null, PDO::PARAM_NULL);
			}
			
			if (is_numeric($manufacturer_id))
			{
				$db->bind_value($res_write, ":manufacturer_id", $manufacturer_id, PDO::PARAM_INT);
			}
			else
			{
				$db->bind_value($res_write, ":manufacturer_id", null, PDO::PARAM_NULL);
			}
			
			$db->execute($res_write);
			
			if ($db->row_count($res_write) == 1)
			{
				$sql_read = "SELECT id FROM ".constant("SAMPLE_TABLE")." WHERE id = currval('".self::SAMPLE_PK_SEQUENCE."'::regclass)";
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
		
		if ($this->sample_id)
		{
			$tmp_sample_id = $this->sample_id;
			
			$this->__destruct();
						
			$sql = "DELETE FROM ".constant("SAMPLE_TABLE")." WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $tmp_sample_id, PDO::PARAM_INT);
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
	 * @return string
	 */
	public function get_name()
	{
		if ($this->name)
		{
			return $this->name;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return string
	 */
	public function get_datetime()
	{
		if ($this->datetime)
		{
			return $this->datetime;
		}
		else
		{
			return null;
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
	 * @return integer
	 */
	public function get_template_id()
	{
		if ($this->template_id)
		{
			return $this->template_id;
		}
		else
		{
			return null;
		}
	}
		
	/**
	 * @return bool
	 */
	public function get_deleted()
	{
		if (isset($this->deleted))
		{
			return $this->deleted;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @return bool
	 */
	public function get_available()
	{
		if (isset($this->available))
		{
			return $this->available;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * @return string
	 */
	public function get_comment()
	{
		if ($this->comment)
		{
			return $this->comment;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return integer
	 */
	public function get_language_id()
	{
		if ($this->language_id)
		{
			return $this->language_id;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return string
	 */
	public function get_date_of_expiry()
	{
		if ($this->date_of_expiry)
		{
			return $this->date_of_expiry;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return integer
	 */
	public function get_expiry_warning()
	{
		if ($this->expiry_warning)
		{
			return $this->expiry_warning;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @return integer
	 */
	public function get_manufacturer_id()
	{
		if ($this->manufacturer_id)
		{
			return $this->manufacturer_id;
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @param string $name
	 * @return bool
	 */
	public function set_name($name)
	{
		global $db;
			
		if ($this->sample_id and $name)
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET name = :name WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":name", $name, PDO::PARAM_STR);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->name = $name;
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
			
		if ($this->sample_id and $datetime)
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET datetime = :datetime WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
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
	 * @param integer $owner_id
	 * @return bool
	 */
	public function set_owner_id($owner_id)
	{
		global $db;
			
		if ($this->sample_id and is_numeric($owner_id))
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET owner_id = :owner_id WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
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
	 * @param integer $template_id
	 * @return bool
	 */
	public function set_template_id($template_id)
	{
		global $db;
			
		if ($this->sample_id and is_numeric($template_id))
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET template_id = :template_id WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":template_id", $template_id, PDO::PARAM_INT);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->template_id = $template_id;
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
	 * @param bool $available
	 * @return bool
	 */
	public function set_available($available)
	{
		global $db;
			
		if ($this->sample_id and isset($available))
		{		
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET available = :available WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":available", $available, PDO::PARAM_BOOL);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->available = $available;
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
	 * @param bool $deleted
	 * @return bool
	 */
	public function set_deleted($deleted)
	{
		global $db;
			
		if ($this->sample_id and isset($deleted))
		{			
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET deleted = :deleted WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":deleted", $deleted, PDO::PARAM_BOOL);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->deleted = $deleted;
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
	 * @param string $comment
	 * @return bool
	 */
	public function set_comment($comment)
	{
		global $db;
			
		if ($this->sample_id and $comment)
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET comment = :comment WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":comment", $comment, PDO::PARAM_STR);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->comment = $comment;
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
	 * @param string $string
	 * @param string $language_name
	 * @return bool
	 */
	public function set_comment_text_search_vector($string, $language_name)
	{
		global $db;
			
		if ($this->sample_id and $string)
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET comment_text_search_vector = to_tsvector(:language_name,:string) WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":string", $string, PDO::PARAM_STR);
			
			if (isset($language_name))
			{
				$db->bind_value($res, ":language_name", $language_name, PDO::PARAM_STR);
			}
			else
			{
				$db->bind_value($res, ":language_name", "default", PDO::PARAM_STR);
			}
			
			$db->execute($res);
			
			if ($db->row_count($res))
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
	 * @param integer $language_id
	 * @return bool
	 */
	public function set_language_id($language_id)
	{
		global $db;
			
		if ($this->sample_id and is_numeric($language_id))
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET language_id = :language_id WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":language_id", $language_id, PDO::PARAM_INT);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->language_id = $language_id;
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
	 * @param string $date_of_expiry
	 * @return bool
	 */
	public function set_date_of_expiry($date_of_expiry)
	{
		global $db;
			
		if ($this->sample_id and $date_of_expiry)
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET date_of_expiry = :date_of_expiry WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":date_of_expiry", $date_of_expiry, PDO::PARAM_STR);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->date_of_expiry = $date_of_expiry;
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
	 * @param integer $expiry_warning
	 * @return bool
	 */
	public function set_expiry_warning($expiry_warning)
	{
		global $db;
			
		if ($this->sample_id and is_numeric($expiry_warning))
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET expiry_warning = ':expiry_warning WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":expiry_warning", $expiry_warning, PDO::PARAM_INT);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->expiry_warning = $expiry_warning;
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
	 * @param integer $manufacturer_id
	 * @return bool
	 */
	public function set_manufacturer_id($manufacturer_id)
	{
		global $db;

		if ($this->sample_id and $manufacturer_id)
		{
			$sql = "UPDATE ".constant("SAMPLE_TABLE")." SET manufacturer_id = :manufacturer_id WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $this->sample_id, PDO::PARAM_INT);
			$db->bind_value($res, ":manufacturer_id", $manufacturer_id, PDO::PARAM_INT);
			$db->execute($res);
			
			if ($db->row_count($res))
			{
				$this->manufacturer_id = $manufacturer_id;
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
	 * @return array
	 */
	public static function list_entries_by_owner_id($owner_id)
	{
		global $db;
			
		if (is_numeric($owner_id))
		{
			$return_array = array();
			
			$sql = "SELECT id FROM ".constant("SAMPLE_TABLE")." WHERE owner_id = :owner_id";
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
	 * @param integer $template_id
	 * @return array
	 */
	public static function list_entries_by_template_id($template_id)
	{
		global $db;
			
		if (is_numeric($template_id))
		{
			$return_array = array();
			
			$sql = "SELECT id FROM ".constant("SAMPLE_TABLE")." WHERE template_id = :template_id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":template_id", $template_id, PDO::PARAM_INT);
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
		
		$sql = "SELECT id FROM ".constant("SAMPLE_TABLE")."";
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
	
	/**
	 * @param integer $sample_id
	 * @return bool
	 */
	public static function exist_sample_by_sample_id($sample_id)
	{
		global $db;
			
		if (is_numeric($sample_id))
		{
			
			$sql = "SELECT id FROM ".constant("SAMPLE_TABLE")." WHERE id = :id";
			$res = $db->prepare($sql);
			$db->bind_value($res, ":id", $sample_id, PDO::PARAM_INT);
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
		
}
?>
