<?php
/**
 *
 * phpBB Studio - Prism. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\prism\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\config\config		$config			Config object
	 * @param \phpbb\template\template	$template		Template object
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\template\template $template
	)
	{
		$this->config	= $config;
		$this->template	= $template;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core.
	 *
	 * @return array
	 * @static
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'core.text_formatter_s9e_configure_after'	=> 'onConfigure',
			'core.page_header_after'					=> 'assignCss',
			'core.adm_page_header'						=> 'assignCss',
		];
	}

	/**
	 * Configure language selection for CODE bbcode
	 *
	 * @event  core.text_formatter_s9e_configure_after
	 * @param \phpbb\event\data		$event		The event object
	 * @return void
	 */
	public function onConfigure(\phpbb\event\data $event): void
	{
		$configurator = $event['configurator'];

		if (!isset($configurator->tags['CODE'], $configurator->BBCodes['CODE']))
		{
			return;
		}

		$configurator->BBCodes['CODE']->defaultAttribute = 'lang';

		if (!isset($configurator->tags['CODE']->attributes['lang']))
		{
			$attribute = $configurator->tags['CODE']->attributes->add('lang');
			$attribute->required = false;
			$attribute->filterChain->append('#identifier');
		}

		$attribute = $configurator->tags['CODE']->attributes['lang'];
		$attribute->filterChain->prepend('strtolower');

		$dom = $configurator->tags['CODE']->template->asDOM();

		foreach ($dom->getElementsByTagName('code') as $code)
		{
			$code->setAttribute('class', trim($code->getAttribute('class') . ' language-{@lang}'));
		}

		$dom->saveChanges();
	}

	/**
	 * Assign user's defined theme to Prism
	 *
	 * @event  core.page_header_after
	 * @param \phpbb\event\data		$event		The event object
	 * @return void
	 */
	public function assignCss(\phpbb\event\data $event): void
	{
		$this->template->assign_var('THEME_CSS', $this->config['phpbbstudio_prism_theme']);
	}
}
