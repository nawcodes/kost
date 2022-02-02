<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {


	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	

	public function login(){ 
		$this->load->view('src/header');
		$this->load->view('login');
		$this->load->view('src/footer');
	}
	public function register(){ 
		$this->load->view('src/header');
		$this->load->view('register');
		$this->load->view('src/footer');
	}
	public function profile(){ 
		$id_user = $this->session->userdata('id_user');
		if(!empty($this->input->post())){
			$update = $this->input->post();
			if(empty($update['password'])){
				unset($update['password']);
			}else{
				$update['password'] = md5($update['password']);
			}
			$up = $this->m_general->uData('user',$update,array('id_user'=>$id_user));
			if($up){
				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Profil berhasil diupdate</div>');
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Terjadi Kesalahan</div>');
			}
		}
		$data['detail'] = $this->m_general->gDataW('user',array('id_user'=>$id_user))->row();
		$this->load->view('src/header',$data);
		$this->load->view('profile',$data);
		$this->load->view('src/footer');
	}
	public function auth(){ 
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$login = $this->m_general->login($username,$password);
		if($login){
			$id = $this->m_general->gDataW('user',array('username'=>$username))->row();
			if($id->is_verify == 1) {
				$this->session->set_userdata('id_user',$id->id_user);
				$this->session->set_userdata('level',$id->level);
				redirect(base_url());
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun anda belum diaktifkan, silahkan check Email anda untuk mengaktifkan akun</div>');
				redirect('account/login');
			}
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Username / Password salah</div>');
			redirect('account/login');
		}
	}
	public function logout(){
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('level');
		redirect('account/login');
	}
	public function registerProccess(){
		if(!$_POST) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Terjadi suatu kesalahan. coba kembali</div>');
			redirect('account/register');
		}
		$email = $_POST['email'];
		$nama = $_POST['nama'];
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$c_password = $_POST['c_password'];
		$image_hidden = '';

		$this->form_validation->set_rules('email', 'Email' , 'required|valid_email');
		$this->form_validation->set_rules('nama', 'Nama' , 'required');
		$this->form_validation->set_rules('alamat', 'Alamat' , 'required');
		$this->form_validation->set_rules('no_hp', 'No. Tlp', 'numeric|required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if (!empty($_FILES) && $_FILES['image']['name'] !== '') {
			// make custom name
			$image_hidden;
			$account_imageName = url_title($nama, '-', true) . '-' . $_FILES['image']['name'];

			$account_image = $this->_isUpload('image', $account_imageName);
			if ($account_image) {
				$image_hidden = $account_image['file_name'];
			} else {
				$this->session->set_flashdata(
					'message',
					$this->upload->display_errors('', '')
				);
				redirect('account/register');
			}
		}else{
			$this->form_validation->set_rules('image_hidden', 'Foto Ktp', 'required');
		}




		if($this->form_validation->run() == FALSE) {
			$this->load->view('src/header');
			$this->load->view('register');
			$this->load->view('src/footer');
			return;
		}
		

		if($password!==$c_password){
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Konfirmasi Kata Sandi tidak sama</div>');
			redirect('account/register');
		}else{
			$check = $this->db->get_where('user', ['email' => $email])->row();
			if($check) {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email ini sudah terdaftar</div>');
				redirect('account/register');
			}

			$want = array('email' => $email, 'nama' => $nama, 'alamat' => $alamat, 'no_hp' => $no_hp, 'username' => $username, 'password' => md5($password), 'level' => '2', 'img' => $image_hidden, 'is_verify' => 0);

			$insert = $this->m_general->iData('user',array('email' => $email ,'nama'=>$nama,'alamat'=>$alamat,'no_hp'=>$no_hp,'username'=>$username,'password'=>md5($password),'level'=>'2', 'img' => $image_hidden, 'is_verify' => 0));
			if($insert > 0) {
				$this->_sendMail();
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pendaftaran Berhasil, Permohonan aktivasi sudah dirikim ke email <span class="text-primary">'  . $this->input->post('email') .  '</span></div>');
				redirect('account/login');
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Gagal memasukan data</div>');
				redirect('account/register');
			}
		}
	}


	private function _sendMail() {

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'tiarakost.smi@gmail.com',
			'smtp_pass' => 'Tiarakostsmi',
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline' => "\r\n"
		);

		$this->load->library('email', $config);
		$fromEmail = 'tiarakost.smi@gmail.com';
		$toEmail = $this->input->post('email');
		$subject = "Aktivasi akun anda";
		$token = base64_encode(random_bytes(32));

		$data = [
			'name' => $this->input->post('nama'),
			'email' => $this->input->post('email'),
			'token' => $token,
			'date_created' => time()
		];
		$mesg = $this->load->view('mail/register-verif', $data ,true);
		$this->email->to($toEmail);
		$this->email->from($fromEmail, "Tiara Kost Apartement Sukabumi");
		$this->email->reply_to($fromEmail, 'Tiara Kost Apartement Sukabumi');
		$this->email->subject($subject);
		$this->email->message($mesg);
		$mail = $this->email->send();
		if(!$mail) {
			echo $this->email->print_debugger();
			die;
		}else{
			$this->db->insert('verify_account', ['email' => $data['email'], 'token' => $data['token'], 'date_created' => $data['date_created']]);
			$db = $this->db->insert_id();
		}

	}


	private function _isUpload($field, $imageName)
	{
		$config = [
			'upload_path'        => './assets/images/ktp',
			'allowed_types'      => 'jpg|png|jpeg|gif|JPG|JPEG|',
			'max_size'           => 5024,
			'max_width'          => 0,
			'max_height'         => 0,
			'file_name'          => $imageName,
			'overwrite'          => true,
			'file_ext_tolower'   => true,
		];

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($this->upload->do_upload($field)) {
			return $this->upload->data();
		} else {
			return false;
		}
	}

	public function verify() {
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if($user) {
			$verify_account = $this->db->get_where('verify_account', ['token' => $token])->row_array();

			if($verify_account) {
				// dateNow - dateCreatedJustNow < 1 dat 
				if(time() - $verify_account['date_created'] < (60*60*24)) {
					$this->db->set('is_verify', 1);
					$this->db->where('email', $email);
					$this->db->update('user');

					$this->db->delete('verify_account', ['email' => $email]);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Aktivasi Berhasil, silahkan login.</div>');
					redirect('account/login');
				} else {
					$this->db->delete('user', ['email' => $email]);
					$this->db->delete('verify_account', ['email' => $email]);

					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User atau link aktivasi sudah kadaluarsa</div>');
					redirect('account/login');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Authentication Failed</div>');
				redirect('account/login');
			}

		}else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Authentication Failed</div>');
			redirect('account/login');
		}
	}
}
