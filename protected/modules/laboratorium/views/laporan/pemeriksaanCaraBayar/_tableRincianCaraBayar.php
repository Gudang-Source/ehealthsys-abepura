<?php
$data = $model->searchLaporanRincianCarabayar();
if(isset($caraPrint)){
    $data = $model->searchPrintLaporanRincianCarabayar();
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
    'id'=>'rincianPmeriksaanLab',
    'dataProvider'=>$data,
    'template'=>"{summary}\n{items}\n{pager}",
    'enableSorting'=>true,
    'itemsCssClass'=>'table table-striped table-condensed',
    'mergeColumns' => array(
        'no_pendaftaran',
        'no_masukpenunjang',
        'nama_pasien'
    ),
    'columns'=>array(
        array(
            'header'=>'<center>No. Pendaftaran</center>',
            'type'=>'raw',
            'name'=>'no_pendaftaran',
        ),
        array(
            'header'=>'<center>No. Lab</center>',
            'type'=>'raw',
            'name'=>'no_masukpenunjang',
        ),
        array(
            'header'=>'<center>Nama Pasien</center>',
            'type'=>'raw',
            'name'=>'nama_pasien',
        ),
        array(
            'header'=>'<center>Pemeriksaan</center>',
            'type'=>'raw',
            'name'=>'daftartindakan_nama',
        ),
        array(
            'header'=>'<center>Cara Bayar</center>',
            'type'=>'raw',
            'name'=>'carabayar_nama',
            'footerHtmlOptions'=>array(
                'colspan'=>6,
                'style'=>'text-align:right;font-style:italic;'
            ),
            'footer'=>'Total',
        ),
        array(
            'header'=>'<center>Penjamin</center>',
            'type'=>'raw',
            'name'=>'penjamin_nama',
        ),
        array(
            'header' => '<center>Total Biaya</center>',
            'type'=>'raw',
            'name' => 'total_biaya',
            'value'=>'number_format($data->total_biaya)',
            'htmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),
            'footerHtmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),                            
            'footer'=>'sum(total_biaya)',
        ),
        array(
            'header' => '<center>Bayar</center>',
            'type'=>'raw',
            'name' => 'bayartindakan',
            'value'=>'number_format($data->bayartindakan)',
            'htmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),
            'footerHtmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),                            
            'footer'=>'sum(bayartindakan)',
        ),
        array(
            'header' => '<center>Sisa</center>',
            'type'=>'raw',
            'name' => 'sisatindakan',
            'value'=>'number_format($data->sisatindakan)',
            'htmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),
            'footerHtmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),                            
            'footer'=>'sum(sisatindakan)',
        ),
    ),
)); ?> 
