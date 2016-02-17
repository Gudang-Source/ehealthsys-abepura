<?php
$this->breadcrumbs=array(
	'Konsul Gizi',
);
$this->widget('bootstrap.widgets.BootAlert');

?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpasien-konsulGizi-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($modKirimKeUnitLain,'catatandokterpengirim'),
)); ?>
<div class="block-tabel">
    <h6>Tabel Pelayanan <b>Konsultasi Gizi</b></h6>
    <div id="tblGizi">
        <table width="100%">
            <tr>
                <td width="50%">        
                        <table id="tblFormPermintaanGizi" class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Pelayanan</th>
                                </tr>
                            </thead>
                            <tbody id="bodyTblFormPermintaanGizi"></tbody>
                        </table> 
                </td>
                <td width="50%">
                    <?php $this->renderPartial('_listKirimKeUnitLain',array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain)) ?>

                    <div class="control-group" id="tarif_konsulgizi">
                         <table id="tbl_tarifkonsulgizi" class="items table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th>Permintaan Konsultasi Gizi</th>
                                        <th>Tarif</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                            </table>
                                            <table class="table table-bordered table-condensed">
                                                    <tr><td width="95%" style="text-align: right;">Total Biaya Pelayanan</td><td><?php echo CHtml::textField('totalTarif', '',array('class'=>'span2', 'style'=>'text-align:right;', 'disabled'=>'disabled'));?></td></tr>
                                            </table>

                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($modKirimKeUnitLain, $modPasienMasukPenunjang); ?>
                
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <?php echo CHtml::hiddenField('deposit',$modDeposit,array('onclick'=>'cekInput()')); ?>	
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
            </td>
            <td>
                <?php echo $form->hiddenfield($modAdmisi,'kelaspelayanan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
                <?php echo $form->dropDownListRow($modKirimKeUnitLain,'pegawai_id', CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($modKirimKeUnitLain,'ruangan_id', CHtml::listData($modKirimKeUnitLain->getRuanganGiziItems(), 'ruangan_id', 'ruangan_nama'),
                                                                array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                      'onchange'=>'loadFormTindakanGizi(this.value)')); ?>
            </td>
            <td>
                <?php echo $form->textAreaRow($modKirimKeUnitLain,'catatandokterpengirim',array('onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
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
        ?>
        <?php  $content = $this->renderPartial('../tips/tips',array(),true);
                    $this->widget('UserTips',array('type'=>'admin','content'=>$content)); ?>
    </div>

<?php $this->endWidget(); ?>
<?php
$ruanganGizi = Params::RUANGAN_ID_GIZI;
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

<script type="text/javascript">
function loadFormTindakanGizi(idRuangan)
{
    var idKelasPelayanan = $('#PasienadmisiT_kelaspelayanan_id').val();
	if (idRuangan != ""){
		$('#tblGizi').addClass("animation-loading");
		$.post("<?php echo $this->createUrl('KonsulGiziTRI/loadFormTindakanGizi')?>", {idRuangan:idRuangan, idKelasPelayanan:idKelasPelayanan}, function(data){
			$('#tblGizi').removeClass("animation-loading");
			$('#bodyTblFormPermintaanGizi').html(data.form);
		}, "json");
	}
}

function batalKirim(idPasienKirimKeUnitLain,pendaftaran_id)
{
    myConfirm("Apakah anda akan membatalkan Konsultasi Gizi kirim pasien?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {idPasienKirimKeUnitLain: idPasienKirimKeUnitLain, pendaftaran_id:pendaftaran_id}, function(data){
                $('#tblListPemeriksaanRad').html(data.result);
            }, 'json');
        }
    });
}

function cekInputan(){
   var jmlTindakan = $('#tblFormPermintaanGizi tr').length;
   if($(".ceklis").length < 1){
        myAlert("Pilih pelayanan konsultasi gizi terlebih dahulu");
        return false;
   }else{
       $('.inputFormTabel').each(function(){this.value = unformatNumber(this.value)});
       return true;
   }    
}
function ceklist(obj){
    var kelaspelayanan_id = $('#PasienadmisiT_kelaspelayanan_id').val();
    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
    var daftartindakan_id = $(obj).parents('tr').find('input[name$="[idDaftarTindakan]"]').val();
    if($(obj).is(':checked')) {
        $.post('<?php echo $this->createUrl('konsulGiziTRI/CekTindakanGiziKelas') ?>', {daftartindakan_id: daftartindakan_id, kelaspelayanan_id:kelaspelayanan_id,pendaftaran_id:pendaftaran_id}, function(data){
             $(obj).each(function(){            
                if ($(this).is(':checked')){
                    if(data.status != 'ada'){
                        $(obj).removeAttr('checked');
                        alert ('Tindakan Bukan Termasuk kelas Pelayanan Yang Digunakan');
                    }else{
		hitungTotalTarif();
                        $(this).val(1);  
                        $('#tarif_konsulgizi').show();
                        $('#tbl_tarifkonsulgizi tbody').append(data.result);
                    }
                }else{
                    $(this).val(0);
                }
		hitungTotalTarif();
            });
        }, 'json');
    }else{
        $('.daftartindakan_id').each(function(){
            var daftartindakan = $(this).val();
            if(daftartindakan == daftartindakan_id){
                myConfirm("Apakah anda akan membatalkan tindakan konsultasi gizi?","Perhatian!",function(r) {
                    if(r){
                        removeTabel(daftartindakan_id);
                    }
                });
            }
        });
		hitungTotalTarif();
    }
}
function removeTabel(daftartindakan_id){
	var daftartindakan_id = daftartindakan_id;
	$('#tbl_tarifkonsulgizi').find('#daftartindakan_id_'+daftartindakan_id).parent().parent().remove();
	hitungTotalTarif();
}

function cekInput(){
	var deposit = $('#deposit').val();
	var totalTarif = unformatNumber($('#totalTarif').val());
	// requiredCheck
	var ruangan = $('#RIPasienKirimKeUnitLainT_ruangan_id').val();
	if (ruangan == ""){
	alert ('Ruangan Belum Dipilih!');
	return false;
	}
	cekInputan();
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
					   $('#rjpasien-konsulGizi-t-form').submit();
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
							$('#rjpasien-konsulGizi-t-form').submit();
							}, 2000);
						}
					});
			}else{
				$('#rjpasien-konsulGizi-t-form').submit();
			}
}

function hitungTotalTarif()
{
    var totalTarif = 0;
	var harga_tariftindakan = 0;
    $('#tbl_tarifkonsulgizi > tbody > tr').each(function(){
		harga_tariftindakan = unformatNumber($(this).find('input[name*="[harga_tariftindakan]"]').val());
        totalTarif += harga_tariftindakan;
    });
    $('#totalTarif').val(formatNumber(totalTarif));
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
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GIZI ?>, judulnotifikasi:'Pasien Rujukan', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
});
$('#tarif_konsulgizi').hide();
</script>