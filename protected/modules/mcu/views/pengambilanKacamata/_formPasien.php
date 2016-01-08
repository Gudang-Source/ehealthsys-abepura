<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jpegcam/assets/webcam.js'); ?>
<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");
?>
<style>
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
<div class="span4">
	<?php echo $form->dropDownListRow($model, 'jnstransaksi_km', LookupM::getItems('jnstransaksi_km'), array('class' => 'span3','onchange'=>'setPegawaiBaru()', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <div class="control-group">
        <?php echo CHtml::label("NIP", 'nomorindukpegawai', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->hiddenField($model, 'pegawai_id', array());
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'cari_nomorindukpegawai',
                'value' => $modPegawai->nomorindukpegawai,
                'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompletePegawai') . '",
									   dataType: "json",
									   data: {
										   nomorindukpegawai: request.term,
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
                    'select' => 'js:function( event, ui ) {
								$(this).val( ui.item.value);
								setDataPegawai(ui.item.pegawai_id);
								return false;
							}',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                'htmlOptions' => array('placeholder' => 'Ketik NIP', 'rel' => 'tooltip', 'title' => 'Ketik NIP untuk mencari pasien',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'class' => 'numbers-only required'),
            ));
            ?>
        </div>
    </div>       
</div>
<div class="span4">
	<div class="control-group">
        <div class="control-label">Nama Pekerja</div>
        <div class="controls">
            <?php echo $form->textField($model, 'nama_pegawai', array('placeholder' => 'Nama Pekerja', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>    
        </div>
    </div>
    <?php echo $form->textFieldRow($model, 'departement_peg', array('placeholder' => 'Departement', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
</div>
<div class="span4">	    
    <?php echo $form->textFieldRow($model, 'namapasien_hub', array('placeholder' => 'Nama Pasien', 'class' => 'span3 ' . $nama_kapital, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>    
	<?php echo $form->dropDownListRow($model, 'statushubungan', LookupM::getItems('statuskeluargaasuransi'), array('class' => 'span3', 'empty' => '-- Pilih --','onchange'=>'setJumlahHarga();', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));

$modDataPasien = new MCPegawaiM('search');
$modDataPasien->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['MCPegawaiM'])) {
    $modDataPasien->attributes = $_GET['MCPegawaiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modDataPasien->search(),
    'filter' => $modDataPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPasien",
									"onClick" => "
										setDataPegawai(\"$data->pegawai_id\");
										$(\"#dialogPegawai\").dialog(\"close\");
									"))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => '$data->nomorindukpegawai',
        ),
        'gelardepan',
        'nama_pegawai',
        'gelarbelakang.gelarbelakang_nama',
        array(
            'name' => 'jeniskelamin',
            'type' => 'raw',
            'filter' => LookupM::model()->getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin'
        ),
        array(
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter' => $this->widget('MyDateTimePicker', array(
                'model' => $modDataPasien,
                'attribute' => 'tgl_lahirpegawai',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker3', 'id' => 'tanggal_lahir', 'placeholder' => '23 Jan 1993'),
                    ), true
            ),
            'htmlOptions' => array('width' => '80', 'style' => 'text-align:center'),
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
				 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
				 jQuery(\'#tgl_lahirpegawai\').datepicker(jQuery.extend({
						showMonthAfterYear:false}, 
						jQuery.datepicker.regional[\'id\'], 
					   {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
					   \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
					   \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
				jQuery(\'#tgl_lahirpegawai_date\').on(\'click\', function(){jQuery(\'#tgl_lahirpegawai\').datepicker(\'show\');});


			}',
));
$this->endWidget();
?>