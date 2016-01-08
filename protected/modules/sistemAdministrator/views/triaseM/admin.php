<?php
$this->breadcrumbs=array(
		'Rdtriase Ms'=>array('index'),
		'Manage',
);

$arrMenu = array();
				(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Triase ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;

				// (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Triase', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
		$('.search-form').toggle();
	$('#SATriaseM_triase_nama').focus();
		return false;
});
$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('rdtriase-m-grid', {
				data: $(this).serialize()
		});
		return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
			'model'=>$model,
	)); ?>
</div><!-- search-form -->
<!--<div class="block-tabel">-->
	<!--<h6>Tabel <b>Triase</b></h6>-->
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'rdtriase-m-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-condensed',
		'columns'=>array(
				////'triase_id',
				array(
						'name'=>'triase_id',
						'value'=>'$data->triase_id',
						'filter'=>false,
				),
				'triase_nama',
				'triase_namalainnya',
				'warna_triase',
				'kode_warnatriase',
				'keterangan_triase',
				array(
					'header'=>'<center>Status</center>',
					'value'=>'($data->triase_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
					'htmlOptions'=>array('style'=>'text-align:center;'),
				),
				array(
						'header'=>Yii::t('zii','View'),
						'class'=>'bootstrap.widgets.BootButtonColumn',
						'template'=>'{view}',
						'buttons'=>array(
						'view' => array (
										  'options'=>array('title'=>'Lihat triase'),
										),
						),
				),
				array(
						'header'=>Yii::t('zii','Update'),
						'class'=>'bootstrap.widgets.BootButtonColumn',
						'template'=>'{update}',
						'buttons'=>array(
							'update' => array (
										  'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
										  'options'=>array('title'=>'Ubah triase'),
										),
						 ),
				),
				array(
					'header'=>Yii::t('zii','Delete'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{remove} {add} {delete}',
					'buttons'=>array(
						'remove' => array (
								'label'=>"<i class='icon-form-silang'></i>",
								'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->triase_id))',
								'click'=>'function(){nonActive(this);return false;}',
								'visible'=>'(($data->triase_aktif)? TRUE : FALSE)'
						),
						'add' => array (
								'label'=>"<i class='icon-form-check'></i>",
								'options'=>array('title'=>Yii::t('mds','Add Temporary')),
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->triase_id))',
								'click'=>'function(){active(this);return false;}',
								'visible'=>'(($data->triase_aktif)? FALSE : TRUE)'
						),
						'delete'=> array(),
					)
				),
		),
	   'afterAjaxUpdate'=>'function(id, data){
			jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			$("table").find("input[type=text]").each(function(){
				cekForm(this);
			})
		}',
	)); ?>
    <?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Triase',array('{icon}'=>'<i class="icon-plus icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/create'), 
                                array('class'=>'btn btn-success'));
    echo "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'create','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#rdtriase-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rdtriase-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
<!--</div>-->
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
							$.fn.yiiGridView.update('rdtriase-m-grid');
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
							$.fn.yiiGridView.update('rdtriase-m-grid');
							if(data.sukses > 0){
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

    $(document).ready(function(){
        $('input[name="SATriaseM[triase_nama]"]').focus();
    })
</script>