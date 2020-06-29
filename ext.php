<?php
/**
 *
 * phpBB Studio - Prism. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\prism;

/**
 * phpBB Studio - Prism Extension base
 */
class ext extends \phpbb\extension\base
{
	/**
	 * {@inheritdoc
	 */
	public function is_enableable()
	{
		/* Now if the phpBB is adequate */
		if (!(phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>=') && phpbb_version_compare(PHPBB_VERSION, '4.0.0@dev', '<')))
		{
			$language= $this->container->get('language');
			$language->add_lang('prism_ext', 'phpbbstudio/prism');

			return $language->lang('PHPBB_VERSION', '3.3.0', '4.0.0@dev');
		}

		/* Now if the extension "s9e/highlighter" is enabled */
		$ext_manager = $this->container->get('ext.manager');
		$is_s9e_highlighter_enabled = $ext_manager->is_enabled('s9e/highlighter');

		if ($is_s9e_highlighter_enabled)
		{
			$language= $this->container->get('language');
			$language->add_lang('prism_ext', 'phpbbstudio/prism');

			return $language->lang('S9E_HIGHLIGHTER_INSTALLED');
		}

		return true;
	}
}
