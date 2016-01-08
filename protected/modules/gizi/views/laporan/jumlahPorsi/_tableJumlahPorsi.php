<?php 
//     $rim = 'max-width:1300px;overflow-x:scroll;';
// $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
//     $sort = true;
//     if (isset($caraPrint)){
//         $data = $model->searchPrint();
//         $template = "{items}";
//         $sort = false;
//         if ($caraPrint == "EXCEL")
//             $table = 'ext.bootstrap.widgets.BootExcelGridView';
            
//     } else{
//         $data = $model->searchTable();
//          $template = "{summary}\n{items}\n{pager}";
//     }
?>

<?php
$rim = 'max-width:1250px;overflow-x:scroll;';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->search();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
    if (isset($caraPrint)){
        $sort = false;
        $data = $model->searchPrint();
        $rim = '';
        $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
            $data = $model->searchTable();
            $template = "{summary}\n{items}\n{pager}";
        }
?>

<!-- <div id="div_rekap"> -->
<div style="<?php echo $rim; ?>">
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Topaz</center>',
                'start'=>2, 
                'end'=>9, 
            ),
            //RUANGAN LAIN DISESUAIKAN DENGAN KONTEN column
            
        ),
        //'mergeColumns'=>array('nama_pasien','no_rekam_medik'),
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(

                array(
                    'header' => 'No',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header'=>'Jenis DIIT',
                    'value'=> '$data->jenisdiet_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;'),
                    'footer'=>'JUMLAH',
                ),
				//ruangan_id = 27 (Topaz)
                array(
                    'header'=>'VVIP', //kelaspelayanan_id = 1
                    'value'=> 'number_format($data->getSumKelas(1,$data->jenisdiet_id,27))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumKelasP(array("jenisdiet"),1,27)),
                ),
                array(
                    'header'=>'VIP', //kelaspelayanan_id = 2
                    'value'=> 'number_format($data->getSumKelas(2,$data->jenisdiet_id,27))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumKelasP(array("jenisdiet"),2,27)),
                ),
                array(
                    'header'=>'Kelas I', //kelaspelayanan_id = 3
                    'value'=> 'number_format($data->getSumKelas(3,$data->jenisdiet_id,27))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumKelasP(array("jenisdiet"),3,27)),
                ),
                array(
                    'header'=>'Kelas II', //kelaspelayanan_id = 5
                    'value'=> 'number_format($data->getSumKelas(5,$data->jenisdiet_id,27))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumKelasP(array("jenisdiet"),5,27)),
                ),
                array(
                    'header'=>'Kelas III', //kelaspelayanan_id = 4
                    'value'=> 'number_format($data->getSumKelas(4,$data->jenisdiet_id,27))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumKelasP(array("jenisdiet"),4,27)),
                ),
				array(
                    'header'=>'Utama', //kelaspelayanan_id = 7
                    'value'=> 'number_format($data->getSumKelas(7,$data->jenisdiet_id,27))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumKelasP(array("jenisdiet"),7,27)),
                ),
                array(
                    'header'=>'JML',
                    'value'=> 'number_format($data->getSumJml($data->jenisdiet_id,27))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumJmlT(27)),
                ),
		
				//RUANGAN LAINNYA SILAHKAN DITAMBAHKAN DI BAWAH (DISESUAIKAN DI MASING2 PROJEK)
			
                array(
                    'header'=>'JML TOTAL',
                    'value'=> 'number_format($data->getSumTotal($data->jenisdiet_id))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumTotalT()),
                    ),

                
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>