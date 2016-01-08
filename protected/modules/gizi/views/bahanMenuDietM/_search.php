<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
                'type'=>'horizontal',
	'method'=>'get',
     'id'=>'gzbahanmenudiet-m-search',
)); ?>

		<?php //echo $form->textFieldRow($model,'bahanmenudiet_id'); ?>
		<?php //echo $form->textFieldRow($model,'menudiet_id'); ?>
		<?php //echo $form->textFieldRow($model,'bahanmakanan_id'); ?>
        
        <div class="control-label">Menu Diet</div>
        <div class="controls">        
                <?php // echo $form->textFieldRow($model,'menudiet_id'); ?>
                <?php echo CHtml::ActiveHiddenField($model,'menudiet_id', '', array('readonly'=>true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                                       'name'=>'menudiet', 
                                        'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.Yii::app()->createUrl('ActionAutoComplete/MenuDiet').'",
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
                                                       $("#BahanMenuDietM_menudiet_id").val(ui.item.menudiet_id);
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
        <div class="control-label">Bahan Makanan</div>
        <div class="controls">
                <?php // echo $form->textFieldRow($model,'bahanmakanan_id'); ?>
                <?php echo CHtml::ActiveHiddenField($model,'bahanmakanan_id', '', array('readonly'=>true)) ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                                       'name'=>'bahanmakanan', 
                                        'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.Yii::app()->createUrl('ActionAutoComplete/BahanMakanan').'",
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
                                                       $("#BahanMenuDietM_bahanmakanan_id").val(ui.item.bahanmakanan_id);
                                                       $("#satuan").val(ui.item.satuanbahan);
                                                        return false;
                                                    }',
                                        ),
                                        'htmlOptions'=>array(
                                            'readonly'=>false,
                                            'placeholder'=>'Bahan Makanan',
                                            'size'=>13,
                                            'onkeypress'=>"return $(this).focusNextInputField(event);" 
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogBahanMakanan'),
                                )); ?>
        </div>
		<?php echo $form->textFieldRow($model,'jmlbahan'); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
<?php

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
if(isset($_GET['SAMenuDietM'])) {
    $modMenuDiet->attributes = $_GET['SAMenuDietM'];
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
                                                    "onClick" => "\$(\"#BahanMenuDietM_menudiet_id\").val(\"$data->menudiet_id\");
                                                                          \$(\"#menudiet\").val(\"$data->menudiet_nama\");
                                                                          \$(\"#dialogMenuDiet\").dialog(\"close\");"
                                             )
                             )',
                        ),
                        array(
                            'header'=>'Jenis Diet',
                            'filter'=>CHtml::listData($modMenuDiet->getJenisdietItems(),'jenisdiet_id','jenisdiet_nama'),
                            'value'=>'$data->jenisdiet->jenisdiet_nama',
                        ),
                        array(
                            'header'=>'Nama Menu Diet',
                            'value'=>'$data->menudiet_nama',
                        ),
                        array(
                            'header'=>'Jumlah Porsi',
                            'value'=>'$data->jml_porsi',
                        ),
                        array(
                            'header'=>'URT',
                            'value'=>'$data->ukuranrumahtangga',
                        ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ========================================= endWidget MenuDiet =============================== */

   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogBahanMakanan',
    'options'=>array(
        'title'=>'Pencarian Bahan Makanan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
    ),
));
   
$modBahanMakanan = new GZBahanmakananM('search');
$modBahanMakanan->unsetAttributes();
if(isset($_GET['SABahanMakananM'])) {
    $modBahanMakanan->attributes = $_GET['SABahanMakananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'bahanmakanan-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modBahanMakanan->search(),
	'filter'=>$modBahanMakanan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectBahanMakanan",
                                                    "onClick" => "\$(\"#BahanMenuDietM_bahanmakanan_id\").val($data->bahanmakanan_id);
                                                                          \$(\"#bahanmakanan\").val(\"$data->namabahanmakanan\");
                                                                          \$(\"#satuan\").val(\"$data->satuanbahan\");
                                                                          \$(\"#dialogBahanMakanan\").dialog(\"close\");"
                                             )
                             )',
                        ),
                        array(
                            'header'=>'Golongan Bahan',
                            'filter'=>CHtml::listData($modBahanMakanan->getGolBahanMakananItems(),'golbahanmakanan_id','golbahanmakanan_nama'),
                            'value'=>'$data->golbahanmakanan->golbahanmakanan_nama',
                        ),
                        array(
                            'header'=>'Jenis Bahan',
                            'value'=>'$data->jenisbahanmakanan',
                        ),
                        array(
                            'header'=>'Kelompok Makanan',
                            'value'=>'$data->kelbahanmakanan',
                        ),
                        array(
                            'header'=>'Nama Bahan Makanan',
                            'value'=>'$data->namabahanmakanan',
                        ),
                        array(
                            'header'=>'Jumlah Persediaan',
                            'value'=>'$data->jmlpersediaan',
                        ),
                        array(
                            'header'=>'Satuan',
                            'value'=>'$data->satuanbahan',
                        ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
<!-- ========================================= endWidget Bahan Makanan ====================== -->