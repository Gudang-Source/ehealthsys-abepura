
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchByFilterPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchByFilter();
         $template = "{summary}\n{items}\n{pager}";
    }
  ?>  

<?php
$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'AKRekeningakuntansi-v',
        'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
              'header'=>'No',
              'type'=>'raw',
              'value'=>'$row+1',
              'htmlOptions'=>array('style'=>'width:20px'),
              'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Struktur',
               'type'=>'raw',
               'value'=>'$data->kdrekening1',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px;'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Kelompok',
               'type'=>'raw',
               'value'=>'$data->kdrekening2',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Jenis',
               'type'=>'raw',
               'value'=>'$data->kdrekening3',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Obyek',
               'type'=>'raw',
               'value'=>'($data->kdrekening4 == null ? "-" : $data->kdrekening4)',
               'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kode Rincian Obyek',
               'type'=>'raw',
                'value'=>'($data->kdrekening5 == null ? "-" : $data->kdrekening5)',
               'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),

            ),
            array(
               'header'=>'Nama Struktur',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening1) ? $data->nmrekening1: "-"',
               'htmlOptions'=>array('style'=>'width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Nama Kelompok',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening2) ? $data->nmrekening2: "-"',
               'htmlOptions'=>array('style'=>'width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Nama Jenis',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening3) ? $data->nmrekening3: "-"',
               'htmlOptions'=>array('style'=>'width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Nama Obyek',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening4) ? $data->nmrekening4 : "-"',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Nama Rincian Obyek',
               'type'=>'raw',
               'value'=>'isset($data->nmrekening5) ? $data->nmrekening5: "-"',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Rincian Obyek NB',
               'type'=>'raw',
               'value'=>'($data->rekening5_nb == null ? "-" : ($data->rekening5_nb == "D" ? "Debit" : "Kredit"))',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Kelompok Rekening',
               'type'=>'raw',
               'value'=>'($data->kelompokrek == null ? "-" : $data->kelompokrek)',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'keterangan',
               'type'=>'raw',
               'value'=>'($data->keterangan == null ? "-" : $data->keterangan)',
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
               'header'=>'Status',
               'type'=>'raw',
               'value'=>'($data->rekening5_aktif == null ? "-" : ($data->rekening5_aktif == true ? "Aktif" : "Non Aktif"))',
               'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
               'headerHtmlOptions'=>array('style'=>'text-align:center;'),
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);
?>