$(document).ready( function() {
    $("#alertButton").click( function() {
        jAlert('This is a custom alert box', 'Alert Dialog');
        return false;
    });

    $("#confirm_button").click( function() {
        jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
            jAlert('Confirmed: ' + r, 'Confirmation Results');
            return false;


        });
        return false;
    });

    $("#prompt_button").click( function() {
        jPrompt('Type something:', 'Prefilled value', 'Prompt Dialog', function(r) {
            if( r ) alert('You entered ' + r);
            return false;
        });
        return false;
    });

    $("#prompt_button").click( function() {
        jPrompt1('Type something:', 'Prefilled value', 'Prompt Dialog', function(r) {
            if( r ) alert('You entered ' + r);
            return false;
        });
        return false;
    });
	 $("#prompt_button").click( function() {
        jPrompturl('Type something:', 'Prefilled value', 'Prompt Dialog', function(r) {
            if( r ) alert('You entered ' + r);
            return false;
        });
        return false;
    });
    $("#alert_button_with_html").click( function() {
        jAlert('You can use HTML, such as <strong>bold</strong>, <em>italics</em>, and <u>underline</u>!');
        return false;
    });

    $("#alert_style_example").click( function() {
        $.alerts.dialogClass = $(this).attr('id'); // set custom style class
        jAlert('This is the custom class called &ldquo;style_1&rdquo;', 'Custom Styles', function() {
            $.alerts.dialogClass = null; // reset to default
            return false;
        });
        return false;
    });
});

function jspt(ids,myKey,e)
{    
    // alert($('.dynamicDiv').html())
	
	if(ids.indexOf("MATERIAL")>=0)
	{
		/*if(e.keyCode==13)
		{
			$('#loading').show();
			$("body").css("opacity","0.4");
				 $.ajax({
				type: "POST",
				url: "common/materialdes",
				data: "val="+myKey,
				success: function(html) 
				{
					//alert(html);
					$('#loading').hide();
					$("body").css("opacity","1"); 
					var str=html.split('@');
					if(str[0]=='S')
					{
						//alert(str[1]);
						$('#'+ids).parent('td').next('td').children('input').val(str[1]);
					}
					else
					{
						//jAlert(str[1],'Message');
					}
			   //     $('#'+table_id+'_tbody').html(html);
				}
			});
		}*/
	}
    if(e.keyCode==40)
    {
        var downkey=40;
        if($('.dynamicDiv').html()==null)
        {
            downkey=0;
        }
    }
    if((downkey!=40) && (e.keyCode!=38) &&(e.keyCode!=13))
    {
        var chosen = "";
        $(document).keydown(function(e){ // 38-up, 40-down
            if (e.keyCode == 40) { 
                if(chosen === "") {
                    chosen = 0;
                } else if((chosen+1) < $('#'+ids+'fill li').length) {
                    chosen++; 
                }
                $('#'+ids+'fill li').removeClass('selected');
                $('#'+ids+'fill li:eq('+chosen+')').addClass('selected');
                return false;
            }
            if (e.keyCode == 38) { 
                if(chosen === "") {
                    chosen = 0;
                } else if(chosen > 0) {
                    chosen--;            
                }
                $('#'+ids+'fill li').removeClass('selected');
                $('#'+ids+'fill li:eq('+chosen+')').addClass('selected');
                // return false;
            }
        });

        var wtd=$("#"+ids).width();
        var position = $("#"+ids).position();
        // alert('X: ' + position.left + ", Y: " + position.top );
        $('.dynamicDiv').remove();
        //document.getElementById(ids+'_s').appendChild(divTag);
       // $("#"+ids).before("<div class='relative'><div id='"+ids+"fill' class='dynamicDiv'></div></div>");
        $('#'+ids+'fill').html('');

        if($('#'+ids).attr('alt')=='MULTI')
        {
            $('#'+ids+'fill').css({
                width: wtd+'px',
                'margin-left':'10px',
                'margin-top':'25px'
            });
        }
        else
        {
            $('#'+ids+'fill').css({
                width: wtd+'px',
                'margin-top':'25px'
            });
        }
        
        if($.cookie(ids))
        {
            var sd = $.cookie(ids);
            var se = sd.split(',');
            for(i=0;i<=se.length-1;i++)
            {
                var myMatch = se[i].search(myKey);
                if(myMatch != -1)
                {
                    $('#'+ids+'fill').append('<li class="name_ha" name="'+ids+'">'+se[i]+'</li>'); 
                }
            }
        }

        if($('#'+ids+'fill').html()=="")
        {
            $('.dynamicDiv').remove();
        }
        $('.name_ha').hover(function(){
            //alert($(this).text());
            $('li').removeClass('selected');
            $('.name_ha').css({
                background:'',
                color:'#000'
            })
            $(this).addClass('selected');
            $(this).click(function()
            {
                $('#'+ids).val($(this).text());
                $('.dynamicDiv').remove();
            })
        });
        $('#'+ids).focusout(function()
        {
            $('.selected').each(function(index, element) {
                var fq=$('.selected').attr('name');
                $('#'+fq).val($('.selected').text());
                $('.dynamicDiv').remove();
                return false;
            });
            $('.dynamicDiv').remove();
        });
    }
}


