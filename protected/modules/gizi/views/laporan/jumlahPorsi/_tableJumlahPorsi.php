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
<?php 
    $kelas = KelaspelayananM::model()->findAll('kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama');
    $total = count($kelas);            
        $columns =array();
        $columns = array(
                 array(
                    'header' => 'No',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header'=>'Jenis DIET',
                    'value'=> '$data->jenisdiet_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footerHtmlOptions'=>array('colspan'=>2,'style'=>'text-align:right;'),
                    'footer'=>'JUMLAH',
                ),
            );
        
        foreach($kelas as $kelas):
            
            $columns[] = array(
                'header'=>'<center>'.$kelas->kelaspelayanan_nama.'</center>',
                'value'=> 'number_format($data->getSumKelas('.$kelas->kelaspelayanan_id.',$data->jenisdiet_id,$data->ruangan_id))',                
                'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'headerHtmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                'footer'=>number_format($model->getSumKelasP(array("jenisdiet"),$kelas->kelaspelayanan_id,$model->ruangan_id)),                
            );
        endforeach;
        
        if (!empty($model->ruangan_id))
        {        
        $columns[] =  array(
                    'header'=>'<center>JML TOTAL</center>',
                    'value'=> 'number_format($data->getSumJml($data->jenisdiet_id,$data->ruangan_id))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumJmlT($model->ruangan_id)),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                    'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                );
        }else{						                
        $columns[] = array(
                    'header'=>'<center>JML TOTAL</center>',
                    'value'=> 'number_format($data->getSumTotal($data->jenisdiet_id))',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer'=>number_format($model->getSumTotalT()),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;color:black;font-weight:bold'),
                    'htmlOptions'=>array('style'=>'text-align: right;vertical-align:middle;'),
                    );
        }






    $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Kelas Pelayanan</center>',
                'start'=>2, 
                'end'=>$total+1, 
            ),
            //RUANGAN LAIN DISESUAIKAN DENGAN KONTEN column
            
        ),
        //'mergeColumns'=>array('nama_pasien','no_rekam_medik'),
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>$columns,
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>