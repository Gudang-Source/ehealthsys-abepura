<div class="white-container">
    <legend class="rim2">Pengaturan <b>Kelas Ruangan</b></legend>
<?php // $this->renderPartial('_tab'); ?> 
<?php
$this->breadcrumbs=array(
	'Ppruangan Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelas Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelas Ruangan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#".CHtml::activeId($model,'instalasi_nama')."').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppruangan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php 

echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut2 search-form" style="display:none">
<?php $this->renderPartial($this->path_view.'_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<!--<div class="block-tabel">-->
    <!--<h6>Tabel Kelas Ruangan</h6>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'ppruangan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
                    'template'=>"{summary}\n{items}{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            array(
                                    'header'=>'Instalasi',
                                    'value'=>'$data->ruangan->instalasi->instalasi_nama',
                                    'filter'=>(Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) ? CHtml::activeTextField($model, 'instalasi_nama') : false,
                            ),
                            array(
                                    'name'=>'ruangan_id',
                                    'value'=>'$data->ruangan->ruangan_nama',
                                    'filter'=>(Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN) ? CHtml::activeTextField($model, 'ruangan_nama') : false,
                            ),
                            array(
                                    'header'=>'Kelas Pelayanan ',
                                    'type'=>'raw',
                                    'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                                    'filter'=> CHtml::activeDropDownList($model, 'kelaspelayanan_id', CHtml::listData(SAKelasPelayananM::model()->getItems(),'kelaspelayanan_id','kelaspelayanan_nama'),array('empty'=>''))
                            ), 
                            array(
                                    'header'=>Yii::t('zii','View'),
                                    'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array(
                                            'view'=>array(
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/View",array("id"=>"$data->ruangan_id"))',
                                                    'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Ruangan Pegawai' ),
                                            ),
                                    ),
                            ),
    //		UNTUK MAPPING INI TIDAK DIPERLUKAN UPDATE
    //		CUKUP CREATE / DELETE
    //		array(
    //                        'header'=>Yii::t('zii','Update'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //                        'template'=>'{update}',
    //                        'buttons'=>array(
    //                            'update' => array (
    //                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
    //                                           'options'=>array('rel'=>'tooltip','title'=>'Ubah Kelas Ruangan'),
    //                                        ),
    //                         ),
    //		),
                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>' {delete}',
                                    'buttons'=>array(
                                                    'delete'=> array(
                                                             'options'=>array('rel'=>'tooltip','title'=>'Hapus Kelas Ruangan'),
                                                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                    ),
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
<!--</div>-->
<?php   
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Kelas Ruangan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
$content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
           function cekForm(obj)
{
    $("#ppruangan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppruangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="SARuanganM[ruangan_nama]"]').focus();
    })
</script>