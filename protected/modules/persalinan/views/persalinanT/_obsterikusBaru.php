<fieldset id="panel-obs" hidden>
    <?php 
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
            'stacked'=>false, // whether this is a stacked menu
            'items'=>array(
                array('label'=>'P 1', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabObs(this, 0);'), 'active'=>true),
                array('label'=>'+', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTabObs(this, "+");')),                
               // array('label'=>'Pemeriksaan Partograf', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this, 4);')),
            ),
            'htmlOptions'=>array(
                'id'=>'tabberObs',
            )
        ));
    
    ?>
        <?php $this->renderPartial('_pemeriksaanObs', array('form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modPemeriksaan)); ?>
    
</fieldset>
            
            
<script>
    function inputKala4(obj){
        
	var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRowKala4(this); return false;')) ?>';
        //var tr = $('#periksaKala4 tbody tr:first').html();	
        var tr = new String(<?php echo CJSON::encode($this->renderPartial('_getFormKala4',array('form'=>$form,'modPeriksaKala4' => $modPeriksaKala4, 'modPemeriksaan'=>$modPemeriksaan),true));?>);
                
        //$('#periksaKala4 tr:last').after('<tr>'+tr+'</tr>');
        
        $(obj).parents('table').children('tbody').append(tr.replace());
        $('#periksaKala4 tr:last td:last').append(buttonMinus);
        
        
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
        
        $('#periksaKala4 tr:last').find('input').val('');
        $('#periksaKala4 tr:last').find('input[name*="kala4_tanggal"]').val('<?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')); ?>');
        
        $('#periksaKala4 tbody').each(function(){
        jQuery('input[name$="[kala4_tanggal]"]').datetimepicker(
			jQuery.extend(
				{showMonthAfterYear:true},
				jQuery.datepicker.regional['id'],
				{
					'dateFormat':'<?php echo Params::DATE_FORMAT; ?>',
					'changeYear':true,
					'changeMonth':true,
					'showAnim':'fold',
					'maxDate':'d'
				}
			)
		);
        });
        //renameInput('PSPemeriksaankala4T','kala4_');                                
    }
    
    function renameInput(modelName,attributeName)
    {
        var trLength = $('#periksaKala4 tbody tr').length;
        var i = 0;
        $('#periksaKala4 tbody tr').each(function(){
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'[0]['+i+']['+attributeName+']').attr('id',modelName+'_0_'+i+'_'+attributeName+'');     //PSPemeriksaankala4T_0_0_kala4_anemia       
            $(this).find('span[id*="'+attributeName+'"]').attr('id',modelName+'_0_'+i+'_'+attributeName+'_date');                        
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
        var li = '<li onclick="setTabObs(this, '+liLength+')"><a href = "javascript:void(0);">+</a></li>';
        $("#tabberObs li").removeClass("active");
        $(obj).addClass("active");
                
        
        if (v == 0) {
            $("#p0").show();            
        }else if (v='+') {
            $('#tabberObs li:last').append(li);
            alert(li);
        }
    }
    
</script>