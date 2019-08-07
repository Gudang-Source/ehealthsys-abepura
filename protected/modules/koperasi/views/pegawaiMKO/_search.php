<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'form-groups-bordered'),
)); ?>

		<?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('pegawai_id'),)); ?>

		<?php //echo $form->textFieldRow($model,'kelurahan_id',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('kelurahan_id'),)); ?>

		<?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'form-control alphaonlyK','maxlength'=>50, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nama_pegawai'),)); ?>

		<?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'form-control numbersOnly','maxlength'=>50, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nomorindukpegawai'),)); ?>

		<?php echo $form->textFieldRow($model,'no_kartupegawainegerisipil',array('class'=>'form-control numbersOnly','maxlength'=>50, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('no_kartupegawainegerisipil'),)); ?>

		<?php //echo $form->textFieldRow($model,'jenisidentitas',array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('jenisidentitas'),)); ?>

		<?php echo $form->textFieldRow($model,'noidentitas',array('class'=>'form-control numbersOnly','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('noidentitas'),)); ?>

		<?php //echo $form->textFieldRow($model,'gelardepan',array('class'=>'form-control','maxlength'=>10, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('gelardepan'),)); ?>

		
		<?php //echo $form->textFieldRow($model,'nama_keluarga',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nama_keluarga'),)); ?>

		<?php //echo $form->textFieldRow($model,'gelarbelakang',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('gelarbelakang'),)); ?>

		<?php //echo $form->textFieldRow($model,'tempatlahir_pegawai',array('class'=>'form-control','maxlength'=>30, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('tempatlahir_pegawai'),)); ?>

		<?php //echo $form->datepickerRow($model,'tgl_lahirpegawai',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

		<?php //echo $form->textFieldRow($model,'jeniskelamin',array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('jeniskelamin'),)); ?>
		<?php echo $form->dropDownListRow($model,'jeniskelamin',Params::getJenisKelamin(),array('class'=>'form-control', 'empty'=>'-- Pilih --')); ?>

		<?php //echo $form->textFieldRow($model,'statusperkawinan',array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('statusperkawinan'),)); ?>

		<?php echo $form->textAreaRow($model,'alamat_pegawai',array('rows'=>6, 'cols'=>50, 'class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('alamat_pegawai'),)); ?>
		<div class="form-group">
            <?php echo $form->labelEx($model, 'Unit',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'unit_id', CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true','order'=>'namaunit')), 'unit_id', 'namaunit'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
		<div class="form-group">
            <?php echo $form->labelEx($model, 'Golongan',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true','order'=>'golonganpegawai_nama')), 'golonganpegawai_id', 'golonganpegawai_nama'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
      
      <div class="form-group">
            <?php echo $form->labelEx($model, 'pangkat_id',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'pangkat_id', CHtml::listData(PangkatM::model()->findAll(array('condition'=>'pangkat_aktif = true')), 'pangkat_id', 'pangkat_nama'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
      
		<div class="form-group">
            <?php echo $form->labelEx($model, 'jabatan_id',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(array('condition'=>'jabatan_aktif = true')), 'jabatan_id', 'jabatan_nama'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
      
     	<div class="form-group">
            <?php echo $form->labelEx($model, 'kategoripegawai',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'kategoripegawai', Params::kategoriPegawai(), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
      
      <div class="form-group">
            <?php echo $form->labelEx($model, 'Status Anggota',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-5">
                <?php echo $form->dropDownList($model, 'isanggota', array(true=>'Anggota',false=>'Non Anggota'), array("class"=>"form-control", "empty" => "-- Pilih --")); ?>
            </div>
      </div>
		<?php //echo $form->textFieldRow($model,'golonganpegawai_id',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('golonganpegawai_id'),)); ?>
		
		<?php //echo $form->textFieldRow($model,'pangkat_id',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('pangkat_id'),)); ?>

		<?php //echo $form->textFieldRow($model,'jabatan_id',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('jabatan_id'),)); ?>

		<?php //echo $form->textFieldRow($model,'agama',array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('agama'),)); ?>

		<?php //echo $form->textFieldRow($model,'golongandarah',array('class'=>'form-control','maxlength'=>2, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('golongandarah'),)); ?>

		<?php //echo $form->textFieldRow($model,'rhesus',array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('rhesus'),)); ?>

		<?php //echo $form->textFieldRow($model,'alamatemail',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('alamatemail'),)); ?>

		<?php //echo $form->textFieldRow($model,'notelp_pegawai',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('notelp_pegawai'),)); ?>

		<?php //echo $form->textFieldRow($model,'nomobile_pegawai',array('class'=>'form-control','maxlength'=>50, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('nomobile_pegawai'),)); ?>

		<?php //echo $form->textFieldRow($model,'warganegara_pegawai',array('class'=>'form-control','maxlength'=>25, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('warganegara_pegawai'),)); ?>

		<?php //echo $form->textFieldRow($model,'jeniswaktukerja',array('class'=>'form-control','maxlength'=>20, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('jeniswaktukerja'),)); ?>

		<?php //echo $form->textFieldRow($model,'kategoripegawai',array('class'=>'form-control','maxlength'=>10, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('kategoripegawai'),)); ?>

		<?php //echo $form->textFieldRow($model,'photopegawai',array('class'=>'form-control','maxlength'=>200, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('photopegawai'),)); ?>

		<?php //echo $form->textFieldRow($model,'norekening',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('norekening'),)); ?>

		<?php //echo $form->textFieldRow($model,'banknorekening',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('banknorekening'),)); ?>

		<?php //echo $form->textFieldRow($model,'npwp',array('class'=>'form-control','maxlength'=>25, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('npwp'),)); ?>

		<?php //echo $form->datepickerRow($model,'tglmulaibekerja',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

		<?php //echo $form->datepickerRow($model,'tglberhenti',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

		<?php //echo $form->textFieldRow($model,'gajipokok',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('gajipokok'),)); ?>

		<?php //echo $form->textFieldRow($model,'insentifpegawai',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('insentifpegawai'),)); ?>

		<?php //echo $form->datepickerRow($model,'peg_create_time',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

		<?php //echo $form->datepickerRow($model,'peg_update_time',array('options'=>array(),'htmlOptions'=>array('class'=>'form-control')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

		<?php //echo $form->textFieldRow($model,'peg_create_login',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('peg_create_login'),)); ?>

		<?php //echo $form->textFieldRow($model,'peg_update_login',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('peg_update_login'),)); ?>

		<?php //echo $form->checkBoxRow($model,'pegawai_aktif',array('class'=>'form-control')); ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-5">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Cari',
			'htmlOptions'=>array('class'=>'btn-primary'),
		)); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
