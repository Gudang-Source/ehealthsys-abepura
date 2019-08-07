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
    	border-collapse: collapse;
	}
	.tabel td, 	th{
		border:1px solid black;
                padding: 5px !important;
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
		<u>INFORMASI PENGAJUAN PEMOTONGAN</u><br />
<?php if (!empty($pengajuanPemotongan->tglAwal) && !empty($pengajuanPemotongan->tglAkhir)) {
			echo "Periode : ".MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($pengajuanPemotongan->tglAwal)))." - ".MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($pengajuanPemotongan->tglAkhir)))."<br>";
		} ?>
</h1>
		

		<?php 
		$provider = $pengajuanPemotongan->search();
		$provider->pagination = false;
		$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
				'id'=>'pengajuanpemotongan-m-grid',
				'dataProvider'=>$provider,
				'filter'=>null,
				'enableSorting'=>false,
				'template' => "{items}",
				'itemsCssClass' => 'tabel',
				'columns'=>array(
					array(
                'header' => 'No',
                'value' => '$row+1',
                'footer' => 'Total',
                'footerHtmlOptions'=>array('colspan'=>5, 'style'=>'text-align:right;font-weight: bold; '),
            ), 
            array(
						'header'=>'Tgl Pengajuan / <br/> No Pengajuan',
						'type'=>'raw',
						'value'=>'date("d/m/Y", strtotime($data->tglpengajuanpemb))."<br/>".$data->nopengajuan',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						//'footer'=>'Total',
						//'footerHtmlOptions'=>array('style'=>'font-weight:bold;text-align:right','colspan'=>4),
					), /*
					array(
						'name'=>'nopengajuan',
						'headerHtmlOptions'=>array('style'=>'text-align:center')
						), */
					array(
						'name'=>'namaunit',
						'header'=>'Unit',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
					), 
					array(
						'header'=>'Sumber Potongan',
						'name'=>'namapotongan',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
					),
					array(
						'header'=>'No Anggota /<br/> Nama Anggota',
						'type'=>'raw',
						'name'=>'nokeanggotaan',
						'value'=>'$data->nokeanggotaan."<br/>".$data->nama_pegawai',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
					), 
					/*array(
						'header'=>'Nama Anggota',
						'name'=>'nama_pegawai',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
					),*/ 
					array(
						'header'=>'Simpanan Wajib',
						'name'=>'simpananwajib',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpananwajib)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($pengajuanPemotongan->getTotalCol($provider, 'simpananwajib')),
						'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight:bold;'),
					),
					array(
						'header'=>'Simpanan Sukarela',
						'name'=>'simpanansukarela',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpanansukarela)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($pengajuanPemotongan->getTotalCol($provider, 'simpanansukarela')),
						'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight:bold;'),
					),
					array(
						'header'=>'Pokok Angsuran',
						'name'=>'jmlpokok_pengangs',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpokok_pengangs)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($pengajuanPemotongan->getTotalCol($provider, 'jmlpokok_pengangs')),
						'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight:bold;'),
					),
					array(
						'header'=>'Jasa Angsuran',
						'name'=>'jmljasaangs_pengangs',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmljasaangs_pengangs)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($pengajuanPemotongan->getTotalCol($provider, 'jmljasaangs_pengangs')),
						'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight:bold;'),
					),
					array(
						'header'=>'Denda Angsuran',
						'name'=>'jmldendaangs_pengangs',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmldendaangs_pengangs)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($pengajuanPemotongan->getTotalCol($provider, 'jmldendaangs_pengangs')),
						'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight:bold;'),
					),
					array(
						'header'=>'Total Pengajuan',
						'name'=>'jmlpengajuan_pengangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpengajuan_pengangsuran)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($pengajuanPemotongan->getTotalCol($provider, 'jmlpengajuan_pengangsuran')),
						'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight:bold;'),
					), /*
					array(
						'header'=>'Total Potongan',
						'name'=>'jmlbayar_pembangsuran',
						'value'=>'MyFormatter::formatNumberForPrint(empty($data->jmlbayar_pembangsuran)?"0":$data->jmlbayar_pembangsuran)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($pengajuanPemotongan->getTotalCol($provider, 'simpananwajib')),
						'footerHtmlOptions'=>array('style'=>'text-align:right'),
					), */			
				),
				//'afterAjaxUpdate'=>'function(id, data) {registerNum(); hitungTotalAngsuran(); }',
			)); ?>		
<table>
<tr>
	<td style="text-align:left">Tanggal Cetak : <?php echo MyFormatter::formatDateTimeId(date('d m Y')); ?></td>
	<td style="text-align:right">Dicetak Oleh : <?php echo Yii::app()->user->name; ?></td>
</tr>
</table>