<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pcobatalkesdetail-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="span4">
        <div class="control-group">
	<?php echo $form->labelEx($model, 'Kode Obat',array('class'=>'control-label')); ?>
		 <div class="controls inline">
			<?php echo $form->dropDownList($model,'obatalkes_id', CHtml::listData(ObatalkesM::model()->findAllByAttributes(array('obatalkes_aktif'=>true),array('order'=>'obatalkes_kode')),'obatalkes_id','obatalkes_kode'), array('class'=>'span3','empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		 </div>
	</div>
	<div class="control-group">
	<?php echo $form->labelEx($model, 'Nama Obat',array('class'=>'control-label')); ?>
		 <div class="controls inline">
			<?php echo $form->textField($model,'obatalkes_nama',array('class'=>'span3')); ?>
		 </div>
	</div>
	<div class="control-group">
	<?php echo $form->labelEx($model, 'Status Obat',array('class'=>'control-label')); ?>
		 <div class="controls inline">
			<?php echo $form->checkBox($model,'obatalkes_aktif',array('checked'=>'obatalkes_aktif')); ?>
		 </div>
	</div>
    </div>
    <div class="span8">
        <?php echo $form->textAreaRow($model,'komposisi',array('rows'=>6, 'cols'=>50, 'class'=>'span3')); ?>
    </div>
</div>
	
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>
<?php $this->endWidget(); ?>
