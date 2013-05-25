<?php

class greeting_model extends MY_Model {

	const TABLE = 'greeting';

	public function __construct() {
		parent::__construct();
	}

	/**
	 * ユーザの挨拶一覧取得
	 * @param type $user
	 */
	public function unreceive_count($user)
	{
		return R::count(self::TABLE, 'to_user_id = ? AND received = 0', array($user->id));
	}
	

	/**
	 * ユーザの挨拶一覧取得
	 * @param type $user
	 */
	public function get_all($user, $start = 0, $count = 50)
	{
		return R::find(self::TABLE, 'to_user_id = ? limit ?, ?', array($user->id, $start, $count));
	}
	
	/**
	 * エールを全て受け取る
	 * @param type $user
	 */
	public function receive_all(&$user)
	{
		$sql = 'SELECT SUM(point) AS point FROM greeting WHERE to_user_id = ? AND received = 0 AND point > 0';
		$point = R::getCell($sql, array($user->id));
		$user->friend_point += min(config_item('game_max_friend_point'), $point);
		$sql = 'UPDATE greeting SET received = 1 WHERE to_user_id = ? AND received = 0 AND point > 0';
		R::exec($sql, array( $user->id ) );
	}
	
	/**
	 * エールを贈る
	 * @param type $user
	 * @param type $id
	 * @param type $body
	 * @return type
	 */
	public function send($user, $id, $body)
	{
		if ( ! $user )
			return;
		// ヘルパーロード
		$this->load->helper('date');
		// データ登録
		$greeting = R::dispense(self::TABLE);
		$greeting->user_id = $user->id;
		$greeting->to_user_id = $id;
		$greeting->body = $body;
		$greeting->received = false;
		$greeting->point = 0;
		$greeting->created = unix_to_human(time(), true, 'ja');
		$greeting->modified = unix_to_human(time(), true, 'ja');
		return R::store($greeting);
	}

	/**
	 * エール送信の可否、ゲームごとに条件を変える
	 * @param type $user
	 * @param type $id
	 * @return boolean
	 */
	public function enable($user, $id)
	{
		if ( ! $user )
			return false;
		if ( ! $id )
			return false;
		$target = R::load('user', $id);
		if ( ! $target->id )
			return false;
		return true;
	}

}
