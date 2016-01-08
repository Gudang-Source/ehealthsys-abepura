<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kpindikatorperilaku-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
	<?php echo $form->dropDownListRow($model,'jabatan_id', CHtml::listData(KPJabatanM::model()->getJabatanItems(), 'jabatan_id', 'jabatan_nama') ,
											array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>

	<?php echo $form->dropDownListRow($model,'jenispenilaian_id', CHtml::listData(KPJenispenilaianM::model()->getJenisPenilaianItems(), 'jenispenilaian_id', 'jenispenilaian_nama') ,
											array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
	<div class="control-group">
		<?php echo CHtml::label('Status','indikatorperilaku_aktif', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->checkBox($model,'indikatorperilaku_aktif',array('checked'=>true)); ?>
		</div>
	</div>
	</div>
	<div class="span8">
	<?php echo $form->dropDownListRow($model,'kompetensi_id', CHtml::listData(KPKompetensiM::model()->getKompetensiItems(), 'kompetensi_id', 'kompetensi_nama') ,
											array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
		<div class="control-group">
			<?php echo CHtml::label('Indikator Perilaku Nama','indikatorperilaku_nama', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textArea($model,'indikatorperilaku_nama',array('rows'=>2, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>300)); ?> 
			</div>
		</div>
	</div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
