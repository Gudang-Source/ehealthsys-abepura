
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gzmenudiet-m-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#MenuDietM_jenisdiet_id',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
                <table style="width:500px">
                    <tr>
                        <td colspan="2">
                            <?php // echo $form->textFieldRow($model,'jenisdiet_id'); ?>
                            <?php echo $form->dropDownListRow($model,'jenisdiet_id',
                            CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
                            array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'empty'=>'-- Pilih --',)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $form->textFieldRow($model,'menudiet_nama',array('onkeyup'=>"namaLain(this)",'onkeypress'=>"return $(this).focusNextInputField(event)", 'size'=>60,'maxlength'=>200)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $form->textFieldRow($model,'menudiet_namalain',array('onkeypress'=>"return $(this).focusNextInputField(event)", 'size'=>60,'maxlength'=>200)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="2">
                            <div class='control-group'>
                                  <?php echo $form->labelEx($model,'daftartindakan_id',array('class'=>'control-label')); ?>
                             <div class="controls">
                                 <?php echo $form->hiddenField($model,'daftartindakan_id',array('class'=>'span1')); ?>
                                    <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                            'name' => CHtml::activeId($model, 'daftartindakan_nama'),
                                            'value' => empty($model->daftartindakan_id)?"-":$model->daftartindakan->daftartindakan_nama,
                                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/tarifTindakanDiet'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'focus' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.harga_tariftindakan);
                                                        return false;
                                                    }',
                                                'select' => 'js:function( event, ui ) {
                                                                $(this).val(ui.item.harga_tariftindakan);
                                                                $("#MenuDietM").val(ui.item.daftartindakan_id);
                                                                    return false;
                                                              }'
                                            ),
                                            'htmlOptions' => array(
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'placeholder'=>'Ketikan Nama Tindakan',
                                                'class'=>'span3',
                                                'style'=>'width:100px;',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogTarifDiet',),
                                        ));
                                    ?>
                             </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->textFieldRow($model,'jml_porsi',array('class'=>'span2','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:50px;')); ?>
                        </td>
                        <td>
                                <?php echo $form->dropDownList($model,'ukuranrumahtangga',
                                CHtml::listData($model->URTItems, 'lookup_name', 'lookup_value'),
                                array('class'=>'inputRequire span2', 'style'=>"margin-right:150px;",'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'empty'=>'-- Pilih --',)); ?>
                        </td>
                    </tr>
                </table>
	
                <fieldset>
                  <div id="divZatgizi">
                      <span class="help-block">Kandungan Menu Diet :</span>
                              <?php
                              $datas = ZatgiziM::model()->findAll(array(
                                'order'=>'zatgizi_nama',
                              ));
                              $md = CHtml::listData($modZatMenuDietM, 'zatgizi_id', 'kandunganmenudiet');
                              $gid = array();
                              foreach ($md as $idx=>$val) {
                                  array_push($gid, $idx);
                              }
                              $returnVal = array();
                              $tr = ''; $inputHiddenZatgizi = '<input type="hidden" size="4" name="zatgizi_id[]" readonly="true"/>';
                              /* $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span3" style="width:500px;"><th> Pilih Semua <br/>'.CHtml::checkBox('checkUncheck', false, array('onclick'=>'checkUncheckAll(this);')).'</th>
                                                  <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>'; */
                              $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered table-striped span1" style="width:400px; float:left;"><th> Pilih </th>
                                                  <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>';
                              foreach ($datas as $data)
                              {
                                  $c = false; $v = 0;
                                  if (in_array($data->zatgizi_id, $gid)) {
                                      $c = true; $v = $md[$data->zatgizi_id];
                                  }
                                  $tr .= "<tr><td>";
                                  $tr .= CHtml::checkBox('zatgizi_id[]', $c, array('value'=>$data->getAttribute('zatgizi_id')));
                                  $tr .= '</td><td width="100%">'.$data->getAttribute('zatgizi_nama');
                                  $tr .= '</td><td nowrap>'.CHtml::textField("kandunganmenudiet[$data->zatgizi_id]", $v, array('size'=>6,'class'=>'default numbers-only span1', 'style'=>'text-align: right'));
                                  $tr .= ' '.$data->zatgizi_satuan;
                                  $tr .= "</td></tr>";
                              }
                              $returnVal .= $tr;
                              $returnVal .= '</table>';
                              echo $returnVal;
                              ?>
                        </div>
                  </div>
              </fieldset>
            <div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit', 'id'=>'btn_simpan','onKeyUp'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/menuDietM/admin'), 
                            array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Menu Diet', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                            $this->createUrl('menuDietM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                <?php
                    $content = $this->renderPartial('../tips/tipsaddedit3a',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                ?>
            </div>
        
<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data Tarif Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTarifDiet',
    'options'=>array(
        'title'=>'Daftar Tarif Diet',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modTarifDiet = new TariftindakanM('search');
$modTarifDiet->unsetAttributes();
$modTarifDiet->komponentarif_id = 6;
if(isset($_GET['TariftindakanM'])) {
    $modTarifDiet->attributes = $_GET['TariftindakanM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'tarifdiet-m-grid',
	'dataProvider'=>$modTarifDiet->searchTarifDiet(),
	'filter'=>$modTarifDiet,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                                $(\"#MenuDietM_daftartindakan_nama\").val(\"".$data->daftartindakan->daftartindakan_nama."\");
                                                $(\"#MenuDietM_daftartindakan_id\").val(\"$data->daftartindakan_id\");                                              
                                                $(\"#dialogTarifDiet\").dialog(\"close\");    
                                                return false;
                            "))',
                ),
                array(
                    'header'=>'Daftar Tindakan',
                    'name'=>'daftartindakan_nama',
                    'value'=>'$data->daftartindakan->daftartindakan_nama',
                ),
                array(
                    'header'=>'Tindakan Medis',
                    'name'=>'tindakanmedis_nama',
                    'value'=>'$data->daftartindakan->tindakanmedis_nama',
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'name'=>'kelaspelayanan_nama',
                    'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                ),
                array(
                    'header'=>'Harga Tarif Diet',
                    'name'=>'harga_tariftindakan',
                    'value'=>'MyFormatter::formatNumberForPrint($data->harga_tariftindakan)',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Tarif Diet dialog =============================
?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('MenuDietM_menudiet_namalain').value = nama.value.toUpperCase();
    }
</script>