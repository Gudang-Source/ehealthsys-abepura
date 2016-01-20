<div class="white-container">
    <legend class="rim2">Pengaturan <b>Tarif Tindakan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Satarif Tindakan Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tarif Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tarif Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tarif Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('satarif-tindakan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <!--<h3>Perda Tarif : <?php //echo PerdatarifM::model()->findByAttributes(array('perda_aktif'=>true))->perdanama_sk ?></h3>-->
    <?php 
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    }
    ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Tarif Tindakan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'satarif-tindakan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                     array(
                            'name'=>'jenistarif_id',
                            'filter'=>  CHtml::listData(SATarifTindakanM ::model()->getJenisTarifItems(), 'jenistarif_id', 'jenistarif_nama'),
    //                         'value'=>array($this,'gridJenisTarif'),
                             'value'=>'$data->jenistarif_nama',
                    ),
                     array(
                            'name'=>'kelaspelayanan_id',
                            'filter'=>  CHtml::listData(SATarifTindakanM ::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
    //                         'value'=>array($this,'gridKelasPelayanan'),
                             'value'=>'$data->kelaspelayanan_nama',
                    ),
                    array(
                            'name'=>'kategoritindakan_id',
                            'filter'=>  CHtml::listData(SATarifTindakanM ::model()->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),
    //                        'value'=>array($this,'gridKategoriTindakan'),
                            'value'=>'$data->kategoritindakan_nama',
                    ),
                    array(
                            'name'=>'daftartindakan_id',
                            'filter'=>  CHtml::listData(SATarifTindakanM ::model()->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
    //                         'value'=>array($this,'gridDaftarTindakan'),
                             'value'=>'$data->daftartindakan_nama',
                    ),
                    array(
                            'name'=>'komponentarif_id',
                            'filter'=>  CHtml::listData(SATarifTindakanM ::model()->KomponenTarifItems, 'komponentarif_id', 'komponentarif_nama'),
    //                        'value'=>'$data->komponentarif_nama',
    //                        'value'=>array($this,'gridKomponenTarif'),
                            'value'=>'$data->komponentarif_nama',
                    ),
                    array(
                        'header'=>'Tarif Tindakan',
                        'name'=>'harga_tariftindakan',
                        'type'=>'raw',
                        'value'=>'"Rp. ".number_format($data->harga_tariftindakan)',
                    ),
    //		'harga_tariftindakan',
                    /*
                    'persendiskon_tind',
                    'hargadiskon_tind',
                    'persencyto_tind',
                    */
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array
                                    (
                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->tariftindakan_id"))',
                                    ),

                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update')."<br>".CHtml::htmlButton("<i class='icon-form-ubah'></i>",array('onclick'=>'cariPerbaikanTarif(this);','class'=>'','rel'=>'tooltip','title'=>'Klik untuk mencari dan ubah tarif komponen yang salah hingga 10 halaman berikutnya')), //10 = LIMIT * 10.
                                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array
                                    (
                                        //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/index",array("perdatarif_id"=>"$data->perdatarif_id","jenistarif_id"=>"$data->jenistarif_id","kelaspelayanan_id"=>"$data->kelaspelayanan_id","daftartindakan_id"=>"$data->daftartindakan_id"))',
                                    ),

                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(
                                            'delete'=> array(
                                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->tariftindakan_id"))',
                                            ),
                            )
                    ),
            ),
             'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
        )); ?>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Tarif Tindakan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/index',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
	/**
	 * untuk mencari tariftindakan yang perlu perbaikan
	 * @returns {undefined}
	 */
	function cariPerbaikanTarif(obj){
		var linkupdate = "<?php echo $this->createUrl("admin"); //SETELAH RND-7868 SELESAI ?>";
		myConfirm("Proses ini memerlukan waktu yang cukup lama. Apakah anda tetap akan melanjutkan ?","Perhatian!", function(r){
			if(r){
				$(obj).hide();
				$(obj).parents("th").addClass('animation-loading-1');
				var pageaktif = $("#satarif-tindakan-m-grid .pagination .active a").html();
				$.ajax({
					type:'POST',
					url:'<?php echo $this->createUrl('CariPerbaikanTarif'); ?>',
					data: {pageaktif:pageaktif},//
					dataType: "json",
					success:function(data){
						if(data.sukses == 1){
							myConfirm(data.pesan+" Apakah anda ingin update tarif untuk tindakan "+data.daftartindakan_nama+"?","Perhatian!", function(r){
							if(r){
								window.location.href = linkupdate+"&id="+data.tariftindakan_id;
							}
							});
						}else{
							myAlert(data.pesan);
						}
						$(obj).show();
						$(obj).parents("th").removeClass('animation-loading-1');
					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
			}
		});
	}
</script>