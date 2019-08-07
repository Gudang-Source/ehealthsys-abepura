<?php
$this->breadcrumbs=array(
	'Profil'=>array('/admin/ProfilS/'),
	'Kelola',
);

$this->menu=array(
	array('label'=>'List Profil','url'=>array('index')),
	array('label'=>'Buat Baru Profil','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('adprofil-s-grid', {
		data: $(this).serialize()
	});
	return false;
	});
");
?>


<div class="col-md-12">
	<div class="panel panel-primary" data-collapsed="0">
		<div class="panel-heading">
			<div class="panel-title"> Kelola Profil </div>  
		</div>
		<div class='panel-body'>

		<?php echo CHtml::link('Pencarian <i class="entypo-down-open"></i>','#',array('class'=>'search-button btn')); ?>			<div class="search-form" style="display:none">
					<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
			</div><!-- search-form -->
		</div>
		<div class="panel-body">
		<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'adprofil-s-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'itemsCssClass' => 'table-bordered datatable dataTable',
		'columns'=>array(
			array(
			'name'=>'profilperusahaan_id',
			'value'=>'$data->profilperusahaan_id',
			'htmlOptions'=>array('width'=>'70px;'),
			'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:center;color:#373e4a;'),
			),
			array(
			'name'=>'nama_profil',
			'value'=>'$data->nama_profil',
			'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:center;color:#373e4a;'),
			),
			array(
			'name'=>'alamat_profil',
			'type'=>'raw',
			'value'=>'$data->alamat_profil',
			'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:center;color:#373e4a;'),
			),
			array(
			'name'=>'propinsi_profil',
			'value'=>'$data->propinsi_profil',
			'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:center;color:#373e4a;'),
			),
			array(
			'name'=>'kota_kab_profil',
			'value'=>'$data->kota_kab_profil',
			'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:center;color:#373e4a;'),
			),
			array(
			'name'=>'telp_profil',
			'value'=>'$data->telp_profil',
			'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:center;color:#373e4a;'),
			),
		/*
		'fax_profil',
		'email_profil',
		'visi_profil',
		'misi_profil',
		'waktu_layanan',
		'textinfo1',
		'textinfo2',
		'textinfo3',
		'textinfo4',
		'valuestext1',
		'valuestext2',
		'valuestext3',
		'path_valuesimage1',
		'path_valuesimage2',
		'path_valuesimage3',
		'longitude',
		'latitude',
		*/
			array(
			'header'=>'Aksi',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('width'=>'75px;'),
			'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:center;color:#373e4a;'),
			),
		),
		)); ?>
		</div>
		<div class='panel-footer'>
			<?php echo Chtml::link('<i class="entypo-plus"></i> Profil',$this->createUrl('/admin/ProfilS/create'), array('class' => 'btn btn-success')); ?>		</div>
	</div>
</div>