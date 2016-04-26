<legend class="rim"><i class="icon-white icon-search"></i> Pencarian Berdasarkan : </legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus' => '#BKLaporanKeseluruhan_instalasi_id',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        #ruangan label{
            width: 120px;
            display:inline-block;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
    </style>  
    <table width="100%">
        <tr>
            <td width="50%">
                <div class="control-group ">
                    <div class='control-label'>Tanggal Kunjungan&nbsp;</div>
                    <div class='controls'>
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php //echo CHtml::hiddenField('src', ''); ?>                    
                        <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                        ?>                    
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')); ?>
                    <label class="control-label">Instalasi</label>
                    <div class="controls">
                        <?php 
                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'ajax' => array('type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                    'update' => '#ruangan',  //selector to update
                                ),
                            ));                    
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')); ?>
                    <label class="control-label">Ruangan</label>
                    <div class="controls">
                        <div id="ruangan">
                            <label>Data Tidak Ditemukan</label>
                        </div>
                    </div>
                </div>            
            </td>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::label(' sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <div style="float:left;margin-right:6px;">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onClick'=>'onReset()')); ?>
        </div>         
        <div style="clear:both;"></div>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<script type="text/javascript">
    function cek_all_ruangan(obj){
        if($(obj).is(':checked')){
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    
    function cek_all_penjamin(obj){
        if($(obj).is(':checked')){
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>