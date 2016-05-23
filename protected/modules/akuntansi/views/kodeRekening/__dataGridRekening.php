<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<!--<div class='block-tabel'>-->
    <!--<h6>Daftar <b>Rekening</b></h6>-->
    <div style="max-width:100%;">
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView',
                array(
                    'id'=>'AKRekeningakuntansi-v',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        /*
                        array(
                          'header'=>'No',
                          'type'=>'raw',
                          'value'=>'$row+1',
                          'htmlOptions'=>array('style'=>'width:20px')
                        ), /*
                        array(
                           'name'=>'kdrekening1',
                           'type'=>'raw',
                           'value'=>'$data->kdrekening1',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px;')
                        ),
                        array(
                           'name'=>'kdrekening2',
                           'type'=>'raw',
                           'value'=>'$data->kdrekening2',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px')
                        ),
                        array(
                           'name'=>'kdrekening3',
                           'type'=>'raw',
                           'value'=>'$data->kdrekening3',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px')
                        ),
                        array(
                           'name'=>'kdrekening4',
                           'type'=>'raw',
                           'value'=>'($data->kdrekening4 == null ? "-" : $data->kdrekening4)',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px')
                        ), */
                        array(
                           'header'=>'Kode Akun',
                           'name'=>'kode',
                           'type'=>'raw',
                           'htmlOptions'=>array('style'=>'width:80px'),
                           'filter'=>  CHtml::activeDropDownList($model, 'akun', array(
                               1 => 'Komponen',
                               2 => 'Unsur',
                               3 => 'Kelompok Pos',
                               4 => 'Pos',
                               5 => 'Akun',
                           ), array ('empty'=>'-- Pilih --')),
                        ), /*
                        array(
                           'name'=>'nmrekening1',
                           'type'=>'raw',
                           'value'=>'isset($data->nmrekening1) ? CHtml::Link($data->nmrekening1, Yii::app()->controller->createUrl("KodeRekening/editStrukturRekening",array("id"=>$data->rekening1_id)),array("style"=>"color:blue","target"=>"frameEditStruktur", "onclick"=>"$(\"#dialogEditStruktur\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Struktur Rekening",)) : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmrekening2',
                           'type'=>'raw',
                           'value'=>'isset($data->namakelrekening) ? CHtml::Link($data->nmrekening2, Yii::app()->controller->createUrl("KodeRekening/editKelompokRekening",array("id"=>$data->rekening2_id)),array("style"=>"color:blue","target"=>"frameEditKelompokRek", "onclick"=>"$(\"#dialogEditKelompokRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik Untuk<br>Edit Kelompok Rekening",)) : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmrekening3',
                           'type'=>'raw',
                           'value'=>'isset($data->nmrekening3) ? CHtml::Link($data->nmrekening3, Yii::app()->controller->createUrl("KodeRekening/editJenisRekening",array("id"=>$data->rekening3_id)),array("style"=>"color:blue","target"=>"frameEditKelompokRek", "onclick"=>"$(\"#dialogEditKelompokRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Jenis Rekening",)) : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmrekening4',
                           'type'=>'raw',
                           'value'=>'isset($data->nmrekening4) ? CHtml::Link($data->nmrekening4, Yii::app()->controller->createUrl("KodeRekening/editObyekRekening",array("id"=>$data->rekening4_id)),array("style"=>"color:blue","target"=>"frameEditObyekRek", "onclick"=>"$(\"#dialogEditObyekRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Obyek Rekening",)) : "-"',
                        ), */
                        array(
                           'header'=>'Nama Akun',
                           'name'=>'nama',
                           'type'=>'raw',
                           'value'=>function($data) {
                                $nama = $data->nama;
                                $pad = 0;
                                $res = "";
                                switch ($data->akun) {
                                    case 1: 
                                        $res = CHtml::Link($data->nama, Yii::app()->controller->createUrl("KodeRekening/editStrukturRekening",array("id"=>$data->id)),array("style"=>"color:blue","target"=>"frameEditStruktur", "onclick"=>'$("#dialogEditStruktur").dialog("open");',"rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Kelompok Akun",));
                                        break;
                                    case 2: 
                                        $res = "&emsp;".CHtml::Link($data->nama, Yii::app()->controller->createUrl("KodeRekening/editKelompokRekening",array("id"=>$data->id)),array("style"=>"color:blue","target"=>"frameEditKelompokRek", "onclick"=>'$("#dialogEditKelompokRek").dialog("open");',"rel"=>"tooltip", "title"=>"Klik Untuk<br>Golongan Akun",));
                                        break;
                                    case 3: 
                                        $res = "&emsp;"."&emsp;".CHtml::Link($data->nama, Yii::app()->controller->createUrl("KodeRekening/editJenisRekening",array("id"=>$data->id)),array("style"=>"color:blue","target"=>"frameEditJenisRek", "onclick"=>'$("#dialogEditJenisRek").dialog("open");',"rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Sub Golongan Akun",));
                                        break;
                                    case 4: 
                                        $res = "&emsp;"."&emsp;"."&emsp;".CHtml::Link($data->nama, Yii::app()->controller->createUrl("KodeRekening/editObyekRekening",array("id"=>$data->id)),array("style"=>"color:blue","target"=>"frameEditObyekRek", "onclick"=>'$("#dialogEditObyekRek").dialog("open");',"rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Jenis Akun",));
                                        break;
                                    case 5:
                                        $res = "&emsp;"."&emsp;"."&emsp;"."&emsp;".CHtml::Link($data->nama, Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek",array("id"=>$data->id)),array("style"=>"color:blue","target"=>"frameEditRincianObyekRek", "onclick"=>'$("#dialogEditRincianObyekRek").dialog("open");',"rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Kode Akun",));
                                        break;
                                }
                                return $res;
                           },//'isset($data->nmrekening5) ? CHtml::Link($data->nmrekening5, Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek",array("id"=>$data->rekening5_id)),array("style"=>"color:blue","target"=>"frameEditRincianObyekRek", "onclick"=>"$(\"#dialogEditRincianObyekRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Rincian Obyek Rekening",)) : "-"',
                        ),
                        array(
                           'header'=>'Saldo Normal',
                           'name'=>'saldo_normal',
                           'type'=>'raw',
                           'value'=>'($data->saldo_normal == null ? "-" : ($data->saldo_normal == "D" ? "Debit" : "Kredit"))',
                        ), /*
                        array(
                           'name'=>'kelompokrek',
                           'type'=>'raw',
                            'value'=>'($data->kelompokrek == null ? "-" : $data->kelompokrek)',
                        ), */ 
                        array(
                           'name'=>'keterangan',
                           'type'=>'raw',
                            'value'=>'($data->keterangan == null ? "-" : $data->keterangan)',
                        ), /*
                        array(
                           'header'=>'Status',
                           'type'=>'raw',
                           'value'=>'($data->aktif == null ? "-" : ($data->aktif == true ? "Aktif" : "Non Aktif"))',
                           'htmlOptions'=>array('style'=>'text-align: center; width:80px')
                        ), */
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )
            );
        ?>
    </div>
