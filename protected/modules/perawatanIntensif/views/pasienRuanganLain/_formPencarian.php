<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'daftarPasien-form',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

)); ?>
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'onClick'=>'cekTanggal()','rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                        Tgl. Masuk 
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
                        )); ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
					<?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <?php //echo $form->dropDownListRow($model,'caramasuk_id', CHtml::listData($model->getCaraMasukItems(), 'caramasuk_id', 'caramasuk_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                 
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <?php echo $form->textFieldRow($model,'nama_bin',array('placeholder'=>'Ketik Nama Panggilan Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                               'ajax' => array('type'=>'POST',
                                                   'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'RDPendaftaran')), 
                                                   'update'=>'#'.CHtml::activeId($model,'penjamin_id').''  //selector to update
                                               ),
                       )); ?>

                <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                <?php echo $form->dropDownListRow($model,'ruanganasal_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama') ,
                                 array('empty'=>'-- Pilih --',
                                       'onkeypress'=>"return $(this).focusNextInputField(event)",
                                       'class'=>'span2')); ?>
            </td>
        </tr>
    </table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
echo CHtml::hiddenField('pendaftaran_id');
echo CHtml::hiddenField('pasien_id');

?>
&nbsp;
<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>&nbsp;
<?php 
           $content = $this->renderPartial('../tips/informasi',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
<?php $this->endWidget();?>
</fieldset>  
<script>
document.getElementById('RIPasienridariruanganlainV_tgl_awal_date').setAttribute("style","display:none;");
document.getElementById('RIPasienridariruanganlainV_tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#RIPasienridariruanganlainV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('RIPasienridariruanganlainV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('RIPasienridariruanganlainV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('RIPasienridariruanganlainV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('RIPasienridariruanganlainV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}
</script>