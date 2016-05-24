<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<table width="100%" cellpadding="5px">
    <tr>
        <td width="65%">
            <?php 
            $ruangan = RuanganM::model()->findAllByAttributes(array(
                'ruangan_aktif'=>true,
            ), array(
                'order'=>'instalasi_id, ruangan_nama',
            ));
            
            
            $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'pasien-m-grid',
                'dataProvider'=>$modPegawai->searchNoMobile(),
                'filter'=>$modPegawai,
                    'template'=>"{summary}\n{items}{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Ruangan',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $pr = PegawairuanganV::model()->findAllByAttributes(array(
                                'pegawai_id'=>$data->pegawai_id,
                            ));
                            $str = "<ul>";
                            foreach ($pr as $item) {
                                $str .= "<li>".$item->ruangan_nama."</li>";
                            }
                            $str .= "<ul>";
                            return $str;
                        },
                        'filter'=>CHtml::activeDropDownList($modPegawai, 'ruangan_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array(
                            'empty'=>'-- Pilih --',
                        )),
                    ),
                    'nomorindukpegawai',
                    'nama_pegawai',
                    'nomobile_pegawai',
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array("onclick"=>"tambahNoTelp(\"$data->nomobile_pegawai\",\"$data->nama_pegawai\");return false;","rel"=>"tooltip","title"=>"Pilih"))',
                        'filter'=>CHtml::link('<i class="icon-form-check"></i>', "javascript:void(0);", array("onclick"=>"pilihSemuaPegawai(); return false;", "rel"=>"tooltip", "title"=>"Klik untuk memilih semua pegawai")),
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
            ?> 
        </td>
        <td style="vertical-align:top">
            <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
            <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'outbox-form',
                'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                    'focus'=>'#',
            )); ?>

                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

                <?php echo $form->errorSummary($model); ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'destinationnumber', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <div id="penerima"></div>
                                <?php echo $form->error($model, 'destinationnumber'); ?>
                            </div>
                        </div>
                        <?php //echo $form->textFieldRow($model,'destinationnumber',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                        <?php echo $form->textAreaRow($model,'TextDecoded',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model,'CreatorID',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                <div class="form-actions">
                    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                            array('class'=>'btn btn-success', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.$this->id.'/pegawai',array('modul_id'=>Yii::app()->session['modul_id'])), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'));  ?>
                </div>

            <?php $this->endWidget(); ?>
        </td>
    </tr>
</table>

<script type="text/javascript">
function tambahNoTelp(noHp,nama)
{
    var cek = false;
    if(noHp=='') {
        alert (nama+' Belum Memiliki No. Handphone');
    } else {
        $('.destination').each(function(){
            if(this.value == noHp) {
                  myAlert(nama+' Sudah ada dalam daftar yang akan dikirimi pesan');  
                  cek = true;
                  $('.destination').stop();
            }
        });
        
        if (!cek) {
           $('#penerima').append('<div class="input-append"><input type="text" name="noPenerima[]" value="'+noHp+'" class="destination span2" readonly="readonly" style="float:left;" />'+
                                 '<span class="add-on"><a href="javascript:void(0);" class="icon-remove" onclick="hapusNomor(this)"></a></span></div>');  
        }        
    }  
}

function hapusNomor(obj)
{
    if(confirm('Anda Yakin Akan Menghapus No. Tujuan Ini?'))
        $(obj).parent().parent().remove();
    
    return false;
}

function pilihSemuaPegawai()
{
    $("#penerima").empty();
    $.post('<?php $this->createUrl('pegawai'); ?>', {
        is_ajax: true,
        f: "kumpulDataPegawai",
        param: {
            serial: $("#pasien-m-grid :input").serializeArray(),
        }
    }, function(data)
    {
        $.each(data, function(idx, val) {
            tambahNoTelp(val.mobile, val.nama);
        });
    }, "json");
}
</script>