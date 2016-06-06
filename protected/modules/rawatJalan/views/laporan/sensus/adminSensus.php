<div class="white-container">
    <legend class="rim2">Laporan <b>Sensus Harian</b></legend>
    <?php
    $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikSensusHarian&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
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
        <div class="row-fluid">
                        <div class="span4">
            <?php $format = new MyFormatter(); ?>
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo CHtml::label('Tanggal Kunjungan', 'tgl_pendaftaran', array('class' => 'control-label')) ?>
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
                     <table width="100%" border="0">
                    <tr>
                      <td> 
                        <div id='searching'>
                        <fieldset>
                            <?php 
    //                         $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    //                                     'id'=>'big',
    // //                                    'parent'=>false,
    // //                                    'disabled'=>true,
    // //                                    'accordion'=>false, //default
    //                                     'content'=>array(
    //                                         'content1'=>array(
    //                                             'header'=>'Berdasarkan Wilayah',
    //                                             'isi'=>'<table><tr><td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
    //                                                             'ajax' => array('type' => 'POST',
    //                                                                 'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
    //                                                                 'update' => '#'.CHtml::activeId($model, 'kabupaten_id').''),
    //                                                             'onkeypress' => "return $(this).focusNextInputField(event)"
    //                                                         )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
    //                                                         $form->dropDownList($model, 'kabupaten_id', array(), array('empty' => '-- Pilih --',
    //                                                             'ajax' => array('type' => 'POST',
    //                                                             'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
    //                                                             'update' => '#'.CHtml::activeId($model, 'kecamatan_id').''),
    //                                                             'onkeypress' => "return $(this).focusNextInputField(event)"
    //                                                         )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'
    //                                                         .$form->dropDownList($model, 'kecamatan_id', array(), array('empty' => '-- Pilih --',
    //                                                             'ajax' => array('type' => 'POST',
    //                                                                 'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
    //                                                                 'update' => '#'.CHtml::activeId($model, 'kelurahan_id').''),
    //                                                             'onkeypress' => "return $(this).focusNextInputField(event)"
    //                                                         )).'</td></tr><tr><td><label>Kelurahan</label></td><td>'.
    //                                                         $form->dropDownList($model, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
    //                                             'active'=>true,
    //                                             ),
    //                                         'content2'=>array(
    //                                             'header'=>'Berdasarkan Cara Bayar',
    //                                             'isi'=>'<table><tr>
    //                                                         <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara Bayar</label></td>
    //                                                         <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
    //                                                             'ajax' => array('type' => 'POST',
    //                                                                 'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
    //                                                                 'update' => '#'.CHtml::activeId($model, 'penjamin_id').'',  //selector to update
    //                                                             ),
    //                                                         )).'</td>
    //                                                             </tr><tr>
    //                                                         <td><label>Penjamin</label></td><td>'.
    //                                                         $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>',            

    //                                             ),
    //                                     ),
    // //                                    'htmlOptions'=>array('class'=>'aw',)
    //                             )); ?>

                                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'form-1',
                            'content'=>array(
                                'content1'=>array(
                                'header'=>'Berdasarkan Wilayah',
                                'isi'=>'<table><tr><td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'model_nama' => ''.$model->getNamaModel().'')),
                                                                'update' => '#'.CHtml::activeId($model, 'kabupaten_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
                                                        $form->dropDownList($model, 'kabupaten_id', array(), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                            'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false,  'model_nama' => ''.$model->getNamaModel().'')),
                                                            'update' => '#'.CHtml::activeId($model, 'kecamatan_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kecamatan</label></td><td>'
                                                        .$form->dropDownList($model, 'kecamatan_id', array(), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false,  'model_nama' => ''.$model->getNamaModel().'')),
                                                                'update' => '#'.CHtml::activeId($model, 'kelurahan_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kelurahan</label></td><td>'.
                                                        $form->dropDownList($model, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
                                'active'=>true,
                            ),     
                            ),
                    )); ?>
                    </td>
                    <td>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'form-2',
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
                    )); ?>
                        </fieldset>
                            </div>
                    </td>
                </tr>
                <tr><td><div id='searching'>
                         <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
//                                    'disabled'=>true,
                            'content' => array(
                                'content1' => array(
                                    'header' => 'Berdasarkan Pengunjung/Kunjungan',
                                    'isi' => '<table>
                                                <tr>
                                                <td>' .
                                                $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td></tr></table>',
                                    'active' => true,
                                ),),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>           
                    </fieldset>
                            </div></td>
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
        </fieldset>
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
    <div class="row-fluid block-tabel">
        <h6>Tabel <b>Sensus Harian</b></h6>
        <?php $this->renderPartial($this->path_view.'sensus/_table', array('model'=>$model)); ?>
    </div>
    <div class="row-fluid block-tabel">
        <h6><b>Grafik</b></h6>
        <?php $this->renderPartial($this->path_view.'_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
    </div>      

    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanSensusHarian');
    $this->renderPartial($this->path_view.'_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div>

<script type="text/javascript">	
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
