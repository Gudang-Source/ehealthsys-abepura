    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('PPInfoKunjungan-v', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="search-form" style="">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
)); ?>

<fieldset>
    <legend>
        <table> 
            <tr>
                <td>
                      <?php echo $form->textFieldRow($modInfoKunjunganV,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
                <td>
                      <?php echo $form->labelEx($modInfoKunjunganV,'tgl_pendaftaran', array('class'=>'control-label')) ?>
                      <div class="controls" style="width:250px;">  
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                         <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modInfoKunjunganV,
                                             'attribute'=>'tgl_awal',
                                             'mode'=>'date',
    //                                          'maxDate'=>'d',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                             'htmlOptions'=>array('readonly'=>true,
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                          <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>

                       </div> 
                </td>
           </tr>
           <tr>
                <td>
                      <?php echo $form->textFieldRow($modInfoKunjunganV,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
                <td>
                     <?php echo CHtml::label(' Samapi Dengan',' Sampai Dengan', array('class'=>'control-label','style'=>'width:20px;')) ?>  
                       <div class="controls" style="text-align: left;">  
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                        <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$modInfoKunjunganV,
                                             'attribute'=>'tgl_akhir',
                                             'mode'=>'date',
    //                                         'maxdate'=>'d',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                             'htmlOptions'=>array('readonly'=>true,
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                           <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                       </div>
               </td>     
           </tr>
           <tr>
                <td colspan="2">
                      <?php echo $form->textFieldRow($modInfoKunjunganV,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </td>
           </tr>
           <tr>
                <td colspan="2" align="center">
                    <div class="menubuttons" style="text-align: center">   
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                    </div>    
                </td>
           </tr>
        </table>
    </legend>
</fieldset>
    
<?php $this->endWidget(); ?>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'PPInfoKunjungan-v',
	'dataProvider'=>$modInfoKunjunganV->searchRJRD(),
        'filter'=>$modInfoKunjunganV,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            'no_rekam_medik',    
            'no_pendaftaran',
            'nama_pasien',
            'alamat_pasien',
            array(
                'header'=>'Nama Ruangan',
                'value'=>'$data->ruangan_nama',
            ),
//            'ruangan_nama',
            'tgl_pendaftaran',
            'carabayar_nama',
             array(
                    'header'=>'Penjamin',
                    'type'=>'raw',
                    'value'=>'CHtml::Button($data->penjamin_nama, array(\'title\'=>\'ubah Cara Bayar\',\'onclick\'=>"ubahCaraBayar(\'$data->no_pendaftaran\',\'$data->pendaftaran_id\',\'$data->carabayar_id\',\'$data->penjamin_id\');","class"=>"button"))',
                    'htmlOptions'=>array('style'=>'text-align: center')
            ),
            array(
                    'header'=>'Print Poli',
                    'type'=>'raw',
                    'value'=>'CHtml::Link(\'<i class="icon-print"></i>\',"javascript:printLembarPoli(\'$data->no_pendaftaran\',\'$data->instalasi_id\');");',
                    'htmlOptions'=>array('style'=>'text-align: center')
            ),
            array(
                    'header'=>'Batal Periksa',
                    'type'=>'raw',
                    'value'=>'CHtml::Link(\'<i class="icon-remove-sign"></i>\',"javascript:dialogConfirm(\'$data->pendaftaran_id\',\'$data->statusperiksa\');");',
                    'htmlOptions'=>array('style'=>'text-align: center')
            ),

                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php
$js = <<< JSCRIPT

JSCRIPT;
Yii::app()->clientScript->registerScript('jsPendaftaran',$js, CClientScript::POS_HEAD);
// ===========================Dialog Batal Periksa=================
$url = $this->createUrl('agamaM/autoCompleteAgama');
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id'=>'confirm',
                                // additional javascript options for the dialog plugin
                                'options'=>array(
                                'title'=>'',
                                'autoOpen'=>false,
                                'show'=>'blind',
                                'hide'=>'explode',
                                'minWidth'=>500,
                                'minHeight'=>100,
                                'resizable'=>false,
                                'modal'=>true,    
                                 ),
                            ));
                            echo '<center>Apakah Anda Yakin Akan Membatalkan Pemeriksaan Pasien Ini?<br><br>' ;   
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Ya',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'ubahPeriksa();'));
                            echo '&nbsp;&nbsp;&nbsp;'.CHtml::htmlButton(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                array('class'=>'btn btn-danger', 'type'=>'button','onclick'=>'$(\'#confirm\').dialog(\'close\');'));
                            echo CHtml::hiddenField('pendaftaran_id', '');
                            echo CHtml::hiddenField('statusperiksa', '');
//                            echo '14 April 2012 Belum Berjalan Karena Untuk <br> 
//                                Pengecekannya Harus Kasir Dulu N tabel yang diperlukan ataw 
//                                view yang diperlukan belum ada';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa=====================

    
//========================================= Cara Bayar dialog =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'carabayardialog',
    'options'=>array(
        'title'=>'Ubah Cara Bayar dan Penjamin',
        'autoOpen'=>false,
        'minWidth'=>500,
        'modal'=>true,
        'hide'=>explode,
    ),
));
echo '<div class="row">';
echo '<table>
        <tr>';
