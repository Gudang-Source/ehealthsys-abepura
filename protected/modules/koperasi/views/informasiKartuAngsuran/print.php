<style>
	h1{
		font-size: 16px;
		margin-top: 0px;
	}
	.header{
		text-align: center;	
		padding-right: 100px;	
	}
	body, table{
		width: 100%;	
		font-size: 14px;
   	margin-left: auto;
    	margin-right: auto;
	}
        th {
            text-align: center !important;
        }
	.tabel td, 	th{
                padding: 5px !important;
		border:1px solid black;
	}	
		hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
	}	
</style>
<table width="100%">
<tr>
<td>
<?php echo CHtml::image(Params::urlProfilGambar().$profil->path_valuesimage1, '', array('width'=>50)); ?>
</td>
<td class="header"><h1>
	<b>KOPERASI PEGAWAI REPUBLIK INDONESIA<br>
	<?php echo $profil->nama_profil; ?></b><br>
	<?php echo $profil->badanhukum; ?>
</h1>
</td>
</tr>
</table>
<hr class="symbol" />
<h1 style="text-align:center">
	<u>INFORMASI KARTU ANGSURAN ANGGOTA</u>
	<br/>
	<?php if (!empty($angsuran->a_tglAwal) && !empty($angsuran->a_tglAkhir)) {
			echo "Periode : ".MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($angsuran->a_tglAwal)))." - ".MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($angsuran->a_tglAkhir)))."<br>";
		} ?>
</h1>

<?php
			$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
				'id'=>'kartuangsuran-m-grid',
				'dataProvider'=>$angsuran->searchPrintInformasi(),
				'filter'=>null,
				'template' => "{items}",
				'summaryText'=>'',
				'itemsCssClass' => 'tabel',
				'columns'=>array( 
					array(
                'header' => 'No',
                //'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                'value' => '$row+1',
                'htmlOptions'=>array('style'=>'text-align:center'),
            	),
            	array(
						'header'=>'Tgl Pinjaman /<br/>No Pinjaman',
						'type'=>'raw',
						'value'=>'date("d/m/Y", strtotime($data->tglpinjaman))." /<br/>".$data->no_pinjaman',
					),
					array(
						'header'=>'Unit Kerja',
						'type'=>'raw',
						'value'=>'$data->namaunit',
					),
					array(
						'header'=>'Golongan',
						'type'=>'raw',
						'value'=>'$data->golonganpegawai_nama',
					),
					array(
						'header'=>'Nomor Anggota',
						'type'=>'raw',
						'value'=>'$data->nokeanggotaan',
					),
					array(
						'header'=>'Nama Anggota',
						'type'=>'raw',
						'value'=>'$data->nama_pegawai',
					),
					array(
						'header'=>'Tgl Angsuran',
						'type'=>'raw',
						'value'=>'date("d/m/Y", strtotime($data->tglangsuran))',
					),
					array(
						'header'=>'Tgl Jatuh Tempo',
						'type'=>'raw',
						'value'=>'date("d/m/Y", strtotime($data->tgljatuhtempoangs))',
					),
					/*array(
						'header'=>'Jumlah Pinjaman',
						'type'=>'raw',
						'value'=>'empty($data->jml_pinjaman)?"-":MyFormatter::formatNumberForPrint($data->jml_pinjaman)',
						'htmlOptions'=>array('style'=>'text-align:right'),
					),*/
					array(
						'header'=>'Angsuran Ke',
						'type'=>'raw',
						'value'=>'$data->angsuran_ke',
						'htmlOptions'=>array('style'=>'text-align:center'),
					),
					array(
						'header'=>'Angsuran Pokok',
						'type'=>'raw',
						'value'=>'empty($data->jmlpokok_angsuran)?"-":MyFormatter::formatNumberForPrint($data->jmlpokok_angsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Jasa Angsuran',
						'type'=>'raw',
						'value'=>'empty($data->jmljasa_angsuran)?"-":MyFormatter::formatNumberForPrint($data->jmljasa_angsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Total Angsuran',
						'type'=>'raw',
						'value'=>'MyFormatter::formatNumberForPrint(
							(empty($data->jmlpokok_angsuran)?0:$data->jmlpokok_angsuran) + 
							(empty($data->jmljasa_angsuran)?0:$data->jmljasa_angsuran))',
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Jml Pembayaran',
						'type'=>'raw',
						'value'=>'(!empty($data->jmlpembayaran)) ? MyFormatter::formatNumberForPrint($data->jmlpembayaran) : "0"',
						'htmlOptions'=>array('style'=>'text-align:right'),
					), 
					array(
						'header'=>'Status Angsuran',
						'type'=>'raw',
						'value'=>'($data->isudahbayar)? "LUNAS":"BELUM LUNAS"',
					),
				),
			));
		?>
<table>
<tr>
	<td style="text-align:left">Tanggal Cetak : <?php echo MyFormatter::formatDateTimeId(date('d m Y')); ?></td>
	<td style="text-align:right">Dicetak Oleh : <?php echo Yii::app()->user->name; ?></td>
</tr>
</table>		