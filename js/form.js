/**import maskMoney dari extensions/moneymask*/
//document.writeln("<script type='text/javascript' src='js/jquery.maskMoney.js'></script>");
//document.writeln("<script type='text/javascript' src='js/jquery.maskedinput.js'></script>");
//document.writeln("<script type='text/javascript' src='js/realtimeClock.js'></script>");
//document.writeln("<script type='text/javascript' src='js/accounting.js'></script>");
/**
 * Dihapus / sudah tidak digunakan
 * digantikan : focusNextInputField
 */
function nextFocus(obj,evt,next_id,before_id)
{    
    console.log("Function nextFocus() sudah tidak digunakan lagi. Gunakan focusNextInputField !");
}
/**
 * Dihapus / sudah tidak digunakan
 * digantikan : focusNextInputField
 */
$.fn.nextFocus = function() {
    console.log("Function nextFocus() sudah tidak digunakan lagi. Gunakan focusNextInputField !");
};

/**
 * untuk next focus jika ditekan enter
 * @param {type} evt
 * @returns {Boolean|$.fn@call;each}
 */
$.fn.focusNextInputField = function(evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
     if(charCode == 13){
        return this.each(function() {
            var fields = $(this).parents('form:eq(0),body').find('button,input,textarea,select,link,checkbox').not('[type=hidden],[readonly]').not(':hidden').not(':disabled');
                var index = fields.index( this );
                if ( index > -1 && ( index + 1 ) < fields.length ) {
                    fields.eq( index + 1 ).focus();
                    fields.eq( index + 1 ).select();
                }
                return false;
        });
            return false;
        }
//        charCode == 40 ||
        else if ( charCode == 34) { //arrow down || pg down
            return this.each(function() {
            var fields = $(this).parents('form:eq(0),body').find('button,input,textarea,link,checkbox').not('[type=hidden]');
            var index = fields.index( this );
            if ( index > -1 && ( index + 1 ) < fields.length ) {
                fields.eq( index + 1 ).focus();
                fields.eq( index + 1 ).select();
            }
            return false;
        });
            return false;
        }
//        charCode == 38 || 
        else if (charCode == 33) { //arrow down || pg down
            return this.each(function() {
            var fields = $(this).parents('form:eq(0),body').find('button,input,textarea,link,checkbox').not('[type=hidden]');
            var index = fields.index( this );
            if ( index > -1 && ( index + 1 ) < fields.length ) {
                fields.eq( index - 1 ).focus();
                fields.eq( index + 1 ).select();
            }
            return false;
        });
            return false;
        }
};
/**
 * untuk mencegah tombol enter ditekan (return false)
 * @param {type} e
 * @returns {Boolean}
 */
function disableKeyPress(e)
{
     var key;     
     if(window.event)
     {
        key = window.event.keyCode; //IE
     }  
     else{
         key = e.which; //firefox
     }
     
     if(key != 13)
     {
         return true;
     }else{
         if((e.target.type == 'textarea'))
         {
             return (e.shiftKey);
         }else{
             return false;
         }         
     }
}
/**
 * Submit form untuk tombol submit jika ditekan enter / klik
 * @param {type} obj <button>
 * @param {type} evt
 * @returns {undefined}
 */
function formSubmit(obj,evt)
{
     evt = (evt) ? evt : event;
     var form_id = $(obj).closest('form').attr('id');
     var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
     if(charCode == 13){
        if(requiredCheck($(obj).parents('form'))){
            document.getElementById(form_id).submit();
			disableOnSubmit(obj);
        }
     }
     return false;
}

/**
 * Mengecek element bernilai kosong dengan label yg memiliki class "required"
 * @param {type} <form>
 * @returns {Boolean}
 */
function requiredCheck(obj){
    var kosong = 0;
    $(obj).find('input,select,textarea').each(function(){
        if($(this).parents(".control-group").find("label").hasClass('required') === true ){
            $(this).parents(".control-group").removeClass("error").removeClass("success");
        }
    });
    $(obj).find('input,select,textarea').each(function(){
        if($(this).parents(".control-group").find("label").hasClass('required') === true || $(this).hasClass('required')){
            if(($(this).val() === "")){
                if($(this).is(":hidden")){ //untuk element type:hidden 
                    var radio_checked = false;
                    $(this).parent().find(".radio").each(function(){ //mengecek element radio button
                        if($(this).find("input").is(":checked")){
                            radio_checked = true;
                        }
                    });
                    if(radio_checked == false){
                        $(this).parents(".control-group").addClass("error");
                        $(this).addClass("error");
                        kosong ++;
                    }else{
                        $(this).parents(".control-group").removeClass("error");
                        $(this).removeClass("error");
                    }
                }else{
                    $(this).parents(".control-group").addClass("error");
                    $(this).addClass("error");
                    kosong ++;
                }
            }else{
                $(this).parents(".control-group").removeClass("error");
				$(this).removeClass("error");
            }
        }
    });
    if(kosong > 0){
        myAlert("Silahkan isi yang bertanda bintang <span class='required'>*</span> !");//("+kosong+" input)
        return false;
    }else{
        disableOnSubmit($(obj).find("button[type='submit']"));
        return true;
    }
}
function toggleAccordion(obj){
    
}
/**
 * remove / replace button / link ketika submit
 * untuk menghindari multiple submit
 * @param {type} obj
 * @returns {undefined}
 */
