<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $dataProvider = $model->printRekapPenjamin();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';

        echo $this->renderPartial('application.views.headerReport.headerLaporan',
            array(
                'judulLaporan'=>$data['judulLaporan'],
                'periode'=>$data['periode']
            )
        );        
    } else{
        $dataProvider = $model->rekapPenjamin();
        $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableRekapCaraBayar',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                  'header'=>'No',
                  'type'=>'raw',
                  'value'=>'$row+1',
                ),
                array(
                  'header'=>'Nama Penjamin',
                  'type'=>'raw',
                  'value'=>'$data->penjamin_nama',
                ),
                array(
                  'header'=>'Jumlah',
                  'type'=>'raw',
                  'value'=>'$data->jumlah',
                ),              
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
?> 