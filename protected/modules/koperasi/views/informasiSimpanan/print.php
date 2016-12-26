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
		font-size: 14px;
   	margin-left: auto;
    	margin-right: auto;
    	border-collapse: collapse;
        width: 100%;
	}
        th {
            text-align: center !important;
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
<?php
$provider = $model->searchPrint();
echo CHtml::image(Params::urlProfilGambar().$profil->path_valuesimage1, '', array('width'=>50)); ?>
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
	<u>INFORMASI SIMPANAN ANGGOTA</u>
</h1>

<div style="text-align:left;">
	<?php if(!empty($periode)){ echo "Periode : ".$periode;}?><br/>
	<?php echo "Total Simpanan Keseluruhan : ".MyFormatter::formatNumberForPrint($model->getTotalSemua($provider)); ?>
</div>

<?php
		$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
		'id'=>'pegawai-m-grid',
		'dataProvider'=>$provider,
		'itemsCssClass' => 'tabel',
		'summaryText'=>'',
		'columns'=>array(
		  array(
                'header' => 'No',
                'value' => '$row+1',
                'type'=>'raw',
					 'footer'=>'<b>GRAND TOTAL</b>',
					 'footerHtmlOptions'=>array('colspan'=>7,'style'=>'text-align:right'),
            ),
            array(
            	'name'=>'tglsimpanan',
            	'value'=>'date("d/m/Y", strtotime($data->tglsimpanan))',
            	),
            'nosimpanan',
				'nokeanggotaan',
				'nama_pegawai',
				array(
					'name'=>'namaunit',
					'filter'=>Chtml::listData(UnitM::model()->findAll(),'namaunit','namaunit'),
					),
				array(
					'header'=>'Golongan',
					'name'=>'golonganpegawai_id',
					'filter'=>CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'),
					'value'=>'$data->golonganpegawai_nama',
					),
				array(
					'header'=>'Simpanan <br/> Pokok',
					'type'=>'raw',
					'value'=>function ($data) {
							if(strtolower($data->jenissimpanan) == 'pokok') {
									return number_format($data->jumlahsimpanan,0,",",".");
								}
								return 0;
						},
					'htmlOptions'=>array('style'=>'text-align:right'),
					'headerHtmlOptions'=>array('style'=>'text-align:center'),
					'footer'=>MyFormatter::formatNumberForPrint($model->getTotalSP($provider)),
					'footerHtmlOptions'=>array('style'=>'text-align:right'),
				),
				array(
					'header'=>'Simpanan <br/> Wajib',
					'value'=>function ($data) {
							if(strtolower($data->jenissimpanan) == 'wajib') {
									return number_format($data->jumlahsimpanan,0,",",".");
								}
								return 0;
						},
					'htmlOptions'=>array('style'=>'text-align:right'),
					'headerHtmlOptions'=>array('style'=>'text-align:center'),
					'footer'=>MyFormatter::formatNumberForPrint($model->getTotalSW($provider)),
					'footerHtmlOptions'=>array('style'=>'text-align:right'),
				),
				array(
					'header'=>'Simpanan <br/> Sukarela',
					'value'=>function ($data) {
							if(strtolower($data->jenissimpanan) == 'sukarela') {
									return number_format($data->jumlahsimpanan,0,",",".");
								}
								return 0;
						},
					'htmlOptions'=>array('style'=>'text-align:right'),
					'headerHtmlOptions'=>array('style'=>'text-align:center'),
					'footer'=>MyFormatter::formatNumberForPrint($model->getTotalSS($provider)),
					'footerHtmlOptions'=>array('style'=>'text-align:right'),
				),
				array(
					'header'=>'Simpanan <br/> Deposit',
					'value'=>function ($data) {
							if(strtolower($data->jenissimpanan) == 'deposito') {
									return number_format($data->jumlahsimpanan,0,",",".");
								}
								return 0;
						},
					'htmlOptions'=>array('style'=>'text-align:right'),
					'headerHtmlOptions'=>array('style'=>'text-align:center'),
					'footer'=>MyFormatter::formatNumberForPrint($model->getTotalSD($provider)),
					'footerHtmlOptions'=>array('style'=>'text-align:right'),
				), /*
				array(
					'header'=>'Simpanan <br/> Lain - Lain',
					'value'=>function ($data) {
							if(strtolower($data->jenissimpanan) == 'lain') {
									return number_format($data->jumlahsimpanan,0,",",".");
								}
								return 0;
					},
					'htmlOptions'=>array('style'=>'text-align:right'),
					'headerHtmlOptions'=>array('style'=>'text-align:center;width:100px;'),
					'footer'=>MyFormatter::formatNumberForPrint($model->getTotalSP($provider) + $model->getTotalSW($provider) + $model->getTotalSS($provider) + $model->getTotalSD($provider)),
					'footerHtmlOptions'=>array('style'=>'text-align:right'),
				), */
			),
		)); ?>
<table>
<tr>
	<td style="text-align:left">Tanggal Cetak : <?php echo MyFormatter::formatDateTimeId(date('d m Y')); ?></td>
	<td style="text-align:right">Dicetak Oleh : <?php echo Yii::app()->user->name; ?></td>
</tr>
</table>
