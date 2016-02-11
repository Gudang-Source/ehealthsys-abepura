<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
    </style>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group ">
				<label class="control-label">
					<?php echo CHtml::activecheckBox($model, 'ceklis_tglmasuk', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekTanggalMasuk()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
					Tanggal Masuk 
				</label>
				<div class="controls">
					<?php $model->verifikasiinasis_tglmasuk = $format->formatDateTimeForUser($model->verifikasiinasis_tglmasuk); ?>
					<?php   $format = new MyFormatter;
							$this->widget('MyDateTimePicker',array(
							'model'=>$model,
							'attribute'=>'verifikasiinasis_tglmasuk',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
					));?>
				</div>
			</div>
			
			<div class="control-group ">
				<label class="control-label">
					Sampai Dengan
				</label>
				<div class="controls">
					<?php $model->verifikasiinasis_tglmasuk_sampaidengan = $format->formatDateTimeForUser($model->verifikasiinasis_tglmasuk_sampaidengan); ?>
					<?php   $format = new MyFormatter;
							$this->widget('MyDateTimePicker',array(
							'model'=>$model,
							'attribute'=>'verifikasiinasis_tglmasuk_sampaidengan',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
					));?>
				</div>
			</div>
			<?php echo $form->dropDownListRow($model,'verifikasiinasis_jnspelayanan',  LookupM::getItems('jenispelayanan'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
			<?php echo $form->dropDownListRow($model,'verifikasiinasis_kelaspelayanan',  LookupM::getItems('kelasrawatbpjs'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
		</div>
		<div class="span4">
			<div class="control-group ">
				<label class="control-label">
					<?php echo CHtml::activecheckBox($model, 'ceklis_tglkeluar', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekTanggalKeluar()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
					Tanggal Keluar 
				</label>
				<div class="controls">
					<?php $model->verifikasiinasis_tglkeluar = $format->formatDateTimeForUser($model->verifikasiinasis_tglkeluar); ?>
					<?php   $format = new MyFormatter;
							$this->widget('MyDateTimePicker',array(
							'model'=>$model,
							'attribute'=>'verifikasiinasis_tglkeluar',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
					));?>
				</div>
			</div>
			<div class="control-group ">
				<label class="control-label">
					Sampai Dengan 
				</label>
				<div class="controls">
					<?php $model->verifikasiinasis_tglkeluar_sampaidengan = $format->formatDateTimeForUser($model->verifikasiinasis_tglkeluar_sampaidengan); ?>
					<?php   $format = new MyFormatter;
							$this->widget('MyDateTimePicker',array(
							'model'=>$model,
							'attribute'=>'verifikasiinasis_tglkeluar_sampaidengan',
							'mode'=>'date',
							'options'=> array(
								'dateFormat'=>Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
					));?>
				</div>
			</div>
			<?php echo $form->dropDownListRow($model,'verifikasiinasis_status',  LookupM::getItems('statusverifikasiinacbg'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
			<div class="control-group">
				<?php echo CHtml::label('No. Rekam Medik','', array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->hiddenField($model,'pasien_id'); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$model,
							'attribute'=>'no_rekam_medik',
							'value'=>$model->no_rekam_medik,
							'source'=>'js: function(request, response) {
									$.ajax({
										url: "'.$this->createUrl('AutocompletePasien').'",
										dataType: "json",
										data: {
											no_rekam_medik: request.term,
										},
										success: function (data) {
												response(data);
										}
									})
								 }',
							 'options'=>array(
								   'minLength' => 4,
									'focus'=> 'js:function( event, ui ) {
										 $(this).val( "");
										 return false;
									 }',
								   'select'=>'js:function( event, ui ) {
										$(this).val( ui.item.value);                                            
										$("#'.CHtml::activeId($model,'pasien_id').'").val( ui.item.pasien_id);                                            
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogPasien'),
							'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','rel'=>'tooltip','title'=>'Ketik No. RM untuk mencari pasien',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'class'=>'numbers-only'),
						)); 
					?>
					<?php echo $form->error($model,'no_rekam_medik'); ?>                        
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('No. SEP','', array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->hiddenField($model,'sep_id'); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$model,
							'attribute'=>'nosep',
							'value'=>$model->nosep,
							'source'=>'js: function(request, response) {
									$.ajax({
										url: "'.$this->createUrl('AutocompleteSep').'",
										dataType: "json",
										data: {
											nosep: request.term,
										},
										success: function (data) {
												response(data);
										}
									})
								 }',
							 'options'=>array(
								   'minLength' => 4,
									'focus'=> 'js:function( event, ui ) {
										 $(this).val( "");
										 return false;
									 }',
								   'select'=>'js:function( event, ui ) {
										$(this).val( ui.item.value);                                            
										$("#'.CHtml::activeId($model,'sep_id').'").val( ui.item.sep_id);                                            
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogSep'),
							'htmlOptions'=>array('placeholder'=>'Ketik No. Sep','rel'=>'tooltip','title'=>'Ketik No. RM untuk mencari pasien',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'class'=>''),
						)); 
					?>
					<?php echo $form->error($model,'nosep'); ?>                        
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Kode INA-CBG','', array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->hiddenField($model,'inacbg_id'); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$model,
							'attribute'=>'verifikasi_kdinacbg',
							'value'=>$model->verifikasi_kdinacbg,
							'source'=>'js: function(request, response) {
									$.ajax({
										url: "'.$this->createUrl('AutocompleteInacbg').'",
										dataType: "json",
										data: {
											kodeinacbg: request.term,
										},
										success: function (data) {
												response(data);
										}
									})
								 }',
							 'options'=>array(
								   'minLength' => 4,
									'focus'=> 'js:function( event, ui ) {
										 $(this).val( "");
										 return false;
									 }',
								   'select'=>'js:function( event, ui ) {
										$(this).val( ui.item.value);                                            
										$("#'.CHtml::activeId($model,'inacbg_id').'").val( ui.item.inacbg_id);                                            
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogInacbg'),
							'htmlOptions'=>array('placeholder'=>'Ketik Kode INA-CBG','rel'=>'tooltip','title'=>'Ketik Kode INA-CBG',
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'class'=>''),
						)); 
					?>
					<?php echo $form->error($model,'nosep'); ?>                        
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'verifikasi_bytagihan', array('class'=>'control-label inline')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'verifikasi_bytagihan', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3)); ?>   sd 
					<?php echo $form->textField($model,'verifikasi_bytagihan_sampaidengan', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3)); ?>            
					<?php echo $form->error($model, 'verifikasi_bytagihan'); ?>
					<?php echo $form->error($model, 'verifikasi_bytagihan_sampaidengan'); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'verifikasi_bytarifgruper', array('class'=>'control-label inline')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'verifikasi_bytarifgruper', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3)); ?>   sd 
					<?php echo $form->textField($model,'verifikasi_bytarifgruper_sampaidengan', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbers-only','maxlength'=>3)); ?>            
					<?php echo $form->error($model, 'verifikasi_bytarifgruper'); ?>
					<?php echo $form->error($model, 'verifikasi_bytarifgruper_sampaidengan'); ?>
				</div>
			</div>
		</div> 
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
		<?php
		echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
			'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
		?>
	</div>
</div>    
<?php
	$this->endWidget();
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasien',
        'options'=>array(
            'title'=>'Pencarian Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
    $modDataPasien = new ARPasienM('searchDialog');
    $modDataPasien->unsetAttributes();
    $format = new MyFormatter();
    $modDataPasien->ispasienluar = FALSE;
    if(isset($_GET['ARPasienM'])) {
        $modDataPasien->attributes = $_GET['ARPasienM'];
//        $modDataPasien->tanggal_lahir =  isset($_GET['ARPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['ARPasienM']['tanggal_lahir']) : null;
        $modDataPasien->cari_kelurahan_nama = $_GET['ARPasienM']['cari_kelurahan_nama'];
        $modDataPasien->cari_kecamatan_nama = $_GET['ARPasienM']['cari_kecamatan_nama'];
		if(isset($_GET['ARPasienM']['nomorindukpegawai'])){
			$modDataPasien->nomorindukpegawai = $_GET['ARPasienM']['nomorindukpegawai'];
		}        
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'pasien-m-grid',
		'dataProvider'=>$modDataPasien->searchDialog(),
		'filter'=>$modDataPasien,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
								"id" => "selectPasien",
								"onClick" => "
									$(\"#'.CHtml::activeId($model,'no_rekam_medik').'\").val(\"$data->no_rekam_medik\");
									$(\"#'.CHtml::activeId($model,'pasien_id').'\").val(\"$data->pasien_id\");
									$(\"#dialogPasien\").dialog(\"close\");
								"))',
			),
			'no_rekam_medik',
			'nama_pasien',
			'nama_bin',
			array(
				'name'=>'jeniskelamin',
				'type'=>'raw',
				'filter'=> LookupM::model()->getItems('jeniskelamin'),
				'value'=>'$data->jeniskelamin'
			),
			array(
				'name'=>'tanggal_lahir',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
				'filter'=>$this->widget('MyDateTimePicker',array(
								'model'=>$modDataPasien,
								'attribute'=>'tanggal_lahir',
								'mode'=>'date',
								'options'=> array(
														'dateFormat'=>Params::DATE_FORMAT,
													),
								'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tanggal_lahir','placeholder'=>'23 Jan 1993'),
								),true
							),
				'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
			),
			'alamat_pasien',
			'rw',
			'rt',
			array(
				'header'=>'Nama Kelurahan',
				'name'=>'cari_kelurahan_nama',
				'type'=>'raw',
				'value'=>'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
			),
			array(
				'header'=>'Nama Kecamatan',
				'name'=>'cari_kecamatan_nama',
				'type'=>'raw',
				'value'=>'$data->kecamatan->kecamatan_nama'
			),
			'norm_lama',
			array(
				'name'=>'statusrekammedis',
				'type'=>'raw',
				'filter'=> LookupM::getItems('statusrekammedis'),
				'value'=>'$data->statusrekammedis',
			),
		),
		'afterAjaxUpdate'=>'function(id, data){
			 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
					showMonthAfterYear:false}, 
					jQuery.datepicker.regional[\'id\'], 
				   {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
				   \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
				   \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
			jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});


		}',
    ));
    $this->endWidget();
