<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('jenislinen_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->jenislinen_id),array('view','id'=>$data->jenislinen_id)); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('jenislinen_no')); ?>:</b>
	<?php echo CHtml::encode($data->jenislinen_no); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('jenislinen_nama')); ?>:</b>
	<?php echo CHtml::encode($data->jenislinen_nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tgldiedarkan')); ?>:</b>
	<?php echo CHtml::encode($data->tgldiedarkan); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('qtyitem')); ?>:</b>
	<?php echo CHtml::encode($data->qtyitem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warnalinen')); ?>:</b>
	<?php echo CHtml::encode($data->warnalinen); ?>
	<br />


</div>