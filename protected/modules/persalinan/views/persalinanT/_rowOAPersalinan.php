<?php

$oa = ObatalkesM::model()->findByPk($obatalkes_id);

?>
<tr>
	<td>
		<?php echo $oa->obatalkes_kode; ?>
	</td>
	<td>
		<?php echo $oa->obatalkes_nama; ?>
		<?php echo CHtml::hiddenFIeld('obatalkes['.$id.']['.$obatalkes_id.'][id]', $obatalkes_id, array(
			'class'=>'row_obatalkes_id',
		)); ?>
	</td>
	<td width="80"><?php echo CHtml::textField('obatalkes['.$id.']['.$obatalkes_id.'][qty]', $qty, array(
		'style'=>'text-align: right; width: 80px;',
	)); ?></td>
	<td width="50" style="text-align: center;"><?php echo CHtml::link('<i class="icon-remove"></i>', '#', array(
		'onclick'=>'$(this).parent().parent().remove(); return false;'
	)); ?></td>
</tr>
