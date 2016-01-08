<?php
if (isset($caraPrint)){
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$judulKuitansi));      
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
		<legend class="rim2">Data Faktur</legend>
            <table width="100%">
                <tr>
                    <td width="13%" style="text-align:right;">Tanggal Terima</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modTerimaPersediaan->tglterima); ?>
                    </td>
                    <td width="13%" style="text-align:right;">Tanggal Faktur</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modTerimaPersediaan->tglfaktur); ?>
	                </td>
                </tr>     
                <tr>
                    <td width="13%" style="text-align:right;">Total Bruto</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modTerimaPersediaan->totalharga); ?>
                    </td>
                    <td width="13%" style="text-align:right;">No. Faktur</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modTerimaPersediaan->nofaktur); ?>
	                </td>
                </tr>   
                <tr>
                    <td width="13%" style="text-align:right;">Supplier</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modTerimaPersediaan->pembelianbarang->supplier->supplier_nama); ?>
                    </td>
                    <td width="13%" style="text-align:right;">Keterangan</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modTerimaPersediaan->keterangan_persediaan); ?>
	                </td>
                </tr>   
                <tr>
                    <td width="13%" style="text-align:right;">No. Penerima</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modTerimaPersediaan->pembelianbarang->nopembelian); ?>
                    </td>
                    <td width="13%" style="text-align:right;"></td><td width="2%"></td>
					<td width="35%">
	                </td>
                </tr>   
            </table>            
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
	<thead>
            <tr>
                <th>Nama Barang</th>
				<th>Satuan Beli</th>
                <th>Jumlah Terima</th>
                <th>Harga Beli</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($modDetailPersediaan as $i => $detail) {                 
            ?>
            <tr>
                <td>
                    <?php echo $detail->barang->barang_nama; ?>
                </td>
                <td>
                    <?php echo $detail->satuanbeli; ?>
                </td>
                <td>
                    <?php echo number_format($detail->jmlterima); ?>
                </td>
                <td>
                    <?php echo number_format($detail->hargabeli); ?>
                </td>
                <td>
                    <?php echo number_format($detail->hargabeli); ?>
                </td>
                <td>
                    <?php echo number_format($detail->jmlterima * $detail->hargasatuan); ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
</table><br>
<table width="100%">
	<tr>
		<td width="13%" style="text-align:right;">Tanggal Pembayaran</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modelBayar->tglbayarkesupplier); ?>
		</td>
		<td width="13%" style="text-align:right;">Cara Bayar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modBuktiKeluar->carabayarkeluar) ? $modBuktiKeluar->carabayarkeluar : ""); ?>
		</td>
	</tr>     
	<tr>
		<td width="13%" style="text-align:right;">Total Tagihan</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modelBayar->totaltagihan); ?>
		</td>
		<td width="13%" style="text-align:right;">Penerima</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modBuktiKeluar->namapenerima) ? $modBuktiKeluar->namapenerima : ""); ?>
		</td>
	</tr>     
	<tr>
		<td width="13%" style="text-align:right;"></td><td width="2%"></td>
		<td width="35%">
		</td>
		<td width="13%" style="text-align:right; vertical-align: top;" rowspan="2">Alamat Penerima</td><td width="2%"  style="vertical-align: top;" rowspan="2">:</td>
		<td width="35%"rowspan="2" style="vertical-align: top;">
			<?php echo CHtml::encode(isset($modBuktiKeluar->alamatpenerima) ? $modBuktiKeluar->alamatpenerima : ""); ?>
		</td>
	</tr>     
	<tr>
		<td width="13%" style="text-align:right;">Jumlah Dibayarkan</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modelBayar->jmldibayarkan); ?>
		</td>
	</tr> 
	<tr>
		<td width="13%" style="text-align:right;">Tanggal Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modBuktiKeluar->tglkaskeluar) ? $modBuktiKeluar->tglkaskeluar : ""); ?>
		</td>
		<td width="13%" style="text-align:right;">Untuk Pembayaran</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modBuktiKeluar->untukpembayaran) ? $modBuktiKeluar->untukpembayaran : ""); ?>
		</td>
	</tr>      
	<tr>
		<td width="13%" style="text-align:right;">No. Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modBuktiKeluar->nokaskeluar) ? $modBuktiKeluar->nokaskeluar : "") ; ?>
		</td>
	</tr>      
	<tr>
		<td width="13%" style="text-align:right;">Biaya Administrasi</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modBuktiKeluar->biayaadministrasi) ? $modBuktiKeluar->biayaadministrasi : ""); ?>
		</td>
	</tr>      
	<tr>
		<td width="13%" style="text-align:right;">Jumlah Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modBuktiKeluar->jmlkaskeluar) ? 0 : ""); ?>
		</td>
	</tr>      
</table>
