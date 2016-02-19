<?php 
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemeriksaLengkap',
    'options'=>array(
        'title'=>'Dokter Pemeriksa',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>256,
        'resizable'=>false,
    ),
));
?> 
    <table>
        <tr>
            <td>
                <?php echo CHtml::hiddenField('baris', '', array('id'=>'rowTindakan','readonly'=>true)) ?>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'Dokter Pemeriksa'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokterpemeriksa1_id',
                                    'value'=>'',
                                    'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokterpemeriksa1_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterPemeriksa1(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(1);"),
                                    'htmlOptions'=>array(
										'onblur' => 'if(this.value === ""){ $("#dokterpemeriksa1_id").val("");updateDokterPemeriksa1(this.value);} ',
										'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokterdelegasi_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokterdelegasi_id',
                                    'value'=>'',
                                    'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokterdelegasi_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterDelegasi(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(3);"),
                                    'htmlOptions'=>array(
										'onblur' => 'if(this.value === ""){ $("#dokterdelegasi_id").val("");updateDokterDelegasi(this.value);} ',
										'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokteranastesi_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokteranastesi_id',
                                    'value'=>'',
                                    'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokteranastesi_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterAnastesi(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(4);"),
                                    'htmlOptions'=>array(
										'onblur' => 'if(this.value === ""){ $("#dokteranastesi_id").val("");updateDokterAnastesi(this.value);} ',
										'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <!-- <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokterpemeriksa2_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokterpemeriksa2_id',
                                    'value'=>'',
                                    'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokterpemeriksa2_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterPemeriksa2(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(2);"),
                                    'htmlOptions'=>array(
										'onblur' => 'if(this.value === "") $("#dokterpemeriksa2_id").val(""); ',
										'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'dokterpendamping_id'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'dokterpendamping_id',
                                    'value'=>'',
                                    'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#dokterpendamping_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setDokterPendamping(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'tombolDialog'=>array("idDialog"=>'dialogDokter', 'jsFunction'=>"setPilihDokter(5);"),
                                    'htmlOptions'=>array(
										'onblur' => 'if(this.value === "") $("#dokterpendamping_id").val(""); ',
										'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                 -->
            </td>
            
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'perawat_1'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'bidan_id',
                                    'value'=>'',
                                    'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetBidan'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#bidan_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setBidan(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array(
										'onblur' => 'if(this.value === ""){ $("#bidan_id").val("");updateBidan(this.value);} ',
										'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'perawat_2'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'suster_id',
                                    'value'=>'',
                                    'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetSuster'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#suster_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setSuster(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array(
										'onblur' => 'if(this.value === ""){ $("#suster_id").val("");updateSuster(this.value);} ',
										'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modTindakan, 'perawat_3'); ?>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'perawat_id',
                                    'value'=>'',
                                    'sourceUrl'=> Yii::app()->createUrl('rawatInap/tindakanTRI/GetPerawat'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#perawat_id").val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setPerawat(ui.item);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array(
										'onblur' => 'if(this.value === ""){ $("#perawat_id").val("");updatePerawat(this.value);} ',
										'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="">
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ok',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'onKeypress'=>'return formSubmit(this,event)',
                                                      'onclick'=>'$("#dialogPemeriksaLengkap").dialog("close");')); ?>
                </div>
            </td>
        </tr>
    </table>
<?php

$this->endWidget();
//========= end pemeriksa dialog =============================
?>  


<?php 
//========= Dialog buat cari dokter =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Data Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>500,
        'height'=>500,
        'resizable'=>false,
    ),
));

$datDokter = new DokterV();
if (isset($_GET['DokterV'])) {
    $datDokter->attributes = $_GET['DokterV'];
}
$provider = $datDokter->search();
$provider->criteria->group = $provider->criteria->select = 'pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'dokter-v-grid2',
        'dataProvider'=>$provider,
        'filter'=>$modTindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectDokter",
                                    "onClick" => "pilihDokter(".$data->pegawai_id."); return false;"))',
                    //'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id').CHtml::activeHiddenField($modTindakan,'kelaspelayanan_id').CHtml::activeHiddenField($modTindakan,'penjamin_id').CHtml::activeHiddenField($modTindakan,'jenistarif_id'),
                ),
                array(
                    'name'=>'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'type'=>'raw',
//                        'filter'=>CHtml::activeHiddenField($modTindakan,'tipepaket_id'),
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end data dokter =============================
?> 
<script>
var idPilihDokter = 0;

function setPilihDokter(val) {
    idPilihDokter = val;
    $("#dialogDokter").dialog('open');
}

function pilihDokter(id) {
    $("#dialogDokter").dialog('close');
    $.post("<?php echo Yii::app()->createUrl('rawatInap/tindakanTRI/GetDokter'); ?>", {
        id: id
    }, function(data) {
        var res = data[0];
        switch(idPilihDokter) {
            case 1: setDokterPemeriksa1(res); $("#dokterpemeriksa1_id").val(res.label); break;
            case 2: setDokterPemeriksa2(res); $("#dokterpemeriksa2_id").val(res.label); break;
            case 3: setDokterDelegasi(res); $("#dokterdelegasi_id").val(res.label); break;
            case 4: setDokterAnastesi(res); $("#dokteranastesi_id").val(res.label); break;
            case 5: setDokterPendamping(res); $("#dokterpendamping_id").val(res.label); break;
        }
        
    }, 'json');
}


</script>