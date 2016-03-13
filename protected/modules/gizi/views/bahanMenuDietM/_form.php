
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'bahanmenudiet-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#menudiet',
        		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
                                <div class="control-label">Menu Diet <span class="required">*</span></div>
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
                                <div class="control-label">Bahan Makanan <span class="required">*</span></div>
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
                                <div class="control-label">Jumlah Bahan</div>
                                <div class="controls">
		<?php echo $form->textField($model,'jmlbahan',array('class'=>'span1','onkeypress'=>"return $(this).focusNextInputField(event);" )); ?>
                                    <?php echo CHtml::textField('satuan','',array('readonly'=>true,'class'=>'span2'))  ?>
                                </div>
                                <div class="controls">
                                         <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                                        array(
                                                                'onclick'=>'submitBahanMenuDiet();
                                                                                  return false;',
                                                                'class'=>'btn btn-primary',
                                                                'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                'rel'=>"tooltip",
                                                                'id'=>'tambahbahanmenudiet',  
                                                                'title'=>"Klik Untuk Menambahkan Bahan",
                                                                )
                                                        );
                                         ?>
                                </div>
                                <div class="row-fluid">
                                    <table id="tableBahanMenuDiet" class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <th><?php echo CHtml::checkBox('checkListUtama',true,array('onclick'=>'checkAll(\'cekList\',this);', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?></th>
                                            <th>Menu Diet</th>
                                            <th>Bahan Makanan</th>
                                            <th>Jumlah Bahan</th>
                                            <th>Satuan</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                
	<div class="form-actions">
		                    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                      Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                      array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeyUp'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                      Yii::app()->createUrl($this->module->id.'/bahanMenuDietM/admin'), 
                                      array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bahan Menu Diet', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('bahanMenuDietM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        <?php
                            $content = $this->renderPartial('../tips/tipsaddedit3c',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
        </div>
<!-- =========================== Widget DialogBox ========================================= -->
<?php $this->endWidget(); ?>
<?php

   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMenuDiet',
    'options'=>array(
        'title'=>'Pencarian Menu Diet',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
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
        'itemsCssClass'=>'table table-striped table-condensed',
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
                            'name' => 'jenisdiet_id',
                            'filter'=> CHtml::dropDownList('GZMenuDietM[jenisdiet_id]',$modMenuDiet->jenisdiet_id,CHtml::listData($modMenuDiet->getJenisdietItems(),'jenisdiet_id','jenisdiet_nama'),array('empty'=>'--Pilih--')),
                            'value'=>'$data->jenisdiet->jenisdiet_nama',
                        ),
                        array(
                            'header'=>'Nama Menu Diet',
                            'name' => 'menudiet_nama',
                            'value'=>'$data->menudiet_nama',
                        ),
                        array(
                            'header'=>'Jumlah Porsi',
                            'name' => 'jml_porsi',
                            'value'=>'$data->jml_porsi',
                        ),
                        array(
                            'header'=>'URT',
                            'name' => 'ukuranrumahtangga',
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
        'height'=>600,
        'resizable'=>false,
    ),
));
   
$modBahanMakanan = new GZBahanmakananM('search');
$modBahanMakanan->unsetAttributes();
if(isset($_GET['GZBahanmakananM'])) {
    $modBahanMakanan->attributes = $_GET['GZBahanmakananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'bahanmakanan-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modBahanMakanan->search(),
	'filter'=>$modBahanMakanan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
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
                            'name' => 'golbahanmakanan_id',
                            'filter'=> CHtml::dropDownList('GZBahanmakananM[golbahanmakanan_id]',$modBahanMakanan->golbahanmakanan_id,CHtml::listData($modBahanMakanan->getGolBahanMakananItems(),'golbahanmakanan_id','golbahanmakanan_nama'), array('empty'=>'--Pilih--')),
                            'value'=>'$data->golbahanmakanan->golbahanmakanan_nama',
                        ),
                        array(
                            'header'=>'Jenis Bahan',
                            'name' => 'jenisbahanmakanan',
                            'value'=>'$data->jenisbahanmakanan',
                        ),
                        array(
                            'header'=>'Kelompok Makanan',
                            'name' => 'kelbahanmakanan',
                            'value'=>'$data->kelbahanmakanan',
                        ),
                        array(
                            'header'=>'Nama Bahan Makanan',
                            'name' => 'namabahanmakanan',
                            'value'=>'$data->namabahanmakanan',
                        ),
                        array(
                            'header'=>'Jumlah Persediaan',
                            'name' => 'jmlpersediaan',
                            'value'=>'$data->jmlpersediaan',
                        ),
                        array(
                            'header'=>'Satuan',
                            'name' => 'satuanbahan',
                            'value'=>'$data->satuanbahan',
                        ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
<!-- ========================================= endWidget Bahan Makanan ====================== -->
<?php
$urlGetBahanMenuDiet = $this->createUrl('GetBahanMenuDiet');
?>
        
<?php
$jscript = <<< JS
function submitBahanMenuDiet()
{
    menudiet_id = $('#BahanMenuDietM_menudiet_id').val();
    bahanmakanan_id = $('#BahanMenuDietM_bahanmakanan_id').val();
    jmlbahan = $('#BahanMenuDietM_jmlbahan').val();
    satuan = $('#satuan').val();
    if(menudiet_id==''){
        myAlert('Silahkan Pilih Menu Terlebih Dahulu');
    }else{
        $.post("${urlGetBahanMenuDiet}", { menudiet_id:menudiet_id, bahanmakanan_id:bahanmakanan_id, jmlbahan:jmlbahan, satuan:satuan},
        function(data){
            $('#tableBahanMenuDiet').append(data.return);
        }, "json");
    }   
}
function checkAll(kelas,obj)
{
    if(obj.checked) {
        $('.'+kelas+'').each(function() {
            $(this).attr('checked', 'checked');
        });
    }
    else
    {
        obj.checked = false;
        $('.'+kelas+'').each(function() {
            $(this).removeAttr('checked');
        });
    }
}
JS;

Yii::app()->clientScript->registerScript('bahanmenudiet',$jscript, CClientScript::POS_HEAD);
?>