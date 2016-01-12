<legend class="rim"><i class="icon-search icon-white"></i> Pencarian Berdasarkan : </legend>
<?php
    $modPPInfoKunjunganV->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d',(strtotime($modPPInfoKunjunganV->tgl_awal))));
    $modPPInfoKunjunganV->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d',(strtotime($modPPInfoKunjunganV->tgl_akhir))));
    $modPPInfoKunjunganV->bln_awal = $format->formatMonthForUser(date('Y-m',(strtotime($modPPInfoKunjunganV->bln_awal))));
    $modPPInfoKunjunganV->bln_akhir = $format->formatMonthForUser(date('Y-m',(strtotime($modPPInfoKunjunganV->bln_akhir))));
?>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInfoKunjungan',
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
	<?php echo CHtml::hiddenField('type','',array()); ?>
        <div class="row-fluid">
         <div class="span4">
             <?php echo CHtml::label('Kunjungan', 'tglmasukpenunjang', array('class' => 'control-label')) ?>
             <div class="controls">
                 <?php echo $form->dropDownList($modPPInfoKunjunganV,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('class'=>'span2', 'onchange'=>'ubahJnsPeriode();')); ?>
             </div>
         </div>
         <div class="span4">
             <div class='control-group hari'>
                 <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                 <div class="controls">  
                     <?php $modPPInfoKunjunganV->tgl_awal = $format->formatDateTimeForUser($modPPInfoKunjunganV->tgl_awal); ?>                     
                    <?php
                     $this->widget('MyDateTimePicker', array(
                         'model' => $modPPInfoKunjunganV,
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
                     <?php $modPPInfoKunjunganV->tgl_awal = $format->formatDateTimeForDb($modPPInfoKunjunganV->tgl_awal); ?>                     
                 </div> 

             </div>
             <div class='control-group bulan'>
                 <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                 <div class="controls">
                     <?php $modPPInfoKunjunganV->bln_awal = $format->formatMonthForUser($modPPInfoKunjunganV->bln_awal); ?>
                     <?php 
                         $this->widget('MyMonthPicker', array(
                             'model' => $modPPInfoKunjunganV,
                             'attribute' => 'bln_awal', 
                             'options'=>array(
                                 'dateFormat' => Params::MONTH_FORMAT,
                             ),
                             'htmlOptions' => array('readonly' => true,
                                 'class' => "span2",
                                 'onkeypress' => "return $(this).focusNextInputField(event)"),
                         ));  
                     ?>
                     <?php $modPPInfoKunjunganV->bln_awal = $format->formatMonthForDb($modPPInfoKunjunganV->bln_awal); ?>
                 </div> 
             </div>
             <div class='control-group tahun'>
                 <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                 <div class="controls">
                     <?php 
                     echo $form->dropDownList($modPPInfoKunjunganV, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                     ?>
                 </div>
             </div>
         </div>
         <div class="span4">
             <div class='control-group hari'>
                 <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                 <div class="controls">  
                     <?php $modPPInfoKunjunganV->tgl_akhir = $format->formatDateTimeForUser($modPPInfoKunjunganV->tgl_akhir); ?>
                     <?php
                     $this->widget('MyDateTimePicker', array(
                         'model' => $modPPInfoKunjunganV,
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
                     <?php $modPPInfoKunjunganV->tgl_akhir = $format->formatDateTimeForDb($modPPInfoKunjunganV->tgl_akhir); ?>
                 </div> 
             </div>
             <div class='control-group bulan'>
                 <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                 <div class="controls"> 
                     <?php $modPPInfoKunjunganV->bln_akhir = $format->formatMonthForUser($modPPInfoKunjunganV->bln_akhir); ?>
                     <?php 
                         $this->widget('MyMonthPicker', array(
                             'model' => $modPPInfoKunjunganV,
                             'attribute' => 'bln_akhir', 
                             'options'=>array(
                                 'dateFormat' => Params::MONTH_FORMAT,
                             ),
                             'htmlOptions' => array('readonly' => true,'class' => "span2",
                                 'onkeypress' => "return $(this).focusNextInputField(event)"),
                         ));  
                     ?>
                     <?php $modPPInfoKunjunganV->bln_akhir = $format->formatMonthForDb($modPPInfoKunjunganV->bln_akhir); ?>
                 </div> 
             </div>
             <div class='control-group tahun'>
                 <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                 <div class="controls">
                     <?php 
                     echo $form->dropDownList($modPPInfoKunjunganV, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                     ?>
                 </div>
             </div>
         </div> 
     </div>
<table width="100%" border="0">
  <tr>
    <td>  <div id='searching'>
                    <fieldset>
	<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'big',
//                                    'disabled'=>true,
                                    'content'=>array(
                                        'content1'=>array(
                                            'header'=>'Berdasarkan Wilayah',
                                            'isi'=>'<table><tr><td>'.CHtml::hiddenField('filter', 'wilayah').'<label>Propinsi</label></td><td>'.$form->dropDownList($modPPInfoKunjunganV, 'propinsi_id', CHtml::listData($modPPInfoKunjunganV->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => $this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($modPPInfoKunjunganV))),
                                                                'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kabupaten_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
                                                        $form->dropDownList($modPPInfoKunjunganV, 'kabupaten_id', array(), array('empty' => '-- Pilih --',
                                                            'ajax' => array('type' => 'POST',
                                                            'url' => $this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($modPPInfoKunjunganV))),
                                                            'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kecamatan_id').''),
                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
                                                        )).'</td></tr></table>',
//                                                        .$form->dropDownList($modPPInfoKunjunganV, 'kecamatan_id', array(), array('empty' => '-- Pilih --',
//                                                            'ajax' => array('type' => 'POST',
//                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => ''.$modPPInfoKunjunganV->getNamaModel().'')),
//                                                                'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'kelurahan_id').''),
//                                                            'onkeypress' => "return $(this).focusNextInputField(event)"
//                                                        )).'</td></tr><tr><td><label>Kabupaten</label></td><td>'.
//                                                        $form->dropDownList($modPPInfoKunjunganV, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
                                            'active'=>true,
                                            ),   ),
//                                    'htmlOptions'=>array('class'=>'aw',)
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
                                                        <td>'.CHtml::hiddenField('filter', 'carabayar',array('disabled'=>'disabled')).'<label>Cara Bayar</label></td>
                                                        <td>'.$form->dropDownList($modPPInfoKunjunganV, 'carabayar_id', CHtml::listData($modPPInfoKunjunganV->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$modPPInfoKunjunganV->getNamaModel().'')),
                                                                'update' => '#'.CHtml::activeId($modPPInfoKunjunganV, 'penjamin_id').'',  //selector to update
                                                            ),
                                                        )).'</td>
                                                            </tr><tr>
                                                        <td><label>Penjamin</label></td><td>'.
                                                        $form->dropDownList($modPPInfoKunjunganV, 'penjamin_id', CHtml::listData($modPPInfoKunjunganV->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>', 'active'=>false,       
                                            'active'=>true,
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
$format = new MyFormatter();
?>


<?php
$urlPeriode = $this->createUrl('GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#PPInfoKunjunganRIV_tgl_awal').val(data.periodeawal);
            $('#PPInfoKunjunganRIV_tgl_akhir').val(data.periodeakhir);
            $('#PPRuanganM_tgl_awal').val(data.periodeawal);
            $('#PPRuanganM_tgl_akhir').val(data.periodeakhir);
//            if(data.namaPeriode == 1 ){
//                myAlert("Pencarian Berdasarkan : "+data.namaPeriode);
//            }
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode',$js,CClientScript::POS_HEAD);
?>
<?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan/_jsFunctions', array('model'=>$modPPInfoKunjunganV));?>
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

