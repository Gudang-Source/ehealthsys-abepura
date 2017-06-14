<?php

$oa = ObatalkesM::model()->findByPk($obatalkes_id);

?>
<tr>
	<td>
		<?php echo $oa->obatalkes_kode; ?>
	</td>
	<td>
		<?php echo $oa->obatalkes_nama; ?>
	</td>
	<td width="80"><?php echo CHtml::textField('obatalkes['.$id.']['.$obatalkes_id.'][qty]', $qty, array(
		'style'=>'text-align: right; width: 80px;',
	)); ?></td>
	<td><?php echo CHtml::link('<i class="icon-remove"></i>', '#', array(
		'onclick'=>'$(this).parent().parent().remove(); return false;'
	)); ?></td>
</tr>
