<?php

class MY_Controller extends CI_Controller {

	public $data = array();
	public $layout = '';

	public function __construct() {
		parent::__construct();
	}

	public function layout_view($view, $layout) {
		$this->data['contents'] = $this->load->view($view, $this->data, TRUE);
		$this->load->view($layout, $this->data);
	}

}
