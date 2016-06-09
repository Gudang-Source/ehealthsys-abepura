<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($model, '[ii]kriteriahasildet_id',array('readonly'=>true));?>
		<?php echo CHtml::activeHiddenField($model, '[ii]kriteriahasil_id',array('readonly'=>true));?>
		<?php echo CHtml::activeTextField($model, '[ii]kriteriahasildet_indikator',array('class'=>'span12'));?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeCheckBox($model,'[ii]kriteriahasildet_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);","onClick"=>'cek(this);','checked'=>'checked')); ?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'tambahLookup()')); ?>
		<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-primary','onclick'=>'hapusLookup(this)')); ?>
	</td>
</tr>
