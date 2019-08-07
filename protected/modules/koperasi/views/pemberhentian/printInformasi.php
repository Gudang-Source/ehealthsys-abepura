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
<td style="text-align:center;padding-right:100px"><h1>
	<b>KOPERASI PEGAWAI REPUBLIK INDONESIA<br>
	<?php echo $profil->nama_profil; ?></b><br>
	<?php echo $profil->badanhukum; ?>
</h1>

</td>
</tr>
</table>
<hr class="symbol" />
<h1 style="text-align:center">
	<u>INFORMASI PEMBERHENTIAN ANGGOTA KOPERASI</u>
	<br/><?php if(strlen($periode) > 5){ echo "Periode : ".$periode;}?>
</h1>


<?php
					$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->searchPrint(),
					'filter'=>null,
					'template' => "{items}",
					'itemsCssClass' => 'tabel',
					'enableSorting'=>false,
          		'columns'=>array(
					array(
                'header' => 'No',
                'value' => '$row+1'
            	),
            	array(
							'header'=>'Tgl Berhenti',
							'type'=>'raw',
							'value'=>'date("d/m/Y H:i", strtotime($data->tglkeanggotaaan))',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
					array(
							'name'=>'tglkeanggotaaan',
							'type'=>'raw',
							'value'=>'date("d/m/Y H:i", strtotime($data->tglkeanggotaaan))',
							'filter'=>false,
						),
					array(
							'name'=>'lamamenjadi_anggota',
							'filter'=>false,
						),
					array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'$data->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
						),
					array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'type'=>'raw',
							'value'=>'$data->NamaGolongan',
							'filter'=>CHtml::activeDropDownList($anggota, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
						),
						'nokeanggotaan',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
						),
						array(
							'header'=>'Jml Simpanan',
							'value'=>'MyFormatter::formatNumberForPrint($data->jmlsimpanan_berhenti)',
							'htmlOptions'=>array('style'=>'text-align:right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a'),
						),
						array(
							'header'=>'Jml Tunggakan',
							'value'=>'MyFormatter::formatNumberForPrint($data->jmltunggakan_berhenti)',
							'htmlOptions'=>array('style'=>'text-align:right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a'),
						),
						array(
							'header'=>'Kas Masuk',
							'value'=>'',
							'htmlOptions'=>array('style'=>'text-align:right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a'),
						),
						array(
							'header'=>'Kas Keluar',
							'value'=>'',
							'htmlOptions'=>array('style'=>'text-align:right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a'),
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
