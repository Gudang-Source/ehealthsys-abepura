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
       label.checkbox{
            width: 250px;
            display:inline-block;
        }
    </style>
       <div class="row-fluid">
         <div class="span4">
             <?php echo CHtml::hiddenField('type', ''); ?>
             <?php echo CHtml::label('Tanggal Pasien Pulang', 'tglpemeriksaan', array('class' => 'control-label')) ?>
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
        <table width="100%" border="0">
              <tr>
                <td> 
                    <div id='searching'>
                    <fieldset>                 
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'kunjungan',
                            'slide'=>true,
                                                                'content'=>array(
                                'conten4t'=>array(
                                    'header'=>'Berdasarkan Cara Pulang',
                                    'isi'=>'<table><tr>      
                                                <td>'.CHtml::checkBox('cek_all', true, array('value'=>'cek', 'onchange'=>'cek_all_tindakan(this)')).' Pilih Semua<td></tr></table>
                                                <table id="tindak_lanjut_tbl">
						<tr>
							<td>'.
								$form->checkBoxList($model, 'carakeluar', CarakeluarM::model()->getCaraKeluar(), array(									
									'empty' => '-- Pilih --',
									'onkeypress' => "return $(this).focusNextInputField(event)")
								)
							.'</td>
						</tr>
						</table>',            
                                        'active'=>true,
                                    ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>
                    </fieldset>					
			</td>
                     <td> 
                    <div id='searching'>
                    <fieldset>                 
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'kunjungan1',
                            'slide'=>true,
                                                                'content'=>array(
                                'content2'=>array(
                                    'header'=>'Berdasarkan Kondisi Pulang',
                                    'isi'=>'<table><tr>      
                                                <td>'.CHtml::checkBox('cek_allkondisi', true, array('value'=>'cek', 'onchange'=>'cek_all_kondisi(this)')).' Pilih Semua<td></tr></table>
                                                <table id="kondisi_tbl">
						<tr>
							<td>'.
								$form->checkBoxList($model, 'kondisipulang', KondisiKeluarM::model()->getKondisiKeluar(), array(									
									'empty' => '-- Pilih --',
									'onkeypress' => "return $(this).focusNextInputField(event)")
								)
							.'</td>
						</tr>
						</table>',            
                                        'active'=>true,
                                    ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>
                    </fieldset>					
			</td>   
                </tr>
                <tr>
                    <td>
                            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'big',
                                    'slide'=>true,
                                    'content'=>array(
                                            'content3'=>array(
                                            'header'=>'Berdasarkan Instalasi dan Ruangan',
                                            'isi'=>'<table>
                                                        <tr>
                                                            <td>'.'<label>Instalasi</label></td>
                                                            <td>'.$form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                    'ajax' => array('type' => 'POST',
                                                                            'url' => $this->createUrl('GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.get_class($model).'')),
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
                                                                    <div id="ruangan">
                                                                            <label>Data Tidak Ditemukan</label>
                                                                    </div>
                                                            </td>
                                                        </tr>
                                                     </table>',
                                             'active'=>false
                                            ),
                                    ),
//                                    'htmlOptions'=>array('class'=>'aw',)
				)); ?>
                        </td>
                </tr>
        </table>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
		<?php
 echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
                                                                        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  
  $("#big").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
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
<script type="text/javascript">
   $( document ).ready(function(){
       cek_all_kondisi($("#cek_allkondisi"));
       cek_all_tindakan($("#cek_all"));
   });
    function cek_all_tindakan(obj){
        if($(obj).is(':checked')){
            $("#tindak_lanjut_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#tindak_lanjut_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    
    function cek_all_kondisi(obj){
        if($(obj).is(':checked')){
            $("#kondisi_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#kondisi_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    
    function checkAll(){
        if($('#checkAllRuangan').is(':checked')){
           $('#searchLaporan input[name*="ruangan_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="ruangan_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    }
</script>
