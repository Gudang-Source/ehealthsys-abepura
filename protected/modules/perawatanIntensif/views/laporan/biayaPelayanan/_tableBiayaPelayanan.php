<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $itemCssClass = 'table table-striped table-condensed';
    $sort = true;
    $pagination = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $pagination = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
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


<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                    'header' => 'No',
                    'value' => $pagination,
            ),
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien /Alias',
                'value'=>'$data->NamaNamaBIN',
            ),
            'no_pendaftaran',
            'umur',
            'jeniskelamin',
            array(
                'header'=>'Nama Jenis Kasus Penyakit',
                'value'=>'(isset($data->jeniskasuspenyakit_nama) ? $data->jeniskasuspenyakit_nama : "")',
            ),
            array(
                'header'=>'Nama Kelas Pelayanan',
                'value'=>'(isset($data->kelaspelayanan_nama) ? $data->kelaspelayanan_nama : "")',
            ),
            array(
                'header'=>'Cara Bayar / Penjamin',
                'value'=>'(isset($data->carabayarPenjamin) ? $data->carabayarPenjamin : "")',
            ),
			array(
                'header'=>'Biaya Pelayanan',
                'value'=>'"Rp".number_format($data->tarif_tindakan,0,"",".")',
                'htmlOptions' => array('style'=>'text-align:right;')
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>