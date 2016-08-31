<?php echo $form->errorSummary($modPengirimanLinen); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->hiddenField($modPengirimanLinen,'pengirimanlinen_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
		<div class="control-group ">
            <?php echo $form->labelEx($modPengirimanLinen,'tglpengirimanlinen', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                        $modPengirimanLinen->tglpengirimanlinen = (!empty($modPengirimanLinen->tglpengirimanlinen) ? date("d/m/Y H:i:s",strtotime($modPengirimanLinen->tglpengirimanlinen)) : null);
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$modPengirimanLinen,
                            'attribute'=>'tglpengirimanlinen',
                            'mode'=>'datetime',
                            'options'=> array(
                                'showOn' => false,
//                                'maxDate' => 'd',
                                'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                            ),
                    )); ?>
                </div>
        </div>
		<?php
			echo $form->textFieldRow($modPengirimanLinen,'nopengirimanlinen',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>true)); 
        ?>
		<?php
			echo $form->dropDownListRow($modPengirimanLinen,'ruangantujuan_id',$ruanganTujuans,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'empty'=>'--Pilih--')); 
        ?>
	</div>
	<div class="span4">
		<?php echo $form->textAreaRow($modPengirimanLinen,'keterangan_pengiriman',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Keterangan Perawatan')); ?>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo $form->labelEx($modPengirimanLinen, 'pegpengirim_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPengirimanLinen, 'pegpengirim_id'); ?>
                                <?php echo $form->textField($modPengirimanLinen, 'pegpengirim_nama', array('readonly'=>TRUE)); ?>
				<?php
				/*$this->widget('MyJuiAutoComplete', array(
					'model'=>$modPengirimanLinen,
					'attribute' => 'pegpengirim_nama',
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
							$("#'.Chtml::activeId($modPengirimanLinen, 'pegpengirim_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Pegawai Mengetahui',
						'class'=>'pegpengirim_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPengirimanLinen, 'pegpengirim_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiPengirim'),
				));*/
				?>
			</div>
		</div>
		
		<div class="control-group ">
			<?php echo $form->labelEx($modPengirimanLinen, 'mengetahui_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($modPengirimanLinen, 'mengetahui_id'); ?>
				<?php
				$this->widget('MyJuiAutoComplete', array(
					'model'=>$modPengirimanLinen,
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
							$("#'.Chtml::activeId($modPengirimanLinen, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
						'placeholder'=>'Ketikan Pegawai Mengetahui',
						'class'=>'mengetahui_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPengirimanLinen, 'pegpengirim_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
				));
				?>
			</div>
		</div>
	</div>
</div>

<?php
//========= Dialog buat cari data Pegawai Pengirim =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiPengirim',
    'options'=>array(
        'title'=>'Pencarian Pegawai Pengirim',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiPengirim = new LAPegawaiV('searchDialog');
$modPegawaiPengirim->unsetAttributes();
if(isset($_GET['LAPegawaiV'])) {
    $modPegawaiPengirim->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaipengirim-grid',
    'dataProvider'=>$modPegawaiPengirim->searchDialog(),
    'filter'=>$modPegawaiPengirim,
	'template'=>"{summary}{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($modPengirimanLinen,'pegpengirim_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($modPengirimanLinen,'pegpengirim_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiPengirim\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
		), /*
		array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPegawaiPengirim, 'gelardepan'),
			'value'=>'$data->gelardepan',
		), */
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiPengirim, 'nama_pegawai'),
			'value'=>'$data->namaLengkap',
		), /*
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPegawaiPengirim, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		), */
		array(
			'header'=>'Alamat Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiPengirim, 'alamat_pegawai'),
			'value'=>'$data->alamat_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Pengirim dialog =============================
?>

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

$modPegawaiMengetahui = new LAPegawaiV('searchDialog');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['LAPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['LAPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengetahui->searchDialog(),
    'filter'=>$modPegawaiMengetahui,
	'template'=>"{summary}{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
										  $(\"#'.CHtml::activeId($modPengirimanLinen,'mengetahui_id').'\").val(\"$data->pegawai_id\");
										  $(\"#'.CHtml::activeId($modPengirimanLinen,'mengetahui_nama').'\").val(\"$data->NamaLengkap\");
										  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'value'=>'$data->nomorindukpegawai',
		), /*
		array(
			'header'=>'Gelar Depan',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
			'value'=>'$data->gelardepan',
		), */
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
			'value'=>'$data->namaLengkap',
		), /*
		array(
			'header'=>'Gelar Belakang',
			'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
			'value'=>'$data->gelarbelakang_nama',
		), */
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