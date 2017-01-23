<?php
    $count=0;
    if (!empty($model->persalinan_id)){
        $count = count(PSPemeriksaanpartografT::model()->findAll("persalinan_id = '".$model->persalinan_id."' ORDER BY persalinan_id"));
        
        
    }
?>
<fieldset id="panel-partograf" hidden>
    <?php 
        
        if ($count>1){
            for ($a=0;$a<=$count;$a++){                
                
                if ($a == 0){
                    $tab[]= array('label'=>'P '.($a+1), 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabPartograf(this, '.$a.');', 'id' => 'Par'.$a), 'active'=>true);
                }elseif ($a == $count){
                    $tab[]= array('label'=>'+', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabPartograf(this, "+");'));
                }else{
                    $tab[]= array('label'=>'P '.($a+1), 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabPartograf(this, '.$a.');', 'id' => 'Par'.$a));//,'icon'=>'icon-form-silang'
                }
            }                                           
        }else{
            $tab = array(
            array('label'=>'P 1', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabPartograf(this, 0);'), 'active'=>true),
            array('label'=>'+', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabPartograf(this, "+");')),                
        );
        }
        
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
            'stacked'=>false, // whether this is a stacked menu
            'items'=>$tab,
            'htmlOptions'=>array(
                'id'=>'tabberPartograf',
            )
        ));
    
    ?>
    
     <table width='100%' id = 'periksaPartograf'>
        <?php
            $i=0;
            if (!empty($model->persalinan_id)){
                $modPartograf = PSPemeriksaanpartografT::model()->findAll("persalinan_id = '".$model->persalinan_id."' ORDER BY pemeriksaanpartograf_id");
                
                if (count($modPartograf)>0){                    
                    foreach($modPartograf as $data){
                        $data->pto_tglperiksa = MyFormatter::formatDateTimeForUser($data->pto_tglperiksa);
                        $data->pto_ketubanpecah = MyFormatter::formatDateTimeForUser($data->pto_ketubanpecah);
                        $data->pto_mules = MyFormatter::formatDateTimeForUser($data->pto_mules);
        ?>
                        <tr id='parP<?php echo $i; ?>'>
                            <td><?php $this->renderPartial('_pemeriksaanPartograf', array('form'=>$form, 'modPartograf'=>$data, 'id'=>$i)); ?></td>
                        </tr>
        <?php
                    $i++;
                    }
                }else{
                    $modPartograf = new PSPemeriksaanpartografT;
                    $modPartograf->pto_tglperiksa = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        ?>
                     <tr id='parP<?php echo $i; ?>'>
                        <td><?php $this->renderPartial('_pemeriksaanPartograf', array('form'=>$form, 'modPartograf'=>$modPartograf, 'id'=>$i)); ?></td>
                    </tr>   
        <?php
                }
        
            }else{
                $modPartograf = new PSPemeriksaanpartografT;
                $modPartograf->pto_tglperiksa = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
        ?>
                    <tr id='parP<?php echo $i; ?>'>
                        <td><?php $this->renderPartial('_pemeriksaanPartograf', array('form'=>$form, 'modPartograf'=>$modPartograf, 'id'=>$i)); ?></td>
                    </tr>
                    
        <?php
            }
            
      ?>
    </table>
    
    
    
</fieldset>

<script>
    
    
    function setTabPartograf(obj, v)
    {
        var liLength = $("#tabberPartograf li").length; 
        var li = '<li onclick="setTabPartograf(this, \'+\')"><a href = "javascript:void(0);">+</a></li>';
        var periksaPartograf = new String(<?php echo CJSON::encode($this->renderPartial('_getFormPartograf',array('form'=>$form,'modPartograf'=>$modPartograf),true));?>);
        var id = liLength - 1;
                
        $("#tabberPartograf li").removeClass("active");
        $(obj).addClass("active");        
        
        if (v == 0) {
            for (var i =0;i<liLength;i++){
                $("#parP"+i+"").hide();
            }
            $("#parP"+v+"").show();            
        }else if (v=='+') {        
            $(obj).html("<a href = 'javascript:void(0);'>P "+liLength+"</a>");
            $(obj).attr('onclick',"setTabPartograf(this, "+id+")");
            $(obj).attr('id',"Par"+id);
            $('#tabberPartograf').append(li);   
            $('#periksaPartograf').append('<tr id= "parP'+(id)+'"><td>'+periksaPartograf.replace()+'</td></tr>');
            
            for (var i =0;i<liLength;i++){
                $("#parP"+i+"").hide();
            }
            
            $("#parP"+(liLength-1)+"").show();
                        
            renameInputPar('statusPar','parP'+id,id);
            
           
            $('#parP'+id).find('#statusPar tbody tr:last').find('input[name*="pemeriksaanpartograf_id]"').val('');
            $('#parP'+id).find('#statusPar tbody tr:last').find('input[name*="pemeriksaanobstetrik_id]"').val('');
            $('#parP'+id).find('#hapusPar tbody').append("<tr><td><a href = '#' onclick='delTrPar("+id+");' ><i class='icon-form-silang'></i></a></td></tr>");
            $('#parP'+id).find('#statusPar tbody').each(function(){
            jQuery('input[name$="[pto_tglperiksa]"]').datetimepicker(
                            jQuery.extend(
                                    {showMonthAfterYear:true},
                                    jQuery.datepicker.regional['id'],
                                    {
                                            'dateFormat':'<?php echo Params::DATE_FORMAT; ?>',
                                            'changeYear':true,
                                            'changeMonth':true,
                                            'showAnim':'fold',
                                            'maxDate':'d',
                                            'showSecond':true,
                                            'timeFormat':'hh:mm:ss'
                                    }
                            )
                    );
            
            jQuery('input[name$="[pto_ketubanpecah]"]').datepicker(
                            jQuery.extend(
                                    {showMonthAfterYear:true},
                                    jQuery.datepicker.regional['id'],
                                    {
                                            'dateFormat':'<?php echo Params::DATE_FORMAT; ?>',
                                            'changeYear':true,
                                            'changeMonth':true,
                                            'showAnim':'fold',
                                            'maxDate':'d',
                                            'showSecond':true,
                                            'timeFormat':'hh:mm:ss'
                                    }
                            )
                    );
            
            jQuery('input[name$="[pto_mules]"]').datepicker(
                            jQuery.extend(
                                    {showMonthAfterYear:true},
                                    jQuery.datepicker.regional['id'],
                                    {
                                            'dateFormat':'<?php echo Params::DATE_FORMAT; ?>',
                                            'changeYear':true,
                                            'changeMonth':true,
                                            'showAnim':'fold',
                                            'maxDate':'d',
                                            'showSecond':true,
                                            'timeFormat':'hh:mm:ss'
                                    }
                            )
                    );
            });
                        
            
        }else{
            for (var i =0;i<liLength;i++){
                $("#parP"+i+"").hide();
            }
            $("#parP"+v+"").show();          
        }
    }
    
    function renameInputPar(obj_table, idAttribute, id)
    {
        var trKala4 = $('#'+idAttribute).find('#periksaKala4 tbody tr').length;
        
        var i = 0;
      //  $('#'+idAttribute).find('#periksaKala4 tbody tr').each(function(){
        //    $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+id+']['+i+']['+attributeName+']').attr('id',modelName+'_'+id+'_'+i+'_'+attributeName+'');     //PSPemeriksaankala4T_0_0_kala4_anemia       
          //  $(this).find('span[id*="'+attributeName+'"]').attr('id',modelName+'_'+id+'_'+i+'_'+attributeName+'_date');                        
       // i++;    
       // });
       
        $('#'+idAttribute).find('#'+obj_table+' tbody > tr').each(function(){
        
            $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 4){
                  $(this).attr("id",old_name_arr[0]+"_"+id+"_"+i+"_"+old_name_arr[3]+"");
                  $(this).attr("name",old_name_arr[0]+"["+id+"]["+i+"]["+old_name_arr[3]+"]");              
                }else if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+id+"_"+old_name_arr[2]+"");
                    $(this).attr("name",old_name_arr[0]+"["+id+"]["+old_name_arr[2]+"]");          
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");

                var old_name_arr = old_name.split("[");
                //alert(old_name_arr.length);
                if(old_name_arr.length == 4){
                    $(this).attr("id",old_name_arr[0]+"_"+id+"_"+i+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"["+id+"]["+i+"]["+old_name_arr[3]+"]");
                }else if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+id+"_"+old_name_arr[2]+"");
                    $(this).attr("name",old_name_arr[0]+"["+id+"]["+old_name_arr[2]+"]");          
                }
            });
            //$(this).find('#tambahKala4').attr('onclick',"inputKala4(this,"+id+")");
            i++;
        });
       
       //tombol
        
        $('.numbers-only').keyup(function(){
            setNumbersOnly(this);
        });
         $('.numbersOnly').keyup(function(){
            setNumbersOnly(this);
        });
    }
    
    function delTrPar(id)
    {
        myConfirm('Apakah Anda yakin ingin membatalkan pemeriksaan partograf ini ?','Perhatian!',function(r){
            if (r){
                $("#periksaPartograf").find("#parP"+id).remove();
                $("#tabberPartograf").find("#Par"+id).remove();
           }
        });
	
    }
    
