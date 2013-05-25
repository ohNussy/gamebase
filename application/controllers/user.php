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
class User extends MY_Controller {

	/**
	 * コンストラクタ
	 * あらかじめユーザデータを取得する
	 */
	public function __construct() {
		parent::__construct();
		if ($this->data['user'] AND $this->data['user']->token != $this->session->userdata('token')) {
			$this->session->sess_destroy();
			$this->session->set_flashdata(MSG, config_item('text_token_invalid'));
			redirect('/');
		}
	}

	/**
	 * フレンド一覧
	 */
	public function friends()
	{
		$this->load->model('friend_model');
		$this->data['data'] = $this->friend_model->all_friends($this->data['user']);
		$this->layout_view('user/friends', $this->layout);
	}
	
	/**
	 * 挨拶一覧
	 */
	public function greeting_list()
	{
		$this->load->model('greeting_model');
		$this->data['data'] = $this->greeting_model->get_all($this->data['user']);
		$this->layout_view('user/greeting_list', $this->layout);
	}

	/**
	 * 挨拶一覧
	 */
	public function receive_greeting()
	{
		$this->load->model('greeting_model');
		R::begin();
		try {
			$this->data['data'] = $this->greeting_model->receive_all( $this->data['user'] );
			R::store($this->data['user']);
			R::commit();
		} catch (Exception $exc) {
			log_message('error', $exc->getMessage());
			R::rollback();
			$this->session->set_flashdata(MSG, config_item('text_db_failed'));
		}
		redirect('user/greeting_list');
	}
	
	/**
	 * 挨拶処理
	 */
	public function greeting()
	{
		// POST通信のみ許可
		if ($this->input->post()) {
			$this->load->model('greeting_model');
			$id = $this->input->post('id');
			$body = $this->input->post('body');
			if ( $this->greeting_model->enable( $this->data['user'] , $id ) )
			{
				// 未送信なら送信
				R::begin();
				try {
					$this->greeting_model->send($this->data['user'], $id, $body);
					R::commit();
					$this->session->set_flashdata(MSG, config_item('text_send_greeting'));
				} catch (Exception $exc) {
					log_message('error', $exc->getMessage());
					R::rollback();
					$this->session->set_flashdata(MSG, config_item('text_db_failed'));
				}
			}
		}
		redirect($this->agent->referrer());
	}
	
	/**
	 * フレンド申請処理
	 */
	public function friend_app()
	{
		// POST通信のみ許可
		if ($this->input->post()) {
			$this->load->model('user_model');
			$this->load->model('friend_model');
			$id = $this->input->post('id');
			if (!$this->user_model->is_exist($id))
			{
				$this->session->set_flashdata(MSG, config_item('text_invalid_data'));
				redirect('/');
			}
			if ($this->friend_model->is_deny($this->data['user'], $id))
			{
				$this->session->set_flashdata(MSG, config_item('text_deny_user'));
				redirect('/');
			}
			if (!$this->friend_model->is_send($this->data['user'], $id))
			{
				// 未送信なら送信
				R::begin();
				try {
					$this->friend_model->app($this->data['user'], $id);
					R::commit();
					$this->session->set_flashdata(MSG, config_item('text_send_friend'));
				} catch (Exception $exc) {
					log_message('error', $exc->getMessage());
					R::rollback();
					$this->session->set_flashdata(MSG, config_item('text_db_failed'));
				}
			}
		}
		redirect($this->agent->referrer());
	}

	/**
	 * フレンド解除処理
	 */
	public function friend_del()
	{
		// POST通信のみ許可
		if ($this->input->post()) {
			$this->load->model('user_model');
			$this->load->model('friend_model');
			$id = $this->input->post('id');
			if (!$this->user_model->is_exist($id))
			{
				$this->session->set_flashdata(MSG, config_item('text_invalid_data'));
				redirect('/');
			}
			if ($this->friend_model->is_send($this->data['user'], $id))
			{
				// 送信されていたら削除処理
				R::begin();
				try {
					$this->friend_model->del($this->data['user'], $id);
					R::commit();
					$this->session->set_flashdata(MSG, config_item('text_del_friend'));
				} catch (Exception $exc) {
					log_message('error', $exc->getMessage());
					R::rollback();
					$this->session->set_flashdata(MSG, config_item('text_db_failed'));
				}
			}
		}
		redirect($this->agent->referrer());
	}

}

