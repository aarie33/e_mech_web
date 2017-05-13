<?php
class admin_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function loginAdmin(){
		$sql = "SELECT*FROM admin WHERE username='$this->username' AND password='$this->password'";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function search(){
		$sql = "SELECT*FROM barang2 WHERE kode LIKE '%$this->cari%' or nama LIKE '%$this->cari%' or harga LIKE '%$this->cari%' or stok LIKE '%$this->cari%'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function dataTeknisiKonfirmasi(){
		$sql = "SELECT t.* FROM teknisi t INNER JOIN ahli a ON t.id_teknisi = a.id_teknisi WHERE t.status=0 OR a.status = 0 GROUP BY t.id_teknisi";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function dataTeknisiKeahlian(){
		$sql = "SELECT*FROM ahli a INNER JOIN keahlian k ON a.no_keahlian = k.no_keahlian WHERE a.id_teknisi = '$this->id_teknisi' AND a.status = 0";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function simpanKonfTeknisi(){
		if(isset($this->no_keahlian1)){
			$query = $this->db->query("UPDATE ahli SET status = 1 WHERE id_teknisi = '$this->id_teknisi' AND no_keahlian = '$this->no_keahlian1'");
		}
		if(isset($this->no_keahlian2)){
			$query = $this->db->query("UPDATE ahli SET status = 1 WHERE id_teknisi = '$this->id_teknisi' AND no_keahlian = '$this->no_keahlian2'");
		}
		$query = $this->db->query("UPDATE teknisi SET status = 1 WHERE id_teknisi = '$this->id_teknisi'");
	}
	
	public function dataTeknisi(){
		$sql = "SELECT*FROM teknisi WHERE status=1";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function dataTeknisiSMS(){
		$sql = "SELECT*FROM teknisi WHERE status=1 AND NOT kode_ver = ''";
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function dataCustomer(){
		$sql = "SELECT*FROM customer ORDER BY id_customer DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function dataCustomerSMS(){
		$sql = "SELECT*FROM customer WHERE NOT kode_ver = '' ORDER BY id_customer DESC";
		$query = $this->db->query($sql);
		return $query;
	}
}
?>