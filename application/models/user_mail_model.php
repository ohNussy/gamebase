<?php

class user_mail_model extends MY_Model {

	const TABLE = 'user_mail';

	public function __construct() {
		parent::__construct();
		$this->ci->load->helper('date');
	}

	public function get_all_by_user($user, $start, $count)
	{
		$result = R::find(self::TABLE, 'user_id = ? ORDER BY id DESC LIMIT ?, ?', array($user->id, $start, $count));
		R::preload( $result, array( 'from_user' => 'user' ) );
		return $result;
	}

	public function get_unread($user)
	{
		return R::count(self::TABLE, 'user_id = ? AND opened = ?', array($user->id, 0) );
	}

	public function send($user, $target, $body)
	{
		$mail = R::dispense('user_mail');
		$mail->user = $target;
		$mail->from_user = $user;
		$mail->body = $body;
		$mail->opened = 0;
		$mail->created = unix_to_human(time(), 0, 'ja');
		$mail->modified = unix_to_human(time(), 0, 'ja');
		R::store($mail);
	}
	
	public function set_opened($user)
	{
		$table = self::TABLE;
		$sql = "UPDATE {$table} SET opened = 1 WHERE user_id = ? AND opened = 0";
		R::exec($sql, array($user->id));
	}
}
