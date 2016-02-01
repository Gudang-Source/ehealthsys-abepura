<div class="white-container">
    <legend class="rim2">Informasi Diagnosa <b>ICD X</b></legend><?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <div class="box2">
        <table width="100%">
            <tr>
                <td width="30%">
                    <div style="height: 100%;"> 
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'tabular-grid',
                    'dataProvider'=>$modTabularList->searchRJ(),
                    'filter'=>$modTabularList,    
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
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


                    <div id="diagnosa-div" style="display: none;" >
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                        'id'=>'diagnosa-grid',
                        'dataProvider'=>$modDiagnosa->searchRJ(),
                        'filter'=>$modDiagnosa,
                        'template'=>"{summary}\n{items}\n{pager}",
                        'itemsCssClass'=>'table table-striped table-condensed',
                        'columns'=>array(	
                            array(
                                'name' => 'diagnosa_kode',
                                'filter' => CHtml::activeTextField($modDiagnosa, 'diagnosa_kode').CHtml::activeHiddenField($modDiagnosa, 'dtd_id', array('id'=>'diagnosa_dtd')),
                            ),
                                'diagnosa_nama',
                         ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});diagnosahideshow();}',
                        )); ?>
                    </div>
                </td>
                <td>
                        <?php echo $this->renderPartial('_table', array('modDTDM'=>$modDTDM));  ?>
                </td>   
            </tr>
        </table>
    </div>
    <?php /*
    <div class="search-form">
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'diagnosa-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                'focus'=>'#',
        )); ?>
        <fieldset class="box">
            <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
            <?php $this->renderPartial('rawatJalan.views.informasiTabularList._search', array('modDiagnosa'=>$modDiagnosa,'modDTDM'=>$modDTDM,'form'=>$form));  ?>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan','ajax' => array(
                     'type' => 'GET', 
                     'url' => array("/".$this->route), 
                     'update' => '#dtd-grid',
                     'beforeSend' => 'function(){
                                          $("#dtd-grid").addClass("animation-loading");
                                      }',
                     'complete' => 'function(){
                                          $("#dtd-grid").removeClass("animation-loading");
                                      }',
                ))); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/informasiTabularis/index'), 
                    array('class'=>'btn btn-danger',
                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php 
                    $content = $this->renderPartial('../tips/informasi',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
            </div>
        </fieldset>
        <?php $this->endWidget(); ?>
    </div>    
     * 
     */ ?>

    


<?php
$js = <<< JSCRIPT
function cariDtd(obj,tabularlist_id)
{
    $("#dtd_tabularlist_id").val(tabularlist_id);
    $('#diagnosa-div').attr("style","display:none");
    $('#dtd-div').attr("style","display:block");
        
        
        
    $.fn.yiiGridView.update('dtd-grid', {
            data: $("#dtd-grid :input").serialize()
    });

}
   
function cariDiagnosa(dtd_id)
{
    $("#diagnosa_dtd").val(dtd_id);    
    $.fn.yiiGridView.update('diagnosa-grid', {
            data: $("#diagnosa-grid :input").serialize()
    });
}

function diagnosahideshow()
{
     $('#diagnosa-div').attr("style","display:block");
     $('#dtd-div').attr("style","display:none");
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


