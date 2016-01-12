<fieldset class="box search-form">
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'searchLaporan',
            'type'=>'horizontal',
    )); ?>
    <table width="100%">
        <tr>
            <td>
                <?php echo CHtml::hiddenField('type', '', array('readonly'=>true)); ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal. Pembebasan',  CHtml::activeId($model, 'tgl_awal'), array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
							<?php $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal); ?>
                        </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::label('Sampai Dengan',CHtml::activeId($model, 'tgl_akhir'), array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>'dd M yy',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                        </div>
                </div> 
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td><legend class="rim" style="width: 300px;">Berdasarkan Pegawai Kasir</legend></td>
            <td><legend class="rim" style="width: 300px;">Berdasarkan Ruangan Kasir <?php echo CHtml::checkBox('cek_ruangan', true, array('onchange'=>'cek_all_ruangan(this)','value'=>'cek_ruangan'));?></legend></td>
            <td><legend class="rim" style="width: 300px;">Berdasarkan Shift</legend></td>
        </tr>
        <tr>
            <td>
                <?php // echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>
                <div class="control-group ">
                    <label class="control-label" for="nama_pegawai">Nama Pegawai Kasir</label>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly'=>true)) ?>
                        <?php 
                            $this->widget('MyJuiAutoComplete',
                                array(
                                    //'model'=>$model,
                                    //'attribute'=>'nama_pegawai',
                                    'name'=>'nama_pegawai',
                                    'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/ListKaryawan'),
                                    'options'=>array(
                                        'class'=>'span3',
                                        'showAnim'=>'fold',
                                        'minLength' => 2,
                                        'select'=>'js:function( event, ui ){
                                            $("#BKLaporanclosingkasirV_pegawai_id").val(ui.item.pegawai_id);
                                            $(this).val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                                        'focus'=> 'js:function( event, ui ) {
                                            $(this).val("");
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions'=>array(
                                        'placeholder'=>'Ketikan Nama Pegawai',
                                        'class'=>'span3'
                                    ),
                                    'tombolDialog'=>array(
                                        'idDialog'=>'dialogPegawai'
                                    ),
                                )
                            ); 
                        ?>                    
                    </div>
                </div>
            </td>
            <td><?php echo $form->checkBoxList($model, 'create_ruangan', CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('inline'=>true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?></td>
            <td><?php echo $form->dropDownlistRow($model,'shift_id',Chtml::listData($model->ShiftItems, 'shift_id', 'shift_nama'),array('empty'=>'Semua','class'=>'span3')); ?></td>
        </tr>
    </table>
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
             <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onclick'=>'resetForm();')); ?>
                                    <?php  
    //$content = $this->renderPartial('../tips/informasi',array(),true);
    //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
    </div>
    <?php $this->endWidget(); ?>
</fieldset>
<script type="text/javascript">
function resetForm(){
    window.open("<?php echo $this->createUrl("/".$this->route); ?>", "_self");
}

function cek_all_ruangan(obj){
    if($(obj).is(':checked')){
        $("#searchLaporan").find("input[type=\'checkbox\']").attr("checked", "checked");
    }else{
        $("#searchLaporan").find("input[type=\'checkbox\']").attr("checked", false);
    }
}
cek_all_ruangan($('#cek_ruangan'));
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>700,
        'height'=>450,
        'resizable'=>false,
    ),
));

$modPeg = new PegawaiM('search');
$modPeg->unsetAttributes();
if(isset($_GET['PegawaiM'])){
    $modPeg->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'cari-pegawai-m-grid',
    'dataProvider'=>$modPeg->search(),
    'filter'=>$modPeg,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"
                    $(\"#BKLaporanclosingkasirV_pegawai_id\").val(\"$data->pegawai_id\");
                    $(\"#nama_pegawai\").val(\"$data->NamaLengkap\");
                    $(\"#dialogPegawai\").dialog(\"close\");
                    return false;"
                )
            )'
        ),
        'nama_pegawai',
        'jeniskelamin',
        'nomorindukpegawai'
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>