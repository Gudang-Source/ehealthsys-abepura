<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'lbkelkumurhasillab-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'kelkumurhasillabnama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'umurminlab',array('class'=>'span3 integer umurminlab', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'onblur'=>'setHariLab()')); ?>
			<?php echo $form->textFieldRow($model,'umurmakslab',array('class'=>'span3 integer umurmakslab', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'onblur'=>'setHariLab()')); ?>
		</div>
		<div class = "span4">		
			<?php 
			echo $form->dropDownListRow($model,'satuankelumur', LookupM::getItems(Params::LOOKUPTYPE_SATUAN_KELOMPOK_UMUR),array('empty'=>'-- Pilih --','class'=>'span3 satuankelumur', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'onchange'=>'setHariLab()'));
			?>
			<?php echo $form->textFieldRow($model,'hariminlab',array('class'=>'span3 integer hariminlab', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($model,'harimakslab',array('class'=>'span3 integer harimakslab', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class = "span4">
			<?php echo $form->textFieldRow($model,'kelkumurhasillab_urutan',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>9)); ?>
			<?php echo $form->checkBoxRow($model,'kelkumurhasillab_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
				array('class'=>'btn btn-danger',
				'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kelompok Umur Hasil Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
            	<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kelompok Umur',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php	$content = $this->renderPartial($this->path_view.'tips.tipsCreateUpdate',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
	function setHariLab(){
		var umurminlab = $('.umurminlab').val();
		var umurmakslab = $('.umurmakslab').val();
		var satuankelumur = $('.satuankelumur').val();
		var hariminlab = 0;
		var harimakslab = 0;

		if(satuankelumur=='Hr'){
			var hariminlab = umurminlab;
			var harimakslab = umurmakslab;
		}else if(satuankelumur=='Bln'){
			var hariminlab = umurminlab*30;
			var harimakslab = umurmakslab*30+29;
		}else if(satuankelumur=='Thn'){
			var hariminlab = umurminlab*360;
			var harimakslab = umurmakslab*360+359;
		}
		$('.hariminlab').val(hariminlab);
		$('.harimakslab').val(harimakslab);
	}
</script>