<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->layout = 'layout/welcome';

		$this->data['user'] = R::findOne('user', 'openid = ? AND token = ?', array($this->session->userdata('openid'), $this->session->userdata('token')));
	}

	public function index() {
		$this->layout_view('welcome/index', $this->layout);
	}

	public function login() {
		$this->load->library('twitter');
		$this->twitter->getOauthToken(site_url('callback'));
	}

	public function callback() {
		$this->load->library('twitter');
		$this->twitter->getAccessToken($this->input->get('oauth_verifier'));
		$this->twitter->getUserData();
		if ($this->twitter->userdata) {
			$this->_user_login();
		}
		redirect('/');
	}

	public function rule() {
		$this->layout_view('welcome/rule', $this->layout);
	}

	public function gamelogs() {
		$this->layout_view('welcome/gamelogs', $this->layout);
	}

	public function chatlogs() {
		$this->layout_view('welcome/chatlogs', $this->layout);
	}

	// コントローラ・アクション以外の処理関数
	protected function _user_login() {
		$user = R::findOne('user', 'twitter_id = ?', array($this->twitter->userdata->id_str));
		if (!$user) {
			$user = $this->_new_user();
		}
		$this->_user_login_set($user);
		R::store($user);
		// セッションセット
		$this->session->set_userdata('openid', $user->openid);
		$this->session->set_userdata('token', $user->token);
	}

	protected function _new_user() {
		$user = R::dispense('user');
		$user->twitter_id = $this->twitter->userdata->id_str;
		$user->name = $this->twitter->userdata->name;
		$user->created = date('Y-m-d H:i:s');
		$openid = md5(uniqid(microtime(TRUE)));
		$user->openid = $openid;
		return $user;
	}

	protected function _user_login_set(&$user) {
		$token = md5(uniqid(microtime(TRUE)));
		$user->token = $token;
		$user->screen_name = $this->twitter->userdata->screen_name;
		$user->icon_url = $this->twitter->userdata->profile_image_url;
		$user->modified = date('Y-m-d H:i:s');
	}

}
