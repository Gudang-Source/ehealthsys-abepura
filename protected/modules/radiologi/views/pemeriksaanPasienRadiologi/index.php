
<div class="white-container">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <legend class="rim2">Pemeriksaan <b>Pasien Radiologi</b></legend>
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
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
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
                    <div id="form-masukpenunjang">
                            <?php echo $this->renderPartial('_formUbahMasukPenunjang',array('form'=>$form,'modPasienMasukPenunjang'=>$modPasienMasukPenunjang)); ?>
                    </div>
                </fieldset>
                <div class="block-tabel">
                    <h6>Tabel <b>Pemeriksaan</b></h6>
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
            </div>
        </div>
        <div class="form-actions">
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                echo "&nbsp;";
                if(!isset($_GET['frame'])){
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
                    echo "&nbsp;";
                }

                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printStatus();return false"));
                echo "&nbsp;";
                $content = $this->renderPartial('tips/tipsPemeriksaanPasienRadiologi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial('_jsFunctions', array('modKunjungan'=>$modKunjungan, 'modTindakan'=>$modTindakan)); ?>
</div>