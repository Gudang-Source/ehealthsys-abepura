<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));        ?>
<div class="white-container">
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::activeHiddenField($modPengkajian, 'anamesa_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php echo CHtml::activeHiddenField($modPengkajian, 'pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php echo CHtml::activeLabel($modPengkajian, 'no_pengkajian', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modPengkajian, 'no_pengkajian', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modPengkajian,
						'attribute' => 'pengkajianaskep_tgl',
						'mode' => 'datetime',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
						),
					));
					?>

				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Nama Pegawai', 'namapegawai', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->hiddenField($modPengkajian, 'pegawai_id', array('required'=>true,'readonly' => true, 'id' => 'pegawai_id')) ?>
					<?php
					$modul = ModulK::model()->findByAttributes(
							array('modul_key' => $this->module->id)
					);
					$modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'nama_pegawai',
						'value' => isset($modPengkajian->pegawai->nama_pegawai) ? $modPengkajian->pegawai->nama_pegawai : "",
						'sourceUrl' => $this->createUrl('Pegawairiwayat'),
						'options' => array(
							'showAnim' => 'fold',
							'minLength' => 4,
							'focus' => 'js:function( event, ui ) {
                                                    $("#pegawai_id").val( ui.item.value );
                                                    $("#nama_pegawai").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
							'select' => 'js:function( event, ui ) {
                                                    $("#pegawai_id").val( ui.item.value );
                                                    return false;
                                                }',
						),
						'htmlOptions' => array('required'=>true,'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
						'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
					));
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPegawai',
	'options' => array(
		'title' => 'Daftar Pegawai',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 600,
		'resizable' => false,
	),
));

$modPegawai = new ASPegawaiM;
if (isset($_GET['PegawaiM']))
	$modPegawai->attributes = $_GET['PegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pegawai-m-grid',
	'dataProvider' => $modPegawai->searchPerawat(),
	'filter' => $modPegawai,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
								$(\"#pegawai_id\").val(\"$data->pegawai_id\");
								$(\"#nama_pegawai\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawai\").dialog(\"close\");    
                                return false;
                                "))',
		),
		'nomorindukpegawai',
		'nama_pegawai',
		'tempatlahir_pegawai',
		'tgl_lahirpegawai',
		'jeniskelamin',
		'statusperkawinan',
		array(
			'header' => 'Jabatan',
			'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
		),
		'alamat_pegawai',
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>