<div class="white-container">
    <legend class="rim2">Informasi <b>Pelatihan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Pelamar Ts'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','List').' Data Pelamar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PelamarT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PelamarT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    //$('.search-button').click(function(){
    //	$('.search-form').toggle();
    //	return false;
    //});
    $('#pegmutasi-r-search').submit(function(){
            $.fn.yiiGridView.update('pegmutasi-r-grid', {
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
        <h6>Tabel <b>Pelatihan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pegmutasi-r-grid',
            'dataProvider'=>$model->searchInformasi(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'pelamar_id',
                      array(
                        'header'=>'<center>No.</center>',
                          'value' =>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        'htmlOptions'=>array('style'=>'text-align:center;width:30px;'),
                        'type'=>'raw',
                      ),
                      array(
                          'header'=> 'Jenis Diklat',
                          'name' => 'jenisdiklat_id',
                          'value' => '$data->jenisdiklat->jenisdiklat_nama'
                      ),
                      array(
                          'header'=> 'Nama Pegawai',
                          'name' => 'pegawaidiklat_nama',
                          'value' => '$data->pegawai->namaLengkap'
                      ),
                      array(
                          'header'=> 'Lama',
                          'name' => 'pegawaidiklat_lamanya',
                          'value' => '$data->pegawaidiklat_lamanya'
                      ),
                      array(
                          'header'=> 'Tempat',
                          'name' => 'pegawaidiklat_tempat',
                          'value' => '$data->pegawaidiklat_tempat'
                      ),
                      array(
                          'header'=> 'No Keputusan',
                          'name' => 'nomorkeputusandiklat',
                          'value' => '$data->nomorkeputusandiklat'
                      ),
                      array(
                          'header'=> 'Tanggal Ditetapkan',
                          'name' => 'tglditetapkandiklat',
                          'value' => 'MyFormatter::formatDateTimeForUser($data->tglditetapkandiklat)'
                      ),
                      array(
                          'header'=> 'Disetujui Oleh',                          
                          'value' => '$data->rencanadiklat->diklatMenyetujui->namaLengkap'
                      ),
                    ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </fieldset>
</div>
