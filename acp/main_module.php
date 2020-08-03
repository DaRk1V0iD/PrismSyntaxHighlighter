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
 * phpBB Studio - ACP module.
 */
class main_module
{
	/** @var string Page title */
	public $page_title;

	/** @var string Template name */
	public $tpl_name;

	/** @var string Custom form action */
	public $u_action;

	/**
	 * Main ACP module
	 *
	 * @param int    $id   The module ID
	 * @param string $mode The module mode (for example: manage or settings)
	 * @throws \Exception
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \phpbbstudio\prism\controller\acp_controller $acp_controller */
		$acp_controller = $phpbb_container->get('phpbbstudio.prism.controller.acp');

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_phpbbstudio_prism_body';

		// Set the page title for our ACP page
		$this->page_title = $language->lang('ACP_PHBBSTUDIO_PRISM_TITLE');

		// Make the $u_action url available in our ACP controller
		$acp_controller->set_page_url($this->u_action);

		// Load the display options handle in our ACP controller
		$acp_controller->display_options();
	}
}
