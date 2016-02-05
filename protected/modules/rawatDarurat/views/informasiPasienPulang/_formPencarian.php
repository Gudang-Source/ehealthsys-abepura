<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasienPulang-form',
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
         'focus'=>'#'.CHtml::activeId($modPasienYangPulang,'no_pendaftaran'),

)); ?>
<fieldset class="box">
    <legend class="rim">Pencarian</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        <?php //echo CHtml::activecheckBox($modPasienYangPulang, 'ceklis',array('onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                        Tanggal Pulang 
                    </label>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPasienYangPulang,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); ?> </div></div>
						<div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                            <?php    $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPasienYangPulang,
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
                 
                 <?php echo $form->dropDownListRow($modPasienYangPulang,'carabayar_id', CHtml::listData($modPasienYangPulang->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'ajax' => array('type'=>'POST',
                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'RDPendaftaran')), 
                                                    'update'=>'#'.CHtml::activeId($modPasienYangPulang,'penjamin_id').''  //selector to update
                                                ),
                        )); ?>

                 <?php echo $form->dropDownListRow($modPasienYangPulang,'penjamin_id', CHtml::listData($modPasienYangPulang->getPenjaminItems($modPasienYangPulang->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                <?php echo $form->dropDownListRow($modPasienYangPulang, 'pegawai_id', 
                        CHtml::listData(DokterV::model()->findAllByAttributes(array(
                            'instalasi_id'=>Params::INSTALASI_ID_RD,
                        ), array(
                            'order'=>'nama_pegawai asc'
                        )), 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --')); ?>
            </td>
            <td>
                 <?php echo $form->textFieldRow($modPasienYangPulang,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik no.pendaftaran')); ?>
                 <?php echo $form->textFieldRow($modPasienYangPulang,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik nama pasien')); ?>
                 <?php echo $form->textFieldRow($modPasienYangPulang,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik nama bin')); ?>
                 <?php echo $form->textFieldRow($modPasienYangPulang,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik no.rekam medik')); ?>
                 <?php //echo $form->textFieldRow($modPasienYangPulang,'keterangan_kamar',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'Ketik keterangan kamar.')); ?>
                 
            </td>
        </tr>
    </table>
<?php 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); 

//	echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
//                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan',
//                                                    'ajax' => array(
//                                                     'type' => 'GET', 
//                                                     'url' => array("/".$this->route), 
//                                                     'update' => '#daftarPasienPulang-grid',
//                                                     'beforeSend' => 'function(){
//                                                                          $("#daftarPasienPulang-grid").addClass("animation-loading");
//                                                                      }',
//                                                     'complete' => 'function(){
//                                                                          $("#daftarPasienPulang-grid").removeClass("animation-loading");
//                                                                      }',
//                                                 ))); 
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');

?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
			<?php 
           $content = $this->renderPartial('../tips/informasi',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
<?php $this->endWidget();?>
</fieldset>  
<script>
document.getElementById('RDPasienpulangrddanriV_tgl_awal_date').setAttribute("style","display:block;");
document.getElementById('RDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style","display:block;");
function cekTanggal(){

    var checklist = $('#RDPasienpulangrddanriV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('RDPasienpulangrddanriV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('RDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('RDPasienpulangrddanriV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('RDPasienpulangrddanriV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}
</script>