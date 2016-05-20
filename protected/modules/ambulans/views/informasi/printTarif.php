<style>
    .table {
        border-collapse: collapse;
        border: 1px solid black;
        box-shadow: none;
    }
    .table th, .table td, .table tbody tr:hover td {
        background-color: white;
        border: 1px solid black;
        color: black;
    }
</style>

<?php

$format = new MyFormatter();
    $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'tableTarif',
    'dataProvider'=>$modTarifRad->searchTarifPrint(),
    'template'=>"{items}",
    'itemsCssClass'=>'table table-condensed',
    'enableSorting'=>false,    
    'mergeHeaders'=>array(
                array(
                    'name'=>'<center>Tujuan</center>',
                    'start'=>1, //indeks kolom 3
                    'end'=>5, //indeks kolom 4
                ),
            ),
    'columns'=>array(
                    array(
                        'name'=>'tarifambulans_kode',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'daftartindakan.daftartindakan_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'kepropinsi_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'kekabupaten_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:lrft;'),
                    ),
                    array(
                        'name'=>'kekecamatan_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'kekelurahan_nama',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                    ),
                    array(
                        'name'=>'jmlkilometer',
                        'value'=>'number_format($data->jmlkilometer,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
                    array(
                        'name'=>'tarifperkm',
                        'value'=>'"Rp".number_format($data->tarifperkm,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
                    array(
                        'name'=>'tarifambulans',
                        'value'=>'"Rp".number_format($data->tarifambulans,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                    ),
            ),     
)); ?>
<script>
    window.print(); 
</script>

