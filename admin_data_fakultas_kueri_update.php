<?php
	include("config/config.php");
	
	include("_session_tata_usaha.php");
		
	$kd_fakultas_old = $_POST['kd_fakultas_old'];
	$kd_fakultas = $_POST['kd_fakultas'];
	$nama_fakultas = $_POST['nama_fakultas'];
	
	// Perform an SQL query
	$sql = "UPDATE mst_fakultas SET
				kd_fakultas = '$kd_fakultas',
				nama_fakultas = '$nama_fakultas'
			WHERE kd_fakultas = '$kd_fakultas_old'";
	
	if (!$result = $mysqli->query($sql)) {
		// Oh no! The query failed. 
		echo "Sorry, the website is experiencing problems.";

		// Again, do not do this on a public site, but we'll show you how
		// to get the error information
		echo "Error: Our query failed to execute and here is why: \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		header('location:admin_data_fakultas_ubah.php?fail='.$mysqli->errno);
	} else {
		header('location:admin_data_fakultas_lihat.php?success=2');
	}
?>