//GEZG 09/18/2018
//New function for getting BOM and material description
function getMatDescBOM(ids,element,e,tableName){                        
        var id_append = ids.replace(/[^0-9\.]/g, '');              
        var data="";
        var lineNumber = "";
        var myKey = $(element.parentElement.parentElement).find("input[name='material[]']").val();
        var qty   = $(element.parentElement.parentElement).find("input[name='Order_quantity[]']").val();               
        var freeCharge = $(element.parentElement.parentElement).find("input[name='IS_FREE_CHARGE[]']").prop("checked");        
        if(qty.trim() == ""){
            qty = 0;
        }
        //if material is not set don't do anything
        if(myKey.trim() == ""){            
            return;
        }
        $('#loading').show();
        $("body").css("opacity","0.4");

        if($('#DISTR_CHAN').length>0)
            dcnl=$('#DISTR_CHAN').val();
        else
            dcnl="";            
        if($('#SALES_ORG').length>0)
            sorg=$('#SALES_ORG').val();
        else
            sorg="";
        if($('#PARTN_NUMB').length>0)
            part=$('#PARTN_NUMB').val();
        else
            part="";
        if($('#PARTN_NUMB1').length>0)
            part1=$('#PARTN_NUMB1').val();
        else
            part1="";
        if($('#DOC_TYPE').length>0)
            doc=$('#DOC_TYPE').val();
        else
            doc="";
        
        myKey=encodeURIComponent(myKey);        
        $.ajax({
            type: "POST",
            url: "common/materialbom",
            data: "val="+myKey+"&dcnl="+dcnl+"&sorg="+sorg+"&part="+part+"&part1="+part1+"&doc="+doc+"&qty="+qty,
            success: function(response) 
            {                                                           
                var headerCurrency = $("#HEAD_CURRENCY").val();
                var parentRow = $("#MATERIAL"+id_append).closest("tr");
                var incRowNumber = 0;
                if(id_append == ""){
                    currentRowNumber = 0;
                }else{
                    currentRowNumber = id_append/10;
                }
                currentLineItem = id_append;
                response = JSON.parse(response);                
                if(response.isSuccess)
                {
                    var parentLineNumber = "";
                    var pad = "000000";
                    var currentChild = false;                    
                    //$('#'+ids).parent('td').next('td').children('input').val(str[1]);
                    $('#SHORT_TEXT'+id_append).val(response.data.matDesc);
                    $('#TARGET_QU'+id_append).val(response.data.su);
                    $('#NET_PRICE'+id_append).val((freeCharge == true)?0:response.data.matPrice);
                    $('#COND_VALUE'+id_append).val(response.data.matPrice);
                    $('#COND_P_UNT'+id_append).val((freeCharge == true)?0:response.data.matPer);
                    $('#KONWA'+id_append).val(headerCurrency);
                    $('#CURRENCY'+id_append).val(response.data.matCur);
                    $('#PLANT'+id_append).val(response.data.matPlant);                
                    $('#COND_UNIT'+id_append).val(response.data.uom);                
                    if(response.data.components != undefined && response.data.components.length > 0){
                       parentRow.addClass("parentBOM");
                       $('#ITEM_CATEG'+id_append).val("ZTAQ");     
                       parentLineNumber = $("#ITM_NUMBER"+id_append).val();
                       $('#REQ_QTY'+id_append).val(1);                       
                        $('#REQ_QTY'+id_append).attr("onfocus","saveOrigQty(this.value)");
                       $('#REQ_QTY'+id_append).attr("onchange","calcItemsQty('"+((id_append!=""?parseInt(id_append):0)+incRowNumber+10)+"',this)");
                    }else{
                        currentChild = parentRow.hasClass("childBOM");
                        if($('#COND_P_UNT'+id_append).val() == ""){
                            $('#COND_P_UNT'+id_append).val(0);
                        }
                        if($('#NET_PRICE'+id_append).val() == ""){
                            $('#NET_PRICE'+id_append).val(0);
                        }

                    }
                    
                    if(response.data.components != undefined)
                    {
                        for(var i=0; i<response.data.components.length; i++){                        
                            incRowNumber++;
                            parentRow.after("<tr onclick='select_row(\"ids_"+currentRowNumber+"_"+incRowNumber+"\")' class='ids_"+currentRowNumber+"_"+incRowNumber+"'>"+parentRow[0].innerHTML+"</tr>");                                                
                            parentRow = parentRow.next();
                            parentRow.addClass("component_"+((id_append != ""?parseInt(id_append):0)+10).toString());
                            parentRow.addClass("childBOM");
                            component = response.data.components[i];
                            //Setting propertyes for new elements
                            itemNumberRow   = parentRow.find("#ITM_NUMBER"+currentLineItem)[0];  
                            matRow          = parentRow.find("#MATERIAL"+currentLineItem)[0];   
                            shorTextRow     = parentRow.find("#SHORT_TEXT"+currentLineItem)[0];   
                            targetQtyRow    = parentRow.find("#TARGET_QU"+currentLineItem)[0];   
                            netPriceRow     = parentRow.find("#NET_PRICE"+currentLineItem)[0];                           
                            condPUnitRow    = parentRow.find("#COND_P_UNT"+currentLineItem)[0];
                            konwaRow        = parentRow.find("#KONWA"+currentLineItem)[0];                       
                            plantRow        = parentRow.find("#PLANT"+currentLineItem)[0];                       
                            itemTextRow     = parentRow.find("#ITEM_TEXT"+currentLineItem)[0];
                            salesTextRow    = parentRow.find("#SALES_TEXT"+currentLineItem)[0];
                            isFreeChargeRow = parentRow.find("#IS_FREE_CHARGE"+currentLineItem)[0];
                            freeChargeRow   = parentRow.find("#FREE_CHARGE"+currentLineItem)[0];
                            reqQtyRow       = parentRow.find("#REQ_QTY"+currentLineItem)[0];
                            isComponentRow  = parentRow.find("#IS_COMPONENT"+currentLineItem)[0];
                            itemCategRow    = parentRow.find("#ITEM_CATEG"+currentLineItem)[0];
                            highLevelRow    = parentRow.find("#HIGH_LEVEL_ITEM"+currentLineItem)[0];
                            condUnitRow     = parentRow.find("#COND_UNIT"+currentLineItem)[0];
                            if(currentLineItem == ""){
                                currentLineItem = 0;
                            }
                            currentLineItem++;                        
                            //Setting IDS                        
                            itemNumberRow.id    = "ITM_NUMBER"+currentLineItem;
                            matRow.id           = "MATERIAL"+currentLineItem;
                            shorTextRow.id      = "SHORT_TEXT"+currentLineItem;
                            targetQtyRow.id     = "TARGET_QU"+currentLineItem;
                            netPriceRow.id      = "NET_PRICE"+currentLineItem;                        
                            condPUnitRow.id     = "COND_P_UNT"+currentLineItem;
                            konwaRow.id         = "KONWA"+currentLineItem;                        
                            plantRow.id         = "PLANT"+currentLineItem;                        
                            itemTextRow.id      = "ITEM_TEXT"+currentLineItem;
                            salesTextRow.id     = "SALES_TEXT"+currentLineItem;   
                            isFreeChargeRow.id  = "IS_FREE_CHARGE"+currentLineItem;
                            freeChargeRow.id    = "FREE_CHARGE"+currentLineItem;                        
                            reqQtyRow.id        = "REQ_QTY"+currentLineItem;
                            isComponentRow.id   = "IS_COMPONENT"+currentLineItem;
                            itemCategRow.id     = "ITEM_CATEG"+currentLineItem;
                            highLevelRow.id     = "HIGH_LEVEL_ITEM"+currentLineItem;
                            condUnitRow.id      = "COND_UNIT"+currentLineItem;
    
                            //Setting values
                            itemNumberRow.value    = (id_append!=""?parseInt(id_append):0)+incRowNumber+10;
                            matRow.value           = component.matNumber;
                            shorTextRow.value      = component.matDesc;
                            targetQtyRow.value     = component.su;
                            netPriceRow.value      = component.matPrice;
                            condPUnitRow.value     = component.matPer;
                            konwaRow.value         = headerCurrency; 
                            plantRow.value         = component.matPlant;                                              
                            reqQtyRow.value        = component.matQty;
                            condUnitRow.value      = component.uom;
                            isComponentRow.value   = "1";                        
                            itemCategRow.value     = "ZTAE";    
                            highLevelRow.value     =  pad.substring(0,pad.length - parentLineNumber.length)+parentLineNumber;    
                            reqQtyRow.classList.add("reqQty_"+((id_append != ""?parseInt(id_append):0)+10).toString());
    
                            //Updating events
                            $(matRow).attr("onchange","getMatDescBOM('MATERIAL"+currentLineItem+"',this.value,event,'dataTable')");
                            $(matRow).attr("onkeyup","jspt('MATERIAL"+currentLineItem+"',this.value,event)");
                            $(matRow).next().attr("onclick","lookup('Material', 'MATERIAL"+currentLineItem+"', 'material')");
                            $(reqQtyRow).removeAttr("onfocus");
                            $(reqQtyRow).removeAttr("onchange");
                            $(reqQtyRow).attr("onkeyup","jspt('REQ_QTY"+currentLineItem+"',this.value,event)");
                            $(targetQtyRow).attr("onkeyup","jspt('TARGET_QU"+currentLineItem+"',this.value,event)");
                            $(shorTextRow).attr("onkeyup","jspt('SHORT_TEXT"+currentLineItem+"',this.value,event)");
                            $(netPriceRow).attr("onkeyup","jspt('NET_PRICE"+currentLineItem+"',this.value,event)");
                            $(condPUnitRow).attr("onkeyup","jspt('COND_P_UNT"+currentLineItem+"',this.value,event)");
                            $(konwaRow).attr("onkeyup","jspt('KONWA"+currentLineItem+"',this.value,event)");
                            $(plantRow).attr("onkeyup","jspt('PLANT"+currentLineItem+"',this.value,event)");
                            $(plantRow).next().attr("onclick","lookup_plant('PLANT', 'PLANT"+currentLineItem+"')");
                            $(condUnitRow).next().attr("onclick","lookup('UOM', 'COND_UNIT"+currentLineItem+"', 'uom')");
                            $(plantRow).attr("onchange","setChildPlant(this)");
                            $(targetQtyRow).next().attr("onclick","lookup('SU', 'TARGET_QU"+currentLineItem+"', 'uom')");
                            $(itemTextRow).next().attr("onclick","enterText('ITEM_TEXT', '"+currentLineItem+"')");
                            $(salesTextRow).next().attr("onclick","enterText('SALES_TEXT', '"+currentLineItem+"')");
                        }
                    }

                    $('#loading').hide();                        
                    $("body").css("opacity","1");                    
                }
                else
                {   
                    jAlert(response.message,'Message');
                    $('#MATERIAL'+id_append).val('');
                    $('#MATERIAL'+id_append).focus();
                    $('#loading').hide();                        
                    $("body").css("opacity","1");  
                }
            }
        });
}

