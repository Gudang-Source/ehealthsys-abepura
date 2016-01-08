<tr>
	<td>
		<?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		<?php echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]satuankecil_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]qtystoked',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]stokobatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]obatalkes_nama',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modStoreEdDetail,'[ii]supplier_nama',array('readonly'=>true,'class'=>'span1')); ?>
	</td>
	<td>
		<?php echo (!empty($modStoreEdDetail->obatalkes_id) ? $modStoreEdDetail->obatalkes_nama : "") ?>
	</td>
	<td>
		<?php echo (!empty($modStoreEdDetail->obatalkes_id) ? $modStoreEdDetail->supplier_nama : "") ?>
	</td>
	<td>
		<?php echo (!empty($modStoreEdDetail->tglkadaluarsa) ? $format->formatDateTimeForUser($modStoreEdDetail->tglkadaluarsa) : "") ?>
	</td>
	<td>
		<?php echo CHtml::activeTextField($modStoreEdDetail, '[ii]qtystoked',array('readonly'=>true,'style'=>'width:50px;')); ?>
	</td>
	<td>
		<?php echo (!empty($modStoreEdDetail->satuankecil_id) ? $modStoreEdDetail->satuankecil_nama : "") ?>
	</td>
	<?php if(!isset($_GET['sukses'])){ ?>
		<td>
			<a onclick="batalStoreEdDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan obat alkes ini"><i class="icon-form-silang"></i></a>
		</td>
	<?php } ?>
</tr>