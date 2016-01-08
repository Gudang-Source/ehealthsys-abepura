<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<table width="100%" cellpadding="5px">
    <tr>
        <td width="65%">
            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'pasien-m-grid',
                'dataProvider'=>$modPasien->search(),
                'filter'=>$modPasien,
                    'template'=>"{summary}\n{items}{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    'no_rekam_medik',
                    'nama_pasien',
                    'nama_bin',
                    'no_mobile_pasien',
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'CHtml::link("<i class=\"icon-form-check\"></i>", "javascript:void(0);", array("onclick"=>"tambahNoTelp(\"$data->no_mobile_pasien\",\"$data->nama_pasien\");return false;","rel"=>"tooltip","title"=>"Pilih"))',
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); 
            ?> 
        </td>
        <td style="vertical-align:top;">
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
                            Yii::app()->createUrl($this->module->id.'/'.$this->id.'/pasien',array('modul_id'=>Yii::app()->session['modul_id'])), 
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
                  alert (nama+' Sudah ada dalam daftar yang akan dikirimi pesan');  
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
</script>