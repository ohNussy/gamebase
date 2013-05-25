<?php

class MY_Model extends CI_Model {

	public $table = '';
	protected $ci;

	public function __construct() {
		parent::__construct();
		$this->ci = & get_instance();
	}

}
