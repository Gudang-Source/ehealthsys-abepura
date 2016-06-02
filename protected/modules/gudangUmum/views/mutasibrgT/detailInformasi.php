<style>
    .table {
        border-collapse: collapse;
        border: none;
        box-shadow: none;
    }
    
    .det th, .det td {
        background-color: white;
        color: black;
        border: 1px solid black;
    }
</style>

<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
?>
<table class='table'>
    <tr>
        <td>No. Mutasi</td><td>:</td><td><?php echo CHtml::encode($modMutasi->nomutasibrg); ?></td>
        <td>Tgl. Mutasi</td><td>:</td><td><?php echo CHtml::encode($modMutasi->tglmutasibrg); ?></td>
    </tr>
    <tr>
        <td>Ruangan Rujuan</td><td>:</td><td><?php echo CHtml::encode($modMutasi->ruangantujuan->ruangan_nama); ?></td>
        <td>Create Time</td><td>:</td><td><?php echo CHtml::encode($modMutasi->create_time); ?></td>
    </tr> 
</table>

<table id="tableObatAlkes" class="det" width="100%">
    <thead>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Bidang</th>
        <th>Barang</th>
        <th>Jumlah Mutasi</th>
        <th>Ukuran<br/>Bahan</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        foreach($modDetailMutasi AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama;  ?></td>
                <td><?php echo $modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama; ?></td>
                <td><?php echo $modBarang->subsubkelompok->subkelompok->subkelompok_nama; ?></td>
                <td><?php echo $modBarang->subsubkelompok->subsubkelompok_nama; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td><?php echo $detail->qty_mutasi." ".$detail->satuanbrg; ?></td>
                <td><?php echo $modBarang->barang_ukuran; ?><br/><?php echo $modBarang->barang_bahan; ?></td>
            </tr>   
            <?php 
        $no++;
        endforeach;
    ?>
    </tbody>
</table>
<table width="100%" style="margin-top:20px;">
	<tr>
		<td width="100%" align="left" align="top">
			<table width="100%">
				<tr>
					<td width="35%" align="center">
						<div>Mengetahui</div>
						<div style="margin-top:60px;"><?php echo isset($modMutasi->pegmengetahui_id) ? $modMutasi->pegawaimengetahui->NamaLengkap : "" ?></div>
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Pengirim</div>
						<div style="margin-top:60px;"><?php echo isset($modMutasi->pegpengirim_id) ? $modMutasi->pegawaipengirim->NamaLengkap : "" ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php if(isset($caraPrint)){
    
}else{ ?>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; ?>
<?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print&id='.$modMutasi->mutasibrg_id);
        $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gumutasibrg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php } ?>