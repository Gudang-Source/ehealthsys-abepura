<div class="col-sm-3 col-xs-6">
	<div class="tile-stats tile-red">
		<div class="icon">
			<i class="entypo-user"></i>
		</div>
		<div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
                <h3>Kunjungan Pasien <br> Rawat Jalan Hari Ini</h3> <p>Jumlah pasien hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?></p>
	</div>
</div>
<div class="col-sm-3 col-xs-6">
	<div class="tile-stats tile-green">
		<div class="icon">
			<i class="entypo-users"></i>
		</div>
		<div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num">0</div>
                <h3>Kunjungan Pasien <br> Rawat Darurat Hari Ini</h3> <p>Jumlah pasien hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d"));?></p>
	</div>
</div>
<div class="col-sm-3 col-xs-6">
	<div class="tile-stats tile-aqua">
		<div class="icon">
			<i class="entypo-user-add"></i>
		</div>
		<div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
                <h3>Kunjungan Pasien <br> Rawat Inap Hari Ini</h3> <p>Jumlah pasien hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d"));?></p>
	</div>
</div>
<div class="col-sm-3 col-xs-6">
	<div class="tile-stats tile-blue">
		<div class="icon">
			<i class="entypo-home"></i>
		</div>
		<div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
                <h3>Berkas Dokumen Baru <br> Hari Ini</h3> <p>Jumlah berkas dokumen baru hari ini <?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d"));?></p>
	</div>
</div>