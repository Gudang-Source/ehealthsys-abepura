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
                    <td width="13%" style="text-align:right;">Tanggal Faktur</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modFakturBeli->tglfaktur); ?>
                    </td>
                    <td width="13%" style="text-align:right;">Tanggal Jatuh Tempo</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modFakturBeli->tgljatuhtempo); ?>
	                </td>
                </tr>     
                <tr>
                    <td width="13%" style="text-align:right;">Total Bruto</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modFakturBeli->totalhargabruto); ?>
                    </td>
                    <td width="13%" style="text-align:right;">No. Faktur</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modFakturBeli->nofaktur); ?>
	                </td>
                </tr>   
                <tr>
                    <td width="13%" style="text-align:right;">Supplier</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modFakturBeli->supplier->supplier_nama); ?>
                    </td>
                    <td width="13%" style="text-align:right;">Keterangan</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modFakturBeli->keteranganfaktur); ?>
	                </td>
                </tr>   
                <tr>
                    <td width="13%" style="text-align:right;">No. Penerima</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode($modFakturBeli->penerimaanbarang->noterima); ?>
                    </td>
                    <td width="13%" style="text-align:right;">No. PO</td><td width="2%">:</td>
					<td width="35%">
						<?php echo CHtml::encode(isset($modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan)?$modFakturBeli->penerimaanbarang->permintaanpembelian->nopermintaan:'-'); ?>
	                </td>
                </tr>   
            </table>            
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
	<thead>
            <tr>
                <th>Nama Obat Alkes</th>
                <th>Jml Terima</th>
                <th>Harga Netto</th>
                <th>Harga PPN</th>
                <th>Harga PPH</th>
                <th>% Discount</th>
                <th>Jml Discount</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $totalppn = 0;
            $totalpph = 0;
            $hargappn = 0;
            $hargappnfaktur = 0;
            $hargapph = 0;
            $hargapphfaktur = 0;
            foreach ($modDetailBeli as $i => $detail) { 
                if($detail->persenppnfaktur <= 0){
                    $hargappnfaktur = 0;
                }else{
                    $hargappn = $detail->harganettofaktur * ($detail->persenppnfaktur / 100);
                    $hargappnfaktur = $detail->harganettofaktur + hargappn;
                }
                if($detail->persenpphfaktur <= 0){
                    $hargapphfaktur = 0;
                }else{
                    $hargapph = $detail->harganettofaktur * ($detail->persenpphfaktur / 100);
                    $hargapphfaktur = $detail->harganettofaktur + hargapph;
                }
                
            ?>
            <tr>
                <td>
                    <?php echo $detail->obatalkes->obatalkes_nama; ?>
                </td>
                <td>
                    <?php echo number_format($detail->jmlterima); ?>
                </td>
                <td>
                    <?php echo number_format($detail->harganettofaktur); ?>
                </td>
                <td>
                    <?php echo number_format($hargappnfaktur); ?>
                </td>
                <td>
                    <?php echo number_format($hargapphfaktur); ?>
                </td>
                <td>
                    <?php echo number_format($detail->persendiscount); ?>
                </td>
                <td>
                    <?php echo number_format($detail->jmldiscount); ?>
                </td>
                <td>
                    <?php echo number_format($detail->hargasatuan); ?>
                </td>
                <td>
                    <?php echo number_format($detail->jmlterima * $detail->harganettofaktur); ?>
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
			<?php echo CHtml::encode($modBuktiKeluar->carabayarkeluar); ?>
		</td>
	</tr>     
	<tr>
		<td width="13%" style="text-align:right;">Total Tagihan</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modelBayar->totaltagihan); ?>
		</td>
		<td width="13%" style="text-align:right;">Penerima</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->namapenerima); ?>
		</td>
	</tr>     
	<tr>
		<td width="13%" style="text-align:right;">Uang Muka</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode(isset($modUangMuka->jumlahuang)?$modUangMuka->jumlahuang : "0"); ?>
		</td>
		<td width="13%" style="text-align:right; vertical-align: top;" rowspan="2">Alamat Penerima</td><td width="2%"  style="vertical-align: top;" rowspan="2">:</td>
		<td width="35%"rowspan="2" style="vertical-align: top;">
			<?php echo CHtml::encode($modBuktiKeluar->alamatpenerima); ?>
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
			<?php echo CHtml::encode($modBuktiKeluar->tglkaskeluar); ?>
		</td>
		<td width="13%" style="text-align:right;">Untuk Pembayaran</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->untukpembayaran); ?>
		</td>
	</tr>      
	<tr>
		<td width="13%" style="text-align:right;">No. Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->nokaskeluar); ?>
		</td>
	</tr>      
	<tr>
		<td width="13%" style="text-align:right;">Biaya Administrasi</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->biayaadministrasi); ?>
		</td>
	</tr>      
	<tr>
		<td width="13%" style="text-align:right;">Jumlah Kas Keluar</td><td width="2%">:</td>
		<td width="35%">
			<?php echo CHtml::encode($modBuktiKeluar->jmlkaskeluar); ?>
		</td>
	</tr>      
</table>
