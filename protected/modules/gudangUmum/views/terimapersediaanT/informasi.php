<div class="white-container">
    <legend class="rim2">Informasi <b>Penerimaan Persediaan</b></legend>
    <?php
    //$this->breadcrumbs=array(
    //	'Gupembelianbarang Ts'=>array('index'),
    //	'Manage',
    //);
    //
    //$arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUPembelianbarangT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUPembelianbarangT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUPembelianbarangT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                
    //$this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('guterimapersediaan-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Penerimaan Persediaan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'guterimapersediaan-t-grid',
            'dataProvider'=>$model->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'terimapersediaan_id',
    //		array(
    //                        'name'=>'terimapersediaan_id',
    //                        'value'=>'$data->terimapersediaan_id',
    //                        'filter'=>false,
    //                ),
                    'nopenerimaan',
                    'tglterima',
                    'sumberdana.sumberdana_nama',
                    'pembelianbarang.nopembelian',
                    'penerima.nama_pegawai',
    //		'peg_mengetahui_id',
                    'ruangan.ruangan_nama',
    //		'returpenerimaan_id',


                /*
                    'tglsuratjalan',
                    'nosuratjalan',
                    'tglfaktur',
                    'nofaktur',
                    'keterangan_persediaan',
                    'totalharga',
                    'discount',
                    'biayaadministrasi',
                    'pajakpph',
                    'pajakppn',
                    'nofakturpajak',
                    'peg_penerima_id',
                    'peg_mengetahui_id',
                    'ruanganpenerima_id',
                    'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    'tglsuratjalan',
                    'nosuratjalan',
                    'tglfaktur',
                    'nofaktur',
                    'keterangan_persediaan',
                    'totalharga',
                    'discount',
                    'biayaadministrasi',
                    'pajakpph',
                    'pajakppn',
                    'nofakturpajak',
                    'peg_penerima_id',
                    'peg_mengetahui_id',
                    'ruanganpenerima_id',
                    'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    'create_ruangan'
                    */
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/TerimapersediaanT/detailTerimaPersediaan",array("id"=>$data->terimapersediaan_id,"frame"=>1)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Penerimaan Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                    array(
                        'header'=>'Retur Penerimaan',
                        'type'=>'raw',
                        'value'=>'(empty($data->returpenerimaan_id)) ? CHtml::link("<i class=\'icon-form-retur\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/ReturpenerimaanT/index",array("id"=>$data->terimapersediaan_id)),array( "rel"=>"tooltip","title"=>"Klik untuk Retur Penerimaan Persediaan Barang", )) : "Telah Diretur"',    'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </fieldset><!-- search-form -->

<?php 
 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//        $this->widget('UserTips',array('type'=>'admin'));
//        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
//
//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#gupembelianbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penerimaan Barang',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 820,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>
</div>