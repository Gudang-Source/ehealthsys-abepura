<div class="white-container">
    <legend class="rim2">Penjualan <b>Resep Umum</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfmutasioaruangan Ts'=>array('index'),
            'Create',
    );
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penjualanresep-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#FAPendaftaranT_instalasi_id',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    ));?>
    <?php
    if(isset($_GET['sukses'])){
        if($_GET['sukses'] == 1){
            Yii::app()->user->setFlash("success","Tansaksi Penjualan Resep Umum berhasil disimpan!");
        }
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <fieldset id="form-antrian">
        <div class="control-group">
            <?php echo CHtml::label('No. Antrian','noantrian',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->hiddenField($modPenjualan,'antrianfarmasi_id',array('class'=>'antrianfarmasiId'));?>
                <?php echo CHtml::textField('racikan_singkatan',((empty($modAntrian->racikan_id) ? "" : $modAntrian->racikan->racikan_singkatan)),array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;float: left;', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="span3" style="float: left;">
                <?php
                    $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modAntrian,
                                'attribute'=>'noantrian',
                                'tombolDialog'=>array('idDialog'=>'dialog-pilihantrian'),
                                'htmlOptions'=>array('value'=>$modAntrian->noantrian,
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() === "") {$('.CHtml::activeId($modPenjualan, 'antrianfarmasi_id').').val(""); $("#racikan_singkatan").val("");}',
                                    'placeholder'=>'Klik icon =>'
                                    )
                            ));
                ?>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset id="form-infodokter">
        <!--<legend class="rim"><span class='judul'>Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setInfoDokterReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>-->
        <div class="row-fluid">
            <div class = "span12">
                <?php echo $form->hiddenField($modPenjualan,'is_pasien', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-pasien',
                        'content'=>array(
                            'content-pasien'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengisi data pasien')).'<b> Data Pasien</b>',
                                'isi'=>$this->renderPartial($this->path_view_umum.'_formDataPasien',array(
                                        'form'=>$form,
                                        'modPenjualan'=>$modPenjualan,
                                        'modPasien'=>$modPasien,
                                        ),true),
                                'active'=>$modPenjualan->is_pasien,
                            ),   
                        ),
                )); ?>
            </div>
        </div>
    </fieldset>
    <div class="row-fluid">
        <div class="span8">
            <fieldset class="box" id="form-dataresep">
                <legend class="rim">Data Resep</legend>
                <?php $this->renderPartial($this->path_view_umum.'_formDataResep', array('form'=>$form,'modPenjualan'=>$modPenjualan,'modReseptur'=>$modReseptur)); ?>
            </fieldset>
        </div>
        <div class="span4">
            <?php 
                if(!isset($_GET['sukses'])){ //RND-5894
                        $this->renderPartial($this->path_view.'_formInputObat', array('form'=>$form,'racikan'=>$racikan, 'racikanDetail'=>$racikanDetail,'nonRacikan'=>$nonRacikan)); 
                }	
            ?>
        </div>
    </div>
    <div class="block-tabel">
        <h6>Tabel <b>Obat Alkes</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <th>Resep</th>
                    <th>R ke</th>
                    <th>Kode / Nama Obat</th>
                    <th>Sumber Dana</th>
                    <!--th>Satuan Kecil</th-->
                    <th>Jumlah</th>
                    <!--th>Stok</th-->
                    <th>Harga</th>
                    <!--<th>Discount (%)</th>-->
                    <th>Sub Total</th>
                    <th>Signa</th>
                    <th>Etiket</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modObatAlkesPasien) > 0){
                    foreach($modObatAlkesPasien AS $i=> $modDetail){
                        $modDetail->jmlstok = StokobatalkesT::getJumlahStokOaTersimpan($modDetail->obatalkespasien_id);
                        echo $this->renderPartial($this->path_view.'_rowDetail',array('modObatAlkesPasien'=> $modDetail));
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <?php echo $form->hiddenField($modPenjualan, 'totharganetto',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'totaltarifservice',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'biayaadministrasi',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'biayakonseling',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'pembulatanharga',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'jasadokterresep',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'discount',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'subsidiasuransi',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'subsidipemerintah',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'subsidirs',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'iurbiaya',array('class'=>'integer', 'readonly'=>'true')); ?>
        </div>
            <div class="span4"><?php echo $form->dropDownListRow($modPenjualan, 'takaranresep',LookupM::getItems('takaranresep'),array('class'=>'span1','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'ubahTakaranResep(this);')); ?></div>
        <div class="span4"><?php echo $form->textFieldRow($modPenjualan, 'totalhargajual',array('class'=>'integer', 'readonly'=>'true')); ?></div>
    </div>
    <div class="form-actions">
            <?php 
                $disableSave = false;
                $disableSave = (!empty($_GET['penjualanresep_id'])) ? true : ($sukses > 0) ? true : false;; 
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();','disabled'=>$disableSave)); //formSubmit(this,event)        
                //  jika tanpa cek obat
                /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                 * 
                 */
                 ?>
            <?php if(!isset($_GET['frame'])){
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
            } ?>								
            <?php
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            ?>
            <?php
                $content = $this->renderPartial('tips/tipsPenjualanResepUmum',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-pilihantrian',
        'options'=>array(
            'title'=>'Daftar Antrian',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>900,
            'minHeight'=>400,
            'resizable'=>false,
        ),
    ));
    ?>
    <div class="dialog-content">
        <?php 
            if(!isset($_GET['sukses'])){ //RND-5894
            $modKarcisTerakhir = new FAAntrianFarmasiT('search');
            $modKarcisTerakhir->unsetAttributes();
            if(isset($_GET['FAAntrianFarmasiT'])){
                $modKarcisTerakhir->attributes = $_GET['FAAntrianFarmasiT'];
            }
            $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'anantrianfarmasi-t-grid',
                'dataProvider'=>$modKarcisTerakhir->searchDialogKarcis(),
                'filter'=>$modKarcisTerakhir,
                'template'=>"{summary}\n{pager}\n{items}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Karcis","class"=>"btn_small",
                            "id"=>"pilihkarcis",
                            "onClick"=>"$(\"#'.CHtml::activeId($modPenjualan,'antrianfarmasi_id').'\").val(\"$data->antrianfarmasi_id\");
                                        $(\"#'.CHtml::activeId($modAntrian,'noantrian').'\").val(\"$data->noantrian\");
                                        $(\"#racikan_singkatan\").val(\"$data->RacikanSingkatan\");
                                        $(\"#dialog-pilihantrian\").dialog(\"close\");
                                        return false;"
                            ))'
                    ),

                    array(
                        'name'=>'tglambilantrian',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglambilantrian)',
                        'filter'=>false,
                    ),
                    array(
                        'name'=>'racikan_id',
                        'type'=>'raw',
                        'value'=>'$data->racikan->racikan_nama." (".$data->racikan->racikan_singkatan.")"',
                        'filter'=>$modKarcisTerakhir->getListRacikans(),
                    ),
                    'noantrian',
                    array(
                        'name'=>'panggilantrian',
                        'filter'=> array(1=>'Sudah',0=>'Belum'),
                        'type'=>'raw',
                        'value'=>'($data->panggilantrian) ? "Sudah" : "Belum"',
                    ),
                    array(
                        'name'=>'antrianlewat',
                        'filter'=> array(1=>'Ya',0=>'Tidak'),
                        'type'=>'raw',
                        'value'=>'($data->antrianlewat) ? "Ya" : "Tidak"',
                    ),
                    array(
                        'header'=>'Print Karcis',
                        'filter'=> false,
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-print\"></i>","javascript:void(0);",
                                array(
                                      "onclick"=>"printKarcisFarmasi($data->antrianfarmasi_id,\"PRINT\")",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk Membatalkan Pembayaran",
                                ))',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: center;'
                                )
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    )); 
            }
                    ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenjualan'=>$modPenjualan,'modReseptur'=>$modReseptur)); ?>
    <?php $this->renderPartial($this->path_view_umum.'_jsFunctions', array('modPenjualan'=>$modPenjualan,'modReseptur'=>$modReseptur,'modPasien'=>$modPasien)); ?>
</div>