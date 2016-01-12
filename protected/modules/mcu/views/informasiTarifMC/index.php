<div class="white-container">
    <legend class="rim2">Informasi Tarif <b>Medical Check Up</b></legend>
    <div class="block-tabel">
        <h6>Tabel Informasi <b>Tarif Medical Check Up</b></h6>
        <?php echo $this->renderPartial($this->path_view.'_table', array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));  ?> 
    </div>
    <fieldset class="box">
        <legend class="rim">Pencarian</legend>
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
                'focus'=>'#'.CHtml::activeId($modTarifTindakanRuanganV,'daftartindakan_nama'),
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

        )); ?>
        <table width="100%">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif'=>true)), 'jenistarif_id', 'jenistarif_nama'), array('class'=>'span3')); ?>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kategoritindakan_id',CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kelaspelayanan_id',CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($modTarifTindakanRuanganV,'daftartindakan_nama',array( 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Ketik Nama Daftar Tindakan', 'maxlength'=>30)); ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','ajax' => array(
                             'type' => 'GET', 
                             'url' => array("/".$this->route), 
                             'update' => '#daftarTindakan-grid',
                             'beforeSend' => 'function(){
                                                                      $("#daftarTindakan-grid").addClass("animation-loading");
                                                              }',
                             'complete' => 'function(){
                                                                      $("#daftarTindakan-grid").removeClass("animation-loading");
                                                              }',
                     ))); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                                    array('class'=>'btn btn-danger',
                                                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php 
               $content = $this->renderPartial('rawatJalan.views.tips.informasi',array(),true);
                    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </fieldset>
</div>