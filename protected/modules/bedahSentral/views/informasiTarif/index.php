<div class="white-container">
    <legend class="rim2">Infomasi Tarif <b>Bedah Sentral</b></legend>
    <div class="block-tabel">
        <h6>Tabel Tarif <b>Bedah Sentral</b></h6>
        <?php 
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarTindakan-grid',
            'dataProvider'=>$modTarifTindakanRuanganV->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                'jenistarif_nama',
                'kelompoktindakan_nama',
                'komponenunit_nama',
                'kategoritindakan_nama',
                'daftartindakan_nama',
                'kelaspelayanan_nama',
                array(
                    'name'=>'tarifTotal',
                    'value'=>'$this->grid->getOwner()->renderPartial(\'_tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                 array(
                        'name'=>'persencyto_tind',
                        'htmlOptions'=>array('style'=>'text-align: right'),
                    ), 
                array(
                        'name'=>'persendiskon_tind',
                        'htmlOptions'=>array('style'=>'text-align: right'),
                    ),
                array(
                    'name'=>'Komponen Tarif',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id, "jenistarif_id"=>$data->jenistarif_id)) ,array("title"=>"Klik Untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))', 'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'formCari',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#SARuanganM_instalasi_id',
            'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
        )); ?>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif'=>true), array('order'=>'jenistarif_nama ASC')), 'jenistarif_id', 'jenistarif_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelompoktindakan_id', CHtml::listData(KelompoktindakanM::model()->findAllByAttributes(array('kelompoktindakan_aktif'=>true), array('order'=>'kelompoktindakan_nama ASC')), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'komponenunit_id', CHtml::listData(KomponenunitM::model()->findAllByAttributes(array('komponenunit_aktif'=>true), array('order'=>'komponenunit_nama ASC')), 'komponenunit_id', 'komponenunit_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kategoritindakan_id',CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kelaspelayanan_id',CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($modTarifTindakanRuanganV,'daftartindakan_nama',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30, 'placeholder'=>'Ketik nama daftar tindakan')); ?>
                </td>
            </tr>
        </table>          
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php 
              $content = $this->renderPartial('../tips/informasiTarif',array(),true);
                           $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetailsTarif',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Komponen Tarif',
                        'autoOpen'=>false,
                        'width'=>300,
                        'height'=>350,
                        'resizable'=>false,
                        'scroll'=>false    
                         ),
                    ));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
?>
<script type="text/javascript">
$('form#formCari').submit(function(){
    $('#daftarTindakan-grid').addClass('animation-loading');
    $.fn.yiiGridView.update('daftarTindakan-grid', {
            data: $(this).serialize()
    });
    return false;
});
</script>