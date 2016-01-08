<?php
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 
        'periode'=>$periode, 'colspan'=>10));  
?>
<div style='border:1px solid #cccccc; border-radius:2px;padding:10px;float:right;margin-right:30px;margin-top:-100px;text-align:center;'>
                <font style='font-size:9pt;text-align:center;'><B>PURCHASE ORDER REPORT</B></font><br></div><br/>
<?php
    $criteria=new CDbCriteria;
	$criteria->addCondition('permintaanpembelian_t.supplier_id = '.$_GET['id']);
	$criteria->addCondition('t.permintaanpembelian_id = '.$_GET['idPembelian']);
	$criteria->join = 'LEFT JOIN permintaanpembelian_t ON t.permintaanpembelian_id = permintaanpembelian_t.permintaanpembelian_id';
	$criteria->limit = -1;
	$models = GFPermintaanDetailT::model()->findAll($criteria);
	?>

<div style='border:1px solid #cccccc; border-radius:2px;padding:10px;float:left;margin-left:3px;margin-top:-20px;'>
	<font style='font-size:9pt'><B><?php echo $models[0]->permintaanpembelian->nopermintaan; ?></B></font><br>
</div>
<div style='border:1px solid #cccccc; border-radius:2px;padding:10px;float:left;margin-left:40px;margin-top:-20px;margin-bottom:20px;'>
	<font style='font-size:9pt'><B><?php echo MyFormatter::formatDateTimeForUser($models[0]->permintaanpembelian->tglpermintaanpembelian); ?></B></font>
</div>
				
<table width='100%' border='0' style='font-size:small;'>
	<tr>
		<td style='font-size:9pt;' width="15%"><b> Nama Supplier </b></td>
		<td style='font-size:9pt;'>: <?php echo $models[0]->permintaanpembelian->supplier->supplier_nama; ?></td>
	</tr>
	<tr>
		<td style='font-size:9pt;' width="15%"><b> Alamat Supplier </b></td>
		<td style='font-size:9pt;'>: <?php echo $models[0]->permintaanpembelian->supplier->supplier_alamat; ?></td>
	</tr>
</table>
<br>

<table width='100%' border='1' style='font-size:small;'>		
	<tr>
		<td>
			<table width='100%' border='1'>
				<thead>
					<tr style='font-weight:bold;background-color:#C0C0C0'>
						<th align='center'>Kode</th>
						<th align='center'>Nama</th>
						<th align='center'>Satuan</th>
						<th align='center'>Jumlah</th>
						<th align='center'>Harga</th>
						<!--<th align='center'>Bruto</th>-->
						<th align='center'>Diskon %</th>
						<th align='center'>Ppn %</th>
						<!--<th align='center'>Netto %</th>-->
						<th align='center'>Biaya Lain</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$total = 0;
						$totdisc = 0;
					?>
					<?php foreach($models as $key => $detail){ ?>
					<tr>
						<td width='10%'><?php echo $detail->obatalkes->obatalkes_kode; ?></td>
						<td width='20%;'><?php echo $detail->obatalkes->obatalkes_nama; ?></td>
						<td width='15%;'><?php echo !empty($detail->satuanbesar_id)?$detail->satuanbesar->satuanbesar_nama:''; ?></td>
						<td width='10%;' style='text-align:center'><?php echo $detail->kemasanbesar; ?></td>
						<td width='10%;' style='text-align:right'><?php echo MyFormatter::formatUang($detail->harganettoper); ?></td>
						<td width='8%;' style='text-align:right'><?php echo $detail->persendiscount; ?></td>
						<td width='8%;' style='text-align:right'><?php echo $detail->persenppn; ?></td>
						<td width='8%;' style='text-align:right'><?php echo MyFormatter::formatUang($detail->biaya_lainlain); ?></td>
					</tr>
					<?php
						$total += $detail->harganettoper;
						$totdisc += $detail->jmldiscount;
					?>
					<?php } ?>
				</tbody>
			</table>
			<br><br>
			<div>
				<table align='right' border='1'>
					<tr>
						<th style='text-align:right; background-color:#C0C0C0' width='120px;'>Total : </th>
						<th width='120px;' style='text-align:right'><?php echo MyFormatter::formatUang($total); ?></th>
					</tr>
					<tr>
						<th style='text-align:right; background-color:#C0C0C0'>Discount : </th>
						<th style='text-align:right'><?php echo MyFormatter::formatUang($totdisc); ?></th>
					</tr>
					<tr>
						<th style='text-align:right; background-color:#C0C0C0'>Total Transaksi : </th>
						<th style='text-align:right'><?php echo MyFormatter::formatUang($total-$totdisc); ?></th>
					</tr>
				</table>
			</div>
			<div style='border:0px solid #cccccc;padding:10px; width: 10%;float:right;margin-top:5px;margin-right:60px;'>
					<font style='font-size:9pt'><B><CENTER>Purchasing</CENTER></B><br><br><br/>
					<font style='font-size:9pt'><B><CENTER><?php echo PegawaiM::model()->findByPk(Yii::app()->user->id)->nama_pegawai; ?></CENTER></B><hr style='height:3px;background:#000000;margin-top:-2px;' />
			</div>
		</td>
	</tr>
</table>