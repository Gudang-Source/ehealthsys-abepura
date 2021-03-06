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

$modTarifTindakan = new DaftartindakanM('search');
$modTarifTindakan->unsetAttributes();
//$modTarifTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['DaftartindakanM'])) {
    $modTarifTindakan->attributes = $_GET['DaftartindakanM'];
}

$provider = $modTarifTindakan->search();
//$provider->criteria->select = $provider->criteria->group = "daftartindakan_id, daftartindakan_nama, kelaspelayanan_id, kelaspelayanan_nama";
//$provider->criteria->select .= ", sum(harga_tariftindakan) as harga_tariftindakan";

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id'=>'satarif-tindakan-m-grid', 
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTarifTindakan->search(), //$modTarifTindakan->search(),
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
                                                          $(\"#RMTindakanrmM_daftartindakan_nama\").val(\"".$data->daftartindakan_nama."\");
                                                          $(\"#dialogDaftarTindakan\").dialog(\"close\");    
                                                "))',
        ),
        // array( 
        //                 'name'=>'tariftindakan_id', 
        //                 'value'=>'$data->tariftindakan_id', 
        //                 'filter'=>false, 
        //         ),
        array(
                'name'=>'kelompoktindakan_nama',
                'header'=>'Kelompok Tindakan',                
                'type'=>'raw',                
                'filter'=> CHtml::dropDownList('DaftartindakanM[kelompoktindakan_nama]',$modTarifTindakan->kelompoktindakan_nama,CHtml::listData(KelompoktindakanM::model()->findAll("kelompoktindakan_aktif = TRUE ORDER BY kelompoktindakan_nama"), 'kelompoktindakan_nama', 'kelompoktindakan_nama'), array('empty'=>'--Pilih')),           
                'value'=>'$data->kelompoktindakan->kelompoktindakan_nama',
            ),  
            //'kelompoktindakan_nama',
            array(
                'name'=>'kategoritindakan_nama',
                'header'=>'Kategori Tindakan',                
                'type'=>'raw',                
                'filter'=> CHtml::dropDownList('DaftartindakanM[kategoritindakan_nama]',$modTarifTindakan->kategoritindakan_nama,CHtml::listData(KategoritindakanM::model()->findAll("kategoritindakan_aktif = TRUE ORDER BY kategoritindakan_nama"), 'kategoritindakan_nama', 'kategoritindakan_nama'), array('empty'=>'--Pilih--')),           
                'value'=>'$data->kategoritindakan->kategoritindakan_nama',
            ),
            //'kategoritindakan_nama',
            'daftartindakan_kode',
            'daftartindakan_nama',   
       /* array( 
                        'name'=>'kelaspelayanan_id', 
                        'value'=>'$data->kelaspelayanan_nama',
                        'filter'=>CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif = true'), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                ), */
        /*
        array( 
                        'name'=>'harga_tariftindakan', 
                        'value'=>'number_format($data->harga_tariftindakan,0,".",",")', 
                        'filter'=>false, 
                        'htmlOptions'=>array('style'=>'text-align: right;'),
                ), */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end daftar tindakan dialog =============================
?>