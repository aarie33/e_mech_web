<?php
if(isset($_REQUEST['id_teknisi'])){ ?>
	<input type="checkbox" name="check" id="check" required > <?php
	$query_keahlian = $this->db->query("SELECT*FROM ahli a INNER JOIN keahlian k ON a.no_keahlian = k.no_keahlian WHERE a.id_teknisi = '$_REQUEST[id_teknisi]' AND a.status = 0");
	$data_keahlian = $query_keahlian->result();
	$x=0;
	foreach ($data_keahlian as $row) { $x++;?>
	<input type="checkbox" name="check<?php echo $x;?>" id="check<?php echo $x;?>" value="<?php echo $row->no_keahlian;?>" onClick="req()" /> <?php echo $row->keahlian;?> <br />
<?php
	} ?>
    <script>
	$(function(){
		$('#check').hide();
	});
	function req(){
		var x = <?php echo $x;?>;
		if(x == 1){
			if(document.getElementById('check1').checked == true){
				document.getElementById('check').checked = true;
			}else{
				document.getElementById('check').checked = false;
			}
		}else if(x == 2){
			if(document.getElementById('check1').checked == true || document.getElementById('check2').checked == true){
				document.getElementById('check').checked = true;
			}else{
				document.getElementById('check').checked = false;
			}
		}
	}
	</script>
<?php
}
?>