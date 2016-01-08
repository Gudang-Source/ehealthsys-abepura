<div class="row-fluid">
	<div class="span4"> 
		<div class="control-group">
			<?php echo $form->labelEx($model,'tglbuatjadwal',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php   
					$model->tglbuatjadwal = (!empty($model->tglbuatjadwal) ? date("d/m/Y",strtotime($model->tglbuatjadwal)) : null);
					$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tglbuatjadwal',
											'mode'=>'date',
											'options'=> array(
		//                                            'dateFormat'=>Params::DATE_FORMAT,
												'showOn' => false,
												'maxDate' => 'd',
												'yearRange'=> "-150:+0",
											),
											'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
											),
				)); ?>
				<?php echo $form->error($model, 'tglbuatjadwal'); ?>
			</div>
		</div>
		<?php echo $form->textFieldRow($model,'no_pembuatanjadwal',array('readonly'=>true,'class'=>'span3')); ?>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'mengetahui_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'mengetahui_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'pegawaimengetahui',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'mengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
		
		<div class="control-group ">
			<?php echo $form->labelEx($model, 'menyetujiu_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($model, 'menyetujiu_id',array('readonly'=>true)); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'menyetujiu_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawai') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'menyetujiu_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'class'=>'programkerja',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'menyetujiu_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
				));
				?>
			</div>
		</div>
	</div>
	<div class="span4">
		<?php echo $form->textAreaRow($model,'keterangan_penjadwalan',array()); ?>
	</div>
</div>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengetahui->searchPegawaiMengetahui(),
    'filter'=>$modPegawaiMengetahui,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
								$(\"#'.CHtml::activeId($model,'mengetahui_id').'\").val(\"$data->pegawai_id\");
								$(\"#'.CHtml::activeId($model,'mengetahui_nama').'\").val(\"$data->NamaLengkap\");
								$(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
								return false;
							"))',
			),
			array(
				'header'=>'NIP',
				'value'=>'$data->nomorindukpegawai',
			),
			array(
				'header'=>'Gelar Depan',
				'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
				'value'=>'$data->gelardepan',
			),
			array(
				'header'=>'Nama Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
				'value'=>'$data->nama_pegawai',
			),
			array(
				'header'=>'Gelar Belakang',
				'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
				'value'=>'$data->gelarbelakang_nama',
			),
			array(
				'header'=>'Alamat Pegawai',
				'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
				'value'=>'$data->alamat_pegawai',
			),
		),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMenyetujui->unsetAttributes();
if(isset($_GET['KPPegawaiV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMenyetujui->searchPegawaiMengetahui(),
    'filter'=>$modPegawaiMenyetujui,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
					"href"=>"",
					"id" => "selectObat",
					"onClick" => "
						$(\"#'.CHtml::activeId($model,'menyetujiu_id').'\").val(\"$data->pegawai_id\");
						$(\"#'.CHtml::activeId($model,'menyetujiu_nama').'\").val(\"$data->NamaLengkap\");
						$(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
						return false;
					 "))',
		),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
			'value'=>'$data->gelardepan',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
		),
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		),
		array(
			'header'=>'Alamat Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
			'value'=>'$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>