<!--</div>-->
<?php 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
?>
<?php
        $content = $this->renderPartial('../tips/master3',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        
        
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#AKRekeningakuntansi-v :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditStruktur',
        'options' => array(
            'title' => 'Edit Komponen',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close'=>'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditStruktur' width="100%" height="100%"></iframe>
<?php
    $this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditKelompokRek',
        'options' => array(
            'title' => 'Edit Unsur',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close'=>'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditKelompokRek' width="100%" height="100%"></iframe>
<?php
    $this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditJenisRek',
        'options' => array(
            'title' => 'Edit Kelompok Pos',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close'=>'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditJenisRek' width="100%" height="100%"></iframe>
<?php
    $this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditObyekRek',
        'options' => array(
            'title' => 'Edit Pos',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close'=>'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditObyekRek' width="100%" height="100%"></iframe>
<?php
    $this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditRincianObyekRek',
        'options' => array(
            'title' => 'Edit Akun',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 450,
            'resizable' => false,
            'close'=>'js:function(){getTreeMenu();$.fn.yiiGridView.update(\'AKRekeningakuntansi-v\', {});}'
        ),
    )
);
?>
<iframe name='frameEditRincianObyekRek' width="100%" height="100%"></iframe>
<?php
    $this->endWidget();
?>


<script type="text/javascript">
    
</script>