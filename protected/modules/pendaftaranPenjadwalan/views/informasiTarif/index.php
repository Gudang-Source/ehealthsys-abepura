<div class="white-container">
    <legend class="rim2">Informasi <b>Tarif Pelayanan</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Tarif Pelayanan</b></h6>
        <div class='table-responsive'>   
            <?php
            $this->widget('ext.bootstrap.widgets.BootGridView',
                array(
                    'id'=>'daftarTindakan-grid',
                    'dataProvider'=>$modTarifTindakanRuanganV->searchInformasi(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(                        
                        'jenistarif_nama',
                        /*array(
                            'header'=>'Instalasi / Ruangan ',
                            'type'=>'raw',
                            'value'=>'$data->InstalasiRuangan',
                        ),*/
                        array(
                            'header'=>'Instalasi',
                            'type'=>'raw',
                            'value'=>'$data->instalasi_nama',
                        ),
                        array(
                            'header'=>'Ruangan ',
                            'type'=>'raw',
                            'value'=>'$data->ruangan_nama',
                        ),
                        'kelompoktindakan_nama',
                        'komponenunit_nama',
                        'kategoritindakan_nama',
                        array(
                            'header'=>'Kelas Pelayanan',
                            'value'=>'$data->kelaspelayanan_nama',
                            'filter'=>false,
                        ),
                        'daftartindakan_nama',                        
                        array(
                            'name'=>'tarifTotal',
                            'htmlOptions'=>array('style'=>'text-align: right;'),
                            'value'=>'$this->grid->getOwner()->renderPartial(\'_tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                        ),
                        array(
                            'header'=>'Cyto <br> Tindakan (%)',
                            'htmlOptions'=>array('style'=>'text-align: right;'),
                            'value'=>'$data->persencyto_tind',
                        ),
                        array(
                            'header'=>'Diskon <br> Tindakan (%)',
                            'htmlOptions'=>array('style'=>'text-align: right;'),
                            'value'=>'$data->persendiskon_tind',
                        ),
                        array(
                            'name'=>'Komponen<br />Tarif',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align: left; width: 60px;'),
                            'value'=>'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id, "jenistarif_id"=>$data->jenistarif_id)) ,array("title"=>"Klik Untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))'
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )
            );

            ?>
        </div>
    </div>
    <?php
    // ===========================Dialog Details Tarif=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
        'id'=>'dialogDetailsTarif',
        'options'=>
            array(
                'title'=>'Komponen Tarif',
                'autoOpen'=>false,
                'width'=>480,
                'height'=>400,
                'resizable'=>false,
            ),
        )
    );
    ?>
    <iframe src="" name="iframe" width="100%" height="100%"></iframe>
    <?php
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Details Tarif================================


    Yii::app()->clientScript->registerScript('search', "

    $('#formCari').submit(function(){
            $.fn.yiiGridView.update('daftarTindakan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    ?>
    <fieldset class="box search-form">
        <legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend> 
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'formCari',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($modTarifTindakanRuanganV,'daftartindakan_nama'),
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
            )
        );
        ?>
        <div class="row-fluid">
            <div class="span4">
                 <?php 
                        echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif'=>true),array('order'=>'jenistarif_nama ASC')), 'jenistarif_id', 'jenistarif_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3')); 
                ?>
                <?php
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'instalasi_id',
                        CHtml::listData($modTarifTindakanRuanganV->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'),
                        array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3', 
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>$this->createUrl('ruanganDariInstalasi',array('encode'=>false,'namaModel'=>'PPTarifTindakanPerdaRuanganV')),
                                'update'=>'#PPTarifTindakanPerdaRuanganV_ruangan_id'
                            )
                        )
                    );
                ?>
               <?php
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'ruangan_id',
                        CHtml::listData($modTarifTindakanRuanganV->getRuanganItems($modTarifTindakanRuanganV->instalasi_id), 'ruangan_id', 'ruangan_nama'),
                        array(
                            'class'=>'span3', 
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'empty'=>'-- Pilih --'
                        )
                    );
                ?>
            </div>
            <div class="span4">
                <?php
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'kelompoktindakan_nama',
                        CHtml::listData($modTarifTindakanRuanganV->getKelompokTindakanItems(), 'kelompoktindakan_nama', 'kelompoktindakan_nama'),
                        array(
                            'class'=>'span3', 
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'empty'=>'-- Pilih --'
                        )
                    );
                ?>
                <?php
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'komponenunit_nama',
                        CHtml::listData($modTarifTindakanRuanganV->getKomponenUnitItems(), 'komponenunit_nama', 'komponenunit_nama'),
                        array(
                            'class'=>'span3', 
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'empty'=>'-- Pilih --'
                        )
                    );
                ?>
                 <?php
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'kategoritindakan_id',
                        CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'),
                        array(
                            'class'=>'span3', 
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'empty'=>'-- Pilih --'
                        )
                    );
                ?>
               
            </div>
            <div class="span4">               
                  <?php
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'kelaspelayanan_id',  
                        CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                        array(
                            'class'=>'span3', 
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'empty'=>'-- Pilih --'
                        )
                    );
                ?>               
                <?php
                    echo $form->textFieldRow($modTarifTindakanRuanganV,'daftartindakan_nama',
                        array(
                            'class'=>'span3',
                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                            'maxlength'=>30
                        )
                    );
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit'));
            ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                        $this->createUrl($this->id.'/index'), 
                                        array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
            <?php 
                $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiTarifPelayanan',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </fieldset>
</div>