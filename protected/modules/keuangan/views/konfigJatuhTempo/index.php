<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakonfigsystem-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                            'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>
<?php echo $form->errorSummary($model); ?>
<div class="white-container">
<legend class="rim2">Konfigurasi <b>Jatuh Tempo</b></legend>
<div class="row-fluid">
    <div class="span12">
		<div class="box">
			<div class="control-group ">
                <?php echo $form->labelEx($model, 'Termin Jatuh Tempo Klaim', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'jatuhtempoklaim',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200, 'rel'=>'tooltip', 'title'=>'Termin Jatuh Tempo Klaim')); ?> Hari.
                </div>
            </div>
			<div class="control-group ">
                <?php echo $form->labelEx($model, 'Termin Jatuh Tempo Tagihan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'jatuhtempotagihan',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200, 'rel'=>'tooltip', 'title'=>'Termin Jatuh Tempo Tagihan')); ?> Hari.
                </div>
            </div>
		</div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
		?>
        <?php
//            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Sistem', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
            $content = $this->renderPartial('tips/tipsaddedit',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>	
</div>
<?php $this->endWidget(); ?>