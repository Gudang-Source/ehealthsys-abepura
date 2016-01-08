<div class="white-container">
	<legend class='rim2'>Pengaturan <b>Tipe Paket</b></legend>
<?php
$this->breadcrumbs=array(
	'SatipePaket Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Paket ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tipe Paket', 'icon'=>'list', 'url'=>array('index'))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Paket', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#satipe-paket-m-search').submit(function(){
	$.fn.yiiGridView.update('satipe-paket-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial($this->path_view.'_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<!--<legend class='rim2'>Tabel <b>Tipe Paket</b></legend>-->
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'satipe-paket-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'tipepaket_id',
//		array(
//                        'name'=>'tipepaket_id',
//                        'value'=>'$data->tipepaket_id',
//                        'filter'=>false,
//                ),
		array(
                        'name'=>'carabayar_id',
                        'filter'=>  CHtml::listData(SAPendaftaranT::model()->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'),
                        'value'=>'$data->carabayar->carabayar_nama',
                ),
		array(
                        'name'=>'penjamin_id',
                        'filter'=>  CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = TRUE'), 'penjamin_id', 'penjamin_nama'),
                        'value'=>'$data->penjamin->penjamin_nama',
                ),
		array(
                        'name'=>'kelaspelayanan_id',
                        'filter'=>  CHtml::listData(SAPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                ),
		'tipepaket_nama',
		'tipepaket_singkatan',
                array(
                    'header'=>'Tarif Paket',
                    'name'=>'tarifpaket',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatUang($data->tarifpaket)',
                ),
//                'tarifpaket',
		/*
		'tipepaket_namalainnya',
		'tglkesepakatantarif',
		'nokesepakatantarif',
		
		'paketsubsidiasuransi',
		'paketsubsidipemerintah',
		'paketsubsidirs',
		'paketiurbiaya',
		'nourut_tipepaket',
		'keterangan_tipepaket',
		'tipepaket_aktif',
		*/
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->tipepaket_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//                array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',
//                        'selectableRows'=>0,
//                        'checked'=>'$data->tipepaket_aktif',
//                ),
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view' => array(
                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Tipe Paket' ),
                            ),
                         ),
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                                        'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Tipe Paket' ),
                                        'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                         ),
		),
		array(
			'header'=>Yii::t('zii','Delete'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{remove} {delete}',
			'buttons'=>array(
			
				'remove' => array (
						'label'=>"<i class='icon-remove'></i>",
						'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
						'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>$data->tipepaket_id))',
						'click'=>'function(){removeTemporary(this);return false;}',
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
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
)); ?>

<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Tipe Paket', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
      $content = $this->renderPartial('sistemAdministrator.views.tips.master',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#satipe-paket-m-search :input[name='"+obj.name+"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#satipe-paket-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
</div>
<script type="text/javascript">
    function removeTemporary(obj){
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('satipe-paket-m-grid');
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
</script>