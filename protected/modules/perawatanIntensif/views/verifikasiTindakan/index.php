<div class="white-container">
	<legend class="rim2"><b>Verifikasi</b> Tindakan</legend>
<?php
$this->breadcrumbs=array(
	'Tindakan',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rencanatindakan-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus'=>'#',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
)); ?>
<?php echo $form->errorSummary($modRencanaTindakan); ?>
<fieldset id="form-infopasien" class="box">
    <legend class="rim"><span class='judul'>Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setInfoPasienReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data pasien')); ?></span></legend>
    <div class="row-fluid">
        <?php $this->renderPartial('_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi,'modInfoPasien'=>$modInfoPasien)); ?>
    </div>
</fieldset>
<fieldset class="box">
<?php $this->renderPartial('_tableRencanaTindakan',array(
                        'format'=>$format,
                        'modRiwayatTindakans'=>$modRiwayatTindakans,
                        )); ?>
</fieldset>

<fieldset class="box">
<legend class="rim">Tindakan yang Telah Dilakukan</legend>
    <p class="help-block"><?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    
    <?php
        echo CHtml::hiddenField('jenistarif_id','',array());
        echo CHtml::hiddenField('jenistarif_nama','',array());
    ?>
	<div style="overflow: auto;max-width: 1300px;">
    <table class="items table table-striped table-bordered table-condensed" id="table_rencanatindakan">
        <thead>
            <tr>
                <th>Kategori Rencana Tindakan</th>
                <th>Tanggal Rencana</th>
                <th>Rencana Tindakan <font color='red'>*</font></th>
                <th>Tarif Satuan</th> 
                <th>Jumlah</th>
                <th>Satuan<br/>Tindakan</th>
                <th>Cyto </th>
                <th>Jumlah Tarif</th> 
                <th>Dokter</th> 
                <th>Verifikasi</th> 
                <th>Keterangan Tindakan</th> 
                <!--<th>&nbsp;</th>-->
            </tr>
        </thead>
        <?php 
            $trTindakan = $this->renderPartial('_rowTindakanPasien',array('modTindakan'=>$modTindakan,'modTindakans'=>$modTindakans),true); 
            echo $trTindakan;
        ?>
    </table>	
    </div></fieldset><br/>
	<fieldset class="box">
	<legend class='rim'>Verifikasi Tindakan</legend>
	<div class='row-fluid'>
		<div class="span6">
			<div class="control-group ">
				<?php echo $form->labelEx($modVerifikasiTindakan,'tglverifikasirenc', array('class'=>'control-label')) ?>
				<div class="controls">  
					<?php $modVerifikasiTindakan->tglverifikasirenc = isset($modVerifikasiTindakan->tglverifikasirenc) ? MyFormatter::formatDateTimeForUser($modVerifikasiTindakan->tglverifikasirenc) : date('d M Y H:i:s'); ?>
					<?php $this->widget('MyDateTimePicker',array(
										 'model'=>$modVerifikasiTindakan,
										 'attribute'=>'tglverifikasirenc',
										 'mode'=>'datetime',
										 'options'=> array(
										 'dateFormat'=>Params::DATE_FORMAT,
										 'maxDate'=>'d',   
											 ),
										 'htmlOptions'=>array('readonly'=>true, 'class'=>'dtPicker3',
										 'onkeypress'=>"return $(this).focusNextInputField(event)"),
									)); ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($modVerifikasiTindakan,'noverifikasi_renc',array('class'=>'span3','readonly'=>true)); ?>
		</div>
		<div class='span6'>
			<div class="control-group ">				
				<?php echo $form->labelEx($modVerifikasiTindakan,'petugas_verif_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->hiddenField($modVerifikasiTindakan,'petugas_verif_id',array()); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modVerifikasiTindakan,
							'attribute'=>'nama_pegawai',
							'value'=>isset($modVerifikasiTindakan->petugas->NamaLengkap) ? isset($modVerifikasiTindakan->petugas->NamaLengkap) : "", 
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('AutocompletePegawaiVerifikasi').'",
											   dataType: "json",
											   data: {
												   nama_pegawai: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
							 'options'=>array(
								   'showAnim'=>'fold',
								   'minLength' => 2,
								   'select'=>'js:function( event, ui ) {
									   $(this).val( ui.item.label);
									   $("#'.CHtml::activeId($modVerifikasiTindakan,'petugas_verif_id').'").val(ui.item.pegawai_id);
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogPegawaiVerifikasi'),
							'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Petugas Verifikasi",'onkeypress'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($modVerifikasiTindakan,'petugas_verif_id').'").val(""); '),
						)); 
					?>
				</div>
			</div>
			<div class="control-group ">				
				<?php echo $form->labelEx($modVerifikasiTindakan,'mengetahui_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->hiddenField($modVerifikasiTindakan,'mengetahui_id',array()); ?>
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model'=>$modVerifikasiTindakan,
							'attribute'=>'mengetahui_nama',
							'value'=>isset($modVerifikasiTindakan->mengetahui->NamaLengkap) ? isset($modVerifikasiTindakan->mengetahui->NamaLengkap) : "", 
							'source'=>'js: function(request, response) {
										   $.ajax({
											   url: "'.$this->createUrl('AutocompletePegawaiMengetahui').'",
											   dataType: "json",
											   data: {
												   mengetahui_nama: request.term,
											   },
											   success: function (data) {
													   response(data);
											   }
										   })
										}',
							 'options'=>array(
								   'showAnim'=>'fold',
								   'minLength' => 2,
								   'select'=>'js:function( event, ui ) {
									   $(this).val( ui.item.label);
									   $("#'.CHtml::activeId($modVerifikasiTindakan,'mengetahui_id').'").val(ui.item.pegawai_id);
										return false;
									}',
							),
							'tombolDialog'=>array('idDialog'=>'dialogPegawaiMengetahui'),
							'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Pegawai Mengetahui",'onkeypress'=>"return $(this).focusNextInputField(event)",
								'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($modVerifikasiTindakan,'mengetahui_id').'").val(""); '),
						)); 
					?>
				</div>
			</div>
			<div class="control-group">
				<label class='control-label'>Keterangan</label>
				<div class="controls">
					<?php  echo $form->textArea($modVerifikasiTindakan,'keterangan_verifrenc'); ?>
				</div>
			</div>
		</div>		
	</div>
	</fieldset>
    <div class="form-actions">
		<?php 
			$disableSave = false;
			$disableSave = (!empty($_GET['verifrenctindakan_id'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
								array('class'=>'btn btn-primary', 'id'=>'btn_submit','type'=>'submit','disabled'=>$disableSave)); ?>
		<?php
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/'.$this->action->id.'&pendaftaran_id='.$_GET['pendaftaran_id'].'&pasienadmisi_id='.$_GET['pasienadmisi_id']), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
		?>
		<?php
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
		?>
		<?php
			$content = $this->renderPartial('tips/tipsRencanaTindakan',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>
    </div>    

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_dialogPemeriksa',array('modTindakan'=>$modTindakan)); ?> 
<?php $this->renderPartial('_dialogPemeriksaLengkap',array('modTindakan'=>$modTindakan)); ?> 
<?php $this->renderPartial('_jsFunctions', array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi,'modInfoPasien'=>$modInfoPasien,'modTindakan'=>$modTindakan,'modTindakans'=>$modTindakans)); ?>
<?php 
//========= Dialog buat daftar tindakan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDaftarTindakanPaket',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div id="tableDaftarTindakanPaket"></div>';
    $this->renderPartial('_daftarTindakanPaket');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tindakan =============================
?> 
<?php 
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id'=>'dialogPegawaiVerifikasi',
		'options'=>array(
			'title'=>'Daftar Petugas Verifikasi',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>900,
			'resizable'=>false,
		),
	));

	$modPegawaiVerifikasi = new RIPegawaiM('search');
	$modPegawaiVerifikasi->unsetAttributes();
	if(isset($_GET['RIPegawaiM'])){
		$modPegawaiVerifikasi->attributes = $_GET['RIPegawaiM'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'pegawaiverifikasi-m-grid',
		'dataProvider'=>$modPegawaiVerifikasi->search(),
		'filter'=>$modPegawaiVerifikasi,
		'template'=>"{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
					"id"=>"selectPegawaiVerifikasi",
					"onClick"=>"$(\"#'.CHtml::activeId($modVerifikasiTindakan,'petugas_verif_id').'\").val(\"$data->pegawai_id\");
							$(\"#'.CHtml::activeId($modVerifikasiTindakan,'nama_pegawai').'\").val(\"$data->NamaLengkap\");
							$(\"#dialogPegawaiVerifikasi\").dialog(\"close\");
							return false;"
					))'
			),

			array(
				'header'=>'Nama Pegawai',
				'type'=>'raw',
				'value'=>'$data->NamaLengkap',
			),
			'jeniskelamin',
			'nomorindukpegawai',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
$this->endWidget();
?>
<?php 
	$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id'=>'dialogPegawaiMengetahui',
		'options'=>array(
			'title'=>'Daftar Pegawai Mengetahui',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>900,
			'resizable'=>false,
		),
	));

	$modPegawaiMengetahui = new RIPegawaiM('search');
	$modPegawaiMengetahui->unsetAttributes();
	if(isset($_GET['RIPegawaiM'])){
		$modPegawaiMengetahui->attributes = $_GET['RIPegawaiM'];
	}
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'pegawaimengetahui-m-grid',
		'dataProvider'=>$modPegawaiMengetahui->search(),
		'filter'=>$modPegawaiMengetahui,
		'template'=>"{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
					"id"=>"selectPegawaiMengetahui",
					"onClick"=>"$(\"#'.CHtml::activeId($modVerifikasiTindakan,'mengetahui_id').'\").val(\"$data->pegawai_id\");
							$(\"#'.CHtml::activeId($modVerifikasiTindakan,'mengetahui_nama').'\").val(\"$data->NamaLengkap\");
							$(\"#dialogPegawaiMengetahui\").dialog(\"close\");
							return false;"
					))'
			),

			array(
			  'header'=>'Nama Pegawai',
			  'type'=>'raw',
			  'value'=>'$data->NamaLengkap',
			),
			'jeniskelamin',
			'nomorindukpegawai',
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	));
$this->endWidget();
?>
<?php 
//========= Dialog buat daftar dokter  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDaftarDokter',
    'options'=>array(
        'title'=>'Daftar Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div id="tableDaftarDokter"></div>';
    $this->renderPartial('_daftarDokter');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar dokter =============================
?> 
</div>