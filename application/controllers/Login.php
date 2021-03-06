<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
//load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}
	public function index()
	{

		// validasi
		$valid=$this->form_validation;
		$valid->set_rules('username','Username','required',
			array('required' => '%s harus diisi'
					));
		$valid->set_rules('password','Password','required|trim',
			array('required' => '%s harus diisi'
		));

		if($valid->run()){
			$username 		= $this->input->post('username');
			$password 		= $this->input->post('password');
			// Compare dengan data di database
			$check_login 	=$this->user_model->login($username,
				$password);
			// Kalau ada data yang cocok maka create SESSION ada 4 (id_user,username,akses_level,dan nama)
			if($check_login && count($check_login) == 1){
				$this->session->set_userdata('id_user',$check_login->id_user);
				$this->session->set_userdata('username',$check_login->username);
				$this->session->set_userdata('nama',$check_login->nama);
				$this->session->set_userdata('akses_level',$check_login->akses_level);
				$this->session->set_flashdata('sukses','Anda berhasil Login');
				redirect(base_url('admin/dasbor'),'refresh');
			}else{
				// kalau tidak cocok redirect ke halaman login
				$this->session->set_flashdata('sukses','Username atau Password salah');
				redirect(base_url('login'),'refresh');
			}

		}

	// End validasi

		$data=array('title'		=> 'Login Administrator'
					);
		$this->load->view('admin/login/list',$data,FALSE);
	}

	//logout
	public function logout(){
		 $this->check_login->logout();
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */