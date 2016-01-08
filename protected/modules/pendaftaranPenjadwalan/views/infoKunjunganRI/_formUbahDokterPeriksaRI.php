<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash("success","Transaksi berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary(array($model,$modUbahDokter)); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id',array('readonly'=>true)); ?>
<div class="control-group ">
    <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('no_pendaftaran',$model->pendaftaran->no_pendaftaran,array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Nama Pasien', 'np', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('np',$model->pasien->nama_pasien,array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Nama Ruangan', 'ruangan_nama', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('ruangan_nama',$model->ruangan->ruangan_nama,array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Dokter Lama', 'dp', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('dp',$model->pegawai->nama_pegawai,array('readonly'=>true)); ?>
    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Dokter Baru <span class="required">*</span>', 'db', array('class'=>'control-label required')) ?>
    <div class="controls">
        <?php
			echo $form->dropDownList($model,'pegawai_id',
					CHtml::listData(
						$model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai'
					),
					array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")
				);
		?>

    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Alasan Perubahan <span class="required">*</span>', 'ap', array('class'=>'control-label required')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($modUbahDokter,'alasanperubahandokter', LookupM::getItems('alasanperubahandokter'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:220px')); ?>   

    </div>
</div>
<div class="control-group ">
    <?php echo CHtml::label('Keterangan', 'k', array('class'=>'control-label')) ?>
    <div class="controls">
		<?php echo $form->hiddenField($modUbahDokter,'dokterlama_id',array('class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);",'value'=>$model->pegawai_id)); ?>
       <?php echo $form->textArea($modUbahDokter,'keterangan',array('placeholder'=>'Keterangan Perubahan Dokter','rows'=>2, 'cols'=>60, 'class'=>'span3 ', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
       echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
		$this->createUrl($this->id.'/ubahDokterPeriksaRI&id='.$_GET['id']), 
		array('class'=>'btn btn-danger',
			  'onclick'=>'return refreshForm(this);'));
    ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        $.post("<?php echo $this->createUrl('getDataPendaftaranRI'); ?>", { pendaftaran_id: pendaftaran_id },
            function(data){
                $('#no_pendaftaran').val(data.no_pendaftaran);
                $('#PasienadmisiT_pendaftaran_id').val(data.pendaftaran_id);
                $('#np').val(data.nama_pasien);
                $('#ruangan_nama').val(data.ruangan_nama);
                var dokter = (data.gelardepan == null ? "dr.": data.gelardepan) + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#dp').val(dokter);
				$('#PPUbahdokterR_dokterlama_id').val(data.pegawai_id);
                listDokterRuangan(data.ruangan_id);
            },
        "json");
    }
//    loadDataPendaftaran();
    
    function listDokterRuangan(idRuangan)
    {
        $.post("<?php echo $this->createUrl('listDokterRuangan')?>", { idRuangan: idRuangan },
            function(data){
                $('#PasienadmisiT_pegawai_id').html(data.listDokter);
        }, "json");
    }    
	function closeDialog(){
		window.parent.$('#editDokterPeriksa').dialog('close');
	}
</script>