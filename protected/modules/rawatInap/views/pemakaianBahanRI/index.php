<div class="white-container">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <legend class="rim2">Pemakaian <b>Bahan</b></legend>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data pemakaian Bahan berhasil disimpan !");
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
    
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <div class="fluid">
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
                                    <th hidden>Satuan Kecil</th>
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
        )); ?>
    </div>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formObatAlkesPasien',array('modKunjungan'=>$modKunjungan)); ?>
        </div>
        <div class="block-tabel">
            <h6>Tabel <b>Bahan</b></h6>
            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Obat / Alat Kesehatan</th>
                        <th hidden>Satuan Kecil</th>
                        <th hidden>Stok</th>
                        <th>Jumlah</th>
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
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                    echo '&nbsp;';
                    if(!isset($_GET['frame'])){
                       echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->module->id.'/index'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
                       echo '&nbsp;';
                    }
                    if($modKunjungan->isNewRecord){
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                        echo '&nbsp;';
                    }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print(".$modKunjungan->pasienadmisi_id.");return false"));
                        echo '&nbsp;';
                    }


                    $content = $this->renderPartial('laboratorium.views.pemakaianBahan.tips.tipsPemakaianBahan',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
</div>