function disableOnSubmit(obj){
	$(obj).parent().html('<span class="animation-loading-1" style="display: block; height:32px; vertical-align:"></span>');
	$('.float').each(function(){
		$(this).val(unformatNumber($(this).val()));
	});
	$('.integer').each(function(){
		$(this).val(unformatNumber($(this).val()));
	});
}

/**
 * untuk refresh halaman dari tombol (link) ulang
 * @param {type} obj
 * @returns {undefined}
 */
function refreshForm(obj){
	myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = $(obj).attr("href");});
	return false;
}

/**
 * Refresh form element
 * RND-5940
 * @param {type} param
 */
function resetElement(){
	$("label.refreshable").each(function(){
		$(this).attr('title','Klik untuk refresh ini');
		$(this).attr('rel','tooltip');
		$(this).append('<i class="icon-refresh"></i> ');
		$(this).tooltip();
	});
	$("label.refreshable").click(function(){
		var control = $(this).parent();
		control.addClass('animation-loading-1');
		var element_id = $(this).parent().find('input,textarea,select').attr('id');
		$.ajax({
            type:'GET',
            url:window.location.href,
			success: function (jqXHR, textStatus, errorThrown) {
				control.removeClass('animation-loading-1');
				var elemenbaru = $(jqXHR).find("#"+element_id).html();
				$("#"+element_id).html(elemenbaru);
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); control.removeClass('animation-loading-1');}
        });
	});
}
/**
 * filter karakter selain number
 */
function setNumbersOnly(obj){
	var d = $(obj).attr('numeric');
	var value = $(obj).val();
	var orignalValue = value;
	value = value.replace(/[0-9]*/g, "");
	var msg = "Only Integer Values allowed.";

	if (d == 'decimal') {
	value = value.replace(/\./, "");
	msg = "Only Numeric Values allowed.";
	}

	if (value != '') {
		orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
		$(obj).val(orignalValue);
	}
}

/**
 * Set functions on ready windows 
 */
$( document ).ready(function(){
    //numbers-only = input hanya nomor 
    $('.numbers-only').keyup(function() {
        setNumbersOnly(this);
    });
    /**class : all-caps = kapital semua */
    $('.all-caps').keyup(function() {
        var allcaps = $(this).val().toUpperCase();
        $(this).val(allcaps);
    });
    /**class : integer = format integer*/
    $(".integer").maskMoney(
        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
    );
    /**class : float = format float / double (2 angka dibelakang koma)*/
    $(".float").maskMoney(
        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":2}
    );
    /**class : umur = 00 Thn 00 Bln 00 Hr */
    $(".umur").mask("99 Thn 99 Bln 99 Hr");
    /**class : datemask = 00/00/0000 */
    $(".datemask").mask("99/99/9999");
    /**class : datetimemask = 00/00/0000 */
    $(".datetimemask").mask("99/99/9999 99:99:99");
    /** realtime clock */
	if($(".realtime").length > 0){
		setInterval('date_time()', 1000);
	}
    /**
     * set class "required" when accordion show hide
     */
    $(".accordion-heading").click(function(){
        var collapse = false;
        $(this).parent().find(".accordion-body.in.collapse").each(function(){
            collapse = true;
        });
        if(collapse){
            $(this).find(".icon-ok").addClass("icon-minus").removeClass("icon-ok");
            $(this).find(".btn").removeClass("btn-primary");
            $(this).parent().find(".required").addClass("not-required").removeClass("required");
        }else{
            $(this).find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
            $(this).find(".btn").addClass("btn-primary");
            $(this).parent().find(".not-required").addClass("required").removeClass("not-required");
        }
        $(this).parent().find(".control-group.error").removeClass("error");
        $(this).parent().find(".control-group.success").removeClass("success");
    });
    $(".accordion-group").find(".required").addClass("not-required").removeClass("required");
    $(".accordion-group > .accordion-heading").find(".btn").removeClass("btn-primary");
    $(".accordion-group").find(".accordion-body.collapse").each(function(){
        $(this).parent().find("input,select").attr("disabled",true);
    });
    $(".accordion-group").find(".accordion-body.collapse.in").each(function(){
        $(this).find(".not-required").addClass("required").removeClass("not-required");
        $(this).parent().find(".btn").addClass("btn-primary");
        $(this).parent().find(".icon-minus").addClass("icon-ok").removeClass("icon-minus");
        $(this).parent().find("input,select").removeAttr("disabled");
    });
    //tambahkan class 'refreshable' di label
	resetElement();
});


