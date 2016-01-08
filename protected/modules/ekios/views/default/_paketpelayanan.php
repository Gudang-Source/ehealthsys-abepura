<style type="text/css">
	.paket{
		width: 320px;
		display: inline-table;
		margin-top: 20px;
		margin-left: 0px;
		vertical-align: top;
	}
	.pakettable{
		border: 1px solid LightSteelBlue;
	}
	.litindakan{
		list-style-position: inside;
		list-style: none;
	}
	.bedpaket {
	    border-color: #CCCCCC;
	    display: inline-block;
	    margin: -5px;
	    width: 100%;
	}
	.popover-title-pak{
		background-color: Lavender;
	}

	h4.popover-title-pak{
		text-align: center;
	}

</style>

<div class="block-kioskmodule" id="paketpelayanan" name="paketpelayanan">
	<legend class="rim">PAKET PELAYANAN</legend>
	<div class="contentKamar" style="max-height:400px;overflow-y: scroll;">
		<?php
			$tipepaket = EKTipepaketM::model()->findAll('tipepaket_aktif = true');
			foreach ($tipepaket as $data => $paket) {
		?>
			<div class="paket">
				<ul>
					<li class="bedpaket">
						<div class="popover-inner">
							<h4 class="popover-title-pak"><?php echo $paket->tipepaket_nama ?></h4>
							<h6 class="popover-title-pak"><?php echo "Rp. ". number_format($paket->tarifpaket,2) ?></h6>
							<div class="popover-content">
								Paket Meliputi:<hr>
								<?php 
									$daftartindakan = PaketpelayananM::model()->findAll('tipepaket_id = '.$paket->tipepaket_id);
									foreach ($daftartindakan as $data => $tindakan) {
										echo "<i class='icon-form-check'></i>&nbsp;".$tindakan->daftartindakan->daftartindakan_nama."<br>";
									}
								?>
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
