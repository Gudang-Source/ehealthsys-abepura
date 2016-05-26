<style>
    .det td {
        border: 1px solid black;
    }
</style>
<?php 
$format = new MyFormatter();
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  
$print = ReevaluasiasetT::model()->findByAttributes(array('reevaluasiaset_id'=>$_GET['id']));
$sql = "select reevaluasiaset_t.*,reevaluasiasetdetail_t.* from reevaluasiaset_t  join reevaluasiasetdetail_t on
		(reevaluasiasetdetail_t.reevaluasiaset_id=reevaluasiaset_t.reevaluasiaset_id)
		where reevaluasiaset_t.reevaluasiaset_id='".$_GET['id']."' ";
$query = Yii::app()->db->createCommand($sql)->queryAll();
?>

<table>
	<tr>
		<td>No. Reevaluasi</td>
		<td>:</td>
		<td><?php echo $print->reevaluasiaset_no;?></td>
	</tr>
	<tr>
		<td>Tanggal Reevaluasi</td>
		<td>:</td>
		<td><?php echo $format->formatDateTimeForUser($print->reevaluasiaset_tgl);?></td>
	</tr>	
</table>
<br />
<?php
	$row="";
	$no = 1;
	foreach($query as $data):
            $barang = BarangM::model()->findByPk($data['barang_id']);
            $pasar = $data['reevaluasiaset_nilaibuku'] + $data['reevaluasiaset_selisihreevaluasi'];
		$row.="
        <tr>
			<td>$no</td>
                        <td>".$data['reevaluasiaset_no']."<strong></strong></td>
                        <td>".$barang->barang_nama."</td>
                        <td style='text-align: right'>".$data['reevaluasiaset_umurekonomis']." Tahun</td>
                        <td style='text-align: right'>".$format->formatNumberForPrint($data['reevaluasiaset_nilaibuku'])."</td>
			<td style='text-align: right'>".$format->formatNumberForPrint($pasar)."</td>
			<td style='text-align: right'>".$format->formatNumberForPrint($data['reevaluasiaset_selisihreevaluasi'])."</td>
        </tr>
		";
		$no++;
	endforeach;
?>
<table width="100%" class="det">
        <tr>
           <td>No</td>
           <td>No. Registrasi</td>
           <td>Nama Aset</td>
           <td>Umur Ekonomis</td>
           <td>Nilai Buku</td>
           <td>Harga Pasar</td>
           <td>Selisih Reevaluasi</td>		   
        </tr>
		<tr>
			<?php echo $row;?>
		</tr>
</table>

<?php if (isset($_GET['caraPrint'])): ?>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="center">
			Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($print->pegawaimengetahui_id) ? $print->pegawaimengetahui->namaLengkap : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kecamatan_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo (isset($print->pegawaimenyetujui_id) ? $print->pegawaimenyetujui->namaLengkap : Yii::app()->user->getState('nama_pegawai')); ?>
        </td>
    </tr>
</table>
<?php else: ?>
<?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $this->widget('UserTips',array('type'=>'admin'));
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/reevaluasiasetT/print');
        
$pendaftaran_id = $_GET['id'];
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);       
?>
<?php endif; ?>
