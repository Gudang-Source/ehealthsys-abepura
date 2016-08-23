<div class="white-container">
    <legend class="rim2">Informasi Permintaan <b>Pembelian Barang</b></legend>
    <div class="block-tabel">
        <h6>Tabel Permintaan <b>Pembelian Barang</b></h6>
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
                $.fn.yiiGridView.update('gupembelianbarang-t-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gupembelianbarang-t-grid',
            'dataProvider'=>$model->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
    //		////'pembelianbarang_id',
    //		array(
    //                        'name'=>'pembelianbarang_id',
    //                        'value'=>'$data->pembelianbarang_id',
    //                        'filter'=>false,
    //                ), 
				
                    'nopembelian',
    //		'terimapersediaan_id',
                    'sumberdana.sumberdana_nama',
                    'supplier.supplier_nama',                    
                     array(
                        'header' => 'Tanggal Pembelian',
                        'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tglpembelian))))'
                    ),  
                     array(
                        'header' => 'Tanggal Dikirim',
                        'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tgldikirim))))'
                    ),  

                    array(
                        'header' => 'Pegawai Pemesan',
                        'value' => 'empty($data->pemesan)?"-":$data->pemesan->nama_pegawai'
                    ),                    
                    array(
                        'header' => 'Pegawai Mengetahui',
                        'value' => '!empty($data->peg_mengetahui_id)?$data->mengetahui->nama_pegawai:"-"'
                    ),                    
                    array(
                        'header' => 'Pegawai Menyetujui',
                        'value' => '!empty($data->peg_menyetujui_id)?$data->menyetujui->nama_pegawai:"-"'                       
                    ),                                        
                /*
                    'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    'create_ruangan',
                    */ 
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/pengadaan/PembelianbarangT/detailPembelianBarang",array("id"=>$data->pembelianbarang_id)),array("id"=>"$data->pembelianbarang_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pembelian Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),
				
                    array(
                        'header'=>'Terima Barang',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'(empty($data->terimapersediaan_id)) ? ((Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_LOGISTIK) ? CHtml::link("<i class=\'icon-form-terimabrg\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/TerimapersediaanT/index",array("id"=>$data->pembelianbarang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Persediaan Barang")) : "Belum Diterima") : "Telah Dikirim"',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </fieldset><!-- search-form -->
</div>
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
        'title' => 'Detail Pembelian Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 250,
        'resizable' => true,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>