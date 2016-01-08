<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'statuskepemilikanrumah-m-form',
                'type'=>'horizontal',
	'enableAjaxValidation'=>false,
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#KPStatuskepemilikanrumahM_statuskepemilikanrumah_nama',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldRow($model,'statuskepemilikanrumah_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model,'statuskepemilikanrumah_namalain',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <div>
            <?php echo $form->checkBoxRow($model,'statuskepemilikanrumah_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
            <div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton','onKeypress'=>'return formSubmit(this,event);')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/statuskepemilikanrumahM/admin'), 
                                    array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Status Kepemilikan Rumah', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('statuskepemilikanrumahM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
            </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('KPStatuskepemilikanrumahM_statuskepemilikanrumah_namalain').value = nama.value.toUpperCase();
    }
</script>