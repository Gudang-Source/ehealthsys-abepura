<div class="white-container">
    <legend class="rim2">Rencana <b>Operasi</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'rencanaoperasi-form',
            'enableAjaxValidation'=>false, // Ini yang bikin gw jadi gila selama 3 hari (from TRUE to FALSE)
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#no_pendaftaran',
    )); ?>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success', "Data rencana operasi berhasil disimpan !");
            $this->widget('bootstrap.widgets.BootAlert');
        }
    ?>
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Rujukan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial('_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>

    <fieldset class="box">
        <legend class="rim">Daftar Rencana Operasi</legend>
        <div id='content-pemeriksaan-bedah'>
                <?php $this->renderPartial('_formCariPemeriksaan',array('modPemeriksaanBedah'=>$modPemeriksaanBedah,)); ?>
                <div class='checklists'></div>
        </div>
    </fieldset>
        <div class="row-fluid">
            <div class="span4">
                <fieldset class="box">
                    <legend class="rim">Data Rencana Operasi</legend>
                    <?php echo $this->renderPartial('_formRencanaOperasi',array('form'=>$form,'modRencanaOperasi'=>$modRencanaOperasi)); ?>
                </fieldset>
            </div>
            <div class="span4">
                <fieldset class="box">
                    <legend class="rim">Data Kunjungan Bedah Sentral</legend>
                    <?php echo $this->renderPartial('_formMasukPenunjang',array('form'=>$form,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,'modTindakan'=>$modTindakan)); ?>
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
                </fieldset>
            </div>
            <div class="span4">
                <!--RSN-469-->
                <?php if(!isset($_GET['sukses'])){ ?>
                <div class="block-tabel">
                    <h6>Tabel Permintaan <b>Ke Penunjang</b></h6>
                    <div id="form-permintaankepenunjang" style="overflow-x: scroll;">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th width="90%">Nama Pemeriksaan Permintaan</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
		<?php } ?>
                <div class="block-tabel">
                    <h6>Tabel <b>Rencana Operasi</b> <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-arrow-down icon-white"></i>')),array('class'=>'btn btn-mini btn-primary', 'type'=>'button',"onclick"=>"setCheckedPemeriksaanDariPermintaan();", 'rel'=>'tooltip', 'title'=>'Klik untuk menyalin dari tabel permintaan')); ?></h6>
                    <div id="form-tindakanpemeriksaan" style="overflow-x: scroll;">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Nama Tindakan Operasi</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Tarif Tindakan</th>
                                <th>Total Tarif</th>
								<th>Cyto</th>
								<th>Tarif Cyto</th>
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
                        if(!isset($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                            echo "&nbsp;";
                        }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                            echo "&nbsp;";
                        }
                            echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl('index'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
                            echo "&nbsp;";
                        $content = $this->renderPartial('tips/tipsPendaftaranBedahSentralRujukanRS',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                    ?> 
            </div>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan, 'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,'modTindakan'=>$modTindakan,'modRencanaOperasi'=>$modRencanaOperasi)); ?>
