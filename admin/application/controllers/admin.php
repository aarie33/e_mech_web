<?php
class admin extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_model');
		session_start();
		$this->model = $this->admin_model;
		$rowsTekn = $this->model->dataTeknisiSMS();
		$rowsCust = $this->model->dataCustomerSMS();
	}
	
	public function index(){
		$this->isloggedIn();
	}
	
	public function loginAdmin(){
		if(isset($_REQUEST['btnLogin'])){
			$this->model->username = $_REQUEST['username'];
			$this->model->password = md5($_REQUEST['password']);
			$barisCek = $this->model->loginAdmin();
			if($barisCek == 0){
				unset($_SESSION['us_admin']);
				unset($_SESSION['ps_admin']);
				redirect('admin');
			}else{
				$_SESSION['us_admin'] = $_REQUEST['username'];
				$_SESSION['ps_admin'] = md5($_REQUEST['password']);
				redirect('admin');
			}
		}else{
			redirect('admin');
		}
	}
	
	public function isloggedIn(){
		if(isset($_SESSION['us_admin']) && isset($_SESSION['ps_admin'])){
			$this->model->username = $_SESSION['us_admin'];
			$this->model->password = $_SESSION['ps_admin'];
			$barisCek = $this->model->loginAdmin();
			if($barisCek == 0){
				$this->load->view('login_admin');
				unset($_SESSION['us_admin']);
				unset($_SESSION['ps_admin']);
			}else{
				$this->bukaHalamanKonfTeknisi();
			}
		}else{
			$this->load->view('login_admin');
		}
	}
	
	public function logout(){
		unset($_SESSION['us_admin']);
		unset($_SESSION['ps_admin']);
		$this->load->view('login_admin');
	}
	
	public function bukaHalamanKonfTeknisi(){
		$rows = $this->model->dataTeknisiKonfirmasi();
		$rowsTekn = $this->model->dataTeknisiSMS();
		$rowsCust = $this->model->dataCustomerSMS();
		$this->load->view('admin_view_head', ['konfTeknisi'=>'true', 'notifTek'=>$rowsTekn->num_rows(), 'notifCust'=>$rowsCust->num_rows()]);
		$this->load->view('daftar_konfirmasi_teknisi', ['rows'=>$rows]);
		$this->load->view('admin_view_footer');
	}
	
	public function keahlianTeknisi($id_teknisi){
		$this->model->id_teknisi = $id_teknisi;
		$rows = $this->model->dataTeknisiKeahlian();
		return ['dataKeahlian'=>$rows];
	}
	
	public function ajaxFormKonfTeknisi(){
		$this->load->view('load_form_konf', ['id_teknisi'=>$_POST['id_teknisi']]);
	}
	
	public function simpanKonfTeknisi(){
		$this->model->id_teknisi = $_POST['id_teknisi'];
		if(isset($_POST['check1']) and $_POST['check1'] <>""){
			$this->model->no_keahlian1 = $_POST['check1'];
		}
		if(isset($_POST['check2']) and $_POST['check2'] <>""){
			$this->model->no_keahlian2 = $_POST['check2'];
			echo $_POST['check2'];
		}
		$this->model->simpanKonfTeknisi();
		redirect('admin/bukaHalamanKonfTeknisi');
	}
	
	public function bukaHalamanTeknisi(){
		$rows = $this->model->dataTeknisi();
		$rowsTekn = $this->model->dataTeknisiSMS();
		$rowsCust = $this->model->dataCustomerSMS();
		$this->load->view('admin_view_head', ['teknisi'=>'true', 'notifTek'=>$rowsTekn->num_rows(), 'notifCust'=>$rowsCust->num_rows()]);
		$this->load->view('daftar_teknisi', ['rows'=>$rows]);
		$this->load->view('admin_view_footer');
	}

	public function bukaHalamanTeknisiSMS(){
		$rowsTekn = $this->model->dataTeknisiSMS();
		$rowsCust = $this->model->dataCustomerSMS();
		$this->load->view('admin_view_head', ['smsmenu'=>'true', 'notifTek'=>$rowsTekn->num_rows(), 'notifCust'=>$rowsCust->num_rows()]);
		$this->load->view('daftar_teknisi', ['rows'=>$rowsTekn->result()]);
		$this->load->view('admin_view_footer');
	}
	
	public function bukaHalamanCustomer(){
		$rows = $this->model->dataCustomer();
		$rowsTekn = $this->model->dataTeknisiSMS();
		$rowsCust = $this->model->dataCustomerSMS();
		$this->load->view('admin_view_head', ['customer'=>'true', 'notifTek'=>$rowsTekn->num_rows(), 'notifCust'=>$rowsCust->num_rows()]);
		$this->load->view('daftar_customer', ['rows'=>$rows]);
		$this->load->view('admin_view_footer');
	}

	public function bukaHalamanCustomerSMS(){
		$rowsTekn = $this->model->dataTeknisiSMS();
		$rowsCust = $this->model->dataCustomerSMS();
		$this->load->view('admin_view_head', ['smsmenu'=>'true', 'notifTek'=>$rowsTekn->num_rows(), 'notifCust'=>$rowsCust->num_rows()]);
		$this->load->view('daftar_customer', ['rows'=>$rowsCust->result()]);
		$this->load->view('admin_view_footer');
	}

	public function getNotificationTekn(){
		$rowsTekn = $this->model->dataTeknisiSMS();

		echo $rowsTekn->num_rows();
	}

	public function getNotificationCust(){
		$rowsCust = $this->model->dataCustomerSMS();

		echo $rowsCust->num_rows();
	}
}
?>