<?php
    $data = $model->searchLaporanCarabayar();
    if(isset($caraPrint)){
        $data = $model->searchPrintLaporanCarabayar();
    }
        
    $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',
        array(
            'id'=>'tableGroupPemeriksaanCaraBayar',
            'dataProvider'=>$data,
            'template'=>"{summary}\n{items}\n{pager}",
            'enableSorting'=>true,
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header' => '<center>No.</center>',
                    'type'=>'raw',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    'htmlOptions'=>array(
                        'style'=>'text-align:center'
                    ),
                    'footerHtmlOptions'=>array(
                        'colspan'=>6,
                        'style'=>'text-align:right;font-style:italic;'
                    ),
                    'footer'=>'Total',
                ),
                array(
                    'header' => '<center>No. Pendaftaran</center>',
                    'type'=>'raw',
                    'name' => 'no_pendaftaran',
                ),
                array(
                    'header' => '<center>Nama Pasien</center>',
                    'type'=>'raw',
                    'name' => 'nama_pasien',
                ),
                array(
                    'header' => '<center>Alamat Pasien</center>',
                    'type'=>'raw',
                    'name' => 'alamat_pasien',
                ),
                array(
                    'header' => '<center>Cara Bayar</center>',
                    'type'=>'raw',
                    'name' => 'carabayar_nama',
                ),
                array(
                    'header' => '<center>Penjamin</center>',
                    'type'=>'raw',
                    'name' => 'penjamin_nama',
                ),
                array(
                    'header' => '<center>Total Biaya</center>',
                    'type'=>'raw',
                    'name' => 'total_biaya',
                    'value'=>'number_format($data->total_biaya,0,",",".")',
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
                    'value'=>'number_format($data->bayartindakan,0,",",".")',
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
            'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            }',                    
        )
    );
?>