function jspt_new(ids,myKey,e)
{    
	var id_append = ids.replace(/[^0-9\.]/g, '');
	if(ids.indexOf("MATERIAL") >= 0 && myKey.trim() != "")
	{
		$('#loading').show();
		$("body").css("opacity","0.4");
		var data="";
		if($('#DISTR_CHAN').length>0)
			dcnl=$('#DISTR_CHAN').val();
		else
			dcnl="";
			
		if($('#SALES_ORG').length>0)
			sorg=$('#SALES_ORG').val();
		else
			sorg="";
		if($('#PARTN_NUMB').length>0)
			part=$('#PARTN_NUMB').val();
		else
			part="";
		if($('#PARTN_NUMB1').length>0)
			part1=$('#PARTN_NUMB1').val();
		else
			part1="";
		if($('#DOC_TYPE').length>0)
			doc=$('#DOC_TYPE').val();
		else
			doc="";	

		myKey=encodeURIComponent(myKey);
		$.ajax({
			type: "POST",
			url: "common/materialdes",
			data: "val="+myKey+"&dcnl="+dcnl+"&sorg="+sorg+"&part="+part+"&part1="+part1+"&doc="+doc,
			success: function(html) 
			{
				//alert(html);				
				var str=html.split('@');
				if(str[0]=='S')
				{
					//$('#'+ids).parent('td').next('td').children('input').val(str[1]);
					$('#SHORT_TEXT'+id_append).val(str[1]);
					$('#TARGET_QU'+id_append).val(str[2]);
					$('#NET_PRICE'+id_append).val(str[3]);
					$('#COND_VALUE'+id_append).val(str[3]);
					$('#COND_P_UNT'+id_append).val(str[4]);
					$('#KONWA'+id_append).val(str[5]);
					$('#CURRENCY'+id_append).val(str[5]);
                    $('#loading').hide();                        
                    $("body").css("opacity","1");                    
				}
				else
				{
					jAlert(str[1],'Message');
					$('#MATERIAL'+id_append).val('');
					$('#MATERIAL'+id_append).focus();
				}
			}
		});
	}else if(ids.indexOf("PARTN_NUMB") >= 0 && myKey.trim() != "")
	{
		$('#loading').show();
		$("body").css("opacity","0.4");
		var data="";
		if($('#PARTN_NUMB').length>0)
			part=$('#PARTN_NUMB').val();
		else
			part="";
		
			
		myKey=encodeURIComponent(myKey);
		$.ajax({
			type: "POST",
			url: "common/soldtoname",
			data: "val="+myKey+"&part="+part,
			success: function(html) 
			{
				//alert(html);
				$('#loading').hide();
				$("body").css("opacity","1"); 
				var str=html.split('@');
				if(str[0]=='S')
				{
					//$('#'+ids).parent('td').next('td').children('input').val(str[1]);
					if($('#SALES_ORG').length>0)
						$('#SALES_ORG').html(str[1]);
					if($('#DISTR_CHAN').length>0)
						$('#DISTR_CHAN').html(str[2]);
					$('#SOLD_NAME').html(str[3]);
					$('#LANGUAGE').val(str[4]);
                    $('#PMNTTERMS').val(str[5]);
                    $('#ZTERM_DESC').val(str[6]);                    
				
                }
				else
				{
					jAlert(str[1],'Message');
					$('#PARTN_NUMB').val('');
					$('#PARTN_NUMB').focus();
				}
			}
		});
	}
}

