<div class="search-form">
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'id' => 'pencarianbarang-form',
		'type' => 'horizontal',
		'focus' => '#' . CHtml::activeId($modBarang, 'barang_kode'),
	));
	?>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Jenis Inventarisasi', 'jenisinventarisasi', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (empty($model->formuliropname_id)) {
						echo $form->dropDownList($modBarang, 'invbarang_jenis', LookupM::getItems('jenisinventarisasi'), array('class' => 'span3', 'onchange' => 'setJenisInventarisasi();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
					} else {
						echo $form->textField($modBarang, 'invbarang_jenis', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
					}
					?>
				</div>
			</div>
			<?php echo $form->textFieldRow($modBarang, 'inventarisasi_kode', array('placeholder' => 'Ketik Kode Barang', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>        
		</div>
		<div class="span4">
			<?php echo $form->textFieldRow($modBarang, 'barang_nama', array('placeholder' => 'Ketik Kode Barang', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>        
			<?php echo $form->textFieldRow($modBarang, 'barang_noseri', array('placeholder' => 'Ketik No. Seri', 'class' => 'span3', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
		</div>
		<div class="span4">
			<?php echo $form->textFieldRow($modBarang, 'barang_merk', array('placeholder' => 'Ketik Merk Barang', 'class' => 'span3', 'maxlength' => 200, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>               
			<?php echo $form->dropDownListRow($modBarang, 'barang_satuan', CHtml::listData(SatuankecilM::model()->findAll(), 'satuankecil_id', 'satuankecil_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>