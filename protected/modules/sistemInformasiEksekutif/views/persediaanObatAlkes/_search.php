<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'search-laporan',
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
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian Berdasarkan :</legend>
    <div class="row-fluid">
        <div class="span4">
            <?php echo CHtml::label('Kunjungan', 'tanggal_kunjungan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('onchange' => 'ubahJnsPeriode();')); ?>
            </div>
        </div>
        <div class="span4">
            <div class='control-group hari'>
                <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> 

            </div>
            <div class='control-group bulan'>
                <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyMonthPicker', array(
                        'model' => $model,
                        'attribute' => 'bln_awal',
                        'options' => array(
                            'dateFormat' => Params::MONTH_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> 
            </div>
            <div class='control-group tahun'>
                <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
        </div>
        <div class="span4">
            <div class='control-group hari'>
                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> 
            </div>
            <div class='control-group bulan'>
                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyMonthPicker', array(
                        'model' => $model,
                        'attribute' => 'bln_akhir',
                        'options' => array(
                            'dateFormat' => Params::MONTH_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> 
            </div>
            <div class='control-group tahun'>
                <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
        </div> 
    </div>
    <div class="row-fluid">
        <div class="span4">
            <?php
            echo $form->dropDownListRow($model, 'instalasi_id', $instalasiAsals, array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array('type' => 'POST',
                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                    'update' => "#" . CHtml::activeId($model, 'ruangan_id'),
            )));
            ?>
        </div>
        <div class=""span4>
            <?php echo $form->dropDownListRow($model, 'ruangan_id', $ruanganAsals, array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="row-fluid">
        <!--<div class="form-actions">-->
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->route) . '";}); return false;'));
        ?>								
        <!--</div>-->
    </div>
    <?php //$this->widget('TipsMasterData', array('type' => 'create'));  ?>   
</div>   

<?php
$this->endWidget();
?>

<script type="text/javascript">
    function refreshForm() {
        window.location.href = "<?php echo Yii::app()->createUrl($this->route); ?>";
    }

    function ubahJnsPeriode() {
        var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode') ?>");
        if (obj.val() == 'hari') {
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        } else if (obj.val() == 'bulan') {
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        } else if (obj.val() == 'tahun') {
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }

    ubahJnsPeriode();
</script>