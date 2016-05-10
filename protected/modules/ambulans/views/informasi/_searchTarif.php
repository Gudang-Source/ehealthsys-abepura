<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?> 
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<div class="search-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'pencarian-tarif',
        'focus'=>'#'.CHtml::activeId($modTarif, 'tarifambulans_kode'),
)); ?>

<!--  <div class="control-label"> Daftar Tindakan </div>
 <div class="controls">
     <?php echo $form->hiddenField($modTarif, 'daftartindakan_id',array('id'=>'daftartindakan_id')) ?>
     <?php $this->widget('MyJuiAutoComplete', array(
            'name'=>'daftartindakan', 
             'source'=>'js: function(request, response) {
                    $.ajax({
                        url: "'.Yii::app()->createUrl('ActionAutoComplete/Daftartindakan').'",
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
                        'minLength' => 1,
                        'focus'=> 'js:function( event, ui )
                            {
                             $(this).val(ui.item.daftartindakan_nama);
                             return false;
                             }',
                        'select'=>'js:function( event, ui ) {
                            $("#daftartindakan_id").val(ui.item.daftartindakan_id);
                             return false;
                         }',
             ),
             'htmlOptions'=>array(
                 'readonly'=>false,
                 'placeholder'=>'Daftar Tindakan',
                 'size'=>13,
                 'onkeypress'=>"return $(this).focusNextInputField(event);",
             ),
             'tombolDialog'=>array('idDialog'=>'dialogDaftartindakan'),
     )); ?>
 </div> -->
    <table width="100%">
        <tr>
            <td>
                <?php echo $form->textFieldRow($modTarif,'tarifambulans_kode',array('placeholder'=>'Kode Tarif','size'=>20,'maxlength'=>20,'class'=>'span2')); ?>
                <?php echo $form->dropDownListRow($modTarif,'kepropinsi_nama', CHtml::listData($modTarif->getPropinsiItems(), 'propinsi_nama', 'propinsi_nama'), 
                    array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                        'ajax'=>array('type'=>'POST','url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKabupaten',array('encode'=>false,'namaModel'=>'AMTarifambulansM')),
                        'update'=>'#AMTarifambulansM_kekabupaten_nama')));
                ?>
                <?php echo $form->dropDownListRow($modTarif,'kekabupaten_nama', array(), 
                    array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                        'ajax'=>array('type'=>'POST','url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKecamatan',array('encode'=>false,'namaModel'=>'AMTarifambulansM')),
                        'update'=>'#AMTarifambulansM_kekecamatan_nama')));
                ?>
            </td>
            <td>
                <?php echo $form->dropDownListRow($modTarif,'kekecamatan_nama', array(), 
                    array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                        'ajax'=>array('type'=>'POST','url'=>Yii::app()->createUrl('ActionDynamic/GetTarifKelurahan',array('encode'=>false,'namaModel'=>'AMTarifambulansM')),
                        'update'=>'#AMTarifambulansM_kekelurahan_nama')));
                ?>
                <?php echo $form->dropDownListRow($modTarif,'kekelurahan_nama', array(), 
                    array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",));
                ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modTarif,'tarifperkm',array('class'=>'span2 integer2')); ?>
                <?php echo $form->textFieldRow($modTarif,'tarifambulans',array('class'=>'span2 integer2')); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
         <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); 
            echo "&nbsp;";
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>								
            <?php
            $content = $this->renderPartial('../tips/informasiTarifAmbulans',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
