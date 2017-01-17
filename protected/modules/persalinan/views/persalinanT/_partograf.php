<?php
    $count=0;
    if (!empty($modObstetrik->pemeriksaanobstetrik_id)){
        $count = count(PSPemeriksaanpartografT::model()->findAll("pemeriksaanobstetrik_id = '".$modObstetrik->pemeriksaanobstetrik_id."' ORDER BY pemeriksaanpartograf_id"));
        
        
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
            if (!empty($modObstetrik->pemeriksaanobstetrik_id)){
                $modPartograf = PSPemeriksaanpartografT::model()->findAll("pemeriksaanobstetrik_id = '".$modObstetrik->pemeriksaanobstetrik_id."' ORDER BY pemeriksaanpartograf_id");
                
                if (count($modPartograf)>0){
                    foreach($modPartograf as $data){
                        $data->pto_tglperiksa = MyFormatter::formatDateTimeForUser($data->pto_tglperiksa);
        ?>
                        <tr id='parP<?php echo $i; ?>'>
                            <td><?php $this->renderPartial('_pemeriksaanPartograf', array('form'=>$form, 'modPartograf'=>$data, 'id'=>$i)); ?></td>
                        </tr>
        <?php
                    $i++;
                    }
                }else{
                    $modPartograf = new PSPemeriksaanpartografT;
                    $modPartograf->pto_tglperiksa = MyFormatter::formatDateTimeForUser(date('D m Y H:i:s'));
        ?>
                     <tr id='parP<?php echo $i; ?>'>
                        <td><?php $this->renderPartial('_pemeriksaanPartograf', array('form'=>$form, 'modPartograf'=>$modPartograf, 'id'=>$i)); ?></td>
                    </tr>   
        <?php
                }
        
            }else{
                $modPartograf = new PSPemeriksaanpartografT;
                $modPartograf->pto_tglperiksa = MyFormatter::formatDateTimeForUser(date('D m Y H:i:s'));
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