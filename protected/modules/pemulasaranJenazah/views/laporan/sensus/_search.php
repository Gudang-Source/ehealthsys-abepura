<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus'=>'#'.CHtml::activeId($model,'jns_periode'),
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
         #jeniss label.checkbox, .ruangan span label.checkbox{
            width: 150px;
            display:inline-block;
        }
    </style>
    <table width='100%'>
        <tr>
            <td>
                <fieldset class='box2'>
                    <legend class="rim">Berdasarkan Tanggal</legend>
                    <div class="row-fluid">
                        <div class="span4">
                            <?php echo CHtml::label('Kunjungan', 'tglmasukpenunjang', array('class' => 'control-label')) ?>
                            <?php echo CHtml::hiddenField('type',''); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('onchange'=>'ubahJnsPeriode();')); ?>
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
                                             'maxDate'=>'d',
                                         ),
                                         'htmlOptions' => array('readonly' => true,
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
                                             'options'=>array(
                                                 'dateFormat' => Params::MONTH_FORMAT,
                                             ),
                                             'htmlOptions' => array('readonly' => true,
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
                                     echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('onkeypress' => "return $(this).focusNextInputField(event)")); 
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
                                                'maxDate'=>'d',
                                            ),
                                            'htmlOptions' => array('readonly' => true,
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
                                             'options'=>array(
                                                 'dateFormat' => Params::MONTH_FORMAT,
                                            ),
                                             'htmlOptions' => array('readonly' => true,
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
                                        echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('onkeypress' => "return $(this).focusNextInputField(event)")); 
                                    ?>
                                </div>
                            </div>
                        </div> 
                    </div>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td>
                <div class='row-fluid'>
                    <div class='span6'>
                        <div id='searching'>
                            <fieldset>
                                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                        'id'=>'big',
            //                                    'parent'=>false,
            //                                    'disabled'=>true,
            //                                    'accordion'=>false, //default
                                        'content'=>array(
                                            'content1'=>array(
                                                'header'=>'Berdasarkan Instalasi Asal',
                                                'isi'=>'<table id="jeniss"><tr><td>'.$form->hiddenField($model, 'pilihan', array('value'=>'instalasi','disabled'=>'disabled'))
                                                .'<label>Instalasi</label></td><td>'
                                                    .$form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                'ajax' => array('type' => 'POST',
                                                                    'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganAsalForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                                    'update' => '.ruangan',  //selector to update
                                                                )
                                                        ))
                                                .'</td></tr><tr><td><label>Ruangan</label></td><td>
                                                    <div class="ruangan"><label>data tidak ditemukan</label></div>
                                                    </td></tr></table>',
                                                'active'=>true,
                                                ),
                                        ),
                                )); ?>
                            </fieldset>
                        </div>
                    </div>
                    <div class='span6'>
                        <fieldset>
                            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'kunjungan',
                                    'slide'=>true,
                                                                        'content'=>array(
                                        'content2'=>array(
                                            'header'=>'Berdasarkan Cara Bayar',
                                            'isi'=>'<table><tr>
                                                        <td>'.CHtml::hiddenField('filter', 'carabayar',array('disabled'=>'disabled')).'<label>Cara Bayar</label></td>
                                                        <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                                'update' => '#'.CHtml::activeId($model, 'penjamin_id').'',  //selector to update
                                                            ),
                                                        )).'</td>
                                                            </tr><tr>
                                                        <td><label>Penjamin</label></td><td>'.
                                                        $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>', 'active'=>false,       
                                            'active'=>true,
                                            ),
                                    ),
                                )); 
                            ?>
                        </fieldset>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;'));  ?>
    </div>    
</div>    
<?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
