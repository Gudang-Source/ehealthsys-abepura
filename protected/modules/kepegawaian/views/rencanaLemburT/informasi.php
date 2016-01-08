<?php
$this->breadcrumbs=array(
	'Rencana Lembur'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>'Informasi Rencana Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rencana Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RencanaLemburT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RencanaLemburT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rencana-lembur-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Rencana Lembur</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Rencana Lembur</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rencana-lembur-t-grid',
            'dataProvider'=>$modRencanaLembur->searchInformasiRencanaLembur(),
            //'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'rencanalembur_id',
                    array(
                            'name'=>'no',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'header'=>'No.',
                            'filter'=>false,
                    ),		
                    array(
                        'name'=>'tglrencana',
                        'value'=>'date("d M Y",strtotime($data->tglrencana))',
                        //'filter'=>false,
                    ),
                    array(
                        'name'=>'norencana',
                        'value'=>'$data->norencana',
                        //'filter'=>false,
                    ),

                    array(
                        'name'=>'mengetahui_nama',
                        'header'=>'Mengetahui',
                        'value'=>'$data->getPegawaiAttributes($data->mengetahui_id,\'nama_pegawai\')',
    //                    'value'=>'$data->mengetahui_id',
                        'filter'=>false,
                    ),
                    array(
                        'name'=>'menyetujui_nama',
                        'header'=>'Menyetujui',
                        'value'=>'$data->getPegawaiAttributes($data->menyetujui_id,\'nama_pegawai\')',
                        //'value'=>'$data->menyetujui_id',
                        'filter'=>false,
                    ),
                    array(
                        'name'=>'pemberitugas_nama',
                        'header'=>'Pemberi Tugas',
                        'value'=>'$data->getPegawaiAttributes($data->pemberitugas_id,\'nama_pegawai\')',
                        //'value'=>'$data->pemberitugas_id',
                        'filter'=>false,
                    ),
                    array(
                           'header'=>'Lihat Detail',
                           'type'=>'raw',
                           'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/lihatdetail",
                               array("norencana"=>$data->norencana)),
                               array("title"=>"Klik Untuk Lihat Detail","target"=>"iframeLihatDetail", "onclick"=>"$(\'#dialogLihatDetail\').dialog(\'open\')"))', //'CHtml::link("<i class=\'icon-search\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/update",array("id"=>$data->karyawan_id)),array("title"=>"Klik Untuk Pindah Kamar","target"=>"iframeLihatDetail", "onclick"=>"$(\"#dialogLihatDetail\").dialog(\"open\");", "rel"=>"tooltip"))',
                           'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                        ),
                    array(
                           'header'=>'Realisasi Lembur',
                           'type'=>'raw',
                           'value'=>'CHtml::link("<i class=\'icon-form-lembur\'></i>",Yii::app()->controller->createUrl("realisasiLemburT/buat",
                               array("norencana"=>$data->norencana,"frame"=>1)),
                               array("title"=>"Klik Untuk Realisasi Lembur", "target"=>"iframeRealisasiLembur", "onclick"=>"$(\'#dialogRealisasiLembur\').dialog(\'open\')"))', //'CHtml::link("<i class=\'icon-search\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/update",array("id"=>$data->karyawan_id)),array("title"=>"Klik Untuk Pindah Kamar","target"=>"iframeLihatDetail", "onclick"=>"$(\"#dialogLihatDetail\").dialog(\"open\");", "rel"=>"tooltip"))',
                           'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                        ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php 
        //echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        //echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        //echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        //$this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rencana-lembur-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php
//============================ Dialog Lihat Detail =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogLihatDetail',
    'options'=>array(
        'title'=>'Lihat Detail Rencana Lembur',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>500,
        'resizable'=>false,
    ),
));
echo '<iframe src="" name="iframeLihatDetail" width="100%" height="500"></iframe>';
$this->endWidget();

//==============================================================================
?>
<?php
//============================ Dialog Lihat Detail =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRealisasiLembur',
    'options'=>array(
        'title'=>'Realisasi Rencana Lembur',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>1100,
        'minHeight'=>640,
        'resizable'=>false,
    ),
));
echo '<iframe src="" name="iframeRealisasiLembur" width="100%" height="500"></iframe>';
$this->endWidget();

//==============================================================================
?>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="search-form" style="display:true">
            <?php $this->renderPartial('_search',array(
                    'modRencanaLembur'=>$modRencanaLembur,
            )); ?>
        </div>
    </fieldset>
</div>