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
 * Common IO Class
 * @package base
 */
class Error_IO
{
	private $exception;
	private $error_type;
	
	/**
	 * @param object $exception
	 * @param integer $module
	 * @param integer $layer
	 * @param integer $error_type
	 */
	function __construct($exception, $error_type, $module = null, $layer = null)
	{
		$this->exception = $exception;
		$this->error_type = $error_type;
	}
	
	public function display_error()
	{
		if ($this->error_type == 2)
		{
			$template = new Template("template/base/error/security_in_box.html");
		}
		else
		{
			$template = new Template("template/base/error/error_in_box.html");
		}	
		
		$error_message = $this->exception->getMessage();
		
		if ($error_message)
		{
			$template->set_var("error_msg", $error_message);
		}
		else
		{
			$template->set_var("error_msg", "A non-specific error occured");
		}

		$template->output();
	}
	
	/**
	 * @param string $message
	 */
	public static function fatal_error($message)
	{
		$template = new Template("template/login_header.html");
		$template->output();
		
		$template = new Template("template/base/error/fatal.html");
		$template->set_var("message", $message);
		$template->output();
	}
	
	/**
	 * @param string $message
	 */
	public static function security_out_of_box_error($message)
	{
		$template = new Template("template/login_header.html");
		$template->output();
		
		$template = new Template("template/base/error/security_out_of_box.html");
		$template->set_var("message", $message);
		$template->output();
	}
}

?>
