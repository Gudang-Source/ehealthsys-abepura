<style>
.num {
	text-align: right;
}
</style>
<div class="panel panel-primary col-sm-12">
	<div class="panel-heading panel-heading2">
		<div class="panel-title"></div>  
	</div>
	<div class="panel panel-primary col-sm-6">
		<div class="panel-heading panel-heading2">
			<div class="panel-title">Data Pegawai</div>  
		</div>
		<div class="panel-body">
		
			<div class="form-group">
				<?php echo $form->labelEx($model, 'nomorindukpegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'nomorindukpegawai',array('class'=>'form-control numbersOnly','maxlength'=>18, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nomorindukpegawai'),)); ?>
					<?php echo $form->hiddenField($model,'pegawai_id'); ?>
				</div>
			</div>
			<div class="form-group" hidden>
				<?php echo $form->labelEx($model, 'no_kartupegawainegerisipil', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'no_kartupegawainegerisipil',array('class'=>'form-control numbersOnly','maxlength'=>18, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('no_kartupegawainegerisipil'),)); ?>
				</div>
			</div>
			<?php /*
			<div class="form-group">
				<?php echo $form->labelEx($model, 'jenisidentitas', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-3">
					<?php echo $form->dropDownList($model,'jenisidentitas',Params::jenisIdentitas(), array('class'=>'form-control','maxlength'=>20, 'empty'=>'-- Pilih --',)); ?>
				</div>
				<?php // echo $form->labelEx($model, 'noidentitas', array('class'=>'control-label col-sm-2')); ?>
				<div class="col-sm-6">
					<?php echo $form->textField($model,'noidentitas',array('class'=>'form-control numbersOnly','maxlength'=>20, 'placeholder'=>'Ketikan No Identitas')); ?>
				</div>
			</div>
			*/ ?>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'nama_pegawai', array('class'=>'control-label col-sm-3')); ?>
				<?php /*
                                <div class="col-sm-3" hidden>
					<?php echo $form->dropDownList($model,'gelardepan',Params::gelarDepan(),array('empty'=>'-- Pilih --','class'=>'form-control','maxlength'=>10, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('gelardepan'),)); ?>
				</div>
                                 * 
                                 */ ?>
				<div class="col-sm-7">
					<?php echo $form->textField($model,'nama_pegawai',array('class'=>'form-control alphaonlyK uc','maxlength'=>50, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nama_pegawai'),)); ?>
				</div>
				<div class="col-sm-2">
					<?php $model->gelarbelakang = "-"; ?>
					
					<?php echo $form->hiddenField($model,'gelarbelakang'); ?>
					<button type="button" class="btn btn-blue" onclick='$("#dialog_pegawai").modal("show");'><i class="entypo-search"></i></button>
					<?php //echo $form->textField($model,'gelarbelakang',array('class'=>'form-control','maxlength'=>10, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('gelarbelakang'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'nama_keluarga', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'nama_keluarga',array('class'=>'form-control alphaonlyK uc', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('nama_keluarga'),)); ?>
				</div>
			</div>
			<?php /*
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
			*/ ?>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'alamat_pegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textArea($model,'alamat_pegawai',array('rows'=>6, 'cols'=>50, 'class'=>'form-control uc', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('alamat_pegawai'),)); ?>
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
						<label><?php echo $form->radioButton($model, 'jeniskelamin', array('id'=>'jk_laki', 'value'=>'LAKI-LAKI', 'uncheckValue'=>null)); ?>Laki-laki</label>
					</div>
					<?php //echo $form->radioButtonList($model,'jeniskelamin',Params::getJenisKelamin(),array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('jeniskelamin'),)); ?>
				</div>
				<div class="col-sm-3">
					<div class="radio">
						<label><?php echo $form->radioButton($model, 'jeniskelamin', array('id'=>'jk_perempuan', 'value'=>'PEREMPUAN', 'uncheckValue'=>null)); ?>Perempuan</label>
					</div>
					<?php //echo $form->radioButtonList($model,'jeniskelamin',Params::getJenisKelamin(),array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('jeniskelamin'),)); ?>
				</div>
			</div>
			<?php /*
			<div class="form-group">
				<?php echo $form->labelEx($model, 'statusperkawinan', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'statusperkawinan',Params::statusPerkawinan(), array('empty'=>'-- Pilih -- ', 'class'=>'form-control','maxlength'=>20, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('statusperkawinan'),)); ?>
				</div>
			</div>
			*/ ?>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'golonganpegawai_id', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,'golonganpegawai_id',CHtml::listData(GolonganpegawaiM::model()->findAll('golonganpegawai_aktif = true order by golonganpegawai_nama'), 'golonganpegawai_id', 'golonganpegawai_nama'),
					array('empty'=>'-- Pilih --', 'class'=>'form-control', 'onchange'=>'cekSimpananGolongan()')); ?>
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
					<img id="photo_pegawai" src="<?php echo empty($model->photopegawai)?'':Params::urlPegawaiGambar().$model->photopegawai ?>" width="150" height="200">
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
			<?php /*
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
						<label><?php echo $form->radioButton($model, 'rhesus', array('id'=>'rh_plus','value'=>'RH+', 'uncheckValue'=>null)); ?>RH+</label>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="radio">
						<label><?php echo $form->radioButton($model, 'rhesus', array('id'=>'rh_minus','value'=>'RH-', 'uncheckValue'=>null)); ?>RH-</label>
					</div>
				</div>
			</div>
			*/ ?>
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
			<?php /*
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
							'model'=>$model, 'attribute'=>'tglmulaibekerja', 'options'=>array('format'=>'dd/mm/yyyy'), 'htmlOptions'=>array('class'=>'form-control datepicker'),
						));
					?><div class='input-group-addon'>
        					<a href='#'>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
					</div>
				</div>
			</div>
			<div class="form-group">
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
			*/ ?>
		</div>
	</div>
	<?php /*
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
					<?php echo $form->textField($model,'banknorekening',array('class'=>'form-control uc','maxlength'=>100, 'placeholder'=>'Ketikan '.$model->getAttributeLabel('banknorekening'),)); ?>
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
					<?php echo $form->textField($model,'gajipokok',array('class'=>'form-control num', 'data-validate'=>'number', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('gajipokok'),)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model, 'insentifpegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'insentifpegawai',array('class'=>'form-control num', 'data-validate'=>'number', 'placeholder'=>'Ketikan '.$model->getAttributeLabel('insentifpegawai'),)); ?>
				</div>
			</div>
			
		</div>
	</div>
	*/ ?>
</div>
