<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kondisi-keluar-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row-fluid">

	<div class = "span6">
            <?php //echo $form->textFieldRow($model,'carakeluar_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'kondisikeluar_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'kondisikeluar_namalain',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->dropDownListRow($model,'carakeluar_id',CHtml::listData(SACarakeluarM::model()->CarakeluarItems, 'carakeluar_id', 'carakeluar_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->checkBoxRow($model,'kondisikeluar_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
	</div>
		<div class = "span6">
        </div>
    </div>
    <div class="row-fluid">
	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kondisi Keluar',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));  ?>
                <?php
                 $content = $this->renderPartial($this->path_view.'/tips/tipsaddedit',array(),true);        
                 $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                 ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