function enterText(type,ids){
	if(type=='HEADER_TEXT')
		var name="HEADER_TEXT";
	else
		var name=type+ids;
	/*if(type!='HEADER_TEXT')
		type='ITEM_TEXT';*/
	$('#loading').show();
    $('#block-ui').show();
    $("body").css("opacity","0.4");
    $("body").css("filter","alpha(opacity=40)");
	$('#loading').hide();
    $("body").css("opacity","1");
	var tarea_val=$("#"+name).val();		
	var divs='<div id="as">';
    divs +='<input type="button" value="" class="c_bt tip_cls" onClick="clse()" id="clse"/>';
    divs +='<div id="title">'+type+'<span class="swip">Swipe to Scroll</span></div>';
	if ( $('#edit_salesorder').css('display') == 'inline-block' )
	{
	divs +='<div id="dialog" onscroll="scrt()"><textarea style="width:95%;height:90%" id="T_AREA" readonly name="'+name+'">'+tarea_val+'</textarea></div>';
    divs +='<input type="button" value="<?php echo _BACK ?>" class="c_bb" id="back_its" style="display:none;"/>';
    }else
	{
	divs +='<div id="dialog" onscroll="scrt()"><textarea style="width:95%;height:90%" id="T_AREA"  name="'+name+'">'+tarea_val+'</textarea></div>';
    divs +='<input type="button" value="<?php echo _BACK ?>" class="c_bb" id="back_its" style="display:none;"/>';
    divs +='<input type="button" value="Save" class="c_bt" onClick="saveData(\'T_AREA\',\''+name+'\');"  id="sub_ok" style="display:none;"/></div>';	
	}
	$('#tarea').show();
    $('#tarea').html(divs);
    $('#back_its').hide();
    $('#sub_ok').show();
	$('#as').show();
	 $('#title').mouseover(function ()
    {
        $('#as').draggable();
    });
    $('#title').mouseout(function ()
    {
        $('#as').draggable("destroy");
    });		
}

