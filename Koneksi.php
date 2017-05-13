<?php

$db = mysqli_connect('localhost', 'root', '', 'e_mech');

if (!$db) {
	echo "Database gagal terhubung ".mysqli_error();
}
?>