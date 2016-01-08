<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'jenispengeluaran-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php echo $form->errorSummary($model); ?>

       <table>
            <tr>
                <td>
                    <div class='control-group'>
                                  <?php echo $form->labelEx($model,'jenispengeluaran_kode', array('class'=>'control-label')) ?>
                             <div class="controls">
                                  <?php echo $form->textField($model,'jenispengeluaran_kode',array('class'=>'span3','maxlength'=>50)); ?>
                             </div>
                   </div>

                   <div class='control-group'>
                                  <?php echo $form->labelEx($model,'jenispengeluaran_nama', array('class'=>'control-label')) ?>
                             <div class="controls">
                                  <?php echo $form->textField($model,'jenispengeluaran_nama',array('class'=>'span3','maxlength'=>50)); ?>
                             </div>
                   </div>

                   <div class='control-group'>
                                  <?php echo $form->labelEx($model,'jenispengeluaran_namalain', array('class'=>'control-label')) ?>
                             <div class="controls">
                                  <?php echo $form->textField($model,'jenispengeluaran_namalain',array('class'=>'span3','maxlength'=>50)); ?>
                             </div>
                   </div>
                    
                   <div class='control-group'>
                                    <?php echo $form->checkBoxRow($model,'jenispengeluaran_aktif',array('checked'=>'checked')); ?>
                   </div>
                </td>
            </tr>
        </table>
        
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
                ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/jurnalRekPengeluaran/admin'), 
                            array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
                ?>       
                <?php $this->widget('UserTips',array('type'=>'update'));?>
	</div>

<?php $this->endWidget(); ?>