<div class="white-container">
    <legend class="rim2">Informasi <b>Diagnosa</b></legend><?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <table width="100%">
        <tr>
            <td width="35%">
                <div style="height: 100%;"> 
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'tabular-grid',
                'dataProvider'=>$modTabularList->searchRJ(),
                'filter'=>$modTabularList,    
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                   array(
                   'name'=>'tabularlist_chapter',
                   'type'=>'raw',
                   'value'=>'CHtml::link($data->tabularlist_chapter, "javascript:cariDtd(this,\'$data->tabularlist_id\');",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Klik Untuk Melihat DTD"))',
                   'htmlOptions'=>array('style'=>'text-align: left; width:120px'),
                    ),

                 ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )); ?>
                 </div>   
            </td>
            <td>
                <div id="dtd-div" style="display: block;" >
                     <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'dtd-grid',
                    'dataProvider'=>$modDTDM->searchRJ(),
                    'filter'=>$modDTDM, 
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(	
                            array(
                               'header'=>'Kode',
                               'type'=>'raw',
                               'value'=>'CHtml::link($data->dtd_kode, "javascript:cariDiagnosa(\'$data->dtd_id\');",array("id"=>"$data->dtd_id","rel"=>"tooltip","title"=>"Klik Untuk Melihat Diagnosa"))',
                               'htmlOptions'=>array('style'=>'text-align: left; width:120px')
                            ),
                            'dtd_kode',	
                            'dtd_nama',
                     ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    )); ?>
                </div>

                <div id="diagnosa-div" style="display: none;" >
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'diagnosa-grid',
                    'dataProvider'=>$modDiagnosa->searchRJ(),
					'filter'=>$modDiagnosa,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(	
                            'diagnosa_kode',	
                            'diagnosa_nama',
                     ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    )); ?>
                </div>
            </td>
        </tr>
    </table>
    <!-- <legend class="rim">Pencarian</legend> -->
    <div class="search-form">
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'diagnosa-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                'focus'=>'#',
        )); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$js = <<< JSCRIPT
function cariDtd(obj,tabularlist_id)
{
    $(obj).parent().find("div").html("rizky");
    $('#diagnosa-div').attr("style","display:none");
     $('#dtd-div').attr("style","display:block");
    $.fn.yiiGridView.update('dtd-grid', {
            data: { RDDtdM_tabularlist_id : tabularlist_id}
    });

}
   
function cariDiagnosa(dtd_id)
{
     $('#diagnosa-div').attr("style","display:block");
//     $('#dtd-div').attr("style","display:none");
     $.fn.yiiGridView.update('diagnosa-grid', {
//            data: { RDDiagnosaM_dtd_id : dtd_id}
    });
}


JSCRIPT;
Yii::app()->clientScript->registerScript('search',$js,CClientScript::POS_HEAD);                        

$js = <<< JSCRIPT
$('.search-form form').submit(function(){
        $('#diagnosa-div').attr("style","display:block");
     $('#dtd-div').attr("style","display:none");
	$.fn.yiiGridView.update('diagnosa-grid', {
		data: $(this).serialize()
	});
	return false;
});
JSCRIPT;
Yii::app()->clientScript->registerScript('search-form',$js,CClientScript::POS_READY);                        

?>


