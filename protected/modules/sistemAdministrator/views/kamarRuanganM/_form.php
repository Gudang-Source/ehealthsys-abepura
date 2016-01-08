

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakamar-ruangan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SAKamarRuanganM_kelaspelayanan_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

            <?php echo $form->errorSummary($model); ?>
        <table class="table">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model,'kelaspelayanan_id',  CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'empty'=>'-- Pilih Kelas Pelayanan --')); ?>
                    <?php echo $form->dropDownListRow($model,'ruangan_id',  CHtml::listData($model->RuanganItems, 'ruangan_id', 'ruangan_nama'),
                                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'empty'=>'-- Pilih Ruangan --')); ?>
                    <div class="control-group"> 
                        <div class="control-label">
                            <?php echo $form->labelEx($model, 'keterangan_kamar');?>
                        </div>
                        <div class="controls">
                        <?php echo $form->dropDownList($model,'keterangan_kamar',  CHtml::listData($model->KeteranganKamarItems, 'lookup_value', 'lookup_name'),
                                array('empty'=>'-- Pilih Keterangan Kamar --',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                    )); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model,'kamarruangan_nokamar',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                    <?php echo $form->textFieldRow($model,'kamarruangan_jmlbed',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'onkeyup'=>'noBed(this)')); ?>                 
                    <?php echo CHtml::hiddenField('jumlahBedSebelumnya'); ?>

                    
                </td>
                <td>
                    <div class="control-group">
                      <?php echo $form->labelEx($model,'kamarruangan_image', array('class'=>'control-label','onkeypress'=>"return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
                          <div class="controls">  
                            <?php echo Chtml::activeFileField($model,'kamarruangan_image',array('hint'=>'Isi Jika Akan Menambahkan Logo')); ?>
                          </div>
                    </div>
                    <?php echo $form->labelEx($modRiwayatRuanganR,'tglpenetapanruangan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modRiwayatRuanganR,
                                                'attribute'=>'tglpenetapanruangan',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                    'yearRange'=> "-60:+0",
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php echo $form->error($modRiwayatRuanganR, 'tglpenetapanruangan'); ?>
                    </div>
                        <?php echo $form->textFieldRow($modRiwayatRuanganR,'nopenetapanruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php echo $form->textAreaRow($modRiwayatRuanganR,'tentangpenetapan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
            </tr>
        </table>
        <div>
                    <table id="tbl-kamar" class="table table-striped table-bordered table-condensed">
                        <tr>
                            <td>    
                                <div class="control-group">
                                    <?php echo $form->labelEx($model,'kamarruangan_nobed', array('class'=>'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model,'kamarruangan_nobed[]',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                    </div>
                                </div>
                                
                            </td>
                            <td></td>
                        </tr>
                    </table>
        </div>
        
               
            
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/kamarRuanganM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	<?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kamar Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT

function noBed(obj)
{
    var jmlSekarang = obj.value;
    var jmlSebelumnya = $('#jumlahBedSebelumnya').val();
    var JumlahRowSekarang =$('#tbl-kamar tr').length;
   
   if(jmlSekarang!='')
    {
       if(jmlSekarang<jmlSebelumnya)
          {
            myAlert('Harap Gunakan Tombol Hapus Untuk Menghapus');
            $('#SAKamarRuanganM_kamarruangan_jmlbed').val(jmlSebelumnya);
          }
       else
          {
            $('#jumlahBedSebelumnya').val(obj.value);
            for(i=1; i<=jmlSekarang-JumlahRowSekarang; i++)
               {
                    var tr = $('#tbl-kamar tr:first').html();
                    $('#tbl-kamar tr:last').after('<tr>'+tr+'</tr>');
                    $('#tbl-kamar tr:last td:last').append('$buttonMinus');
               }
          }
      }
    
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else 
    {
        $(obj).parent().parent().remove();
        var jmlBedSebelumnya=$('#SAKamarRuanganM_kamarruangan_jmlbed').val();
        jmlBedSekarang=jmlBedSebelumnya-1;
        $('#SAKamarRuanganM_kamarruangan_jmlbed').val(jmlBedSekarang);
        $('#jumlahBedSebelumnya').val(jmlBedSekarang);

    }
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>