</script>
<?php 
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkes',
    'options'=>array(
        'title'=>'Daftar Stok Ruangan -'.Yii::app()->user->getState('ruangan_nama').'-',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>620,
        'resizable'=>false,
    ),
));
$format = new MyFormatter();
$modObatAlkes = new PSInfostokobatalkesruanganV('searchDialogMutasi');
$modObatAlkes->unsetAttributes();
$modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modObatAlkes->instalasi_id = Yii::app()->user->getState('instalasi_id');
if(isset($_GET['PSInfostokobatalkesruanganV'])){
    $modObatAlkes->attributes = $_GET['PSInfostokobatalkesruanganV'];
    $modObatAlkes->obatalkes_kode = isset($_GET['PSInfostokobatalkesruanganV']['obatalkes_kode']) ? $_GET['GFInfostokobatalkesruanganV']['obatalkes_kode'] : null;
    $modObatAlkes->jenisobatalkes_nama = isset($_GET['PSInfostokobatalkesruanganV']['jenisobatalkes_nama']) ? $_GET['GFInfostokobatalkesruanganV']['jenisobatalkes_nama'] : null;
    $modObatAlkes->satuankecil_nama = isset($_GET['PSInfostokobatalkesruanganV']['satuankecil_nama']) ? $_GET['GFInfostokobatalkesruanganV']['satuankecil_nama'] : null;
    $modObatAlkes->tglkadaluarsa = isset($_GET['PSInfostokobatalkesruanganV']['tglkadaluarsa']) ? $format->formatDateTimeForDb($_GET['GFInfostokobatalkesruanganV']['tglkadaluarsa']) : null;
}

