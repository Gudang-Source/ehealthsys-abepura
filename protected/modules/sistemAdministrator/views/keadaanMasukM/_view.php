<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->lookup_id),array('view','id'=>$data->lookup_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_name')); ?>:</b>
	<?php echo CHtml::encode($data->lookup_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_urutan')); ?>:</b>
	<?php echo CHtml::encode($data->lookup_urutan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_kode')); ?>:</b>
	<?php echo CHtml::encode($data->lookup_kode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lookup_aktif')); ?>:</b>
	<?php $lookup_aktif =(CHtml::encode($data->lookup_aktif == TRUE)) ? Yii::t('mds','Yes') :  Yii::t('mds','No'); echo $lookup_aktif; ?>
	<br />


</div>