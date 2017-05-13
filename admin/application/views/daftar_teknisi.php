<h3>Data Teknisi</h3>
<table class="table table-bordered table-hover" id="dataTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jkel</th>
            <th>No Telp</th>
            <th>Keahlian</th>
            <th>Kode Ver</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($rows as $row) { 
			$sql_keahlian = "SELECT*FROM ahli a INNER JOIN keahlian k ON a.no_keahlian = k.no_keahlian WHERE a.id_teknisi = '$row->id_teknisi' AND a.status = 1";
			$query_keahlian = $this->db->query($sql_keahlian);
			$data_keahlian = $query_keahlian->result();
			//$data_keahlian = $this->admin(keahlianTeknisi($row->id_teknisi));
		?>
        <tr>
            <td><?php echo $row->id_teknisi;?></td>
            <td><?php echo $row->nama;?></td>
            <td><?php echo $row->email;?></td>
            <td><?php echo $row->jkel;?></td>
            <td><?php echo $row->telp;?></td>
            <td><?php 
					foreach ($data_keahlian as $baris){ echo "[".$baris->keahlian."] "; }
			?></td>
            <td><?php if($row->kode_ver<>"")echo '<b class="text-primary">'.$row->kode_ver.'</b>';?></td>
            <td><?php echo $row->rating;?></td>
            <td><?php echo $row->status;?></td>
            <td align="center"><a href="#" data-toggle="modal" data-target="#modal_konfirmasi" class="btn btn-xs btn-primary btnKonfirmasi" id_teknisi="<?php echo $row->id_teknisi;?>"><span class="glyphicon glyphicon-ok"></span></a>
            <a href="crud_p11/delete/<?php echo $row->id_teknisi;?>" data-toggle="modal" data-target="#modal_hapus" class="btn btn-xs btn-danger btnHapus"><span class="glyphicon glyphicon-remove"></span> </a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<div class="modal fade" id="modal_konfirmasi" tabindex="-1" role="dialog" aria-labelledby="LabelModalEdit">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
        	<form method="post" action="<?php echo site_url('admin/simpanKonfTeknisi');?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="LabelModalTambah">Konfirmasi Teknisi</h4>
            </div>
            <div class="modal-body">
            	<div class="container">
                    <h5>Pilih keahlian untuk dikonfirmasi</h5>
                    <input type="hidden" name="id_teknisi" id="id_teknisi" />
                    <div id="resultFormKonf"></div>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-ok"></span> Konfirmasi</button>
            </div>
            </form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_hapus" tabindex="-1" role="dialog" aria-labelledby="LabelModalEdit">
	<div class="modal-dialog" role="document">
    	<div class="modal-content">
        	<form method="post" action="laundryMasukHapus_proses.php">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="LabelModalTambah">Apakah Anda yakin akan menghapus data ini ?</h4>
            </div>
            <div class="modal-body">
            	<center><b id="no_laundryHapuslbl" style="font-size:36px; color:red;"></b></center>
                <input type="hidden" name="no_laundryHapus" id="no_laundryHapus" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-remove"></span> Hapus</button>
            </div>
            </form>
		</div>
	</div>
</div>
<script>
$(function(){
	$('.btnKonfirmasi').click(function(){
		$('#id_teknisi').val($(this).attr('id_teknisi'));
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('admin/ajaxFormKonfTeknisi/'); ?>",
			//dataType: 'json',
			data: {id_teknisi: $(this).attr('id_teknisi')},
			success: function(data) {
				$('#resultFormKonf').html(data);
			}
		});
	});
});
</script>