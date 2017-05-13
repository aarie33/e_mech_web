<?php
include 'Koneksi.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_REQUEST['daftarCust'])){
		if(isset($_POST['nama']) and isset($_POST['email']) and isset($_POST['jkel']) and isset($_POST['no_telp']) and isset($_POST['password']) and isset($_POST['alamat'])){

			$data_cust = mysqli_query($db, "SELECT*FROM customer WHERE email='$_POST[email]'");
			$jlh_cust = mysqli_num_rows($data_cust);

			if ($jlh_cust <>0 ) {
				$response['error'] = true;
				$response['message'] = "Email telah terdaftar, silahkan masukkan email lain";
			}else{
				$password = md5($_POST['password']);
				$insertCust = mysqli_query($db, "INSERT INTO customer VALUES(null,'$_POST[nama]', '$_POST[email]', '$_POST[no_telp]', '$_POST[jkel]', '$_POST[alamat]', '$password','', 0, '')");

				if($insertCust){	
					$data_custm = mysqli_query($db, "SELECT*FROM customer WHERE email='$_POST[email]'");
					$isi_custm = mysqli_fetch_array($data_custm);
					$response['error'] = false;
					$response['message'] = "Registrasi sukses";
					$response['email'] = $isi_custm['email'];
					$response['nama'] =  $isi_custm['nama'];
					$response['telp'] =  $isi_custm['telp'];
					$response['jkel'] =  $isi_custm['jkel'];
					$response['alamat'] =  $isi_custm['alamat'];
				}else{
					$response['error'] = true;
					$response['message'] = "Data gagal disimpan";
				}
			}

		}else{
			$response['error'] = true;
			$response['message'] = "Terdapat field yang kosong";
		}
	}elseif(isset($_REQUEST['loginCust'])){
		if(isset($_POST['username']) and isset($_POST['password'])){
			$password = md5($_POST['password']);
			$login = mysqli_query($db, "SELECT*FROM customer WHERE email = '$_POST[username]' AND password = '$password'");
			$jlh_login = mysqli_num_rows($login);
			
			if($jlh_login <> 0){
				$isi_login = mysqli_fetch_array($login);
				$response['error'] = false;
				$response['message'] = "Login sukses";
				$response['email'] = $isi_login['email'];
				$response['nama'] =  $isi_login['nama'];
				$response['telp'] =  $isi_login['telp'];
				$response['jkel'] = $isi_login['jkel'];
				$response['alamat'] = $isi_login['alamat'];
			}else{
				$response['error'] = true;
				$response['message'] = "Login gagal";
			}
		}else{
			$response['error'] = true;
			$response['message'] = "Terdapat field yang kosong";
		}
	}elseif(isset($_REQUEST['lupaPasswordCust'])){
		if(isset($_POST['email']) && isset($_POST['telp'])){
			$cek_email = mysqli_query($db, "SELECT*FROM customer WHERE email = '$_POST[email]' AND telp = '$_POST[telp]'");
			$jlh_cek = mysqli_num_rows($cek_email);
			if($jlh_cek<>0){
				$data_customer = mysqli_query($db, "SELECT*FROM customer WHERE email = '$_POST[email]'");
				$isi_customer = mysqli_fetch_array($data_customer);
				$kode = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
				$simpanKode = mysqli_query($db, "UPDATE customer SET kode_ver = '$kode' WHERE email = '$_POST[email]'");
				
				/*$to       = $_POST['email'];
				$subject  = "Kode Verifikasi E-Mech";
				$message  = "<center><h2>E-Mech</h2></center><br>Halo $isi_customer[nama], <br>Selamat Datang di E-Mech <br>Kode verifikasi untuk mengembalikan akun Anda adalah : <h2>$kode</h2><br><br>Admin<br>E-Mech"; 
				// user dan password gmail
				$sender   = 'moneymanagerdev@gmail.com';
				$password = 'moneymanager321';
				//if(email_localhost($to, $subject, $message, $sender, $password)){*/
				if($simpanKode){
					$response['error'] = false;
					$response['message'] = "Kode akan dikirim ke nomor ".$_POST['telp'];
				}else{
					$response['error'] = true;
					$response['message'] = "Kode gagal dikirim";
				}
			}else{
				$response['error'] = true;
				$response['message'] = "Email atau nomor telepon tidak terdaftar";
			}
		}else{
			$response['error'] = true;
			$response['message'] = "Field email masih kosong";
		}
	}elseif(isset($_REQUEST['verifikasiCust'])){
		if(isset($_POST['email']) and isset($_POST['kode'])){
			$cek_kode = mysqli_query($db, "SELECT*FROM customer WHERE email = '$_POST[email]'");
			$jlh_kode = mysqli_num_rows($cek_kode);
			
			if($jlh_kode <> 0){
				$isi_kode = mysqli_fetch_array($cek_kode);
				if($_POST['kode'] == $isi_kode['kode_ver']){
					mysqli_query($db, "UPDATE customer SET kode_ver = '' WHERE email = '$_POST[email]'");
					$response['error'] = false;
					$response['message'] = "Verifikasi sukses";
				}else{
					$response['error'] = true;
					$response['message'] = "Kode yang Anda masukkan salah";
				}
			}else{
				$response['error'] = true;
				$response['message'] = "Email atau nomor telepon tidak terdaftar";
			}
		}else{
			$response['error'] = true;
			$response['message'] = "Field masih kosong";
		}
	}elseif(isset($_REQUEST['gantiPassCust'])){
		if(isset($_POST['email']) and isset($_POST['password'])){
			$password = md5($_POST['password']);
			$ganti_pass = mysqli_query($db, "UPDATE customer SET password = '$password' WHERE email = '$_POST[email]'");
			if($ganti_pass){
				$data_cust = mysqli_query($db, "SELECT*FROM customer WHERE email = '$_POST[email]' AND password = '$password'");
				$isi_cust = mysqli_fetch_array($data_cust);
				$response['error'] = false;
				$response['message'] = "Password berhasil disimpan";
				$response['email'] = $isi_cust['email'];
				$response['nama'] =  $isi_cust['nama'];
				$response['telp'] =  $isi_cust['telp'];
				$response['jkel'] =  $isi_cust['jkel'];
				$response['alamat'] =  $isi_cust['alamat'];
			}else{
				$response['error'] = true;
				$response['message'] = "Password gagal disimpan";
			}
		}else{
			$response['error'] = true;
			$response['message'] = "Field masih kosong";
		}
	}else{
		$response['error'] = true;
		$response['message'] = "Data gagal disimpan, periksa kembali URL";
	}
}
echo json_encode($response);
?>