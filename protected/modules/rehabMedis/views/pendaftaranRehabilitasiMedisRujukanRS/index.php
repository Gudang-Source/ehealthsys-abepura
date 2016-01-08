<div class="white-container">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <legend class="rim2">Pendaftaran Rehabilitasi Medis <b>Rujukan Rumah Sakit</b></legend>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pemeriksaanrehabmedis-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#no_pendaftaran',
    )); ?>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien rehabilitasi medis berhasil disimpan !");
            $this->widget('bootstrap.widgets.BootAlert');
        }
    ?>
    <div class="row-fluid">
        <div class="span6">
            <?php 
            if(Yii::app()->user->getState('issmsgateway')){
               $this->renderPartial($this->path_view_pendaftaran.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway)); 
            }
            ?>
        </div>
    </div>
    
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Rujukan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial('_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <div class="row-fluid box">
        <div class="span8">
            <fieldset class="box2">
                <legend class="rim">Daftar Pemeriksaan Rehabilitasi Medis</legend>
                <div id='content-pemeriksaan-rehab'>
                    <?php 
                        $this->renderPartial($this->path_view_pendaftaran.'_formCariPemeriksaan',array(
                                            'modPemeriksaanRm'=>$modPemeriksaanRm,                                        
                                            )); ?>
                        <div class='checklists'></div>
                </div>
            </fieldset>
        </div>
        <div class="span4">
            <fieldset class="box2">
                <legend class="rim">Data Kunjungan Rehabilitasi Medis</legend>
                <?php echo $this->renderPartial('_formMasukPenunjang',array('form'=>$form,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,'modTindakan'=>$modTindakan)); ?>
            </fieldset>
            <?php if(!isset($_GET['sukses'])){ ?>
            <div class="block-tabel">
                <h6>Tabel Permintaan <b>Ke Penunjang</b></h6>
                <div id="form-permintaankepenunjang" style="overflow-x: scroll;">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <th>No.</th>
                            <th width="90%">Nama Pemeriksaan Permintaan</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><br />
                <div class="control-group">
                    <?php echo CHtml::label("Dokter Perujuk", 'pegawai_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('pegawai_id',$modKunjungan->pegawai_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('nama_pegawai',$modKunjungan->gelardepan." ".$modKunjungan->nama_pegawai." ".$modKunjungan->gelarbelakang_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Catatan Dokter Perujuk", 'catatandokterpengirim', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textArea('catatandokterpengirim',$modKunjungan->catatandokterpengirim,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="block-tabel">
                <h6>Tabel <b>Pemeriksaan</b> <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-arrow-down icon-white"></i>')),array('class'=>'btn btn-mini btn-primary', 'type'=>'button',"onclick"=>"setCheckedPemeriksaanDariPermintaan();", 'rel'=>'tooltip', 'title'=>'Klik untuk menyalin dari tabel permintaan')); ?></h6>
                <div id="form-tindakanpemeriksaan" style="overflow-x: scroll;">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <th>No.</th>
                            <th>Nama Pemeriksaan</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                    if($modPasienMasukPenunjang->isNewRecord){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                        echo "&nbsp;";
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                        echo "&nbsp;";
                    }
                    if(!isset($_GET['frame'])){
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->id.'/index'), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                        echo "&nbsp;";
                    }
                    if($modPasienMasukPenunjang->isNewRecord){
                        echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled'=>true,'class'=>'btn btn-info','onclick'=>"return false"));
                        echo "&nbsp;";
                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printStatus();return false"));
                        echo "&nbsp;";
                    }
                    $content = $this->renderPartial('tips/tipsPendaftaranRehabilitasiMedisRujukanRS',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan, 'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,'modTindakan'=>$modTindakan)); ?>
