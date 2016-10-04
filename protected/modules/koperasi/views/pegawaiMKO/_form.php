<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pegawai-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="panel panel-primary col-sm-6">
		<div class="panel-heading panel-heading2">
			<div class="panel-title">Data Pegawai</div>  
		</div>
		<div class="panel-body col-sm-12">
			<div class="form-group">
				<?php echo $form->labelEx($model, 'nomorindukpegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'nomorindukpegawai',array('class'=>'form-control numbersOnly','maxlength'=>50, 'placeholder'=>'Ketikkan Nomor Induk Pegawai')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'no_kartupegawainegerisipil', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'no_kartupegawainegerisipil',array('class'=>'form-control numbersOnly','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('no_kartupegawainegerisipil'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'jenisidentitas', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-3">
					<?php echo $form->dropDownList($model,'jenisidentitas',Params::jenisIdentitas(), array('class'=>'form-control','maxlength'=>20, 'empty'=>'-- Pilih --',)); ?>
				</div>
				<?php // echo $form->labelEx($model, 'noidentitas', array('class'=>'control-label col-sm-2')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model,'noidentitas',array('class'=>'form-control numbersOnly','maxlength'=>100, 'placeholder'=>'Ketikan No Identitas')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'nama_pegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-3">
					<?php echo $form->dropDownList($model,'gelardepan',Params::gelarDepan(),array('empty'=>'-- Pilih --','class'=>'form-control','maxlength'=>10, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('gelardepan'),)); ?>
				</div>
				<div class="col-sm-4">
					<?php echo $form->textField($model,'nama_pegawai',array('class'=>'form-control alphaonlyK','maxlength'=>50, 'onkeyup'=>'convertToUpper(this)', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nama_pegawai'),)); ?>
				</div>
				<div class="col-sm-2">
					<?php echo $form->textField($model,'gelarbelakang',array('class'=>'form-control','maxlength'=>10, 'onkeyup'=>'convertToUpper(this)', 'placeholder'=>'')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'nama_keluarga', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'nama_keluarga',array('class'=>'form-control alphaonlyK', 'onkeyup'=>'convertToUpper(this)', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nama_keluarga'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo CHtml::label('Tempat / Tgl Lahir<span class="required">*</span>',null, array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-4">
					<?php echo $form->textField($model,'tempatlahir_pegawai',array('class'=>'form-control alphaonlyK','maxlength'=>30, 'onkeyup'=>'convertToUpper(this)', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('tempatlahir_pegawai'),)); ?>
				</div>
				<div class="col-sm-5">
					<div class="input-group"><?php 
						$this->widget('bootstrap.widgets.TbDatePicker', array(
							'model'=>$model, 'attribute'=>'tgl_lahirpegawai', 'options'=>array('format'=>'dd/mm/yyyy'), 'htmlOptions'=>array('class'=>'form-control'),
						));?>
						<div class='input-group-addon' onclick="$('#PegawaiM_tgl_lahirpegawai').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
					</div>
					<?php // echo $form->datepickerRow($model,'tgl_lahirpegawai',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'alamat_pegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textArea($model,'alamat_pegawai',array('rows'=>6, 'cols'=>50, 'class'=>'form-control', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('alamat_pegawai'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'kelurahan_id', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'kelurahan_id',CHtml::listData(KelurahanM::model()->findAll('kelurahan_aktif = true'), 'kelurahan_id', 'kelurahan_nama'),
					array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'jeniskelamin', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-3">
					<div class="radio">
						<label><?php echo $form->radioButton($model, 'jeniskelamin', array('value'=>'LAKI-LAKI', 'uncheckValue'=>null)); ?>Laki-laki</label>
					</div>
					<?php //echo $form->radioButtonList($model,'jeniskelamin',Params::getJenisKelamin(),array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('jeniskelamin'),)); ?>
				</div>
				<div class="col-sm-3">
					<div class="radio">
						<label><?php echo $form->radioButton($model, 'jeniskelamin', array('value'=>'PEREMPUAN', 'uncheckValue'=>null)); ?>Perempuan</label>
					</div>
					<?php //echo $form->radioButtonList($model,'jeniskelamin',Params::getJenisKelamin(),array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('jeniskelamin'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'statusperkawinan', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'statusperkawinan',Params::statusPerkawinan(), array('empty'=>'-- Pilih -- ', 'class'=>'form-control','maxlength'=>20, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('statusperkawinan'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'golonganpegawai_id', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'golonganpegawai_id',CHtml::listData(GolonganpegawaiM::model()->findAll('golonganpegawai_aktif = true'), 'golonganpegawai_id', 'golonganpegawai_nama'),
					array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'pangkat_id', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'pangkat_id',CHtml::listData(PangkatM::model()->findAll('pangkat_aktif = true'), 'pangkat_id', 'pangkat_nama'),
					array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'jabatan_id', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'jabatan_id',CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'),
					array('empty'=>'-- Pilih --', 'class'=>'form-control')); ?>
				</div>
			</div>
			<?php // echo $form->textFieldRow($model,'nama_keluarga',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nama_keluarga'),)); ?>
		
			<?php // echo $form->textFieldRow($model,'gelarbelakang',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('gelarbelakang'),)); ?>
		</div>
		
</div>
<div class="panel panel-primary col-sm-6" style="float:right">
		<div class="panel-heading panel-heading2">
			<div class="panel-title">Photo Pegawai</div>  
		</div>
		<div class="panel-body">
			<div class="panel-body col-sm-6">
			<div class="form-group">
				<div class="col-sm-12">
					<img id="photo_pegawai" width="150" height="200">
				</div>
				<div style="float: clear;"></div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<?php echo $form->fileField($model, 'photopegawai', array('onchange'=>"readURL(this);",)); ?>
				</div>
			</div>
		</div>
		</div>
</div>
<div class="panel panel-primary col-sm-6" style="float:right" data-collapsed="0">
		<div class="panel-heading panel-heading2">
			<div class="panel-title">Detail Pegawai</div>  
			<div class="panel-options">
				<a href="#" data-rel="collapse">
					<i class="entypo-down-open"></i>
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<?php echo $form->labelEx($model, 'agama', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'agama',Params::agama(), array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nomorindukpegawai'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'golongandarah', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-3">
					<?php echo $form->dropDownList($model,'golongandarah',Params::golonganDarah(), array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nomorindukpegawai'),)); ?>
				</div>
				<div class="col-sm-3">
					<div class="radio">
						<label><?php echo $form->radioButton($model, 'rhesus', array('value'=>'RH+', 'uncheckValue'=>null)); ?>RH+</label>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="radio">
						<label><?php echo $form->radioButton($model, 'rhesus', array('value'=>'RH-', 'uncheckValue'=>null)); ?>RH-</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'alamatemail', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'alamatemail', array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('alamatemail'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'notelp_pegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'notelp_pegawai',array('class'=>'form-control numbersOnly','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('notelp_pegawai'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'nomobile_pegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'nomobile_pegawai',array('class'=>'form-control numbersOnly','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nomobile_pegawai'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'jeniswaktukerja', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'jeniswaktukerja',Params::jenisWaktuKerja(), array('empty'=>'-- Pilih --','class'=>'form-control','maxlength'=>20, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('jeniswaktukerja'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'tglmulaibekerja', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<div class="input-group">
						<?php 
						$this->widget('bootstrap.widgets.TbDatePicker', array(
							'model'=>$model, 'attribute'=>'tglmulaibekerja', 'options'=>array('format'=>'dd/mm/yyyy'), 'htmlOptions'=>array('class'=>'form-control'),
						));
					?><div class='input-group-addon' onclick="$('#PegawaiM_tglmulaibekerja').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
					</div>
				</div>
			</div>
			<div class="form-group" hidden>
				<?php echo $form->labelEx($model, 'kategoripegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'kategoripegawai',Params::kategoriPegawai(), array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>10, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('jeniswaktukerja'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'unit_id', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'unit_id', CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true','order' => 'namaunit ASC')), 'unit_id', 'namaunit'), array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>10)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'kategoripegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'kategoripegawai', Params::kategoriPegawai(), array('empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>10)); ?>
				</div>
			</div>

		</div>
</div>
<div class="panel panel-primary col-sm-6" data-collapsed="0">
		<div class="panel-heading panel-heading2">
			<div class="panel-title">Lain-lain</div>  
			<div class="panel-options">
				<a href="#" data-rel="collapse">
					<i class="entypo-down-open"></i>
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<?php echo $form->labelEx($model, 'banknorekening', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'banknorekening',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('banknorekening'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'norekening', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'norekening',array('class'=>'form-control numbersOnly','maxlength'=>100, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('norekening'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'npwp', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'npwp',array('class'=>'form-control numbersOnly','maxlength'=>25, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('npwp'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'gajipokok', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'gajipokok',array('class'=>'form-control num', 'style'=>'text-align:right', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('gajipokok'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'insentifpegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'insentifpegawai',array('class'=>'form-control num', 'style'=>'text-align:right', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('insentifpegawai'),)); ?>
				</div>
			</div>
			
		</div>
</div>


	<?php //echo $form->textFieldRow($model,'warganegara_pegawai',array('class'=>'form-control','maxlength'=>25, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('warganegara_pegawai'),)); ?>

	<?php //echo $form->datepickerRow($model,'tglberhenti',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

	<?php //echo $form->datepickerRow($model,'peg_create_time',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

	<?php //echo $form->datepickerRow($model,'peg_update_time',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

	<?php //echo $form->textFieldRow($model,'peg_create_login',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('peg_create_login'),)); ?>

	<?php //echo $form->textFieldRow($model,'peg_update_login',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('peg_update_login'),)); ?>

	<?php //echo $form->checkBoxRow($model,'pegawai_aktif',array('class'=>'form-control')); ?>

<div class="form-group" style="text-align: center;">
	<div class="col-sm-offset-3 col-sm-5">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Simpan' : 'Simpan',
			'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)',),
			'visible'=>($model->isNewRecord || $this->action->id == 'update'),
		)); ?>
	<?php echo $model->isNewRecord ? '&nbsp;&nbsp;'.CHtml::ResetButton('Ulang', array('class' => 'btn btn-default')) : ''; ?>
	<?php echo ($model->isNewRecord || $this->action->id == 'update') ? '':CHtml::link('Print', $this->createUrl('printSuratAnggota', array('id'=>$model->pegawai_id)), array('target'=>'blank', 'class'=>'btn btn-green')); ?>
	<?php echo Chtml::link('Kembali',$this->createUrl('/admin/pegawaiM/admin'), array('class' => 'btn btn-link')); ?>	
	</div>
</div>

<?php $this->endWidget(); ?>
<?php $js = <<<'EOF'

$(".num").each(function() {
	$(this).maskMoney({
		defaultZero:true,
		allowZero:true,
		thousands:'',
		thousands:'.',
		precision:0
	});
});

EOF;

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
Yii::app()->clientScript->registerScript('numMasker', $js, CClientScript::POS_READY);

?>
<script type="text/javascript">

$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});

$('.alphaonlyK').bind('keyup blur',function(){ 
    $(this).val( $(this).val().replace(/[^a-zA-Z ]/g,'') );}
);

function convertToUpper(obj)
{
    var string = obj.value;
    $(obj).val(string.toUpperCase());
}

function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
        $('#photo_pegawai')
        .attr('src', e.target.result)
        .width(150)
        .height(200);
    };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>