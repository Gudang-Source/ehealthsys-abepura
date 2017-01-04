<?php
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/dropCheck.css');
                   
        ?>
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
             <?php echo CHtml::hiddenField('type', ''); ?>
             <?php echo CHtml::label('Periode Laporan', 'tglpemeriksaan', array('class' => 'control-label')) ?>
             <div class="controls">
                 <?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('class'=>'span2', 'onchange'=>'ubahJnsPeriode();')); ?>
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
                             'options'=>array(
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
                     echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
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
                         'htmlOptions' => array('readonly' => true,'class' => "span2",
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
                             'htmlOptions' => array('readonly' => true,'class' => "span2",
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
                     echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                     ?>
                 </div>
             </div>
         </div>        
     </div> 
    <table width ="100%">       
        <tr>
            <td>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'big',
                            'content'=>array(
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
                                                   <i class="icon-list"></i>
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
            </td>
            <td>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'big',
                        'content'=>array(
                            'content2'=>array(
                                'header'=>'Berdasarkan Cara Bayar',
                                'isi'=>'<table><tr>
                                            <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara Bayar</label></td>
                                            <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'ajax' => array('type' => 'POST',
                                                    'url' => Yii::app()->createUrl('/ActionDynamic/GetPenjaminForDropCheck', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                    'update' => '#checkboxes2',  //selector to update
                                                ),
                                            )).'</td>
                                                </tr><tr>
                                            <td><label>Penjamin</label></td><td>
                                            <div class="multiselect" id="multiselect2">
                                                        <div class="selectBox" onclick="showCheckboxes2();">
                                                            <select id = "dropCaraBayar">
                                                                <option>-- Pilih --</option>
                                                            </select>
                                                            <div class="overSelect"></div>
                                                        </div>
                                                        <div class="checkboxes" id="checkboxes2">
                                                           '.$form->checkBoxList($model, 'penjamin_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'
                                                        </div>'.
                                            '</td></tr></table>',            
                                'active'=>true,
                                ),
                        ),
                        'htmlOptions'=>array('class'=>'aw')
                )); ?>
            </td>
        </tr>
        <tr>
                <td>
                    <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big4',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                            'content' => array(
                                'content6' => array(
                                    'header' => 'Berdasarkan Kunjungan',
                                    'isi' => '<table>
                                                <tr>
                                                <td><label>Kunjungan</label></td>
                                                <td> <div class="multiselect" id="multiselect1">
                                                        <div class="selectBox" onclick="showCheckboxes1();">
                                                            <select id = "dropKunjungan">
                                                                <option>-- Pilih --</option>
                                                            </select>
                                                            <div class="overSelect"></div>
                                                        </div>
                                                        <div class="checkboxes" id="checkboxes1">
                                                           '.$form->checkBoxList($model, 'kunjungan', LookupM::getItems('kunjungan'), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'
                                                        </div>
                                                    </div></td></tr></table>',
                                    'active' => true,
                                ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>       
                </td>
            </tr>
            <tr>
                <td>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'big',
                            'slide'=>true,
                            'content'=>array(
                                    'content7'=>array(
                                    'header'=>'Berdasarkan Instalasi dan Ruangan',
                                    'isi'=>'<table>
                                                            <tr>
                                                                    <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Instalasi</label></td>
                                                                    <td>'.$form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
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
                </td>
                <td>
                     <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'kunjungan5',
                        'slide'=>false,
                        'content'=>array(
                        'content5'=>array(
                            'header'=>'Data grafik',
                            'isi'=>  '<table>
                                        <tr>
                                            <td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'kunjungan')).' <label>Kunjungan</label></td>                                               
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'carabayar')).' <label>Cara Bayar</label></td>                                                                                           
                                        </tr>                                                                                    
                                        <tr>
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'instalasiasal')).' <label>Instalasi asal</label></td>
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'ruanganasal')).' <label>Ruangan Asal</label></td>
                                        </tr>
                                        <tr>
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'jenispemeriksaan')).' <label>Jenis Pemeriksaan</label></td>                                            
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
<?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
<script>
    var expanded = false;
    function showCheckboxes3() {
        $("#multiselect3").find("#checkboxes3").slideToggle('fast');
    }
    
    function showCheckboxes1() {
        $("#multiselect1").find("#checkboxes1").slideToggle('fast');
        
       // $('#checkboxes1 input[type="checkbox"]').on('click', function() {

       // var title = $(this).closest('#checkboxes1').find('input[type="checkbox"] label').html(),
       //    title = $(this).next('label').text() + ",";


       // if ($(this).is(':checked')) {
       //   var str = $("#dropKunjungan").val();
       //   var html = str.replace("-- Pilih --",'');    
       //   $('#dropKunjungan').find('option').remove().end().append('<option value="'+html+''+title+'">'+html+' '+title+'</option>').val('');

       // } else {
       //   var str = $("#dropKunjungan").val();
        //  var html = str.replace(title,'');   

        //  if (html == ''){        
        //      $('#dropKunjungan').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        //  }else{
         //     $('#dropKunjungan').find('option').remove().end().append('<option value="'+html+'">'+html+'</option>').val('');
         // }

        //}
      //});
    }
    
    function showCheckboxes2() {
        $("#multiselect2").find("#checkboxes2").slideToggle('fast');
        
       // $("#multiselect2").find('#checkboxes2 input[type="checkbox"]').on('click', function() {

       // var title = $(this).closest('#checkboxes2').find('input[type="checkbox"] label').html(),
       //   title = $(this).next('label').text() + ",";
                  


       // if ($(this).is(':checked')) {
       //   var str = $("#dropCaraBayar").val();
        //  var html = str.replace("-- Pilih --",'');    
         // $('#dropCaraBayar').find('option').remove().end().append('<option value="'+html+''+title+'">'+html+' '+title+'</option>').val('');

       // } else {
       //   var str = $("#dropCaraBayar").val();
       //   var html = str.replace(title,'');   

        //  if (html == ''){        
           //   $('#dropCaraBayar').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        //  }else{
        //      $('#dropCaraBayar').find('option').remove().end().append('<option value="'+html+'">'+html+'</option>').val('');
        //  }

       // }
     // });
    }
    
        
   $(document).bind('click', function(e) {
    var $clicked = $(e.target);
    if (!$clicked.parents().hasClass("multiselect")){ $("#checkboxes2").hide();$("#checkboxes1").hide();$("#checkboxes3").hide();}
  });
  
  
</script>