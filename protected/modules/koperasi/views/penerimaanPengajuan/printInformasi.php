<style>	
		h1{
		font-size: 16px;
		margin-top: 0px;
	}
.header{
		text-align: center;
		padding-right: 100px;
	}
	hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
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
	border:1px solid black;
        padding: 5px !important;
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
		<u>INFORMASI PENGAJUAN PEMOTONGAN</u><br/>
		<?php if(!empty($periode)) echo "Tgl Periode : ".$periode;?>
</h1>
	
<?php	
			$provider = $penerimaanPemotongan->searchPrint();
			$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
				'id'=>'penerimaanpemotongan-m-grid',
				'dataProvider'=>$provider,
				'filter'=>null,
				'enableSorting'=>false,
				'template' => "{items}",
				'summaryText'=>'',
				'itemsCssClass' => 'tabel',
				'columns'=>array(
					array(
                'header' => 'No',
                'value' => '$row+1',
                'footer' => 'GRAND TOTAL',
                'footerHtmlOptions'=>array('colspan'=>6, 'style'=>'text-align:right;font-weight: bold; '),
           	 ), 
            array(
						'header'=>'Tgl BKM /<br/>No BKM',
						'name'=>'tglbuktibayar',
						'type'=>'raw',
						'value'=>'date("d/m/Y H:i", strtotime($data->tglbuktibayar))."<br/>".$data->nobuktimasuk',
						//'footer'=>'<b>GRAND TOTAL</b>',
           			//'footerHtmlOptions'=>array('style'=>'text-align:right;','colspan'=>'5'),					
					), /*
					array(
						'header'=>'No BKM',
						'name'=>'nobuktimasuk',
					), */
					array(
						'name'=>'namaunit',
						'headerHtmlOptions'=>array('style'=>'vertical-align:middle;color:#373E4A'),
						),
					'namapotongan',
					'nokeanggotaan',
					array(
						'header'=>'Nama Anggota',
						'name'=>'nama_pegawai',
						),
					array(
						'name'=>'simpananwajib',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpananwajib)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						'footer'=>MyFormatter::formatNumberForPrint($penerimaanPemotongan->getTotSW($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
						'name'=>'simpanansukarela',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpanansukarela)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						'footer'=>MyFormatter::formatNumberForPrint($penerimaanPemotongan->getTotSS($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
						'header'=>'Pokok Angsuran',
						'name'=>'jmlpokok_byrangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpokok_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						'footer'=>MyFormatter::formatNumberForPrint($penerimaanPemotongan->getTotPA($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
						'header'=>'Jasa Angsuran',
						'name'=>'jmljasa_byrangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmljasa_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						'footer'=>MyFormatter::formatNumberForPrint($penerimaanPemotongan->getTotJA($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
						'header'=>'Denda Angsuran',
						'name'=>'jmldenda_byrangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmldenda_byrangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						'footer'=>MyFormatter::formatNumberForPrint($penerimaanPemotongan->getTotDA($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
						'header'=>'Total Pengajuan',
						'name'=>'jmlpengajuan_pengangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpengajuan_pengangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						'footer'=>MyFormatter::formatNumberForPrint($penerimaanPemotongan->getTotPengajuan($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
						'header'=>'Total Potongan',
						'name'=>'jmlbayar_pembangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlbayar_pembangsuran)',
						'htmlOptions'=>array('style'=>'text-align: right'),
						'footer'=>MyFormatter::formatNumberForPrint($penerimaanPemotongan->getTotPotongan($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),
					),
					array(
						'header'=>'Sisa',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpengajuan_pengangsuran - $data->jmlbayar_pembangsuran)',					
						'htmlOptions'=>array('style'=>'text-align: right'),
						'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
						'footer'=>MyFormatter::formatNumberForPrint($penerimaanPemotongan->getTotSisa($provider)),
						'footerHtmlOptions'=>array('style'=>'text-align:right;'),					
					)
					/*
					array(
						'header'=>'Penangguhan',
						'type'=>'raw',
						'value'=>function($data) {
							return CHtml::link('<i class="entypo-publish"></i>', Yii::app()->controller->createUrl('penangguhan', array('id'=>1)), array('target'=>'_blank'));
						},
						'htmlOptions'=>array('style'=>'text-align: center'),
					),	*/			
				),
				//'afterAjaxUpdate'=>'function(id, data) {registerNum(); hitungTotalAngsuran(); }',
			));
		?>
<table>
<tr>
	<td style="text-align:left">Tanggal Cetak : <?php echo MyFormatter::formatDateTimeId(date('d m Y')); ?></td>
	<td style="text-align:right">Dicetak Oleh : <?php echo Yii::app()->user->name; ?></td>
</tr>
</table>