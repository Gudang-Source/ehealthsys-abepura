<?php
$this->breadcrumbs=array(
	'Rehab Medis',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpasien-rehabMedis-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($modKirimKeUnitLain,'catatandokterpengirim'),
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return requiredCheck(this)'),
)); ?>

<div class="formInputTab">
    <div class="block-tabel">
        <h6>Tabel Riwayat <b>Rehab Medis Pasien</b></h6>
        <?php $this->renderPartial($this->path_view.'_listKirimKeUnitLain',array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain)) ?>
        <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
    </div>
    <div class="box">
        <?php foreach($modJenisTindakanRm as $i=>$jenisPeriksa){ 
                $ceklist = false;
        ?>
                <div class="boxtindakan">
                    <h6><?php echo $jenisPeriksa->jenistindakanrm_nama; ?></h6>
                    <?php foreach ($modTindakanRm as $j => $pemeriksaan) {
                             if($jenisPeriksa->jenistindakanrm_id == $pemeriksaan->jenistindakanrm_id) {
                                 echo CHtml::checkBox("tindakanRM[]", $ceklist, array('value'=>$pemeriksaan->tindakanrm_id,
                                                                                          'onclick' => "inputperiksa(this);"));
                                 echo "<span>".$pemeriksaan->tindakanrm_nama."</span><br/>";
                             }
                         } ?>
                </div>
        <?php } ?>
    </div>
                
    <table width="100%" class="table-condensed">
        <tr>
            <td width="35%">
				<?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
				<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
                <div class="control-group ">
                    
                     <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
                    Tanggal Permintaan
                    <span class="required">*</span>
                    </label>
                    <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modKirimKeUnitLain,
                                                    'attribute'=>'tgl_kirimpasien',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true),
                            )); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($modKirimKeUnitLain,'pegawai_id', CHtml::listData($modKirimKeUnitLain->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'),
                                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modKirimKeUnitLain,'catatandokterpengirim',array('onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
            </td>
            <td width="65%">
                <div class="block-tabel">
                    <h6>Tabel Tindakan Rehab <b>Medis  <?php echo isset($modJenisTarif) ? "- ".$modJenisTarif->jenistarif->jenistarif_nama : "" ; ?></b></h6>
                    <table id="tblFormPermintaanRehab" class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Jenis Tindakan</th>
                                <th>Tindakan</th>
                                <th>Tarif</th>
                                <th>Jumlah<th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    
    
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>
            <?php
            if(isset($_GET['idPasienKirimKeUnitLain'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp"; 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp&nbsp"; 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp"; 
            }
            ?>  
            <?php 
            $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
            $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain'])?$_GET['idPasienKirimKeUnitLain']:null;
            $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id.'&idPasienKirimKeUnitLain='.$idPasienKirimKeUnitLain);
            $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printRiwayat&id='.$modPendaftaran->pendaftaran_id);
            $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);


$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(idPasienKirimKeUnitLain)
{
    window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                         
?>
			
    </div>

</div>
<?php $this->endWidget(); ?>
<?php 
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa Untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"


function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

JS;
Yii::app()->clientScript->registerScript('js',$js,CClientScript::POS_READY);
?>   
<script>
function inputperiksa(obj)
{
    if($(obj).is(':checked')) {
        var tindakanrm_id = obj.value;
        var kelaspelayanan_id = <?php echo $modPendaftaran->kelaspelayanan_id ?>;
        var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id ?>;
        jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('rawatJalan/RehabMedis/loadFormPermintaanRehabMedis')?>',
                 'data':{tindakanrm_id:tindakanrm_id, kelaspelayanan_id:kelaspelayanan_id,pendaftaran_id:pendaftaran_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                        if($.trim(data.form)=='')
                         {
                            $(obj).removeAttr('checked');
                            myAlert ('Pemeriksaan belum memiliki tarif');
                         }else{
                             $('#tblFormPermintaanRehab > tbody').append(data.form);
                             $("#tblFormPermintaanRehab > tbody > tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
                             $('.integer').each(function(){this.value = formatNumber(this.value)});
                         }
                 } ,
                 'cache':false});
    } else {
		batalPeriksa(obj.value);
//        myConfirm("Apakah anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
//            if(r){
//                batalPeriksa(obj.value);
//            }else{
//                $(obj).attr('checked', 'checked');
//            }
//        });
    }
}

function batalPeriksa(idTindakanRm)
{
    $('#tblFormPermintaanRehab #tindakanrm_'+idTindakanRm).detach();
}

function batalKirim(idPasienKirimKeUnitLain,pendaftaran_id)
{
    myConfirm("Apakah anda akan membatalkan kirim pasien ke Rehab Medis?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {idPasienKirimKeUnitLain: idPasienKirimKeUnitLain, pendaftaran_id:pendaftaran_id}, function(data){
                $('#tblListPermintaanRehab').html(data.result);
            }, 'json');
        }
    });
}

$(document).ready(function(){
    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_REHABMEDIS ?>, judulnotifikasi:'Pasien Rujukan', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
});
</script>