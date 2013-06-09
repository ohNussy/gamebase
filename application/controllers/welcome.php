<?php

/**
 * 開発予定の共通機能
 *  
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
		
	}

	/**
	 * トップページ
	 */
	public function index()
	{
		if ( $this->data['user'] )
		{
			$this->load->model('user_mail_model');
			$this->data['mails'] = $this->user_mail_model->get_all_by_user($this->data['user'], 0, 3);
		}
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
	public function ranking($category, $page = 1)
	{
		// カテゴリが不在ならエラー
		$this->data['category'] = R::findOne('ranking_category', 'openid = ?', array($category));
		if (!$this->data['category'])
		{
			$this->session->set_flashdata(MSG, config_item('text_invalid_data'));
			redirect ('/');
		}
		$id = $this->data['category']->id;
		// ランキングデータ取得
		$this->load->model('ranking_model');
		$count = 50;
		$start = ($page - 1) * $count;
		$this->data['data'] = $this->ranking_model->get_all_by_category($id, $start, $count);
		// ビュー
		$this->layout_view('welcome/ranking', $this->layout);
	}

	/**
	 * ユーザデータ
	 */
	public function user($id = 0)
	{
		$user = R::load('user', $id);
		if (!$user->id)
		{
			$this->session->set_flashdata(MSG, config_item('text_invalid_data'));
			redirect('/');
		}
		$this->data['is_friend'] = false;
		if ($this->data['user'])
		{
			$this->load->model('friend_model');
			$this->data['is_friend'] = $this->friend_model->is_friend($this->data['user'], $user->id);		
		}
		$this->data['data'] = $user;
		$this->layout_view('welcome/user', $this->layout);
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

