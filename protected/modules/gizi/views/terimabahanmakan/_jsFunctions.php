<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.numbersOnly',
        'config' => array(
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => ',',
            'thousands' => '.',
            'precision' => 0,
        )
    ));
?>

<script>
function inputBahanMakanan(){
		unformatNumberSemua();
        var id = $('#idBahan').val();
        var qty= $('#qty').val();
        var ukuran = $('#ukuran').val();
        var merk = $('#merk').val();
        var satuanbahan = $('#satuanbahan').val();
        if (jQuery.isNumeric(id)){
            $.post('<?php echo $urlBahan; ?>',{id:id, qty:qty,ukuran:ukuran,merk:merk, satuanbahan:satuanbahan},function(data){
                $('#tableBahanMakanan tbody').append(data);		
		renameInputRowBahanMakanan('tableBahanMakanan');
                hitungSemua();
                hitungTotalDiscount();	    	
                $("#tableBahanMakanan tbody tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                $("#tableBahanMakanan tbody tr:last .satuanbahan").val(satuanbahan);
				$("#tableBahanMakanan tbody tr:last .tanggal").datepicker(
					jQuery.extend(
						{showMonthAfterYear:true},
						jQuery.datepicker.regional['id'],
						{
							'dateFormat':'dd M yy',
							'changeYear':true,
							'changeMonth':true,
							'showAnim':'fold',
							'yearRange':'-0y:+10y'
						}
					)
				);
				formatNumberSemua();
				$("#qty, #satuanbahan, #namaBahan, #isBahan, #ukuran, #merk").val("");
            });
        }
        else{
            myAlert('Isi Data dengan Benar');
        }
    }
    
    function hitungSemua(){
		unformatNumberSemua();
        value = 0;
        $('.noUrut').each(function(){
            $(this).parents('tr').find('#checkList').attr('name','checkList['+(noUrut-1)+']');
//            $(this).val(noUrut);
//            noUrut++;
            //if ($(this).parents('tr').find('#checkList').is(':checked')){
                val = parseFloat(unformatNumber($(this).parents('tr').find('.subNetto').val()));
                value += val;
            //}
        });
        hitungTotalDiscount();
        $(".total_semua").val(value);
		formatNumberSemua();
    }
	   	
    function hitung(obj){
		//unformatNumberSemua();
        var netto = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[harganettobahan]"]').val()));
        var jml = parseFloat(unformatNumber($(obj).parents('tr').find('input[name$="[qty_terima]"]').val()));
		$(obj).parents('tr').find('.subNetto').val(formatNumber(netto*jml));
		console.log(netto, jml);
		hitungSemua();
        hitungTotalDiscount();
		//formatNumberSemua();
    }
    
    function hapus(obj) {
        $(obj).parents('tr').remove();
        hitungSemua();
    }
    
    function hitungTotal(obj){
		unformatNumberSemua();
        var netto = $('#TerimabahandetailT_harganettobhn').val();
        var jml = $(obj).val();
        $(obj).parents('tr').find('.subNetto').val(netto*jml);
        hitungSemua();
        hitungTotalDiscount();
		formatNumberSemua();
    }
    
    function hitungTotalDiscount(){
		unformatNumberSemua();
        var discountPersen = $('#discountpersen').val();
        var totaldiscount = 0;
            if (jQuery.isNumeric(discountPersen)){
                $('.discount').each(function(){
                    if ($(this).parents('tr').find('.cekList').is(':checked')){
                        var subnetto = $(this).parents('tr').find('.subNetto').val();
                        discount = subnetto*discountPersen/100;
                        $(this).val(discount);
                        totaldiscount+=discount;
                    }
                });
            }
            else{
                $('.discount').each(function(){
                    var discount = parseFloat($(this).val());
                    if ($(this).parents('tr').find('#checkList').is(':checked')){
                        totaldiscount+=discount;
                    }
                });      
            }
		formatNumberSemua();
        $('#GZTerimabahanmakan_totaldiscount').val(formatNumber(totaldiscount));
    }
	
	function renameInputRowBahanMakanan(obj_table){
		var row = 0;
		$('#'+obj_table).find("tbody > tr").each(function(){
		$(this).find("#noUrut").val(row+1);
		$(this).find('input,select,textarea').each(function(){ //element <input>
			var old_name = $(this).attr("name").replace(/]/g,"");
			var old_name_arr = old_name.split("[");
			if(old_name_arr.length == 3){
			$(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
			$(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
			}
		});
		row++;
		});

    }
	
	$(document).ready(function() {
		renameInputRowBahanMakanan('tableBahanMakanan');
		hitung();
		setTimeout(function() {
			$("#tableBahanMakanan tbody tr .tanggal").each(function() {
				$(this).datepicker(
					jQuery.extend(
						{showMonthAfterYear:true},
						jQuery.datepicker.regional['id'],
						{
							'dateFormat':'dd M yy',
							'changeYear':true,
							'changeMonth':true,
							'showAnim':'fold',
							'yearRange':'-0y:+10y'
						}
					)
				);
			});
		}, 500);
		
		$("form").submit(function(){
			supplier = $("#<?php echo CHtml::activeId($model, 'supplier_id'); ?>").val();
			jumlah = 0;
			if (!jQuery.isNumeric(supplier)){
				myAlert("<?php echo CHtml::encode($model->getAttributeLabel('supplier_id')); ?> harus diisi !");
				return false;
			}
			$(".cekList").each(function(){
				if ($(this).is(":checked")){
					jumlah++;
				}
			});

			if (jumlah < 1){
				myAlert("Pilih Nama Bahan Makanan yang akan diajukan !");
				return false;
			}
		});
	});
</script>