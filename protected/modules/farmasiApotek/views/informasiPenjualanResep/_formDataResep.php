<?php // $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
//	'id'=>'penjualanresep-form',
//	'enableAjaxValidation'=>false,
//        'type'=>'horizontal',
////        'focus'=>'#FAPendaftaranT_instalas    i_id',
//        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
//                             'onsubmit'=>'return cekInput();'),
//));?>
<div class="row-fluid" >
    <div class="span4">
            <?php
                    echo $form->hiddenField($modPenjualan,'penjualanresep_id',array('readonly'=>true));
                ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($modPenjualan,'tglresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$modPenjualan,
                                            'attribute'=>'tglresep',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                                'yearRange'=> "-60:+0",
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'style'=>'width:128px;','onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                        )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPenjualan,'noresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($modPenjualan,'noresep',array('readonly'=>true, 'style'=>'width:170px;')); ?><br>
                        </div>
                    </div>
                    <div class="control-group">  
                    <?php echo $form->labelEx($modPenjualan,'pegawai_id', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modPenjualan,'pegawai_id'); ?>
                        <?php echo CHtml::hiddenField('reseptur_id'); ?>
                            <div style="float:left;">
                                <?php
                                    $modReseptur->dokter = (isset($modPenjualan->pegawai->nama_pegawai)? $modPenjualan->pegawai->nama_pegawai:"");
                                    $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$modReseptur,
                                        'attribute'=>'dokter',
                                        'sourceUrl'=>  Yii::app()->createUrl('ActionAutoComplete/ListDokter'),
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength'=>2,
                                            'select'=>'js:function( event, ui ) {
                                                    $("#'.CHtml::activeId($modPenjualan,'pegawai_id').'").val(ui.item.pegawai_id);
                                                        }',
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                        'htmlOptions'=>array('value'=>$modReseptur->getDokter(),'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','style'=>'float:left;')
                                    ));
                                ?>
                            </div>
                    </div>          
                    </div>

                    <?php 
                        echo $form->hiddenField($modPenjualan,'discount',array('class'=>'inputFormTabel lebar3 integer','readonly'=>true,'onkeyup'=>'hitungDiskonSemua();', 'onkeypress'=>"return $(this).focusNextInputField(event)"));
                    ?>
    </div>
    <div class="span4">
        <div class="control-group ">
            <?php echo $form->labelEx($modPenjualan,'tglpenjualan', array('class'=>'control-label')) ?>
            <div class="controls">
            <?php   
                $this->widget('MyDateTimePicker',array(
                                'model'=>$modPenjualan,
                                'attribute'=>'tglpenjualan',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    'yearRange'=> "-60:+0",
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'style'=>'width:128px;', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
            )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPenjualan,'jenispenjualan',array('readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

        <div class="control-group ">
            <?php echo $form->labelEx($modPenjualan,'lamapelayanan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenjualan,'lamapelayanan',array('class'=>'inputFormTabel lebar3 integer','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?> Menit
            </div> 
        </div>
    </div>
    <div class="span4">
        <?php echo $form->dropDownListRow($modPenjualan,'carabayar_id', CHtml::listData($modPenjualan->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
                'ajax' => array('type'=>'POST',
                    'url'=> $this->createUrl('SetDropdownPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($modPenjualan))), 
                    'success'=>'function(data){$("#'.CHtml::activeId($modPenjualan, "penjamin_id").'").html(data);}',
                ),
                'class'=>'span3',
         )); ?>
        <?php echo $form->dropDownListRow($modPenjualan,'penjamin_id', CHtml::listData($modPenjualan->getPenjaminItems($modPenjualan->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
    </div>
</div>
<?php // $this->endWidget(); ?>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM('searchByDokter');
$modPegawai->unsetAttributes();
if(isset($_GET['PegawaiM'])){
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modPegawai->searchByDokter(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#'.CHtml::activeId($modPenjualan,'pegawai_id').'\").val(\"$data->pegawai_id\");
                            $(\"#'.CHtml::activeId($modReseptur,'dokter').'\").val(\"$data->nama_pegawai\");
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        'gelardepan',
        'nama_pegawai',
        'jeniskelamin',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>