echo      '<td> No. Pendaftaran</td>
           <td> :'.CHtml::textField('no_pendaftaran','',array('readonly'=>TRUE)).CHtml::hiddenField('ubahPendaftaranId','',array('readonly'=>TRUE)).
           '</td>
         </tr>
         <tr>
            <td>'.CHtml::label('Cara Bayar', 'carabayar').'</td>
            <td>: '.Chtml::dropDownList('ubahCaraBayar_id','', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama'), 'carabayar_id', 'carabayar_nama'),
        array('onchange'=>"dynamicPenjamin(this)")).'</td>
        </tr>
        <tr>
            <td>
    ';
echo CHtml::label('Penjamin','penjamin').'</td><td> : ';
echo Chtml::dropDownList('ubahPenjamin_id','',array(),array('style'=>'width:140px;'));
echo '</td>';
echo '</table><center>';
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanCaraBayar();'));
                            echo '&nbsp;&nbsp;&nbsp;'.CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                                                array('class'=>'btn btn-danger', 'type'=>'button','onclick'=>'$(\'#carabayardialog\').dialog(\'close\');'));

echo '</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========================================================= end cara bayar dialog =========================


//======================================================JAVA SCRIPT===================================================                          
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$statusPeriksaBatalPeriksa=Params::STATUSPERIKSA_BATAL_PERIKSA;
$js = <<< JSCRIPT
//====================================Awal Ubah Cara Bayar============================================================
function ubahCaraBayar(no_pendaftaran,pendaftaran_id,carabayar_id,penjamin_id)
   {
        $('#ubahCaraBayar_id').val(carabayar_id);
        $('#no_pendaftaran').val(no_pendaftaran);
        $('#ubahPenjamin_id').val(penjamin_id);
        $('#ubahPendaftaranId').val(pendaftaran_id);
        $.post("${url}/ajaxGetPenjamin", {carabayar_id: carabayar_id, penjamin_id : penjamin_id},
                function(data){
                   $('#ubahPenjamin_id').html(data.penjamin);
                },"json");
        
        $('#carabayardialog').dialog('open');   
   }

function simpanCaraBayar()
   {
        carabayar_id=$('#ubahCaraBayar_id').val();
        penjamin_id=$('#ubahPenjamin_id').val();
        pendaftaran_id=$('#ubahPendaftaranId').val();
        myAlert(pendaftaran_id);
        $.post("${url}/ajaxUpdateCaraBayarAntrian", { pendaftaran_id: pendaftaran_id, carabayar_id: carabayar_id, penjamin_id:penjamin_id  },
                function(data){
                     myAlert(data.message);
                     $('#carabayardialog').dialog('close');   
                     window.location.reload();
                },"json");
        
    } 
    
 function dynamicPenjamin(obj) 
    {
       $.post("${url}/ajaxGetPenjamin", {carabayar_id: obj.value},
                function(data){
                   $('#ubahPenjamin_id').html(data.penjamin);
                },"json");
        
  
   }
   
//=====================================Akhir Ubah Cara Bayar============================================================    

//======================================Awal batal Periksa==============================================================

function dialogConfirm(pendaftaran_id,statusperiksa)
   {
        $('#confirm #pendaftaran_id').val(pendaftaran_id);
        $('#confirm #statusperiksa').val(statusperiksa);
        $('#confirm').dialog('open');
        
   } 
function ubahPeriksa()
    {
      var url =$('#url').val();
      var statusperiksa=$('#confirm #statusperiksa').val();
      var pendaftaran_id=$('#confirm #pendaftaran_id').val(); 
      if(statusperiksa=='${statusPeriksaBatalPeriksa}')
        {
            myAlert('PasienSudah Dibatalkan');
        }
      else
        {
             $.post("${url}/ubahPeriksa", {pendaftaran_id: pendaftaran_id,statusperiksa:statusperiksa},
                function(data){
                     myAlert(data.message);
                },"json");
            
        }
   
    }   
//=======================================Akhir Batal Periksa=============================================================   

//=======================================Awal Print Lembar Poli==========================================================

 function printLembarPoli(pendaftaran_id,instalasi_id)
   {
      window.open('${url}/printLembarPoli/pendaftaran_id/'+pendaftaran_id,'printwin','left=100,top=100,width=400,height=800');
   } 
//========================================Akhir Print Lembar Poli========================================================
JSCRIPT;
Yii::app()->clientScript->registerScript('alert',$js,CClientScript::POS_HEAD);                        


?>


