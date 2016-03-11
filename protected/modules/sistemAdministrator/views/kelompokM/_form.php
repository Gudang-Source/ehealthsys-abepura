

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelompok-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#golonganNama',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
            <div class="control-group ">
                    <label class="control-label" for="bidang">Golongan</label>
                    <div class="controls">
                        <?php echo $form->hiddenField($model,'golongan_id'); ?>
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            
                                            'name'=>'golonganNama',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/getGolongan').'",
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
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) { 
                                                        $("#'.CHtml::activeId($model, 'golongan_id').'").val(ui.item.golongan_id);
                                                        $("#golonganNama").val(ui.item.golongan_nama);
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogGolongan'),
                                        )); 
                        ?>
                    </div>
                </div>
            <?php //Echo CHtml::hiddenField('tempKode', $model->kelompok_kode); ?>
            <?php echo $form->textFieldRow($model,'kelompok_kode',array('class'=>'span1 ', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,)); ?>
            
            <?php echo $form->textFieldRow($model,'kelompok_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'kelompok_namalainnya',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php //echo $form->checkBoxRow($model,'kelompok_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '',
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
           
    <?php
echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$content = $this->renderPartial($this->path_tips.'tipsaddedit3a',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogGolongan',
    'options'=>array(
        'title'=>'Golongan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modGolongan = new SAKelompokM('search');
$modGolongan->unsetAttributes();
if(isset($_GET['SAKelompokM']))
    $modGolongan->attributes = $_GET['SAKelompokM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sainstalasi-m-grid',
	'dataProvider'=>$modGolongan->search(),
	'filter'=>$modGolongan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small", 
                                    "id" => "selectGolongan",
                                    "onClick" => "
                                    $(\"#'.CHtml::activeId($model, 'golongan_id').'\").val($data->golongan_id);
                                    $(\"#golonganNama\").val(\'$data->golonganNama\');
                                    $(\'#dialogGolongan\').dialog(\'close\');return false;"))'
                ),
                array(
                        'header'=>'Golongan',
                        'filter'=>  CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),
                        'value'=>'$data->golongan->golongan_nama',
                ),
                array(
                        'header'=>'Kelompok',
                        'filter'=>  CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
                        'value'=>'$data->kelompok_nama',
                ),
                array(
                        'header'=>'Sub Kelompok',
//                        'filter'=>  CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),
                        'type'=>'raw',
                        
                        'value'=>'$this->grid->getOwner()->renderPartial("'.$this->path_view.'"\'listSubKelompok\', array(\'idKelompok\'=>$data->kelompok_id))',
                ),
//                array(
//                        'header'=>'bidang_id',
//                        'filter'=>  CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
//                        'type'=>'raw',
//                        'value'=>'$this->grid->getOwner->renderPartial(\'listBidang\',array(\'idKelompok\'=>\'$data->kelompok_id\'))',
//                ),
		
                
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<?php 
//Yii::app()->clientScript->registerScript('head','
//    function setKode(obj){
//        var value = $("#tempKode").val();
//        var objValue = $(obj).val();
//        if (objValue < value){
//           $(obj).val(value);
//        }
//    }
//',  CClientScript::POS_HEAD); ?>
<?php //JS;
//Yii::app()->clientScript->registerScript('jsBarang',$jscript, CClientScript::POS_BEGIN);
//
//$js = <<< JS
//$('.numbersOnly').keyup(function() {
//var d = $(this).attr('numeric');
//var value = $(this).val();
//var orignalValue = value;
//value = value.replace(/[0-9]*/g, "");
//var msg = "Only Integer Values allowed.";
//
//if (d == 'decimal') {
//value = value.replace(/\./, "");
//msg = "Only Numeric Values allowed.";
//}
//
//if (value != '') {
//orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
//$(this).val(orignalValue);
//}
//});
//JS;
//Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);?>
