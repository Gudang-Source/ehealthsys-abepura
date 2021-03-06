<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        'htmlOptions'=>array(),

)); ?>
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        <?php //echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip' ,'onClick'=>'cekTanggal()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                        Tanggal Masuk 
                    </label>
                    <div class="controls">
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                        <?php   $format = new MyFormatter;
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_awal',
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
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                              <?php   $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); ?>
                    </div>
                </div>
                
            </td>
            <td>
                 <div class="control-group">
                        <?php echo CHtml::label('No. Pendaftaran','no_pendaftaran', array('class'=>'control-label')) ?>                        
                            <div class="controls">
                                
                                <?php 
                                       
                                        $prefix = array(
                                            0 => Params::PREFIX_RAWAT_DARURAT,
                                            1 => Params::PREFIX_RAWAT_INAP,
                                            2 => Params::PREFIX_RAWAT_JALAN
                                        );

                                    echo $form->dropDownList($model,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                                ?>
                                <?php echo $form->textField($model, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>                                                                
                            </div>                        
                    </div>
                <?php //echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3 angkahuruf-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                
                <?php // echo $form->textFieldRow($model,'nama_bin',array('placeholder'=>'Ketik Alias / Nama Panggilan','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'caramasuk_id', CHtml::listData($model->getCaraMasukItems(), 'caramasuk_id', 'caramasuk_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                 <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'ajax' => array('type'=>'POST',
                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'RDPendaftaran')), 
                                                    'update'=>'#'.CHtml::activeId($model,'penjamin_id').''  //selector to update
                                                ),
                        )); ?>

                 <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Dokter Penanggung Jawab
                      </label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'nama_pegawai', CHtml::listData(DokterV::model()->findAll(), 'nama_pegawai', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model,'kamarruangan_id',  CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
                    'kamarruangan_aktif'=>true,
                    'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                ), array(
                    'order'=>'kamarruangan_nokamar',
                )), 'kamarruangan_id', 'kamarDanTempatTidurPolos'),array('empty'=>'-- Pilih --','placeholder'=>'Ketik Nama Pasien','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            </td>
        </tr>
    </table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');


?>&nbsp;
<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
&nbsp;
<?php 
           $content = $this->renderPartial('../tips/informasi',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
<?php $this->endWidget();?>
</fieldset>  
<script>
// document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
// document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#RIInfopasienmasukkamarV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('RIInfopasienmasukkamarV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('RIInfopasienmasukkamarV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}
</script>