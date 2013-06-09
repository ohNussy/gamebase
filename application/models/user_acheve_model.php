<?php

class user_acheve_model extends MY_Model {

	const TABLE = 'user_acheve';

	public function __construct() {
		parent::__construct();
	}

	public function get_all_by_user($user)
	{
		$result = R::find(self::TABLE, 'user_id = ? ORDER BY acheve_id', array($user->id));
		R::preload( $result, array( 'acheve' ) );
		return $result;
	}

	public function add($user, $acheve, $value)
	{
		$row = R::findOne( self::TABLE, 'user_id = ? AND acheve_id = ?', array( $user->id, $acheve->id ) );
		if ($row)
		{
			$row->value += $value;
			$row->modified = unix_to_human(time(), true, 'ja');
		}
		else
		{
			$row = R::dispense( self::TABLE );
			$row->user = $user;
			$row->acheve = $acheve;
			$row->value = $value;
			$row->created = unix_to_human(time(), true, 'ja');
		}
		if ($row->value >= $acheve->value)
		{
			$row->complete = 1;
		}
		R::store($row);
	}

	public function set($user, $acheve, $value)
	{
		$row = R::findOne( self::TABLE, 'user_id = ? AND acheve_id = ?', array( $user->id, $acheve->id ) );
		if ($row)
		{
			$row->value = $value;
			$row->modified = unix_to_human(time(), true, 'ja');
		}
		else
		{
			$row = R::dispense( self::TABLE );
			$row->user = $user;
			$row->acheve = $acheve;
			$row->value = $value;
			$row->created = unix_to_human(time(), true, 'ja');
		}
		if ($row->value >= $acheve->value)
		{
			$row->complete = 1;
		}
		R::store($row);
	}

}
