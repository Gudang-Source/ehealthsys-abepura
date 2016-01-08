
		<div id="carousel-kiosk" >
			<ul>
				<li><img alt="" src="images/default.jpg" width="975" height="415" /><p><?php echo Yii::app()->user->getState('nama_rumahsakit'); ?></p>
				</li>
			<?php
				$modPicture = ProfilpictureM::model()->getPicture();
				if(!empty($modPicture)){
					foreach ($modPicture as $i => $picture){
						$path 			= $picture['profilpicture_path'];
						$description 	= $picture['profilpicture_desc'];
						$nama 			= $picture['profilpicture_nama'];
			?>
						<li><img alt="" src="<?php echo $path ?>" width="975" height="415"/>
							<p><?php echo $nama."<br>".$description ?></p>
						</li>
			<?php			
					} // akhir dari looping foreach
				}else{
			?>
					<li><img alt="" src="images/Kartu.jpg" width="975" height="415" /><p>Gambar belum tersedia di database</p>
					</li>
			<?php					
				} // akhir dari kondisi
			?>
			</ul>
		</div>
