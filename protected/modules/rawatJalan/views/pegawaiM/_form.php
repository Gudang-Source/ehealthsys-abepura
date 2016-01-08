<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapegawai-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

<fieldset>
    <legend>Data Pegawai</legend>
        <table>
            <tr>
                <td width="60%">
                    <div>
                         <div class="control-group">
                            <?php echo $form->labelEx($model,'caraAmbilPhoto', array('class'=>'control-label','onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                               <div class="controls">  
                        <?php echo CHtml::radioButton('caraAmbilPhoto',true,array('value'=>'webCam','onclick'=>'caraAmbilPhotoJS(this)'));?> Web Cam
                        <?php echo CHtml::radioButton('caraAmbilPhoto',false,array('value'=>'file','onclick'=>'caraAmbilPhotoJS(this)'));?> File                               
                               </div>
                          </div>
                       
                    </div>
                    <div id="divCaraAmbilPhotoWebCam"  style="display: block">
                    <?php 
                        $random=rand(0000000000000000, 9999999999999999);                    
                        $pathPhotoPegawaiTumbs=Params::pathPegawaiTumbsDirectory();
                        $pathPhotoPegawai=Params::pathPegawaiDirectory();
                    ?>
                    <?php $onBeforeSnap = "document.getElementById('upload_results').innerHTML = '<h1>Proses Penyimpanan...</h1>';";
                          $completionHandler = <<<BLOCK
                          if (msg == 'OK') 
                           {
                                document.getElementById('upload_results').innerHTML = '<h1>OK! ...Photo Sedang Disimpan</h1>';

                                // reset camera for another shot
                                webcam.reset();
                                setTimeout(function(){
                                document.getElementById('upload_results').innerHTML = '<h1>Photo Berhasil Disimpan</h1>';
                                },3000);
//                              $('#sapegawai-m-form').submit();           
                              $.post("${urlAjaxSessionPhoto}",{},
                                    function(data){
                                    $('#gambar').attr('src',data.photo);
                                                 
                                },"json");   

                            }
                         else
                            {
                                myAlert("PHP Error: " + msg);
                            }
BLOCK;

      $this->widget('application.extensions.jpegcam.EJpegcam', array(
            'apiUrl' => 'index.php?r=photoWebCam/jpegcam.saveJpg&random='.$random.'&pathTumbs='.$pathPhotoPegawaiTumbs.'&path='.$pathPhotoPegawai.'',
            'shutterSound' => false,
            'stealth' => true,
            'buttons' => array(
                'configure' => 'Konfigurasi',
//                'takesnapshot' => 'Ambil Photo',
                'freeze'=>'Ambil Photo',
                'reset'=>'Ulang',
                
            ),
            'onBeforeSnap' => $onBeforeSnap,
            'completionHandler' => $completionHandler
        ));
?>     
<!--<img src="<?php //echo Params::urlPegawaiDirectory()?>9680901rizky.jpg " id="gambar">  -->

                        <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
                    </div>
                    <div id="divCaraAmbilPhotoFile" style="display: none">
                          <div class="control-group">
                            <?php echo $form->labelEx($model,'photopegawai', array('class'=>'control-label','onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                               <div class="controls">  
                                <?php echo Chtml::activeFileField($model,'photopegawai',array('maxlength'=>254,'Hint'=>'Isi Jika Akan Menambahkan Logo')); ?>
                                </div>
                          </div>
                      </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                      <?php echo $form->labelEx($model,'nama_pegawai',array('class'=>'control-label required')); ?>
                         <div class="controls inline">
                             <?php echo $form->dropDownList($model,'gelardepan',GelarDepan::items(), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span1')); ?>
                             <?php echo $form->textField($model,'nama_pegawai',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'class'=>'inputRequire')); ?>
                             <?php echo $form->dropDownList($model,'gelarbelakang_id',  CHtml::listData($model->getGelarBelakangItems(), 'gelarbelakang_id', 'gelarbelakang_nama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span1')); ?>
                          </div>
                    </div>
                </td>
                <td>
                       <?php echo $form->textFieldRow($model,'tempPhoto',array('readonly'=>TRUE,'value'=>$random.'.jpg')); ?>
                       <?php echo $form->textFieldRow($model,'nomorindukpegawai',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
            </tr> 
            <tr>
                <td>
                        <?php echo $form->dropDownListRow($model,'kategoripegawaiasal',LookupM::getItems('kategoriasalpegawai'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
                <td>
                        <?php echo $form->dropDownListRow($model,'kategoripegawai',LookupM::getItems('kategoripegawai'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
            </tr>
            <tr>
                <td>
                         <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',  CHtml::listData($model->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
                <td>
                     <?php echo $form->textFieldRow($model,'no_kartupegawainegerisipil',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
            </tr>
             <tr>
                <td>
                     <?php echo $form->textFieldRow($model,'no_taspen',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
                <td>
                     <?php echo $form->textFieldRow($model,'no_askes',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
            </tr>
            <tr>
                <td>
                        <?php echo $form->textFieldRow($model,'warganegara_pegawai',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25)); ?>
                </td>
                <td>
                         <?php echo $form->dropDownListRow($model,'kelompokjabatan',LookupM::getItems('kelompokjabatan'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
            </tr> 
            <tr>
                
                <td>
                     <?php echo $form->textFieldRow($model,'no_karis_karsu',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
                <td>
                       <?php echo $form->dropDownListRow($model,'jeniswaktukerja',LookupM::getItems('jeniswaktukerja'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>  
                </td>
            </tr>
            <tr>
                 <td>
                     <?php echo $form->dropDownListRow($model,'pangkat_id',  CHtml::listData($model->getPangkatItems(), 'pangkat_id', 'pangkat_nama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
                 <td>
                      <?php echo $form->dropDownListRow($model,'jabatan_id',  CHtml::listData($model->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                         <?php echo $form->labelEx($modRuanganPegawai,'ruangan_id',array('class'=>'control-label'));  ?>
                        <div class="control-group">
                            <div class="controls">

                                 <?php 
                                       $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                     array('sortable'=>true, 'searchable'=>true)
                                                );
                                        echo CHtml::dropDownList(
                                        'ruangan_id[]',
                                        '',
                                        CHtml::listData(RJRuanganM::model()->findAll(array('order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                                        array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                                );
                                  ?>
                            </div>
                        </div>
                    
                </td>
            </tr>
             
             <tr>
                <td>
                     <?php echo $form->textFieldRow($model,'nama_keluarga',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td>
                         <?php echo $form->dropDownListRow($model,'statusperkawinan',LookupM::getItems('statusperkawinan'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'inputRequire')); ?> 
                </td>
            </tr>
            <tr>
                <td>
                     <?php echo $form->textFieldRow($model,'tempatlahir_pegawai',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                </td>
                <td>
                     <?php echo $form->labelEx($model,'tgl_lahirpegawai', array('class'=>'control-label')) ?>
                       <div class="controls">  
                          <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_lahirpegawai',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                    ),
                        )); ?> 
                        </div>      
                </td>
                 
            </tr>
            <tr>
                <td>
                     <?php echo $form->dropDownListRow($model,'agama',LookupM::getItems('agama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'inputRequire')); ?>
                </td>
                 <td>
                     <?php echo $form->dropDownListRow($model,'suku_id',  CHtml::listData($model->getSukuItems(), 'suku_id', 'suku_nama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
            </tr>
             <tr>
                <td>
                         <?php echo $form->dropDownListRow($model,'pendidikan_id',  CHtml::listData($model->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($model,'pendkualifikasi_id',  CHtml::listData($model->getPendidikanKualifikasiItems(), 'pendkualifikasi_id', 'pendkualifikasi_nama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                )); ?>
                </td>
                
            </tr>
            <tr>
                <td>
                  <div class="control-group ">
                    <?php echo $form->labelEx($model,'golongandarah', array('class'=>'control-label')) ?>

                    <div class="controls">

                        <?php echo $form->dropDownList($model,'golongandarah', LookupM::getItems('golongandarah'),  
                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>   
                        <div class="radio inline">
                            <div class="form-inline">
                            <?php echo $form->radioButtonList($model,'rhesus',LookupM::getItems('rhesus'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>            
                            </div>
                       </div>
                        <?php echo $form->error($model, 'golongandarah'); ?>
                        <?php echo $form->error($model, 'rhesus'); ?>
                    </div>
                   </div>
                </td>
                 <td>
                    <?php echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputRequire')); ?>
                </td>
            </tr>            
        </table>
</fieldset>    
<fieldset>
    <legend>Contact Person</legend>
        <table>
             <tr>
                <td rowspan="4">
                     <?php echo $form->textAreaRow($model,'alamat_pegawai',array('rows'=>6, 'cols'=>50,  'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                     <?php echo $form->dropDownListRow($model,'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST',
                                                              'url'=>Yii::app()->createUrl('ActionDynamic/GetKabupaten',array('encode'=>false,'namaModel'=>'SAPegawaiM')),
                                                              'update'=>'#SAPegawaiM_kabupaten_id'))); ?>
                </td>
             </tr>   
             <tr>
                <td>
                      <?php echo $form->dropDownListRow($model,'kabupaten_id', array(), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST',
                                                              'url'=>Yii::app()->createUrl('ActionDynamic/GetKecamatan',array('encode'=>false,'namaModel'=>'SAPegawaiM')),
                                                              'update'=>'#SAPegawaiM_kecamatan_id'))); ?>
                </td>
            </tr>
            <tr>
                <td>
                     <?php echo $form->dropDownListRow($model,'kecamatan_id', array(), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'ajax'=>array('type'=>'POST',
                                                              'url'=>Yii::app()->createUrl('ActionDynamic/GetKelurahan',array('encode'=>false,'namaModel'=>'SAPegawaiM')),
                                                              'update'=>'#SAPegawaiM_kelurahan_id'))); ?>
                </td>
            </tr>
            <tr>
                <td>
                     <?php echo $form->dropDownListRow($model,'kelurahan_id', array(), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                               )); ?>
                </td>
            </tr>
            <tr>
                <td>
                        <?php echo $form->textFieldRow($model,'notelp_pegawai',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td>
                        <?php echo $form->textFieldRow($model,'nomobile_pegawai',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
            </tr>
            <tr>
                <td>
                      <?php echo $form->textFieldRow($model,'alamatemail',array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                </td>
                <td>
                   
                </td>
            </tr>
            
        </table>
</fieldset>    

	<div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 
                                                    'onKeypress'=>'return formSubmit(this,event)',
                                                    'id'=>'btn_simpan','onclick'=>'do_upload()',
                                                   )); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.pegawaiM.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));   
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
	</div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JS

function caraAmbilPhotoJS(obj)
{
    caraAmbilPhoto=obj.value;
    
    if(caraAmbilPhoto=='webCam')
        {
          $('#divCaraAmbilPhotoWebCam').slideToggle(500);
          $('#divCaraAmbilPhotoFile').slideToggle(500);
            
        }
    else
        {
         $('#divCaraAmbilPhotoWebCam').slideToggle(500);
          $('#divCaraAmbilPhotoFile').slideToggle(500);
        }
} 

function simpanDataPegawai()
{
    var caraAmbilPhoto = $('#caraAmbilPhoto');
     if(caraAmbilPhoto=='webCam')
        {
          $('#upload').click();  
          do_upload();
          $('#sapegawai-m-form').submit();           
        }
     else
        {
          $('#sapegawai-m-form').submit();           
        }
}    

JS;
Yii::app()->clientScript->registerScript('caraAmbilPhoto212',$js,CClientScript::POS_BEGIN);
?>