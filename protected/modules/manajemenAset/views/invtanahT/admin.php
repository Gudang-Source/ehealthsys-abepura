<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Guinvtanah Ts'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Inventarisasi Tanah ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                    //array_push($arrMenu,array('label'=>Yii::t('mds','List').' MAInvtanahT', 'icon'=>'list', 'url'=>array('index'))) ;
                    //(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Inventarisasi Tanah', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    //$this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('guinvtanah-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class='rim2'>Informasi <b>Inventarisasi Tanah</b></legend>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="search-form cari-lanjut2" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Inventarisasi Tanah</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'guinvtanah-t-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'invtanah_id',
                    array(
                            'header'=>'ID',
                            'value'=>'$data->invtanah_id',
                            'filter'=>false,
                    ),
                                    array(
                            'name'=>'pemilikbarang_id',
                            'filter'=>  CHtml::listData($model->PemilikItems, 'pemilikbarang_id', 'pemilikbarang_nama'),
                            'value'=>'$data->pemilik->pemilikbarang_nama',
                    ),
                                    array(
                            'name'=>'barang_id',
                            'filter'=>  CHtml::listData($model->BarangItems, 'barang_id', 'barang_nama'),
                            'value'=>'$data->barang->barang_nama',

                    ),
                                    array(
                            'name'=>'asalaset_id',
                            'filter'=>  CHtml::listData($model->AsalAsetItems, 'asalaset_id', 'asalaset_nama'),
                            'value'=>'isset($data->asalaset_id)?$data->asal->asalaset_nama:" - "',
                    ),
                                    array(
                            'name'=>'lokasi_id',
                            'filter'=>  CHtml::listData($model->LokasiAsetItems, 'lokasi_id', 'lokasiaset_namalokasi'),
							'value'=>'isset($data->lokasi_id)?$data->lokasi->lokasiaset_namalokasi:" - "',
                    ),
                    array(
                        'header'=>'Tahun/<br/>Tanggal',
                        'type'=>'raw',
                        'value'=>'$data->tahunNama',
                    ),
                    array(
                        'header'=>'No. Sertifikat/<br/>Tanggal',
                        'type'=>'raw',
                        'value'=>'$data->sertifikat',
                    ),

                    'invtanah_kode',

                    //'invtanah_noregister',
                    'invtanah_namabrg',
                    'invtanah_luas',

                    //'invtanah_thnpengadaan',
                    //'invtanah_tglguna',
                    'invtanah_alamat',
                    'invtanah_status',
                    //'invtanah_tglsertifikat',
                    //'invtanah_nosertifikat',
                    'invtanah_penggunaan',
                    'invtanah_harga',
                    //'invtanah_ket',
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
                                'view' => array(
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat inventarisasi tanah' ),
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
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah inventarisasi tanah' ),
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
                                                    'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus inventarisasi tanah' ),
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
        $content = $this->renderPartial('tips/informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#guinvtanah-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script>
    $(document).ready(function(){
        $("input[name='MAInvtanahT[invtanah_kode]']").focus();
    });
</script>