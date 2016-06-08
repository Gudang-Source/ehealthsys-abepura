<div class="white-container">
    <legend class="rim2">Informasi <b>Pemesanan Barang</b></legend>
    <?php
        //$this->breadcrumbs=array(
        //	'Gupesanbarang Ts'=>array('index'),
        //	'Manage',
        //);
        //
        //$arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUPesanbarangT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUPesanbarangT', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUPesanbarangT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                
        //$this->menu=$arrMenu;
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gupesanbarang-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pemesanan Barang</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gupesanbarang-t-grid',
            'dataProvider'=>$model->searchInformasiGudang(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header' => 'Tgl Pemesan',
                        'value' => '$data->tglpesanbarang',
                        ),
                    array(
                        'header' => 'No Pemesan',
                        'value' => '$data->nopemesanan',
                        ),
                    array(
                        'header' => 'Ruangan /<br> Pegawai Pemesan',
                        'value' => '$data->ruanganpemesan->ruangan_nama." \ ".$data->pegawaipemesan->nama_pegawai'
                    ),                                       
                    'keterangan_pesan',  
                    array(
                        'header' => 'Tgl Kirim',
                        'value' => '$data->tglmintadikirim',
                    ),
                     array(
                        'header' => 'Pegawai Pengirim',
                        'value' => function($data){
                            if (empty($data->mutasibrg_id)){
                                return '-';
                            }else{
                                $p = GUMutasibrgT::model()->findByPk($data->mutasibrg_id); 
                                
                                return $p->pegawaipengirim->nama_pegawai;
                            }
                        }
                    ),
                    array(
                            'header'=>'Detail',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/PesanbarangT/detailPesanBarang",array("id"=>$data->pesanbarang_id)),array("id"=>"$data->pesanbarang_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pemesanan Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',          'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),
                    array(
                            'header'=>'Mutasi Barang',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            'value'=>'(empty($data->mutasibrg_id))? CHtml::link("<i class=\'icon-form-mutasi\'></i> ", Yii::app()->controller->createUrl("/gudangUmum/MutasibrgT/index",array("id"=>$data->pesanbarang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Mutasi")) : "Telah Dimutasi"',
                    ),      
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('gudangUmum.views.pesanbarangT._searchGudang',array(
                'model'=>$model,
                'format'=>$format,
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

//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#gupesanbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pemesanan Barang',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>