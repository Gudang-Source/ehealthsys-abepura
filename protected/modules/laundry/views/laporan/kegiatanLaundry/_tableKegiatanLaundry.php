<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        array(
			'header'=>'No.',
			'value'=>'(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
			'type'=>'raw',
        ),
		array(
			'header'=>'Instalasi Asal',
			'value'=>'$data->instalasi_nama',
			'type'=>'raw',
        ),
		array(
			'header'=>'Ruangan Asal',
			'value'=>'$data->ruangan_nama',
			'type'=>'raw',
        ),
		array(
			'header'=>'Linen(kg)',
			'value'=>'$data->beratlinen',
			'type'=>'raw',
        ),
		array(
			'header'=>'Perbaikan (pcs)',
			'value'=>'$data->perbaikan',
			'type'=>'raw',
        ),
		array(
			'header'=>'Dekontaminasi (pcs)',
			'value'=>'$data->dekontaminasi',
			'type'=>'raw',
        ),
		array(
			'header'=>'Pencucian (pcs)',
			'value'=>'$data->pencucian',
			'type'=>'raw',
        ),
		array(
			'header'=>'Rata-rata per Hari',
			'value'=>'$data->pencucian',
			'type'=>'raw',
        ),
    ),
)); ?> 
