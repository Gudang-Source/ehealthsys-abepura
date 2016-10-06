<div class="white-container">
    <legend class="rim2">Informasi <b>Struktur Organisasi</b></legend>
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
        <h6>Tabel <b>Struktur Organisasi</b></h6>
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
                          'header'=> 'No Sk',
                          'name' => 'organigram_kode',
                          'value' => '$data->organigram_kode'
                      ),
                      array(
                          'header'=> 'Bertanggung Jawab Kpd',
                          'name' => 'organigramasal_id',
                          'value' => '!empty($data->organigramasal->pegawai->namaLengkap)?$data->organigramasal->pegawai->namaLengkap:"-"',
                      ),
                      array(
                          'header'=> 'Unit Kerja Organigram',
                          'name' => 'organigram_unitkerja',
                          'value' => '$data->organigram_unitkerja',                          
                      ),
                      array(
                          'header'=> 'Formasi',
                          'name' => 'organigram_formasi',
                          'value' => '$data->organigram_formasi'
                      ),
                      array(
                          'header'=> 'NIP',
                          'name' => 'nomorindukpegawai',
                          'value' => '$data->pegawai->nomorindukpegawai'
                      ),
                      array(
                          'header'=> 'Nama Pegawai',
                          'name' => 'nama_pegawai',
                          'value' => '$data->pegawai->namaLengkap'
                      ),
                      array(
                          'header'=> 'Jabatan',
                          'name' => 'jabatan_id',
                          'value' => '$data->pegawai->jabatan->jabatan_nama'
                      ),
                      array(
                          'header'=> 'Pelaksana Kerja',
                          'name' => 'organigram_pelaksanakerja',
                          'value' => '$data->organigram_pelaksanakerja'
                      ),
                     array(
                          'header'=> 'Periode',
                          'name' => 'organigram_periode',
                          'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_periode)'
                      ),
                       array(
                          'header'=> 'Sampai Dengan',
                          'name' => 'organigram_sampaidengan',
                          'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_sampaidengan)'
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