function enterValue(type,ids){
    var name=type+ids;
    $('#loading').show();
    $('#block-ui').show();
    $("body").css("opacity","0.4");
    $("body").css("filter","alpha(opacity=40)");
    $('#loading').hide();
    $("body").css("opacity","1");
    var tarea_val=$("#"+name).val();        
    var divs='<div id="vlsl" >';
    divs +='<input type="button" value="" class="c_bt tip_cls" onClick="clse()" id="clse" style="position:relative;right:20px" />';
    divs +='<div id="title">'+type+'<span class="swip">Swipe to Scroll</span></div>';
    if ( $('#edit_salesorder').css('display') == 'inline-block' )
    {
    divs +='<div id="dialog" style="height:50px !important; width:90% !important; position:relative; top:20px" onscroll="scrt()">'+
            '<input readonly type="text" style="width:40%;" id="T_AREA"  name="'+name+'" value="'+tarea_val+'" /> <b>%</b> </div>';
    divs +='<input type="button" value="<?php echo _BACK ?>" class="c_bb" id="back_its" style="display:none;"/>';
    }else
    {
    divs +='<div id="dialog" style="height:50px !important; width:70% !important; position:relative; top:20px" onscroll="scrt()">'+
            '<input type="text" style="width:40%;" id="T_AREA"  name="'+name+'" value="'+tarea_val+'" /> <b>%</b> </div>';
    divs +='<input type="button" value="<?php echo _BACK ?>" class="c_bb" id="back_its" style="display:none;"/>';
    divs +='<input type="button" value="Save" class="c_bt" onClick="saveData(\'T_AREA\',\''+name+'\');"  id="sub_ok" style="display:none;"/></div>';    
    }
    $('#tarea').show();
    $('#tarea').html(divs);
    $('#back_its').hide();
    $('#sub_ok').show();
    $('#vlsl').show();
     $('#title').mouseover(function ()
    {
        $('#vlsl').draggable();
    });
    $('#title').mouseout(function ()
    {
        $('#vlsl').draggable("destroy");
    });     
}
function saveData(ids,val)
{
    $('#'+val).val($('#'+ids).val());
    if($('#as').length){
        $('#as').remove();
    }
    else{
        $('#vlsl').remove();
    }
    
    $('#tarea').hide('slow');	
    $('#block-ui').hide();
}
 function clse()
 {
 $('#as').remove();
        $('#tarea').hide('slow');	
		$('#block-ui').hide();
}


