<div class="white-container">
    <legend class="rim2">Data <b>Tabular List</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <table width="100%">
        <tr>
            <td width="35%">
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
                <div class="block-tabel" id="dtd-div">
                    <h6>Tabel <b>Diagnosa X</b></h6>
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
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="search-form">
            <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'id'=>'search',
                    'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
                    'focus'=>'#'.CHtml::activeId($modDTDM,'dtd_kode'),
            )); ?>

            <?php echo $form->hiddenField($modDiagnosa,'diagnosa_id',array('class'=>'span3','maxlength'=>50)); ?>
                             <?php echo $form->hiddenField($modDTDM,'tabularlist_id',array('class'=>'span3','maxlength'=>50)); ?>
            <div id='search-diagnosa' style="display: none;">
                <table width="100%">
                    <tr>
                        <td>
                            <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_kode',array('placeholder'=>'Ketik Kode','class'=>'span3','maxlength'=>10)); ?>
                            <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_nama',array('placeholder'=>'Ketik Nama','class'=>'span3','maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_namalainnya',array('placeholder'=>'Ketik Nama Lain','class'=>'span3','maxlength'=>50)); ?>
                            <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_katakunci',array('placeholder'=>'Ketik Kata Kunci','class'=>'span3','maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_nourut',array('class'=>'span3')); ?>
                            <?php echo $form->checkBoxRow($modDiagnosa,'diagnosa_imunisasi'); ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div id='search-dtd' style="display: block;">
                <table width="100%">
                    <tr>
                        <td>
                            <?php echo $form->textFieldRow($modDTDM,'dtd_kode',array('placeholder'=>'Ketik Kode','class'=>'span3','maxlength'=>10)); ?>
                            <?php echo $form->textFieldRow($modDTDM,'dtd_nama',array('placeholder'=>'Ketik Nama','class'=>'span3','maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($modDTDM,'dtd_namalainnya',array('placeholder'=>'Ketik Nama Lainnya','class'=>'span3','maxlength'=>50)); ?>
                            <?php echo $form->textFieldRow($modDTDM,'dtd_katakunci',array('placeholder'=>'Ketik Kata Kunci','class'=>'span3','maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($modDTDM,'dtd_nourut',array('class'=>'span3')); ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="form-actions">
                 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
                 ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php 
                    $content = $this->renderPartial('../tips/informasi',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
            </div>
        </div>    
    </fieldset>
</div>
<?php $this->endWidget(); ?>

<?php
$tabularlist_id = CHtml::activeId($modDTDM,'tabularlist_id');
$dtd_id = CHtml::activeId($modDiagnosa,'dtd_id');
$js = <<< JSCRIPT
function cariDtd(obj,tabularlist_id)
{
    $(obj).parent().find("div").html("rizky");
    $('#diagnosa-div').attr("style","display:none");
    $('#dtd-div').attr("style","display:block");
    $('#search-dtd').show();
    $('#search-diagnosa').hide();
        
    $("#${tabularlist_id}").val(tabularlist_id);    
//    $.fn.yiiGridView.update('dtd-grid', {
//            data: $(this).serialize()
//    });
    $.fn.yiiGridView.update('dtd-grid', {
            data: { RJDtdM_tabularlist_id : tabularlist_id}
    });

}
   
function cariDiagnosa(dtd_id)
{
    $('#diagnosa-div').attr("style","display:block");
    $('#dtd-div').attr("style","display:none");
    $('#search-dtd').hide();
    $('#search-diagnosa').show();
    
    $("#${dtd_id}").val(dtd_id);
//    $.fn.yiiGridView.update('diagnosa-grid', {
//            data: $(this).serialize()
//    });
     $.fn.yiiGridView.update('diagnosa-grid', {
            data: { RJDiagnosaM_dtd_id : dtd_id}
    });
}


JSCRIPT;
Yii::app()->clientScript->registerScript('search',$js,CClientScript::POS_HEAD);                        

$js = <<< JSCRIPT
$('#search').submit(function(){
	$.fn.yiiGridView.update('diagnosa-grid', {
		data: $(this).serialize()
	});
	$.fn.yiiGridView.update('dtd-grid', {
		data: $(this).serialize()
	});
	return false;
});
JSCRIPT;
Yii::app()->clientScript->registerScript('search-form',$js,CClientScript::POS_READY);                        

?>


