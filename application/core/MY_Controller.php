<?php

class MY_Controller extends CI_Controller {

	public $data = array();
	public $layout = '';

	public function __construct() {
		parent::__construct();
		$this->layout = 'layout/welcome';

		$this->data['user'] = R::findOne('user', 'openid = ? AND secretkey = ?', array($this->session->userdata('openid'), $this->session->userdata('secretkey')));
		$this->data['msg'] = $this->session->flashdata(MSG);

		// TODO: 各種データ取得
		$this->data['friends'] = array(); // フレンド
		$this->data['greetings'] = array(); // 挨拶機能
		$this->data['minimails'] = array(); // 未読ミニメール
		$this->data['teamchats'] = array(); // チームチャット
		$this->data['chats'] = array(); // ディスカッション
		$this->data['mytimelines'] = array(); // 自身のタイムライン
		$this->data['timelines'] = array(); // フレンドのタイムライン
		
		if ($this->data['user'])
		{
			$this->load->model('greeting_model');
			$this->data['greetings'] = $this->greeting_model->unreceive_count($this->data['user']);
		}
	}

	public function layout_view($view, $layout) {
		$this->data['contents'] = $this->load->view($view, $this->data, TRUE);
		$this->load->view($layout, $this->data);
	}

}
