<?php
$this->breadcrumbs=array(
	'Kporganigram Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('kporganigram-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
	<!--<div class="block-tabel">-->
		<!--<h6 class="rim2">Tabel Organigram</h6>-->
	<?php                      
            $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'kporganigram-m-grid',
		'dataProvider'=>$model->searchTable(),
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
			'organigram_kode',
			array(
				'name'=>'organigramasal_id',
				'value'=>'isset($data->organigramasal->pegawai->nama_pegawai) ? $data->organigramasal->pegawai->nama_pegawai : (isset($data->organigramasal->organigram_unitkerja) ? $data->organigramasal->organigram_unitkerja : "-")',
				'filter'=>CHtml::activeTextField($model, 'atasan'),
			),
			'organigram_unitkerja',
			'organigram_formasi',
			array(
                                'header' => 'Nama Pegawai',
				'name'=>'nama_pegawai',
                                'value' => '$data->pegawai->nama_pegawai',
				'filter'=>CHtml::activeTextField($model, 'nama_pegawai'),
			),
			array(
                               // 'name' => 'jabatan_id',
                                'header' => 'Jabatan',
                                'name'=>'jabatan_id',
				'value'=>'isset($data->jabatan_id)?"$data->Jabatan":"-"',
				'filter'=>CHtml::activeDropDownList($model, 'jabatan_id',  CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
			),
			'organigram_pelaksanakerja',
			//'organigram_periode',
                        array(
                            'header' => 'Periode',
                            'name' => 'organigram_periode',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_periode)'
                        ),
			//'organigram_sampaidengan',
                     array(
                            'header' => 'Sampai Dengan',
                            'name' => 'organigram_sampaidengan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_sampaidengan)'
                        ),
			array(
				'name'=>'organigram_urutan',
				'filter'=>false,
			),
                        array(
                            'header' => 'Status',
                            'value' => '($data->organigram_aktif)?"Aktif":"Tidak Aktif"'
                        ),
		/*
		'organigram_periode',
		'organigram_sampaidengan',
		'organigramasal_id',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'organigram_aktif',
		'organigram_urutan',
		'pegawai_id',
		*/
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
							'click'=>'function(){ubahData(this);return false;}',
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Delete'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{remove} {delete}',
                                'htmlOptions'=>array('style'=>'width:80px;'),
				'buttons'=>array(
					'remove' => array (
							'label'=>"<i class='icon-form-silang'></i>",
							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->organigram_id))',
							'click'=>'function(){nonActive(this);return false;}',
							'visible'=>'($data->organigram_aktif)?true:false',
					),
					'delete'=> array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
					),
				)
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>
<!--</div>-->
<?php 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	//$this->widget('UserTips',array('content'=>''));
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>

<script type="text/javascript">	
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
							$.fn.yiiGridView.update('kporganigram-m-grid');
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
	
	/**
	 * ubah data organigram
	 * @param {type} obj
	 * @returns {Boolean}
	 */
	function ubahData(obj){
		parent.window.location.href = obj.href;
		return false;
	}
	
</script>