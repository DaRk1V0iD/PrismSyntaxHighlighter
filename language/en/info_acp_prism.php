<?php
/**
 *
 * phpBB Studio - Prism. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
 * Some characters you may want to copy&paste: ’ » “ ” …
 */

$lang = array_merge($lang, [
	'ACP_PHBBSTUDIO_PRISM_TITLE' 					=> 'phpBB Studio - Prism',
	'ACP_PHBBSTUDIO_PRISM_SETTINGS' 				=> 'Settings',
	'ACP_PHPBBSTUDIO_PRISM_THEME_NAME' 				=> 'Theme name',

	'ACP_PHPBBSTUDIO_PRISM_THEME_CHANGED'			=> '<strong>phpBB Studio - Prism</strong> theme changed.',
	'ACP_PHPBBSTUDIO_PRISM_NO_THEMES'				=> 'No themes available!',
	'LOG_ACP_PHPBBSTUDIO_PRISM_THEME_CHANGED'		=> '<strong>phpBB Studio - Prism</strong> theme changed.',
]);
