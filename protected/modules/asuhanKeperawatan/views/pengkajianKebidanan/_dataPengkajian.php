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
					$this->widget('MyJuiAutoComplete',array(
						'model'=>$modPengkajian,
						'name'=>'ASPengkajianaskepT[nama_pegawai]',
						'value' => isset($modPengkajian->pegawai->nama_pegawai) ? $modPengkajian->pegawai->nama_pegawai : "",
						'source'=>'js: function(request, response) {
									   $.ajax({
										   url: "'.$this->createUrl('Pegawairiwayat').'",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
						'options'=>array(
						   'showAnim'=>'fold',
						   'minLength' => 2,
						   'focus'=> 'js:function( event, ui ) {
								$(this).val( ui.item.label);
								return false;
							}',
						   'select'=>'js:function( event, ui ) {
								$("#pegawai_id").val(ui.item.pegawai_id); 
								$("#ASPengkajianaskepT_nama_pegawai").val( ui.item.nama_pegawai );
								return false;
							}',

						),
						'tombolDialog'=>array("idDialog"=>'dialogPegawai'),
						'htmlOptions'=>array('required'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2'),
					)); ?>
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
if (isset($_GET['ASPegawaiM'])){
	$modPegawai->attributes = $_GET['ASPegawaiM'];
}

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
								$(\"#ASPengkajianaskepT_nama_pegawai\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawai\").dialog(\"close\");    
                                return false;
                                "))',
		),
                array(
                    'header' => 'NIP',
                    'name' => 'nomorindukpegawai',
                    'value' => '$data->nomorindukpegawai',
                    'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
                ),		
                array(
                    'header' => 'Nama Pegawai',
                    'name' => 'nama_pegawai',
                    'value' => '$data->namaLengkap',
                    'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
                ),			
		array(
			'header' => 'Jabatan',
                        'name' => 'jabatan_id',
			'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
                        'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id',Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --'))
		),		
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
    });'
    . '}',
));

$this->endWidget();
?>