<?php
include 'Koneksi.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_REQUEST['daftarTeknisi'])){
		if(isset($_POST['nama']) and isset($_POST['email']) and isset($_POST['jkel']) and isset($_POST['no_telp']) and isset($_POST['password']) and (isset($_POST['ahliLaptop']) or isset($_POST['ahliKomputer']))){

			$data_tek = mysqli_query($db, "SELECT*FROM teknisi WHERE email='$_POST[email]'");
			$jlh_tek = mysqli_num_rows($data_tek);

			if ($jlh_tek <>0 ) {
				$response['error'] = true;
				$response['message'] = "Email telah terdaftar, silahkan masukkan email lain";
			}else{
				$password = md5($_POST['password']);
				$insertTeknisi = mysqli_query($db, "INSERT INTO teknisi VALUES(null,'$_POST[nama]', '$_POST[email]', '$_POST[no_telp]', '$_POST[jkel]', '$password','', 0, '', 0)");

				if($insertTeknisi){
					$cari_tek = mysqli_query($db, "SELECT*FROM teknisi WHERE email='$_POST[email]'");
					$isi_tek = mysqli_fetch_array($cari_tek);

					$cari_ahliLap = mysqli_query($db, "SELECT*FROM keahlian WHERE keahlian = '$_POST[ahliLaptop]'");
					$jlh_ahliLap = mysqli_num_rows($cari_ahliLap);
					if ($jlh_ahliLap <>0) {
						$isi_ahliLap = mysqli_fetch_array($cari_ahliLap);
						$insertKeahlian1 = mysqli_query($db, "INSERT INTO ahli VALUES('$isi_tek[id_teknisi]', '$isi_ahliLap[no_keahlian]',0)");
					}

					$cari_ahliKomp = mysqli_query($db, "SELECT*FROM keahlian WHERE keahlian = '$_POST[ahliKomputer]'");
					$jlh_ahliKomp = mysqli_num_rows($cari_ahliKomp);
					if ($jlh_ahliKomp <>0) {
						$isi_ahliKomp = mysqli_fetch_array($cari_ahliKomp);
						$insertKeahlian2 = mysqli_query($db, "INSERT INTO ahli VALUES('$isi_tek[id_teknisi]', '$isi_ahliKomp[no_keahlian]',0)");
					}

					if ($insertKeahlian1 || $insertKeahlian2) {
						$data_tekn = mysqli_query($db, "SELECT*FROM teknisi WHERE email='$_POST[email]'");
						$isi_tekn = mysqli_fetch_array($data_tekn);
						$response['error'] = false;
						$response['message'] = "Registrasi sukses";
						$response['email'] = $isi_tekn['email'];
						$response['nama'] =  $isi_tekn['nama'];
						$response['status'] =  $isi_tekn['status'];
					}else{
						mysqli_query($db, "DELETE FROM teknisi WHERE email = '$_POST[email]'");
						mysqli_query($db, "DELETE FROM ahli WHERE id_teknisi = '$isi_tek[id_teknisi]'");
						$response['error'] = true;
						$response['message'] = "Data gagal disimpan";
					}
				}else{
					$response['error'] = true;
					$response['message'] = "Data gagal disimpan";
				}
			}

		}else{
			$response['error'] = true;
			$response['message'] = "Terdapat field yang kosong";
		}
	}elseif(isset($_REQUEST['loginTeknisi'])){
		if(isset($_POST['username']) and isset($_POST['password'])){
			$password = md5($_POST['password']);
			$login = mysqli_query($db, "SELECT*FROM teknisi WHERE email = '$_POST[username]' AND password = '$password'");
			$jlh_login = mysqli_num_rows($login);
			
			if($jlh_login <> 0){
				$isi_login = mysqli_fetch_array($login);
				$response['error'] = false;
				$response['message'] = "Login sukses";
				$response['email'] = $isi_login['email'];
				$response['nama'] =  $isi_login['nama'];
				$response['status'] =  $isi_login['status'];
			}else{
				$response['error'] = true;
				$response['message'] = "Login gagal";
			}
		}else{
			$response['error'] = true;
			$response['message'] = "Terdapat field yang kosong";
		}
	}elseif(isset($_REQUEST['lupaPasswordTeknisi'])){
		if(isset($_POST['email']) && isset($_POST['telp'])){
			$cek_email = mysqli_query($db, "SELECT*FROM teknisi WHERE email = '$_POST[email]' AND telp = '$_POST[telp]'");
			$jlh_cek = mysqli_num_rows($cek_email);
			if($jlh_cek<>0){
				$data_teknisi = mysqli_query($db, "SELECT*FROM teknisi WHERE email = '$_POST[email]'");
				$isi_teknisi = mysqli_fetch_array($data_teknisi);
				$kode = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
				$simpanKode = mysqli_query($db, "UPDATE teknisi SET kode_ver = '$kode' WHERE email = '$_POST[email]'");
				
				/*$to       = $_POST['email'];
				$subject  = "Kode Verifikasi E-Mech";
				$message  = "<center><h2>E-Mech</h2></center><br>Halo $isi_teknisi[nama], <br>Selamat Datang di E-Mech <br>Kode verifikasi untuk mengembalikan akun Anda adalah : <h2>$kode</h2><br><br>Admin<br>E-Mech"; 
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
	}elseif(isset($_REQUEST['verifikasiTeknisi'])){
		if(isset($_POST['email']) and isset($_POST['kode'])){
			$cek_kode = mysqli_query($db, "SELECT*FROM teknisi WHERE email = '$_POST[email]'");
			$jlh_kode = mysqli_num_rows($cek_kode);
			
			if($jlh_kode <> 0){
				$isi_kode = mysqli_fetch_array($cek_kode);
				if($_POST['kode'] == $isi_kode['kode_ver']){
					mysqli_query($db, "UPDATE teknisi SET kode_ver = '' WHERE email = '$_POST[email]'");
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
	}elseif(isset($_REQUEST['gantiPassTeknisi'])){
		if(isset($_POST['email']) and isset($_POST['password'])){
			$password = md5($_POST['password']);
			$ganti_pass = mysqli_query($db, "UPDATE teknisi SET password = '$password' WHERE email = '$_POST[email]'");
			if($ganti_pass){
				$data_tek = mysqli_query($db, "SELECT*FROM teknisi WHERE email = '$_POST[email]' AND password = '$password'");
				$isi_tek = mysqli_fetch_array($data_tek);
				$response['error'] = false;
				$response['message'] = "Password berhasil disimpan";
				$response['email'] = $isi_tek['email'];
				$response['nama'] =  $isi_tek['nama'];
				$response['status'] =  $isi_tek['status'];
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