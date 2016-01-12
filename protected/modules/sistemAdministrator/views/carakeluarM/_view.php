<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('carakeluar_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->carakeluar_id),array('view','id'=>$data->carakeluar_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('carakeluar_nama')); ?>:</b>
	<?php echo CHtml::encode($data->carakeluar_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('carakeluar_namalain')); ?>:</b>
	<?php echo CHtml::encode($data->carakeluar_namalain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('carakeluar_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->carakeluar_aktif); ?>
	<br />


</div>