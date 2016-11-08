<legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan :</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInfoKunjungan',
        'focus'=>'#'.CHtml::activeId($modPPInfoKunjunganV,'instalasi_id'),
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
     <!--   <legend>Kunjungan</legend> -->
       


    <div class="row-fluid">
    <div class="span4">
        <?php echo CHtml::label('Periode Laporan', 'tglmasukpenunjang', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPPInfoKunjunganV, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
        </div>
    </div>
    <div class="span4">
        <div class='control-group hari'>
            <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php $modPPInfoKunjunganV->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($modPPInfoKunjunganV->tgl_awal)))); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPPInfoKunjunganV,
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
                <?php $modPPInfoKunjunganV->tgl_awal = $format->formatDateTimeForDb($modPPInfoKunjunganV->tgl_awal); ?>
            </div> 

        </div>
        <div class='control-group bulan'>
            <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php $modPPInfoKunjunganV->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($modPPInfoKunjunganV->bln_awal)))); ?>
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $modPPInfoKunjunganV,
                    'attribute' => 'bln_awal',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'class' => "span2",
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
                <?php $modPPInfoKunjunganV->bln_awal = $format->formatMonthForDb(date('Y-m', (strtotime($modPPInfoKunjunganV->bln_awal)))); ?>
            </div> 
        </div>
        <div class='control-group tahun'>
            <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPPInfoKunjunganV, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class='control-group hari'>
            <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php $modPPInfoKunjunganV->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($modPPInfoKunjunganV->tgl_akhir)))); ?>
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPPInfoKunjunganV,
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
                <?php $modPPInfoKunjunganV->tgl_akhir = $format->formatDateTimeForDb($modPPInfoKunjunganV->tgl_akhir); ?>
            </div> 
        </div>
        <div class='control-group bulan'>
            <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
            <div class="controls">  
                <?php $modPPInfoKunjunganV->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($modPPInfoKunjunganV->bln_akhir)))); ?>
                <?php
                $this->widget('MyMonthPicker', array(
                    'model' => $modPPInfoKunjunganV,
                    'attribute' => 'bln_akhir',
                    'options' => array(
                        'dateFormat' => Params::MONTH_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => "span2",
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
                <?php $modPPInfoKunjunganV->bln_akhir = $format->formatMonthForDb(date('Y-m', (strtotime($modPPInfoKunjunganV->bln_akhir)))); ?>
            </div> 
        </div>
        <div class='control-group tahun'>
            <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList($modPPInfoKunjunganV, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
    <table width = "100%">
         <tr>
            <td>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                                    'id'=>'big',
                                                    'slide'=>false,
                                                    'content'=>array(
                                                            'content2'=>array(
                                                            'header'=>'Berdasarkan Instalasi dan Ruangan',
                                                            'isi'=>'<table>
                                                                                    <tr>
                                                                                            <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Instalasi</label></td>
                                                                                            <td>'.$form->dropDownList($modPPInfoKunjunganV, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                                                    'ajax' => array('type' => 'POST',
                                                                                                            'url' => $this->createUrl('GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.get_class($modPPInfoKunjunganV).'')),
                                                                                                            'update' => '#ruangan',  //selector to update
                                                                                                    ),
                                                                                            )).'
                                                                                            </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                            <td>
                                                                                                    <label>Ruangan</label>
                                                                                            </td>
                                                                                            <td>
                                                                                                    <div margin id="ruangan">
                                                                                                            <label>Data Tidak Ditemukan</label>
                                                                                                    </div>
                                                                                            </td>
                                                                                    </tr>
                                                                             </table>',
                                                             'active'=>true
                                                            ),
                                                    ),
    //                                    'htmlOptions'=>array('class'=>'aw',)
                                    )); ?>
            </td>
        </tr>
    </table>
</div>
        
    
    
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php 
$urlAjax = $this->createUrl('GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => get_class($modPPInfoKunjunganV)));
        Yii::app()->clientScript->registerScript('numbers','
    $("#'.CHtml::activeId($modPPInfoKunjunganV, 'instalasi_id').'").change(function(){
        $.ajax({
            type:"POST",
            data:$("#searchInfoKunjungan").serialize(),
            url:"'.$urlAjax.'",
            success:function(data){
                $("#'.CHtml::activeId($modPPInfoKunjunganV, 'ruangan_id').'").html("<option value>-- Pilih --</pilih>"+data)
            }
        });
    })
',  CClientScript::POS_READY
);?>


<script>
    function checkAll(){
        if($('#checkAllRuangan').is(':checked')){
           $('#searchInfoKunjungan input[name*="ruangan_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchInfoKunjungan input[name*="ruangan_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    }
</script>

