<div class="span11">
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'batalbayarpemb-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert'); 
echo $form->errorSummary(array($modBatalBayar)); ?>

<fieldset>
    <legend class="rim">Pembatalan Pembayaran Gaji Pegawai</legend>
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <br>
	<?php
	if($sukses=1){
	    Yii::app()->user->setFlash('success', "Pembatalan pembayaran gaji berhasil disimpan !");
	}else{
	    Yii::app()->user->setFlash('error', "Pembatalan pembayaran gaji gagal disimpan !");
	} ?>
       <div class="control-group ">
            <?php echo $form->labelEx($modBatalBayar,'tglbatalkeluar', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php 
                $this->widget('MyDateTimePicker',array(
                                'model'=>$modBatalBayar,
                                'attribute'=>'tglbatalkeluar',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'timeFormat'=>  Params::TIME_FORMAT,
                                    'maxDate'=> 'd',
                                ),
                                'htmlOptions'=>array('readonly'=>true,
				'class'=>'dtPicker3',
				'onkeypress'=>"return $(this).focusNextInputField(event);",
				),
                )); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($modBatalBayar, 'alasanbatalkeluar'); ?>
        

    <div class="form-actions">
        <?php 
	 	if(!$modBatalBayar->isNewRecord){
		    echo CHtml::htmlButton($modBatalBayar->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('disabled'=>true,'class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
		}else{
		    echo CHtml::htmlButton($modBatalBayar->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                array('disabled'=>false,'class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
		}
	?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                array('class'=>'btn btn-danger')); 
        ?>
    </div>   
</fieldset>
    
<?php $this->endWidget(); ?>
</div>