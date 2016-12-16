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
		width: 1200px;
		font-size: 11px;
   	margin-left: auto;
    	margin-right: auto;
	}
	.tabel td, 	th{
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
<center>
	<h1><u>INFORMASI PENERIMAAN POTONGAN</u></h1>
</center>
<table>
	<tr>
		<td width="10%">
			Tanggal BKM
		</td>
		<td>: <?php echo MyFormatter::formatDateTimeId($header['tglbuktibayar']); ?></td>
		<td style="text-align:right">
			Tanggal Pengajuan
		</td>
		<td width="10%"> : <?php echo MyFormatter::formatDateTimeId($header['tglpengajuanpemb']); ?></td>
	</tr>
	<tr>
		<td>
			No BKM
		</td>
		<td> : <?php echo $header['nobuktimasuk']; ?></td>
		<td style="text-align:right">
			No Pengajuan
		</td>
		<td> : <?php echo $header['nopengajuan']; ?></td>
	</tr>
	<tr>
		<td>
		Tanggal Cetak
		</td>
		<td> : <?php echo MyFormatter::formatDateTimeId(date('d m Y')); ?></td>
		<td style="text-align:right">
			Sumber Potongan
		</td>
		<td> : <?php echo $header['namapotongan']; ?></td>
	</tr>
	<tr>
		<td>
		Dicetak Oleh
		</td>
		<td> : <?php echo Yii::app()->user->name; ?></td>
		<td style="text-align:right">
			Total Potongan
		</td>
		<td> : <?php echo MyFormatter::formatNumberForPrint($header['jmlbayar_pembangsuran']); ?></td>
	</tr>
</table>



<?php
			$provider = $model->searchPrint();
			$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
				'id'=>'laporan-m-grid',
				'dataProvider'=>$provider,
				'filter'=>null,
				'template' => "{items}",
				'summaryText'=>'',
				'itemsCssClass' => 'tabel',
				'columns'=>array(
					/*array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            	), */
            	array(
						'header'=>'Unit',
						'type'=>'raw',
						'value'=>'$data->namaunit',
						'footer'=>'<b>GRAND TOTAL</b>',
           			'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>'3'),
           		),
					array(
						'header'=>'No Anggota',
						'type'=>'raw',
						'value'=>'$data->nokeanggotaan',
					),
					array(
						'header'=>'Nama Anggota',
						'type'=>'raw',
						'value'=>'$data->nama_pegawai',
					),
					array(
						'header'=>'Simpanan Wajib',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpananwajib)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($model->getTotSW($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
						),
					array(
						'header'=>'Simpanan Sukarela',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpanansukarela)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($model->getTotSS($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
						),
					array(
						'header'=>'Pokok Angsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpokok_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($model->getTotPA($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
						),
					array(
						'header'=>'Jasa Angsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmljasa_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($model->getTotJA($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
						),
					array(
						'header'=>'Denda Angsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmldenda_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($model->getTotDA($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
						),
					array(
						'header'=>'Total Pengajuan',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpengajuan_pengangsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($model->getTotPengajuan($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
						),
					array(
						'header'=>'Total Potongan',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlbayar_pembangsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($model->getTotPotongan($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
						),
					array(
						'header'=>'Sisa',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlsisa_pembangsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($model->getTotSisa($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
						),
				),
			));
		?> 
	</div>
</div>
