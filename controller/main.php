<?php

/**
*
* @package NV Newspage Extension
* @copyright (c) 2013 nickvergessen
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

class phpbb_ext_nickvergessen_newspage_controller_main
{
	/**
	* Constructor
	* NOTE: The parameters of this method must match in order and type with
	* the dependencies defined in the services.yml file for this service.
	*
	* @param phpbb_auth		$auth		Auth object
	* @param phpbb_cache_service	$cache		Cache object
	* @param phpbb_config	$config		Config object
	* @param phpbb_db_driver	$db		Database object
	* @param phpbb_request	$request	Request object
	* @param phpbb_template	$template	Template object
	* @param phpbb_user		$user		User object
	* @param phpbb_content_visibility		$content_visibility	Content visibility object
	* @param phpbb_controller_helper		$helper				Controller helper object
	* @param phpbb_ext_nickvergessen_newspage		$newspage	Newspage object
	* @param string			$root_path	phpBB root path
	* @param string			$php_ext	phpEx
	*/
	public function __construct(phpbb_auth $auth, phpbb_cache_service $cache, phpbb_config $config, phpbb_db_driver $db, phpbb_request $request, phpbb_template $template, phpbb_user $user, phpbb_content_visibility $content_visibility, phpbb_controller_helper $helper, phpbb_ext_nickvergessen_newspage $newspage, $root_path, $php_ext)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->content_visibility = $content_visibility;
		$this->helper = $helper;
		$this->newspage = $newspage;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;

		if (!class_exists('bbcode'))
		{
			include($this->root_path . 'includes/bbcode.' . $this->php_ext);
		}
		if (!function_exists('get_user_rank'))
		{
			include($this->root_path . 'includes/functions_display.' . $this->php_ext);
		}
	}

	/**
	* Base controller to be accessed with the URL /newspage/{page}
	* (where {page} is the placeholder for a value)
	*
	* @param int	$page	Page number taken from the URL
	* @return Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function base($page = null)
	{
		$this->newspage->set_start($this->request->variable('start', 0))
			->set_category($this->request->variable('f', 0))
			->set_news($this->request->variable('news', 0))
			->set_archive($this->request->variable('archive', ''));

		$this->newspage->base();
		return $this->helper->render('newspage_body.html', $this->newspage->get_page_title());
	}
}