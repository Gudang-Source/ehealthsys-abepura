<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rmtindakanrm-m-search',
        'type'=>'horizontal',
)); ?>
<table width='100%'>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'jenistindakanrm_id', CHtml::listData($model->getJenisTindakanItems(), 'jenistindakanrm_id', 'jenistindakanrm_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            <?php //echo $form->textFieldRow($model,'daftartindakan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
                <?php echo $form->label($model, 'daftartindakan_id', array('class' => 'control-label')); ?>
                <?php echo CHtml::ActiveHiddenField($model,'daftartindakan_id', '', array('readonly'=>true)) ?>
                <div class="controls">
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'daftartindakan_nama',
                                'sourceUrl' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/getDaftarTindakan').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   idKelasPelayanan: 5,
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                                $(this).val( ui.item.label);
                                                                return false;
                                                            }',
                                    'select' => 'js:function( event, ui ) {
                                                                      $("#RMTindakanrmM_daftartindakan_id").val(ui.item.daftartindakan_id);
                                                                      $(this).val(ui.item.label);
                                                                      return false;
                                                            }',
                                ),
                                'htmlOptions' => array('value' => '', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3 ',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogDaftarTindakan'),
                        ));
                        ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'tindakanrm_nama',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'tindakanrm_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'tindakanrm_aktif', array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data daftar tindakan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDaftarTindakan',
    'options' => array(
        'title' => 'Pencarian Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modTarifTindakan = new RMTarifTindakanM('search');
$modTarifTindakan->unsetAttributes();
$modTarifTindakan->kelaspelayanan_id = 0;
if (isset($_GET['SATarifTindakanM'])) {
    $modTarifTindakan->attributes = $_GET['SATarifTindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id'=>'satarif-tindakan-m-grid', 
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTarifTindakan->searchDaftarTindakan(),
    'filter' => $modTarifTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectDaftarTindakan",
                                            "onClick" => "$(\"#RMTindakanrmM_daftartindakan_id\").val(\"$data->daftartindakan_id\");
                                                          $(\"#RMTindakanrmM_daftartindakan_nama\").val(\"".$data->daftartindakan->daftartindakan_nama." - ".$data->kelaspelayanan->kelaspelayanan_nama." - ".$data->harga_tariftindakan."\");
                                                          $(\"#dialogDaftarTindakan\").dialog(\"close\");    
                                                "))',
        ),
        // array( 
        //                 'name'=>'tariftindakan_id', 
        //                 'value'=>'$data->tariftindakan_id', 
        //                 'filter'=>false, 
        //         ),
        array( 
                        'name'=>'daftartindakan_id', 
                        'value'=>'$data->daftartindakan->daftartindakan_nama',
                ),
        array( 
                        'name'=>'kelaspelayanan_id', 
                        'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                        'filter'=>CHtml::listData($modTarifTindakan->KelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                ),
        array( 
                        'name'=>'harga_tariftindakan', 
                        'value'=>'number_format($data->harga_tariftindakan,0,".",",")', 
                        'filter'=>false, 
                ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end daftar tindakan dialog =============================
?>