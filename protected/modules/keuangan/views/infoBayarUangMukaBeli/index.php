<div class="white-container">
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
    $this->breadcrumbs=array(
            'Informasi Pembayaran Uang Muka Pembelian',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('#pembayaran-t-search').submit(function()
    {
        $.fn.yiiGridView.update('infopembayaran-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    $('#btn_resset').click(function()
    {
        setTimeout(function(){
            $.fn.yiiGridView.update('infopembayaran-m-grid', {
                data: $('#pembayaran-t-search').serialize()
            });    
        }, 1000);
    });
    ");
    ?>
    <legend class="rim2">Informasi <b>Pembayaran Uang Muka Pembelian</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pembayaran Uang Muka Pembelian</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'infopembayaran-m-grid',
            'dataProvider'=>$modBayar->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No',
                            'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                    ), 
                    array(
                            'header'=>'Supplier',
                            'name'=>'supplier_id',
                            'type'=>'raw',
                            'value'=>'$data->supplier->supplier_nama',
                    ),
                    array(
                            'header'=>'No. Kas Keluar',
                            'type'=>'raw',
                            'value'=>function($data) {
                                    $tb = TandabuktikeluarT::model()->findByAttributes(array(
                                        'uangmukabeli_id'=>$data->uangmukabeli_id
                                    ));
                                    if (empty($tb)) return "-";
                                    return $tb->nokaskeluar;
                            }//'empty($data->tandabuktikeluar)?"-":$data->tandabuktikeluar->nokaskeluar',
                    ),
                    array(
                            'header'=>'No. Penerimaan',
                            'type'=>'raw',
                            'value'=>'empty($data->penerimaanbarang_id)?"-":$data->penerimaanbarang->noterima',
                    ),
                    array(
                            'header'=>'No. Permintaan',
                            'type'=>'raw',
                            'value'=>'empty($data->permintaanpembelian_id)?"-":$data->permintaanpembelian_id',
                    ),
                    array(
                            'header'=>'Jumlah Uang',
                            'name'=>'jumlahuang',
                            'value'=>'MyFormatter::formatNumberForPrint($data->jumlahuang)',
                            'htmlOptions'=>array(
                                'style'=>'text-align: right',
                            ),
                    ),
                
                /*
                    array(
                            'header'=>'Tgl. Pembayaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgluangmuka)',
                    ),
                    array(
                            'header'=>'No. Pembayaran',
                            'type'=>'raw',
                            'value'=>'$data->nobuktibayar',
                    ),
                    array(
                            'header'=>'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien',
                    ),
                    array(
                            'header'=>'Biaya Administrasi',
                            'type'=>'raw',
                            'value'=>'number_format($data->biayaadministrasi)',
                  
                    ),
                    array(
                            'header'=>'Biaya Materai',
                            'type'=>'raw',
                            'value'=>'number_format($data->biayamaterai)',
                    ),
                    array(
                            'header'=>'Total Uang Muka',
                            'type'=>'raw',
                            'value'=>'number_format($data->totaluangmuka)',
                    ),
                    array(
                            'header'=>'Sisa Uang Muka',
                            'type'=>'raw',
                            'value'=>'$data->sisauangmuka',
                    ), */
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array('modBayar'=>$modBayar)); ?>
    </fieldset>
</div>
<br>
