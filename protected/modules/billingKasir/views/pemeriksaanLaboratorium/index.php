<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pemeriksaanlaboratorium-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#no_pendaftaran',
)); ?>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
'id'=>'table-riwayattindakan',
'content'=>array(
    'content-riwayattindakan'=>array(
        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat tindakan')).'<b> Riwayat Tindakan</b>',
        'isi'=>$this->renderPartial($this->path_view.'_tableRiwayatTindakan',array(
                'format'=>$format,
                'modRiwayatTindakans'=>$modRiwayatTindakans,
                'modPendaftaran'=>$modPendaftaran
                ),true),
        'active'=>true,
        ),   
    ),
)); ?>
<div class="box">
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien laboratorium berhasil disimpan !");
        }
    ?>
    
    <div class="row-fluid">        
        <div class="span8">
            <fieldset class="box2">
                <legend class="rim">Daftar Pemeriksaan Laboratorium</legend>
                <div id='content-pemeriksaan-lab'>
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
                    <?php 
                        $this->renderPartial($this->path_view.'_formCariPemeriksaan',array(
                                            'modPemeriksaanLab'=>$modPemeriksaanLab,                                        
                                            )); ?>
                    <div class='checklists'></div>
                </div>
            </fieldset>
        </div>
        <div class="span4">
            <fieldset class="box2">
                <legend class="rim">Data Kunjungan Laboratorium</legend>
                <?php echo $this->renderPartial('_formMasukPenunjang',array('form'=>$form,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang)); ?>
            </fieldset>
            <div class="block-tabel">
                <h6>Tabel <b>Pemeriksaan</b></h6>
                <div id="form-tindakanpemeriksaan" style="overflow-x: scroll;">
                    <table class="table table-condensed table-striped" id="tabelpemeriksaanlab">
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
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan, 'modPendaftaran'=>$modPendaftaran, 'modPasienAdmisi'=>$modPasienAdmisi, 'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,'modTindakan'=>$modTindakan)); ?>
</div>
<div class="row-fluid">
        <div class="form-actions">
            <?php 
                if(!$modPasienMasukPenunjang->pasienmasukpenunjang_id){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                    echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                    echo "&nbsp;";
                }
                if(!isset($_GET['frame'])){
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), "javascript:void(0);", 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'refreshHalaman();'));
                    echo "&nbsp;";
                }
                if(!isset($_GET['sukses'])){
                    echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled'=>true,'class'=>'btn btn-info','onclick'=>"return false"));
                    echo "&nbsp;";
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printStatus();return false"));
                    echo "&nbsp;";
                }
                $content = $this->renderPartial('tips/tipsPemeriksaanLaboratorium',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </div>