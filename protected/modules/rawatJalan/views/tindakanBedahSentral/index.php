<div class="white-container">
    <legend class="rim2">Transaksi Tindakan <b>Bedah Sentral</b></legend>
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
        <legend class="rim"><span class='judul'>Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Daftar Tindakan Operasi</legend>
        <div id='content-pemeriksaan-bedah'>
                <?php $this->renderPartial($this->path_view.'_formCariPemeriksaan',array('modPemeriksaanBedah'=>$modPemeriksaanBedah,)); ?>
                <div class='checklists'></div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <fieldset class="box2">
                    <legend class="rim">Data Pasien Bedah Sentral</legend>
                    <?php echo $this->renderPartial($this->path_view.'_formRencanaOperasi',array('form'=>$form,'modTindakan'=>$modTindakan, 'modTindakanDetail'=>$modTindakanDetail)); ?>
                </fieldset>        
            </div>
            <div class="span6">
                <fieldset class="box2">
                    <legend class="rim">Data Kunjungan Bedah Sentral</legend>
                    <?php echo $this->renderPartial($this->path_view.'_formMasukPenunjang',array('form'=>$form,'modPendaftaran'=>$modPendaftaran,'modTindakan'=>$modTindakan)); ?>
                </fieldset>
            </div>
            <div class="span6">
                <!--RSN-469-->
                <?php if(!isset($_GET['sukses'])){ ?>
                <!--<legend class="rim">Tabel Permintaan Ke Penunjang</legend>-->
                <div id="form-permintaankepenunjang" style="overflow-x: scroll;" hidden="">
                        <table class="table table-condensed table-bordered">
                                <thead>
                                        <th>No.</th>
                                        <th width="90%">Nama Pemeriksaan Permintaan</th>
                                </thead>
                                <tbody>
                                </tbody>
                        </table>
                </div>
                <?php } ?>
                <div class="block-tabel">
                    <h6>Tabel Tindakan <b>Operasi Pasien</b><?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-arrow-down icon-white"></i>')),array('class'=>'btn btn-mini btn-primary', 'type'=>'button',"onclick"=>"setCheckedPemeriksaanDariPermintaan();", 'rel'=>'tooltip', 'title'=>'Klik untuk menyalin dari tabel permintaan')); ?></h6>
                    <div id="form-tindakanpemeriksaan" style="overflow-x: scroll;">
                        <table class="table table-condensed table-bordered table-striped" id="tbl-tindakanoperasi">
                            <thead>
                                <th>No.</th>
                                <th>Nama Tindakan Operasi</th>
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
        <div class="row-fluid">
            <table width="100%">
                <tr>
                    <td width="50%">
                            <?php $this->renderPartial($this->path_view.'_formPemakaianBahan',array()); ?>
                    </td>
                    <td width="50%">
                            <?php $this->renderPartial($this->path_view.'_formPaketBmhp',array('modViewBmhp'=>$modViewBmhp, 'modTindakan'=>$modTindakan)); ?>
                    </td>
                </tr>
            </table>
        </div>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
            <?php 
                if(!isset($_GET['sukses'])){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);'));
                        echo '&nbsp;&nbsp;';
                }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                }
                        echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
                                        'onclick'=>'return refreshForm(this);'));
                        echo '&nbsp;&nbsp;';
                $content = $this->renderPartial($this->path_view.'tips/tipsPendaftaranBedahSentralRujukanRS',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan, 'modPendaftaran'=>$modPendaftaran,'modTindakan'=>$modTindakan,'modTindakanDetail'=>$modTindakanDetail)); ?>
</div>