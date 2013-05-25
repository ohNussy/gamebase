<?php

class ranking_model extends MY_Model {

	const TABLE = 'ranking';

	public function __construct() {
		parent::__construct();
	}

	public function get_all_by_category($category, $start = 0, $count = 50)
	{
		return R::find(self::TABLE, 'ranking_category_id = ? ORDER BY rank ASC LIMIT ?, ?', array($category, $start, $count));
	}

}
