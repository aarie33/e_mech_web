<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Administrator E-Mech</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<style>
	.navbar-custom {
		background-color:#dd2c00;
		color:#FFF;
		border-radius:0;
	}
	.navbar-custom .navbar-nav > li > a {
		color:#FFF;
	}
	.navbar-custom .navbar-nav > .active > a, .navbar-nav > .active > a:hover, .navbar-nav > .active > a:focus, #side-menu li .active
	{
		background-color:#a30000;
		color: #FFF;
	}
		  
	.navbar-custom .navbar-nav > li > a:hover, .nav > li > a:focus {
		text-decoration: none;
		background-color: #a30000;
	}
		  
	.navbar-custom .navbar-brand {
		color:#FFF;
	}
	.navbar-custom .navbar-toggle {
		background:#dd2c00;
	}
	.navbar-custom .icon-bar {
		background:#FFF;
	}
	</style>

    <script>
    var jlh_notifTekn = null;
    var jlh_notifCust = null;
      document.addEventListener('DOMContentLoaded', function () {
      if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.'); 
        return;
      }

      if (Notification.permission !== "granted")
        Notification.requestPermission();
    });

    function showNotifTekn(jlh) {
      if (Notification.permission !== "granted")
        Notification.requestPermission();
      else {
          var notification = new Notification('Notifikasi Teknisi', {
            icon: 'https://assets.materialup.com/uploads/c8f04d47-fc5d-40f5-8e70-6910ddd06a6d/preview',
            body: jlh + " Notifikasi kode SMS baru untuk Teknisi",
          });

          notification.onclick = function () {
            window.focus();
            window.close();
            window.open("<?php echo site_url('admin/bukaHalamanTeknisiSMS');?>");
            notification.close();
          };
      }
    }

    function showNotifCust(jlh) {
      if (Notification.permission !== "granted")
        Notification.requestPermission();
      else {
          var notification = new Notification('Notifikasi Customer', {
            icon: 'https://assets.materialup.com/uploads/c8f04d47-fc5d-40f5-8e70-6910ddd06a6d/preview',
            body: jlh + " Notifikasi kode SMS baru untuk Customer",
          });

          notification.onclick = function () {
            window.focus();
            window.close();
            window.open("<?php echo site_url('admin/bukaHalamanCustomerSMS');?>");      
            notification.close();
          };
      }
    }

    function getNotifTekn(){
      $.ajax({
        url:'<?php echo site_url('admin/getNotificationTekn');?>',
        success:
          function (data){
            if(jlh_notifTekn == null){
              jlh_notifTekn = data;
              //showNotifTekn(data);
            }else{
              if(data>jlh_notifTekn){
                showNotifTekn(data);
                jlh_notifTekn = data;
              }else{
                jlh_notifTekn = data;
              }
            }
            setTimeout(function(){
              getNotifTekn();
            }, 10000);
          }
      });
    }

    function getNotifCust(){
      $.ajax({
        url:'<?php echo site_url('admin/getNotificationCust');?>',
        success:
          function (data){
            if(jlh_notifCust == null){
              jlh_notifCust = data;
              //showNotifCust(data);
            }else{
              if(data>jlh_notifCust){
                showNotifCust(data);
                jlh_notifCust = data;
              }else{
                jlh_notifCust = data;
              }
            }
            setTimeout(function(){
              getNotifCust();
            }, 10000);
          }
      });
    }

    $(function(){
      getNotifTekn();
      getNotifCust();
    });
  </script>

</head>
<body>
<nav class="navbar navbar-custom">
  <div class="container-fluid">
    <div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
      <a class="navbar-brand" href="#">Administrator E-Mech</a>
    </div>
    <div class="navbar-collapse collapse">
	    <ul class="nav navbar-nav">
	      <li><a href="#">Home</a></li>
          <li <?php if(isset($konfTeknisi)){ echo 'class="active"';}?>><a href="<?php echo site_url('admin/bukaHalamanKonfTeknisi');?>">Teknisi Baru</a></li>
          <li <?php if(isset($teknisi)){ echo 'class="active"';}?>><a href="<?php echo site_url('admin/bukaHalamanTeknisi');?>">Teknisi</a></li>
          <li <?php if(isset($customer)){ echo 'class="active"';}?>><a href="<?php echo site_url('admin/bukaHalamanCustomer');?>">Customer</a></li>
          <li class="dropdown <?php if(isset($smsmenu)){ echo 'active';}?>">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              Kode SMS <?php $notifAll = $notifTek + $notifCust; 
                  if($notifTek>0){
                    echo '<span class="label label-primary">'.$notifAll.'</span>';
                    } ?>
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li>
                <a href="<?php echo site_url('admin/bukaHalamanTeknisiSMS');?>">
                  SMS Teknisi <?php if($notifTek>0){echo '<span class="label label-primary">'.$notifTek.'</span>';} ?>
                </a>
                <a href="<?php echo site_url('admin/bukaHalamanCustomerSMS');?>">
                  SMS Customer <?php if($notifCust>0){echo '<span class="label label-primary">'.$notifCust.'</span>';} ?>
                </a>
            </li>
                </ul>
          </li>
	    </ul>
        <ul class="nav navbar-nav navbar-right">
	      <li><a href="<?php echo site_url('admin/logout');?>"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
	    </ul>
	</div>
  </div>
</nav>
<div class="container">