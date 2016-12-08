<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasienPulang-form',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($modPasienYangPulang,'no_pendaftaran'),
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

)); ?>
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        <?php $modPasienYangPulang->tgl_awal = MyFormatter::formatDateTimeForUser($modPasienYangPulang->tgl_awal); ?>
                        <?php $modPasienYangPulang->ceklis = false; ?>
                        <?php echo CHtml::activecheckBox($modPasienYangPulang, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
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
                        )); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                            <?php $modPasienYangPulang->tgl_akhir = MyFormatter::formatDateTimeForUser($modPasienYangPulang->tgl_akhir); ?>
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
                <?php //echo $form->textFieldRow($modPasienYangPulang,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
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

                                    echo $form->dropDownList($modPasienYangPulang,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
                                ?>
                                <?php echo $form->textField($modPasienYangPulang, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>                                                                
                            </div>                        
                    </div>
                <?php echo $form->textFieldRow($modPasienYangPulang,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>6)); ?>
                <?php echo $form->textFieldRow($modPasienYangPulang,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <?php //echo $form->textFieldRow($modPasienYangPulang,'nama_bin',array('placeholder'=>'Ketik Alias / Nama Panggilan','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                
            </td>
            <td>
                <?php //echo $form->textFieldRow($modPasienYangPulang,'keterangan_kamar',array('placeholder'=>'Ketik Status Kamar','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?> 
                <?php echo $form->dropDownListRow($modPasienYangPulang,'carabayar_id', CHtml::listData($modPasienYangPulang->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                       'ajax' => array('type'=>'POST',
                                                               'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($modPasienYangPulang))), 
                                                               'success'=>'function(data){$("#'.CHtml::activeId($modPasienYangPulang, "penjamin_id").'").html(data); }',
                                                       ),
                                                       'class'=>'span3',
                               )); ?>

                <?php echo $form->dropDownListRow($modPasienYangPulang,'penjamin_id', CHtml::listData($modPasienYangPulang->getPenjaminItems($modPasienYangPulang->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            </td>
        </tr>
    </table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');

?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>													
			<?php 
           $content = $this->renderPartial('../tips/informasiPasienPulang',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
<?php $this->endWidget();?>
</fieldset>  
<script>
document.getElementById('RIPasienygPulangriV_tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('RIPasienygPulangriV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#RIPasienygPulangriV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('RIPasienygPulangriV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('RIPasienygPulangriV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('RIPasienygPulangriV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('RIPasienygPulangriV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}
</script>