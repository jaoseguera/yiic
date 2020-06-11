<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/datatable.js"></script><script>

var isSalesPerson = false;

function lookup(title, ctrl, type, scr_id, lo_id,auto_val)
{    
    var values='';
	$('#loading').show();
    $('#block-ui').show();
    $("body").css("opacity","0.4");
    $("body").css("filter","alpha(opacity=40)");
	if(type!='plant' && type!='uom' && type!='sold_to_customer' && type!='vendor' && type!='storgae_loc' && type!='sales_document' && type!='material' && type!='sales_person')
	{
	values=$('#'+ctrl).val();
	if(ctrl=='PARTN_NUMB1')
		values=$('#PARTN_NUMB').val();
	}else
		values='';
	
    if(type == 'sales_person') {
        isSalesPerson = true;
        type = 'sold_to_customer';
    }
    
	if(typeof values == 'undefined')
		values='';
	$.ajax(
    {
        type:'POST', 
		data: 'type='+type,
        url: 'common/lookuptype',
        success: function(response) 
        {
            $('#loading').hide();
            $("body").css("opacity","1");
			data1 = $.parseJSON(response);
			obj = data1.OBJTYPE;
			method = data1.METHOD;
			order = data1.PARAMETER;
			type = data1.FIELD;
			sel = data1.FIELDNAME+'@'+data1.SHLPNAME;
			tipup(obj, method, order, type, title, ctrl, sel,scr_id,lo_id,values);
        }
    });
}

function tipup(obj,method,order,type,title,ids,sel,scr_id,lo_id,values)
{
    // console.log(ids);
    // alert(title);
    var divs='<div id="digs">';
    divs +='<input type="button" value="" class="c_bt tip_cls" id="clse"/>';
    var swipeScroll = '<?=Controller::customize_label(_SWIPESCROLL);?>';
    divs +='<div id="title">'+title+'<span class="swip">'+swipeScroll+'</span></div>';
    divs +='<div id="dialog" onscroll="scrt(\''+title+'\')"></div>';
    divs +='<input type="button" value="<?php echo _BACK ?>" class="c_bb" id="back_it" style="display:none;"/>';
    divs +='<input type="button" value="<?php echo _SELECTITEM?>" class="c_bt" id="ok_it" style="display:none;"/></div>';

    $('#digtss').show();
    $('#digtss').html(divs);
    $('#back_it').hide();
    $('#ok_it').hide();

    document.getElementById('ok_it').onclick=function(){sty(ids,'ok');};
    document.getElementById('clse').onclick=function(){sty(ids,'cancel');};

    $('#digs').show();
    $('#title').mouseover(function ()
    {
        $('#digs').draggable();
    });
    $('#title').mouseout(function ()
    {
        $('#digs').draggable("destroy");
    });

    var val = "";
    if(scr_id!="")
        val = $('#'+scr_id).val()

    // $('#title').html(title+"<span class='swip'>Swipe to Scroll</span>"); 
    $('#dialog').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loader.gif' style='margin-left:45%;margin-top:15%;'>");
    var datastr = 'url=lookup&key=lookup&type='+type+'&order='+order+'&ids='+ids+'&obj='+obj+'&method='+method+'&sel='+sel+'&lo_value='+val+'&lo_id='+lo_id;

    if(isSalesPerson) {
        type = "sales_person";
        isSalesPerson = false;
    }
	
	url='common/lookup';
  $.ajax(
    {
        type:'POST',
        url: url,
        data:datastr,
        success: function(data) 
        {
            $('#dialog').html(data);
            var help_shname = $('#help_shname').val();
            $('#help_submit').click(function(){
			opps(help_shname,type,order,ids,obj,method,sel,values);
         
			});
		
		if(values!='')			
			opps(help_shname,type,order,ids,obj,method,sel,values);
            
        }
    });
    $('#back_it').click(function(e) 
    {	
		tipup(obj,method,order,type,title,ids,sel,'','','');
    });

	
}


function sty(id,type)
{   
    $('#ok_it').hide();
    $('#block-ui').hide();
    if(type=='ok')
    {
		vals = $('#'+id).attr("data-alt");
		$('#'+id).removeAttr("data-alt");
		$('#'+id).val(vals);
        $('#'+id).css(
        {
			color:'#000'
        })
        $('#D'+id).css({
			color:'#000'
        })
        $('#digs').remove();
        $('#digtss').hide('slow');
    }
    else
    {
        //$('#'+id).val(" ");
        $('#'+id).css(
        {
			color:'#000'
        })
        //$('#D'+id).val("");
        $('#D'+id).css({
			color:'#000'
        })
        $('#digs').remove();
        $('#digtss').hide('slow');
    }    
	if(sessionStorage.getItem('lookup_type') == 'MATERIAL' || sessionStorage.getItem('lookup_type') == 'PARTN_NUMB')
		$('#'+id).trigger("change");
    if(id.indexOf("PLANT") == 0){
        setChildPlant($('#'+id)[0]);
    }
}
</script>

