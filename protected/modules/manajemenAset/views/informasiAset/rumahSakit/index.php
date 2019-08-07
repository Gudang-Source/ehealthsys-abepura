<div class="white-container">
    <legend class="rim2">Informasi <b>Aset Rumah Sakit</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Penjualan Tanahs'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','List').' Data Pelamar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PelamarT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PelamarT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

   // $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    //$('.search-button').click(function(){
    //	$('.search-form').toggle();
    //	return false;
    //});
    $('#invtanah-t-search').submit(function(){
            $.fn.yiiGridView.update('invtanah-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <!--<div class="search-form" style="display:none">-->

    <!--</div> search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Informasi Aset Rumah Sakit</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'invtanah-t-grid',
            'dataProvider'=>$model->searchInformasiAsetRumahSakit(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(                    
                      array(
                        'header'=>'<center>No.</center>',
                        'value' =>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
                        'type'=>'raw',
                      ),
                      array(
                          'header'=> 'Inventaris Kode',
                          'name' => 'inventarisasi_kode',
                          'value' => '$data->inventarisasi_kode'
                      ),
                      array(
                          'header'=> 'Nama Barang',
                          'name' => 'barang_nama',
                          'value' => '$data->barang_nama'
                      ),
                      array(
                          'header'=> 'Kode Barang',
                          'name' => 'barang_kode',
                          'value' => '$data->barang_kode'
                      ),
                      array(
                          'header'=> 'Jumlah',
                          'name' => 'inventarisasi_qty_skrg',
                          'value' => 'number_format($data->inventarisasi_qty_skrg,0,"",".")',
                          'htmlOptions' => array('style'=>'text-align:right;')
                      ),
                       array(
                          'header'=> 'Satuan',
                          'name' => 'inventarisasi_hargasatuan',
                          'value' => 'number_format($data->inventarisasi_hargasatuan,0,"",".")',
                          'htmlOptions' => array('style'=>'text-align:right;')
                      ),
                       array(
                          'header'=> 'Ruangan',
                          'name' => 'ruangan_nama',
                          'value' => '$data->ruangan_nama',                        
                      ),
                      array(
                          'header'=> 'Keadaan',
                          'name' => 'inventarisasi_keadaan',
                          'value' => '$data->inventarisasi_keadaan',                        
                      ),
                    ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('rumahSakit/_search',array(
                'model'=>$model,
        )); ?>
    </fieldset>
</div>
