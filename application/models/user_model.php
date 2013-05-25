<?php

class user_model extends MY_Model {

	const TABLE = 'user';
	
	public function __construct() {
		parent::__construct();
	}

	public function is_exist($id)
	{
		$user = R::load(self::TABLE, $id);
		return ($user->id > 0);
	}

}
