<h3>Data Customer</h3>
<table class="table table-bordered table-hover" id="dataTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jkel</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Kode Ver</th>
            <th>Rating</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($rows as $row) { ?>
        <tr>
            <td><?php echo $row->id_customer;?></td>
            <td><?php echo $row->nama;?></td>
            <td><?php echo $row->email;?></td>
            <td><?php echo $row->jkel;?></td>
            <td><?php echo $row->telp;?></td>
            <td><?php echo $row->alamat;?></td>
            <td><?php if($row->kode_ver<>"")echo '<b class="text-primary">'.$row->kode_ver.'</b>';?></td>
            <td><?php echo $row->rating;?></td>
            <td align="center"><a href="#" data-toggle="modal" data-target="#modal_edit" class="btn btn-xs btn-warning btnEdit"><span class="glyphicon glyphicon-pencil"></span></a>
            <a href="#" data-toggle="modal" data-target="#modal_hapus" class="btn btn-xs btn-danger btnHapus"><span class="glyphicon glyphicon-trash"></span> </a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
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