<?php
$this->breadcrumbs=array(
	'Bedah Sentral',
);

$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">BEDAH SENTRAL</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjbedahsentral-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($modKirimKeUnitLain,'catatandokterpengirim'),
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<!--<legend class="rim">Tabel Riwayat Bedah Sentral Pasien</legend>-->
<?php $this->renderPartial('_listKirimKeUnitLain',array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain)) ?>

<div class="formInputTab">
    <?php echo $form->errorSummary($modKirimKeUnitLain, $modPasienMasukPenunjang); ?>
    <div class="box">
        <?php echo $this->renderPartial('_formOperasi', array('modKegiatanOperasi'=>$modKegiatanOperasi,'modOperasi'=>$modOperasi)); ?>
    </div>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<table width="100%" class="table-condensed">
    <tr>
        <td width="35%">
			<?php  echo CHtml::hiddenField('deposit',$modDeposit,array('onclick'=>'cekInput()')); ?>	
            <div class="control-group ">
                <?php echo $form->labelEx($modKirimKeUnitLain,'tgl_kirimpasien', array('class'=>'control-label')) ?>
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
            <?php echo $form->dropDownListRow($modKirimKeUnitLain,'pegawai_id', CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                                            array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textAreaRow($modKirimKeUnitLain,'catatandokterpengirim',array('onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
        </td>
        <td>
            <div class="block-tabel">
                <h6>Tabel Tindakan <b>Rencana Operasi  <?php echo isset($modJenisTarif) ? "- ".$modJenisTarif->jenistarif->jenistarif_nama : "" ; ?></b></h6>
                <?php echo $this->renderPartial('_formRencanaOperasi', 
                                                array('modPendaftaran'=>$modPendaftaran,'modJenisTarif'=>$modJenisTarif)); ?>
            </div>
        </td>
    </tr>
</table>

    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'id'=>'btn_submit', 'onKeypress'=>'cekInput()', 'onclick'=>'cekInput()')); ?>
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
            $content = $this->renderPartial('../tips/tips',array(),true);
            $this->widget('UserTips',array('type'=>'admin','content'=>$content)); ?>
    </div>

</div>
<?php $this->endWidget(); ?>
<?php
            $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain'])?$_GET['idPasienKirimKeUnitLain']:null;
            $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id.'&idPasienKirimKeUnitLain='.$idPasienKirimKeUnitLain);
            $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printRiwayat&id='.$modPendaftaran->pendaftaran_id);


$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                     
?>

<script type="text/javascript">
function batalKirim(idPasienKirimKeUnitLain,pendaftaran_id)
{
    myConfirm("Apakah anda akan membatalkan kirim pasien ke Bedah Sentral?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {idPasienKirimKeUnitLain: idPasienKirimKeUnitLain, pendaftaran_id:pendaftaran_id}, function(data){
                $('#tblListRencanaOperasi').html(data.result);
            }, 'json');
        }
    });
}

function hitungTotal(){
    var total = 0;
    $('.tarif_satuan').each(
        function(){
            qty = $(this).parents('tr').find('.qty').val();
            total += unformatNumber(this.value) * qty;
        }
    );
 
    $('#totalTarif').val(formatNumber(total));    
}

function hitungTotalTarif()
{
    var totalTarif = 0;
    $('#tbl_tarifkonsulgizi > tbody > tr').each(function(){
        totalTarif += unformatNumber($(this).find('label[name*="[harga_tariftindakan]"]').val());
    });
    $('#totalTarif').val(formatNumber(totalTarif));
}

function cekInput(){
	var deposit = $('#deposit').val();
	var totalTarif = unformatNumber($('#totalTarif').val());
	if (deposit == ""){
		myConfirm("Pasien Belum Melakukan Deposit!","Perhatian!",function(r) {
		   if(r){	
			   // notifikasi
			   var totalTarif =  $('#totalTarif').val();
			   var params = [];
			   params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik; echo "-"; echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp. <?php echo isset($modDeposit)? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp. ' + totalTarif + '. Silahkan hubungi kasir'};
			   insert_notifikasi(params);
			   disableOnSubmit('#btn_submit');
			   setTimeout(function(){
			   $('#rjbedahsentral-t-form').submit();
			   }, 2000);
		   }
	   });
	}else if (deposit < totalTarif){
			 myConfirm("Uang deposit tidak mencukupi, Silahkan hubungi kasir!","Perhatian!",function(r) {
				if(r){	
					// notifikasi
					var totalTarif =  $('#totalTarif').val();
					var params = [];
					params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik; echo "-"; echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp. <?php echo isset($modDeposit)? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp. ' + totalTarif + '. Silahkan hubungi kasir'};
					insert_notifikasi(params);
					disableOnSubmit('#btn_submit');
					setTimeout(function(){
					$('#rjbedahsentral-t-form').submit();
					}, 2000);
				}
			});
	}else{
		$('#rjbedahsentral-t-form').submit();
	}
}

$(document).ready(function(){
    <?php 
        if(isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_BEDAHSENTRAL ?>, judulnotifikasi:'Pasien Rujukan', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
})
</script>