$provider = $modObatAlkes->searchDataObat();
$provider->sort->defaultOrder = 'obatalkes_nama asc';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-m-grid',
	'dataProvider'=>$modObatAlkes->searchDataObat(),
	'filter'=>$modObatAlkes,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\'+$(\'#nomor\').val()).val($data->obatalkes_id);                                        
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
                array(
                    'header'=>'Jenis Obat Alkes',
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
                    'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "")',
                    'filter'=>  CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                        'condition'=>'jenisobatalkes_aktif = true',
                        'order'=>'jenisobatalkes_nama'
                    )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --')),
                ),
                
                array(
                    'name'=>'obatalkes_kategori',
                    'filter'=> CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'name'=>'obatalkes_golongan',
                    'filter'=> CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --'))
                ),
                'obatalkes_kode',
                'obatalkes_nama',
                //'obatalkes_kategori',
                //'obatalkes_golongan',
                // 'nobatch',
		array(
                    'header'=>'Tgl Kadaluarsa',
                    'name'=>'tglkadaluarsa',
                    'type'=>'raw',
                    'value'=>'(!empty($data->tglkadaluarsa) ? MyFormatter::formatDateTimeForUser($data->tglkadaluarsa) : "")',
                    'filter'=>$this->widget('MyDateTimePicker',array(
						'model'=>$modObatAlkes,
						'attribute'=>'tglkadaluarsa',
						'mode'=>'date',
						'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
						),
						'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3 datemask','placeholder'=>'00/00/0000', 'id'=>'tglkadaluarsa'),
						),true
					),
                ), /*
                array(
                    'name'=>'satuankecil_id',
                    'type'=>'raw',
//                    'value'=>'isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : isset($data->satuankecil_nama) ? $data->satuankecil_nama : ""',
                    'value'=>'$data->satuankecil_nama',
                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
                ), */
		// dicomment karena RND-5732
//                array(
//                    'name'=>'hargajual',
//                    'type'=>'raw',
//                    'value'=>'"Rp.".MyFormatter::formatNumberForPrint($data->hargajual)',
//                    'filter'=>false,
//                ),
                array(
                    'header'=>'Jumlah Stok',
                    'value'=>function($data) {
                        //$stok = StokobatalkesT::model()->findAllByAttributes(array(
                          //  'obatalkes_id'=>$data->obatalkes_id,
                            //'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                        //));
    
                        $r = Yii::app()->user->getState('ruangan_id');
    
                        $criteria = new CDbCriteria();
                        $criteria->compare('obatalkes_id',$data->obatalkes_id);
                        $criteria->addCondition("tglkadaluarsa = '".MyFormatter::formatDateTimeForDb($data->tglkadaluarsa)."' ");
                      //  if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GUDANG_FARMASI)
                       // {
                            $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
                        //}
                        $stok = StokobatalkesT::model()->findAll($criteria);
                        $total = 0;
                        foreach ($stok as $item) {
                            $total += $item->qtystok_in - $item->qtystok_out;
                        }
                        $satuan = ($data->satuankecil_nama==null)?$data->satuankecil->satuankecil_nama:$data->satuankecil_nama;

                        return $total." ".$satuan;

                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: right;'
                    )
                ),

                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
			jQuery(\'#tglkadaluarsa\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tglkadaluarsa_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});}',
)); 

$this->endWidget();
?>