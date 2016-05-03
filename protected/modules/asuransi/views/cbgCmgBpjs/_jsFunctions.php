<script type="text/javascript">
function cariDataDiagnosa(){
	var katakunci = $('#katakunci_diagnosa').val();
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(katakunci != ''){
		var isi = katakunci;
		var aksi = 4; // 1 untuk mencari data peserta diagnosa
	}
	
    if (isi=="") {myAlert('Isi Kata Kunci terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#data-diagnosa").addClass("animation-loading");
        },
        success: function(data){
            $("#data-diagnosa").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
				var peserta = obj.response;
				$("#kodeDiagnosa").text(peserta.kodeDiagnosa);
				$("#namaDiagnosa").text(peserta.namaDiagnosa);
				$("#pencarian-diagnosa-cbg-cmg-form .btn-primary-blue").removeAttr('disabled',true);			
				// OVERWRITES old selecor
				jQuery.expr[':'].contains = function(a, i, m) {
				  return jQuery(a).text().toUpperCase()
					  .indexOf(m[3].toUpperCase()) >= 0;
				};
            }else{
              myAlert(obj.metaData.message);
            }
        },
        error: function(data){
            $("#data-diagnosa").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function cariDataCBG(){
	var katakunci = $('#katakunci_cbg').val();
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(katakunci != ''){
		var isi = katakunci;
		var aksi = 5; // 1 untuk mencari data peserta CBG
	}
	
    if (isi=="") {myAlert('Isi Kata Kunci terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#data-cbg").addClass("animation-loading");
        },
        success: function(data){
            $("#data-cbg").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
				var peserta = obj.response;
				$("#kodeProsedur").text(peserta.kodeProsedur);
				$("#namaProsedur").text(peserta.namaProsedur);
				$("#pencarian-diagnosa-cbg-cmg-form .btn-primary-blue").removeAttr('disabled',true);			
				// OVERWRITES old selecor
				jQuery.expr[':'].contains = function(a, i, m) {
				  return jQuery(a).text().toUpperCase()
					  .indexOf(m[3].toUpperCase()) >= 0;
				};
            }else{
              myAlert(obj.metaData.message);
            }
        },
        error: function(data){
            $("#data-cbg").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function cariDataCMG(){
    $("#kodeCMG, #kodeGrup, #namaCMG").val("");
	var katakunci = $('#katakunci_cmg').val();
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(katakunci != ''){
		var isi = katakunci;
		var aksi = 6; // 1 untuk mencari data peserta CMG
	}
	
    if (isi=="") {myAlert('Isi Kata Kunci terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#data-cmg").addClass("animation-loading");
        },
        success: function(data){
            $("#data-cmg").removeClass("animation-loading");
            var obj = JSON.parse(data);
            
            /* if(obj.response!=null){
				var peserta = obj.response;
				$("#kodeCMG").text(peserta.kodeCMG);
				$("#kodeGrup").text(peserta.kodeGrup);
				$("#namaCMG").text(peserta.namaCMG);
				$("#pencarian-diagnosa-cbg-cmg-form .btn-primary-blue").removeAttr('disabled',true);
				// OVERWRITES old selecor
				jQuery.expr[':'].contains = function(a, i, m) {
				  return jQuery(a).text().toUpperCase()
					  .indexOf(m[3].toUpperCase()) >= 0;
				}; */
            console.log(obj);
            if (obj.length != 0) {
                $("#kodeCMG").text(obj[0].code);
		$("#kodeGrup").text(obj[0].group_code);
		$("#namaCMG").text("");
		$("#pencarian-diagnosa-cbg-cmg-form .btn-primary-blue").removeAttr('disabled',true);
            }else{
                myAlert(obj.metaData.message);
            }
        },
        error: function(data){
            $("#data-cmg").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function printData(caraPrint){
	var diagnosa = $('#katakunci_diagnosa').val();
	var cmg = $('#katakunci_cmg').val();
	var cbg = $('#katakunci_cbg').val();
	window.open('<?php echo $this->createUrl('PrintData'); ?>&diagnosa='+diagnosa+'&cmg='+cmg+'&cbg='+cbg+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).each(function(){

});
</script>