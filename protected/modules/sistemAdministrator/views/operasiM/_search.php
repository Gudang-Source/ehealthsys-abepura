<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'bsoperasi-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <label class="control-label" for="bidang">Daftar Tindakan</label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('daftartindakan_id'); ?>
                    <?php 
                        $this->widget('MyJuiAutoComplete', array(

                                        'name'=>'daftartindakan_nama',
            //                                            'value'=>$model->daftartindakan->daftartindakan_nama,
                                        'value'=>$model->getDaftarTindakanNama($model->daftartindakan_id),
                                        'source'=>'js: function(request, response) {
                                                       $.ajax({
                                                           url: "'.$this->createUrl('AutocompleteDaftarTindakan').'",
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
                                                    $("#daftartindakan_id").val(ui.item.daftartindakan_id);
                                                    $("#daftartindakan_nama").val(ui.item.daftartindakan_nama);
                                                    return false;
                                                }',
                                        ),
                                        'htmlOptions'=>array(
                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'placeholder'=>"Daftar Tindakan",
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogTindakan'),
                                    )); 
                     ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->dropDownlistRow($model,'kegiatanoperasi_id',  CHtml::listData(SAKegiatanOperasiM::model()->getAllItems(), 'kegiatanoperasi_id', 'kegiatanoperasi_nama'),array('empty'=>'- Pilih -','class'=>'span2', 'style'=>'width:160px','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'operasi_kode',array('class'=>'span3','maxlength'=>20)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'operasi_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td colspan="2">
            <?php echo $form->textFieldRow($model,'operasi_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'operasi_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'operasi_id',array('class'=>'span5')); ?>

	<?php //echo $form->dropDownlistRow($model,'daftartindakan_id',  CHtml::listData(DaftartindakanM::model()->getAllItems(), 'daftartindakan_id', 'daftartindakan_nama'),array('empty'=>'- Pilih -','class'=>'span2', 'style'=>'width:160px', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Tindakan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTindakan',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modTindakanRad = new TariftindakanperdatotalV('search');
$modTindakanRad->unsetAttributes();
if(isset($_GET['TariftindakanperdatotalV']))
    $modTindakanRad->attributes = $_GET['TariftindakanperdatotalV'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'sainstalasi-m-grid',
    'dataProvider'=>$modTindakanRad->search(),
    'filter'=>$modTindakanRad,
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
                                "id" => "selectTindakan",
                                "onClick" => "
                                $(\"#daftartindakan_id\").val(\'$data->daftartindakan_id\');
                                $(\"#daftartindakan_nama\").val(\'$data->daftartindakan_nama\');
                                $(\'#dialogTindakan\').dialog(\'close\');return false;"))'
            ),
            'kelompoktindakan_nama',
            'kategoritindakan_nama',
            'daftartindakan_kode',
            'daftartindakan_nama',
            'harga_tariftindakan',
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>