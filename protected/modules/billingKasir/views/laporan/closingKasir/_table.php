<?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'laporanclosingkasir-m-grid',
	'dataProvider'=>$model->searchInformasi(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
        'mergeHeaders'=>array(
            array(
                'name'=>'<center>Penerimaan</center>',
                'start'=>4, 
                'end'=>5, 
            ),
            array(
                'name'=>'<center>Banyaknya</center>',
                'start'=>9, 
                'end'=>11, 
            ),
        ),
	'columns'=>array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'name'=>'tglclosingkasir',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->tglclosingkasir))',
                ),
                array(
                    'name'=>'closingdari',
                    'header'=>'Closing Dari <br>Sampai Dengan',
                    'type'=>'raw',
                    'value'=>'date("d/m/Y H:i:s",strtotime($data->closingdari))." <br> ".date("d/m/Y H:i:s",strtotime($data->sampaidengan))',
                ),
//                'nama_pegawai',
//                'shift_nama',
                array(
                    'name'=>'closingsaldoawal',
                    'type'=>'raw',
                    'value'=>'number_format($data->closingsaldoawal)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'terimauangmuka',
                    'type'=>'raw',
                    'value'=>'number_format($data->terimauangmuka)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'terimauangpelayanan',
                    'type'=>'raw',
                    'value'=>'number_format($data->terimauangpelayanan)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'totalpengeluaran',
                    'type'=>'raw',
                    'value'=>'number_format($data->totalpengeluaran)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'nilaiclosingtrans',
                    'type'=>'raw',
                    'value'=>'number_format($data->nilaiclosingtrans)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'totalsetoran',
                    'type'=>'raw',
                    'value'=>'number_format($data->totalsetoran)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'jmltransaksi',
                    'type'=>'raw',
                    'value'=>'number_format($data->jmltransaksi)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'jmluanglogam',
                    'type'=>'raw',
                    'value'=>'number_format($data->jmluanglogam)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'jmluangkertas',
                    'type'=>'raw',
                    'value'=>'number_format($data->jmluangkertas)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'name'=>'piutang',
                    'type'=>'raw',
                    'value'=>'number_format($data->piutang)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                'keterangan_closing',
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>