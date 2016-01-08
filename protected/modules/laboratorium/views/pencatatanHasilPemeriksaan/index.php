<div class="white-container">
    <legend class="rim2">Pencatatan Hasil <b>Pemeriksaan Laboratorium</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pemeriksaanlaboratorium-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#no_pendaftaran',
    )); ?>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success', "Data hasil pemeriksaan laboratorium berhasil disimpan !");
        }
    ?>
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <fieldset>
        <div class="row-fluid">
        <div class="span4">
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                'id'=>'riwayat-anamnesa',
                'content'=>array(
                    'content-riwayat-anamnesa'=>array(
                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat anamnesa')).'<b> Riwayat Anamnesa</b>',
                        'isi'=>'<div class="content"></div>',
                        'active'=>false,
                        ),   
                    ),
                    )); ?>  
        </div>
        <div class="span4">
            <?php 
                $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                'id'=>'riwayat-pemeriksaan-fisik',
                'content'=>array(
                    'content-riwayat-pemeriksaan-fisik'=>array(
                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pemeriksaan fisik')).'<b> Riwayat Pemeriksaan Fisik</b>',
                        'isi'=>'<div class="content"></div>',
                        'active'=>false,
                        ),   
                    ),
                    )); 
            ?>  
        </div>
        <div class="span4">
            <?php 
                $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                'id'=>'riwayat-diagnosa',
                'content'=>array(
                    'content-riwayat-diagnosa'=>array(
                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat diagnosa')).'<b> Riwayat Diagnosa</b>',
                        'isi'=>'<div class="content"></div>',
                        'active'=>false,
                        ),   
                    ),
                    )); 
            ?>  
        </div>
    </div>
    </fieldset>
    <fieldset>
        <div class="row-fluid">
            <div class="span12">
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-tindakanpemeriksaan',
                        'content'=>array(
                            'content-tindakan'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan tindakan pemeriksaan laboratorium')).'<b> Tabel Pemeriksaan</b>',
                                'isi'=>'
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                            <th>No.</th>
                                            <th>Nama Pemeriksaan</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Tarif</th>
                                            <th>Total</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>',
                                'active'=>false,
                            ),   
                        ),
                )); ?>
            </div>
        </div>
        <?php
        if($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
            echo $this->renderPartial('_formHasilPemeriksaan',array('form'=>$form,'modHasilPemeriksaan'=>$modHasilPemeriksaan));
        }else if ($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI){
            echo $this->renderPartial('_formHasilPemeriksaanPA',array('format'=>$format));
        }
        ?>
        
        <div class="row-fluid">
            <div class="form-actions">
                    <?php 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);'));
                        echo "&nbsp;";
                        if(!isset($_GET['frame'])){
                            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                            echo "&nbsp;";
                        }
                        
                        echo CHtml::link(Yii::t('mds', '{icon} Print Hasil', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printHasil();return false"));
                        echo "&nbsp;";

                        $content = $this->renderPartial('tips/tipsPencatatanHasilPemeriksaan',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                    ?> 
            </div>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan, 'modTindakan'=>$modTindakan, 'dariHasil'=>1)); ?>
    <?php $this->renderPartial('_jsFunctions', array('modKunjungan'=>$modKunjungan, 'modHasilPemeriksaan'=>$modHasilPemeriksaan, 'modTindakan'=>$modTindakan)); ?>
</div>