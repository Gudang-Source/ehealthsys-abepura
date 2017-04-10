<?php
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/dropCheck.css');
                   
        ?>
<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    
    $format = new MyFormatter();
    ?>
    <style>

        label.checkbox, label.radio{
            width:150px;
            display:inline-block;
        }

    </style>
    <div class="row-fluid">
        <div class="span4">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo CHtml::label('Periode Laporan', 'tglkunjungan', array('class' => 'control-label')) ?>
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
    <table width="100%">
        <tr>
            <td width="50%">
                <div id='searching'>
                    <fieldset>                                     
                       <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
//                            'parent'=>false,
//                            'disabled'=>true,
//                            'accordion'=>false, //default
                            'content' => array(
                                'content1' => array(
                                    'header' => 'Berdasarkan Rujukan',
                                    'isi' => '<table><tr><td>'.CHtml::checkBox('checkAllRujukan', true, array('onkeypress' => "return $(this).focusNextInputField(event)",
                                                    'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')).' Pilih Semua</td></tr></table>'
                                            . '<table id = "rujukan">'
                                            . '<tr>'
                                            . '<td>'.$form->checkBoxList($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_nama')).'</td>'
                                            . '</tr>'
                                            . '</table>',
                                    'active' => true,
                                ),            
                              
                                ),
                        ));
                        ?> 
                    </fieldset>
                </div>
            </td>
            <td>
                <div id='searching'>
                    <fieldset>                                     
                       <?php
                   /*     $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big1',
//                            'parent'=>false,
//                            'disabled'=>true,
//                            'accordion'=>false, //default
                            'content' => array(
                                'content2' => array(
                                    'header' => 'Berdasarkan Asal Instalasi',
                                    'isi' => '<table><tr><td>'.CHtml::checkBox('checkAllInstalasi', true, array('onkeypress' => "return $(this).focusNextInputField(event)",
                    'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')).' Pilih Semua</td></tr></table>'
                                            . '<table id = "instalasi">'
                                            . '<tr>'
                                            . '<td>'.$form->checkBoxList($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama')).'</td>'
                                            . '</tr>'
                                            . '</table>',
                                    'active' => true,
                                ),),
                        ));*/
                        ?> 
						
						 <?php 
							$ins = new CDbCriteria();
							$ins->addInCondition("instalasi_id", Params::getArrayInstalasiPelayanan());
							$ins->addCondition("instalasi_aktif=  TRUE");
							$ins->order = "instalasi_nama ASC";
						 
							$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'big',
                            'slide'=>true,
                            'content'=>array(
                                    'content7'=>array(
                                    'header'=>'Berdasarkan Instalasi dan Ruangan',
                                    'isi'=>'<table>
                                                            <tr>
                                                                    <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Instalasi</label></td>
                                                                    <td>'.$form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll($ins), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                            'ajax' => array('type' => 'POST',
                                                                                    'url' => $this->createUrl('/ActionDynamic/GetRuangAslForDropCheck/', array('encode' => false, 'namaModel' => ''.get_class($model).'')),
                                                                                    'update' => '#checkboxes3',  //selector to update
                                                                            ),
                                                                    )).'
                                                                    </td>
                                                            </tr>
                                                            <tr>
                                                                    <td>
                                                                            <label>Ruangan</label>
                                                                    </td>
                                                                    <td>
                                                                            <div class="multiselect" id="multiselect3">
                                                                            <div class="selectBox" onclick="showCheckboxes3();">
                                                                                <select id = "dropRuangan">
                                                                                    <option>-- Pilih --</option>
                                                                                </select>
                                                                                <div class="overSelect"></div>
                                                                            </div>
                                                                            <div class="checkboxes" id="checkboxes3">
                                                                               '.$form->checkBoxList($model, 'ruanganasal_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'
                                                                            </div>
                                                                    </td>
                                                            </tr>
                                                     </table>',
                                     'active'=>true
                                    ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>
                    </fieldset>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                  <?php 
                    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'kunjungan5',
                        'slide'=>false,
                        'content'=>array(
                        'content5'=>array(
                            'header'=>'Opsi Grafik',
                            'isi'=>  '<table>
                                        <tr>
                                            <td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'instalasiasal')).' <label>Instalasi Asal</label></td>                                               
											<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'ruanganasal')).' <label>Ruangan Asal</label></td>                                               
                                        </tr>                                        
										<tr>                                            
											<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'rujukan')).' <label>Rujukan</label></td>                                                                                            
											<td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'asalrujukan')).' <label>Asal Rujukan</label></td>                                                                                            
                                        </tr>
                                    </table>',          
                            'active'=>TRUE,
                                ),
                        ),
    //                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>	
            </td>
        </tr>
    </table>             
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'));
        ?>
    </div>
<?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
', CClientScript::POS_READY);
?>
<script>
    function checkAll() {
        if ($("#checkAllInstalasi").is(":checked")) {
            $('#instalasi input[name*="ruanganasal_id"]').each(function () {
                $(this).attr('checked', true);
            })
//        myAlert('Checked');
        } else {
            $('#instalasi input[name*="ruanganasal_id"]').each(function () {
                $(this).removeAttr('checked');
            })
        }
		
		if($('#checkAllRuangan').is(':checked')){
           $('#searchLaporan input[name*="ruanganasal_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="ruanganasal_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }

        if ($("#checkAllRujukan").is(":checked")) {
            $('#rujukan input[name*="asalrujukan_id"]').each(function () {
                $(this).attr('checked', true);
            })
//        myAlert('Checked');
        } else {
            $('#rujukan input[name*="asalrujukan_id"]').each(function () {
                $(this).removeAttr('checked');
            })
        }
    }
	

    
    checkAll();
	
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
<script>
    function showCheckboxes3() {
        $("#multiselect3").find("#checkboxes3").slideToggle('fast');
    }
    
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("multiselect")){                     
            $("#checkboxes3").hide();    
        }
     });
</script>
