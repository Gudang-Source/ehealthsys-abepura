<div class="white-container">
    <legend class="rim2">Informasi <b>Kamar</legend>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian Kamar</legend>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'informasiKamar-t-form',
            'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                'focus'=>'#',
        )); ?>
        <table width="100%">
            <tr>
                <td width="30%">
                     <?php echo $form->dropDownListRow($modKamarRuangan,'kelaspelayanan_id',  CHtml::listData($modKamarRuangan->KelasPelayananRuanganItems, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',
                                                        'ajax'=>array('type'=>'POST',
                                                                  'url'=>$this->createUrl('GetRuanganNoKamarRuangan',array('encode'=>false,'namaModel'=>'RIKamarRuanganM')),
                                                                  'update'=>'#RIKamarRuanganM_kamarruangan_nokamar',),
                                                    )); ?>
                    <?php echo $form->dropDownListRow($modKamarRuangan,'kamarruangan_nokamar', array(),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>


                </td>
                <td width="25%">
                    <fieldset class="box2">
                        <legend class="rim">Foto Ruangan <?php echo $modRuangan->ruangan_nama;?></legend>
                          <img src="<?php echo Params::urlRuanganTumbsDirectory().'kecil_'.$modRuangan->ruangan_image ?>" />
                    </fieldset>
                </td>
                <td>
                    <fieldset class="box2">
                        <legend class="rim">Fasilitas</legend>
                        <?php echo $modRuangan->ruangan_fasilitas ?>
                    </fieldset>
                </td> 
            </tr>
        </table>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                               array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        <?php
        $content = $this->renderPartial('../tips/informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
        <?php echo $formKasur ?>
        <?php $this->endWidget(); ?>
    </fieldset>
</div>
<?php
$idKelasPelayanan=  CHtml::activeId($modKamarRuangan,'kelaspelayanan_id');
$idNoKamar=  CHtml::activeId($modKamarRuangan,'kamarruangan_nokamar');
$jscript = <<< JS
function cekValidasi()
{
    idKelas=$('#${idKelasPelayanan}').val();
    idKamar=$('#${idNoKamar}').val();
    
    if(idKelas==''){
        myAlert('Anda Belum Memilih Kelas Pelayanan');
    }else if(idKamar==''){
        myAlert('Anda Belum Memilih Kamar');
    }else{
        $('#btn_simpan').click();
    }
}
JS;
Yii::app()->clientScript->registerScript('faktur',$jscript, CClientScript::POS_HEAD);
?>

