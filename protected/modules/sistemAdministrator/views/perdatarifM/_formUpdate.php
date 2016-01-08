
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saperda-tarif-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SAPerdaTarifM_perdanama_sk',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->textFieldRow($model,'perdanama_sk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'noperda',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'tglperda', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglperda',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);"),
                    )); ?>
                    <?php echo $form->error($model, 'tglperda'); ?>
                </div>
            </div>
            <?php echo $form->textAreaRow($model,'perdatentang',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'ditetapkanoleh',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
            <?php echo $form->textFieldRow($model,'tempatditetapkan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'perda_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
                                    array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Perda Tarif', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
                    $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>

<?php $this->endWidget(); ?>
