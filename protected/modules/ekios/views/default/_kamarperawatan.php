<style type="text/css">
	.imgruangan{
		width: 295px;
		height: 150px;
	}
</style>
<div class="block-kioskmodule" id="kamarperawatan" name="kamarperawatan">
	<legend class="rim">KAMAR PERAWATAN</legend><hr>
	<div class="contentKamar" style="max-height:400px;overflow-y: scroll;">
		<?php
			$ruang = RuanganM::model()->findAll('instalasi_id = '.Params::INSTALASI_ID_RI.'order by ruangan_nama');
		foreach ($ruang as $data => $nilai) {
			if(empty($nilai->ruangan_image) || $nilai->ruangan_image==''){
				$gambar = "images/noimage.jpg";
			}else{
				$gambar = "images/icon_menu/".$nilai->ruangan_image;
			}
	?>
			<div class="paket">
				<ul>
					<li class="bedpaket">
						<div class="popover-inner">
							<div class="popover-title-pak">
								<center>
									<!-- <img width="200" height="60" src="images/default.jpg" alt=""> -->
									<img class="imgruangan" width="295" height="60" src="<?php echo $gambar ?>" alt="">
								</center>
							</div>
							<h4 class="popover-title-pak"><?php echo $nilai->ruangan_nama; ?></h4>
							<div class="popover-content"><b>Fasilitas:</b><br><?php echo $nilai->ruangan_fasilitas; ?>
							</div>
						</div>
					</li>
				</ul>
			</div>
	<?php 
		} 
	?>
	</div>
</div>	
