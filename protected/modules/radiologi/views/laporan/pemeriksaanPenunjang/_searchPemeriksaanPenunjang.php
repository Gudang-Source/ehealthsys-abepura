<div class="search-form" style="">
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)'),
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
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian Berdasarkan : </legend>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group ">
                    <div class="control-label">
                        <?php
                            echo CHtml::label('Periode ','Periode ', array('class'=>'control-label'));
                            echo CHtml::hiddenField('page',0, array('class'=>'number_page'));
							echo CHtml::hiddenField('type', '');
                        ?>
                    </div>
                    <div class="controls">                        
                        <?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), 
                                array(
                                'onChange'=>'ubahJnsPeriode()',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'style'=>'width:120px;',
                                'style'=>'width:120px;float:left', 
                                'onchange'=>'ubahJnsPeriode();')); 
                        ?>
                    </div>                     
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
                                'maxDate'=>'d',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "dtPicker2",
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
                                'options'=>array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'class' => "dtPicker2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));  
                        ?>
                    </div> 
                </div>
                <div class='control-group tahun'>
                    <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php 
                        echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
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
                                'maxDate'=>'d',
                            ),
                            'htmlOptions' => array('readonly' => true,'class' => "dtPicker2",
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
                                'options'=>array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,'class' => "dtPicker2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));  
                        ?>
                    </div> 
                </div>
                <div class='control-group tahun'>
                    <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php 
                        echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                        ?>
                    </div>
                </div>                             
            </div>
        </div>
        <div class="form-actions">
            <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                            array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;'));  ?>
        </div>
    </fieldset>
</div>    
<?php $this->endWidget(); ?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#LBLaporanpemeriksaanpenunjangV_tgl_awal').val(data.periodeawal);
            $('#LBLaporanpemeriksaanpenunjangV_tgl_akhir').val(data.periodeakhir);
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode',$js,CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event){
            var namaPeriode = $('#PeriodeName').val();

            if(namaPeriode == ''){
                myAlert('Pilih Kategori Pencarian');
                event.preventDefault();
                $('#dtPicker3').datepicker("hide");
                return true;
                ;
            }
        }

</script>