<?php
$this->breadcrumbs=array(
	'Reseptur',
);

$this->widget('bootstrap.widgets.BootAlert');
//$this->renderPartial('/_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modAdmisi'=>$modAdmisi));
//
//echo '<legend class="rim">RESEPTUR</legend><hr>';
//$this->renderPartial('/_tabulasi',array('modPendaftaran'=>$modPendaftaran, 'modAdmisi'=>$modAdmisi));

?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjreseptur-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#namaObatNonRacik',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'list-rujukankeluar',
            'content'=>array(
                'content-detailpasien'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Rujukan Pasien')).'<b> Tabel Riwayat Resep</b>',
                    'isi'=>$this->renderPartial('_listResep',array(
                            'modRiwayatResep'=>$modRiwayatResep,
                            ),true),
                    'active'=>true,
                    ),   
                ),
        )); ?>

<div class="formInputTab">
<?php $this->renderPartial('_formInputObat',array('form'=>$form,'modReseptur'=>$modReseptur,'modDeposit'=>$modDeposit,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran)); ?>
<div class="block-tabel">
<h6>Tabel <b>Reseptur</b></h6>
	<table class="items table table-striped table-condensed" id="table-obatalkespasien">
		<thead>
			<tr>
                <th>Resep</th>
                <th>R ke</th>
                <th>Kode / Nama Obat</th>
                <th>Sumber Dana</th>
                <!--th>Satuan Kecil</th-->
                <th>Jumlah</th>
                <!--th>Stok</th-->
                <th>Estimasi Harga</th>
                <!--<th>Discount (%)</th>-->
                <th>Sub Total</th>
                <th>Signa</th>
                <th>Etiket</th>
                <th>Sediaan</th>
                <th>Batal</th>
            </tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr>
				<td colspan="6" style="text-align: right;"><b>Total Estimasi Harga</b></td>
				<td><input type="text" readonly name="totalHargaReseptur" id="totalHargaReseptur" class="inputFormTabel lebar2 integer" /></td>
				<td colspan="3"></td>
			</tr>
    </tfoot>
	</table>
</div>


    <div class="form-actions">
            
	<?php
	if(isset($_GET['sukses'])){
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'id'=>'btn_submit','disabled'=>true))."&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRecordTerakhir(\'PRINT\')'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print Resep',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printResep(\'PRINT\')'))."&nbsp&nbsp"; 
	}else{
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'id'=>'btn_submit', 'onclick'=>'cekObat();', 'onKeypress'=>'cekObat();'))."&nbsp&nbsp";
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>'disabled'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print Resep',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>'disabled'))."&nbsp&nbsp"; 
	}
	?>
            <?php    $content = $this->renderPartial('../tips/tips',array(),true);
                    $this->widget('UserTips',array('type'=>'admin','content'=>$content)); ?>
    </div>

	<?php
           $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
           $urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
		   $urlPrintResep=  Yii::app()->createAbsoluteUrl('farmasiApotek/InformasiPasienResep/printResepDokter&id='.$modReseptur->reseptur_id);
$js = <<< JSCRIPT
function print(caraPrint,idReseptur)
{
    window.open("${urlPrint}&idReseptur="+idReseptur+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printResep(caraPrint)
{
    window.open("${urlPrintResep}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

</div>
<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailResep">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
	function viewDetailResep(idReseptur,pendaftaran_id)
	{
	
	$.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {idReseptur: idReseptur, pendaftaran_id: pendaftaran_id}, function(data){
			$('#contentDetailResep').html(data.result);
		}, 'json');
		$('#dialogDetailresep').dialog('open');
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
    });
</script>