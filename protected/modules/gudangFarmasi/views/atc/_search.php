<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfatc-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
    <div class = "span4">
        <?php echo $form->textFieldRow($model,'atc_kode',array('class'=>'span3','maxlength'=>10)); ?>
        <?php echo $form->checkBoxRow($model,'atc_aktif',array('checked'=>'checked')); ?>
    </div>
    <div class = "span4">
            <?php echo $form->textFieldRow($model,'atc_nama',array('class'=>'span3','maxlength'=>100)); ?>
    </div>
</div>
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
