<style>
	.contentfasilitas{
		width: 467px;
		display: inline-table;
		margin-top: 10px;
		margin-bottom: 10px;
		margin-left: 15px;
		vertical-align: top;
		background-color: #FFFFFF;
	    border: 1px solid #559DCF;
	    border-radius: 3px 3px 3px 3px;
	    color: #6D6D6D;

	}
</style>
<div class="block-kioskmodule" id="fasilitas" name="fasilitas">
	<legend class="rim">FASILITAS</legend>
	<div class="contentKamar" style="max-height:400px;overflow-y: scroll;">
		<?php 
			$modFasilitas = FasilitasS::model()->findAll('fasilitasaktif = TRUE ORDER BY namafasilitas');
			$jmlfas = count($modFasilitas);
		?>
		<input type="hidden" id="jmlfas" name="jmlfas" value="<?php echo $jmlfas ?>"> <!-- untuk jumlah fasilitas yang akan digunakan di js -->
		<?php
			$i = 1;
			foreach ($modFasilitas as $key => $datafasilitas) {
			
		?>
			<div class="contentfasilitas">
				<h4 class="popover-title-pak"><?php echo $datafasilitas->namafasilitas ?></h4>
			    <div id="carousel-fasilitas<?php echo $i ?>">
					<ul>
						<?php 
							$modFasilitasGalery = FasilitasgaleryS::model()->findAll('fasilitas_id ='.$datafasilitas->fasilitas_id);

							foreach ($modFasilitasGalery as $key => $datagalery) {
									?>
								<li><img alt="" src="images/<?php echo $datagalery->galeryimage ?>" width="467" height='360' /><p><?php echo $datagalery->galery_thumbs ?></p>
									<?php		
							}
						?>
						<!-- 
						</li>
						<li><img alt="" src="images/Kartu.jpg" width="467" height='360' /><p>Gambar belum tersedia di database</p>
						</li> -->
					</ul>
				</div>
				<div class="popoper-content">&nbsp;
					<?php echo $datafasilitas->descfasilitas ?>
				</div>
			</div>		
		<?php	
				$i++;	
			}
		?>
		
	</div>
</div>	

<script type="text/javascript">
	$(function(){
		var jumlah_fasilitas = $('#jmlfas').val();
		var i = 1;
		
		for (var i = 1; i <= jumlah_fasilitas; i++) {
			$('#carousel-fasilitas'+i).infiniteCarouselfasilitas({
				displayTime: 6000,
				textholderHeight : .25
			});
		};

	});
</script>