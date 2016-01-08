<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saalatsterilisasi-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="span4">
        <?php //echo $form->textFieldRow($model,'alatmedis_id',array('class'=>'span3')); ?>
	<?php echo $form->dropdownListRow($model,'instalasi_id', CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
	<?php echo $form->dropdownListRow($model,'jenisalatmedis_id', CHtml::listData($model->JenisalatmedisItems, 'jenisalatmedis_id', 'jenisalatmedis_nama'),array('empty'=>'-- Pilih --','onkeypress'=>'return $(this).focusNextInputField(event)','class'=>'span3')); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model,'alatmedis_noaset',array('class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'alatmedis_nama',array('class'=>'span3','maxlength'=>100)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model,'alatmedis_namalain',array('class'=>'span3','maxlength'=>100)); ?>
	<?php echo $form->checkBoxRow($model,'alatmedis_aktif'); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
