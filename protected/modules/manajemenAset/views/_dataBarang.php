<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modBarang)){
?>
<fieldset class="box">
    <legend class="rim">Data Barang</legend>
    <?php echo CHtml::css ('table.table tr td.img img{max-width:120px;max-height:120px;}'); ?>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
            <div class="control-group ">
                    <label class="control-label" for="bidang">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_nama',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                        <?php //echo $form->hiddenField($model,'barang_id'); ?>
                    <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            
                                            'name'=>'barang_nama',
                                            'value'=>$modBarang->barang_nama,
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.Yii::app()->createUrl('ActionAutoComplete/getBarang').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 2,
                                                   'focus'=> 'js:function( event, ui ) {
                                                        $(this).val( ui.item.label);
                                                        return false;
                                                    }',
                                                   'select'=>'js:function( event, ui ) { 
                                                        
                                                  $("#'.CHtml::activeId($modBarang,'barang_id').'").val(ui.item.barang_id);
                                                  $("#'.CHtml::activeId($modBarang,'barang_type').'").val(ui.item.barang_type);   
                                                  $("#'.CHtml::activeId($modBarang,'barang_image').'").val(ui.item.barang_image);     
                                                  $("#'.CHtml::activeId($modBarang,'barang_kode').'").val(ui.item.barang_kode);
                                                  $("#'.CHtml::activeId($modBarang,'barang_nama').'").val(ui.item.barang_nama);   
                                                  $("#MAInvtanahT_barang_nama").val(ui.item.barang_nama);   
                                                  $("#MAInvtanahT_barang_id").val(ui.item.barang_id);   
                                                  $("#MAInvgedungT_barang_nama").val(ui.item.barang_nama);   
                                                  $("#MAInvgedungT_barang_id").val(ui.item.barang_id);   
                                                  $("#MAInvperalatanT_barang_nama").val(ui.item.barang_nama);   
                                                  $("#MAInvperalatanT_barang_id").val(ui.item.barang_id);   
                                                  $("#MAInvasetlainT_barang_nama").val(ui.item.barang_nama);   
                                                  $("#MAInvasetlainT_barang_id").val(ui.item.barang_id);   
                                                  $("#MAInvjalanT_barang_nama").val(ui.item.barang_nama);   
                                                  $("#MAInvjalanT_barang_id").val(ui.item.barang_id);   
                                                  $("#'.CHtml::activeId($modBarang,'barang_noseri').'").val(ui.item.barang_noseri);   
                                                  $("#'.CHtml::activeId($modBarang,'barang_thnbeli').'").val(ui.item.barang_thnbeli);     
                                                  $("#'.CHtml::activeId($modBarang,'barang_satuan').'").val(ui.item.barang_satuan);  
                                                  $("#'.CHtml::activeId($modBarang,'barang_jmldlmkemasan').'").val(ui.item.barang_jmldlmkemasan);
                                                      
                                                    if(ui.item.barang_image != null){
                                                        $("td.img img").attr(\'src\',\''.Params::urlBarangDirectory().'\'+ui.item.barang_image);
                                                    } else {
                                                        $("td.img img").attr(\'src\',\''.Params::urlBarangDirectory().'no_photo.jpeg\');
                                                    }
                                                        return false;
                                                    }',
                                            ),
                                            'htmlOptions'=>array(
                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogBarang'),
                                        )); 
                        ?>
                    </div>
                </div>
            </td>            
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_type">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_type',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_type', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td></td>
            <td rowspan="4" class='img'>
                <?php 
                    if(!empty($modBarang->barang_image)){
                        echo CHtml::image(Params::urlBarangDirectory().$modBarang->barang_image, 'barang_image', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlBarangDirectory().'no_photo.jpeg', 'barang_image', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_kode">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_kode',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_kode', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_nama">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_nama',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_nama', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_thnbeli">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_thnbeli',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_thnbeli', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_thnbeli">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_satuan',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_satuan', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_jmldlmkemasan">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_jmldlmkemasan',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang,'barang_jmldlmkemasan', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="barang_jmldlmkemasan">
                        <?php echo CHtml::activeLabel($modBarang, 'barang_noseri',array('class'=>'control-label')); ?>
                    </label>
                    <div class="controls">
                       <?php echo CHtml::activeTextField($modBarang, 'barang_noseri', array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td></td>
            
            </tr>
    </table>
</fieldset>
<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogBarang',
    'options'=>array(
        'title'=>'Data Barang',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));

$barang= new MABarangM('search');
$barang->unsetAttributes();

if (isset($this->golongan_id) && !empty($this->golongan_id)) {
    $barang->golongan_id = $this->golongan_id;
}

if(isset($_GET['MABarangM'])) {
    $barang->attributes = $_GET['MABarangM'];
    $barang->kelompok_id = $_GET['MABarangM']['kelompok_id'];
    $barang->subkelompok_id = $_GET['MABarangM']['subkelompok_id'];
    $barang->subsubkelompok_id = $_GET['MABarangM']['subsubkelompok_id'];
}


$cb = new CDbCriteria();
$cb->compare('golongan_id', $barang->golongan_id);
$cb->order = "bidang_nama asc";
$cb->addCondition("bidang_aktif = true");

$b = BidangM::model()->findAll($cb);

$ck = new CDbCriteria();
$ck->compare('bidang_id', $barang->bidang_id);
$ck->order = "kelompok_nama asc";
$ck->addCondition("kelompok_aktif = true");

$k = KelompokM::model()->findAll($ck);
$krl = CHtml::listData($k, 'kelompok_id', 'kelompok_id');

if (!empty($barang->kelompok_id) && !in_array($barang->kelompok_id, $krl)) {
    $barang->kelompok_id = $barang->subkelompok_id = $barang->subsubkelompok_id = null;
}

$csk = new CDbCriteria();

if (empty($barang->kelompok_id)) {
    $csk->compare('kelompok_id', $krl);
} else {
    $csk->compare('kelompok_id', $barang->kelompok_id);
}

$csk->order = "subkelompok_nama asc";
$csk->addCondition('subkelompok_aktif = true');

$sk = SubkelompokM::model()->findAll($csk);
$skrl = CHtml::listData($sk, 'subkelompok_id', 'subkelompok_id');

if (!empty($barang->subkelompok_id) && !in_array($barang->subkelompok_id, $skrl)) {
    $barang->subkelompok_id = $barang->subsubkelompok_id = null;
}

$cssk = new CDbCriteria();
if (empty($barang->subkelompok_id)) {
    $cssk->compare('subkelompok_id', $skrl);
} else {
    $cssk->compare('subkelompok_id', $barang->subkelompok_id);
}

$cssk->order = "subsubkelompok_nama asc";
$ssk = SubsubkelompokM::model()->findAll($cssk);
$sskrl = CHtml::listData($ssk, 'subsubkelompok_id', 'subsubkelompok_id');
if (!empty($barang->subsubkelompok_id) && !in_array($barang->subsubkelompok_id, $sskrl)) {
    $barang->subsubkelompok_id = null;
}


$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-v-grid',
    'dataProvider'=>$barang->searchBarang(),
    'filter'=>$barang,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        //'golongan_id',
        //'golongan_kode',
       // 'golongan_nama',
       //  'bidang.subkelompok.kelompok.golongan.golongan_nama',
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>",
                        "#",
                        array(
                            "class"=>"btn-small", 
                            "id" => "selectKelompoks",
                            "onClick" => "
                            $(\"#'.CHtml::activeId($modBarang,'barang_id').'\").val($data->barang_id);
                            $(\"#'.CHtml::activeId($modBarang,'barang_type').'\").val(\"$data->barang_type\");   
                            $(\"#'.CHtml::activeId($modBarang,'barang_image').'\").val(\"$data->barang_image\");     
                            $(\"#'.CHtml::activeId($modBarang,'barang_kode').'\").val(\"$data->barang_kode\");
                                $(\"#barang_nama\").val(\"$data->barang_nama\");
                            $(\"#'.CHtml::activeId($modBarang,'barang_nama').'\").val(\"$data->barang_nama\");   
                            $(\"#MAInvtanahT_invtanah_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvtanahT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvtanahT_barang_id\").val($data->barang_id);   
                            $(\"#MAInvgedungT_invgedung_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvgedungT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvgedungT_barang_id\").val($data->barang_id);   
                            $(\"#MAInvperalatanT_invperalatan_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvperalatanT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvperalatanT_barang_id\").val($data->barang_id);   
                            $(\"#MAInvasetlainT_invasetlain_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvasetlainT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvasetlainT_barang_id\").val($data->barang_id);   
                            $(\"#MAInvjalanT_invjalan_namabrg\").val(\"$data->barang_nama\");   
                            $(\"#MAInvjalanT_barang_nama\").val(\"$data->barang_nama\");   
                            $(\"#MAInvjalanT_barang_id\").val($data->barang_id);   
                            $(\"#'.CHtml::activeId($modBarang,'barang_noseri').'\").val(\"$data->barang_noseri\");   
                            $(\"#'.CHtml::activeId($modBarang,'barang_thnbeli').'\").val($data->barang_thnbeli);     
                            $(\"#'.CHtml::activeId($modBarang,'barang_satuan').'\").val(\"$data->barang_satuan\");  
                            $(\"#'.CHtml::activeId($modBarang,'barang_jmldlmkemasan').'\").val($data->barang_jmldlmkemasan);
                            if(\"$data->barang_image\" != \"\"){
                                $(\"td.img img\").attr(\'src\',\''.Params::urlBarangDirectory().'\'+\"$data->barang_image\");
                            } else {
                                $(\"td.img img\").attr(\'src\',\''.Params::urlBarangDirectory().'no_photo.jpeg\');
                            }
                               $(\"#dialogBarang\").dialog(\"close\");

                            "))
                        ',
            'htmlOptions'=>array(
                'style'=>'width: 50px',
            )
        ),
        array(
            'header'=>'Bidang',
            'type'=>'raw',
            'name'=>'bidang_id',
            'value'=>function($data) use (&$subk) {
                $subk = SubsubkelompokM::model()->findByPk($data->subsubkelompok_id);
                if (empty($subk)) return "-";
                return $subk->subkelompok->kelompok->bidang->bidang_nama;
            },
            'filter'=>  CHtml::activeDropDownList($barang, 'bidang_id', CHtml::listData($b, 'bidang_id', 'bidang_nama'), array(
                    'empty' => '-- Pilih --', 'style'=>'max-width: 150px',
            )),
        ),
        /*
        array(
            'header'=>'Nama Golongan',
            'name'=>'golongan_nama',
            'value'=>function($data) use (&$subk) {
                $subk = SubsubkelompokM::model()->findByPk($data->subsubkelompok_id);
                return $subk->subkelompok->kelompok->golongan->golongan_nama;
            },
        ), */
        //'kelompok_id',
        //'kelompok_kode',
        //'kelompok_nama',
           array(
            'header'=>'Kelompok',
            'name'=>'kelompok_id',
            'value'=>function($data) use (&$subk) {
                if (empty($subk)) return "-";
                return $subk->subkelompok->kelompok->kelompok_nama;
            },
            'filter'=>  CHtml::activeDropDownList($barang, 'kelompok_id', CHtml::listData($k, 'kelompok_id', 'kelompok_nama'), array(
                    'empty' => '-- Pilih --', 'style'=>'max-width: 150px',
            )),
            'htmlOptions'=>array(
                'style'=>'width: 150px',
            )
            
        ),
       // 'bidang.subkelompok.kelompok.kelompok_nama',
        
        
        //'subkelompok_id',
        //'subkelompok_kode',
        //'subkelompok_nama',
      //  'bidang.subkelompok.subkelompok_nama',
          array(
            'header'=>'Sub Kelompok',
            'name'=>'subkelompok_id',
            'value'=>function($data) use (&$subk) {
                if (empty($subk)) return "-";
                return $subk->subkelompok->subkelompok_nama;
            },
            'filter'=>  CHtml::activeDropDownList($barang, 'subkelompok_id', 
                    CHtml::listData($sk, 'subkelompok_id', 'subkelompok_nama'), 
                    array(
                        'empty' => '-- Pilih --', 'style'=>'max-width: 150px',
                    )),
            'htmlOptions'=>array(
                'style'=>'width: 150px',
            )
        ),
          array(
            'header'=>'Sub Sub Kelompok',
            'name'=>'subsubkelompok_id',
            'value'=>function($data) use (&$subk) {
                if (empty($subk)) return "-";
                return $subk->subsubkelompok_nama;
            }, 
            'filter'=>  CHtml::activeDropDownList($barang, 'subsubkelompok_id', 
                    CHtml::listData($ssk, 'subsubkelompok_id', 'subsubkelompok_nama'), array(
                    'empty' => '-- Pilih --', 'style'=>'max-width: 150px',
                )),
            'htmlOptions'=>array(
                'style'=>'width: 150px',
            )
            
        ),
        //'bidang_id',
        //'bidang_kode',
       // 'bidang_nama',
                    /*
         array(
            'header'=>'Nama Bidang',
            'name'=>'bidang_nama',
            'value'=>'$data->bidang->bidang_nama'
            
        ),
                     * 
                     */
        // 'bidang.bidang_nama',
        ////'barang_id',
//        array(
//                        'name'=>'barang_id',
//                        'value'=>'$data->barang_id',
//                        'filter'=>false,
//                ),
       // 'barang_type',
      'barang_kode',
      'barang_nama',
//        'barang_namalainnya',
//        'barang_merk',
//        'barang_noseri',
//        'barang_ukuran',
//        'barang_bahan',
//        'barang_thnbeli',
//        'barang_warna',
//        'barang_statusregister',
//        'barang_ekonomis_thn',
//        'barang_satuan',
//        'barang_jmldlmkemasan',
//        'barang_image',
//        'barang_aktif',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
<?php } ?>


