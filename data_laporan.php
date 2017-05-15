<!DOCTYPE html>
<?php
	session_start();
?>
<html lang="en">
  <?php
	include("header.php");
  ?>
  <body>
	<header>		
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="navigation">
				<?php
					include("menu.php");
				?>
			</div>
		</nav>		
	</header>
	
	<div id="breadcrumb">
		<div class="container">	
			<div class="breadcrumb">							
				<li><a href="index.php">Beranda</a></li>
				<li>Data Laporan</li>			
			</div>		
		</div>	
	</div>
	
	<?php
		include("head.php");
	?>
	
	<div class="services">
		<div class="container">
			<h3>Data Laporan</h3>
			<hr>
			<div>
				<center>
					<h4>Mahasiswa/i</h4>
					<a href="data_laporan_mahasiswa.php"><img src="images/student.png" class="img-responsive" width="100"></a>
				</center>
			</div>
			<div class="col-md-4">
				<center>
					<h4>Ruang Kelas</h4>
					<a href="data_laporan_ruang_kelas.php"><img src="images/student.png" class="img-responsive" width="100"></a>
				</center>
			</div>
			<div class="col-md-4">
				<center>
					<h4>Laboratorium</h4>
					<a href="data_laporan_laboratorium.php"><img src="images/student.png" class="img-responsive" width="100"></a>
				</center>
			</div>
			<div class="col-md-4">
				<center>
					<h4>Mata Kuliah</h4>
					<a href="data_laporan_mata_kuliah.php"><img src="images/student.png" class="img-responsive" width="100"></a>
				</center>
			</div>
		</div>
	</div>
	
	<?php
		include("footer.php");
	?>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-2.1.1.min.js"></script>	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/jquery.isotope.min.js"></script>  
	<script src="js/wow.min.js"></script>
    <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
	<script src="js/functions.js"></script>
    <script src="contactform/contactform.js"></script>
    
</body>
</html>