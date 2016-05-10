<div class="white-container">
    <legend class="rim2">Infomasi Tarif <b>Rehab Medis</b></legend>    
    <div class="block-tabel">
        <h6>Tabel Tarif <b>Rehab Medis</b></h6>    	
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarTindakan-grid',
            'dataProvider'=>$modTarifTindakanRuanganV->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                  /*  array(
                        'header'=>'No.',
                        'value'=>'$row+1',
                    ),*/
                    'jenistarif_nama',
                    'kelompoktindakan_nama',
                    'komponenunit_nama',
                    'kategoritindakan_nama',
                    'daftartindakan_nama',
                    'kelaspelayanan_nama',                    
    //                'ruangan_id',

                  array(
                            'name'=>'tarifTotal',
                            'value'=>'$this->grid->getOwner()->renderPartial("_tarifTotal",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id,"jenistarif_id"=>$data->jenistarif_id),true)',
                            'htmlOptions'=>array('style'=>'text-align: right;')
                    ),
                array(
                    'name'=>'persencyto_tind',
                    'htmlOptions'=>array('style'=>'text-align: right;')
                ),
                array(
                    'name'=>'persendiskon_tind',
                    'htmlOptions'=>array('style'=>'text-align: right;')
                ),
                array(
                            'name'=>'Komponen Tarif',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                            'value'=>'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("idKelasPelayanan"=>$data->kelaspelayanan_id,"idDaftarTindakan"=>$data->daftartindakan_id, "idKategoriTindakan"=>$data->kategoritindakan_id, "jenistarif_id"=>$data->jenistarif_id)) ,array("title"=>"Klik Untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))',
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <?php
        // ===========================Dialog Details Tarif=========================================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'dialogDetailsTarif',
                // additional javascript options for the dialog plugin
                'options'=>array(
                'title'=>'Komponen Tarif',
                'autoOpen'=>false,
                'width'=>350,
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

        Yii::app()->clientScript->registerScript('search', "

        $('form#formCari').submit(function(){
                $.fn.yiiGridView.update('daftarTindakan-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ", CClientScript::POS_READY);
        ?>

        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'formCari',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#SARuanganM_instalasi_id',
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

        )); ?>
        <?php //echo $form->dropDownListRow($modTarifTindakanRuanganV,'daftartindakan_id',CHtml::listData(TariftindakanperdaruanganV::model()->findAll(), 'daftartindakan_id', 'daftartindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
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
                    <?php echo $form->textFieldRow($modTarifTindakanRuanganV,'daftartindakan_nama',array('style'=>'width:204px', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Ketik Nama Daftar Tindakan')); ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
                                                    array('class'=>'btn btn-blue', 'type'=>'button', 'onclick'=>'printTarif()')); ?>
                <?php 
                   $content = $this->renderPartial('../tips/informasiTarif',array(),true);
                                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
                ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    
</div>
<?php $urlPrint = $this->createUrl('print'); ?>
<script>
    function printTarif() {
        //console.log("<?php echo $urlPrint; ?>&" + $("#formCari").serialize());
        window.open("<?php echo $urlPrint; ?>&" + $("#formCariInput :input").serialize() +"&caraPrint=PRINT","",'location=_new, width=900px');
    }
</script>