<div class="white-container">
    <legend class="rim2">Tambah <b>Lokasi Aset</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Salokasiaset Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Create').'  Lokasi Aset ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SALokasiasetM', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'  Lokasi Aset', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model,'garis_latitude'=>$garis_latitude,'garis_longitude'=>$garis_longitude)); ?>
</div>
<?php
//========= Dialog buat cari data instalasi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogInstalasi',
    'options'=>array(
        'title'=>'Instalasi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modinstalasi = new SAInstalasiM('search');
$modinstalasi->unsetAttributes();
if(isset($_GET['SAInstalasiM']))
    $modinstalasi->attributes = $_GET['SAInstalasiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modinstalasi->search(),
	'filter'=>$modinstalasi,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectInstalasi",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'lokasiaset_namainstalasi').'\").val(\'$data->instalasi_nama\');
                                    $(\'#dialogInstalasi\').dialog(\'close\');return false;"))',
                ),
                'instalasi_nama',
		'instalasi_singkatan',
                'instalasi_lokasi',
                
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
        
<?php
//========= Dialog buat cari data ruangan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRuangan',
    'options'=>array(
        'title'=>'Ruangan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modRuangan = new SARuanganM('search');
$modRuangan->unsetAttributes();
if(isset($_GET['SARuanganM']))
    $modRuangan->attributes = $_GET['SARuanganM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'saruangan-m-grid',
	'dataProvider'=>$modRuangan->search(),
	'filter'=>$modRuangan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                 array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectRuangan",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'lokasiaset_namabagian').'\").val(\'$data->ruangan_nama\');
                                    $(\'#dialogRuangan\').dialog(\'close\');return false;"))',
                ),
                'ruangan_nama',
		'ruangan_jenispelayanan',
                'ruangan_lokasi',
                
               
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>