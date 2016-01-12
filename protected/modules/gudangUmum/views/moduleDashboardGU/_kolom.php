<div class="col-sm-3 col-xs-6">
	<div class="tile-stats tile-red">
		<div class="icon">
			<i class="entypo-home"></i>
		</div>
		<div data-delay="0" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[1]; ?>" data-start="0" class="num">0</div>
		<h3>Pembelian Barang</h3>
		<p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
	</div>
</div>

<div class="col-sm-3 col-xs-6">
	<div class="tile-stats tile-green">
		<div class="icon"><i class="entypo-users"></i></div>
		<div data-delay="600" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[2]; ?>" data-start="0" class="num">0</div>
		<h3>Penerimaan Persediaan</h3>
		<p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
	</div>
</div>

<div class="col-sm-3 col-xs-6">
	<div class="tile-stats tile-aqua">
		<div class="icon"><i class="entypo-user-add"></i></div>
		<div data-delay="1200" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[3]; ?>" data-start="0" class="num">0</div>
		<h3>Retur Penerimaan Persediaan</h3>
		<p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
	</div>
</div>

<div class="col-sm-3 col-xs-6">
	<div class="tile-stats tile-blue">
		<div class="icon"><i class="entypo-user"></i></div>
		<div data-delay="1800" data-duration="1500" data-postfix="" data-end="<?php echo $dataKolom[4]; ?>" data-start="0" class="num">0</div>
		<h3>Batal Mutasi Barang</h3>
		<p>Hari Ini <?php echo MyFormatter::formatDateTimeId(date("Y-m-d")); ?></p>
	</div>
</div>