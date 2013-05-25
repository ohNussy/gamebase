<?php

class friend_model extends MY_Model {

	const TABLE = 'friend';

	public function __construct() {
		parent::__construct();
	}

	public function is_friend($user, $id)
	{
		if (!$user)
			return false;
		$friend = R::findOne(self::TABLE, 'user_id = ? AND to_user_id = ? AND allow = 1 AND accept = 1', array($user->id, $id));
		return (!empty($friend));
	}

	public function is_deny($user, $id)
	{
		if (!$user)
			return false;
		$friend = R::findOne(self::TABLE, 'to_user_id = ? AND user_id = ? AND deny = 1', array($user->id, $id));
		return (!empty($friend));
	}

	public function is_send($user, $id)
	{
		if (!$user)
			return false;
		$friend = R::findOne(self::TABLE, 'user_id = ? AND to_user_id = ?', array($user->id, $id));
		return (!empty($friend));
	}

	public function all_friends($user)
	{
		if (!$user)
			return array();
		$friends = R::find(self::TABLE, 'user_id = ? AND allow = 1 AND accept = 1', array($user->id));
		return $friends;
	}

	public function app($user, $id)
	{
		$this->ci->load->helper('date');
		// 既存データの削除
		$this->del($user, $id);
		// 自身基点
		$friend = R::dispense(self::TABLE);
		$friend->user_id = $user->id;
		$friend->to_user_id = $id;
		$friend->allow = 1;
		$friend->accept = 0;
		$friend->deny = 0;
		$friend->created = unix_to_human(time(), true, 'ja');
		$friend->modified = unix_to_human(time(), true, 'ja');
		R::store($friend);
		// 相手基点
		$friend = R::dispense(self::TABLE);
		$friend->user_id = $id;
		$friend->to_user_id = $user->id;
		$friend->allow = 0;
		$friend->accept = 1;
		$friend->deny = 0;
		$friend->created = unix_to_human(time(), true, 'ja');
		$friend->modified = unix_to_human(time(), true, 'ja');
		R::store($friend);
	}

	public function del($user, $id)
	{
		// 既存データの削除
		$sql = 'DELETE FROM friend WHERE (user_id = :user_id AND to_user_id = :to_user_id) OR (user_id = :to_user_id AND to_user_id = :user_id)';
		R::exec($sql, array('user_id' => $user->id, 'to_user_id' => $id));
	}

}
