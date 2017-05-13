<?php
include 'Koneksi.php';
$response = array();
$data_items = array();
date_default_timezone_set("Asia/Jakarta");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (isset($_REQUEST['dataProses'])) {
		if (isset($_POST['email'])) {
			$getData = mysqli_query($db, "SELECT p.*, k.*, c.* FROM pemesanan p INNER JOIN keahlian k ON p.no_keahlian = k.no_keahlian INNER JOIN customer c ON p.id_customer = c.id_customer LEFT JOIN teknisi t ON p.id_teknisi = t.id_teknisi WHERE p.id_teknisi = 0 OR t.email = '$_POST[email]' ORDER BY no_pemesanan DESC");

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
						'id_teknisi' => $isi_data["id_teknisi"]
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