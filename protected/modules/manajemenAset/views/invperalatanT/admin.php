<div class="white-container">
    <legend class="rim2">Informasi Inventarisasi <b>Peralatan dan Mesin</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Guinvperalatan Ts'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Peralatan dan Mesin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvperalatanT', 'icon'=>'list', 'url'=>array('index'))) ;
                    //(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Inventarisasi Peralatan dan Mesin', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('guinvperalatan-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel Inventarisasi <b>Peralatan dan Mesin</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'guinvperalatan-t-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'invperalatan_id',
                    array(
                            'name'=>'invperalatan_id',
                            'value'=>'$data->invperalatan_id',
                            'filter'=>false,
                    ),
                    array(
                            'name'=>'pemilikbarang_id',
                            'filter'=>  CHtml::listData($model->PemilikItems, 'pemilikbarang_id', 'pemilikbarang_nama'),
                            'value'=>'isset($data->pemilik->pemilikbarang_nama)?$data->pemilik->pemilikbarang_nama:"-"',
                    ),
                                    array(
                            'name'=>'barang_id',
                            'filter'=>  CHtml::listData($model->BarangItems, 'barang_id', 'barang_nama'),
                            'value'=>'isset($data->barang->barang_nama)?$data->barang->barang_nama:"-"',

                    ),
                                    array(
                            'name'=>'asalaset_id',
                            'filter'=>  CHtml::listData($model->AsalAsetItems, 'asalaset_id', 'asalaset_nama'),
                            'value'=>'isset($data->asal->asalaset_nama)?$data->asal->asalaset_nama:"-"',
                    ),
                                    array(
                            'name'=>'lokasi_id',
                            'filter'=>  CHtml::listData($model->LokasiAsetItems, 'lokasi_id', 'lokasiaset_namalokasi'),
                            'value'=>'isset($data->lokasi->lokasiaset_namalokasi)?$data->lokasi->lokasiaset_namalokasi:"-"',
                    ),
                    'invperalatan_kode',

                    'invperalatan_noregister',
                    'invperalatan_namabrg',
                    //'invperalatan_merk',
                    //'invperalatan_ukuran',
                    //'invperalatan_bahan',
                    'invperalatan_thnpembelian',
                    //'invperalatan_tglguna',
                    //'invperalatan_nopabrik',
                    'invperalatan_norangka',
                    'invperalatan_nomesin',
                    'invperalatan_nopolisi',
                    'invperalatan_nobpkb',
                    //'invperalatan_harga',
                    //'invperalatan_akumsusut',
                    //'invperalatan_ket',
                    //'invperalatan_kapasitasrata',
                    //'invperalatan_ijinoperasional',
                    //'invperalatan_serftkkalibrasi',
                    //'invperalatan_umurekonomis',
                    //'invperalatan_keadaan',
                    //'create_time',
                    //'update_time',
                    //'create_loginpemakai_id',
                    //'update_loginpemakai_id',
                    //'create_ruangan',

                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array (
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat inventarisasi peralatan dan mesin' ),
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
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah inventarisasi peralatan dan mesin' ),
                                            ),
                             ),
                    ),
                    array(
                            'header'=>'Batal Register',
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                             'delete'=> array(
                                                    'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                    'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus inventarisasi peralatan dan mesin' ),
                                            ),
                            )
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class='rim'><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="search-form" >
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
        </div><!-- search-form -->
    </fieldset>
</div>
<?php 
 
//         echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//         echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
//         echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
// $content = $this->renderPartial('../tips/master',array(),true);
// $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#guinvperalatan-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script>
    $(document).ready(function(){
        $("input[name='MAInvperalatanT[invperalatan_kode]']").focus();
    });
</script>