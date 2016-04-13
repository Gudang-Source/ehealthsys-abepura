<div class="white-container">
    <legend class="rim2">Transaksi <b>Pemakaian Bahan</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
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
        <div class="row-fluid">
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'riwayat-obatalkespasien-t',
                    'content'=>array(
                        'content-riwayat-obatalkespasien-t'=>array(
                            'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk menampilkan obat alkes pasien')).'<b> Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                            'isi'=>'
                                <table class="table table-condensed">
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
            )); ?>
        </div>
        <fieldset class="box" id="form-tambahobatalkes">
            <legend class='rim'>Obat dan Alat Kesehatan</legend>
            <div class="row-fluid">
                <?php $this->renderPartial($this->path_view.'_formObatAlkesPasien',array('modKunjungan'=>$modKunjungan)); ?>
            </div>
        </fieldset>
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


        <div class="row-fluid">
            <div class="form-actions">
                    <?php 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                        echo '&nbsp;&nbsp;';
                        if(!isset($_GET['frame'])){
                            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                            echo '&nbsp;&nbsp;';
                        }
                        if($modKunjungan->isNewRecord){
                            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                            echo '&nbsp;&nbsp;';
                        }else{
                            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print(".$modKunjungan->pendaftaran_id.");return false"));
                            echo '&nbsp;&nbsp;';
                        }


                        $content = $this->renderPartial($this->path_view.'tips/tipsPemakaianBahan',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                    ?> 
            </div>
        </div>
    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'modObatAlkesPasien'=>$modObatAlkesPasien)); ?>
</div>