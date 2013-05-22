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

}
