<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN BMHP di Billing Kasir ?>
<?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data pemakaian BMHP berhasil disimpan !");
    }
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pemakaianbahp-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#no_pendaftaran',
)); ?>
    
    <div class="row-fluid">
        <?php
            $kelaspelayanan_id = (!empty($modPasienAdmisi->kelaspelayanan_id) ? $modPasienAdmisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id);
            $carabayar_id = (!empty($modPasienAdmisi->carabayar_id) ? $modPasienAdmisi->carabayar_id : $modPendaftaran->carabayar_id);
            $penjamin_id = (!empty($modPasienAdmisi->penjamin_id) ? $modPasienAdmisi->penjamin_id : $modPendaftaran->penjamin_id);
            $instalasi_id = (!empty($modPasienAdmisi->ruangan->instalasi_id) ? $modPasienAdmisi->ruangan->instalasi_id : $modPendaftaran->ruangan->instalasi_id);
            $ruangan_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan_id : $modPendaftaran->ruangan_id);
        ?>
        <div style="display:none;">
            <?php echo Chtml::textField('pendaftaran_id',$modPendaftaran->pendaftaran_id,array('readonly'=>true)); ?>
            <?php echo Chtml::textField('pasienadmisi_id',$modPasienAdmisi->pasienadmisi_id,array('readonly'=>true)); ?>
            <?php echo Chtml::textField('kelaspelayanan_id',$kelaspelayanan_id,array('readonly'=>true)); ?>
            <?php echo Chtml::textField('carabayar_id',$carabayar_id,array('readonly'=>true)); ?>
            <?php echo Chtml::textField('penjamin_id',$penjamin_id,array('readonly'=>true)); ?>
            <?php echo Chtml::textField('instalasi_id',$instalasi_id,array('readonly'=>true)); ?>
            <?php echo Chtml::textField('ruangan_id',$ruangan_id,array('readonly'=>true)); ?>
        </div>
        <div class="span12">
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
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
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Hapus</th>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan=7>Data tidak ditemukan</td></tr>
                                    </tbody>
                                </table>',
                            'active'=>true,
                        ),   
                    ),
            )); ?>
        </div>
    </div>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formObatAlkesPasien',array('modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>BMHP</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Obat / Alat Kesehatan</th>
                    <th>Satuan Kecil</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($dataOas) > 0){
                    foreach($dataOas AS $i=>$modObatAlkesPasien){
                        echo $this->renderPartial($this->path_view.'_rowObatAlkesPasien',array('modObatAlkesPasien'=>$modObatAlkesPasien));
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
        
        
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                    echo "&nbsp;";
                     if(!isset($_GET['frame'])){
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), "javascript:void(0);", 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'refreshHalaman();'));
                        echo "&nbsp;";
                    }
                    if(!isset($_GET['sukses'])){
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                        echo "&nbsp;";
                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print(".$modPendaftaran->pendaftaran_id.");return false"));
                        echo "&nbsp;";
                    }


                    $content = $this->renderPartial($this->path_view.'tips/tipsPemakaianBmhp',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
