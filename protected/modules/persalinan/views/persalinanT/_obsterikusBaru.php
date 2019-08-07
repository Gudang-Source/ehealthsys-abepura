<?php
    $count=0;
    if (!empty($model->persalinan_id)){
        $count = count(PSPemeriksaanobstetrikT::model()->findAll("persalinan_id = '".$model->persalinan_id."' ORDER BY pemeriksaanobstetrik_id"));
        
        
    }
?>
<fieldset id="panel-obs" hidden>
    <?php 
        
        if ($count>1){
            for ($a=0;$a<=$count;$a++){                
                
                if ($a == 0){
                    $tab[]= array('label'=>'P '.($a+1), 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabObs(this, '.$a.');', 'id' => 'P'.$a), 'active'=>true);
                }elseif ($a == $count){
                    $tab[]= array('label'=>'+', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabObs(this, "+");'));
                }else{
                    $tab[]= array('label'=>'P '.($a+1), 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabObs(this, '.$a.');', 'id' => 'P'.$a));//,'icon'=>'icon-form-silang'
                }
            }                                           
        }else{
            $tab = array(
            array('label'=>'P 1', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabObs(this, 0);'), 'active'=>true),
            array('label'=>'+', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabObs(this, "+");')),                
        );
        }
        
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
            'stacked'=>false, // whether this is a stacked menu
            'items'=>$tab,
            'htmlOptions'=>array(
                'id'=>'tabberObs',
            )
        ));
    
    ?>
    <table width='100%' id = 'periksaOBS'>
        <?php
            $i=0;
            if (!empty($model->persalinan_id)){
                $modObstetrik = PSPemeriksaanobstetrikT::model()->findAll("persalinan_id = '".$model->persalinan_id."' ORDER BY pemeriksaanobstetrik_id");
                
                if (count($modObstetrik)>0){
                    foreach($modObstetrik as $data){
        ?>
                        <tr id='obsP<?php echo $i; ?>'>
                            <td><?php $this->renderPartial('_pemeriksaanObs', array('form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$data, 'id'=>$i)); ?></td>
                        </tr>
        <?php
                    $i++;
                    }
                }else{
                    $modObstetrik = new PSPemeriksaanobstetrikT;
        ?>
                     <tr id='obsP<?php echo $i; ?>'>
                        <td><?php $this->renderPartial('_pemeriksaanObs', array('model' => $model,'modPemeriksaLama' => $modPemeriksaLama,'form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modObstetrik, 'id'=>$i)); ?></td>
                    </tr>   
        <?php
                }
        
            }else{
                $modObstetrik = new PSPemeriksaanobstetrikT;
        ?>
                    <tr id='obsP<?php echo $i; ?>'>
                        <td><?php $this->renderPartial('_pemeriksaanObs', array('model' => $model,'modPemeriksaLama' => $modPemeriksaLama,'form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modObstetrik, 'id'=>$i)); ?></td>
                    </tr>
                    
        <?php
            }
            
      ?>
    </table>
    
</fieldset>
            
            
<script>
    function inputKala4(obj,id){
        
	var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRowKala4(this); return false;')) ?>';
        //var tr = $('#periksaKala4 tbody tr:first').html();	
        var tr = new String(<?php echo CJSON::encode($this->renderPartial('_getFormKala4',array('form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modPemeriksaan),true));?>);
                
        //$('#periksaKala4 tr:last').after('<tr>'+tr+'</tr>');
        
        $('#obsP'+id).find('#periksaKala4 tbody').append(tr.replace());
        //parents('table').children('tbody').append
        $('#obsP'+id).find('#periksaKala4 tr:last td:last').append(buttonMinus);
                
	renameInput('PSPemeriksaankala4T','kala4_tanggal', id);
        renameInput('PSPemeriksaankala4T','kala4_anemia', id);
        renameInput('PSPemeriksaankala4T','kala4_systolic', id);
        renameInput('PSPemeriksaankala4T','kala4_diastolic', id);
        renameInput('PSPemeriksaankala4T','kala4_tekanandarah', id);
        renameInput('PSPemeriksaankala4T','kala4_meanarteripressure', id);
        renameInput('PSPemeriksaankala4T','kala4_detaknadi', id);
        renameInput('PSPemeriksaankala4T','kala4_pernapasan', id);
        renameInput('PSPemeriksaankala4T','kala4_tinggifundus', id);
        renameInput('PSPemeriksaankala4T','kala4_kontraksi', id);
        renameInput('PSPemeriksaankala4T','kala4_kandungkemih', id);
        renameInput('PSPemeriksaankala4T','kala4_darahcc', id);
        renameInput('','tekananDarah', id);
        
        $('#obsP'+id).find('#periksaKala4 tr:last').find('input').val('');
        $('#obsP'+id).find('#periksaKala4 tr:last').find('input[name*="kala4_tanggal"]').val('<?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')); ?>');
        
        $('#obsP'+id).find('#periksaKala4 tbody').each(function(){
        jQuery('input[name$="[kala4_tanggal]"]').datetimepicker(
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
        //renameInput('PSPemeriksaankala4T','kala4_');                                
    }
    
    function renameInput(modelName,attributeName,id)
    {
        //var trLength = $('#periksaKala4 tbody tr').length;
        var i = 0;        
        $('#obsP'+id).find('#periksaKala4 tbody > tr').each(function(){             
            $(this).find('input[name*="['+attributeName+']"]').attr('name',modelName+'['+id+']['+i+']['+attributeName+']').attr('id',modelName+'_'+id+'_'+i+'_'+attributeName+'');     //PSPemeriksaankala4T_0_0_kala4_anemia       
            $(this).find('span[id*="'+attributeName+'"]').attr('id',modelName+'_'+id+'_'+i+'_'+attributeName+'_date');                        
            $(this).find('#tambahKala4').attr('onclick',"inputKala4(this,"+id+")");
            if (attributeName == 'kala4_systolic'){
                $(this).find('input[name*="['+attributeName+']"]').attr('onkeyup', 'setTekanan(this, '+id+' , '+i+');').
                         attr('class', 'span1 numbers-only systolic'+id+i);
            }
            if (attributeName == 'kala4_diastolic'){
                $(this).find('input[name*="['+attributeName+']"]').attr('onkeyup', 'setTekanan(this, '+id+' , '+i+');').
                        attr('class', 'span1 numbers-only diastolic'+id+i);
            }
            if (attributeName == 'kala4_tekanandarah'){
                $(this).find('input[name*="['+attributeName+']"]').attr('class', 'span2 td'+id+i);
            }
            
            if (attributeName == 'tekananDarah'){                
                $(this).find('#tekananDarah').attr('id', 'tekananDarah'+id+i);
            }
        i++;    
        });
        
        $('.numbers-only').keyup(function(){
            setNumbersOnly(this);
        });
         $('.numbersOnly').keyup(function(){
            setNumbersOnly(this);
        });
    }
    
    function delRowKala4(obj)
    {
	$(obj).parent().parent().remove();
        
	renameInput('PSPemeriksaankala4T','kala4_tanggal');
        renameInput('PSPemeriksaankala4T','kala4_anemia');
        renameInput('PSPemeriksaankala4T','kala4_systolic');
        renameInput('PSPemeriksaankala4T','kala4_diastolic');
        renameInput('PSPemeriksaankala4T','kala4_tekanandarah');
        renameInput('PSPemeriksaankala4T','kala4_meanarteripressure');
        renameInput('PSPemeriksaankala4T','kala4_detaknadi');
        renameInput('PSPemeriksaankala4T','kala4_pernapasan');
        renameInput('PSPemeriksaankala4T','kala4_tinggifundus');
        renameInput('PSPemeriksaankala4T','kala4_kontraksi');
        renameInput('PSPemeriksaankala4T','kala4_kandungkemih');
        renameInput('PSPemeriksaankala4T','kala4_darahcc');
    }
    
     function setTabObs(obj, v)
    {
        var liLength = $("#tabberObs li").length; 
        var li = '<li onclick="setTabObs(this, \'+\')"><a href = "javascript:void(0);">+</a></li>';
        var periksaObs = new String(<?php echo CJSON::encode($this->renderPartial('_getFormObs',array('form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modPemeriksaan),true));?>);
        var id = liLength - 1;
                
        $("#tabberObs li").removeClass("active");
        $(obj).addClass("active");        
        
        if (v == 0) {
            for (var i =0;i<liLength;i++){
                $("#obsP"+i+"").hide();
            }
            $("#obsP"+v+"").show();            
        }else if (v=='+') {        
            $(obj).html("<a href = 'javascript:void(0);'>P "+liLength+"</a>");
            $(obj).attr('onclick',"setTabObs(this, "+id+")");
            $(obj).attr('id',"P"+id);
            $('#tabberObs').append(li);   
            $('#periksaOBS').append('<tr id= "obsP'+(id)+'"><td>'+periksaObs.replace()+'</td></tr>');
            
            for (var i =0;i<liLength;i++){
                $("#obsP"+i+"").hide();
            }
            
            $("#obsP"+(liLength-1)+"").show();
            
            renameInputObs('periksaKala4','obsP'+id,id);
            renameInputObs('statusObs','obsP'+id,id);
            renameInputObs('plasenta','obsP'+id,id);
            renameInputObs('taliPusar','obsP'+id,id);
            renameInputObs('perlukaan','obsP'+id,id);
            renameInputObs('pendarahan','obsP'+id,id);
            renameInputObs('nifas','obsP'+id,id);
           // renameInputObs('PSPemeriksaankala4T','kala4_anemia','obsP'+id,id);
           // renameInputObs('PSPemeriksaankala4T','kala4_systolic','obsP'+id,id);
           // renameInputObs('PSPemeriksaankala4T','kala4_diastolic','obsP'+id,id);
           // renameInputObs('PSPemeriksaankala4T','kala4_tekanandarah','obsP'+id,id);
           // renameInputObs('PSPemeriksaankala4T','kala4_meanarteripressure','obsP'+id,id);
          //  renameInputObs('PSPemeriksaankala4T','kala4_detaknadi','obsP'+id,id);
            //renameInputObs('PSPemeriksaankala4T','kala4_pernapasan','obsP'+id,id);
           // renameInputObs('PSPemeriksaankala4T','kala4_tinggifundus','obsP'+id,id);
           // renameInputObs('PSPemeriksaankala4T','kala4_kontraksi','obsP'+id,id);
          //  renameInputObs('PSPemeriksaankala4T','kala4_kandungkemih','obsP'+id,id);
          //  renameInputObs('PSPemeriksaankala4T','kala4_darahcc','obsP'+id,id);
            //$('#periksaKala4 tr:last').find('input[name*="kala4_tanggal"]').val('<?php //echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')); ?>');
            $('#obsP'+id).find('#statusObs tbody tr:last').find('input[name*="pemeriksaanobstetrik_id]"').val('');
            $('#obsP'+id).find('#hapusObs tbody').append("<tr><td><a href = '#' onclick='delTrObs("+id+");' ><i class='icon-form-silang'></i></a></td></tr>");
            $('#obsP'+id).find('#periksaKala4 tbody').each(function(){
            jQuery('input[name$="[kala4_tanggal]"]').datetimepicker(
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
            
            $('#obsP'+id).find('#statusObs tbody').each(function(){
                jQuery('input[name$="[obs_periksadalam]"]').datetimepicker(
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
                jQuery('input[name$="[plasenta_lahir]"]').datetimepicker(
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
                $("#obsP"+i+"").hide();
            }
            $("#obsP"+v+"").show();          
        }
    }
    
    function renameInputObs(obj_table, idAttribute, id)
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
                    
                    if (old_name_arr[3] == 'kala4_systolic'){
                        $(this).attr('onkeyup', 'setTekanan(this, '+id+' , '+i+');').
                                 attr('class', 'span1 numbers-only systolic'+id+i);
                    }
                    if (old_name_arr[3] == 'kala4_diastolic'){
                        $(this).attr('onkeyup', 'setTekanan(this, '+id+' , '+i+');').
                                attr('class', 'span1 numbers-only diastolic'+id+i);
                    }
                    if (old_name_arr[3] == 'kala4_tekanandarah'){
                        $(this).attr('class', 'span2 td'+id+i);
                    }

                    
            
                }else if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+id+"_"+old_name_arr[2]+"");
                    $(this).attr("name",old_name_arr[0]+"["+id+"]["+old_name_arr[2]+"]");          
                }
            });
            $(this).find('#tambahKala4').attr('onclick',"inputKala4(this,"+id+")");
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
    
    function delTrObs(id)
    {
         myConfirm('Apakah Anda yakin ingin membatalkan pemeriksaan obsterikus ini ?','Perhatian!',function(r){
            if (r){
                $("#periksaOBS").find("#obsP"+id).remove();
                $("#tabberObs").find("#P"+id).remove();
           }
        });
	
    }
    
    function ubahNomor(id)
    {
        $("#nomor").val(id);
        $('#dialogObatAlkes').dialog("open");return false;
    }
    
</script>