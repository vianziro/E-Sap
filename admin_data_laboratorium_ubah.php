<!DOCTYPE html>
<?php
	session_start();
	include("_session_tata_usaha_program_studi.php");
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
				<li><a href="admin_data_perkuliahan.php">Data Perkuliahan</a></li>
				<li>Ubah Laboratorium</li>			
			</div>		
		</div>	
	</div>
	
	<?php
		include("head.php");
	?>
	
	</br>
	
	<script>
		function checkAvailability() {
			$("#loaderIcon").show();
			jQuery.ajax({
				url		: "check_availability_kd_ruang_ubah.php",
				data	: 'kd_ruang='+$("#kd_ruang").val()+'&kd_ruang_old='+$("#kd_ruang_old").val(),
				type	: "POST",
				success	: function(data){
					$("#user-availability-status").html(data);
					$("#loaderIcon").hide();
				},
				error	: function (){
				
				}
			});
		}
	</script>
	
	<section id="contact-page">
        <div class="container">
            <div class="center">
                <h2>Data Laboratorium</h2>
            </div> 
            <div class="row contact-wrap">
				<?php
					if (isset($_GET['fail']) && $_GET['fail'] == 1062) {
				?>
					<div class="alert alert-danger" role="alert">
						<center><strong>Gagal Ubah Data!</strong>. Kode Laboratorium Telah Terdaftar.</center>
					</div>
				<?php
					} else if (isset($_GET['fail'])) {
				?>
					<div class="alert alert-danger" role="alert">
						<center><strong>Gagal Ubah Data!</strong>.</center>
					</div>
				<?php
					}
				?>
					
				<?php
					if (isset($_GET['ubah'])) {
						$kd_ruang = $_GET['ubah'];
				?>
                <div class="col-md-6 col-md-offset-3">
                    <div id="sendmessage">Your message has been sent. Thank you!</div>
                    <div id="errormessage"></div>
					
					<?php
						require ("config/config.php");
						$sql = "SELECT * FROM laboratorium WHERE kd_ruang='$kd_ruang'";
						if (!$result = $mysqli->query($sql)) {
							$message = "Sorry, the website is experiencing problems.";
							echo "<script type='text/javascript'>alert('$message');</script>";
							exit;
						}
						
						while ($data = $result->fetch_assoc()) {
							$nama_lab = $data['nama_lab'];
							$semester = $data['semester'];
							$kd_prodi = $data['kd_prodi'];
							$nik_dosen_pj = $data['nik_dosen_pj'];
						}
						
						$sql2 = "SELECT * from mst_program_studi WHERE kd_prodi = '$kd_prodi'";
						if (!$result2 = $mysqli->query($sql2)) {
							$message2 = "Sorry, the website is experiencing problems.";
							echo "<script type='text/javascript'>alert('$message2');</script>";
						}
						$data2 = $result2->fetch_assoc();
						
						$sql3 = "SELECT * from mst_fakultas WHERE kd_fakultas = '".$data2['kd_fakultas']."'";
						if (!$result3 = $mysqli->query($sql3)) {
							$message3 = "Sorry, the website is experiencing problems.";
							echo "<script type='text/javascript'>alert('$message3');</script>";
						}
						$data3 = $result3->fetch_assoc();
					?>
						
                    <form action="admin_data_laboratorium_kueri_update.php" method="post" role="form" class="contactForm">
						<div class="form-group">
								<select class="form-control" name="nama_fakultas" id="nama_fakultas">
									<option value="" disabled selected>Pilih Fakultas</option>
									<?php
										require ("config/config.php");
										if ($_SESSION['kd_prodi'] == "") {
											$sql = "SELECT * from mst_fakultas";
										} else {
											$sql2 = "SELECT * from mst_program_studi WHERE kd_prodi = '".$_SESSION['kd_prodi']."'";
											if (!$result2 = $mysqli->query($sql2)) {
												$message2 = "Sorry, the website is experiencing problems.";
												echo "<script type='text/javascript'>alert('$message2');</script>";
											}
											$data2 = $result2->fetch_assoc();
											echo $data2['nama_prodi'];
											
											$sql = "SELECT * from mst_fakultas WHERE kd_fakultas = '".$data2['kd_fakultas']."'";
										}
										if (!$result = $mysqli->query($sql)) {
											$message = "Sorry, the website is experiencing problems.";
											echo "<script type='text/javascript'>alert('$message');</script>";
										}
									?>
									<?php
										while ($data = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $data['nama_fakultas'];?>"
									<?php
										if (isset($_GET['nama_fakultas']) && $_GET['nama_fakultas'] == $data['nama_fakultas']) {
											echo ' selected="selected"';
										} else if (!isset($_GET['nama_fakultas']) && $data3['nama_fakultas'] == $data['nama_fakultas']) {
											echo ' selected="selected"';
										}
									?>
										>
									<?php
											echo $data['nama_fakultas'];
									?>
										</option>
									<?php
										}
									?>
								</select>
								<script>
									$('#nama_fakultas').on('change', function() {
										var nama_fakultas = this.value;
										var kd_ruang_old = $('#kd_ruang_old').val();
										
										if (nama_fakultas != "") {
											$.post('ajax_get_kode_fakultas.php', {nama_fakultas:nama_fakultas},
											function(data) {
												window.location.href = window.location.pathname + "?ubah=" + kd_ruang_old + "&kd_fakultas=" + data + "&nama_fakultas=" + nama_fakultas;
											});
										}
										else {
											window.location.href = window.location.pathname;
										}
									});
								</script>
								<div class="validation"></div>
						</div>
						<div class="form-group">
								<select class="form-control" name="nama_prodi" id="nama_prodi">
									<option value="" disabled selected>Pilih Program Studi</option>
									<?php
										if (isset($_GET['kd_fakultas'])) {
											$kd_fakultas = $_GET['kd_fakultas'];
											require ("config/config.php");
											$sql = "SELECT * from mst_program_studi WHERE kd_fakultas = '$kd_fakultas'";
											if (!$result = $mysqli->query($sql)) {
												$message = "Sorry, the website is experiencing problems.";
												echo "<script type='text/javascript'>alert('$message');</script>";
											}
										} else {
											require ("config/config.php");
											$sql = "SELECT * from mst_program_studi WHERE kd_fakultas = '".$data2['kd_fakultas']."'";
											if (!$result = $mysqli->query($sql)) {
												$message = "Sorry, the website is experiencing problems.";
												echo "<script type='text/javascript'>alert('$message');</script>";
											}
										}
									?>
									<?php
										while ($data = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $data['nama_prodi'];?>" 
									<?php
										if (isset($_GET['nama_fakultas'])) {
											// do nothing
										} else if (!isset($_GET['nama_fakultas']) && $data2['nama_prodi'] == $data['nama_prodi']) {
											echo ' selected="selected"';
										}
									?>
										>
									<?php
											echo $data['nama_prodi'];
									?>
										</option>
									<?php
										}
									?>
								</select>
								<script>
									$('#nama_prodi').on('change', function() {
										var nama_prodi = this.value;
										
										if (nama_prodi != "") {
											$.post('ajax_get_kode_program_studi.php', {nama_prodi:nama_prodi},
											function(data) {
												$('#kd_prodi').val(data);
											});
										}
										else {
											$('#kd_prodi').val("");
										}
									});
								</script>
								<div class="validation"></div>
						</div>
						<div class="form-group">
								<input type="text" class="form-control" name="kd_prodi" id="kd_prodi" placeholder="Kode Program Studi" data-rule="minlen:4" data-msg="Please enter at least 4 chars" style="pointer-events:none; background:#F0F0F0;" required value="<?php echo $kd_prodi; ?>"/>
								<div class="validation"></div>
						</div>
						<div class="form-group">
								<input type="hidden" class="form-control" name="kd_ruang_old" id="kd_ruang_old" required value="<?php echo $kd_ruang; ?>"/>
								<input type="text" class="form-control" name="kd_ruang" id="kd_ruang" placeholder="Kode Laboratorium" data-rule="minlen:4" data-msg="Please enter at least 4 chars" onBlur="checkAvailability()" required value="<?php echo $kd_ruang; ?>"/>
								<span id="user-availability-status"></span>
								<p><img src="images/LoaderIcon.gif" id="loaderIcon" style="display:none" width="100" height="70"/></p>
								<div class="validation"></div>
						</div>
						<div class="form-group">
								<input type="text" class="form-control" name="nama_lab" id="nama_lab" placeholder="Nama Laboratorium" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" required value="<?php echo $nama_lab; ?>"/>
								<div class="validation"></div>
						</div>
						<div class="form-group">
								<select class="form-control" name="nama_dosen" id="nama_dosen">
									<option value="" disabled selected>Pilih Dosen Penanggung Jawab</option>
									<?php
										if (isset($_SESSION['kd_prodi'])) {
											$kd_prodi = $_SESSION['kd_prodi'];
											require ("config/config.php");
											$sql = "SELECT * from mst_dosen WHERE kd_prodi = '$kd_prodi'";
											if (!$result = $mysqli->query($sql)) {
												$message = "Sorry, the website is experiencing problems.";
												echo "<script type='text/javascript'>alert('$message');</script>";
											}
										}
									?>
									<?php
										while ($data = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $data['nama_dosen'];?>"
									<?php
										if ($nik_dosen_pj == $data['nik']) {
											echo ' selected="selected"';
										}
									?>
										>
									<?php
											echo $data['nama_dosen'];
									?>
										</option>
									<?php
										}
									?>
								</select>
								<script>
									$('#nama_dosen').on('change', function() {
										var nama_dosen = this.value;
										
										if (nama_dosen != "") {
											$.post('ajax_get_nik_dosen.php', {nama_dosen:nama_dosen},
											function(data) {
												$('#nik_dosen_pj').val(data);
											});
										}
										else {
											$('#nik_dosen_pj').val("");
										}
									});
								</script>
								<div class="validation"></div>
						</div>
						<div class="form-group">
								<input type="text" class="form-control" name="nik_dosen_pj" id="nik_dosen_pj" placeholder="NIK Dosen Penanggung Jawab" data-rule="minlen:4" data-msg="Please enter at least 4 chars" style="pointer-events:none; background:#F0F0F0;" required value="<?php echo $nik_dosen_pj; ?>"/>
								<div class="validation"></div>
						</div>
                        <div class="text-center"><button type="submit" name="submit" class="btn btn-primary btn-lg" required="required">Ubah</button></div>
                    </form>
                </div>
				<?php
					} else {
						header('location:admin_data_laboratorium_lihat.php');
					}
				?>
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-page-->
	
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