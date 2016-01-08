<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'jenis-surat-m-form',
                'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->textFieldRow($model,'jenissurat_nama',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->textFieldRow($model,'jenissurat_namalain',array('size'=>60,'maxlength'=>200)); ?>
                <div>
                    <?php echo $form->checkBoxRow($model,'jenissurat_aktif'); ?>
                </div>
	<div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                 array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeypress'=>'return formSubmit(this,event)','onClick'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                 Yii::app()->createUrl($this->module->id.'/jenisSuratM/admin'), 
                                 array('class'=>'btn btn-danger',
                                 'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Surat', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('jenisSuratM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
            <?php
                $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>

<?php $this->endWidget(); ?>