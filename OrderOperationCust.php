<?php
include 'Koneksi.php';
$response = array();
$data_items = array();
date_default_timezone_set("Asia/Jakarta");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (isset($_REQUEST['orderBaru'])) {
		if (isset($_POST['deskripsi']) && isset($_POST['lokasi']) && isset($_POST['servis']) && isset($_POST['email'])) {
			$data_keahlian = mysqli_query($db, "SELECT*FROM keahlian WHERE keahlian LIKE '%$_POST[servis]%'");
			$jlh_keahlian = mysqli_num_rows($data_keahlian);

			if ($jlh_keahlian == 0 || $_POST['servis']== "") {
				$response['error'] = true;
				$response['message'] = "Servis tidak diketahui";
			}else{
				$isi_keahlian = mysqli_fetch_array($data_keahlian);
				$tgl = date('Y-m-d');
				$jam = date('H:i:s');
				$cari_email = mysqli_query($db, "SELECT*FROM customer WHERE email = '$_POST[email]'");
				$jlh_email = mysqli_num_rows($cari_email);

				if($jlh_email == 0){
					$response['error'] = true;
					$response['message'] = "Email tidak terdaftar";
				}else{
					$isi_email = mysqli_fetch_array($cari_email);
					/*$simpanOrder = mysqli_query($db, "INSERT INTO pemesanan VALUES(null, '$tgl', '$jam', '$_POST[deskripsi]', 0, '$_POST[lokasi]', '$isi_keahlian[no_keahlian]', '$isi_email[id_customer]', '')");
					if ($simpanOrder) {*/
						$getData = mysqli_query($db, "SELECT p.*, k.*, c.*, t.nama AS nama_teknisi FROM pemesanan p INNER JOIN keahlian k ON p.no_keahlian = k.no_keahlian INNER JOIN customer c ON p.id_customer = c.id_customer LEFT JOIN teknisi t ON p.id_teknisi = t.id_teknisi WHERE p.id_teknisi = 0 AND c.email = '$_POST[email]' ORDER BY no_pemesanan DESC");
						$isi_data = mysqli_fetch_array($getData);
						array_push($data_items,
							array('no_pemesanan' => $isi_data["no_pemesanan"],
							'tgl_pemesanan' => $isi_data["tgl_pemesanan"],
							'jam_pemesanan' => $isi_data["jam_pemesanan"],
							'deskripsi' => $isi_data["deskripsi"],
							'biaya' => $isi_data["biaya"],
							'tempat' => $isi_data["tempat"],
							'keahlian' => $isi_data["keahlian"],
							'id_teknisi' => $isi_data["id_teknisi"],
							'nm_teknisi' => $isi_data["nama_teknisi"]
							));

						$response['error'] = false;
						$response['message'] = "Order berhasil";
						$response['data'] = $data_items;
//					}else {
//						$response['error'] = true;
//						$response['message'] = "Order gagal";
//					}
				}
			}
		}else{
			$response['error'] = true;
			$response['message'] = "Terdapat field yang kosong";
		}
	}else if (isset($_REQUEST['dataProses'])) {
		if (isset($_POST['email'])) {
			$getData = mysqli_query($db, "SELECT p.*, k.*, c.*, t.nama AS nama_teknisi FROM pemesanan p INNER JOIN keahlian k ON p.no_keahlian = k.no_keahlian INNER JOIN customer c ON p.id_customer = c.id_customer LEFT JOIN teknisi t ON p.id_teknisi = t.id_teknisi WHERE p.id_teknisi = 0 AND c.email = '$_POST[email]' ORDER BY no_pemesanan DESC");

			if($getData){
				$response['error'] = false;
				$response['message'] = "Data terhubung";
				while($isi_data = mysqli_fetch_array($getData)){

					array_push($data_items,
						array('no_pemesanan' => $isi_data["no_pemesanan"],
						'tgl_pemesanan' => $isi_data["tgl_pemesanan"],
						'jam_pemesanan' => $isi_data["jam_pemesanan"],
						'deskripsi' => $isi_data["deskripsi"],
						'biaya' => $isi_data["biaya"],
						'tempat' => $isi_data["tempat"],
						'keahlian' => $isi_data["keahlian"],
						'id_teknisi' => $isi_data["id_teknisi"],
						'nm_teknisi' => $isi_data["nama_teknisi"]
						));
				}
				$response['data'] = $data_items;
				//echo json_encode(array("data"=>$data_items));

			}else{
				$response['error'] = true;
				$response['message'] = "Data tidak terhubung";
			}
		}
	}
}
echo json_encode($response);
?>