<!--<legend class="rim2">Reseptur Pasien</legend>-->
<?php
$this->breadcrumbs=array(
	'Reseptur',
);

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjreseptur-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#therapiobat_nama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             ),
)); ?>

<?php 
$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'list-rujukankeluar',
            'content'=>array(
                'content-detailpasien'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Rujukan Pasien')).'<b> Tabel Riwayat Resep</b>',
                    'isi'=>$this->renderPartial($this->path_view.'_listResep',array(
                            'modRiwayatResep'=>$modRiwayatResep,
                            ),true),
                    'active'=>true,
                    ),   
                ),
        )); 
?>
<div class="formInputTab">
<fieldset class="box" id="form-dataresep">
    <legend class="rim">Data Resep</legend>
    <?php $this->renderPartial($this->path_view.'_formDataResep', array('form'=>$form,'modReseptur'=>$modReseptur,'modPendaftaran'=>$modPendaftaran)); ?>
</fieldset>
<?php 
if(!isset($_GET['sukses'])){
	$this->renderPartial($this->path_view.'_formInputObat',array('modPendaftaran'=>$modPendaftaran,'form'=>$form,'modReseptur'=>$modReseptur));
}	
?>
<div class="block-tabel">
    <h6>Tabel <b>Reseptur</b></h6>
    <table class="items table table-striped table-condensed" id="table-obatalkespasien">
        <thead>
            <tr>
                <th>Resep</th>
                <th>R ke</th>
                <th>Kode / Nama Obat</th>
                <!--th>Sumber Dana</th>
                <th>Satuan Kecil</th-->
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
        <tbody>
            <?php
            if(count($modResepturDetail) > 0){
                foreach($modResepturDetail AS $i=> $modDetail){
                    echo $this->renderPartial($this->path_view.'_rowDetail',array('modResepturDetail'=> $modDetail));
                }
            }
            ?>
        </tbody>
		<tfoot>
			<tr>

				<td colspan="4" style="text-align: right;"><b>Total Estimasi Harga</b></td>
				<td><input type="text" readonly name="totalHargaReseptur" id="totalHargaReseptur" class="inputFormTabel lebar2 integer" /></td>
				<td colspan="3"></td>
			</tr>
    </tfoot>
    </table>
</div>
    <div class="form-actions">
            <?php 
                $disableSave = false;
                $disableSave = (!empty($_GET['sukses'])) ? true : false; 
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();','disabled'=>$disableSave)); //formSubmit(this,event)        
                //  jika tanpa cek obat
                /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                 * 
                 */
            ?>
            <?php if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
            } ?>
            <?php
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Print Detail',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'printRecordTerakhir(\'PRINT\')')).'&nbsp';                 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Print Resep',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'printResep(\'PRINT\')'));                 
            ?>
            <?php
                $content = $this->renderPartial($this->path_view.'tips/tipsReseptur',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailResep"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
$urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
$urlPrintResep=  Yii::app()->createAbsoluteUrl('farmasiApotek/InformasiPasienResep/printResepDokter&id='.$modReseptur->reseptur_id);
$js = <<< JSCRIPT
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
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modReseptur'=>$modReseptur,'modReseptur'=>$modReseptur)); ?>