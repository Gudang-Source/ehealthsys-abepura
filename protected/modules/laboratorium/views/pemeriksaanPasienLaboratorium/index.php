<div class="white-container">
    <legend class="rim2">Pemeriksaan <b>Pasien Laboratorium</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pemeriksaanlaboratorium-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#no_pendaftaran',
    ));
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pemeriksaan pasien laboratorium berhasil disimpan !");
        $this->widget('bootstrap.widgets.BootAlert');
    }
    ?>
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
        </div>
    </fieldset>
    <fieldset class="box">
        <div class="row-fluid">
            <div class="span8">
                <fieldset id='content-pemeriksaan-lab' class='box2'>
                    <legend class="rim">Daftar Pemeriksaan Laboratorium</legend>
                    <?php
                    $this->renderPartial($this->path_view_pendaftaran . '_formCariPemeriksaan', array(
                        'modPemeriksaanLab' => $modPemeriksaanLab,
                    ));
                    ?>
                    <div class='checklists'></div>
                </fieldset>
            </div>
            <div class="span4">
                <fieldset class="box2">
                    <legend class="rim">Data Kunjungan Laboratorium</legend>
                    <div id="form-masukpenunjang">
                        <?php echo $this->renderPartial('_formUbahMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
                    </div>
                </fieldset>
                <fieldset class="box2">
                    <legend class="rim">Tabel Pemeriksaan</legend>
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
                </fieldset>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
                echo "&nbsp;";
                if (!isset($_GET['frame'])) {
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                    echo "&nbsp;";
                }

                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
                echo "&nbsp;";

                $content = $this->renderPartial('tips/tipsPemeriksaanPasienLaboratorium', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?> 
            </div>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan)); ?>
</div>