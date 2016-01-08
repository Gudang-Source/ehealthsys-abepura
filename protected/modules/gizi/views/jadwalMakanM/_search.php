<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'type'=>'horizontal',
)); ?>
<?php //echo $form->textFieldRow($model,'jenisdiet_nama',array('class'=>'span3')); ?>
<?php //echo $form->textFieldRow($model,'tipediet_nama',array('class'=>'span3')); ?>
<?php //echo $form->textFieldRow($model,'menudiet_nama',array('class'=>'span3')); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo CHtml::label('Jenis Diet','jjenisdiet',array('class'=>"control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('jenisdietid', '', array('readonly'=>true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                       'name'=>'jenisdiet', 
                        'source'=>'js: function(request, response) {
                               $.ajax({
                                   url: "'.$this->createUrl('Jenisdiet').'",
                                   dataType: "json",
                                   data: {
                                       term: request.term,
                                   },
                                   success: function (data) {
                                           response(data);
                                   }
                               })
                            }',
                        'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui )
                                       {
                                        $(this).val(ui.item.label);
                                        return false;
                                        }',
                                   'select'=>'js:function( event, ui ) {
                                       $("#jenisdietid").val(ui.item.jenisdiet_id);
                                       $("#jenisdiet_nama").val(ui.item.jenisdiet_nama);
                                        return false;
                                    }',
                        ),
                        'htmlOptions'=>array(
                            'readonly'=>false,
                            'placeholder'=>'Jenis Diet',
                            'size'=>13,
                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogJenisdiet'),
                )); ?>
            </div>
        </td>
        <td>
            <?php echo CHtml::label('Tipe Diet','ttipediet',array('class'=>"control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('tipedietid', '', array('readonly'=>true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                       'name'=>'tipediet', 
                        'source'=>'js: function(request, response) {
                               $.ajax({
                                   url: "'.$this->createUrl('TipeDiet').'",
                                   dataType: "json",
                                   data: {
                                       term: request.term,
                                   },
                                   success: function (data) {
                                           response(data);
                                   }
                               })
                            }',
                        'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui )
                                       {
                                        $(this).val(ui.item.label);
                                        return false;
                                        }',
                                   'select'=>'js:function( event, ui ) {
                                       $("#tipedietid").val(ui.item.tipediet_id);
                                       $("#tipediet_nama").val(ui.item.tipediet_nama);
                                        return false;
                                    }',
                        ),
                        'htmlOptions'=>array(
                            'readonly'=>false,
                            'placeholder'=>'Tipe Diet',
                            'size'=>13,
                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogTipeDiet'),
                )); ?>
            </div>
        </td>
        <td>
            <?php echo CHtml::label('Menu Diet','mmenudiet',array('class'=>"control-label")) ?>
            <div class="controls">
                            <?php echo CHtml::hiddenField('menudietid', '', array('readonly'=>true)) ?>
                            <?php $this->widget('MyJuiAutoComplete', array(
                       'name'=>'menudiet', 
                        'source'=>'js: function(request, response) {
                               $.ajax({
                                   url: "'.$this->createUrl('MenuDiet').'",
                                   dataType: "json",
                                   data: {
                                       term: request.term,
                                   },
                                   success: function (data) {
                                           response(data);
                                   }
                               })
                            }',
                        'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui )
                                       {
                                        $(this).val(ui.item.label);
                                        return false;
                                        }',
                                   'select'=>'js:function( event, ui ) {
                                       $("#menudietid").val(ui.item.menudiet_id);
                                        return false;
                                    }',
                        ),
                        'htmlOptions'=>array(
                            'readonly'=>false,
                            'placeholder'=>'Menu Diet',
                            'size'=>13,
                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogMenuDiet'),
                )); ?>
            </div>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>

<?php

   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogJenisdiet',
    'options'=>array(
        'title'=>'Pencarian Jenis Diet',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
        ),
    ));
   
$modJenisdiet = new GZJenisdietM('search');
$modJenisdiet->unsetAttributes();
if(isset($_GET['GZJenisdietM'])) {
    $modJenisdiet->attributes = $_GET['GZJenisdietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'jenisdiet-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modJenisdiet->search(),
	'filter'=>$modJenisdiet,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectJenisdiet",
                                                    "onClick" => "\$(\"#jenisdietid\").val($data->jenisdiet_id);
                                                                          \$(\"#jenisdiet\").val(\"$data->jenisdiet_nama\");
                                                                          \$(\"#dialogJenisdiet\").dialog(\"close\");"
                                             )
                             )',
                        ),
                'jenisdiet_nama',
                'jenisdiet_namalainnya',
                'jenisdiet_keterangan',
                'jenisdiet_catatan',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget Jenisdiet ---------------------------------------------- */

   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTipeDiet',
    'options'=>array(
        'title'=>'Pencarian Tipe Diet',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
    ),
));
   
$modTipeDiet = new GZTipeDietM('search');
$modTipeDiet->unsetAttributes();
if(isset($_GET['GZTipeDietM'])) {
    $modTipeDiet->attributes = $_GET['GZTipeDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'tipediet-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modTipeDiet->search(),
	'filter'=>$modTipeDiet,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectTipeDiet",
                                                    "onClick" => "\$(\"#tipedietid\").val($data->tipediet_id);
                                                                          \$(\"#tipediet\").val(\"$data->tipediet_nama\");
                                                                          \$(\"#dialogTipeDiet\").dialog(\"close\");
                                                                          \$(\"#tableJadwalMakan\").append(\"<tr><td>tes..</td></tr>\");"
                                             )
                             )',
                        ),
                'tipediet_nama',
                'tipediet_namalainnya',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget TipeDiet ---------------------------------------------- */


   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMenuDiet',
    'options'=>array(
        'title'=>'Pencarian Menu Diet',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
    ),
));
   
$modMenuDiet = new GZMenuDietM('search');
$modMenuDiet->unsetAttributes();
if(isset($_GET['GZMenuDietM'])) {
    $modMenuDiet->attributes = $_GET['GZMenuDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'menudiet-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modMenuDiet->search(),
	'filter'=>$modMenuDiet,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectTipeDiet",
                                                    "onClick" => "\$(\"#menudietid\").val($data->menudiet_id);
                                                                          \$(\"#menudiet\").val(\"$data->menudiet_nama\");
                                                                          \$(\"#dialogMenuDiet\").dialog(\"close\");"
                                             )
                             )',
                        ),
                'menudiet_nama',
                'menudiet_namalain',
                'jml_porsi',
                'ukuranrumahtangga',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget MenuDiet ---------------------------------------------- */
?>