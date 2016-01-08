<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
?>
<table class='table'>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modMutasi->getAttributeLabel('nomutasibrg')); ?>:</b>
            <?php echo CHtml::encode($modMutasi->nomutasibrg); ?>
            <br />
             <b><?php echo CHtml::encode($modMutasi->getAttributeLabel('tglmutasibrg')); ?>:</b>
            <?php echo CHtml::encode($modMutasi->tglmutasibrg); ?>
             <br/>
             
        </td>
        <td>
             <b><?php echo CHtml::encode($modMutasi->getAttributeLabel('ruangantujuan_id')); ?>:</b>
            <?php echo CHtml::encode($modMutasi->ruangantujuan->ruangan_nama); ?>
            <br />
             <b><?php echo CHtml::encode($modMutasi->getAttributeLabel('create_time')); ?>:</b>
            <?php echo CHtml::encode($modMutasi->create_time); ?>
            <br />
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Bidang</th>
        <th>Barang</th>
        <th>Jumlah Mutasi</th>
        <th>Satuan</th>
        <th>Ukuran<br/>Bahan</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        foreach($modDetailMutasi AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null;  ?></td>
                <td><?php echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
                <td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
                <td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td><?php echo $detail->qty_mutasi; ?></td>
                <td><?php echo $detail->satuanbrg; ?></td>
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