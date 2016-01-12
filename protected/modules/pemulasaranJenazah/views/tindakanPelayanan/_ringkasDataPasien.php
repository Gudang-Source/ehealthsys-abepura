<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<fieldset class="box">
    <legend class="rim">Data Pasien</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td>
                <?php 
                    if(!empty($readOnlyNoRm))
                        echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); 
                    else {
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasien,
                            'attribute' => 'no_rekam_medik',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienJenazah'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);

                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                          $("#' . CHtml::activeId($modPendaftaran, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                          $("#' . CHtml::activeId($modPendaftaran, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);
                                          $("#' . CHtml::activeId($modPendaftaran, 'umur') . '").val(ui.item.umur);
                                          $("#' . CHtml::activeId($modPendaftaran, 'jeniskasuspenyakit_id') . '").val(ui.item.jeniskasuspenyakit_nama);
                                          $("#' . CHtml::activeId($modPendaftaran, 'kelaspelayanan_id') . '").val(ui.item.kelaspelayanan_id);
                                          $("#' . CHtml::activeId($modPendaftaran, 'carabayar_id') . '").val(ui.item.carabayar_id);
                                          $("#' . CHtml::activeId($modPendaftaran, 'kelompokumur_id') . '").val(ui.item.kelompokumur_id);
                                          $("#' . CHtml::activeId($modPendaftaran, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);
                                          $("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val(ui.item.nama_pasien);
                                          $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);
                                          $("#' . CHtml::activeId($modPasien, 'nama_bin') . '").val(ui.item.nama_bin);
                                      }',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                                'htmlOptions'=>array(
                                    'class'=>'span2',
                                    'placeholder'=>'Ketikan No. Rekam Medis',
                                ),
                        ));
                    }
                ?>
            </td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasien->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'photo pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td>
                <?php 
                    if(!empty($modPendaftaran->jeniskasuspenyakit_id)) 
                        echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); 
                    else
                        echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_id',array('readonly'=>true));
                    ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>

<?php
//========= Dialog buat cari data Pasien=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPasien = new PasienmasukpenunjangV('searchJenazah');
$modPasien->unsetAttributes();
if (isset($_GET['PasienmasukpenunjangV'])) {
    $modPasien->attributes = $_GET['PasienmasukpenunjangV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPasien->searchJenazah(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#PasienM_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                                          $(\"#PasienM_jeniskelamin\").val(\"$data->jeniskelamin\");
                                                          $(\"#PasienM_nama_pasien\").val(\"$data->nama_pasien\");
                                                          $(\"#PasienM_nama_bin\").val(\"$data->nama_bin\");
                                                          $(\"#PendaftaranT_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                                          $(\"#PendaftaranT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                                          $(\"#PendaftaranT_jeniskasuspenyakit_id\").val(\"$data->jeniskasuspenyakit_nama\");
                                                          $(\"#PendaftaranT_umur\").val(\"$data->umur\");
                                                          $(\"#PendaftaranT_penjamin_id\").val(\"$data->carabayar_id\");
                                                          $(\"#PendaftaranT_carabayar_id\").val(\"$data->carabayar_id\");
                                                          $(\"#PendaftaranT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id\");
                                                          $(\"#PendaftaranT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                                          $(\"#pasienmasukpenunjang_id\").val(\"$data->pasienmasukpenunjang_id\");
                                                          $(\"#dialogPasien\").dialog(\"close\");    
                                                          
                                                "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',
       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Dialog Pasien =============================
?>