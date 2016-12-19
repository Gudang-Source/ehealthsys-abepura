<?php
$this->breadcrumbs=array(
	'Profil'=>array('/admin/ProfilS/'),
	'Detail',
);

$this->menu=array(
	array('label'=>'List Profil','url'=>array('index')),
	array('label'=>'Buat Baru Profil','url'=>array('create')),
	array('label'=>'Pembaharuan Profil','url'=>array('update','id'=>$model->profilperusahaan_id)),
	array('label'=>'Hapus Profil','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->profilperusahaan_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Kelola Profil','url'=>array('admin')),
);
?>

<div class="col-md-12">
	<div class="panel panel-primary" data-collapsed="0">
		<div class="panel-body">
			<?php $this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$model,
				'attributes'=>array(
							'profilperusahaan_id',
		'nama_profil',
							array(
								'name'=>'alamat_profil',
								'type'=>'raw',
								'value'=>$model->alamat_profil,
							),
		'propinsi_profil',
		'kota_kab_profil',
		'telp_profil',
		'fax_profil',
		'email_profil',
							array(
								'name'=>'visi_profil',
								'type'=>'raw',
								'value'=>$model->visi_profil,
							),
							array(
								'name'=>'misi_profil',
								'type'=>'raw',
								'value'=>$model->misi_profil,
							),
							array(
								'name'=>'waktu_layanan',
								'type'=>'raw',
								'value'=>$model->waktu_layanan,
							),
							array(
								'name'=>'textinfo1',
								'type'=>'raw',
								'value'=>$model->textinfo1,
							),
							array(
								'name'=>'textinfo2',
								'type'=>'raw',
								'value'=>$model->textinfo2,
							),
							array(
								'name'=>'textinfo3',
								'type'=>'raw',
								'value'=>$model->textinfo3,
							),
							array(
								'name'=>'textinfo4',
								'type'=>'raw',
								'value'=>$model->textinfo4,
							),
							array(
								'name'=>'valuestext1',
								'type'=>'raw',
								'value'=>$model->valuestext1,
							),
							array(
								'name'=>'valuestext2',
								'type'=>'raw',
								'value'=>$model->valuestext2,
							),
							array(
								'name'=>'valuestext3',
								'type'=>'raw',
								'value'=>$model->valuestext3,
							),
                            array(
                                'name'=>'path_valuesimage1',
                                'type'=>'raw',
                                'value'=>'<img src="'.Params::urlProfilGambar().$model->path_valuesimage1.'" width="200px" height="200px;">' ,
                            ),
                            array(
                                'name'=>'path_valuesimage2',
                                'type'=>'raw',
                                'value'=>'<img src="'.Params::urlProfilGambar().$model->path_valuesimage2.'" width="200px" height="200px;">' ,
                            ),
                            array(
                                'name'=>'path_valuesimage3',
                                'type'=>'raw',
                                'value'=>'<img src="'.Params::urlProfilGambar().$model->path_valuesimage3.'" width="200px" height="200px;">' ,
                            ),				
		'longitude',
		'latitude',
				),
			)); 
			?>

		</div>
		<div class="panel-footer">
			<?php echo Chtml::link('Kembali',$this->createUrl('/admin/ProfilS/admin'), array('class' => 'btn btn-link')); ?>		</div>
	</div>
</div>

