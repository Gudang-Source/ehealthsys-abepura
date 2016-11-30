<legend class="rim"><i class="icon-white icon-search"></i> Pencarian : </legend>
<div class="search-form">
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'searchLaporan',
            'type'=>'horizontal',
    )); ?>
    <div class = "row-fluid">
     <div class="span4">
                    <?php $format = new MyFormatter(); ?>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php echo CHtml::label('Tanggal Pembebasan', 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                    </div>
                </div>
                <div class="span4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                        </div> 

                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_awal',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                        </div> 
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div> 
                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls"> 
                            <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_akhir',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                        </div> 
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
    </div>
    <table width = "100%">
        <tr>
            <td>            
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Pegawai kasir</legend>
                    <div class = "row-fluid">
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly'=>true)); ?>
                        <?php echo CHtml::label('Nama Dokter', 'nama_dokter', array('class' => 'control-label', 'style'=>'text-align:center;')) ?>
                        <div class="controls">
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
                    </div>
                </fieldset>                
            </td>
            <td>            
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Ruangan <?php echo CHtml::checkBox('cek_ruangan', true, array('onchange'=>'cek_all_ruangan(this)','value'=>'cek_ruangan'));?></legend>
                    <div class = "row-fluid">
                    <div class="controls">
                        <?php //echo $form->hiddenField($model, 'pegawai_id', array('readonly'=>true)); ?>
                        <?php //echo CHtml::label('Nama Dokter', 'nama_dokter', array('class' => 'control-label', 'style'=>'text-align:center;')) ?>
                        <div class="controls">
                            <?php
                               echo $form->checkBoxList($model, 'create_ruangan', CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('inline'=>true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                              ?>
                        </div>
                        </div>
                    </div>
                </fieldset>                
            </td>
        </tr>
        <tr>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Shift </legend>
                    <div class = "row-fluid">
                    <div class="controls">
                        <?php //echo $form->hiddenField($model, 'pegawai_id', array('readonly'=>true)); ?>
                        <?php //echo CHtml::label('Nama Dokter', 'nama_dokter', array('class' => 'control-label', 'style'=>'text-align:center;')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownlistRow($model,'shift_id',Chtml::listData($model->ShiftItems, 'shift_id', 'shift_nama'),array('empty'=>'Semua','class'=>'span3')); ?>
                        </div>
                        </div>
                </fieldset>
            </td>
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
</div>
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

$modPeg = new PegawairuanganV('search');
$modPeg->unsetAttributes();
$modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])){
    $modPeg->attributes = $_GET['PegawairuanganV'];
    $modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
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
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>