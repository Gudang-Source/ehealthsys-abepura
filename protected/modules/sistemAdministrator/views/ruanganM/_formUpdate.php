<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saruangan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SARuanganM_instalasi_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model,$modRiwayatRuangan); ?>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model,'instalasi_id',  CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($model,'ruangan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'ruangan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'ruangan_singkatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php echo $form->textFieldRow($model,'ruangan_lokasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
					<?php echo $form->textFieldRow($model,'kode_bpjs',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    
                    <?php echo $form->dropDownListRow($model,'modul_id',  CHtml::listData(ModulK::model()->findAll(array(
                        'condition'=>'modul_aktif = true',
                        'order'=>'modul_nama'
                    )), 'modul_id', 'modul_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <div>
                        <?php echo $form->checkBoxRow($model,'ruangan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php  echo $form->labelEx($model,'Jenis Kasus Penyakit',array('class'=>'control-label required'));  ?>
                        <div class="controls">

                            <?php 
                                   $arrJenisKasusPenyakit = array();
                                    foreach($modKasusPenyakitRuangan as $jenisKasusPenyakit){
                                       $arrJenisKasusPenyakit[] = $jenisKasusPenyakit['jeniskasuspenyakit_id'];
                                   } 
                                  $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                array('sortable'=>true, 'searchable'=>true)
                                           );
                                   echo CHtml::dropDownList(
                                   'jeniskasuspenyakit_id[]',
                                   $arrJenisKasusPenyakit,
                                   CHtml::listData(SAJenisKasusPenyakitM::model()->findAll(array('order'=>'jeniskasuspenyakit_nama')), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'),
                                   array('multiple'=>'multiple','key'=>'jeniskasuspenyakit_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                           );
                            ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php  echo $form->labelEx($model,'Kelas Pelayanan',array('class'=>'control-label required'));  ?>
                        <div class="controls">

                            <?php 
                                   $arrKelasRuangan = array();
                                    foreach($modKelasRuangan as $jenisKelasRuangan){
                                       $arrKelasRuangan[] = $jenisKelasRuangan['kelaspelayanan_id'];
                                   } 
                                  $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                array('sortable'=>true, 'searchable'=>true)
                                           );
                                   echo CHtml::dropDownList(
                                   'kelaspelayanan_id[]',
                                   $arrKelasRuangan,
                                   CHtml::listData(SAKelasPelayananM::model()->findAll(array('order'=>'kelaspelayanan_nama')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                                   array('multiple'=>'multiple','key'=>'kelaspelayanan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                           );
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php  echo $form->labelEx($model,'Daftar Tindakan',array('class'=>'control-label required'));  ?>
                        <div class="controls">
                            <?php 

                                   $arrTindakanRuangan = array();
                                    foreach($modTindakanRuangan as $dataTindakanRuangan){
                                       $arrTindakanRuangan[] = $dataTindakanRuangan['daftartindakan_id'];
                                   } 
                                  $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                array('sortable'=>true, 'searchable'=>true)
                                           );
                                   echo CHtml::dropDownList(
                                   'daftartindakan_id[]',
                                   $arrTindakanRuangan,
                                   CHtml::listData(SADaftarTindakanM::model()->findAll(array('order'=>'daftartindakan_nama')), 'daftartindakan_id', 'daftartindakan_nama'),
                                   array('multiple'=>'multiple','key'=>'daftartindakan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                           );
                             ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php  echo $form->labelEx($model,'Pegawai',array('class'=>'control-label required'));  ?>
                        <div class="controls">
                            <?php 

                                   $arrRuanganPegawai = array();
                                    foreach($modRuanganPegawai as $dataRuanganPegawai){
                                       $arrRuanganPegawai[] = $dataRuanganPegawai['pegawai_id'];
                                   } 
                                  $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                array('sortable'=>true, 'searchable'=>true)
                                           );
                                   echo CHtml::dropDownList(
                                   'pegawai_id[]',
                                   $arrRuanganPegawai,
                                   CHtml::listData(SAPegawaiM::model()->findAll(array('order'=>'nama_pegawai')), 'pegawai_id', 'nama_pegawai'),
                                   array('multiple'=>'multiple','key'=>'pegawai_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                           );
                             ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modRiwayatRuangan,'tglpenetapanruangan',array('class'=>'inputRequire','style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,)); ?>
                    <?php //echo $form->textField($modRiwayatRuangan,'nopenetapanruangan',array('class'=>'inputRequire','style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$modRiwayatRuangan->getAttributeLabel('nopenetapanruangan'))); ?>
                    <?php //echo $form->textField($modRiwayatRuangan,'tentangpenetapan',array('class'=>'inputRequire','style'=>'width: 124px;','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50,'placeholder'=>$modRiwayatRuangan->getAttributeLabel('tentangpenetapan'))); ?>
                </td>
            </tr>
        </table>                    
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
             <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '', 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
			<?php
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SARuanganM_1_ruangan_namalainnya').value = nama.value.toUpperCase();
    }
</script>