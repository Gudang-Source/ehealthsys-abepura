<div class="white-container">
    <legend class="rim2">Pendaftaran <b>Rawat Jalan</b></legend>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pppendaftaran-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus'=>'#'.CHtml::activeId($modPasien,'no_rekam_medik'),
    )); ?>
    <?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modPasien); ?>
    <?php if (!isset($_GET['id'])) : ?>
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <?php echo CHtml::label('No. Antrian','noantrian',array('class'=>'control-label'));?>
                <div class="controls">
                    <?php echo $form->hiddenField($model,'antrian_id',array('readonly'=>true));?>
                    <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->loket_id,CHtml::listData($modAntrian->getLokets(), 'loket_id', 'loket_nama'),array('class'=>'span2','empty'=>'-- Pilih --','onchange'=>'setFormAntrian("reset");') )?>
                    <?php echo CHtml::textField('noantrian',$modAntrian->noantrian,array('readonly'=>true,'class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('id'=>'bth-lihatantrian','title'=>'Klik untuk menampilkan form antrian','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'$("#dialog-panggilantrian").dialog("open");')); ?>
                </div>
            </div>
        </div> 
    </div>
    <?php endif; ?>
    <fieldset class="box" id="form-pasien">
        <legend class="rim"><span class='judul'>Data Pasien Baru </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setPasienBaru();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk kembali ke Pasien Baru')); ?></span></legend>
        <div class="row-fluid">    
            <?php $this->renderPartial($this->path_view.'_formPasien', array('form'=>$form,'model'=>$model,'modPasien'=>$modPasien, 'modPegawai'=>$modPegawai ));?>
            <br>
            <div class = "span4">
                <?php echo $form->hiddenField($model,'is_adapjpasien', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-pjpasien',
                        'content'=>array(
                            'content-pjpasien'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan penanggung jawab pasien')).'<b> Penanggung Jawab Pasien</b>',
                                'isi'=>$this->renderPartial($this->path_view.'_formPenanggungJawabPasien',array(
                                        'form'=>$form,
                                        'modPenanggungJawab'=>$modPenanggungJawab,
                                        ),true),
                                'active'=>false,
                            ),   
                        ),
                )); ?>
            </div>
        </div>
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Data Kunjungan</legend>
        <div class="row-fluid">
        <?php echo $this->renderPartial($this->path_view.'_formPendaftaran', array('form'=>$form,'model'=>$model, 'modPasien'=>$modPasien, 'modRujukan'=>$modRujukan, 'modRujukanBpjs'=>$modRujukanBpjs, 'modAsuransiPasien'=>$modAsuransiPasien, 'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs, 'modSep'=>$modSep,'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,'modPegawai'=>$modPegawai)); ?>
            <div class = "span4">
                <?php echo $form->hiddenField($model,'is_adakarcis', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-karcis',
                        'content'=>array(
                            'content-karcis'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan karcis')).'<b> Karcis</b>',
                                'isi'=>'<div id="content-karcis-html">'
										.$this->renderPartial($this->path_view.'_formKarcis',array(
											'form'=>$form,
											'model'=>$model,
											'modTindakan'=>$modTindakan,
											'modKarcisV'=>$modKarcisV
											),true)
										.'</div>',
                                'active'=>$model->is_adakarcis,
                            ),   
                        ),
                )); ?>
            </div>
            <div class = "span4">
                <?php echo $form->hiddenField($model,'is_pasienrujukan', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-rujukan',
                        'content'=>array(
                            'content-rujukan'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan rujukan')).'<b> Rujukan</b>',
                                'isi'=>$this->renderPartial($this->path_view.'_formRujukan',array(
                                        'form'=>$form,
                                        'model'=>$model,
                                        'modRujukan'=>$modRujukan,
                                        ),true),
                                'active'=>$model->is_pasienrujukan,
                            ),   
                        ),
                        'htmlOptions'=>array('style'=>(($model->is_bpjs)?'display:none':'')),
                )); ?>
                <?php 
                if(Yii::app()->user->getState('issmsgateway')){
                    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-smsgateway',
                        'content'=>array(
                            'content-smsgateway'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Kirim SMS')).'<b> Kirim SMS</b>',
                                'isi'=> $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway), true),
                                'active'=>true,
                            ),   
                        ),
                    ));
                }
                ?>
                
				<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-riwayatpasien',
                        'content'=>array(
                            'content-riwayatpasien'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat kunjungan pasien')).'<b> Riwayat Kunjungan Pasien</b>',
                                'isi'=>$this->renderPartial($this->path_view.'_tableRiwayatPasien',array(
                                        'form'=>$form,
                                        'modPasien'=>$modPasien,
                                        ),true),
                                'active'=>true,
                            ),   
                        ),
                )); ?>
            </div>

        </div>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
                <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); ?>
                <?php 
                if($model->isNewRecord){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'if (!cekJamPoli()) return false; setVerifikasi();', 'onkeypress'=>'if (!cekJamPoli()) return false; setVerifikasi();')); //formSubmit(this,event)
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                }
                ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->id.'/index'), 
                            array('class'=>'btn btn-danger',
                                'onclick'=>'return refreshForm(this);'));  ?>
                <?php
                    if($model->isNewRecord){
                        echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';
                        if(Yii::app()->user->getState('isbridging')){
                            echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        }else{
                            echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Fitur Bridging tidak aktif!','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        }
                        echo "&nbsp;".CHtml::link(Yii::t('mds', '{icon} Print SJP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';

                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKarcis();return false",'disabled'=>FALSE  )).'&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print Status Pasien', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printStatus();return false",'disabled'=>FALSE  )).'&nbsp;';
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKartuPasien('$model->pasien_id');return false",'disabled'=>FALSE  )).'&nbsp;';                                               
                        
                        if(Yii::app()->user->getState('isbridging')){
                            if (isset($modSep->sep_id)) {
                                echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printSEP();return false",'disabled'=>FALSE  ));
                            }else{
                                echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Belum memiliki No. SEP!','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                            }
                        }else{
                            echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Fitur Bridging tidak aktif!','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        }
                        
                         if ($model->carabayar_id == Params::CARABAYAR_ID_JAMKESPA){
                            echo "&nbsp;".CHtml::link(Yii::t('mds', '{icon} Print SJP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printSJP();return false",'disabled'=>FALSE)).'&nbsp;';
                        }else{
                            echo "&nbsp;".CHtml::link(Yii::t('mds', '{icon} Print SJP', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';
                        }
                    }
                ?>

                <?php 
                $content = $this->renderPartial($this->path_view.'tips/tipsPendaftaranRawatJalan',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
    <hr />
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial('_tablePendaftaranTerakhir', array()); ?>



    <?php 
    $autoopen = Yii::app()->user->getState('isantrian');
    if(!empty($model->pendaftaran_id)){
        $autoopen = false;
    }
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-panggilantrian',
        'options'=>array(
            'title'=>'No. Antrian',
            'autoOpen'=>$autoopen,
            'width'=>180,
            'resizable'=>false,
            'position'=>array("right",140),
        ),
    ));
    ?>
    <div class="dialog-content">
        <?php echo $this->renderPartial($this->path_view.'_formPanggilAntrian', array('modAntrian'=>$modAntrian)); ?>
    </div>

    <div style="text-align: center;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-backward icon-white"></i>')),array('title'=>'Klik untuk tampilkan antrian sebelumnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("prev");','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-forward icon-white"></i>')),array('title'=>'Klik untuk tampilkan antrian berikutnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("next");','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php //RND-1956 >>> echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-down icon-white"></i>')),array('title'=>'Klik untuk membatalkan pemanggilan antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian("batal");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('title'=>'Klik untuk mengulang antrian','rel'=>'tooltip','class'=>'btn btn-mini btn-danger','onclick'=>'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
        <br>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Panggil / Daftar',array('id'=>'btn-panggilantrian','{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian();}','style'=>'font-size:10px; width:128px; height:24px;')); ?>
    </div>
    <?php $this->endWidget(); ?>
    
    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-verifikasi',
        'options'=>array(
            'title'=>'Verifikasi Pendaftaran',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>960,
            'minHeight'=>480,
            'resizable'=>false,
        ),
    ));

    echo '<div class="dialog-content"></div>';
    ?>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'disableOnSubmit(this); $("#pppendaftaran-t-form").submit();')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id'=>'dialogDiagnosa',
            'options'=>array(
                'title'=>'Pencarian Diagnosa Rujukan',
                'autoOpen'=>false,
                'modal'=>true,
                'width'=>960,
                'height'=>480,
                'resizable'=>false,
            ),
        ));
        $modDiagnosa = new PPDiagnosaM('search');
        $modDiagnosa->unsetAttributes();
        if(isset($_GET['PPDiagnosaM'])) {
            $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'diagnosa-m-grid',
                'dataProvider'=>$modDiagnosa->search(),
                'filter'=>$modDiagnosa,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "
                                                if($(\"#content-bpjs\").hasClass(\"in\")){
                                                    setDiagnosaBpjs(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                                }else{
                                                    setDiagnosa(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                                }

                                                $(\"#dialogDiagnosa\").dialog(\"close\");
                                            "))',
                        ),
                        'diagnosa_kode',
                        'diagnosa_nama',
                        'diagnosa_namalainnya',
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        $this->endWidget();
    ?>

    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id'=>'dialogAsuransi',
            'options'=>array(
                'title'=>'Pencarian Asuransi Pasien',
                'autoOpen'=>false,
                'modal'=>true,
                'width'=>960,
                'height'=>480,
                'resizable'=>false,
            ),
        ));
        $modCariAsuransiPasien=new PPAsuransipasienM('search');
        $modCariAsuransiPasien->unsetAttributes();
        if(isset($_GET['PPAsuransipasienM'])) {
            $modCariAsuransiPasien->attributes = $_GET['PPAsuransipasienM'];
            isset($_GET['PPAsuransipasienM']['pasien_id'])?$modCariAsuransiPasien->pasien_id = $_GET['PPAsuransipasienM']['pasien_id']:'';
            isset($_GET['PPAsuransipasienM']['penjamin_id'])?$modCariAsuransiPasien->penjamin_id = $_GET['PPAsuransipasienM']['penjamin_id']:'';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'asuransi-m-grid',
                'dataProvider'=>$modCariAsuransiPasien->searchDialog(),
                'filter'=>$modCariAsuransiPasien,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectAsuransi",
                                            "onClick" => "
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'asuransipasien_id').'\").val($data->asuransipasien_id);
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'nopeserta').'\").val(\"$data->nopeserta\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'\").val(\"$data->nokartuasuransi\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'\").val(\"$data->namapemilikasuransi\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'\").val(\"$data->jenispeserta_id\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'\").val(\"$data->nomorpokokperusahaan\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'\").val(\"$data->namaperusahaan\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'\").val(\"$data->kelastanggunganasuransi_id\");
                                                setAsuransiLama()
                                                $(\"#dialogAsuransi\").dialog(\"close\");
                                            "))',
                        ),
                        'nokartuasuransi',
                        'nopeserta',
                                            array(
                                                    'header'=>'Nama Pemilik Asuransi',
                                                    'value'=>'$data->namapemilikasuransi',
                                                    'filter'=>CHtml::activeHiddenField($modCariAsuransiPasien, 'pasien_id',array('readonly'=>true))."".CHtml::activeHiddenField($modCariAsuransiPasien, 'penjamin_id',array('readonly'=>true))."".CHtml::activeTextField($modCariAsuransiPasien, 'namapemilikasuransi',array()),
                                                    'htmlOptions'=>array('style'=>'text-align:right;'),
                                            ),
                        'namaperusahaan',
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        $this->endWidget();
    ?>

    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id'=>'dialogAsuransiBpjs',
            'options'=>array(
                'title'=>'Pencarian Asuransi Pasien Bpjs',
                'autoOpen'=>false,
                'modal'=>true,
                'width'=>960,
                'height'=>480,
                'resizable'=>false,
            ),
        ));
        $modCariAsuransiPasienBpjs=new PPAsuransipasienbpjsM('search');
        $modCariAsuransiPasienBpjs->unsetAttributes();
        if(isset($_GET['PPAsuransipasienbpjsM'])) {
            $modCariAsuransiPasienBpjs->attributes = $_GET['PPAsuransipasienbpjsM'];
            isset($_GET['PPAsuransipasienbpjsM']['pasien_id'])?$modCariAsuransiPasienBpjs->pasien_id = $_GET['PPAsuransipasienbpjsM']['pasien_id']:'';
            isset($_GET['PPAsuransipasienbpjsM']['penjamin_id'])?$modCariAsuransiPasienBpjs->penjamin_id = $_GET['PPAsuransipasienbpjsM']['penjamin_id']:'';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'asuransibpjs-m-grid',
                'dataProvider'=>$modCariAsuransiPasienBpjs->searchDialog(),
                'filter'=>$modCariAsuransiPasienBpjs,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectAsuransi",
                                            "onClick" => "
                                                $(\"#'.CHtml::activeId($modAsuransiPasienBpjs,'asuransipasien_id').'\").val($data->asuransipasien_id);
                                                $(\"#'.CHtml::activeId($modAsuransiPasienBpjs,'nopeserta').'\").val(\"$data->nopeserta\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi').'\").val(\"$data->nokartuasuransi\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi').'\").val(\"$data->namapemilikasuransi\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id').'\").val(\"$data->jenispeserta_id\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasienBpjs,'nomorpokokperusahaan').'\").val(\"$data->nomorpokokperusahaan\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasienBpjs,'namaperusahaan').'\").val(\"$data->namaperusahaan\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id').'\").val(\"$data->kelastanggunganasuransi_id\");
                                                getAsuransiNoKartu(\'$data->nopeserta\');
                                                setAsuransiLama()
                                                $(\"#dialogAsuransiBpjs\").dialog(\"close\");
                                            "))',
                        ),
                        'nokartuasuransi',
                        'nopeserta',
                                            array(
                                                    'header'=>'Nama Pemilik Asuransi',
                                                    'value'=>'$data->namapemilikasuransi',
                                                    'filter'=>CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'pasien_id',array('readonly'=>true))."".CHtml::activeHiddenField($modCariAsuransiPasienBpjs, 'penjamin_id',array('readonly'=>true))."".CHtml::activeTextField($modCariAsuransiPasienBpjs, 'namapemilikasuransi',array()),
                                                    'htmlOptions'=>array('style'=>'text-align:right;'),
                                            ),
                        'namaperusahaan',
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        $this->endWidget();
    ?>
    <?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model, 'modPasien'=>$modPasien, 'modPegawai'=>$modPegawai, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modRujukanBpjs'=>$modRujukanBpjs, 'modAsuransiPasien'=>$modAsuransiPasien, 'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs, 'modSep'=>$modSep, 'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja, 'ruangan'=>$ruangan)); ?>
<?php echo $this->renderPartial($this->path_view.'_jsFunctionsAntrian', array('model'=>$model, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modAntrian'=>$modAntrian)); ?>
</div>
