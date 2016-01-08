<div class="white-container">
    <legend class="rim2">Transaksi Batal <b>Pengeluaran Umum</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Batal Keluar Umum',
    );?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'batalbayarsupplier-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                                 // 'onsubmit'=>'return cekOtorisasi();'
                                    'onsubmit'=>'return requiredCheck(this);'
                ),
            'focus'=>'#'.CHtml::activeId($modPengeluaran,'nopengeluaran'),
    )); ?>

    <?php $this->renderPartial($this->path_view.'_infoPengeluaran',array('form'=>$form,'modPengeluaran'=>$modPengeluaran)); ?>

    <?php //echo $form->errorSummary(array($modBatalBayar)); ?>

    <fieldset class="box">
       <legend class="rim">Pembatalan</legend>
        <table width="100%">
            <tr>
                <td width="50%">
                    <div class="control-group ">
                        <?php $modBatalBayar->tglbatalkeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBatalBayar->tglbatalkeluar, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                        <?php echo $form->labelEx($modBatalBayar,'tglbatalkeluar', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                'model'=>$modBatalBayar,
                                                'attribute'=>'tglbatalkeluar',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                            )); ?>

                        </div>
                    </div>
                                    </td>
                                    <td>
                    <?php echo $form->textAreaRow($modBatalBayar,'alasanbatalkeluar',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo CHtml::activeHiddenField($modBatalBayar,'user_id_otorisasi',array('class'=>'span3','readonly'=>true)); ?>
                    <?php echo CHtml::activeHiddenField($modBatalBayar,'user_name_otoritasi',array('class'=>'span3','readonly'=>true)); ?>
                    <?php echo CHtml::activeHiddenField($modBatalBayar,'tandabuktikeluar_id',array('class'=>'span3','readonly'=>true)); ?>
                    <?php echo CHtml::activeHiddenField($modBatalBayar,'pengeluaranumum_id',array('class'=>'span3','readonly'=>true)); ?>
                </td>
            </tr>
        </table>
    </fieldset>

    <div class="form-actions">
        <?php 
        if($modBatalBayar->isNewRecord){
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
            echo "&nbsp;";
        }else{
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>true)); 
            echo "&nbsp;";
        }
            // TIDAK ADA FUNGSINYA >>> echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 


            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('index'), array('disabled'=>false,'class'=>'btn btn-danger'));
            echo "&nbsp;";

        $content = $this->renderPartial($this->path_view.'tips',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
$('.currency').each(function(){this.value = formatNumber(this.value)});

function cekLogin()
{
    $.post('<?php echo $this->createUrl('CekLogin',array('task'=>'Retur'));?>', $('#formLogin').serialize(), function(data){
        if(data.error != '')
            myAlert(data.error);
        $('#'+data.cssError).addClass('error');
        if(data.status=='success'){
            $('#BKBatalKeluarUmumT_user_name_otoritasi').val(data.username);
            $('#BKBatalKeluarUmumT_user_id_otorisasi').val(data.userid);
            $('#loginDialog').dialog('close');
        }else{
            myAlert(data.status);
        }
    }, 'json');
}

function cekOtorisasi()
{
    if($('#BKBatalKeluarUmumT_user_name_otoritasi').val() == '' || $('#BKBatalKeluarUmumT_user_id_otorisasi').val() == ''){
        $('#loginDialog').dialog('open');
        return false;
    } 
    
    $('.currency').each(function(){this.value = unformatNumber(this.value)});
    return true;
}

$(document).ready(function(){
    <?php 
        if(isset($modBatalBayar->batalkeluarumum_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_KEUANGAN ?>, judulnotifikasi:'Pembatalan Pengeluaran Umum ', isinotifikasi:'Telah dilakukan pembatalan pengeluaran umum dengan <?php echo $modPengeluaran->nopengeluaran ?> pada <?php echo $modBatalBayar->tglbatalkeluar ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
})
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
