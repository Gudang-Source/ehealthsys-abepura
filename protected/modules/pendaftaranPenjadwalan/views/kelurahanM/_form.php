<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppkelurahan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#propinsi',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group ">
			<?php echo CHtml::label('Propinsi','propinsi_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
					array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
						'ajax'=>array('type'=>'POST',
						'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($model))),
						'update'=>"#".CHtml::activeId($model, 'kabupaten_id'),
			)));?>
            <?php echo $form->error($model, 'propinsi_id'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::label('Kabupaten','kabupaten_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
				array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
						'ajax'=>array('type'=>'POST',
						'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($model))),
						'update'=>"#".CHtml::activeId($model, 'kecamatan_id'),
				)));?>
            <?php echo $form->error($model, 'kabupaten_id'); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($model,'kecamatan_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'kecamatan_id', CHtml::listData($model->getKecamatanItems($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), 
				array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
						'ajax'=>array('type'=>'POST',
						'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($model))),
						'update'=>"#".CHtml::activeId($model, 'kelurahan_id'),
				)));?>
        </div>
    </div>
             
	<table id="tbl-kelurahan" class="table table-striped table-bordered table-condensed">
		<tr>
			<td>
				<?php echo $form->textField($model,'[1]kelurahan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kelurahan_nama'))); ?>
				<span class="required">*</span>
			</td>
			<td>
				<?php echo $form->textField($model,'[1]kelurahan_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kelurahan_namalainnya'))); ?>
			</td>
			<td>
				<?php echo $form->textField($model,'[1]kode_pos',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kode_pos'))); ?>
			</td>
			<td>
				<?php echo CHtml::button( '+', array('class'=>'btn btn-primary','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).focusNextInputField()','id'=>'row1-plus')); ?>
			</td>
		</tr>
	</table>
            
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
					Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					Yii::app()->createUrl($this->module->id.'/kelurahanM/admin'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>

		<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelurahan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
		$this->createUrl('/pendaftaranPenjadwalan/kelurahanM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
		<?php
			$content = $this->renderPartial('../tips/tipsaddedit2b',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
	</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions',array()); ?>