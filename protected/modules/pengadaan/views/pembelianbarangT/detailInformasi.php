<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
?>
<?php
    $format = new MyFormatter;
?>
<style>
    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .border {
        box-shadow:none;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white' >
        <td>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('nopembelian')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modBeli->nopembelian); ?>
        </td>
        <td>
            &nbsp;
        </td>    
        <td>
            <b><?php echo CHtml::encode($modBeli->getAttributeLabel('peg_pemesanan_id')); ?></b>            
        </td>
        <td>: <?php echo CHtml::encode($modBeli->pemesan->nama_pegawai); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('tglpembelian')); ?></b>
        </td>
        <td>
            : <?php echo !empty($modBeli->tglpembelian)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($modBeli->tglpembelian)))):"-" ?>
        </td>
        <td>
            &nbsp;
        </td> 
        <td>
             <b><?php echo "Supplier" ?></b>            
        </td>
        <td>
            : <?php 
                $nama = SupplierM::model()->findByAttributes(array('supplier_id'=>$modBeli->supplier_id));
                echo $nama->supplier_nama;
            ?>
        </td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('tgldikirim')); ?></b>
        </td>
        <td>
            : <?php echo !empty($modBeli->tgldikirim)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($modBeli->tgldikirim)))):"-"; ?>
        </td>
    </tr>
        
</table>

<table id="tableObatAlkes" class="table border" bgcolor='white'>
    <thead>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Bidang</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Sub Sub Kelompok</th>
        <th>Barang</th>
        <th>Harga Beli</th>
        <th>Harga Satuan</th>
        <th>Jumlah Beli</th>
        <!--<th>Satuan</th>-->
        <th>Ukuran<br/>Bahan</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        foreach($modDetailBeli AS $detail): ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php echo $no; ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->golongan->golongan_nama:null;  ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->bidang->bidang_nama:null;  ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->kelompok->kelompok_nama:null; ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subkelompok->subkelompok_nama:null; ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->subsubkelompok_id)?$modBarang->subsubkelompok->subsubkelompok_nama:null; ?></td>
                <td bgcolor='white'><?php echo $modBarang->barang_nama; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo "Rp".$format->formatNumberForPrint($detail->hargabeli); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo "Rp".$format->formatNumberForPrint($detail->hargasatuan); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo $format->formatNumberForPrint($detail->jmlbeli).' '.$detail->satuanbeli; ?></td>
                <!--<td bgcolor='white'><?php //echo $detail->satuanbeli; ?></td>-->
                <td bgcolor='white'><?php echo $modBarang->barang_ukuran; ?><br/><?php echo $modBarang->barang_bahan; ?></td>
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
						<div style="margin-top:60px;"><?php echo isset($modBeli->peg_mengetahui_id) ? $modBeli->mengetahui->NamaLengkap : "" ?></div>
					</td>
					<td width="35%" align="center">
					</td>
					<td width="35%" align="center">
						<div>Menyetujui</div>
						<div style="margin-top:60px;"><?php echo isset($modBeli->peg_menyetujui_id) ? $modBeli->menyetujui->NamaLengkap : "" ?></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    //echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        pembelianbarang_id = '<?php echo isset($modBeli->pembelianbarang_id) ? $modBeli->pembelianbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id='+pembelianbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}
?>