<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
?>

<table class='table'>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPesan->getAttributeLabel('nopemesanan')); ?>:</b>
            <?php echo CHtml::encode($modPesan->nopemesanan); ?>
            <br />
             <b><?php echo CHtml::encode($modPesan->getAttributeLabel('tglpesanbarang')); ?>:</b>
            <?php echo CHtml::encode($modPesan->tglpesanbarang); ?>
             <br/>
             
        </td>
        <td>
             <b><?php echo CHtml::encode($modPesan->getAttributeLabel('ruanganpemesan_id')); ?>:</b>
            <?php echo CHtml::encode($modPesan->ruanganpemesan->ruangan_nama); ?>
            <br />
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-bordered table-condensed">
    <thead>
    
        <th>No.</th>
        <th>Golongan</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Bidang</th>
        <th>Barang</th>
        <th>Jumlah Permintaan</th>
        <th>Satuan</th>
        <!--<th>Ukuran<br/>Bahan</th>-->
    
    </thead>
    <tbody>
    <?php
    $no=1;
        foreach($modDetailPesan AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php 
                    echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama:null; 
                    ?>
                </td>
                <td><?php echo !empty($modBarang->bidang_id)? $modBarang->bidang->subkelompok->kelompok->kelompok_nama:null; ?></td>
				<td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->subkelompok_nama:null; ?></td>
				<td><?php echo !empty($modBarang->bidang_id)?$modBarang->bidang->bidang_nama:null; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td>
                <?php 
                    echo $detail->qty_pesan;
                ?>
                </td>
                <td><?php echo $detail->satuanbarang; ?></td>
                <!--<td><?php //echo $modBarang->barang_ukuran; ?><br/><?php //echo $modBarang->barang_bahan; ?></td>-->
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
						<div>Mengetahui<br>Ka. Instalasi Farmasi</div>
						<div style="margin-top:60px;"><?php echo isset($modPesan->pegpemesan_id) ? $modPesan->pegawaipemesan->NamaLengkap : "" ?></div>
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Dibuat Oleh :</div>
						<div style="margin-top:60px;"><?php echo isset($modPesan->pegmengetahui_id) ? $modPesan->pegawaimengetahui->NamaLengkap : "" ?></div>
						<div>(Petugas Gudang Farmasi)</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php if(isset($caraPrint)){
    
}else{ ?>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
            array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; ?>
<?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print&id='.$modPesan->pesanbarang_id);
        $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gupesanbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php } ?>