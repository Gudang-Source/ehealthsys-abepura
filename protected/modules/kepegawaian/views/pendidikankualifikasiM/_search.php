<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapendidikankualifikasi-m-search',
        'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class = "span4">
        <?php echo $form->textFieldRow($model,'pendkualifikasi_kode',array('class'=>'span3','maxlength'=>10)); ?>
        <?php echo CHtml::label('Status','Status', array('class'=>'control-label')) ?>
        <div class="controls">
                <?php echo $form->checkBox($model,'pendkualifikasi_aktif',array('checked'=>'checked')); ?>
        </div>
    </div>
    <div class="span4">
         <?php echo $form->textFieldRow($model,'pendkualifikasi_nama',array('class'=>'span3','maxlength'=>50)); ?>
    </div>
    <div class = "span4">
        <div class="control-group">
                <?php echo CHtml::label('Kualifikasi Pendidikan Lainnya','Kualifikasi Pendidikan Lainnya', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'pendkualifikasi_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
        </div>
    </div>
</div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
