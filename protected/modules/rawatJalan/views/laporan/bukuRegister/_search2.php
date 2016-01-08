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
    </style>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php //echo CHtml::hiddenField('src', ''); ?>
                   <table width="100%" border="0">
  <tr>
    <td><div class = 'control-label'>Tanggal Kunjungan</div>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
//                                          'maxDate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div> </td>
    <td style="padding:0px 100px 0 0;"><?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
//                                         'maxdate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div> </td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td> 
                    <div id='searching'>
                    <fieldset>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'big',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                                    'content'=>array(
                                        'content1'=>array(
                                            'header'=>'Berdasarkan Wilayah',
                                            'isi'=>'<table><tr><td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                                'update' => '#'.CHtml::activeId($model, 'kabupaten_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
                                                        $form->dropDownList($model, 'kabupaten_id', array(), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                            'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                            'update' => '#'.CHtml::activeId($model, 'kecamatan_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kecamatan</label></td><td>'
                                                        .$form->dropDownList($model, 'kecamatan_id', array(), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                                'update' => '#'.CHtml::activeId($model, 'kelurahan_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kelurahan</label></td><td>'.
                                                        $form->dropDownList($model, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
                                            'active'=>true,
                                            ), ),
				)); ?>      </fieldset>
      </td>
    <td> <fieldset>
				<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'kunjungan',
                                    'slide'=>true,
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
                                                'active'=>false,
                                            ),
                                    ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>
							</fieldset>
							  </fieldset>
      </td>
  </tr>
</table>

    <div class="form-actions">
        <?php
         echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','ajax' => array(
                 'type' => 'GET', 
                 'url' => array("/".$this->route), 
                 'update' => '#tableLaporan',
                 'beforeSend' => 'function(){
                                      $("#tableLaporan").addClass("animation-loading");
                                  }',
                 'complete' => 'function(){
                                      $("#tableLaporan").removeClass("animation-loading");
                                  }',
             ))); 
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


