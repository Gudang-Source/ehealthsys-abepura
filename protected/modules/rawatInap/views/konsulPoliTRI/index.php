<?php
$this->breadcrumbs=array(
	'Konsul Poli',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<!--<legend class="rim">Tabel Konsultasi Poliklinik</legend>-->
<?php $this->renderPartial('_listKonsulPoli',array('modRiwayatKonsul'=>$modRiwayatKonsul)); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($modKonsul,'catatan_dokter_konsul'),
)); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($modKonsul); ?>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group">
                    <label class="control-label">&nbsp;</label>
                    <div class="controls">
                        <?php echo CHtml::textField('deposit',$modDeposit,array('onclick'=>'cekInput()')); ?>	
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($modKonsul,'tglkonsulpoli', array('class'=>'control-label')) ?>
                    <?php $modKonsul->tglkonsulpoli = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKonsul->tglkonsulpoli, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modKonsul,
                                                    'attribute'=>'tglkonsulpoli',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
//                                                        'minDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true),
                            )); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->dropDownListRow($modKonsul,'ruangan_id', CHtml::listData($modKonsul->getRuanganInstalasiItems(Params::INSTALASI_ID_RJ,true), 'ruangan_id', 'ruangan_nama'),
                                                    array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'setTarif()')); ?>
                <?php echo $form->dropDownListRow($modKonsul,'pegawai_id', CHtml::listData($modKonsul->getDokterItems(), 'pegawai_id', 'NamaLengkap'),
                                                    array('empty'=>'-- Pilih --','class'=>'span3 dokter-konsul', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php //echo $form->dropDownListRow($modKonsul,'asalpoliklinikkonsul_id', CHtml::listData($modKonsul->getRuanganInstalasiItems(''), 'ruangan_id', 'ruangan_nama'),
                                                //array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modKonsul,'catatan_dokter_konsul',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <label class="control-label"> </label>
                    <div class="controls" id="tarif_poliklinik">
                        
                    </div>
                </div>
            </td>
        </tr>
<!--        <tr>
            <td colspan="2">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th colspan="2">Karcis Tindakan</th>
                        </tr>
                    </thead>
                    <?php //foreach ($karcisTindakan as $i => $karcis) { ?>
                    <tr>
                        <td width="15px;">
                            <?php //echo CHtml::checkBox('karcis[]', false, array()); ?>
                        </td>
                        <td>
                            <?php //echo $karcis->daftartindakan_nama; ?>
                        </td>
                    </tr>
                    <?php //} ?>
                </table>
            </td>
        </tr>-->
    </table>
    
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary', 'id'=>'btn_submit', 'onKeypress'=>'cekInput()','onclick'=>'cekInput()')); ?>
			<?php
            if(isset($_GET['idKonsulPoli'])){
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

            $idKonsulPoli = isset($_GET['idKonsulPoli'])?$_GET['idKonsulPoli']:null;
            $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id.'&idKonsulPoli='.$idKonsulPoli);
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
function printPermintaan(idKonsulPoli)
{
    window.open("${urlPrintPermintaan}&idKonsulPoli="+idKonsulPoli+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD); 

            ?>
    </div>

<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailKonsul',
    'options'=>array(
        'title'=>'Detail Konsul',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailKonsul">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
function viewDetailKonsul(idKonsulAntarPoli)
{
    $.post('<?php echo $this->createUrl('ajaxDetailKonsul') ?>', {idKonsulAntarPoli: idKonsulAntarPoli}, function(data){
        $('#contentDetailKonsul').html(data.result);
    }, 'json');
    $('#dialogDetailKonsul').dialog('open');
}
function batalKonsul(idKonsulAntarPoli,pendaftaran_id)
{
    myConfirm("Apakah anda akan membatalkan konsul ini?","Perhatian!",function(r) {
        if(r){
            $.post('<?php echo $this->createUrl('ajaxBatalKonsul') ?>', {idKonsulAntarPoli: idKonsulAntarPoli, pendaftaran_id:pendaftaran_id}, function(data){
                $('#tblListKonsul').html(data.result);
            }, 'json');
        }
    });
}
function setTarif(){
    var ruangan_id = $('#<?php echo CHtml::activeId($modKonsul,'ruangan_id'); ?>').val();
    var penjamin_id = '<?php echo $modPendaftaran->penjamin_id; ?>';
    var kelaspelayanan_id = '<?php echo $modPendaftaran->kelaspelayanan_id; ?>';
    $.post('<?php echo $this->createUrl('ajaxSetTarif') ?>', {ruangan_id:ruangan_id,penjamin_id:penjamin_id,kelaspelayanan_id:kelaspelayanan_id}, function(data){
        $('#tarif_poliklinik').html(data.result);
        $('.dokter-konsul').html(data.dokter);
	hitungTotalTarif();
    }, 'json');
}

function cekInput(){
	//requiredCheck
	var ruangan = $('#RIKonsulPoliT_ruangan_id').val();
	if (ruangan == ""){
	alert ('Ruangan Belum Dipilih!');
	return false;
	}
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
			   $('#rjkonsul-poli-t-form').submit();
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
					$('#rjkonsul-poli-t-form').submit();
					}, 2000);
				}
			});
	}else{
		$('#rjkonsul-poli-t-form').submit();
	}
}
function hitungTotalTarif()
{
    var totalTarif = 0;
	var harga_tariftindakan = 0;
    $('#tblListKonsul > tbody > tr').each(function(){
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
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_RJ ?>, judulnotifikasi:'Pasien Rujukan', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
});
</script>