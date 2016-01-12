<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapemeriksaanalatrad-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class="span4">
        <?php echo $form->dropDownListRow($model,'alatmedis_id',  CHtml::listData($model->AlatmedisItems, 'alatmedis_id', 'alatmedis_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
	<?php echo $form->textFieldRow($model,'pemeriksaanalatrad_kode',array('class'=>'span3','maxlength'=>20)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model,'pemeriksaanalatrad_nama',array('class'=>'span3','maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($model,'pemeriksaanalatrad_namalain',array('class'=>'span3','maxlength'=>100)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model,'pemeriksaanalatrad_aetitle',array('class'=>'span3','maxlength'=>100)); ?>
	<?php echo $form->checkBoxRow($model,'pemeriksaanalatrad_aktif'); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
