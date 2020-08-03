<?php
/**
 *
 * phpBB Studio - Prism. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\prism\acp;

/**
 * phpBB Studio - Prism ACP module info.
 */
class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\phpbbstudio\prism\acp\main_module',
			'title'		=> 'ACP_PHBBSTUDIO_PRISM_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'ACP_PHBBSTUDIO_PRISM_SETTINGS',
					'auth'	=> 'ext_phpbbstudio/prism && acl_a_board',
					'cat'	=> ['ACP_PHBBSTUDIO_PRISM_TITLE']
				],
			],
		];
	}
}
