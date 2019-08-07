
<?php 
$itemCssClass = 'table table-striped table-condensed';
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  
  echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass = 'table border';
} else{
    
  $data = $model->searchTable();
  $template = "{summary}\n{items}\n{pager}";
}
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
//            'instalasi_nama',
//            'carakeluar',
            array(
                'header' => 'No',
                'value' => '$row+1',
            ), 
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),
            array(
                'header' => 'No RM',
                'value' => '$data->no_rekam_medik'
            ),            
            array(
                'header' => 'Tanggal Pulang',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpasienpulang)'
            ),
            array(
                'header' => 'Ruangan',
                'value' => '$data->ruangan_nama'
            ),
            array(
                'header' => 'Cara Pulang',
                'value' => '$data->carakeluar'
            ),
            array(
                'header' => 'Status Pulang',
                'value' => '$data->kondisipulang'
            ),            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>