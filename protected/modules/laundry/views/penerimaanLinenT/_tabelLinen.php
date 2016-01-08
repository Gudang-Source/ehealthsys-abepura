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
		<?php foreach($modPengajuanDetail as $i => $detail){ ?>
		<tr>
			<td style="width:30px;"><?php echo $i+1; ?></td>
			<td>
				<?php echo $form->hiddenField($detail,'['.$i.']linen_id',array('readonly'=>true));?>
				<?php echo $detail->linen->noregisterlinen; ?>
			</td>
			<td><?php echo $detail->linen->namalinen; ?></td>
			<td>
				<?php echo CHtml::activeDropDownList($detail, '['.$i.']jenisperawatan', LookupM::getItems('jenisperawatan'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
			</td>
			<td>
				<?php echo $form->textField($detail,'['.$i.']keterangan_pengperawatan',array('readonly'=>true));?>
			</td>
<!--			<td>
				<a onclick="batalLinen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan linen"><i class="icon-remove"></i></a>
			</td>-->
		</tr>
		<?php } ?>
	</tbody>
</table>
