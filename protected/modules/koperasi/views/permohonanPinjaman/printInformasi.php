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
		<?php if ($model->cair == 1) : ?><u>INFORMASI PINJAMAN ANGGOTA</u><br>
		<?php else : ?><u>INFORMASI PERMOHONAN PINJAMAN ANGGOTA</u><br>
		<?php endif; ?>
		<?php if (!empty($model->tglAwal) && !empty($model->tglAkhir)) {
			echo "Periode : ".MyFormatter::formatDateTimeId(date('Y-m-d H:i:s', strtotime($model->tglAwal)))." - ".MyFormatter::formatDateTimeId(date('Y-m-d H:i:s', strtotime($model->tglAkhir)))."<br>";
		} ?>
</h1>



		<?php
		$total = 0;
		$provider = $model->searchPrint();
		$provider->criteria->order = 'nopermohonan asc';
		$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
		'id'=>'pegawai-m-grid',
		'dataProvider'=>$provider,
		'summaryText'=>'',
		'itemsCssClass' => 'tabel',
		'columns'=> array(
				array(
                'header' => 'No',
                'value' => '$row+1',
                'footer' => 'Total Pinjam',
                'footerHtmlOptions'=>array('colspan'=>7, 'style'=>'text-align:right;font-weight: bold; '),
            ),
            $model->cair == 1 ? array (
            	'name'=>'tglpinjaman',
            	'value'=>'date("d/m/Y", strtotime($data->tglpinjaman))',
            ) : array(
            	'name'=>'tglpermohonanpinjaman',
							'header'=>'Tgl Permohonan',
            	'value'=>'date("d/m/Y", strtotime($data->tglpermohonanpinjaman))',
            	),
            array(
            	'header'=>'No Permohonan',
            	'name'=>'nopermohonan',
            	'htmlOptions'=>array('style'=>'text-align:center'),
           	),
            array(
            	'name'=>'namaunit',
            	'header'=>'Unit',
            ),
           	array(
           		'name'=>'jenispinjaman_permohonan',
           		'htmlOptions'=>array('style'=>'text-align:center'),
           	),
            array(
            	'name'=>'nokeanggotaan',
            	'header'=>'Nomor Anggota',
            ),
            array(
            	'name'=>'nama_pegawai',
            	'header'=>'Nama Anggota',
            ),
            $model->cair == 1 ? array(
            	'name'=>'jmlpinjaman',
            	'type'=>'raw',
            	'value'=>function($data) {
            		return "Rp ".MyFormatter::formatNumberForPrint($data->jmlPinjamTerkini);
            	},
            	'htmlOptions'=>array('style'=>'text-align:right'),
            	'footer'=>"Rp ".MyFormatter::formatNumberForPrint($model->getTotalPinjaman($provider, true)),
            	'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
            ) : array(
            	'name'=>'jmlpinjaman',
            	'type'=>'raw',
            	'value'=>function($data) {
            		return "Rp ".MyFormatter::formatNumberForPrint($data->jmlpinjaman);
            	},
            	'htmlOptions'=>array('style'=>'text-align:right;width:100px;'),
            	'footer'=>"Rp ".MyFormatter::formatNumberForPrint($model->getTotalPinjaman($provider)),
            	'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
            ),
		),
		)); ?>
<table>
<tr>
	<td style="text-align:left">Tanggal Cetak : <?php echo MyFormatter::formatDateTimeId(date('d m Y')); ?></td>
	<td style="text-align:right">Dicetak Oleh : <?php echo Yii::app()->user->name; ?></td>
</tr>
</table>
