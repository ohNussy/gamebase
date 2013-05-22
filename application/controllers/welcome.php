<?php

/**
 * 開発予定の共通機能
 *  
	フレンド機能
	簡易ギフト機能
	ランキング機能
	実績機能
	メッセージ機能
	チーム機能
	アバターカスタマイズ機能
	ユーザタイムライン機能
	ディスカッション機能
	協力攻略コンテンツ
	対戦コンテンツ
	図鑑コメント機能
 *
 */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * トップページ関連
 */
class Welcome extends MY_Controller
{

	/**
	 * コンストラクタ
	 * あらかじめユーザデータを取得する
	 */
	public function __construct()
	{
		parent::__construct();
		$this->layout = 'layout/welcome';

		$this->data['user'] = R::findOne('user', 'openid = ? AND secretkey = ?', array($this->session->userdata('openid'), $this->session->userdata('secretkey')));
		if ($this->data['user'] AND $this->data['user']->token != $this->session->userdata('token'))
		{
			$this->session->sess_destroy();
			$this->session->set_flashdata(MSG, config_item('text_token_invalid'));
		}
		$this->data['msg'] = $this->session->flashdata(MSG);
		
		// TODO: 各種データ取得
		$this->data['friends'] = array(); // フレンド
		$this->data['greetings'] = array(); // 挨拶機能
		$this->data['minimails'] = array(); // 未読ミニメール
		$this->data['teamchats'] = array(); // チームチャット
		$this->data['chats'] = array(); // ディスカッション
		$this->data['mytimelines'] = array(); // 自身のタイムライン
		$this->data['timelines'] = array(); // フレンドのタイムライン
		
	}

	/**
	 * トップページ
	 */
	public function index()
	{
		$this->layout_view('welcome/index', $this->layout);
	}

	/**
	 * ログイン処理
	 */
	public function login()
	{
		// POST通信のみ許可
		if ( $this->input->post() )
		{
			// ヘルパーロード
			$this->load->helper('string');
			$this->load->helper('date');
			// クッキーの取得
			$openid = $this->input->cookie('openid');
			$secretkey = $this->input->cookie('secretkey');
			// トークン生成
			$token = random_string('unique');
			// ユーザ取得
			$user = R::findOne( 'user', 'openid = ? AND secretkey = ?', array( $openid, $secretkey ) );
			if ($user)
			{
				$user->modified = unix_to_human(time(), true, 'ja');
			}
			else
			{
				// 存在しなければ、新規ユーザとして開始
				$user = R::dispense('user');
				$openid = random_string('unique');
				$secretkey = random_string('unique');
				$user->openid = $openid;
				$user->secretkey = $secretkey;
				$user->created = unix_to_human(time(), true, 'ja');
			}
			// トークンを指定
			$user->token = $token;
			// ユーザ保存
			R::store($user);
			// セッション情報記憶
			$this->session->set_userdata('openid', $openid);
			$this->session->set_userdata('secretkey', $secretkey);
			$this->session->set_userdata('token', $token);
		}
		redirect('/');
	}

	/**
	 * ログアウト処理
	 */
	public function logout()
	{
		// POST通信のみ許可
		if ( $this->input->post() )
		{
			$this->session->sess_destroy();
		}
		redirect('/');
	}

	// TODO

	/**
	 * ランキング
	 */
	public function ranking()
	{
		
	}

	/**
	 * 実績
	 */
	public function acheve()
	{
		
	}

	/**
	 * ユーザデータ
	 */
	public function user($id)
	{
		
	}

	/**
	 * チームデータ
	 */
	public function team($id)
	{
		
	}

	/**
	 * 図鑑データチャット
	 */
	public function dictdisc($id)
	{
		
	}

}
