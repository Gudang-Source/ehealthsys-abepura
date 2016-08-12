<div class="white-container">
    <legend class="rim2">Laporan Pasien <b>Sudah Bayar</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Pasien Sudah Bayar' => array('/billingKasir/Laporan/pasienSudahBayar'),
            'PasienKarcis',
    );?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('semua_pencarianpasien_grid', {
                data: $(this).serialize()
            });
            $.fn.yiiGridView.update('penjamin_pencarianpasien_grid', {
                data: $(this).serialize()
            });
            $.fn.yiiGridView.update('umum_pencarianpasien_grid', {
                data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <fieldset class="box form-actions">
        <?php echo $this->renderPartial('pasienSudahBayar/_formKriteriaPencarian', array('model'=>$model,'form'=>$form,'format'=>$format),true);  ?> 
        <div style="margin:6px;">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onClick'=>'onReset()')); ?>
        </div>
    </fieldset>
	<?php $this->endWidget(); ?>
    <div class="tab">
        <?php
            $this->widget('bootstrap.widgets.BootMenu',array(
                'type'=>'tabs',
                'stacked'=>false,
                'htmlOptions'=>array('id'=>'tabmenu'),
                'items'=>array(
                    array('label'=>'All','url'=>'javascript:tab(0);','active'=>true),
                    array('label'=>'P3','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                    array('label'=>'Umum','url'=>'javascript:tab(2);', 'itemOptions'=>array("index"=>2)),
                ),
            ))
        ?>
        <div class="biru" id="div_semua">
            <!--<legend class="rim">Tabel Pasien Sudah Bayar - Semua</legend>-->
            <div class="white">
                <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id'=>'semua_pencarianpasien_grid',
                        'dataProvider'=>$model->searchPasienSudahBayar(),
                        'template'=>"{summary}\n{items}\n{pager}",
                        'itemsCssClass'=>'table table-striped table-condensed',
                        'columns'=>array(
                        array(
                                'header'=>'Tanggal Bukti Bayar / <br/> No. Bukti Bayar',
                                'name'=>'tglbuktibayar',
                                'type'=>'raw',
                                'value'=>'(isset($data->tandabuktibayar->tglbuktibayar) ? MyFormatter::formatDateTimeForUser(date("Y-m-d H:i:s",strtotime($data->tandabuktibayar->tglbuktibayar))) : "")." / <br>".(isset($data->tandabuktibayar->nobuktibayar) ? $data->tandabuktibayar->nobuktibayar : "")',
                            ),
                            array(
                                'name'=>'instalasi',
                                'type'=>'raw',
                                'value'=>'(isset($data->pendaftaran->instalasi_id)?$data->pendaftaran->instalasi->instalasi_nama:"")',
                            ),
                            array(
                                'header'=>'No. Pendaftaran / No. Rekam Medik',
                                'value'=>'(isset($data->pendaftaran_id)?$data->pendaftaran->no_pendaftaran:"")." / ".(isset($data->pasien_id)?$data->pasien->no_rekam_medik:"")',
                            ),
                            array(
                                'name'=>'nama_pasien',
                                'type'=>'raw',
                                'value'=>'(isset($data->pasien_id)?$data->pasien->nama_pasien:"")." / ".$data->nama_bin',
                            ),
                            array(
                                'name'=>'alamat_pasien',
                                'type'=>'raw',
                                'value'=>'(isset($data->pasien_id)?$data->pasien->alamat_pasien:"")',
                            ),
                            array(
                                'header'=>'Cara Bayar | Penjamin',
                                'name'=>'carabayar_nama',
                                'type'=>'raw',
                                'value'=>'(isset($data->pendaftaran->carabayar_id)?$data->pendaftaran->carabayar->carabayar_nama:"")."<br>".(isset($data->pendaftaran->penjamin_id)?$data->pendaftaran->penjamin->penjamin_nama:"")',
                            ),
                            array(
                                'name'=>'total_tagihan',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalbiayapelayanan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                )
                            ),
                            array(
                                'header'=>'Subsidi Asuransi',
                                'name'=>'subsidi_asuransi',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalsubsidiasuransi,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                )
                            ),
                            array(
                                'header'=>'Subsidi Pemerintah',
                                'name'=>'subsidi_pemerintah',
                                'type'=>'raw',
                                'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->totalsubsidipemerintah)',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                )
                            ),
                            array(
                                'header'=>'Subsidi RS',
                                'name'=>'subsidi_rs',
                                'type'=>'raw',
                                'value'=>'number_format($data->totalsubsidirs,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                )
                            ),
                            array(
                                'header'=>'Biaya',
                                'name'=>'iur_biaya',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totaliurbiaya,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                )
                            ),
                            array(
                                'header'=>'Disc',
                                'name'=>'discount',
                                'type'=>'raw',
                                'value'=>'number_format($data->totaldiscount,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                )
                            ),
                            array(
                                'header'=>'Pembebasan',
                                'type'=>'raw',
                                'value'=>'number_format($data->totalpembebasan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Jumlah Pembayaran',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalbayartindakan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                )
                            ),
                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    ));
                ?>
            </div>
        </div>
        <div class="biru" id="div_penjamin">
            <!--<legend class="rim">Tabel Pasien Sudah Bayar - P3</legend>-->
            <div class="white" style="max-width:100%;overflow-x:auto">
                <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id'=>'penjamin_pencarianpasien_grid',
                        'dataProvider'=>$model->searchPasienBerdasarkanPenjamin(),
                        'template'=>"{summary}\n{items}\n{pager}",
                        'itemsCssClass'=>'table table-striped table-condensed',
                        'columns'=>array(
                            array(
                                'header'=>'Tanggal Bukti Bayar <br/> No. Bukti Bayar',
                                'name'=>'tglbuktibayar',
                                'type'=>'raw',
                                'value'=>'(isset($data->tandabuktibayar->tglbuktibayar) ? date("d/m/Y H:i:s",strtotime($data->tandabuktibayar->tglbuktibayar)) : "")."<br>".(isset($data->tandabuktibayar->nobuktibayar) ? $data->tandabuktibayar->nobuktibayar : "")',
                            ),
                            array(
                                'name'=>'instalasi',
                                'type'=>'raw',
                                'value'=>'(isset($data->pendaftaran->instalasi_id)?$data->pendaftaran->instalasi->instalasi_nama:"")',
                            ),
                            array(
                                'header'=>'No. Pendaftaran / No. Rekam Medik',
                                'value'=>'(isset($data->pendaftaran_id)?$data->pendaftaran->no_pendaftaran:"")." / ".(isset($data->pasien_id)?$data->pasien->no_rekam_medik:"")',
                            ),
                            array(
                                'name'=>'nama_pasien',
                                'type'=>'raw',
                                'value'=>'(isset($data->pasien_id)?$data->pasien->nama_pasien:"")." / ".$data->nama_bin',
                            ),
                            array(
                                'name'=>'alamat_pasien',
                                'type'=>'raw',
                                'value'=>'(isset($data->pasien_id)?$data->pasien->alamat_pasien:"")',
                            ),
                            array(
                                'header'=>'Cara Bayar | Penjamin',
                                'name'=>'carabayar_nama',
                                'type'=>'raw',
                                'value'=>'(isset($data->pendaftaran->carabayar_id)?$data->pendaftaran->carabayar->carabayar_nama:"")."<br>".(isset($data->pendaftaran->penjamin_id)?$data->pendaftaran->penjamin->penjamin_nama:"")',
                            ),
                            array(
                                'name'=>'total_tagihan',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalbiayapelayanan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Subsidi Asuransi',
                                'name'=>'subsidi_asuransi',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalsubsidiasuransi,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                 'header'=>'Subsidi Pemerintah',
                                 'name'=>'subsidi_pemerintah',
                                 'type'=>'raw',
                                 'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->totalsubsidipemerintah)',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Subsidi RS',
                                'name'=>'subsidi_rs',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalsubsidirs,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Biaya',
                                'name'=>'iur_biaya',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totaliurbiaya,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Disc',
                                'name'=>'discount',
                                'type'=>'raw',
                                'value'=>'number_format($data->totaldiscount,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Pembebasan',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalpembebasan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Jumlah Pembayaran',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalbayartindakan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    ));
                ?>
            </div>            
        </div>
        <div class="biru" id="div_umum">
            <!--<legend class="rim">Tabel Pasien Sudah Bayar - Umum</legend>-->
            <div class="white" style="max-width:100%;overflow-x:auto">
                <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id'=>'umum_pencarianpasien_grid',
                        'dataProvider'=>$model->searchPasienBerdasarkanUmum(),
                        'template'=>"{summary}\n{items}\n{pager}",
                        'itemsCssClass'=>'table table-striped table-condensed',
                        'columns'=>array(
                            array(
                                'header'=>'Tanggal Bukti Bayar <br/> No. Bukti Bayar',
                                'name'=>'tglbuktibayar',
                                'type'=>'raw',
                                'value'=>'(isset($data->tandabuktibayar->tglbuktibayar) ? date("d/m/Y H:i:s",strtotime($data->tandabuktibayar->tglbuktibayar)) : "")."<br>".(isset($data->tandabuktibayar->nobuktibayar) ? $data->tandabuktibayar->nobuktibayar : "")',
                            ),
                            array(
                                'name'=>'instalasi',
                                'type'=>'raw',
                                'value'=>'(isset($data->pendaftaran->instalasi_id)?$data->pendaftaran->instalasi->instalasi_nama:"")',
                            ),
                            array(
                                'header'=>'No. Pendaftaran / No. Rekam Medik',
                                'value'=>'(isset($data->pendaftaran_id)?$data->pendaftaran->no_pendaftaran:"")." / ".(isset($data->pasien_id)?$data->pasien->no_rekam_medik:"")',
                            ),
                            array(
                                'name'=>'nama_pasien',
                                'type'=>'raw',
                                'value'=>'(isset($data->pasien_id)?$data->pasien->nama_pasien:"")." / ".$data->nama_bin',
                            ),
                            array(
                                'name'=>'alamat_pasien',
                                'type'=>'raw',
                                'value'=>'(isset($data->pasien_id)?$data->pasien->alamat_pasien:"")',
                            ),
                            array(
                                'header'=>'Cara Bayar | Penjamin',
                                'name'=>'carabayar_nama',
                                'type'=>'raw',
                                'value'=>'(isset($data->pendaftaran->carabayar_id)?$data->pendaftaran->carabayar->carabayar_nama:"")."<br>".(isset($data->pendaftaran->penjamin_id)?$data->pendaftaran->penjamin->penjamin_nama:"")',
                            ),
                            array(
                                'name'=>'total_tagihan',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalbiayapelayanan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Subsidi Asuransi',
                                'name'=>'subsidi_asuransi',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalsubsidiasuransi,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                 'header'=>'Subsidi Pemerintah',
                                 'name'=>'subsidi_pemerintah',
                                 'type'=>'raw',
                                 'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->totalsubsidipemerintah)',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Subsidi RS',
                                'name'=>'subsidi_rs',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalsubsidirs,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Biaya',
                                'name'=>'iur_biaya',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totaliurbiaya,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Disc',
                                'name'=>'discount',
                                'type'=>'raw',
                                'value'=>'number_format($data->totaldiscount,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Pembebasan',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalpembebasan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                            array(
                                'header'=>'Jumlah Pembayaran',
                                'type'=>'raw',
                                'value'=>'"Rp".number_format($data->totalbayartindakan,0,"",".")',
                                'htmlOptions'=>array(
                                    'style'=>'text-align: right',
                                ),
                            ),
                        ),
                        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                    ));
                ?>
            </div>            
        </div>        
    </div>
    
    <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    //        $this->widget('bootstrap.widgets.BootButtonGroup', array(
    //            'type'=>'primary',
    //            'buttons'=>array(
    //                array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>$urlPrint, 'htmlOptions'=>array('onclick'=>'print(\'PRINT\');return false;')),
    //                array('label'=>'',
    //                    'items'=>array(
    //                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'PDF\');return false;')),
    //                        array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'EXCEL\');return false;')),
    //                    )
    //                ),
    //            ),
    //        ));

        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','url'=>$urlPrint,'onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 

        $content = $this->renderPartial('../tips/tips_laporan',array(),true); 
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>
<?php
$js= <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
    
        $("#div_semua").show();
        $("#div_penjamin").hide();
        $("#div_umum").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('all');
            $("#div_semua").show();
            $("#div_penjamin").hide();
            $("#div_umum").hide();        
        } else if (index==1){
            $("#filter_tab").val('p3');
            $("#div_semua").hide();
            $("#div_penjamin").show();
            $("#div_umum").hide();
        } else if (index==2){
            $("#filter_tab").val('umum');
            $("#div_semua").hide();
            $("#div_penjamin").hide();
            $("#div_umum").show();        
        }
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('semua_pencarianpasien_grid', {
                data: $("#caripasien-form").serialize()
            });
            $.fn.yiiGridView.update('penjamin_pencarianpasien_grid', {
                data: $("#caripasien-form").serialize()
            });
            $.fn.yiiGridView.update('umum_pencarianpasien_grid', {
                data: $("#caripasien-form").serialize()
            });        
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>
<?php
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&"+$('#caripasien-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>