<?php
$this->widget('bootstrap.widgets.BootAlert');

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'returpenjualan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#FAReturresepT_alasanretur',
        'method'=>'post',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'unformatSemuaNumber(); return validasiForm();'),
));
?>
<?php echo $form->errorSummary($modRetur);?>
<fieldset class="box">
    <legend class="rim">Retur Penjualan</legend>
    <table class="table-condensed">
        <tr>
            <td>
                <?php echo $form->textFieldRow($modPenjualanResep,'tglpenjualan',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPenjualanResep,'tglresep',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPenjualanResep,'noresep',array('class'=>'span3','style'=>'width:275px','readonly'=>true)); ?>
                 <?php echo $form->textFieldRow($modPenjualanResep,'pendaftaran_id',array('class'=>'span3','style'=>'width:275px','readonly'=>true)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modPasien,'no_rekam_medik',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPasien,'nama_pasien',array('class'=>'span3','readonly'=>true)); ?>
                <div class="control-group ">
                    <label for="FAInformasipenjualanapotikV_jeniskelamin" class="control-label">Jeniskelamin</label>
                    <div class="controls">
                        <?php //echo $form->textField($infoJualObat[0],'umur',array('class'=>'span2','readonly'=>true)); ?> 
                        <?php echo $form->textField($modPasien,'jeniskelamin',array('class'=>'span2','readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">Cara Bayar/Penjamin</label>
                    <div class="controls">
                        <?php echo CHtml::textField('carabayar_nama',(isset($modPendaftaran->carabayar_id) ? $modPendaftaran->carabayar->carabayar_nama : ''),array('class'=>'span2', 'style'=>'width:80px;','readonly'=>true)); ?>
                        <?php echo CHtml::textField('penjamin_nama',(isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin->penjamin_nama : ''),array('class'=>'span2','readonly'=>true)); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</fieldset>
<table>
    <tr>
        <td>
            <?php echo $form->hiddenField($modRetur,'pasien_id',array('value'=>$modPenjualanResep->pasien_id,'class'=>'span3','readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <div class="control-group ">
                <?php //echo $form->textFieldRow($modRetur,'tglretur',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->labelEx($modRetur,'tglretur', array('class'=>'control-label required')) ?>
                <div class="controls">  
                 <?php $this->widget('MyDateTimePicker',array(
                                     'model'=>$modRetur,
                                     'attribute'=>'tglretur',
                                     'mode'=>'datetime',
                                     'options'=> array(
                                         'maxDate'=>'d',
                                         'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                     'htmlOptions'=>array('readonly'=>true,
                                     'onkeyup'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                </div> 
            </div>
            <?php echo $form->textAreaRow($modRetur,'alasanretur',array('class'=>'span3 required','readonly'=>false, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($modRetur,'noreturresep',array('class'=>'span3','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($modRetur,'keteranganretur',array('class'=>'span3','readonly'=>false, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($modRetur,'pegretur_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id')), array('order'=>'nama_pegawai')), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3 required','readonly'=>false, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($modRetur,'mengetahui_id', CHtml::listData(DokterpegawaiV::model()->findAll(array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --','class'=>'span3','readonly'=>false, 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>
<div id="divTabelRetur">
        <?php echo $form->errorSummary($modReturDetail); ?>
        <?php $this->renderPartial('_tblReturPenjualan',array('infoJualObat'=>$infoJualObat,'modPenjualanResep'=>$modPenjualanResep, 'modObatAlkesPasien'=>$modObatAlkesPasien,'modReturDetail'=>$modReturDetail,'modRetur'=>$modRetur)); ?>
    </div>
<div class="form-actions">
    
            <?php 
            if ($modRetur->isNewRecord){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
            }else{
                echo "<script>setTimeout('print(\"PRINT\");',1000);</script>";
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";                 
            }
            echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset'));
            ?>
			
</div>
<!-- DIKOMEN KARENA MUNCUL GARIS MERAH PADAHAL TDK ADA ERROR -> <div id="errorMessage" class="errorSummary"></div> -->

<?php $this->endWidget(); ?>

<script type="text/javascript">

function cekLogin()
{
    $.post('<?php echo $this->createUrl('CekLogin',array('task'=>'Retur'));?>', $('#formLogin').serialize(), function(data){
        if(data.error != '')
            myAlert(data.error);
        $('#'+data.cssError).addClass('error');
        if(data.status=='success'){
            //myAlert(data.status);
            $('#<?php echo CHtml::activeId($modRetur, 'pegretur_id'); ?>').val(data.userid);
            $('#loginDialog').dialog('close');
            return true;
        }else{
            myAlert(data.status);
        }
    }, 'json');
}

function unformatSemuaNumber(){
    $('#tblReturResepDetail tbody').find('tr').each(
            function(){
                $(this).find('.harga').val(unformatNumber($(this).find('.harga').val()));
                $(this).find('.qty').val(unformatNumber($(this).find('.qty').val()));
                $(this).find('.subtotal').val(unformatNumber($(this).find('.subtotal').val()));
                $(this).find('.total').val(unformatNumber($(this).find('.total').val()));
                $(this).find('.totalAdmin').val(unformatNumber($(this).find('.totalAdmin').val()));
                $(this).find('.totalRetur').val(unformatNumber($(this).find('.totalRetur').val()));
            }
        );
}
function validasiForm(){
    var kosong = "";
    var Req = $('#returpenjualan-form').find('.required[value='+kosong+']');
    var jumReq = Req.length;
    if(jumReq > 0){
        myAlert("Silahkan isi yang bertanda * !");
        return false;
    }else{
        return true;
    }
    
}
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'loginDialog',
    'options'=>array(
        'title'=>'Login',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>400,
        'height'=>190,
        'resizable'=>false,
    ),
));?>
<?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'formLogin')); ?>
    <div class="control-group ">
        <?php echo CHtml::label('Login Pemakai','username', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('username', '', array()); ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo CHtml::label('Password','password', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::passwordField('password', '', array()); ?>
        </div>
    </div>
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Login',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'cekLogin();return false;')); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), '#', array('class'=>'btn btn-danger','onclick'=>"$('#loginDialog').dialog('close');return false",'disabled'=>false)); ?>
    </div> 
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget();?>

<?php
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/informasiPenjualanResep/printStrukRetur&returresep_id='.$modRetur->returresep_id.'&penjualanresep_id='.$modPenjualanResep->penjualanresep_id);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>