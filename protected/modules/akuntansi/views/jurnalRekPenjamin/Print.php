
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
		$rows = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
		$rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
        $data = $model->searchPrint();
		$template = "{summary}\n{items}\n{pager}";
    }
  ?>  

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'penjaminpasien-m-grid',
	'dataProvider'=>$model->searchPenjaminPrint(),
//	'filter'=>$model,
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'No',
                    'value'=>$rows,  
                ),
                array(
                    'header'=>'Cara Bayar',
                    'value'=>'$data->penjamin->carabayar->carabayar_nama',  
                ),
                array(
                    'header'=>'Penjamin',
                    'value'=>'$data->penjamin->penjamin_nama',  
                ),
                array(
                    'header'=>'Rekening Debit',
                    'type'=>'raw',
                    'value'=>'$this->grid->owner->renderPartial("_rekPenjaminD",array("saldonormal"=>"D","penjamin_id"=>$data->penjamin_id),true)',
                ),
		array(
                    'header'=>'Rekening Kredit',
                    'type'=>'raw',
                    'value'=>'$this->grid->owner->renderPartial("_rekPenjaminK",array("saldonormal"=>"K","penjamin_id"=>$data->penjamin_id),true)',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>