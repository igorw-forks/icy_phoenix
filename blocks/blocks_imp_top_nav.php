<?php
/**
*
* @package Icy Phoenix
* @version $Id$
* @copyright (c) 2008 Icy Phoenix
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
*
* @Extra credits for this file
* masterdavid - Ronald John David
*
*/

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}
if(!function_exists(imp_top_nav_block_func))
{
	function imp_top_nav_block_func()
	{
		global $lang, $template, $board_config;

		$template->assign_vars(array(
			)
		);
	}
}

imp_top_nav_block_func();

?>