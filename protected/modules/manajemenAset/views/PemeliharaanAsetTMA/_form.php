<?php echo $form->errorSummary($modPemeliharaanAset); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
            <?php echo $form->labelEx($modPemeliharaanAset,'pemeliharaanaset_tgl', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $modPemeliharaanAset->pemeliharaanaset_tgl = (!empty($modPemeliharaanAset->pemeliharaanaset_tgl) ? date("d/m/Y H:i:s",strtotime($modPemeliharaanAset->pemeliharaanaset_tgl)) : null);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$modPemeliharaanAset,
                            'attribute'=>'pemeliharaanaset_tgl',
                            'mode'=>'datetime',
                            'options'=> array(
                                'showOn' => false,
                                'format' => Params::DATE_FORMAT,
//                                'maxDate' => 'd',
                                'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('class'=>'dtPicker3 realtime','onkeyup'=>"return $(this).focusNextInputField(event)"
                            ),
                    )); ?>
                </div>
        </div>
		<?php
			echo $form->textFieldRow($modPemeliharaanAset,'pemeliharaanaset_no',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>true)); 
        ?>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($modPemeliharaanAset, 'pegmengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPemeliharaanAset, 'pegmengetahui_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$modPemeliharaanAset,
					'attribute' => 'pegmengetahui_nama',
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
							$("#'.Chtml::activeId($modPemeliharaanAset, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Pegawai Mengetahui',
						'class'=>'pegmengetahui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPemeliharaanAset, 'pegmengetahui_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($modPemeliharaanAset, 'Petugas 1', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPemeliharaanAset, 'pegpetugas1_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$modPemeliharaanAset,
					'attribute' => 'petugas_nama1',
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
							$("#'.Chtml::activeId($modPemeliharaanAset, 'pegpetugas1_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Pegawai Menyetujui',
						//'class'=>'pegpenyimpanan_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPemeliharaanAset, 'pegpetugas1_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPetugas1'),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($modPemeliharaanAset, 'Petugas 2', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPemeliharaanAset, 'pegpetugas2_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$modPemeliharaanAset,
					'attribute' => 'petugas_nama2',
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
							$("#'.Chtml::activeId($modPemeliharaanAset, 'pegpetugas2_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Pegawai Menyetujui',
						//'class'=>'pegpenyimpan_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPemeliharaanAset, 'pegpetugas2_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPetugas2'),
				));
				?>
			</div>
		</div>		
	</div>
	<div class="span4">
		<?php echo $form->textAreaRow($modPemeliharaanAset,'pemeliharaanaset_ket',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Keterangan Dekontaminasi')); ?>
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

$modPegawaiMengetahui = new MAPegawaiM('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['MAPegawaiM'])) {
    $modPegawaiMengetahui->attributes = $_GET['MAPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengetahui->searchDialog(),
    'filter'=>$modPegawaiMengetahui,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($modPemeliharaanAset,'pegmengetahui_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($modPemeliharaanAset,'pegmengetahui_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
                        'name' => 'nomorindukpegawai',
		),
		array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
			'value'=>'$data->gelardepan',
                        'name' => 'gelardepan',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
                        'name' => 'nama_pegawai',
		),
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
                        'name' => 'gelarbelakang_nama',
		),
		array(
			'header'=>'Alamat Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
			'value'=>'$data->alamat_pegawai',
                        'name' => 'alamat_pegawai',
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
    'id'=>'dialogPetugas1',
    'options'=>array(
        'title'=>'Pencarian Petugas 1',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPetugas = new MAPegawaiM('searchDialog');
$modPetugas->unsetAttributes();
if(isset($_GET['MAPegawaiM'])) {
    $modPetugas->attributes = $_GET['MAPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'petugas-grid',
    'dataProvider'=>$modPetugas->searchDialog(),
    'filter'=>$modPetugas,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($modPemeliharaanAset,'pegpetugas1_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($modPemeliharaanAset,'petugas_nama1').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPetugas1\").dialog(\"close\"); 
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
    'id'=>'dialogPetugas2',
    'options'=>array(
        'title'=>'Pencarian Petugas 1',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPetugas2 = new MAPegawaiM('searchDialog');
$modPetugas2->unsetAttributes();
if(isset($_GET['MAPegawaiM'])) {
    $modPetugas2->attributes = $_GET['MAPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'petugas2-grid',
    'dataProvider'=>$modPetugas2->searchDialog(),
    'filter'=>$modPetugas2,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($modPemeliharaanAset,'pegpetugas2_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($modPemeliharaanAset,'petugas_nama2').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPetugas2\").dialog(\"close\"); 
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
 