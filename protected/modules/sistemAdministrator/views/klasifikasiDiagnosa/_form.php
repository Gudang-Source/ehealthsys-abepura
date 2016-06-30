<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saklasifikasidiagnosa-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class = "span4">
        <?php 
        $dtd = DtdM::model()->findAll(array(
            'condition'=>'dtd_aktif = true',
            'order'=>'dtd_kode asc',
        ));
        echo $form->dropDownListRow($model, 'dtd_id', CHtml::listData($dtd, 'dtd_id', 'dtd_kode')); ?>
        <?php echo $form->textFieldRow($model,'klasifikasidiagnosa_kode',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3)); ?>
        <?php echo $form->textFieldRow($model,'klasifikasidiagnosa_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>500)); ?>
        <div>
            <?php echo $form->checkBoxRow($model,'klasifikasidiagnosa_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class = "span4">
        <?php echo $form->textAreaRow($model,'klasifikasidiagnosa_namalain',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class = "span4">
        <?php echo $form->textAreaRow($model,'klasifikasidiagnosa_desc',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl('create'), 
                            array('class'=>'btn btn-danger',
                                      'onclick'=>'return refreshForm(this);')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Klasifikasi Diagnosa',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            <?php 
            $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
            $this->widget('UserTips',array('content'=>$content));
            ?>
    </div>
</div>
<?php $this->endWidget(); ?>
