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
                'name'=>'<center>Keadaan Meninggal</center>',
                'start'=>10, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
//        'tglmorbiditas',
            'diagnosa_nama',
//        'kasusdiagnosa',            
             array(
                'name' => 'umur_0_28hr',
                'htmlOptions' => array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'umur_28hr_1thn',
                'htmlOptions' => array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'umur_1_4thn',
                'htmlOptions' => array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'umur_5_14thn',
                'htmlOptions' => array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'umur_15_24thn',
                'htmlOptions' => array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'umur_25_44thn',
                'htmlOptions' => array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'umur_45_64thn',
                'htmlOptions' => array('style'=>'text-align:center;'),
            ),
            array(
                'name' => 'umur_65',
                'htmlOptions' => array('style'=>'text-align:center;'),
            ),
            array(
                    'name' => 'kondisipulang1',
                    'header'=>'< 48 Jam',
                    'value' => '$data->kondisipulang1',
                    'htmlOptions' => array('style'=>'text-align:center;'),
//                    'footer'=>'sum(kondisipulang1)',
                ),
            array(
                    'name' => 'kondisipulang2',
                    'header'=>'> 48 Jam',
                    'value' => '$data->kondisipulang2',
                    'htmlOptions' => array('style'=>'text-align:center;'),
//                    'footer'=>'sum(kondisipulang2)',
                ),
//            'kondisipulang1',
//            'kondisipulang2',
            array(
                'header'=>'Jumlah',
                'value'=>'(isset($data->jumlahkunjungan) ? $data->jumlahkunjungan : 0)',
                'htmlOptions' => array('style'=>'text-align:center;'),
            )
//            'jumlahkunjungan',
        /*
        'diagnosa_id',
        'diagnosa_kode',
        
        'diagnosa_namalainnya',
        'diagnosa_nourut',
        'golonganumur_id',
        'kondisipulang',
        'carakeluar',
           */
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>