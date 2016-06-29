<?php echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="table-linen">
	<thead>
		<tr>
			<th>No. </th>
			<th>No. Register Linen</th>
			<th>Nama Barang</th>
			<th>Jenis Perawatan</th>
			<th>Keterangan</th>
			<!--<th>Batal</th>-->
		</tr>
	</thead>
	<tbody>
		<?php foreach($modPengajuanDetail as $i => $detail){ 
                    echo $this->renderPartial("_rowLinen", array('detail'=>$detail, 'i'=>$i),true);
                } ?>
	</tbody>
</table>
