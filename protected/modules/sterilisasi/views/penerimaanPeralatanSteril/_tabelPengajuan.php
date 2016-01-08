<table class="items table table-striped table-condensed" id="table-peralatansteril">
	<thead>
		<tr>
			<th>Pilih</th>
			<th>No.</th>
			<th>Ruangan Asal</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($modPengDetails) > 0){
			foreach($modPengDetails AS $i=>$modPengDetail){ ?>
				<tr>
					<td>
						<?php echo CHtml::activeCheckBox($modPengDetail,'['.$i.']checklist', array('class'=>'ceklis','checked'=>true)); ?>
					</td>
					<td>
						<?php echo $i+1; ?>
						<?php echo CHtml::activeHiddenField($modPengDetail,'['.$i.']pengajuansterlilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPengDetail,'['.$i.']pengajuansterlilisasidet_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPengDetail,'['.$i.']linen_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPengDetail,'['.$i.']barang_id',array('readonly'=>true,'class'=>'span1')); ?>
					</td>
					<td>
						<?php echo $modPengDetail->pengajuan->ruangan->ruangan_nama; ?>
					</td>
					<td>
						<?php echo $modPengDetail->barang->barang_nama; ?>
					</td>
					<td>
						<?php echo CHtml::activeTextField($modPengDetail,'['.$i.']pengajuansterlilisasidet_jml',array('class'=>'span2 integer','style'=>'width:90px;','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					</td>
					<td>
						<?php echo CHtml::activeTextField($modPengDetail,'['.$i.']pengajuansterlilisasidet_ket',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					</td>
				</tr>
	<?php 	}
		}
		?>
	</tbody>
</table>