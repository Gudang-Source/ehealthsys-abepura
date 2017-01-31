<?php
$this->breadcrumbs=array(
	'Saalatmedis Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('saalatmedis-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
	<legend class="rim2">Pengaturan <b>Alat Medis</b></legend>
	<?php 
	if (!empty($_GET['sukses'])){
		$this->widget('bootstrap.widgets.BootAlert'); 
		Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
	}
	?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut2 search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
	<!--<div class="block-tabel">-->
		<!--<h6 class="rim2">Tabel Alat Medis</h6>-->
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'saalatmedis-m-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
		array(
			'name'=>'instalasi_id',
			'type'=>'raw',
			'value'=>'$data->instalasi->instalasi_nama',
			'filter'=> Chtml::activeDropDownList($model, 'instalasi_id', CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --')),
		),
		array(
			'name'=>'jenisalatmedis_id',
			'type'=>'raw',
			'value'=>'$data->jenisalatmedis->jenisalatmedis_nama',
			'filter'=>Chtml::activeDropDownList($model, 'jenisalatmedis_id',  CHtml::listData($model->JenisalatmedisItems, 'jenisalatmedis_id', 'jenisalatmedis_nama'), array('empty' => '-- Pilih --')),
		),
                array(
                    'header' => 'No Aset',
                    'name' => 'alatmedis_noaset',
                    'filter' => Chtml::activeTextField($model, 'alatmedis_noaset', array('class' => 'numbers-only'))
                ),
		array(
                     'header' => 'Nama',
                    'name' => 'alatmedis_nama',
                    'filter' => Chtml::activeTextField($model, 'alatmedis_nama', array('class' => 'kode-alatmedis'))
                ),
		array(
                     'header' => 'Nama Lain',
                    'name' => 'alatmedis_namalain',
                    'filter' => Chtml::activeTextField($model, 'alatmedis_namalain', array('class' => 'hurufs-only'))
                ),
                array(
                     'header' => 'Kode',
                    'name' => 'alatmedis_kode',
                    'filter' => Chtml::activeTextField($model, 'alatmedis_kode', array('class' => 'numbers-only'))
                ),		
                array(
                     'header' => 'Format',
                    'name' => 'alatmedis_format',
                    'filter' => Chtml::activeTextField($model, 'alatmedis_format', array('class' => 'numbers-only'))
                ),		
		/*
		'alatmedis_aktif',
		
		*/
			array(
				'header'=>'Status',
				'value' => '($data->alatmedis_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
			), 
			array(
				'header'=>Yii::t('zii','View'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{view}',
				'buttons'=>array(
					'view' => array(),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Update'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{update}',
				'buttons'=>array(
					'update' => array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Delete'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
                                'htmlOptions'=>array('style'=>'width:80px;'),
				'template'=>'{remove}{add}{delete}',
				'buttons'=>array(
					'remove' => array (
							'label'=>"<i class='icon-form-silang'></i>",
							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->alatmedis_id))',
							'click'=>'function(){nonActive(this);return false;}',
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
					),
					'add' => array (
										'label'=>"<i class='icon-form-check'></i>",
										'options'=>array('title'=>Yii::t('mds','Add Temporary')),
										'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->alatmedis_id))',
										'click'=>'function(){active(this);return false;}',
										'visible'=>'(($data->alatmedis_aktif) ? FALSE : TRUE)',
								 ),
					'delete'=> array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
					),
				)
			),
		),
		'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                });
                 $("table").find("select").each(function(){
                    cekForm(this);
                });
                $(".kode-alatmedis").keyup(function() {
                    setKodeAlatMedis(this);
                });
                $(".hurufs-only").keyup(function() {
                    setHurufsOnly(this);
                });
            }',
	)); ?>
<!--</div>-->
<?php 
	echo CHtml::link(Yii::t('mds','{icon} Tambah Alat Medis',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	 $content = $this->renderPartial('sistemAdministrator.views.tips.master',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saalatmedis-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div>
<script type="text/javascript">	
	function cekForm(obj)
	{
		 $("#saalatmedis-m-search :input[name='"+obj.name+"']").val(obj.value);
	}
	
	function nonActive(obj){
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('saalatmedis-m-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dinonaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
	
	function active(obj){
		myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('saalatmedis-m-grid');
							if(data.sukses > 0){
								myAlert('Data berhasil diaktifkan!');
							}else{
								myAlert('Data gagal diaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal diaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>