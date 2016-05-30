
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'samenu-modul-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'kelmenu_id'),
         'htmlOptions'=>array('enctype'=>'multipart/form-data','onSubmit'=>'return requiredCheck(this);'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

<table width='100%' class="table-condensed">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'kelmenu_id', CHtml::listData($model->getKelompokMenuItems(), 'kelmenu_id', 'kelmenu_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'modul_id', CHtml::listData($model->getModulItems(), 'modul_id', 'modul_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'menu_nama',array('class'=>'span2', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'menu_namalainnya',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'menu_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->checkBoxRow($model,'menu_shortcut', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'menu_key',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
            <?php //echo $form->textFieldRow($model,'menu_url',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            <div class="control-group">
                <?php echo CHtml::label('Url', 'SAMenuModulK_menu_url', array('class'=>'control-label required')) ?>
                <div class="controls">
                    <?php echo CHtml::textField('SAMenuModulK[menu_url]', $model->menu_url, array('class'=>'span3','maxlength'=>100)); ?>
                    <?php echo CHtml::link('<i class="icon-edit icon-white"></i>','#', array('class'=>'btn btn-primary', 'onclick'=>'$("#dialogUrl").dialog("open"); return false;')); ?>
                </div>   
            </div>
            <?php echo $form->textAreaRow($model,'menu_fungsi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
            <?php //echo $form->fileFieldRow($model,'menu_icon',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'menu_icon',array('class'=>'control-label',)); ?>
                <div class="input-append">
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model,'menu_icon', array('class'=>'span3', 'maxlength'=>100)); ?>

                        <?php echo CHtml::link('<i class="icon-search icon-white"></i>','#', array('class'=>'btn btn-primary', 'onclick'=>'$("#dialogIcon").dialog("open"); return false;')); ?>
                    </div>
                </div>   
            </div>
<!--            <div class="control-group">
                <div class="controls">
                    <?php //echo CHtml::image(Params::urlIconMenuDirectory().$model->menu_icon, 'Icon '.$model->menu_nama, array()); ?>
                </div>   
            </div>-->
            <?php echo $form->textFieldRow($model,'menu_urutan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'onSubmit'=>'return requiredCheck(this);')); ?>
        </td>
    </tr>
</table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/menuModulK/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Menu', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('/sistemAdministrator/MenuModulK/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                <?php
                    $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogUrl',
    'options'=>array(
        'title'=>'URL',
        'autoOpen'=>false,
    'modal'=>true,
    ),
));
?>
        
<?php echo CHtml::beginForm($this->createUrl('GetControllers'), 'POST', ''); ?>
<?php echo CHtml::label('Nama Modul', 'namaModul', array('class'=>'control-label')) ?>
<?php echo CHtml::dropDownList('namaModul', '', CustomFunction::getModules(),array(
                                'ajax' => array('type'=>'POST',
                                                'url'=> $this->createUrl('GetControllers',array('encode'=>false)), 
                                                'update'=>'#namaController'  //selector to update
                ),)
); ?>
<?php echo CHtml::label('Nama Controller', 'namaController', array('class'=>'control-label')) ?>
<?php echo CHtml::dropDownList('namaController', '', array(),array(
                                'ajax' => array('type'=>'POST',
                                                'url'=> $this->createUrl('GetActions',array('encode'=>false)), 
                                                'update'=>'#namaAction'  //selector to update
                ),)
); ?>
<?php echo CHtml::label('Nama Action', 'namaAction', array('class'=>'control-label')) ?>
<?php echo CHtml::dropDownList('namaAction', '', array()); ?>

<div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds','Ok'), '#', array('class'=>'btn btn-primary', 'onclick'=>'createURL(); return false;')); ?>
    <?php echo CHtml::link(Yii::t('mds','Cancel'), '#', array('class'=>'btn btn-danger', 'onclick'=>'$("#dialogUrl").dialog("close"); return false;')); ?>
</div>
<?php echo CHtml::endForm(); ?>
        
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogIcon',
    'options'=>array(
        'title'=>'Pilih Icon',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'height'=>500,
        'resizable'=>false,
    ),
));

$modIconDialog = new SALookupM('search');
$modIconDialog->unsetAttributes();
$lookup_type = 'menu_icon';
$format = new MyFormatter();
if (isset($_GET['SALookupM'])){
    $modIconDialog->attributes = $_GET['SALookupM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'lookup-m-grid',
    'dataProvider'=>$modIconDialog->searchLookup($lookup_type),
    'filter'=>$modIconDialog,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#'.CHtml::activeId($model,'menu_icon').'\").val(\"$data->lookup_name\");
                            $(\"#dialogIcon\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),

        array(
            'header'=>'Icon',
            'value'=>'"<i class=$data->lookup_name></i>"',
            'type'=>'raw',
        ),        
        array(
            'header'=>'Nama Icon',
            'name'=>'lookup_name',
            'value'=>'$data->lookup_name',
            'type'=>'raw',
        ),
        array(
            'header'=>'Nama Menu',
            'name'=>'lookup_kode',
            'value'=>'$data->lookup_kode',
            'type'=>'raw',
        ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>
<script type="text/javascript">
function createURL()
{
    var url = $('#namaModul').val();
    if($('#namaController').val()!=null)
        url = url + '/' + $('#namaController').val();
    if($('#namaAction').val()!=null)
        url = url + '/' + $('#namaAction').val();
    
    $('#SAMenuModulK_menu_url').val(url);
    $("#dialogUrl").dialog("close");
}

function namaLain(nama)
{
    document.getElementById('SAMenuModulK_menu_namalainnya').value = nama.value.toUpperCase();
    document.getElementById('SAMenuModulK_menu_key').value = nama.value;
}
</script>
        