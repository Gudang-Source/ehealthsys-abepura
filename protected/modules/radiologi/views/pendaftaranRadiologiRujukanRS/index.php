
<div class="white-container">
    <legend class="rim2">Pendaftaran Radiologi <b>Rujukan Rumah Sakit</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pemeriksaanradiologi-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#no_pendaftaran',
    )); ?>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien radiologi berhasil disimpan !");
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
        <div class="row-fluid">
            <div class="span8">
                <fieldset class="box2">
                    <legend class="rim">Daftar Pemeriksaan Radiologi</legend>
                    <div id='content-pemeriksaan-lab'>
                        <?php 
                            $this->renderPartial($this->path_view_pendaftaran.'_formCariPemeriksaan',array(
                                                'modPemeriksaanRad'=>$modPemeriksaanRad,                                        
                                                )); ?>
                            <div class='checklists'></div>
                    </div>
                </fieldset>
            </div>
            <div class="span4">
                <fieldset class="box2">
                    <legend class="rim">Data Kunjungan Radiologi</legend>
                    <?php echo $this->renderPartial('_formMasukPenunjang',array('form'=>$form,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,'modTindakan'=>$modTindakan)); ?>
                </fieldset>
                <?php if(!isset($_GET['sukses'])){ ?>
                <div class="block-tabel">
                    <h6>Tabel Permintaan <b>Ke Penunjang</b></h6>
                    <div id="form-permintaankepenunjang" style="overflow-x: scroll;">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th width="80%">Nama Pemeriksaan Permintaan</th>
                                                                    <th>Status</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
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
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Tarif Tindakan</th>
                                <th>Total Tarif</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="block-tabel">
                    <h6>Kirim SMS</h6>
                    <div>
                        <?php 
                        if(Yii::app()->user->getState('issmsgateway')){
                           $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway)); 
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
                <?php 
                if(isset($_GET['sukses'])){
                    $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'riwayat-obatalkespasien-t',
                            'content'=>array(
                                'content-riwayat-obatalkespasien-t'=>array(
                                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk menampilkan obat alkes pasien')).'<b> Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                                    'isi'=>'
                                        <table class="table table-condensed table-striped">
                                            <thead>
                                                <th>No.</th>
                                                <th>Tgl. Pelayanan</th>
                                                <th>Obat / Alat Kesehatan</th>
                                                <th>Satuan Kecil</th>
                                                <th>Jumlah</th>
                                                <th>Hapus</th>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan=7>Data tidak ditemukan</td></tr>
                                            </tbody>
                                        </table>',
                                    'active'=>true,
                                ),   
                            ),
                    )); 
                }
                else{
                ?>
                    <div class="span4">
                        <fieldset class="box2">
                            <legend class='rim'>Pemakaian Bahan</legend>
                            <div id="form-tambahobatalkes">
                                <!--<div class="row-fluid box">-->
                                    <?php $this->renderPartial('_formObatAlkesPasien',array('modKunjungan'=>$modKunjungan)); ?>
                                <!--</div>-->
                            </div>
                        </fieldset>
                    </div>
                    <div class="span8">
                        <div class="block-tabel">
                            <h6>Tabel Obat <b>dan Alat Kesehatan</b></h6>
                            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Obat / Alat Kesehatan</th>
                                        <!--th>Satuan Kecil</th-->
                                        <!--RND-3097 <th>Tarif</th>-->
                                        <!--th>Stok</th-->
                                        <th>Jumlah</th>
                                        <!--RND-3097 <th>Sub Total</th>-->
                                        <th>Batal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php
                } 
                ?>
        </div>
    </fieldset>
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
                echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl('index'), 
                    array('class'=>'btn btn-danger',
                        'onclick'=>'return refreshForm(this);'));
                echo "&nbsp;";
            }
            if(!isset($_GET['pasienmasukpenunjang_id'])){
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled'=>true,'class'=>'btn btn-info','onclick'=>"return false"));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled'=>true,'class'=>'btn btn-info','onclick'=>"return false"));
                echo "&nbsp;";                
            }else{
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printStatus();return false"));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPemakaianOa(".$_GET['pasienmasukpenunjang_id'].");return false"));
            }
            $content = $this->renderPartial('tips/tipsPendaftaranRadiologiRujukanRS',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
        ?> 
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan, 'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,'modTindakan'=>$modTindakan, 'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
</div>