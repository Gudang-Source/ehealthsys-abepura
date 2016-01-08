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
         #jeniss label.checkbox{
            width: 100px;
            display:inline-block;
        }
        #ruangan label{
            width: 120px;
            display:inline-block;
        }
    </style>
        <table width="100%">
            <tr>
                <td width="50%">
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Kunjungan</legend>
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php //echo CHtml::hiddenField('src', ''); ?>
						<div class="control-group">
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
						</div>
						<div class="control-group">
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
						</div>
                    </fieldset>
                    <div id='searching'>
                        <fieldset>
                            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                        'id'=>'big',
    //                                    'parent'=>false,
    //                                    'disabled'=>true,
    //                                    'accordion'=>false, //default
                                        'content'=>array(
    //                                        'content1'=>array(
    //                                            'header'=>'Berdasarkan Jenis Pemeriksaan',
    //                                            'isi'=>'<table id="jeniss"><tr><td>'.CHtml::hiddenField('filter', 'jenis', array('disabled'=>'disabled')).
    //                                                $form->checkBoxList($model, 'pemeriksaanrad_id', Chtml::listData(PemeriksaanradM::model()->findAll('pemeriksaanrad_aktif = true'), 'pemeriksaanrad_id', 'pemeriksaanrad_jenis'))
    //                                            .'</td></tr></table>',
    //                                            'active'=>true,
    //                                            ),
                                             'content1'=>array(
                                                    'header'=>'Berdasarkan Jenis Pemeriksaan',
                                                    'isi'=>'<table>
                                                                <tr>
                                                                <td>'.CHtml::hiddenField('idPemeriksaan')
                                                                .'<div class="input-append"><span class="add-on">'.$form->textField($model, 'jenispemeriksaanrad_nama', array('id'=>'pemeriksaanrad','data-offset-top'=>200,
                                                                        'data-spy'=>'affix','style'=>'margin-top:-3px; margin-left:-3px',
                                                                            'inline'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'sourceUrl'=> $this->createUrl('getPemeriksaanRad'),
                                                                                    'placeholder'=>'Ketikan Jenis Pemeriksaan'))
                                                                .'<a href="javascript:void(0);" id="tombolPemeriksaanRadDialog" 
                                                                        onclick="$(&quot;#dialogPemeriksaanRad&quot;).dialog(&quot;open&quot;);return false;">
                                                            <i class="icon-list-alt"></i>
                                                            <i class="icon-search">
                                                            </i>
                                                            </a>
                                                            </span>
                                                            </div></td></tr></table>',
                                                    'active'=>true,
                                                ),
                                        ),
                                        'htmlOptions'=>array('class'=>'aw')
                                )); ?>
                        </fieldset>
                    </div>
                </td>
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
                    <div id='searching'>
                        <fieldset>
                            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                        'id'=>'big',
                                        'content'=>array(
                                            'content2'=>array(
                                                'header'=>'Berdasarkan Cara Bayar',
                                                'isi'=>'<table><tr>
                                                            <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara Bayar</label></td>
                                                            <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                'ajax' => array('type' => 'POST',
                                                                    'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                                    'update' => '#'.CHtml::activeId($model, 'penjamin_id').'',  //selector to update
                                                                ),
                                                            )).'</td>
                                                                </tr><tr>
                                                            <td><label>Penjamin</label></td><td>'.
                                                            $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>',            
                                                'active'=>true,
                                                ),
                                        ),
                                        'htmlOptions'=>array('class'=>'aw')
                                )); ?>
                        </fieldset>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    </td>
                </tr>
            
        </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;'));  ?>
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
/**
 * Dialog untuk Pemeriksaan Rad
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPemeriksaanRad',
    'options'=>array(
        'title'=>'Daftar Nama Pemeriksaan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPemeriksaan = new PemeriksaanradM;
$modPemeriksaan->unsetAttributes();
if(isset($_GET['PemeriksaanradM'])){
    $modPemeriksaan->attributes = $_GET['PemeriksaanradM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pemeriksaan-m-grid',
	'dataProvider'=>$modPemeriksaan->search(),
	'filter'=>$modPemeriksaan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#idPemeriksaan\").val(\"$data->pemeriksaanrad_id\");
                                                      $(\"#pemeriksaanrad\").val(\"$data->pemeriksaanrad_nama\");
                                                      $(\"#dialogPemeriksaanRad\").dialog(\"close\");    
                                                      return false;
                                            "))',
                    ),
                array(
                    'header'=>'ID',
                    'filter'=>false,
                    'value'=>'$data->pemeriksaanrad_id',
                ),
                array(
                    'header'=>'Jenis Pemeriksaan',
                    'name'=>'jenispemeriksaanrad_nama',
                    'value'=>'$data->jenispemeriksaanrad->jenispemeriksaanrad_nama',
                ),
                array(
                    'header'=>'Nama Pemeriksaan',
                    'name'=>'pemeriksaanrad_nama',
                    'value'=>'$data->pemeriksaanrad_nama',
                ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>