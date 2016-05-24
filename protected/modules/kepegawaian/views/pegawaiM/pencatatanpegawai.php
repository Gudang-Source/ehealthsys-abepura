<div class="white-container">
    <legend class="rim2">Transaksi <b>Pencatatan Pegawai</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/fileupload/fileupload.js'); ?>
    <?php
    $this->breadcrumbs=array(
            'Sapegawai Ms'=>array('index'),
            'Create',
    );

    /*
     * start tidak tahu untuk apa 
     */
    $random = rand(000000, 999999);
    /*
     * end tidak tahu untuk apa 
     */

    $arrMenu = array();
//    array_push($arrMenu,array('label'=>Yii::t('mds','Pencatatan').' Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'sapegawai-m-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#KPPegawaiM_nomorindukpegawai',
    )); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<?php
	if (isset($_GET['pegawai_id'])) {
		Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
	}
	?>
    <?php echo $form->errorSummary($model); ?>
   
    <div class="row-fluid">
        <div class="span8">
        <div class="span5" style = "width:50%;margin-right:5px;">
        <fieldset class = "box">
            <legend class="rim">Data Pribadi</legend>    
            <?php /*
            <div class="control-group">
              <?php echo $form->labelEx($model,'unit_perusahaan',array('class'=>'control-label')); ?>
              <div class="controls">
                <?php echo $form->dropDownList($model,'unit_perusahaan',LookupM::getItems('unit_perusahaan'), 
                    array('onkeyup'=>"return $(this).focusNextInputField(event)", 'readonly'=>true)); //'empty'=>'-- Pilih --', ?>  
              </div>
            </div> 
             * 
             */?>
            <?php echo $form->hiddenField($model,'unit_perusahaan',array('class'=>'required numbers-only','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nomor Induk Pegawai','maxlength'=>20, 'readonly',true,'value'=> LookupM::getNama('unit_perusahaan'))); ?>
            <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'required numbers-only','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nomor Induk Pegawai','maxlength'=>18)); ?>

            <div class="control-group">
                    <?php echo CHtml::label('No. Identitas','jenisidentitas',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'jenisidentitas',LookupM::getItems('jenisidentitas'),array('empty'=>'-- Pilih --','id'=>'jenisidentitas','style'=>'width:70px;','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textField($model,'noidentitas',array('class'=>'numbers-only','empty'=>'-- Pilih --','id'=>'noidentitas','style'=>'width:135px;','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Identitas Pegawai','maxlength'=>18)); ?>
                </div>
            </div>
    <!--         RND-4482 : Memisahkan Gelardepan,Gelar Belakang dengan Nama Pegawai-->
            <div class="control-group">
                <?php echo $form->labelEx($model,'gelardepan',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'gelardepan',CHtml::listData($model->getGelarDepanItems(), 'lookup_id', 'lookup_name'), 
                                 array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                       'style'=>'width:70px;')); ?>               
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'nama_pegawai',array('class'=>'control-label required')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'nama_pegawai',array( 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'class'=>'inputRequire','style'=>'width:208px;','placeholder'=>'Nama Lengkap Pegawai')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'gelarbelakang_id',array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php echo $form->dropDownList($model,'gelarbelakang_id',  CHtml::listData($model->getGelarBelakangItems(), 'gelarbelakang_id', 'gelarbelakang_nama'), 
                                 array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                       'style'=>'width:70px;')); ?>               
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'nama_keluarga',array( 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'Nama Keluarga Pegawai')); ?>


            <?php echo $form->textFieldRow($model,'tempatlahir_pegawai',array( 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30,'placeholder'=>'Kota/Kabupaten Kelahiran')); ?>

            <div class="control-group">
                <?php echo $form->labelEx($model,'tgl_lahirpegawai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
//                    $model->tgl_lahirpegawai = (!empty($model->tgl_lahirpegawai) ? date("d/m/Y",strtotime($model->tgl_lahirpegawai)) : null);
//                    $this->widget('MyDateTimePicker',array(
//                                            'model'=>$model,
//                                            'attribute'=>'tgl_lahirpegawai',
//                                            'mode'=>'date',
//                                            'options'=> array(
//                                                    'dateFormat'=>Params::DATE_FORMAT,
//                                                'showOn' => false,
//                                                'maxDate' => 'd',
//                                                'yearRange'=> "-150:+0",
//                                            ),
//                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
//                                            ),
//                    )); 
						$model->tgl_lahirpegawai = $format->formatDateTimeForUser($model->tgl_lahirpegawai);
						$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_lahirpegawai',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
						)); 
						$model->tgl_lahirpegawai = $format->formatDateTimeForDb($model->tgl_lahirpegawai);					
					?>
                    <?php echo $form->error($model, 'tgl_lahirpegawai'); ?>
                </div>
            </div>
            
           
            <?php 
                if (empty($model->jeniskelamin)):
                    $model->jeniskelamin = 'LAKI-LAKI';
                endif;
                
                echo $form->radioButtonListInlineRow($model, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'inputRequire')); ?>
                
            <div class="control-group">
                <?php echo CHtml::label('Tinggi / Berat Badan','tinggiberatbadan',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'tinggibadan',array('class'=>'span1 integer','style'=>'width:65px;','id'=>'tinggiberatbadan','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Tinggi Badan')) ?>
                    <?php echo ' / '; ?>
                    <?php echo $form->textField($model,'beratbadan',array('class'=>'span1 integer','style'=>'width:60px;','id'=>'tinggiberatbadan','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Berat Badan')) ?>
                </div>
            </div>
             <div class="control-group ">
                <?php echo $form->labelEx($model,'golongandarah', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'golongandarah', LookupM::getItems('golongandarah'),  
                                                  array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>   
                    <div class="radio inline">
                        <div class="form-inline">
                            <?php echo $form->radioButtonList($model,'rhesus',LookupM::getItems('rhesus'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
                        </div>
                    </div>
                    <?php echo $form->error($model, 'golongandarah'); ?>
                    <?php echo $form->error($model, 'rhesus'); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model,'agama',LookupM::getItems('agama'), 
                                 array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                       'class'=>'inputRequire')); ?>
            <?php echo $form->dropDownListRow($model,'suku_id',  CHtml::listData($model->getSukuItems(), 'suku_id', 'suku_nama'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'warganegara_pegawai',LookupM::getItems('warganegara'),array( 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>25, 'empty'=>'-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($model,'statusperkawinan',LookupM::getItems('statusperkawinan'), 
                            array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                  'class'=>'inputRequire')); ?>  
            <p>&nbsp;</p>
            </fieldset>
        </div>
        
        <div class="span5" style = "width:49%;">
            <fieldset class = "box">
                <legend class="rim">Alamat / Kontak</legend>                 
                <?php echo $form->textAreaRow($model,'alamat_pegawai',array('rows'=>6, 'cols'=>50,  'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Alamat Lengkap Pegawai')); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'propinsi_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                                    array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                            'ajax'=>array('type'=>'POST',
                                                        'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($model))),
                                                        'update'=>"#".CHtml::activeId($model, 'kabupaten_id'),
                                            ),
                                            'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
                        <?php echo $form->error($model, 'propinsi_id'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'kabupaten_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
                                    array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                            'ajax'=>array('type'=>'POST',
                                                        'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($model))),
                                                        'update'=>"#".CHtml::activeId($model, 'kecamatan_id'),
                                            ),
                                            'onchange'=>"setClearDropdownKelurahan();",));?>
                        <?php echo $form->error($model, 'kabupaten_id'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'kecamatan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'kecamatan_id', CHtml::listData($model->getKecamatanItems($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), 
                                    array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                            'ajax'=>array('type'=>'POST',
                                                        'url'=>$this->createUrl('SetDropdownKelurahan',array('encode'=>false,'model_nama'=>get_class($model))),
                                                        'update'=>"#".CHtml::activeId($model, 'kelurahan_id'),
                                            ),
                                            'onchange'=>"",));?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'kelurahan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'kelurahan_id',CHtml::listData($model->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                                          array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->error($model, 'kelurahan_id'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'garis_latitude',array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model,'garis_longitude',array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <?php echo CHtml::label('No. Telp / Hp','nomorcontact',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'notelp_pegawai',array( 'class'=>'span2 numbers-only','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15,'style'=>'width:97px;text-align:right;','id'=>'nomorcontact','placeholder'=>'No. Telepon Pegawai')); ?>
                        <?php echo ' / '; ?>
                        <?php echo $form->textField($model,'nomobile_pegawai',array('class'=>'span2 numbers-only', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>15,'style'=>'width:97px;text-align:right;','id'=>'nomorcontact','placeholder'=>'No. Ponsel Pegawai')); ?>
                    </div>
                </div>
		<?php echo $form->textFieldRow($model,'alamatemail',array( 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'placeholder'=>'contoh: info@piinformasi.com')); ?>	                
            </fieldset>
            <fieldset class = "box">
                <legend class="rim">Data Lain - Lain</legend>
                    <?php echo $form->dropDownListRow($model,'statuskepemilikanrumah_id',CHtml::listData($model->getStatuskepemilikanrumahItems(),'statuskepemilikanrumah_id','statuskepemilikanrumah_nama'),array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model,'kemampuanbahasa',array('onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'contoh : Bahasa Indonesia, Inggris')); ?>
                    <?php echo $form->textFieldRow($model,'warnakulit',array('onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'contoh : Sawo Matang')); ?>
            </fieldset>    
        </div>
            
        <div class = "span12">
            <fieldset class = "box">
                <legend class="rim">Ruangan</legend>    
                   <table width="100%" class="table-condensed">
                        <tr>
                            <td style="width:127px;text-align:right;">
                                <div class="control-group">
                                    <?php echo CHtml::label('Ruangan / Unit kerja','ruangan',array('class'=>'control-label'));  ?>
                                </div>
                            </td>
                            <td>
                                <?php 
                                       $arrRuanganPegawai = array();
                                        foreach($modRuanganPegawai as $tampilRuanganPegawai){
                                           $arrRuanganPegawai[] = isset($tampilRuanganPegawai['ruangan_id']) ? $tampilRuanganPegawai['ruangan_id'] : null;
                                       }                                  
                                      $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                    array('sortable'=>true, 'searchable'=>true)
                                               );
                                       echo CHtml::dropDownList(
                                       'ruangan_id[]',
                                       $arrRuanganPegawai,
                                       CHtml::listData(KPRuanganM::model()->findAll(array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'),
                                       array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                               );
                                ?>
                            </td>
                        </tr>
                    </table>
            </fieldset>
        </div>  
            
        </div>    
        <div class="span4">
            <fieldset class = "box">
                <legend class="rim">Data Kepegawaian</legend> 
                <?php echo $form->dropDownListRow($model,'golonganpegawai_id',  CHtml::listData($model->getGolonganPegawaiItems(), 'golonganpegawai_id', 'golonganpegawai_nama'), 
                           array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                 )); ?>
                
                <?php echo $form->dropDownListRow($model,'pangkat_id',  CHtml::listData($model->getPangkatItems(), 'pangkat_id', 'pangkat_nama'), 
                           array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                 )); ?>
                
                <?php echo $form->dropDownListRow($model,'jabatan_id',  CHtml::listData($model->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), 
                           array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                 )); ?>
                
                <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',  CHtml::listData($model->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'), 
                array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                
                <?php echo $form->dropDownListRow($model,'jenistenagamedis_id',  CHtml::listData($model->getJenisTenagaMedisItems(), 'jenistenagamedis_id', 'tenagamedis_nama'), 
                array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                
                <?php echo $form->dropDownListRow($model,'kategoripegawai',LookupM::getItems('kategoripegawai'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                
                <?php echo $form->dropDownListRow($model,'kategoripegawaiasal',LookupM::getItems('kategoriasalpegawai'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                
                <?php echo $form->dropDownListRow($model,'kelompokjabatan',LookupM::getItems('kelompokjabatan'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

            <?php echo $form->dropDownListRow($model,'jeniswaktukerja',LookupM::getItems('jeniswaktukerja'), 
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>  
            
            <div class="control-group ">
                    <?php echo $form->labelEx($model,'pendidikan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'pendidikan_id', CHtml::listData($model->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), 
                                    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                            'ajax'=>array('type'=>'POST',
                                                        'url'=>$this->createUrl('SetDropdownPendKualifikasi',array('encode'=>false,'model_nama'=>get_class($model))),
                                                        'update'=>"#".CHtml::activeId($model, 'pendkualifikasi_id'),
                                            ),
                                            'onchange'=>"setClearDropdownKelompokPegawai();",));?>
                        <?php echo $form->error($model, 'pendidikan_id'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'pendkualifikasi_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'pendkualifikasi_id', CHtml::listData($model->getPendKualifikasiItems($model->pendidikan_id), 'pendkualifikasi_id', 'pendkualifikasi_nama'), 
                                    array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                            'ajax'=>array('type'=>'POST',
                                                        'url'=>$this->createUrl('SetDropdownKelompokPegawai',array('encode'=>false,'model_nama'=>get_class($model))),
                                                        'update'=>"#".CHtml::activeId($model, 'kelompokpegawai_id'),
                                            )));?>
                        <?php echo $form->error($model, 'pendkualifikasi_id'); ?>
                    </div>
                </div>
		
            <div class='control-group'>
                <?php echo $form->labelEx($model,'tglditerima', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
//                    $model->tgl_lahirpegawai = (!empty($model->tgl_lahirpegawai) ? date("d/m/Y",strtotime($model->tglditerima)) : null);
//                    $this->widget('MyDateTimePicker',array(
//                                            'model'=>$model,
//                                            'attribute'=>'tglditerima',
//                                            'mode'=>'date',
//                                            'options'=> array(
//        //                                            'dateFormat'=>Params::DATE_FORMAT,
//                                                'showOn' => false,
//                                                'maxDate' => 'd',
//                                                'yearRange'=> "-150:+0",
//                                            ),
//                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
//                                            ),
//                    )); 
					$model->tglditerima = $format->formatDateTimeForUser($model->tglditerima);
						$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tglditerima',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
						)); 
						$model->tglditerima = $format->formatDateTimeForDb($model->tglditerima);
					?>
                    <?php echo $form->error($model, 'tglditerima'); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo $form->labelEx($model,'caraAmbilPhoto', array('class'=>'control-label')) ?>
                <div class="controls">  
                    <?php echo CHtml::radioButton('caraAmbilPhoto',false,array('value'=>'webCam','onclick'=>'caraAmbilPhotoJS(this)','onkeyup'=>"return $(this).focusNextInputField(event)"));?><span style='font-size:11px';>Web Cam</span>
                    <?php echo CHtml::radioButton('caraAmbilPhoto',true,array('value'=>'file','onclick'=>'caraAmbilPhotoJS(this)','onkeyup'=>"return $(this).focusNextInputField(event)"));?><span style='font-size:11px';>File</span>                               
                </div>
            </div>
            <div id="divCaraAmbilPhotoWebCam"  style="display:none;">
                <div class="controls">
                    <div class="buttonWebcam2">
                        <?php 
                            $random=rand(0000000000000000, 9999999999999999);                    
                            $pathPhotoPegawaiTumbs=Params::pathPegawaiTumbsDirectory();
                            $pathPhotoPegawai=Params::pathPegawaiDirectory();
                            $urlAjaxSessionPhoto = '';
                        ?>
                        <?php echo $form->hiddenField($model,'tempPhoto',array('readonly'=>TRUE,'value'=>$random.'.jpg')); ?>
                        <?php $onBeforeSnap = "document.getElementById('upload_results').innerHTML = '<h1>Proses Penyimpanan...</h1>';";
                          $completionHandler = <<<BLOCK
                          if (msg == 'OK') 
                           {
                                document.getElementById('upload_results').innerHTML = '<h1>OK! ...Photo Sedang Disimpan</h1>';

                                // reset camera for another shot
                                // webcam.reset();
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
                'takesnapshot' => 'Simpan',
            ),
            'onBeforeSnap' => $onBeforeSnap,
            'completionHandler' => $completionHandler
        ));
?>
<!--<img src="<?php //echo Params::urlPegawaiDirectory()?>9680901rizky.jpg " id="gambar">  -->

        <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
                    </div>
                </div>
            </div>
            <div id="divCaraAmbilPhotoFile" style="display: block;">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                  <div class="control-group">
                    <?php echo $form->labelEx($model,'photopegawai', array('class'=>'control-label','onkeyup'=>"return $(this).focusNextInputField(event);")) ?>
                      <div class="controls">  
                        <?php echo Chtml::activeFileField($model,'photopegawai',array('maxlength'=>254,'Hint'=>'Isi Jika Akan Menambahkan Logo','class'=>'fileupload-new')); ?>
                      </div>
                  </div>
                  <div class="control-group">
                      <div class="controls">
                          <div class="fileupload-preview fileupload-exists thumbnail" style="max-width:90%;line-height:20px;margin-left:34.3%"><img src="<?php echo Params::urlPhotoPasienDirectory().'no_photo.jpeg'; ?>" /></div>
                      </div>
                  </div>
                  </div>
            </div>
			
			<br><br>
			<p class="help-block">Dibawah ini hanya diisi untuk dokter tamu atau jenis waktu kerja freelance</p>
			<div class='control-group'>
                <?php echo $form->labelEx($model,'tglmasaaktifpeg', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                    $model->tglmasaaktifpeg = (!empty($model->tglmasaaktifpeg) ? date("d/m/Y",strtotime($model->tglmasaaktifpeg)) : null);
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglmasaaktifpeg',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'showOn' => false,
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'tglmasaaktifpeg'); ?>
                </div>
            </div>
			<div class='control-group'>
                <?php echo $form->labelEx($model,'tglmasaaktifpeg_sd', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                    $model->tglmasaaktifpeg_sd = (!empty($model->tglmasaaktifpeg_sd) ? date("d/m/Y",strtotime($model->tglmasaaktifpeg_sd)) : null);
                    $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglmasaaktifpeg_sd',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'showOn' => false,
                                                'yearRange'=> "-150:+0",
                                            ),
                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php echo $form->error($model, 'tglmasaaktifpeg_sd'); ?>
                </div>
            </div>
            </fieldset>
        </div>
    </div>
    <div class="row-fluid">        
        <div class="form-actions">
            <?php 
                if($model->isNewRecord){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanDataPegawai();', 'onkeypress'=>'simpanDataPegawai();'));
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanDataPegawai();', 'onkeypress'=>'simpanDataPegawai();','disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                }
//			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
//                                                                array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'simpanDataPegawai()')); ?>
            
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('PegawaiM/Pencatatanpegawai'), array('class'=>'btn btn-danger')); ?>
            <?php if($model->isNewRecord == FALSE && isset($_GET['pegawai_id']))
                    {
            ?>
                        <script>
                            print(<?php echo $model->pegawai_id ?>);
                        </script>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$model->pegawai_id');return false",'disabled'=>FALSE  )); 
                  // }else{
                   // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
                   } 
            ?>
            <?php
                $content = $this->renderPartial('../tips/transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                $urlPrintKartuPegawai = $this->createUrl('kartuPegawai',array('idPegawai'=>''));
            ?>  
        </div>       
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php
$js = <<< JS

function print(idPegawai)
{
  window.open('${urlPrintKartuPegawai}'+idPegawai,'printwi','left=100,top=100,width=299px,height=192px');
}

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
<?php //$this->widget('UserTips',array('type'=>'create'));?>
<script type="text/javascript">	
/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($model,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($model,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function setClearDropdownKelompokPegawai()
{
    $("#<?php echo CHtml::activeId($model,"kelompokpegawai_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
setClearDropdownKelurahan();
setClearDropdownKecamatan();

});
</script>