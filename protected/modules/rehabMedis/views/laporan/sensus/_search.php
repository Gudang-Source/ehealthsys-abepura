<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
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
        <table width="100%">
            <tr>
                <td>
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Kunjungan</legend>
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php //echo CHtml::hiddenField('src', ''); ?>
                        <div class = 'control-label'>Tanggal Kunjungan</div>
                        <div class="controls">  
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
								'options' => array(
									'maxDate'=>'d',
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true,
								'class'=>'dtPicker2',
								'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div> 
                        <?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
								'options' => array(
									'maxDate'=>'d',
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true,
								'class'=>'dtPicker2',
								'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </fieldset>
                </td>
                <td rowspan =3>
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
                                        'content2'=>array(
                                            'header'=>'Berdasarkan Cara Bayar',
                                            'isi'=>'<table><tr>
                                                        <td>'.$form->hiddenField($model, 'pilihan', array('value'=>'carabayar','disabled'=>'disabled')).'<label>Cara Bayar</label></td>
                                                        <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                                'update' => '#'.CHtml::activeId($model, 'penjamin_id').'',  //selector to update
                                                            ),
                                                        )).'</td>
                                                            </tr><tr>
                                                        <td><label>Penjamin</label></td><td>'.
                                                        $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>',            
                                            'active'=>false,
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
                    <div id='searching'>
                    <fieldset class="box2">
                        <legend class="rim">Grafik Kunjungan</legend>   
                        <?php echo '<table>
                                                        <tr>
                                                        <td>'.
                                                        $form->checkBoxList($model, 'kunjungan', LookupM::getItems('kunjungan'), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>'; ?>
                    </fieldset>
                    </div>
                </td>
            </tr>
        </table>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
		<?php
 echo CHtml::htmlButton(Yii::t('mds','{icon} Ualng',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));
?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php //Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>
