

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakarcis-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <?php echo $form->dropDownListRow($model,'daftartindakan_id',
                       CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
                       array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                       'empty'=>'-- Pilih --')); ?>

         <?php echo $form->dropDownListRow($model,'ruangan_id',
                       CHtml::listData($model->RuanganItems, 'ruangan_id', 'ruangan_nama'),
                       array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                       'empty'=>'-- Pilih --')); ?>

        <?php echo $form->textFieldRow($model,'karcis_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        
        <?php echo $form->textFieldRow($model,'karcis_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	       
         <?php
             echo $form->radioButtonListInlineRow($model,'StatusPasien', LookupM::getItems('statuspasien'));
          ?>

            <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/karcisM/admin'),           
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Karcis', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('karcisM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
            <?php
            $content = $this->renderPartial('../tips/tips',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
            </div>

<?php $this->endWidget(); ?>
