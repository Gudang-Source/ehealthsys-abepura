<div class="white-container">
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php 
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rkpeminjamanrm-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<?php 
    if(isset($_GET['sukses'])){
       Yii::app()->user->setFlash('success', "Data Peminjaman Dokumen Rekam Medis berhasil disimpan !");
    }
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class="rim2">Transaksi Peminjaman <b>Dokumen Rekam Medis</b></legend>
	<fieldset class="box">
		<legend class="rim"><i class="icon-white icon-user"></i> Data Pasien</legend>
		<?php $this->renderPartial($this->path_view.'_formDataPasien',array('form'=>$form,'model'=>$model)); ?>
	</fieldset>
        <?php echo $form->errorSummary($model); ?>
        <?php 
            if (!$model->isNewRecord){
                echo $form->hiddenField($model,'peminjamanrm_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
            }
        ?>
	<fieldset class="box">
            <legend class="rim"> Peminjaman Dokumen Rekam Medis</legend>		
            <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
            <?php $this->renderPartial($this->path_view.'_formPeminjaman',array('form'=>$form,'model'=>$model)); ?>
	</fieldset>
	
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)', 'disabled'=>($model->isNewRecord ? '' : 'disabled'))); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-danger',
				'onclick'=>'return refreshForm(this);'));  ?> 
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print()', 'disabled'=>($model->isNewRecord ? 'disabled' : '')))."";  ?>
        <?php 
            $content = $this->renderPartial('tips/peminjamanrm',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>	
    </div>
    <?php $this->endWidget(); ?>
</div>

<!-- ======================== Begin Widget Dialog Nama Peminjam ============================= -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogNamaPeminjam',
    'options' => array(
        'title' => 'Peminjam Dokumen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php 
	$modPeminjam = new RKPegawaiV('searchDialog');
	$modPeminjam->unsetAttributes();
	if(isset($_GET['RKPegawaiV'])) {
		$modPeminjam->attributes = $_GET['RKPegawaiV'];
	}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'namapeminjam-grid',
	'dataProvider'=>$modPeminjam->searchDialog(),
	'filter'=>$modPeminjam,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectNamaPeminjam",
							"onClick" => "
										  $(\"#'.CHtml::activeId($model,'namapeminjam').'\").val(\"$data->nama_pegawai\");
										  $(\"#dialogNamaPeminjam\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'NIP',
			'filter'=>  CHtml::activeTextField($modPeminjam, 'nomorindukpegawai'),
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPeminjam, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
		),
	),
		'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
$this->endWidget(); ?>
<!-- =============================== endWidget Dialog Nama Peminjam ============================ -->

<!-- ======================== Begin Widget Dialog Rekam Medik ============================= -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRekamMedik',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 700,
        'resizable' => false,
    ),
));
?>
<?php 
$modDokumenPasienLama = new RKDokumenpasienrmlamaV('searchPeminjaman'); 
$modDokumenPasienLama->unsetAttributes();
if (isset($_GET['RKDokumenpasienrmlamaV'])){
    $modDokumenPasienLama->attributes = $_GET['RKDokumenpasienrmlamaV'];
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rkdokumenpasienrmlama-v-grid',
    'dataProvider'=>$modDokumenPasienLama->searchPeminjaman(),
    'filter'=>$modDokumenPasienLama,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=> 'Pilih',
            'type'=>'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectDokumen",
				"onClick" => "
					$(\'#'.CHtml::activeId($model,'lokasirak_nama').'\').val(\'$data->lokasirak_nama\');
					$(\'#'.CHtml::activeId($model,'subrak_nama').'\').val(\'$data->subrak_nama\');
					$(\'#'.CHtml::activeId($model,'warnadokrm_namawarna').'\').val(\'$data->warnadokrm_namawarna\');
					$(\'#'.CHtml::activeId($model,'nama_pasien').'\').val(\'$data->nama_pasien\');
					$(\'#'.CHtml::activeId($model,'jenis_kelamin').'\').val(\'$data->jeniskelamin\');
					$(\'#'.CHtml::activeId($model,'tanggal_lahir').'\').val(\'$data->tanggal_lahir\');
					$(\'#'.CHtml::activeId($model,'pengirimanrm_id').'\').val(\'$data->pengirimanrm_id\');
					submitRekamMedis(\'$data->no_rekam_medik\', $data->dokrekammedis_id, $data->pasien_id, $data->pendaftaran_id, $data->ruangan_id);
					setUmur(\'$data->tanggal_lahir\');
					$(\'#dialogRekamMedik\').dialog(\'close\');
					return false;"))',
        ),
        array(
            'name'=>'lokasirak_id',
            'filter'=> CHtml::dropDownList('RKDokumenpasienrmlamaV[lokasirak_id]',$modDokumenPasienLama->lokasirak_id,CHtml::listData(LokasirakM::model()->findAll('lokasirak_aktif = true ORDER BY lokasirak_nama ASC'), 'lokasirak_id', 'lokasirak_nama'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->lokasirak_nama',
            ),
        array(
            'name'=>'subrak_id',
            'filter'=>  CHtml::dropDownList('RKDokumenpasienrmlamaV[subrak_id]',$modDokumenPasienLama->subrak_id,CHtml::listData(SubrakM::model()->findAll('subrak_aktif = true ORDER BY subrak_nama ASC'), 'subrak_id', 'subrak_nama'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->subrak_nama',
            ),
        array(
            'header'=>'Warna Dokumen',
            'type'=>'raw',
            'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_warnaDokumen\', array(\'warnadokrm_id\'=>$data->warnadokrm_id), true)',
        ),
        'no_rekam_medik',
        'tgl_pendaftaran',
        'no_pendaftaran',
        'nama_pasien',
        array(
            'name'=>'tanggal_lahir',
            'filter'=>false,
            'value'=>'$data->tanggal_lahir',
            ),
        array(
            'name'=>'jeniskelamin',
            'filter'=> CHtml::dropDownList('RKDokumenpasienrmlamaV[jeniskelamin]',$modDokumenPasienLama->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->jeniskelamin',
        ),
        array(
            'name'=>'alamat_pasien',
            'filter'=>false,
            'value'=>'$data->alamat_pasien',
        ),       
        array(
            'name'=>'instalasi_id',
            'filter'=>  CHtml::dropDownList('RKDokumenpasienrmlamaV[instalasi_id]',$modDokumenPasienLama->instalasi_id,CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->instalasi_nama',
        ),
        array(
            'name'=>'ruangan_id',
            'filter'=>  CHtml::dropDownList('RKDokumenpasienrmlamaV[ruangan_id]',$modDokumenPasienLama->ruangan_id,CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->ruangan_nama',
        ),
        array(
            'header'=>'Kelengkapan',
            'class'=>'CCheckBoxColumn',     
            'selectableRows'=>0,
            'id'=>'rows',
            'checked'=>'(isset($data->kelengkapandokumen) ? $data->kelengkapandokumen : "")',
        ),
        array(
            'header'=>'Print',
            'class'=>'CCheckBoxColumn',     
            'selectableRows'=>0,
            'id'=>'rows',
            'checked'=>'$data->printpeminjaman',
        ),
    ),
	'afterAjaxUpdate'=>'function(id, data){
			var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
	}',
)); ?>

<?php $this->endWidget(); ?>
<!-- =============================== endWidget Dialog Rekam Medik ============================ -->

<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model)); ?>
