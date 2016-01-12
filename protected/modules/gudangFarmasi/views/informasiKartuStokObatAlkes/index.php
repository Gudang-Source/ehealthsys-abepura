<div class="white-container">
    <legend class="rim2">Informasi Kartu Stok <b>Obat dan Alat Kesehatan</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('#divSearch-form form').submit(function(){
            $.fn.yiiGridView.update('informasi-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Kartu Stok</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'informasi-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    'instalasi_nama',
                    'ruangan_nama',
                    array(
                        'name'=>'create_time',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->create_time)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'header'=>'Nama Transaksi',
						'name'=>'transaksi',
                        'type'=>'raw',
                        'value'=>'$data->NamaTransaksi',
                    ),
                    'obatalkes_kode',
                    'obatalkes_nama',
                    'satuankecil_nama',

                    array(
                        'name'=>'harganetto',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->harganetto)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'jmldiscount',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->jmldiscount)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'persenppn',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->persenppn)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'persenpph',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->persenpph)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'header'=>'HPP (Rp.)',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->HPP)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'persenmargin',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->persenmargin)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'header'=>'Harga Jual Apotek (Rp.)',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->HargaJualApotek)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'qtystok_in',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->qtystok_in)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'qtystok_out',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForUser($data->qtystok_out)',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'stokoa_aktif',
                        'type'=>'raw',
                        'value'=>'($data->stokoa_aktif) ? "AKTIF" : "NON-AKTIF"',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view.'search',array('model'=>$model,'format'=>$format,'instalasiAsals'=>$instalasiAsals,'ruanganAsals'=>$ruanganAsals)); ?>
</div>