var parentOriginalQty = 0;
function saveOrigQty(qty){
    parentOriginalQty = qty;
} 

function calcItemsQty(line,item){ 
 if(isNaN(item.value) || item.value.trim() == ""){
    item.value = 1;
 }
 var value = item.value;
 var itemsQty = $(".reqQty_"+line);
 for(var i=0; i<itemsQty.length; i++){
    if(!isNaN(itemsQty[i].value)){
        itemsQty[i].value = (parseInt(itemsQty[i].value)/parentOriginalQty) * parseInt(value);
    }
 }
}

function getPaymentTermDesc(paymentTerm){        
    $('#loading').show();
    $("body").css("opacity","0.4");
    $.post('common/getPaymentTermDesc',{paymentTerm:paymentTerm},function(rs){
        var response = JSON.parse(rs);
        if(response.success){
            $("#ZTERM_DESC").val(response.value);
        }
        else{
            jAlert(response.message,'Message');
        }
        $('#loading').hide();                        
        $("body").css("opacity","1"); 
    });
}


//GEZG 02/11/2019
//Function to set plant field for children components when parent plant changes
//Also check that material exists in selected plant
function setChildPlant(plantInput){
    if(plantInput.value.trim() != ""){
        $('#loading').show();
        $('#block-ui').show();
        $("body").css("opacity","0.4");
        $("body").css("filter","alpha(opacity=40)");
        $.post("common/plantMaterialCheck",{            
            material:$(plantInput.closest("tr")).find("input[name='material[]']").val().toUpperCase(),
            plant:plantInput.value.trim()
        },function(rs){
            try{
                var response = JSON.parse(rs);
                if(response.message.trim() != ""){
                    jAlert(response.message,"Error");
                    plantInput.value="";   
                }                                
            }finally{
                if(plantInput.closest("tr").classList.contains("parentBOM")){
                    var parentItem = $(plantInput.closest("tr")).find("input[name='item[]']").val();
                    $(".component_"+parentItem+" input[name='Plant[]']").val(plantInput.value);
                }
                $('#loading').hide();
                $('#block-ui').hide()
                $("body").css("opacity","1");
            }            
        });
        
    }
}

//GEZG 04/05/2019
//On selecting header currency set currency of all line items
function setLinesCurrency(headCurrency){
    $("input[name='Currency[]']").val(headCurrency);
}