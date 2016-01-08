<?php 
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = "\n{items}";
} else{
  $data = $model->searchTable();
  $template = "{summary}\n{items}\n{pager}";
}
?>
<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Golongan Umur</center>',
                'start'=>2, //indeks kolom 3
                'end'=>9, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Jenis Kelamin</center>',
                'start'=>10, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            'diagnosa_nama',
            'umur_0_28hr',
            'umur_28hr_1thn',
                        'umur_1_4thn',
            'umur_5_14thn',
            'umur_15_24thn',
            'umur_25_44thn',
            'umur_45_64thn',
            'umur_65',
            'lakilaki',
            'perempuan',
            array(
                'header'=>'Jumlah Kunjungan',
                'value'=>'$data->jumlahkunjungan',
            ),
            /*

            'diagnosa_id',
            'diagnosa_kode',
            
            'diagnosa_namalainnya',
            'diagnosa_nourut',
            'golonganumur_id',
            , */
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>