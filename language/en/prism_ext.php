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
	'PHPBB_VERSION'				=> 'Minimum phpBB version required is %1$s but less than %2$s',
	'S9E_HIGHLIGHTER_INSTALLED'	=> 'The extension “s9e/highlighter” has been detected, disable it in order to use this one.',
]);
