<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('potongansumber_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->potongansumber_id),array('view','id'=>$data->potongansumber_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('namapotongan')); ?>:</b>
	<?php echo CHtml::encode($data->namapotongan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('namapotonganlainnya')); ?>:</b>
	<?php echo CHtml::encode($data->namapotonganlainnya); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('potongansumber_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->potongansumber_aktif); ?>
	<br />


</div>