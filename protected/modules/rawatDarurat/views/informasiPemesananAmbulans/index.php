<div class="white-container">
    <legend class="rim2">Informasi <b>Pemesanan Ambulans</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('pesanambulans-t-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    "); 
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pemesanan Ambulans</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pesanambulans-t-grid',
            'dataProvider'=>$modPemesanan->search(),
            //'filter'=>$modPemesanan,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                ////'pesanambulans_t',
                //'pendaftaran_id',
                //'mobilambulans_id',
                //'pemakaianambulans_id',
                //'pasien_id',

                'pesanambulans_no',
                'norekammedis',
                'namapasien',
                'tempattujuan',
                'alamattujuan',
                'tglpemakaianambulans',
                'untukkeperluan',
                'ruanganpemesan.ruangan_nama',
                'userpemesan.nama_pemakai',
                /*
                'tglpemesananambulans',
                'kelurahan_nama',
                'rt_rw',
                'nomobile',
                'notelepon',
                'keteranganpesan',
                'create_time',
                'update_time',
                'update_loginpemakai_id',
                'create_ruangan',
                */
            ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?> 
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_searchPemesanan',array('modPemesanan'=>$modPemesanan,'format'=>$format)) ?>
    </fieldset>
        <?php
    //     $this->widget('bootstrap.widgets.BootButtonGroup', array(
    //                'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    //                'buttons'=>array(
    //                    array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
    //                    array('label'=>'', 'items'=>array(
    //                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
    //                        array('label'=>'EXCEL','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
    //                        array('label'=>'PRINT','icon'=>'icon-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PRINT\')')),
    //                    )),       
    //                ),
    //        //        'htmlOptions'=>array('class'=>'btn')
    //            )); 
    ?>
</div>