<script>

function getLookUpResults(sh,type,para,ids,obj,method,sel,values){
    if(typeof values== 'undefined')
        values='';
    var emails    = new Array();
    var className = new Array();
    var j = 0;
    var vFlag=true;
  
   $(".fut").each(function(){
        var valu=encodeURIComponent($(this).val());
        var alr=$(this).attr('name');
        
        if((alr=='AUART' || alr=='VKORG') &&  $(this).attr('required')=='required' && valu=='' ){
            var salesDoc = '<?=Controller::customize_label(_SALESDOC);?>';
            alert(salesDoc);    
            vFlag=false;
            $("body").css("opacity","1");
            return false;
        }
        else
        {
            emails[j]=encodeURIComponent($(this).val());
            className[j] = $(this).attr('name');
            j++;
        }
    });
    
    if(vFlag)
    {   
    if(type=="material_document_number"){
    if(values!='')
        emails=','+values;
        $('#dialog').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loader.gif' style='margin-left:45%;margin-top:15%;'>");
        var datastr = 'url=help&key=material_doc_lookup&val='+emails+'&em='+className+'&sh='+sh+'&type='+type+'&para='+para+'&ids='+ids+'&obj='+obj+'&method='+method+'&sel='+sel;
        $.ajax(
        {
            type:'POST',
            url: 'common/material_doc_help',
            data:datastr,
            success: function(data)  {
                $('#dialog').html(data);
                $('#ok_it').show();
                $('#back_it').show();
                $("body").css("opacity","1");
            }
        });
    }else{
    if(values!='')        
        emails=values;
        $('#dialog').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loader.gif' style='margin-left:45%;margin-top:15%;'>");
        if((type == "ZTERM" || type == "CURRENCY") && values!=''){
            var datastr = 'url=help&key=search_customers&val='+emails+'&em='+type+'&sh='+sh+'&type='+type+'&para='+para+'&ids='+ids+'&obj='+obj+'&method='+method+'&sel='+sel;
        }
        else if(type=='MATERIAL'){
            var datastr = 'url=help&key=search_material&val='+emails+'&em='+className+'&sh='+sh+'&type='+type+'&para='+para+'&ids='+ids+'&obj='+obj+'&method='+method+'&sel='+sel;
        }
        else if(type=='sales_person'){
            var datastr = 'url=help&key=search_sales_person&val='+emails+'&type=PARTN_NUMB&ids='+ids+'&sel='+sel;
        }
        else if(type!='ship_to_customer'){
            var datastr = 'url=help&key=search_customers&val='+emails+'&em='+className+'&sh='+sh+'&type='+type+'&para='+para+'&ids='+ids+'&obj='+obj+'&method='+method+'&sel='+sel;
        }
        else{
            var datastr = 'url=help&key=shiptoparty&val='+emails+'&em='+className+'&sh='+sh+'&type='+type+'&para='+para+'&ids='+ids+'&obj='+obj+'&method='+method+'&sel='+sel;
       }

        $.ajax(
        {
            type:'POST',
            url: 'common/help',
            data:datastr,
            success: function(data)  {
                $('#dialog').html(data);
                $('#ok_it').show();
                $('#back_it').show();
                $("body").css("opacity","1");
            }
        });
           
    }
    }
}

function opps(sh,type,para,ids,obj,method,sel,values)
{    
    $('#block-ui').show();
    $("body").css("opacity","0.4");
    $("body").css("filter","alpha(opacity=40)");
    var getAccount = false;
    if($("#KTOKD").length){
        getAccount = true;
        var salesOrg = $("input[name='VKORG']")[0].value
    }
    if(getAccount){
        $.post("common/getAccountGroup",{"salesOrg":salesOrg},function(rs){        
            $("#KTOKD").val(rs);
            getLookUpResults(sh,type,para,ids,obj,method,sel,values);   
        });  
    }else{
        getLookUpResults(sh,type,para,ids,obj,method,sel,values);
    }
}