?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogSep',
        'options'=>array(
            'title'=>'Pencarian Data SEP',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
    $modDataSEP = new ARSepT('searchDialog');
    $modDataSEP->unsetAttributes();
    $format = new MyFormatter();
    if(isset($_GET['ARSepT'])) {
        $modDataSEP->attributes = $_GET['ARSepT'];
        $modDataSEP->nosep = $_GET['ARSepT']['nosep'];       
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasien-m-grid',
            'dataProvider'=>$modDataSEP->searchDialog(),
            'filter'=>$modDataSEP,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPasien",
									"onClick" => "
										$(\"#'.CHtml::activeId($model,'nosep').'\").val(\"$data->nosep\");
										$(\"#'.CHtml::activeId($model,'sep_id').'\").val(\"$data->sep_id\");
										$(\"#dialogSep\").dialog(\"close\");
									"))',
				),
				'nosep',
				array(
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglsep)'
				),
				array(
					'header'=>'No. Kartu',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'No. Pendaftaran',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'Tgl. Pendaftaran',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'No. Rekam Medik',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'Nama Pasien',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
				array(
					'header'=>'NIK',
					'name'=>'tglsep',
					'type'=>'raw',
					'value'=>'$data->nokartuasuransi'
				),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            }',
    ));
    $this->endWidget();
    ?>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogInacbg',
        'options'=>array(
            'title'=>'Pencarian Data Inacbg',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
    $modInacbg = new ARInacbgT('search');
    $modInacbg->unsetAttributes();
    $format = new MyFormatter();
    if(isset($_GET['ARInacbgT'])) {
        $modInacbg->attributes = $_GET['ARInacbgT'];
        $modInacbg->nosep = $_GET['ARInacbgT']['ARInacbgT'];       
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'inacbg-m-grid',
            'dataProvider'=>$modInacbg->search(),
            'filter'=>$modInacbg,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPasien",
									"onClick" => "
										$(\"#'.CHtml::activeId($model,'verifikasi_kdinacbg').'\").val(\"$data->kodeinacbg\");
										$(\"#'.CHtml::activeId($model,'inacbg_id').'\").val(\"$data->inacbg_id\");
										$(\"#dialogInacbg\").dialog(\"close\");
									"))',
				),
				'inacbg_nosep',
				array(
					'name'=>'inacbg_tgl',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->inacbg_tgl)'
				),
				array(
					'header'=>'KODE INA-CBG',
					'name'=>'kodeinacbg',
					'type'=>'raw',
					'value'=>'$data->kodeinacbg'
				),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            }',
    ));
    $this->endWidget();
    ?>