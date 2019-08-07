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
    	border-collapse: collapse;
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
	<u>INFORMASI ANGGOTA KOPERASI</u>
</h1>


<?php
					$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->searchPrint(),
					'filter'=>null,
					'template' => "{items}",
					'itemsCssClass' => 'tabel',
					'enableSorting'=>false,
          		'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Berhenti/dipecat sebagai anggota</center>',
                        'start'=>9, //indeks kolom 3
                        'end'=>11, //indeks kolom 4
                    ),
                ),
					'columns'=>array(
					array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            	),
            	array(
							'header'=>'Tgl Keanggotaan',
							'type'=>'raw',
							'value'=>'date("d/m/Y H:i", strtotime($data->tglkeanggotaaan))',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px')
						), 
						array(
							'name'=>'nokeanggotaan',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px')
             ),
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px')
						),	
						array(
							'header'=>'Umur',
							'type'=>'raw',
							'value'=>'Params::getUmur($data->tgl_lahirpegawai)." Thn"',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px')
						),
						// 'pegawai.tempatlahir_pegawai',
						array(
							'header'=>'Jenis Kelamin',
							'name'=>'jeniskelamin',
							'value'=>'$data->jeniskelamin',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px')
							//'filter'=>Params::getJenisKelamin(),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
							'value'=>'$data->alamat_pegawai',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px')
						),
						array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'$data->namaunit',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px')
							//'filter'=>CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true','order'=>'namaunit asc')), 'unit_id', 'namaunit'),
						),
						array(
							'header'=>'Golongan',
							'type'=>'raw',
							'value'=>function ($data) {
									$id = PegawaiM::model()->findByPk($data->pegawai_id);
									$golongan = GolonganpegawaiM::model()->findByPk($id->golonganpegawai_id);
									return $golongan->golonganpegawai_nama;
								}						
						),
						array(
							'header'=>'Jabatan',
							'name'=>'jabatan_id',
							'value'=>'$data->jabatan_nama',
						),
						array(
							'header'=>'Tgl minta berhenti',
							'type'=>'raw',
							'value'=>'!empty($data->tglpermintaanberhenti) ? date("d/m/Y", strtotime($data->tglpermintaanberhenti)):""',
							//'value'=>'empty($data->tglberhentikeanggotaan)?"-":date("d/m/Y H:i", strtotime($data->tglberhentikeanggotaan))',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px')
						), 
						array(
							'header'=>'Tgl berhenti/dipecat',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px'),
							'value'=>'!empty($data->tglberhenti_dipecat) ? date("d/m/Y", strtotime($data->tglberhenti_dipecat)):""',						
						),
						array(
							'header'=>'Sebabnya berhenti/dipecat',
							'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
							//'htmlOptions'=>array('style'=>'text-align:center;vertical-align:middle;','height'=>'100px'),
							'value'=>'$data->sebabberhenti',						
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