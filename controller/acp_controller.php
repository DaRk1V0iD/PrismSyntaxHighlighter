<?php
/**
 *
 * phpBB Studio - Prism. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\prism\controller;

/**
 * phpBB Studio - Prism ACP controller.
 */
class acp_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\extension\manager "Extension Manager" */
	protected $ext_manager;

	/** @var \phpbb\user */
	protected $user;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\config\config		$config			Config object
	 * @param \phpbb\language\language	$language		Language object
	 * @param \phpbb\log\log			$log			Log object
	 * @param \phpbb\request\request	$request		Request object
	 * @param \phpbb\template\template	$template		Template object
	 * @param \phpbb\extension\manager	$ext_manager	Extension manager object
	 * @param \phpbb\user				$user			User object
	 */
	public function __construct(
		\phpbb\config\config $config,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\extension\manager $ext_manager,
		\phpbb\user $user
	)
	{
		$this->config			= $config;
		$this->language			= $language;
		$this->log				= $log;
		$this->request			= $request;
		$this->template			= $template;
		$this->ext_manager	 	= $ext_manager;
		$this->user 			= $user;
	}

	/**
	 * Display the options a user can configure for this extension.
	 *
	 * @return void
	 */
	public function display_options()
	{
		/* Create a form key for preventing CSRF attacks */
		add_form_key('phpbbstudio_prism_acp');

		$data = ['phpbbstudio_prism_theme' => $this->request->variable('phpbbstudio_prism_theme', '', true)];

		/* Create an array to collect errors that will be output to the user */
		$errors = [];

		$themes = scandir($this->ext_manager->get_extension_path('phpbbstudio/prism', true). 'styles/all/theme/prism');

		$themes = array_diff($themes, ['.', '..']);

		/* What if the directory is empty? o_O */
		if (!$themes)
		{
			$errors[] = $this->language->lang('ACP_PHPBBSTUDIO_PRISM_NO_THEMES');
		}

		foreach ($themes as $theme)
		{
			/* Remove ".css" file estension */
			$this->template->assign_block_vars('themes', [
				'NAME'		=> preg_replace('/\\.[^.\\s]{3,4}$/', '', $theme),
			]);
		}

		/* Is the form being submitted to us? */
		if ($this->request->is_set_post('submit'))
		{
			/* Test if the submitted form is valid */
			if (!check_form_key('phpbbstudio_prism_acp'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}

			$white_space_position = strrpos($data['phpbbstudio_prism_theme'], ' ');
			$data['phpbbstudio_prism_theme'] = strtolower($white_space_position ? substr($data['phpbbstudio_prism_theme'], $white_space_position + 1) : $data['phpbbstudio_prism_theme'] . '.css');

			/* If no errors, process the form data */
			if (empty($errors))
			{
				foreach ($themes as $theme)
				{
					if (strpos($theme, $data['phpbbstudio_prism_theme']) !== false)
					{
						$this->config->set('phpbbstudio_prism_theme', $theme);
					}
				}

				/* Add option settings change action to the admin log */
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_PHPBBSTUDIO_PRISM_THEME_CHANGED');

				/* If the request is AJAX */
				if ($this->request->is_ajax())
				{
					/* Set up a JSON response */
					$json_response = new \phpbb\json_response();

					/* Send a JSON response */
					$json_response->send([
						'MESSAGE_TITLE'	=> $this->language->lang('INFORMATION'),
						'MESSAGE_TEXT'	=> $this->language->lang('ACP_PHPBBSTUDIO_PRISM_THEME_CHANGED'),
						'REFRESH_DATA'	=> [
							'url'	=> '',
							'time'	=> 1,
						],
					]);
				}

				/* Show success message when not using AJAX */
				trigger_error($this->language->lang('ACP_PHPBBSTUDIO_PRISM_THEME_CHANGED') . adm_back_link($this->u_action));
			}
		}

		$s_errors = !empty($errors);

		/* Set output variables to use in the template */
		$this->template->assign_vars([
			'S_ERROR'			=> $s_errors,
			'ERROR_MSG'			=> $s_errors ? implode('<br>', $errors) : '',

			'THEME_CSS'			=> $this->config['phpbbstudio_prism_theme'],
			'THEME_CSS_NAME'	=> preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->config['phpbbstudio_prism_theme']),

			'U_ACTION'			=> $this->u_action,
		]);
	}

	/**
	 * Set custom form action.
	 *
	 * @param string	$u_action	Custom form action
	 * @return void
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
