<?php
$this->breadcrumbs=array(
	'Radiologi',
);
$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">RADIOLOGI</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpasien-radiologi-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($modKirimKeUnitLain,'catatandokterpengirim'),
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<!--<legend class="rim">Tabel Riwayat Pemeriksaan Radiologi Pasien</legend>-->
<?php $this->renderPartial('_listKirimKeUnitLain',array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain)) ?>
<div class="row-fluid">
    <div class="control-group ">
        <?php echo $form->dropDownListRow($modKirimKeUnitLain,'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'reqKunjungan')); ?>
    </div>
</div>
<div class="formInputTab">

    <?php echo $form->errorSummary($modKirimKeUnitLain, $modPasienMasukPenunjang); ?>
    <table width="100%">
        <tr>
            <td>
                <div id="formPeriksaLab">
                    <?php 
                        $jenisPeriksa = '';
                        foreach($modPeriksaRad as $i=>$pemeriksaan){ 
                            $ceklist = false;
                            if($jenisPeriksa != $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama){
                                echo ($jenisPeriksa!='') ? "</div>" : "";
                                $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                                echo "<div class='boxtindakan' style='width:30%;'>";
                                echo "<h6>".$pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama."</h6>";
                                echo '<label class="checkbox inline">'.CHtml::checkBox("pemeriksaanRad[]", $ceklist, array('value'=>$pemeriksaan->pemeriksaanrad_id,
                                                                                         'onclick' => "inputperiksa(this);"));
                                echo "<span>".$pemeriksaan->pemeriksaanrad_nama."</span></label><br/>";
                            } else {
                                $jenisPeriksa = $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                                echo'<label class="checkbox inline">'. CHtml::checkBox("pemeriksaanRad[]", $ceklist, array('value'=>$pemeriksaan->pemeriksaanrad_id,
                                                                                         'onclick' => "inputperiksa(this);"));
                                echo "<span>".$pemeriksaan->pemeriksaanrad_nama."</span></label><br/>";
                            }
                        } echo "</div>";
                    ?>               
            </div>
            </td>
        </tr>
    </table>
    
    <table width="100%" class="table-condensed">
        <tr>
            <td width="27%">
                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

		        <?php echo CHtml::hiddenField('deposit',$modDeposit,array()); ?>	
                <div class="control-group ">
                    <label class="control-label required" for="RIPasienKirimKeUnitLainT_tgl_kirimpasien">
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
                <?php echo $form->dropDownListRow($modKirimKeUnitLain,'pegawai_id', CHtml::listData($modKirimKeUnitLain->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                                                array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modKirimKeUnitLain,'catatandokterpengirim',array('onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
				<?php echo $form->checkBoxRow($modKirimKeUnitLain,'isbayarkekasirpenunjang',array('onkeyup'=>"return $(this).focusNextInputField(event);",'title'=>"Pilih jika pasien harus membayar ke kasir terlebih dahulu sebelum periksa", 'rel'=>'tooltip')) ?>
            </td>
            <td width="50%">
                <div class="block-tabel">
                    <h6>Tabel Pemeriksaan <b>Radiologi  <?php echo isset($modJenisTarif) ? "- ".$modJenisTarif->jenistarif->jenistarif_nama : "" ; ?></b></h6>
                    <table id="tblFormPemeriksaanRad" class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Jenis Pemeriksaan</th>
                                <th>Pemeriksaan</th>
                                <th>Tarif</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-condensed">
                        <tr><td width="70%" style="text-align: right;">Total Biaya Pemeriksaan</td><td><?php echo CHtml::textField('periksaTotal', '',array('class'=>'span2', 'style'=>'text-align:right;', 'disabled'=>'disabled'));?></td></tr>
                    </table>
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
            ?>          
            <?php  
            $content = $this->renderPartial('../tips/tips',array(),true);
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
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);  ?>
    </div>
    
</div>

<?php $this->endWidget(); ?>

<script>
function inputperiksa(obj)
{
    if($(obj).is(':checked')) {
        var pemeriksaanrad_id = obj.value;
        var kelaspelayanan_id = $('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') ?>').val();
        var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
        if(kelaspelayanan_id == ''){
			myAlert("Silahkan pilih kelas pelayanan terlebih dahulu!");
			$(obj).attr('checked', false);
			return false;
		}
        jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('rawatInap/radiologiTRI/loadFormPemeriksaanRad')?>',
                 'data':{pemeriksaanrad_id:pemeriksaanrad_id, kelaspelayanan_id:kelaspelayanan_id,pendaftaran_id:pendaftaran_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                         if($.trim(data.form)=='')
                         {
                            $(obj).removeAttr('checked');
                            alert ('Pemeriksaan belum memiliki tarif');
                         } 
                         $('#tblFormPemeriksaanRad #trPeriksaRadKosong').detach();
                         $('#tblFormPemeriksaanRad > tbody').append(data.form);
                         $("#tblFormPemeriksaanRad > tbody > tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
                         $('.integer').each(function(){this.value = formatNumber(this.value)});
                        hitungTotal();
                 } ,
                 'cache':false});
    } else {
        myConfirm("Apakah anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
            if(r){
                batalPeriksa(obj.value);
                hitungTotal();
            }else{
                $(obj).attr('checked', 'checked');
            }
        });
    }
}

function batalPeriksa(idPemeriksaanrad)
{
    $('#tblFormPemeriksaanRad #periksarad_'+idPemeriksaanrad).detach();
    if($('#tblFormPemeriksaanRad tr').length == 1)
        $('#tblFormPemeriksaanRad').append('<tr id="trPeriksaRadKosong"><td colspan="4"></td></tr>');
}

function batalKirim(pasienkirimkeunitlain_id,pendaftaran_id)
{
    myConfirm("Apakah anda akan membatalkan kirim pasien ke Radiologi?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {pasienkirimkeunitlain_id: pasienkirimkeunitlain_id, pendaftaran_id:pendaftaran_id}, function(data){
                $('#tblListPemeriksaanRad').html(data.result);
				myAlert(data.pesan);
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
 
    $('#periksaTotal').val(formatNumber(total));    
}

function cekInput(){
	var deposit = $('#deposit').val();
	var periksaTotal = unformatNumber($('#periksaTotal').val());
	if (deposit == ""){
		myConfirm("Pasien Belum Melakukan Deposit!","Perhatian!",function(r) {
		   if(r){	
			   // notifikasi
			   var periksaTotal =  $('#periksaTotal').val();
			   var params = [];
			   params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik; echo "-"; echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp. <?php echo isset($modDeposit)? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp. ' + periksaTotal + '. Silahkan hubungi kasir'};
			   insert_notifikasi(params);
			   disableOnSubmit('#btn_submit');
			   setTimeout(function(){
			   $('#rjpasien-radiologi-t-form').submit();
			   }, 2000);
		   }
	   });
	}else if (deposit < periksaTotal){
			 myConfirm("Uang deposit tidak mencukupi, Silahkan hubungi kasir!","Perhatian!",function(r) {
				if(r){	
					// notifikasi
					var periksaTotal =  $('#periksaTotal').val();
					var params = [];
					params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik; echo "-"; echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp. <?php echo isset($modDeposit)? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp. ' + periksaTotal + '. Silahkan hubungi kasir'};
					insert_notifikasi(params);
					disableOnSubmit('#btn_submit');
					setTimeout(function(){
					$('#rjpasien-radiologi-t-form').submit();
					}, 2000);
				}
			});
	}else{
		$('#rjpasien-radiologi-t-form').submit();
	}
   return false;
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
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RAD ?>, judulnotifikasi:'Pasien Rujukan', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
})
</script>
