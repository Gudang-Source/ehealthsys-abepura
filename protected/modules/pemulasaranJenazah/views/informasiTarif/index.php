<div class='white-container'>
    <legend class="rim2">Informasi Tarif <b>Pemularasan Jenazah</b></legend>
    <div class='block-tabel'>
        <h6>Tabel Tarif <b>Pemularasan Jenazah</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarTindakan-grid',
            'dataProvider'=>$modTarifTindakanRuanganV->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                'kelompoktindakan_nama',
                'kategoritindakan_nama',
                'daftartindakan_nama',
                'kelaspelayanan_nama',
                array(
                        'name'=>'tarifTotal',
                        'value'=>'$this->grid->getOwner()->renderPartial(\'_tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                ),
                'persencyto_tind',
                'persendiskon_tind',
                array(
                        'name'=>'Komponen Tarif',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id)) ,array("title"=>"Klik Untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))',
                ),                
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class='box'>
        <legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
        <?php
        // ===========================Dialog Details Tarif=========================================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id'=>'dialogDetailsTarif',
                                // additional javascript options for the dialog plugin
                                'options'=>array(
                                'title'=>'Komponen Tarif',
                                'autoOpen'=>false,
                                'width'=>300,
                                'height'=>300,
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

        $('#search').submit(function(){
                $.fn.yiiGridView.update('daftarTindakan-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ", CClientScript::POS_READY);
        ?>

        <?php
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                'id'=>'search',
                'type'=>'horizontal',
                'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                'focus'=>'#'.CHtml::activeId($modTarifTindakanRuanganV,'daftartindakan_nama'),

        )); ?>
        <table width='100%'>
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif'=>true)), 'jenistarif_id', 'jenistarif_nama'), array('class'=>'span3')); ?>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kategoritindakan_id',CHtml::listData(TariftindakanperdaruanganV::model()->getKategoritindakanItems(),'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kelaspelayanan_id',CHtml::listData(TariftindakanperdaruanganV::model()->getKelasPelayananItems(),'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($modTarifTindakanRuanganV,'daftartindakan_nama',array('placeholder'=>'Ketik Nama Daftar Tindakan')); ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                     array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
             <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
             <?php 
                   $content = $this->renderPartial('../tips/informasi3',array(),true);
                                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
        </div>
    <?php $this->endWidget(); ?>
    </fieldset>
</div>