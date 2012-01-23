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
 * @ignore
 */ 	

// Debug Mode
define("DEBUG", 						false);

// Avoid CSS Cache
define("AVOID_CSS_CACHE", 				false);

// Avoid JS Cache
define("AVOID_JS_CACHE", 				false);

// General
define("PRODUCT_USER", 					"");
define("PRODUCT_FUNCTION", 				"");
define("HTML_TITLE",					"");
define("ACCOUNTMAIL",					"");
define("SENDMAIL_FROM",					"");
define("TIMEZONE",						"Europe/Berlin");
define("TIMEZONE_ID",					26);

// Database Settings
define("DB_TYPE",						"");
define("DB_SERVER",						"");
define("DB_PORT",						"");
define("DB_USER",						"");
define("DB_PASSWORD",					"");
define("DB_DATABASE",					"");

// Path Settings
define("BASE_DIR",						"");
define("WWW_DIR",						constant("BASE_DIR")."/www");
define("LOG_DIR",						constant("BASE_DIR")."/logs");

define("INCLUDE_DIR",					constant("WWW_DIR")."/core/include");
define("MODULES_DIR",					constant("WWW_DIR")."/core/modules");

// ! The following settings only needed by enabled serivce system !
define("OS",							"WIN32");
define("BIN_DIR",						constant("BASE_DIR")."/bin");									

define("SERVICE_ENABLE",				false);
define("SERVICE_JS_ENABLE",				false);							
define("SERVICE_JS_JOB_ID",				1);	

define("SERVICE_JAVA_HOME",				"");
define("SERVICE_JAVA_VM",				"java");
define("SERVICE_JAVA_XMS",				"64M");
define("SERVICE_JAVA_XMX",				"128M");
// ! Settings end !

// SQL Log
define("ENABLE_DB_LOG_ON_ROLLBACK",		true);
define("ENABLE_DB_LOG_ON_EXP_ROLLBACK",	false);							
define("ENABLE_DB_LOG_ON_COMMIT",		false);	

// Session-Time and IP Errors
define("MAX_SESSION_PERIOD",			36000);
define("MAX_IP_ERRORS",					50);
define("IP_ERROR_LEAD_TIME",			36000);

define("LOGIN_FOOTER", "".constant("PRODUCT").", version: ".constant("PRODUCT_VERSION").", ".constant("PRODUCT_FUNCTION").", ".constant("PRODUCT_USER")." " .
						"<br />This is free software; It comes with ABSOLUTELY NO WARRANTY." .
						"<br />by R. Konertz, B. Tunggal, L. Eichinger et al.; 2008-2011");
?>
