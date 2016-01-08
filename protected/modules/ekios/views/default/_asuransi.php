<style>
    .table thead tr th{
        /*height: 78px;*/
        font-size:12pt;
        font-family: monospace;
    }
    .table tbody tr td{
        /*height: 78px;*/
        font-size:11pt;
        font-family: monospace;
    }
    .summary {margin:0;padding:0;border:0;font-size:100%;font-family:monospace;vertical-align:baseline;}
    .pagination a{
        float:left;padding:0 8px;
        line-height:24px;
        text-decoration:none;
        border:1px solid #ddd;
        border-left-width:0;
        -moz-border-right-colors: Peru;
        -moz-border-left-colors: Peru;
        -moz-border-top-colors: Peru;
        -moz-border-bottom-colors: Peru;
        padding: 0 15px;
    }
    .pagination a:hover,.pagination .active a{background-color:#FFEBCD;}
    .pagination .active a{color:#4682B4;cursor:default;}
    hr{border:0;border-top:1px solid #eeeeee;border-bottom:1px solid #ffffff;margin:1px}
    

</style>
<div class="block-kioskmodule" id="asuransi" name="asuransi">
	<legend class="rim">ASURANSI</legend>
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ekpenjamin-pasien-m-grid',
	'dataProvider'=>EKPenjaminPasienM::model()->search_ekios(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
                'header'=>'ID',
                'value'=>'$data->penjamin_id',
                ),
            array(
                'name'=>'carabayar_id',
                'filter'=>  CHtml::listData(CarabayarM::model()->CaraBayarItems, 'carabayar_id', 'carabayar_nama'),
                'value'=>'$data->carabayar->carabayar_nama',
                ),
            array(
                'header'=>'Nama Asuransi',
                'value'=>'$data->penjamin_nama',
                ),
            'penjamin_namalainnya',
			array(
                'header'=>Yii::t('zii','View'),
                'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-eye-open\"></i>",Yii::app()->controller->createUrl("Default/view",array("id"=>$data->penjamin_id)),
                           array("class"=>"", 
                                 "target"=>"iframeViewAsuransi",
                                 "onclick"=>"$(\"#dialogViewAsuransi\").dialog(\"open\");",
                                 "rel"=>"tooltip",
                                 "title"=>"Klik untuk melihat asuransi",
                           ))',
                'htmlOptions' => array('style'=>'text-align:center'),
                ),
		),
    	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
	)); ?>

</div>	
<?php 
// Dialog buat lihat menampilkan detail asuransi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogViewAsuransi',
    'options'=>array(
        'title'=>'View Data Asuransi',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>400,
        'minHeight'=>200,
        'resizable'=>false,
        'close'=>'js:function(){$.fn.yiiGridView.update(\'ekpenjamin-pasien-m-grid\', {})}'
    ),
));
?>
<iframe src="" name="iframeViewAsuransi" width="100%" height="250" >

</iframe>
<?php $this->endWidget(); ?>
