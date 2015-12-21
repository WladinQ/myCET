<?php



/**

 * @lang cz

 * Detekce mobilniho zarizeni pro rozhozeni

 * uzivatele na verzi pro WAP 

 *

 * @lang en

 * Detection for mobile device and redirecting

 * user to WAP versinon

 *

 * @author Tomas Kopecny <tomas@kopecny.info>

 * @version 0.1

 * @copyright 2007 - 2008 Tomas Kopecny

 * @url http://code.google.com/p/detectmobile/

 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License

 *

 * This program is free software; you can redistribute it and/or

 * modify it under the terms of the GNU Lesser General Public License

 * as published by the Free Software Foundation; either version 3

 * of the License, or (at your option) any later version.

 *

 * This program is distributed in the hope that it will be useful,

 * but WITHOUT ANY WARRANTY; without even the implied warranty of

 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

 * GNU General Public License for more details.

 *

 * You should have received a copy of the GNU General Public License

 * along with this program; if not, write to the Free Software

 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA

 *     02111-1307, USA.

 *

 * $Id: dm.php 5 2008-06-14 08:29:11Z georgo10 $



 * @lang cz

 * Detekuje mobilnн zaшнzenн

 *

 * @description Pokud je mobilnн zaшнzenн detekovбno, je nastavenб cookie pro snнћenн zбtмћe a pшнљtн detekce

 *

 * @lang en

 * Detect mobile device

 *

 * @description If is mobile device detected, cookie set for performance for next detecting

 *

 * @param void

 * @return bool information about detected mobile device

 */

 

function detect_mobile_device()

{

	// Provest detekci mobilniho zarizeni

	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));

	$mobile_agents = array('acs-','alav','alca','amoi','audi','aste','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','g10-', 'hipt','htc_','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','opwv','palm','pana','pant','pdxg','phil','play','pluc','port','prox','qtek','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');

	if (

		(isset($_COOKIE['isbrowser']) && $_COOKIE['isbrowser']=='1') ||

		(strpos(strtolower($_SERVER['HTTP_ACCEPT']),'text/vnd.wap.wml')!==false) || 

		(strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')!==false) || 

		(isset($_SERVER['HTTP_X_WAP_PROFILE'])) || 

		(isset($_SERVER['HTTP_PROFILE'])) || 

		(isset($_SERVER['X-OperaMini-Features'])) || 

		(isset($_SERVER['UA-pixels'])) ||

		(in_array($mobile_ua,$mobile_agents)) ||

		(preg_match('/(up.browser|up.link|windows ce|iemobile|mmp|symbian|smartphone|midp|wap|phone|vodafone|pocket|mobile|pda|psp)/i',strtolower($_SERVER['HTTP_USER_AGENT'])))

	) {

		// Bylo detekovano mobilni zarizeni

		if(!headers_sent()) // Pro ulehceni pri pristi detekci

		{

			setcookie('isbrowser', 1, time()+3600*24*31, '/', '.mycet.php5.sk');

		}

		return TRUE;

	}

	return FALSE;

};

?>