function getval(vals,type,ids,id,dis,event)
{
	/*
	if(type == 'MATERIAL')
    {
        $shortText = id.match(/\d/g);		
		if($shortText == null)
			$shortText = "";
		else
			$shortText = $shortText.join("");
		
		$('#SHORT_TEXT'+$shortText).val(dis);
		$('#TARGET_QU'+$shortText).val('');
    }
	*/
    $('#block-ui').hide();
    $('#df'+ids).click(function()
    {
        $('.ort').css({ background:'' });
        $('#df'+ids).css({ background:'#E1E3FE' });
    });
	
	if(event == 'double')
	{        
		$('#'+id).removeAttr("data-alt");
		$('#'+id).val(vals);
        if(type=="material_document_number"){
            $('#DOC_YEAR').val(dis);
        }
        if(type=="ZTERM"){
            $("#ZTERM_DESC").val(dis);
        }

		//$('#'+id).css({ color:'#fff' });
		$('#digs').hide('slow');
		// $('#dialog').dialog("close");
		$('#ok_it').hide();
		// Ok
		var ids = id;	
		$('#'+ids).css({  color:'#000' });
		$('#D'+id).css({  color:'#000' });
		$('#digs').remove();
		$('#digtss').hide('slow');		
        if(type == 'MATERIAL' || type == 'PARTN_NUMB' || type == 'PLANT')
			$('#'+ids).trigger("change");
			
	}
	else
	{
		$('#'+id).attr("data-alt", vals);
        if(type=="material_document_number"){
            $('#DOC_YEAR').val(dis);
        }
		sessionStorage.setItem('lookup_type', type);
	}
}

function material_doc_lookup(title,ids,type)
{
    // console.log(ids);
    // alert(title);
    $('#block-ui').show();
    var divs='<div id="digs">';
    divs +='<input type="button" value="" class="c_bt tip_cls" id="clse"/>';
    divs +='<div id="title">'+title+'<span class="swip">Swipe to Scroll</span></div>';
    divs +='<div id="dialog" onscroll="scrt_mat(\''+title+'\')"></div>';
    divs +='<input type="button" value="<?php echo _BACK ?>" class="c_bb" id="back_it" style="display:none;"/>';
    divs +='<input type="button" value="<?php echo _SELECTITEM?>" class="c_bt" id="ok_it" style="display:none;"/></div>';

    $('#digtss').show();
    $('#digtss').html(divs);
    $('#back_it').hide();
    $('#ok_it').hide();

    document.getElementById('ok_it').onclick=function(){sty(ids,'ok');};
    document.getElementById('clse').onclick=function(){sty(ids,'cancel');};

    $('#digs').show();
    $('#title').mouseover(function ()
    {
        $('#digs').draggable();
    });
    $('#title').mouseout(function ()
    {
        $('#digs').draggable("destroy");
    });

    // $('#title').html(title+"<span class='swip'>Swipe to Scroll</span>");
    $('#dialog').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loader.gif' style='margin-left:45%;margin-top:15%;'>");
    var datastr = 'url=material_doc_lookup&key=material_doc_lookup';
    $.ajax(
        {
            type:'POST',
            url: 'common/material_doc_lookup',
            data:datastr,
            success: function(data)
            {
                $('#dialog').html(data);
                var help_shname = $('#help_shname').val();
                $('#help_submit').click(function(){
                    opps(help_shname,type,'',ids,'','','');
                });
            }
        });
    $('#back_it').click(function(e)
    {
        material_doc_lookup(title,ids,type)
    });
}

function lookup_plant(title,inputID){   
    if($("#PARTN_NUMB").val().trim() == "" || $("#SALES_ORG").val().trim() == "" ){
       var message = '<?=Controller::customize_label(_SALESDOC);?>';
       alert(message);
       return;    
    }

    var divs='<div id="digs">';
    divs +='<input type="button" value="" class="c_bt tip_cls" id="clse"/>';
    var swipeScroll = '<?=Controller::customize_label(_SWIPESCROLL);?>';
    divs +='<div id="title">'+title+'<span class="swip">'+swipeScroll+'</span></div>';
    divs +='<div id="dialog" onscroll="scrt()"></div>';
    divs +='<input type="button" value="<?php echo _BACK ?>" class="c_bb" id="back_it" style="display:none;"/>';
    divs +='<input type="button" value="<?php echo _SELECTITEM?>" class="c_bt" id="ok_it" style="display:none;"/></div>';

    $('#digtss').show();
    $('#digtss').html(divs);
    $('#back_it').hide();
    $('#ok_it').hide();

    document.getElementById('ok_it').onclick=function(){sty(inputID,'ok');};
    document.getElementById('clse').onclick=function(){sty(inputID,'cancel');};

    $('#digs').show();
    $('#title').mouseover(function ()
    {
        $('#digs').draggable();
    });
    $('#title').mouseout(function ()
    {
        $('#digs').draggable("destroy");
    });
    $('#dialog').html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loader.gif' style='margin-left:45%;margin-top:15%;'>");    
    
    var salesOrg = $("#SALES_ORG").val();
    var distChan = $("#DISTR_CHAN").val();    
    var datastr = 'url=helpPlant&salesOrg='+salesOrg+'&distChan='+distChan+'&ids='+inputID;    
     $.ajax(
        {
            type:'POST',
            url: 'common/helpPlant',
            data:datastr,
            success: function(data)  {                               
                $('#dialog').html(data);
                $('#ok_it').show();                
                $("body").css("opacity","1");                
            }
        });
}

</script>
<div id="digtss" style="display:none;"></div>