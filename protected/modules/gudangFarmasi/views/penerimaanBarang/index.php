<div class="white-container">
    <legend class="rim2">Penerimaan Obat dan Alat <b>Kesehatan Dari Supplier</b></legend>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data Penerimaan Obat dan Alat Kesehatan Dari Supplier berhasil disimpan !");
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penerimaanbarang-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
    )); ?>
    
    <fieldset class="box" id="form-rencanakebutuhan">
        <legend class="rim"><span class='judul'>Data Penerimaan </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_formPenerimaanBarang', array('form'=>$form,'format'=>$format,'modPenerimaanBarang'=>$modPenerimaanBarang,'modUangMuka'=>$modUangMuka)); ?>
        </div>
    </fieldset>

    
    <?php  if(!isset($_GET['sukses'])){ ?>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formObatPenerimaanBarang',array('modPenerimaanBarang'=>$modPenerimaanBarang,'modPermintaanPembelian'=>$modPermintaanPembelian)); ?>
        </div>
        <?php } ?>
        <div class="block-tabel">
            <h6>Tabel Penerimaan Obat <b>dan Alat Kesehatan</b></h6>
            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Asal Barang</th>
                        <th>Kategori / Nama Obat</th>
                        <th>No. Batch</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Satuan</th>
                        <th hidden>Jumlah Pesan</th>
                        <th>Jumlah Terima</th>
                        <th>Harga Satuan</th>
                        <th>Diskon (%)</th>
                        <th>Diskon Total (Rp.)</th>
                        <th>Sub Total</th>
                        <th>Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(count($modDetails) > 0){
                        foreach($modDetails AS $i=>$modPenerimaanBarangDetail){
                                                    $modStokObatAlkes = StokobatalkesT::model()->findByAttributes(array('penerimaandetail_id'=>$modPenerimaanBarangDetail->penerimaandetail_id));
                                                    $modPenerimaanBarangDetail->nobatch = isset($modStokObatAlkes->nobatch) ? $modStokObatAlkes->nobatch : "";
                            echo $this->renderPartial($this->path_view.'_rowObatPenerimaanBarang',array('modPenerimaanBarangDetail'=>$modPenerimaanBarangDetail,'modPenerimaanBarang'=>$modPenerimaanBarang,'format'=>$format));
                        }
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <td colspan="10">Total</td>
                            <td><?php echo CHtml::textField('total','',array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true))?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </tbody>
            </table>
        </div>
    </fieldset>
    <div class="box row-fluid">
            <div class = "span8">
                    <?php echo $form->hiddenField($modPenerimaanBarang,'is_langsungfaktur', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'form-fakturpembelian',
                                    'content'=>array(
                                            'content-fakturpembelian'=>array(
                                                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk faktur pembelian langsung')).'<b> Terima Langsung Faktur</b>',
                                                    'isi'=>$this->renderPartial($this->path_view.'_formFakturPembelian',array(
                                                                    'form'=>$form,
                                                                    'modFakturPembelian'=>$modFakturPembelian,
                                                                    'modPenerimaanBarang'=>$modPenerimaanBarang,
                                                                    ),true),
                                                    'active'=>false,
                                            ),   
                                    ),
                    )); ?>
            </div>
            <div class="span4">
                    <?php echo $form->hiddenField($modPenerimaanBarang,'is_uangmuka', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'form-uangmuka',
                                    'content'=>array(
                                            'content-uangmuka'=>array(
                                                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk uang muka')).'<b> Uang Muka via Bank</b>',
                                                    'isi'=>$this->renderPartial($this->path_view.'_formUangMuka',array(
                                                                    'form'=>$form,
                                                                    'modUangMuka'=>$modUangMuka,
                                                                    'modPenerimaanBarang'=>$modPenerimaanBarang,
                                                                    ),true),
                                                    'active'=>false,
                                            ),   
                                    ),
                    )); ?>
            </div>
    </div>
    <div class="row-fluid">
        <div class="form-actions">
            <?php 
                if($modPenerimaanBarang->isNewRecord){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
                    echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>true)); 
                    echo "&nbsp;";
                }


                if(!isset($_GET['frame'])){
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'return refreshForm(this);'));
                    echo "&nbsp;";
                }
                if($modPenerimaanBarang->isNewRecord){
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4046*/
                    echo "&nbsp;";
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
//                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4046*/
                    echo "&nbsp;";
                }


                $content = $this->renderPartial($this->path_view.'tips/tipsPenerimaanBarang',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenerimaanBarang'=>$modPenerimaanBarang,'modFakturPembelian'=>$modFakturPembelian,'modUangMuka'=>$modUangMuka,'modPermintaanPembelian'=>$modPermintaanPembelian,'modUangMuka'=>$modUangMuka)); ?>
