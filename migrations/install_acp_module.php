<?php
/**
 *
 * phpBB Studio - Prism. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\prism\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	/**
	 * If the config variable already exists in the db
	 * skip this migration.
	 */
	public function effectively_installed()
	{
		return $this->config->offsetExists('phpbbstudio_prism_theme');
	}

	/**
	 * This migration depends on phpBB's migration
	 * already being installed.
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	public function update_data()
	{
		return [
			/*! Add config variable */
			['config.add', ['phpbbstudio_prism_theme', 'default.css' ]],

			/*! Add parent module */
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_PHBBSTUDIO_PRISM_TITLE'
			]],

			/*! Add main module */
			['module.add', [
				'acp',
				'ACP_PHBBSTUDIO_PRISM_TITLE',
				[
					'module_basename'	=> '\phpbbstudio\prism\acp\main_module',
					'modes'				=> ['settings'],
				],
			]],
		];
	}
}
