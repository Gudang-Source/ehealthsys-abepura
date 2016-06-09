<?php if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}
?>
<?php
    $format = new MyFormatter;
?>
<style>

.table
{
    border: 1px solid #000;
    border-radius: 0px 0px 0px 0px;
    box-shadow: 0px 0px 0px 0px;
}
    
.table-striped tbody tr:nth-child(2n+1) td
{
    background-color: #fff;
}

.table th
{
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
    
}

.c th + th, .c td + td, .c th + td, .c td + th 
{
    border-left: 1px solid #000;
    
}

.d th + th, .d td + td, .d th + td, .d td + th 
{
    border-left: 0px;
    
}
</style>

<table bgcolor='white' class='table table-striped table-bordered table-condensed d' style = "border:0px">
    <tr bgcolor='white' >
        <td bgcolor='white'>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('nopembelian')); ?>:</b>
            <?php echo CHtml::encode($modBeli->nopembelian); ?>
            <br />
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('tglpembelian')); ?>:</b>
            <?php echo CHtml::encode($modBeli->tglpembelian); ?>
             <br/>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('tgldikirim')); ?>:</b>
            <?php echo CHtml::encode($modBeli->tgldikirim); ?>
             <br/>                                    
        </td>
        <td bgcolor='white'>
             <b><?php echo CHtml::encode($modBeli->getAttributeLabel('peg_pemesanan_id')); ?>:</b>
            <?php echo CHtml::encode($modBeli->pemesan->nama_pegawai); ?>
            <br />             
             <b><?php echo "Nama Supplier" ?>:</b>
            <?php 
                $nama = SupplierM::model()->findByAttributes(array('supplier_id'=>$modBeli->supplier_id));
                echo $nama->supplier_nama;
            ?>
             <br/>  
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed c" bgcolor='white'>
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
                <td bgcolor='white' style = "text-align:right;"><?php echo $format->formatNumberForPrint($detail->hargabeli); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo $format->formatNumberForPrint($detail->hargasatuan); ?></td>
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