<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rmwarna-nomor-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#RKWarnaNomor_warnanomorrm_angka',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'warnanomorrm_angka',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);" , 'maxlength'=>5)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'warnanomorrm_warna',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'warnanomorrm_kodewarna',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->checkBoxRow($model,'warnanomorrm_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>




	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/warnaNomor/admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Warna Nomor', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('warnaNomor/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('rekamMedis.views.tips.tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
    </div>

<?php $this->endWidget(); ?>
