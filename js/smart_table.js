// JavaScript Document
//$(function(){
	
//parent.ipad();
//})
function rowShort(Column,thiss,tech,table)
{
	
	
    if(thiss=='L')
    {
        var sor='no-sort';
        var table_id=Column;
    }
    else
    {
        var sor=$(thiss).attr('class');
        var table_id=$(thiss).closest('table').attr('id');
        if(sor=='sorting')
        {
            $('#'+table_id+' thead tr:first-child th').removeClass('sorting_asc').removeClass('sorting_desc').addClass('sorting');
            $(thiss).removeClass('sorting').addClass('sorting_desc');
            var sor=$(thiss).attr('class');
        }
        if(sor=='sorting_desc')
        {
            $(thiss).removeClass('sorting_desc').addClass('sorting_asc');
            var sor=$(thiss).attr('class');
        }
        else
        {
            $(thiss).removeClass('sorting_asc').addClass('sorting_desc');
            var sor=$(thiss).attr('class');
        }
    }
    //alert(sor);

    var t_rows=$('#'+table_id+'_num').html();
    //alert(sor);
    //var tableSess = $('#'+tableId).parent('div').parent('div').closest('div').attr('id');
    //var className  = $('#'+Column).attr('class');
    //showMore = $('#example3_num').text();
    //alert("column="+Column+"&sor="+sor+"&tech="+tech+"&table="+table+"&table_id="+table_id+"&t_rows="+t_rows);
    var datas = "column="+Column+"&sor="+sor+"&tech="+tech+"&table="+table+"&table_id="+table_id+"&t_rows="+t_rows;
	
    $.ajax({
        type: "POST",
        url: "sub_links/table_sort.php",
        data: datas,
        success: function(html) 
        {
            $('#'+table_id+'_tbody').html(html);
        }
    });
}
$(document).ready(function(e) {
    var win_hgt = $(window).height()-90;
    $(window).resize(function(e) {
        $('.table').css({
            width:'100%'
        });
        var wids=$('.table').width();
        if(wids<180)
        {
            wids=$('#out_put').width()-20;
        }
        $('.head_icons').css({
            width:wids+'px'
        });
        if(win_hgt>560){
            $('.main_div').css({
                minHeight:win_hgt+'px'
            });
        }
    });


    var wids=$('.table').width();
    if(wids<180)
    {
        wids=$('#out_put').width()-100;
    }
    $('.head_icons').css({
        width:wids+'px'
    });
    if(win_hgt>560){
    $('.main_div').css({
        minHeight:win_hgt+'px'
    });
    }

});
$(document).ready(function(e) {
	
    if($(window).width()<600)
    {
		
        //$('.edge1').css({width:$('body').width()-120+'px'});
        $.cookie('table_cell','1,');
        $.cookie('table_cell');
        $('.table_cells').show();
		
    }
    if($(window).width()<1030&&$(window).width()>600)
    {
	
	
        //$('.edge').css({width:$('body').width()-2+'px'});
        //$('.edge1').css({width:$('body').width()-150+'px'});
        $.cookie('table_cell','1,2,3,');
	
        $('.table_cells').show();
	
	
    }
    if($(window).width()>1030)
    {
	
        $.cookie('table_cell','1,2,3,4,5,');
    }
    $(window).resize(function() {
        if($(window).width()<1030)
        {
            $('.table_cells').show();
        }
        else
        {
            $('.table_cells').hide();
        }
    })
    if($(window).width()<1030)
    {
        var thwth='';
        $('.nav-tabs').click(function()
        {
		
            thwth +=$('.table tbody td:nth-child(1)').width()+",";
            if($('body').width()<1030&&$('body').width()>600)
            {	
                if (/iPhone/.test(navigator.userAgent)) {
				
                    $('.table tbody td').css({
                        width:'100%'
	 
                    });
                }
                else
                {
                    $('.table tbody td').css({
                        width:'33.3%'
	 
                    });
                }
            }
            else
            {
				
                $('.table tbody td').css({
                    width:'100%'
	 
                });
            }
            var sdw=thwth.split(',');
	
            if(sdw[0]<40)
            {
	
                $('.table th').css({
                    'min-width':'168px'
                });
            }
            else
            {
		
                $('.table th').css({
                    'min-width':sdw[0]-2+'px'
                });
            }
		
		
        });
    }
    if($(window).width()<600)
    {
	
        var inr=1;
        $('.nav-tabs').click(function()
        {
            inr=1;
            var wis=$('.table').width();
            $('.table th, .table tbody td').css({
                display:'none'
            });
            $('.table th:nth-child(1), .table tbody td:nth-child(1)').css({
                display:'table-cell'
            });
            $('.table th:nth-child(1)').css({
                'min-width':'155px'
            });
            $.cookie('table_cell',inr+',');
        })
        $('#next_cell').click(function()
        {
		
            inr=+inr+1;
            $('.table th, .table tbody td').css({
                display:'none'
            });
            $('.table th:nth-child('+inr+'), .table tbody td:nth-child('+inr+')').css({
                display:'table-cell'
            });
        })
        $('#pre_cell').click(function()
        {
		
            inr=+inr-1;
            $('.table th, .table tbody td').css({
                display:'none'
            });
            $('.table th:nth-child('+inr+'), .table tbody td:nth-child('+inr+')').css({
                display:'table-cell'
            });
        })
    }
});
$(document).ready( function () {

		     
    $('.tab-pane').addClass('active');
	
	
    //new FixedHeader( oTable );
    /* Add the events etc before DataTables hides a column */
    $("thead input.search_int").keyup( function () {
        /* Filter on the column (the index) of this element */
        $('#example').dataTable().fnFilter( this.value, $("thead input.search_int").index(this));
    });
    $("thead input.search_int2").keyup( function () {
        /* Filter on the column (the index) of this element */
        $('#example2').dataTable().fnFilter( this.value, $("thead input.search_int2").index(this));
    } );
	
    $("thead input.search_int3").keyup( function () {
		
        /* Filter on the column (the index) of this element */
        $('#example3').dataTable().fnFilter( this.value, $("thead input.search_int3").index(this));
    } );
	
    $("thead input.search_int4").keyup( function () {
		
        /* Filter on the column (the index) of this element */
        $('#example4').dataTable().fnFilter( this.value, $("thead input.search_int4").index(this));
    } );
    /*
     * Support functions to provide a little bit of 'user friendlyness' to the textboxes
     */
  
    $("thead input").focus( function () {
        if ( this.className == "search_init" )
        {
            this.className = "";
            this.value = "";
        }
    } );
    
    
  
	
  
 	

							
} );



function filter(table)
{
    $('#subt').hide();
    $('#filter_id').show();
		
    $('#filter_id').attr('onclick','push_id("'+table+'")');
    var lable="";
			
			
    if($("#fil_left > div[id]").html()==null)
    {
        jQuery("#fil_right > span div[id]").each(function(){
            var id=$(this).attr('id');
            var ids=id.split('_');
            $('#'+table).dataTable().fnFilter('',ids[1]);
        })
				

        //$('#example').dataTable().fnFilter('');
        $('#fil_pop').hide();
    }
    lable +="<table class='sstr' align='center'><tr><th>Lables</th><th>Filter Text</th></tr>";
    jQuery("#fil_left > div[id]").each(function(){
        var context = $(this);
        var inp=context.attr('id');
        lable += "<tr><td>"+context.html()+":</td><td> <input type='text' id='"+inp+"' title='_filterText"+inp+"'></td></tr>";
		
    });
    lable +="</table>"
    $('#cont').show();
    $('#cont').html(lable);
			
    $('#contnt').hide();
			
}
		
function push_id(table)
{
			
    $("#cont").find('input').each(function(){
       
        var ids=this.id;
        var vals=this.value;
        var titile=this.title;
        var colum=ids.split('_');
		
        //$('#'+titile).val(vals);
			
			
        $('#'+table).dataTable().fnFilter(vals,colum[1]);
    //.......................................................................................................................................	
    });
    $('#fil_pop').hide();
}
		
function sort_ch(table)
{
    if(jQuery(".fil_left > div[id]").html()==null)
    {
        jAlert('Minimum One column need to be selected.','Message');			
        return false;
    }
		
    $('#stt').hide();
    $('#st_id').show();
    $('#st_id').attr('onclick','st_id("'+table+'")');
    var lable="";	
		
    if(jQuery(".fil_left > div[id]").html()==null)
    {
        $('#'+table).dataTable().fnSort([[0,'asc']]);
        $('#sort_pop').hide();
    }

    lable +="<table class='sstr' align='center'><tr><th>Lables</th><th>Ascending</th><th>Descending</th></tr>";
    jQuery(".fil_left > div[id]").each(function(){
        var context = $(this);
        var inp=context.attr('id');
        var sty=inp.split('_');
        lable += "<tr><td>"+context.html()+":</td><td> <input type='radio' title='asc' value='"+sty[1]+"' name='"+inp+"'></td><td><input title='desc' type='radio' value='"+sty[1]+"' name='"+inp+"'></td></tr>";
    });
    lable +="</table>";
    $('.cont').show();
    $('.cont').html(lable);
    $('.contnt').hide();

}
		
		


//................................................	

function p_ch(table)
{
	
    var names='';
    var oTable = $('#'+table).dataTable();
    $(".pos_center").find('input:not(:checked)').each(function(){
        var sel=$(this).attr('id');
        var nam=$(this).attr('name');
	 
        var seln=sel.split('_');
        var iCol=seln[1];
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : false);
        names +=nam+',';
    });
    var name=names.split(',');
    var dd=$('.'+table+'_thw').attr('alt');
	
    var datas="hid="+name+"&dd="+dd;
    $.ajax({
        type: "POST",
        url: "table_store.php",
        data: datas,
        success: function(html) {
	
	                               
        }
    });
$(".pos_center").find('input:checked').each(function(){
    var sel=$(this).attr('id');
    var seln=sel.split('_');
    var iCol=seln[1];
    var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
    oTable.fnSetColumnVis( iCol, bVis ? true : true);
});
	
$('.pos_pop').hide();
	
}





function tech(table)
{

    $('.'+table+'_tech').each(function() {
	
        var name=$(this).text();
        nm=name.split('@');
        var ty=$(this).attr('name');
	
        if(ty=='tex')
        {
            $('.'+table+'_'+nm[0]).find('span').each(function() {
                if($(this).hasClass('notdraggable'))
                {
                    $(this).html(nm[1]);
                }
            });
			
            //$('.'+table+'_'+nm[0]).find('span').hasClass('notdraggable').html(nm[1]);
            //$('.'+table+'_'+nm[0]).html(nm[1]);
            $('.'+table+'_'+nm[0]+"_hid1").html(nm[1]);
            $('.'+table+'_'+nm[0]+'_hid').html(nm[1]);
            $(this).attr('name','des');
        //$('#tech').html('Technical Names');
        }
        else
        {
            $('.'+table+'_'+nm[0]).find('span').each(function() {
                if($(this).hasClass('notdraggable'))
                {
                    $(this).html(nm[0]);
                }
            });
            //$('.'+table+'_'+nm[0]).find('span').hasClass('notdraggable').html(nm[0]);
            $('.'+table+'_'+nm[0]+"_hid1").html(nm[0]);
            $('.'+table+'_'+nm[0]+'_hid').html(nm[0]);
            $(this).attr('name','tex');
        //$('#tech').html('Description Names');
        }
    });
}
function eporte(table)
{
    Createpdf(table);
    Createpdfview(table);
    var tap = table.split('_');
    var t_data = '';
    var t_data_pdf = '';
    var full_table = $('#export_table').html();
    
    if($('#head').length > 0)
	{
        t_header = $('#head_table').html();
        t_data = t_header + $('#export_table').html();
        t_data_pdf = t_header + $('#export_table_view_pdf').html();
	}else
	{
		t_data = $('#export_table').html();
		t_data_pdf = $('#export_table_view_pdf').html();
	}
	var datas = "name=" + $('#'+tap[0]).attr('alt') + "&table_data=" + t_data + "&table_data_pdf="         +            t_data_pdf + "&full_table=" + full_table;
    
    $.ajax({
        type: "POST",
        url: $('#excelAjax').val(),
        data: datas,
        success: function(html) {
        }
    })
	
    $('.excel_link').attr("onClick","excel('"+table+"')");
    $('.csv_link').attr("onClick","csv('"+table+"')");
	
    $('.excel_view').attr("onClick","excel_view('"+table+"')");
    $('.csv_view').attr("onClick","csv_view('"+table+"')");
	
    $('#exp_pop').toggle();
    $('#exp_pop').mouseleave(function() {
        $('#exp_pop').hide();
    });
}
function pdf(table)
{

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    // Createpdf(table);
    $("body").css("filter","alpha(opacity=40)");
    var tap=table.split('_'); 
    var datas="name="+$('#'+tap[0]).attr('alt')+"&table_data="+$('#export_table').html();
    $.ajax({
        type: "POST",
        url: $('#excelAjax').val(),
        data: datas,
        success: function(html) {
		  
            if($(window).width()<1030)
            {
			
                $('#pdf_new').children('a').trigger('click');
            }
            else
            {
                window.location=$('#pdfAjax').val();
            }
            $('#loading').hide();
            $("body").css("opacity","1"); 
        }
    })
}

function excel_view(table)
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    var tap=table.split('_');	
	var da='';
	if($('#head').length>0)
	{
		da=$('#head_table').html();
		da=da+$('#export_table_view_pdf').html();
	}else
		da=$('#export_table_view_pdf').html();
	
    var datas="name="+$('#'+tap[0]).attr('alt')+"&table_data="+da;
    $.ajax({
        type: "POST",
        url: $('#excelAjax').val(),
        data: datas,
        success: function(html) 
        {
		window.location=$('#excelexportAjax').val();
            $('#loading').hide();
            $("body").css("opacity","1"); 
        }
    })
}

function excel(table)
{
    $('#loading').show();
    CreateTable(table);
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    var tap=table.split('_');
	var da='';
	if($('#head').length>0)
	{
		da=$('#head_table').html();
		da=da+$('#export_table').html();
	}else
		da=$(export_table).html();
    var datas="name="+$('#'+tap[0]).attr('alt')+"&table_data="+da;

    $.ajax({
        type: "POST",
        url: $('#excelAjax').val(),
        data: datas,
        success: function(html) 
        {
            window.location=$('#excelexportAjax').val();
            $('#loading').hide();
            $("body").css("opacity","1"); 
        }
    });
}

function csv_view(table)
{
    // CreateTable(table);

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    var data = tableToCSV('#export_table_view_pdf');
	if($('#head').length>0)
		var t_data = tableToCSV('#head_table');
	else
		var t_data='';
    var tap=table.split('_');	
    var datas="name="+$('#'+tap[0]).attr('alt')+"&table_data="+t_data+data;

    $.ajax({
        type: "POST",
        url: $('#excelAjax').val(),
        data: datas,
        success: function(html) {

            window.location=$('#csvAjax').val();
            $('#loading').hide();
            $("body").css("opacity","1"); 
		  
        }
    })


}


function csv(table)
{
    CreateTable(table);

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    var data=tableToCSV('#export_table');
	if($('#head').length>0)
		var t_data = tableToCSV('#head_table');
	else
		var t_data='';
    var tap=table.split('_');
    var datas="name="+$('#'+tap[0]).attr('alt')+"&table_data="+t_data+data;
    $.ajax({
        type: "POST",
        url: $('#excelAjax').val(),
        data: datas,
        success: function(html) {
            window.location = $('#csvAjax').val();
            $('#loading').hide();
            $("body").css("opacity","1");
        }
    })


}
//.............................................................

function tableToCSV(table) {
    var headers = [];
    var rows = [];
    var csv = '';
	  
    $(table).find('thead td').each(function() {
        var $th = $(this);
        var text = $th.text();
        var header = '"' + text + '"';
        headers.push(header);
    });
	  
    csv += headers.join(',') + "\n";
    $(table).find('tbody tr').each(function() {
        $(this).find('td').each(function() {
            var row = $(this).text();
            if(!$(this).is('td:last-child')) {
                row += ',';
            } else {
                row += "\n";
            }
            csv += row;
        });
    });
    return csv;
}

function CreateTable(tables) 
{
    var idsd=tables.split('_');	
    document.getElementById ('export_table').innerHTML=" ";
    var jsonDatar2=$('#'+tables).html();
    var jsonDatar = JSON.parse(jsonDatar2);
    var table = document.createElement ("table");
    table.border = "1px";
    table.cellPadding="0px";
    table.cellSpacing="0px";
    table.setAttribute("class","malto");
    table.style.textAlign="center";
	
    var tHead = table.createTHead ();
    tHead.style.backgroundColor="#859CE6";
    var row = tHead.insertRow (-1);	
    $("."+idsd[0]+"_th").each(function()
    {
        var fid=$(this).parent('th').closest('div').hasClass('head_fix');
        var title=$(this).text();
        if(!fid)
        {
            var cell = row.insertCell (-1);
            cell.style.minWidth="350px";
            cell.style.paddingBottom="5px";
            cell.style.paddingTop="5px";
            cell.innerHTML = title ;
        }
    })
    var tBody = document.createElement ("tbody");
    table.appendChild (tBody);
    for (var key in jsonDatar) 
    {
        var obj = jsonDatar[key];
        var row = tBody.insertRow (-1);
        for (var prop in obj) 
        {
            var cell = row.insertCell (-1);
            // cell.innerHTML = encodeURIComponent(obj[prop]);
            cell.innerHTML = obj[prop];
			cell.style.minWidth="auto";
        }
    }
    document.getElementById ('export_table').appendChild(table);           
}

function Createpdfview(tables) 
{
    var tap = tables.split('_');	   
    var tds = $('#'+tap[0] + ' tbody tr').find('td');
    var ths = $('#'+tap[0] + ' thead tr:first').find("th");
	var st=1;
	var count=0;
    $("."+tap[0]+"_th").each(function()
    {
        // var idd = $('.'+table+'_th').eq(i).attr('id');
        var fid=$(this).parent('th').closest('div').hasClass('head_fix');
        if(!fid)
        {
            var title = $(this).text();
            if($(this).parent('th').css('display')=='table-cell')
            {
             	count++;
            }
        }
        st++;
    });
	$('#noh').html(count);
    
    var values = '';
    var i = 1;
    values = values + '<table class="malto" border="1px" cellspacing="0px" cellpadding="0px" style="text-align: center;">';
    values = values + '<thead><tr>';
    ths.each(function(indexs, items) 
    {
        if($(items).css("display") != "none") {
            values = values + '<td>' + $(items).find("span:last").html() + '</td>';			
        }
    });
    values = values + '</tr></thead>';
    values = values + '<tbody><tr>';
    tds.each(function(index, item) 
    {
        if($(item).css("display") != "none") 
        {
            var columnsCount =$('#noh').html();
			//var columnsCount =5;
            //if($(window).width()<1030 && $(window).width()>600) columnsCount = 3;
			if(columnsCount < i)
            {
                values = values + '</tr><tr>';
                i = 1;
            }			

            if($(item).children("div").children("div").html() != null)
            {
                values = values + '<td>' + $(item).children("div").children("div").html() + '</td>';
            }
            else
            {
                values = values + '<td>' + $(item).html() + '</td>';
            }			
            i++;
        }		
    });
    values = values + '</tr></tbody>';
    values = values + '</table>';
    $("#export_table_view_pdf").html(values);
}

function Createpdf(tables) 
{
    // alert(tables); return false;    
    var idsd=tables.split('_');	
    document.getElementById ('export_table').innerHTML = " ";
    var jsonDatar2 = $('#'+tables).html();
    // alert(jsonDatar2);
    var jsonDatar  = JSON.parse(jsonDatar2);	
    var table  = document.createElement ("table");
    table.border      = "1px";
    table.cellPadding = "0px";
    table.cellSpacing = "0px";
    table.setAttribute("class","malto");
    table.style.textAlign = "center";
    /*var sde = 0;
    for (var key in jsonDatar) 
    {
        var obj = jsonDatar[key];
        if(sde == 0)
        {
            var tHead = table.createTHead();
            var row = tHead.insertRow (-1);
            for (var prop in obj) 
            {
                var cell = row.insertCell (-1);
                cell.innerHTML = encodeURIComponent(prop);
            }
        }
        sde++;
    }*/
    
    var tHead = table.createTHead ();
    var row = tHead.insertRow (-1);	
    $("."+idsd[0]+"_th").each(function()
    {
        var fid=$(this).parent('th').closest('div').hasClass('head_fix');
        var title=$(this).text();
        if(!fid)
        {
            var cell = row.insertCell (-1);
            cell.innerHTML = title ;
        }
    })
    var tBody = document.createElement ("tbody");
    table.appendChild (tBody);
    for (var key in jsonDatar) 
    {
        var obj = jsonDatar[key];
        var row = tBody.insertRow (-1);
        for (var prop in obj) 
        {
            var cell = row.insertCell (-1);
            cell.innerHTML = encodeURIComponent(obj[prop]);
        }
    }
    document.getElementById ('export_table').appendChild(table);           
}
//............................................................
function mailto(table)
{
	
    jPrompt1('Email Id:', '', 'Send Mail', function(r) {
        if( r ) 
        {
            CreateTable(table);
				
            $('#loading').show();
            $("body").css("opacity","0.4"); 
            $("body").css("filter","alpha(opacity=40)"); 
            //var datas="mail_to="+r+"&table_data="+$('#export_table').html();
            var data=tableToCSV('#export_table');
            var tap=table.split('_');
			
            //var datas="mail_to="+r+"&name="+$('#'+tap[0]).attr('alt')+"&table_data="+data;
			var datas="mail_to="+r+"&name="+$('#'+tap[0]).attr('alt')+"&table_data="+$('#export_table').html();
            $.ajax({
                type: "POST",
                url: "common/tablemail",
                data: datas,
                success: function(html) {
				
		  
                }	
            })
            
				$('#loading').hide();
            $("body").css("opacity","1");; 
                    jAlert('Mail Sent','Message');       
        }
           
    });
	
}
	
//.........................................................................
function filtes1(table) {
    $('.'+table+'_filter').toggle();
}
//................................................................
function table_cells(table)
{
    $('#block-ui').show();
    var back_to_visible = $("#back_to").is(':visible');
	if(back_to_visible)
		sort_main_div = "#out_table";
	else
		sort_main_div = "#out_put";

    // $('#sort_pop h2').text('Table Columns');
    $(sort_main_div).find('#title').text('Table Columns');
    $(sort_main_div).find('#sort_pop').show();
    $(sort_main_div).find('.contnt').show();
    $(sort_main_div).find('.cont').hide();
    $(sort_main_div).find('#stt').show();
    $(sort_main_div).find('#st_id').hide();
    var table_len = $(sort_main_div).find('.'+table+'_th').length;
	
    var titles="";
    var titles1="";
    var st=1;
	var count=0;
    $(sort_main_div).find("."+table+"_th").each(function()
    {
        // var idd = $('.'+table+'_th').eq(i).attr('id');
        var fid=$(this).parent('th').closest('div').hasClass('head_fix');
        if(!fid)
        {
            var title = $(this).text();
            if($(this).parent('th').css('display')=='none')
            {
                titles +="<span id='ths_"+st+"po'><div class='selt cells1 q"+st+"' id='ths_"+st+"' style='cursor:pointer'>"+title+"</div></span>";
            }
            if($(this).parent('th').css('display')=='table-cell')
            {
                titles1 +="<div class='selt table_sel1 cells1 q"+st+"' id='ths_"+st+"' style='cursor:pointer'>"+title+"</div>";
                titles +="<span id='ths_"+st+"po'></span>";
				count++;
            }
        }
        st++;
    });
	$('#noh').html(count);
    $(sort_main_div).find('.fil_right').html(titles);
    $(sort_main_div).find('.fil_left').html(titles1);
	
    $(sort_main_div).find('.selt').click(function()
    {
        var fillt = $(this).attr('id');
        $(sort_main_div).find('.selt').css({
            background:''
        });
        $(sort_main_div).find('#'+fillt).css({
            background:'#cecece'
        });
        $(sort_main_div).find('.midd').attr('title',fillt);
        //$('#'+fillt).hide();
		
        $(sort_main_div).find('.to_left').unbind('click').click(function()
        {
            //alert($('.fil_left').children('div').length);
			hlen=$('#noh').html();
            var tt = $(sort_main_div).find('.midd').attr('title');			
            /*if($(window).width()>1030)
            {*/
			//alert($('.fil_left').children('div').length);
                if($(sort_main_div).find('.fil_left').children('div').length < hlen)
                    $(sort_main_div).find('.fil_left').append($('#'+tt));
                else
					jAlert('Maximum selection of columns should not be more than '+hlen,'Message');
            /*if($('.fil_left').children('div').length >5){
					$('#'+tt).remove();
					jAlert('Maximum selection of columns should not be more than five','Message');
				}	*/						
            //}
             /*if($(window).width()<1030 && $(window).width()>600)
            {
                if($(sort_main_div).find('.fil_left').children('div').length < 3 )
					$(sort_main_div).find('.fil_left').append($('#'+tt));
				else
					jAlert('Maximum selection of columns should not be more than three','Message');
            }
            if($(window).width()<600)
            {
                if($(sort_main_div).find('.fil_left').children('div').length < 1 )
					$(sort_main_div).find('.fil_left').append($('#'+tt));
				else
					jAlert('Maximum selection of columns should not be more than one','Message');
            } */
            $(sort_main_div).find('#'+tt).addClass('table_sel1');			
        })
        $(sort_main_div).find('.to_right').unbind('click').click(function()
        {
            var tt = $(sort_main_div).find('.midd').attr('title');
            $(sort_main_div).find('#'+tt).removeClass('table_sel1');
            $(sort_main_div).find('#'+tt+'po').html($('#'+tt));
        // $('.fil_right').append($('#'+tt));
        })
    })
    //........................
    $(sort_main_div).find('#stt').attr('onclick','sel_class1("'+table+'")');
    return false;
	
    //////////////////////////////////////////////////////////////////////////////
    $('.pos_pop').show();
    $('.pos_pop').addClass('post_col');
    var titles="";
    var let=1;
    $("."+table+"_th").each(function(){
        var fid=$(this).parent('th').closest('div').hasClass('head_fix');
        var title=$(this).text();
        if(!fid)
        {
            if($(this).parent('th').css('display')!='none')
            {
                titles +="<div class='cells q"+let+" table_sel' alt='"+table+"'>"+title+"</div>";
            }
            else
            {
                titles +="<div class='cells q"+let+"' alt='"+table+"'>"+title+"</div>";
            }
        }
        let++;	
    })

    $('.pos_center').html(titles);
    //var sdwq=$.cookie('table_cell').split(',');
    //	var i;
    //for(i=0;i<sdwq.length-1;i++)
    //{
    //sdwq[i];
    //$('.q'+sdwq[i]).addClass('table_sel');
    //}
    $('.cells').click(function()
    {
        if($(window).width()>1026)
        {
            if($(this).hasClass('table_sel'))
            {
                $(this).removeClass('table_sel');
            }
            else
            {
                $(this).addClass('table_sel');
            }
            if($('.table_sel').length>5)
            {
                $.cookie('table_show','4')
                $(this).removeClass('table_sel');
                jAlert('Maximum selection of columns should not be more then five2','Message',function(r)
                {
                    });
            }
        }
        //$('.cells').removeClass('table_sel');
        if($(window).width()<1030)
        {
            if($(this).hasClass('table_sel'))
            {
                $(this).removeClass('table_sel');
            }
            else
            {
                $(this).addClass('table_sel');
            }
            if($('.table_sel').length>3)
            {
                $(this).removeClass('table_sel');
                jAlert('Maximum selection of columns should not be more than three','Message');
            }
        }
        if($(window).width()<600)
        {
            $('.cells').removeClass('table_sel');
            $(this).addClass('table_sel');
        }
    })
    $('#p_ch').attr('onclick','sel_class("'+table+'")');
    $(document).mouseup(function (e)
    {
        var container = $(".post_col");
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
            $('.pos_pop').hide();
        }
    });
}

function sorte(table)
{
    //$('#sort_pop h2').text('Multi Sorting');
    $('#title').text('Multi Sorting');
    $('#sort_pop').show();
    $('.contnt').show();
    $('.cont').hide();
    $('#stt').show();
    $('#st_id').hide();
    var table_len = $('.'+table+'_th').length;

    var titles="";
    var st=0;
    $("."+table+"_th").each(function()
    {
        var fid=$(this).parent('th').closest('div').hasClass('head_fix');
        if(!fid)
        {
            if($(this).parent('th').css('display')=='table-cell')
            {
                var title = $(this).text();
                titles +="<span id='ths_"+st+"po'><div class='selt' id='ths_"+st+"' style='cursor:pointer'>"+title+"</div></span>";
            }
        }
        st++;
    });
   $('.fil_right').html('');
   $('.fil_left').html('');
    $('.fil_right').html(titles);
    $('.selt').click(function()
    {
        var fillt=$(this).attr('id');
        $('.selt').css({
            background:''
        });
        $('#'+fillt).css({
            background:'#cecece'
        });
        $('.midd').attr('title',fillt);
        $('.to_left').click(function()
        {
            var tt=$('.midd').attr('title');
            $('.fil_left').append($('#'+tt));
        })
        $('.to_right').click(function()
        {
            var tt=$('.midd').attr('title');
            $('#'+tt+'po').html($('#'+tt));
        })
    })
    //........................
    $('#stt').attr('onclick','sort_ch("'+table+'")');
}
  
function st_id(table)
{		
    var vads1=new Array;	
    var n =$(".cont").find('input:checked').length;
    var i=1;
    $(".cont").find('input:checked').each(function(){
        order=this.value;
        var values=this.title;
        var ivad=new Array;
        ivad.push(order);
        ivad.push(values);
        vads1.push(ivad); 
    // vads1=vads1.concat("["+order+",'"+values+"'],");
    });

    $('#'+table).dataTable1().fnSort(vads1);
    //$('#fil_pop').hide();
    $('#sort_pop').hide();
}
		
function ssum(Column,table,ids)
{
	if(typeof(ids)!='undefined')
	{
		
	
    var total=0;
    var tog=0;
	if(Column=='VBELN' || Column=='KUNNR' || Column=='VKORG')
	{
		jAlert('<b>Invalid Selected field</b>', 'Message');
	}
	else
	{
   $('#'+table+' td:nth-child('+ids+')').each(function(index, element) {
						
       
lllll							
        if(!isNaN($(this).text()))
        {
							
            //alert($(this).text());
            total=Number(total)+Number($(this).text());
        }
							
						
        else
        {
            tog=1;
        }
						
    });
    if(tog==0)
    {
        jAlert('<b>Total: </b>'+total, 'Message');
    }
    else
    {
        jAlert('<b>Invalid Selected field</b>', 'Message');
    }
	}
	}
	else
	{
		jAlert('<b>Please select field</b>', 'Message');
	}
}
//..........................................................................
function main_table(table)
{
    $('.pos_pop').show();
    $('.pos_pop').css({
        'margin-left':'58%'
    });
    var titles="";
    var let=1;
    $("."+table+"_th").each(function(){
	
        var title=$(this).text();
        titles +="<div class='cells q"+let+"'>"+title+"</div>";
	
	
        let++;	
    })
    $('.pos_center').html(titles);
    var sdwq=$.cookie('table_cell').split(',');
    var i;
    for(i=0;i<sdwq.length-1;i++)
    {
        sdwq[i];
        $('.q'+sdwq[i]).addClass('table_sel');
    }
    $('.cells').click(function()
    {
        if($(this).hasClass('table_sel'))
        {
            $(this).removeClass('table_sel');
        }
        else
        {
            $(this).addClass('table_sel');
        }
        if($('.table_sel').length>5)
        {
            $(this).removeClass('table_sel');
            jAlert('Maximum selection of columns should not be more then five3','Message');
			
        }
    });
    $('#p_ch').attr('onclick','sel_class("'+table+'")');
}
//..........................................................................
		
function sel_class1(table)
{
    $('#block-ui').hide();
    var back_to_visible = $("#back_to").is(':visible');
	if(back_to_visible)
		sort_main_div = "#out_table";
	else
		sort_main_div = "#out_put";
	
	hleng=$('#noh').html();
    /*if($('body').width()< 600)
    {				
        if($(sort_main_div).find('.fil_left').children('div').length < 1)
        {
            jAlert('Atleast 1 columns need to be selected.','Message');
            return false;
        }
        var inr = 0;
        var head_pos = '';
        $(sort_main_div).find('#'+table+' th, #'+table+' tbody td').css({
            display:'none'
        });				
        $(sort_main_div).find('.cells1').each(function() 
        {				
            inr=inr+1;
            if($(this).hasClass('table_sel1'))
            {
                var sde=$(this).attr('id').split('_');
						
                if($('body').width()<600)
                {
                    $(sort_main_div).find('#'+table+' th:nth-child('+sde[1]+'), #'+table+' tbody td:nth-child('+sde[1]+')').css({
                        display:'table-cell',
                        width:'100%'
                    });
                }						
                head_pos +=inr+',';
            }
        });
        $.cookie('table_cell',head_pos);
        $(sort_main_div).find('.pos_center').html(' ');
        // alert(table);
        store_tableheader_couchdb(table);
        $(sort_main_div).find('#sort_pop').hide();
    }
		
    if($('body').width()< 1030 && $('body').width()>600)
    {
        if($(sort_main_div).find('.fil_left').children('div').length < 2)
        {
            jAlert('Atleast 3 columns need to be selected.','Message');
            return false;
        }
        var inr = 0;
        var head_pos = '';
        $(sort_main_div).find('#'+table+' th, #'+table+' tbody td').css({
            display:'none'
        });				
        $(sort_main_div).find('.cells1').each(function() 
        {				
            inr=inr+1;
            if($(this).hasClass('table_sel1'))
            {
                var sde=$(this).attr('id').split('_');
						
                if($('body').width()<1030 && $('body').width()>600)
                {
                    $(sort_main_div).find('#'+table+' th:nth-child('+sde[1]+'), #'+table+' tbody td:nth-child('+sde[1]+')').css({
                        display:'table-cell',
                        width:'33.3%'
                    });
                }						
                head_pos +=inr+',';
            }
        });
        $.cookie('table_cell',head_pos);
        $(sort_main_div).find('.pos_center').html(' ');
        store_tableheader_couchdb(table);
        $(sort_main_div).find('#sort_pop').hide();
    }*/
			
     if($('body').width()>100)
    { 
        if($(sort_main_div).find('.fil_left').children('div').length < hleng)
        {
            jAlert('Atleast '+hleng+' columns need to be selected.','Message')
            
            return false;
        }					
        var inr = 0;
        var head_pos = '';
        $(sort_main_div).find('#'+table+' th, #'+table+' tbody td').css({
            display:'none'
        });				
        $(sort_main_div).find('.cells1').each(function() 
        {				
            inr=inr+1;
            if($(this).hasClass('table_sel1'))
            {
                var sde=$(this).attr('id').split('_');
                /*if($('body').width()<1030&&$('body').width()>600)
                {
                    $(sort_main_div).find('#'+table+' th:nth-child('+sde[1]+'), #'+table+' tbody td:nth-child('+sde[1]+')').css({
                        display:'table-cell',
                        width:'33.3%'
                    }); 
                }
                if($('body').width()<600)
                {
                    $(sort_main_div).find('#'+table+' th:nth-child('+sde[1]+'), #'+table+' tbody td:nth-child('+sde[1]+')').css({
                        display:'table-cell',
                        width:'100%'
                    });
                }
                /*if($('body').width()>1030)
                {*/
                    if(inr >=hleng+1){}else{
                        $(sort_main_div).find('#'+table+' th:nth-child('+sde[1]+'), #'+table+' tbody td:nth-child('+sde[1]+')').css({
                            display:'table-cell',
                            width:'20%'
                        });	
                    }					
                //}
                head_pos +=inr+',';
            }
        });
        $.cookie('table_cell',head_pos);
        $(sort_main_div).find('.pos_center').html(' ');
        store_tableheader_couchdb(table);
        $(sort_main_div).find('#sort_pop').hide();
    }
}
		
function sel_class(table)
{
		
    if($('body').width()<1030&&$('body').width()>600)
    {
        if($('.table_sel').length<3)
        {
            jAlert('Atleast 3 columns need to be selected.','Message');
            return false;
        } 
    }
    if($('body').width()>1030)
    {
        if($('.table_sel').length<5)
        {
            jAlert('Atleast 5 columns need to be selected.','Message',function(r)
            {//onClick="table_cells('example')
			
                });
            return false;
        } 
    }
    var inr=0;
    var head_pos='';
    $('#'+table+' th, #'+table+' tbody td').css({
        display:'none'
    });
    $('.cells').each(function() {
        inr=inr+1;
        if($(this).hasClass('table_sel'))
        {
			
            if($('body').width()<1030&&$('body').width()>600)
            {	
			
                $('#'+table+' th:nth-child('+inr+'), #'+table+' tbody td:nth-child('+inr+')').css({
                    display:'table-cell',
                    width:'33.3%'
		
                }); 
            }
            if($('body').width()<600)
            {
				
                $('#'+table+' th:nth-child('+inr+'), #'+table+' tbody td:nth-child('+inr+')').css({
                    display:'table-cell',
                    width:'100%'
		
                });
            }
            if($('body').width()>1030)
            {
				
                $('#'+table+' th:nth-child('+inr+'), #'+table+' tbody td:nth-child('+inr+')').css({
                    display:'table-cell',
                    width:'20%'
                });
            }
            head_pos +=inr+',';
        }
    });
    $.cookie('table_cell',head_pos);
    $('.pos_pop').hide();
    $('.pos_center').html(' ');
    store_tableheader_couchdb(table);
}
//..........................................................................
function post(table)
{
	
    $('.pos_pop').show();
    $('.pos_pop').css({
        'margin-left':'5%'
    });
    var arrt='';	

    $("."+table+"_th").each(function(){
        var tti=$(this).attr('name');
	
        arrt +=tti+',';
    })

    var arr=arrt.split(',');
	
    var table_len=$('.'+table+'_thw').length;
    var titles="";
    for(i=0;i<table_len;i++)
    {
        var ids = $('.'+table+'_thw').eq(i).attr('name');
	  
        var title = $('.'+table+'_thw').eq(i).text();
        var t=arr.indexOf(ids);
        if(t!=-1)
        {
            titles +="<div><input type='checkbox' id='ch_"+i+"'  name='"+ids+"' CHECKED>"+title+"</div>";
        }
        else
        {
            titles +="<div><input type='checkbox' id='ch_"+i+"' name='"+ids+"' >"+title+"</div>";
        }
    }
    $('.pos_center').html(titles);

    $('#p_ch').attr('onclick','p_ch("'+table+'")');
}
//..................................................
function side_links(jonb,jum)
{
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $.ajax({
        type:'POST', 
        url: "../lib/controller.php?page=forms&url=editsalesorder&values="+jonb+"&jum="+jum+"&titl=Edit Sales Order&tabs=editsalesorder", 
        success: function(response) {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            $('#out_put').html(response)
        }
    })
//controller.php?page=forms&url=editsalesorder&values="+jonb+"&jum="+jum+"&titl=Edit Sales Order&tabs=editsalesorder
}
function execute(id,table_div)
{
	$.cookie('sub_out','1');
    var form_values= $('#'+$.cookie('validation_form')).serialize();

    $.cookie('form_values',form_values);
    var back_to=$('#'+id).attr('name');

    var back_tit=$('#head_tittle').html();
    location.href='#sublink';
    $(document).find('.head_fix').each(function(index, element) {
        $(this).remove();
    });

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $('.pos_center').addClass('addheaders');
    $('.addheaders').removeClass('pos_center');
    $('.addheaders').html(' ');
    $('#p_ch').addClass('submitreplace');
    $('.submitreplace').removeAttr('id');
     //alert($('#'+id).attr('alt'));
    $.ajax({
        type:'POST', 
        url: $('#'+id).attr('alt'), 
        success: function(response) {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            $('#out_put').hide('slide', {
                direction: 'left'
            }, 500);
            $('#out_table').html(response)
            $('#out_table').show('slide', {
                direction: 'right'
            }, 500);
        }
    })



}
//onclick='side_links(\""+jonb+"\",\""+jum+"\")' 
function side_links(id,table_div)
{
    $.cookie('sub_out','1');
    var form_values= $('#'+$.cookie('validation_form')).serialize();

    $.cookie('form_values',form_values);
    var back_to=(typeof(id)!="object"?$('#'+id).attr('name'):$(id).attr("name"));

    var back_tit=$('#head_tittle').html();
    location.href='#sublink';
    $(document).find('.head_fix').each(function(index, element) {
        $(this).remove();
    });

    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
    $('.pos_center').addClass('addheaders');
    $('.addheaders').removeClass('pos_center');
    $('.addheaders').html(' ');
    $('#p_ch').addClass('submitreplace');
    $('.submitreplace').removeAttr('id');
     //alert($('#'+id).attr('alt'));
    $.ajax({
        type:'POST', 
        //url: url: (typeof(id)!="object"?$('#'+id).attr('alt'):$(id).attr("alt")),
        url: (typeof(id)!="object"?$('#'+id).attr('alt'):$(id).attr("alt")),
        success: function(response) {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            $('#out_put').hide('slide', {
                direction: 'left'
            }, 500);
            $('#out_table').html(response)
            $('#out_table').show('slide', {
                direction: 'right'
            }, 500);
        }
    })

    $('#back_to').show();
    $('#back_to').attr('onClick','back_to("'+back_to+'","'+back_tit+'","'+table_div+'")');
}

function back_to(page,title,table_div)
{
    if(page == "Search_customer")
        page = "search_customers";
	if(page=='search_customers')
	{
		$(".head_icons").show();
        $(".head_icons span").removeClass("table_top_hide");
	}
	if(page=='sales_workbench')
	{
		$(".head_icons").show();
        $(".head_icons span").removeClass("table_top_hide");
	}
    $('.addheaders').addClass('pos_center');
    $('.pos_center').removeClass('addheaders');
    $('.submitreplace').attr('id','p_ch');
    $('#p_ch').removeClass('submitreplace');
    $.cookie('form_values','');
    $.cookie('sub_out','0');
    $('#back_to').hide();
    $('#out_table').hide('slide', {
        direction: 'right'
    }, 500);
    $('#out_put').show('slide', {
        direction: 'left'
    }, 500);
    $('#out_table').html("");
    parent.subtu(page);
    $('#head_tittle').html(title);
    var wids=$('#'+table_div).width();
  // alert(wids)
    $('.head_icons').css({ width:wids+'px' });
}

function show_doc(id,jonb,jum,table_div)
{
    var lent=$('#'+id).closest('table').find('tr').length-2;
    var ide=$('#'+id).closest('tr').index();
    var ure=lent-ide;
    var tope=''
    var leftq=''
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div  style='display:none;' class='exp_menu' id='display1' onclick='side_links(\"display1\",\""+table_div+"\")' alt='../lib/controller.php?page=forms&url=display_billing_list&values="+jonb+"&jum="+jum+"&titl=Display Billing List&tabs=display_billing_list'>Display</div>";

    doc_s += "</div>";
    doc_s +="</div>";
 
 
    var doc_h=$('#'+id).append(doc_s);
    $('#display1').trigger('click');
    $('.red_pop').css({
        position:'absolute'
    });
	
    if(ure<=5)
    {
        $('.red_pop').css({
            'margin-top':'0px'
        });
    }
    $('.red_pop').show();
	
    $('.red_pop').mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
   
	
}

function show_dilv(id,jonb,jum,back_to,table_div)
{
	//alert('hi');
    var lent=$('#'+id).closest('table').find('tr').length-2;
    var ide=$('#'+id).closest('tr').index();
    var ure=lent-ide;
    var tope=''
    var leftq=''
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
 doc_s += "<div   class='exp_menu' name='"+back_to+"' id='display1' onclick='side_links(\"display1\",\""+table_div+"\")' alt='picking_and_post_goods/picking_and_post_goods?page=forms&url=picking_and_post_goods&values="+jonb+"&jum="+jum+"&titl=Pick And Post Goods&tabs=picking_and_post_goods'>Pick And Post Goods</div>";
doc_s += "<div   class='exp_menu' name='"+back_to+"' id='display1' onclick='side_links(\"display1\",\""+table_div+"\")' alt='picking_and_post_esign/picking_and_post_esign?page=forms&url=picking_and_post_goods&values="+jonb+"&jum="+jum+"&titl=Pick And Post eSign&tabs=picking_and_post_esign'>Pick And Post eSign</div>";
 doc_s += "<div class='exp_menu' id='Create_Billing1' onclick='pdfstrg(\""+ids[0]+"\")' >Delivery Note Output</div>";
 doc_s += "<div class='exp_menu' id='Create_Billing2' onclick='pdfstrgland(\""+ids[0]+"\")' >Bill of Lading Output</div>";
    doc_s += "</div>";
    doc_s +="</div>";
 
 
    var doc_h=$('#'+id).append(doc_s);
   // $('#display1').trigger('click');
    $('.red_pop').css({
        position:'absolute'
    });
	
    if(ure<=5)
    {
        $('.red_pop').css({
            'margin-top':'0px'
        });
    }
    $('.red_pop').show();
	
    $('.red_pop').mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
   
	
}

//.......................................................

function show_purch(id,jonb,jum,back_to,table_div)
{
	//alert('hi');
    var lent=$('#'+id).closest('table').find('tr').length-2;
    var ide=$('#'+id).closest('tr').index();
    var ure=lent-ide;
    var tope=''
    var leftq=''
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";

	doc_s += "<div class='exp_menu' name='"+back_to+"' id='display1' onclick='side_links(\"display1\",\""+table_div+"\")' alt='edit_purchase_order/edit_purchase_order/?PURCHASE_ORDER="+ids[0]+"&titl=Display Purchase Order&key=edit_purchase_order'>Display Purchase Order</div>";
	doc_s += "<div class='exp_menu' id='Create_Billing1' onclick='pdfstrgpur(\""+ids[0]+"\")' >Purchase Order Output</div>";
    doc_s += "</div>";
    doc_s +="</div>";
 
 
    var doc_h=$('#'+id).append(doc_s);
   // $('#display1').trigger('click');
    $('.red_pop').css({
        position:'absolute'
    });
	
    if(ure<=5)
    {
        $('.red_pop').css({
            'margin-top':'0px'
        });
    }
    $('.red_pop').show();
	
    $('.red_pop').mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
   
	
}

//.......................................................
function ccls()
{
    $('.material_pop').hide();
}

function show_prod(id, pnt, back_to)
{
	var lent=$('#'+id).closest('table').find('tr').length-2;
	var ide=$('#'+id).closest('tr').index();
	var ure=lent-ide;
	var tope=''
	var leftq=''
	$('.red_pop').remove();
	var ids=id.split('_');
	var doc_s='';
	doc_s +="<div class='blue_pop'>";
	doc_s +="<div class='red_pop'>";
	doc_s += "<div class='exp_menu' name='"+back_to+"' id='display1' onclick=\"show_prod_avail('"+id+"','"+pnt+"','"+back_to+"')\" >Product Availability</div>";
	doc_s += "</div>";
	doc_s +="</div>";
	var doc_h=$('#'+id).append(doc_s);
	$('.red_pop').css({
		position:'absolute'
	});
	if(ure<=5)
	{
		$('.red_pop').css({
			'margin-top':'0px'
		});
	}
	$('.red_pop').show();
	
	$('.red_pop').mouseleave(function()
	{
		$('.red_pop').remove();
	})
	
	$('#'+id).mouseleave(function()
	{
		$('.red_pop').remove();
	});
}

function show_prod_avail(id, pnt, back_to)
{
	id = encodeURIComponent($("#"+id+" div").first().text());
    $('#loading').show();
    $("body").css("opacity","0.4");
    $.ajax({
        type:'POST', 
		url: 'product_availability/product_avl?page=sublink&bapiName=BAPI_MATERIAL_STOCK_REQ_LIST&url=product_avl&values='+id+'&pln='+pnt, 
		
        success: function(response) {
            $('#loading').hide();
            $("body").css("opacity","1"); 
            $('.material_pop').html(response);
            $('.material_pop').show();
        }
    });
}
//..............................

function pdfstrgpur(id)
{
	//alert($('#'+id).attr('alt'));
	$('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
	$.ajax({
	type:'POST',
	data:'VAL='+id+'&bapiName=/EMG/SD_FORM_DEL_NOTE_GET',
	url:'search_purchase_orders/strgpdf',
	success:function(data){
		//alert(data);
		$('#loading').hide();
            $("body").css("opacity","1");
		
		if($.trim(data)!='')
		{
			jAlert(data,'Message');
		}
		else
		{
			var tab=window.open('common/Pdfurl');
			tab.focus();
		}
	
	}
	});	
}

//.......................................................
function pdfstrg(id)
{
	//alert($('#'+id).attr('alt'));
	$('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
	$.ajax({
	type:'POST',
	data:'LAND=&VAL='+id+'&bapiName=/EMG/SD_FORM_DEL_NOTE_GET',
	url:'delivery_list/strgpdf',
	success:function(data){
		$('#loading').hide();
            $("body").css("opacity","1");
		if($.trim(data)!='')
			{
				jAlert(data,'Message');
			}
			else
			{
				var tab=window.open('common/Pdfurl');
				tab.focus();
			}
	
	}
	});	
}
function pdfstrgland(id)
{
	//alert($('#'+id).attr('alt'));
	$('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)"); 
	$.ajax({
	type:'POST',
	data:'LAND=X&VAL='+id+'&bapiName=/EMG/SD_FORM_DEL_NOTE_GET',
	url:'delivery_list/strgpdf',
	success:function(data){
		$('#loading').hide();
            $("body").css("opacity","1");
		if($.trim(data)!='')
			{
				jAlert(data,'Message');
			}
			else
			{
				var tab=window.open('common/Pdfurl');
				tab.focus();
			}
		//tab.focus();
	
	}
	});	
}
function show_rels(id,jonb,jum,back_to)
{
    /*var lent=$('#'+id).closest('table').find('tr').length-2;
    var ide=$('#'+id).closest('tr').index();
    var ure=lent-ide;
    var tope=''
    var leftq=''
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='display1' name='"+back_to+"' onclick='cert_deliv(\"display1\")' alt='release_prod_order/release_pro?bapiName=BAPI_PRODORD_RELEASE&page=sublink&url=releasepro&ORDER_NUMBER="+jonb+"&jum="+jum+"&titl=Release Prod Order&tabs=release_prod_order'>Display</div>";
    doc_s += "</div>";
    doc_s +="</div>"; 
 
    var doc_h=$('#'+id).append(doc_s);
    $('#display1').trigger('click');
    $('.red_pop').css({
        position:'absolute'
    });
	
    if(ure<=5)
    {
        $('.red_pop').css({
            'margin-top':'0px'
        });
    }
    $('.red_pop').show();
	
    $('.red_pop').mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
    */
    
    var tableID  = $("div.tab-pane:visible").attr("id");
    var lent  = $('#'+id).closest('table').find('tr').length-2;
    var ide   = $('#'+id).closest('tr').index();
    var ure   = lent-ide;
    var tope  = ''
    var leftq = ''
    $('.red_pop').remove();
    var ids = id.split('_');
    var doc_s = '';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='display1' name='"+back_to+"' onclick='cert_deliv(\"display1\")' alt='release_prod_order/release_pro?bapiName=BAPI_PRODORD_RELEASE&page=sublink&url=releasepro&ORDER_NUMBER="+jonb+"&jum="+jum+"&titl=Release Prod Order&tabs=release_prod_order'>Release</div>";
    doc_s += "</div>";
    doc_s += "</div>";
    var doc_h=$('#'+tableID).find('#'+id).append(doc_s);
    $('.red_pop').css({
        position:'absolute'
    });
    
    $('.red_pop').css({
        'margin-top':'-40px',
        'margin-left':'100px', 
        'opacity':'1000px'
    });
    
    /* 
	if(ure<=4)
	{
		$('.red_pop').css({'margin-top':'-148px'});
		if(lent<5)
		{
			$('.red_pop').css({'margin-top':'-60px','margin-left':'100px'});
		}
	}
	*/
    $('.red_pop').show();
    $('.red_pop').mouseleave(function()
    {
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
        $('.red_pop').remove();
    })
}
function approve_r(id,jonb)
{
      
		   
    var lent  = $('#'+id).closest('table').find('tr').length-2;
    var ide   = $('#'+id).closest('tr').index();
    var ure   = lent-ide;
    var tope  = ''
    var leftq = ''
    $('.red_pop').remove();
    var ids = id.split('_');
    var doc_s = '';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='approve1' name='"+back_to+"' onclick='cert_deliv(\"approve1\")' alt='approve_purchase_requisition/approve_request?bapiName=BAPI_REQUISITION_RELEASE_GEN&NUMBER="+jonb+"'>Approve Purchase Requisition</div>";
    doc_s += "</div>";
    doc_s += "</div>";
    var doc_h=$('#'+id).append(doc_s);
    $('.red_pop').css({
        position:'absolute'
    });
    
    $('.red_pop').css({
        'margin-top':'-40px',
        'margin-left':'100px', 
        'opacity':'1000px'
    });
    
  
    $('.red_pop').show();
    $('.red_pop').mouseleave(function()
    {
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
        $('.red_pop').remove();
    })
}
//..................................................

function show_conf(id,jon,jonb,jum,back_to)
{	
    /* var lent=$('#'+id).closest('table').find('tr').length-2;
    var ide=$('#'+id).closest('tr').index();
    var ure=lent-ide;
    var tope=''
    var leftq=''
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div  style='display:none;' class='exp_menu' name='"+back_to+"' id='display1' onclick='side_links(\"display1\")' alt='confirm_prod_order/confirm_prod_order?page=forms&url=confirm_prod_order&json="+jon+"&value="+jonb+"&jum="+jum+"&titl=Confirm Prod Order&tabs=confirm_prod_order'>Display</div>";
    doc_s += "</div>";
    doc_s +="</div>";
  
    var doc_h=$('#'+id).append(doc_s);
    $('#display1').trigger('click');
    $('.red_pop').css({
        position:'absolute'
    });
	
    if(ure<=5)
    {
        $('.red_pop').css({
            'margin-top':'0px'
        });
    }
    $('.red_pop').show();
	
    $('.red_pop').mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
	  
        $('.red_pop').remove();
    }) */
   
	var tableID  = $("div.tab-pane:visible").attr("id");
    var lent  = $('#'+id).closest('table').find('tr').length-2;
    var ide   = $('#'+id).closest('tr').index();
    var ure   = lent-ide;
    var tope  = ''
    var leftq = ''
    $('.red_pop').remove();
    var ids = id.split('_');
    var doc_s = '';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='display1' name='"+back_to+"' onclick='side_links(\"display1\")' alt='confirm_prod_order/confirm_prod_order?page=forms&url=confirm_prod_order&json="+jon+"&value="+jonb+"&jum="+jum+"&titl=Confirm Prod Order&tabs=confirm_prod_order'>Confirm Prod Order</div>";
    doc_s += "</div>";
    doc_s += "</div>";
    var doc_h=$('#'+tableID).find('#'+id).append(doc_s);
    $('.red_pop').css({
        position:'absolute'
    });
    
    $('.red_pop').css({
        'margin-top':'-40px',
        'margin-left':'100px', 
        'opacity':'1000px'
    });
    
    /* 
	if(ure<=4)
	{
		$('.red_pop').css({'margin-top':'-148px'});
		if(lent<5)
		{
			$('.red_pop').css({'margin-top':'-60px','margin-left':'100px'});
		}
	}
	*/
    $('.red_pop').show();
    $('.red_pop').mouseleave(function()
    {
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
        $('.red_pop').remove();
    })
}

//..................................................
function show_menu(id,jonb,jum,back_to,table_div)
{
var obj=decodeURIComponent(jonb);
var obj1=jQuery.parseJSON(obj);
	var table_id  = "";
    $("table").find('#'+id).each(function() {
		if($(this).closest('table').is(':visible'))
			table_id  = $(this).closest('table').attr('id');
	});
    var lent  = $('#'+id).closest('table').find('tr').length-2;
    var ide   = $('#'+id).closest('tr').index();
    var ure   = lent-ide;
    var tope  = ''
    var leftq = ''
    $("#"+table_id).find('.red_pop').remove();
    var ids = id.split('_');
    var doc_s = '';
	if(obj1.DOC_TYPE=='ZQT' || obj1.DOC_TYPE=='QT' || obj1.DOC_TYPE=='AG')
	{
	doc_s +="<div style='margin-top:50px' class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu'  id='display1' name='"+back_to+"' onclick='side_links(\"display1\",\""+table_div+"\")' alt='editsalesquotation/editsalesquotation/?bapiName=BAPISDORDER_GETDETAILEDLIST&I_VBELN="+ids[0]+"&jum="+jum+"&titl=Display Sales Quotation&tabs=editsalesquotation&key=editsalesquotation'>Display</div>";
if(jum != 'DOCUMENT_FLOW_ALV_STRUC'){
    //doc_s += "<div class='exp_menu' id='display2' name='"+back_to+"' onclick='side_links(\"display2\",\""+table_div+"\")' alt='quotation_document_flow/quotation_document_flow/?DOC_NUM="+ids[0]+"&titl=Document Flow&tabs=document_flow'>Document Flow</div>";
}
    //doc_s += "<div class='exp_menu' id='Create_Sales1' name='"+back_to+"' onclick='side_links(\"Create_Sales1\",\""+table_div+"\")' alt='create_sales_order/sales_order_from_quotation?&bapiName=BAPISDORDER_GETDETAILEDLIST&CUSTOMER="+$('#CUSTOMER_NUMBER').val()+"&I_VBELN="+ids[0]+"&jum="+jum+"&type=off&titl=Create Sales Order&tabs=create_sales_order&key=create_sales_order'>Create Order</div>";
  
	}else
	{
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='display1' name='"+back_to+"' onclick='side_links(\"display1\",\""+table_div+"\")' alt='editsalesorder/editsalesorder/?bapiName=BAPISDORDER_GETDETAILEDLIST&I_VBELN="+ids[0]+"&jum="+jum+"&titl=Display Sales Order&tabs=editsalesorder&key=editsalesorder'>Display</div>";
if(jum != 'DOCUMENT_FLOW_ALV_STRUC'){
    doc_s += "<div class='exp_menu' id='display2' name='"+back_to+"' onclick='side_links(\"display2\",\""+table_div+"\")' alt='document_flow/document_flow/?DOC_NUM="+ids[0]+"&titl=Document Flow&tabs=document_flow'>Document Flow</div>";
}
    doc_s += "<div class='exp_menu' id='Set_Delivery' onclick='cert_deliv(\"Set_Delivery\")' alt='common/setdeliveryblock/?REF_DOC="+ids[0]+"&bapiName=BAPI_SALESORDER_CHANGE&type=set'>Set Delivery Block</div>";
    doc_s += "<div class='exp_menu' id='Remove_Delivery' onclick='cert_deliv(\"Remove_Delivery\")' alt='common/setdeliveryblock/?REF_DOC="+ids[0]+"&bapiName=BAPI_SALESORDER_CHANGE&type=remove'>Remove Delivery Block</div>";
    doc_s += "<div class='exp_menu' id='Create_Delivery1' onclick='cert_deliv(\"Create_Delivery1\")' alt='common/createdelivery/?REF_DOC="+ids[0]+"&bapiName=BAPI_OUTB_DELIVERY_CREATE_SLS'>Create Delivery</div>";
    doc_s += "<div class='exp_menu' onclick='cert_r(\""+ids[0]+"\",\""+id+"\")'>Credit Release</div>";
	doc_s += "<div class='exp_menu' onclick='cert_rr(\""+ids[0]+"\",\""+id+"\")'>Approve Sales Order</div>";
    if(jum=='/KYK/S_POWL_BILLDUE')
    {
        doc_s += "<div class='exp_menu' id='Create_Billing1' onclick='cert_deliv(\"Create_Billing1\")' alt='common/createbilling/?REF_DOC="+ids[0]+"&josn="+jonb+"&page=sublink&url=createbill&bapiName=ZBAPI_POWL_CREATE_BILLING'>Create Billing</div>";
    }
	}
    doc_s += "</div>";
    doc_s += "</div>";
    var doc_h=$("#"+table_id).find('#'+id).append(doc_s);
    $("#"+table_id).find('.red_pop').css({
        position:'absolute'
    });
    var posiElement = parseInt($('#'+id).offset().top) - parseInt($(window).scrollTop());
    if(parseInt(posiElement) <= 450)
    {
        $("#"+table_id).find('.red_pop').css({
            'margin-top':'-70px',
            'margin-left':'100px', 
            'opacity':'1000px'
        });
    }
    else
    {
        $("#"+table_id).find('.red_pop').css({
            'margin-top':'-98px', 
            'margin-left':'100px', 
            'opacity':'1000px'
        });
    }
    /* 
	if(ure<=4)
	{
		$('.red_pop').css({'margin-top':'-148px'});
		if(lent<5)
		{
			$('.red_pop').css({'margin-top':'-60px','margin-left':'100px'});
		}
	}
	*/
    $("#"+table_id).find('.red_pop').show();
    $("#"+table_id).find('.red_pop').mouseleave(function()
    {
        $("#"+table_id).find('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
        $("#"+table_id).find('.red_pop').remove();
    })
}
//......................................................................
function show_menu1(id,jonb,jum,back_to)
{
    var lent  = $('#'+id).closest('table').find('tr').length-2;
    var ide   = $('#'+id).closest('tr').index();
    var ure   = lent-ide;
    var tope  = ''
    var leftq = ''
    $('.red_pop').remove();
    var ids = id.split('_');
    var doc_s = '';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='display1' name='"+back_to+"' onclick='side_links(\"display1\")' alt='editsalesorder/editsalesorder/?bapiName=BAPISDORDER_GETDETAILEDLIST&I_VBELN="+ids[0]+"&jum="+jum+"&titl=Display Sales Order&tabs=editsalesorder'>Display</div>";
    doc_s += "<div class='exp_menu' id='Set_Delivery' onclick='cert_deliv(\"Set_Delivery\")' alt='common/setdeliveryblock/?REF_DOC="+ids[0]+"&bapiName=BAPI_SALESORDER_CHANGE&type=set'>Set Delivery Block</div>";
    doc_s += "<div class='exp_menu' id='Remove_Delivery' onclick='cert_deliv(\"Remove_Delivery\")' alt='common/setdeliveryblock/?REF_DOC="+ids[0]+"&bapiName=BAPI_SALESORDER_CHANGE&type=remove'>Remove Delivery Block</div>";
    doc_s += "<div class='exp_menu' id='Create_Delivery1' onclick='cert_deliv(\"Create_Delivery1\")' alt='common/createdelivery/?REF_DOC="+ids[0]+"&bapiName=BAPI_OUTB_DELIVERY_CREATE_SLS'>Create Delivery</div>";
    doc_s += "<div class='exp_menu' onclick='cert_r(\""+ids[0]+"\",\""+id+"\")'>Credit Release</div>";
    if(jum=='/KYK/S_POWL_BILLDUE')
    {
        doc_s += "<div class='exp_menu' id='Create_Billing1' onclick='cert_deliv(\"Create_Billing1\")' alt='../lib/controller.php?REF_DOC="+ids[0]+"&josn="+jonb+"&page=sublink&url=createbill&bapiName=ZBAPI_POWL_CREATE_BILLING'>Create Billing</div>";
    }
    doc_s += "</div>";
    doc_s += "</div>";
    var doc_h=$('#'+id).append(doc_s);
    $('.red_pop').css({
        position:'absolute'
    });
    var posiElement = parseInt($('#'+id).offset().top) - parseInt($(window).scrollTop());
    if(parseInt(posiElement) <= 450)
    {
        $('.red_pop').css({
            'margin-top':'-70px',
            'margin-left':'100px', 
            'opacity':'1000px'
        });
    }
    else
    {
        $('.red_pop').css({
            'margin-top':'-148px',  
            'margin-left':'100px',
            'opacity':'1000px'
        });
    }
    /* 
	if(ure<=4)
	{
		$('.red_pop').css({'margin-top':'-148px'});
		if(lent<5)
		{
			$('.red_pop').css({'margin-top':'-60px','margin-left':'100px'});
		}
	}
	*/
    $('.red_pop').show();
    $('.red_pop').mouseleave(function()
    {
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
        $('.red_pop').remove();
    })
}
//......................................................................
function show_info_rec(id,json,back_to,table_div)
{
	

    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
 doc_s += "<div  style='display:none;' class='exp_menu' name='"+back_to+"' id='display1' onclick='side_links(\"display1\",\""+table_div+"\")' alt='create_purchase_order/create_purchase_order?page=forms&url=create_purchase_order&ORDER_NUMBER="+id+"&json="+json+"&titl=Create Purchase Order&tabs=create_purchase_order'>Display</div>";

    doc_s += "</div>";
    doc_s +="</div>";
 
 
    var doc_h=$('#'+id).append(doc_s);
    $('#display1').trigger('click');
	
	
}
function show_pro_avl(id,json,back_to)
{
	

    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div  style='display:none;' class='exp_menu' name='"+back_to+"' id='display1' onclick='side_links(\"display1\")' alt='../lib/controller.php?page=forms&url=product_availability&ORDER_NUMBER="+id+"&json="+json+"&titl=Create Purchase Order&tabs=create_purchase_order'>Display</div>";

    doc_s += "</div>";
    doc_s +="</div>";
 
 
    var doc_h=$('#'+id).append(doc_s);
    $('#display1').trigger('click');
	
	
}
function show_cus(id,back_to,table_div)
{
    var widt=$(window).width();
    var lent=$('#'+id).closest('table').find('tr').length-2;
    var ide=$('#'+id).closest('tr').index();
    var ure = lent-ide;
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s += "<div class='blue_pop'>";
    doc_s += "<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='Display_Edit1' name='"+back_to+"' onclick='side_links(\"Display_Edit1\",\""+table_div+"\")' alt='editcustomers/editcustomers/?table_name=Sales_orders&bapiName=BAPI_CUSTOMER_GETLIST&type=off&CUSTOMER_ID="+ids[0]+"&titl=Edit Customers&tabs=editcustomers'>Display/Edit</div>";
    doc_s += "<div class='exp_menu' id='Sales_Details1' name='"+back_to+"' onclick='side_links(\"Sales_Details1\",\""+table_div+"\")' alt='search_sales_orders/search_sales_orders?scr="+widt+"&bapiName=BAPI_SALESORDER_GETLIST&type=off&CUSTOMER_NUMBER="+ids[0]+"&SALES_ORGANIZATION=1000&titl=Search Sales Orders&tabs=search_sales_orders'>Sales Details</div>";
    doc_s += "<div class='exp_menu' id='Post_Incoming1' name='"+back_to+"' onclick='side_links(\"Post_Incoming1\",\""+table_div+"\")' alt='post_incoming_payment/post_incoming_payment?&bapiName=ZBAPI_ACC_DOCUMENT_POST&type=off&CUSTOMER="+ids[0]+"&titl=Post Incoming Payment&tabs=post_incoming_payment'>Post Incoming Payment</div>";
    doc_s += "<div class='exp_menu' id='Create_Sales1' name='"+back_to+"' onclick='side_links(\"Create_Sales1\",\""+table_div+"\")' alt='create_sales_order/create_sales_order?&bapiName=BAPI_SALESORDER_CREATEFROMDAT2&type=off&CUSTOMER="+ids[0]+"&titl=Create Sales Order&tabs=create_sales_order'>Create Sales Order</div>";
    doc_s += "</div>";
    doc_s += "</div>";
    var doc_h = $('#'+id).append(doc_s);
    var posiElement = parseInt($('#'+id).offset().top) - parseInt($(window).scrollTop());
    // alert(parseInt($('#'+id).offset().top));
    // alert(parseInt($(window).scrollTop()));
    // alert(posiElement);
    if(parseInt(posiElement) <= 450)
    {
        $('.red_pop').css({
            'margin-top':'-70px',
            'margin-left':'100px', 
            'opacity':'1000px'
        });
    }
    else
    {
        $('.red_pop').css({
            'margin-top':'-105px',  
            'margin-left':'100px',
            'opacity':'1000px'
        });
    }
    /*if(ure<=4)
    {
        $('.red_pop').css({'margin-top':'-105px'});
        if(lent<2)
        {
            $('.red_pop').css({'margin-top':'-60px','margin-left':'100px'});
        }
    }
    if(ure==-1)
    {
        $('.red_pop').css({'margin-top':'0px'});
    }*/
    $('.red_pop').show();
    $('.red_pop').mouseleave(function()
    {
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
        $('.red_pop').remove();
    })
	
}
function show_vendor_menu(id,back_to,table_div)
{
	//alert('hi');
    var widt=$(window).width();
    var lent=$('#'+id).closest('table').find('tr').length-2;
    var ide=$('#'+id).closest('tr').index();
    var ure = lent-ide;
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s += "<div class='blue_pop'>";
    doc_s += "<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='Display_Edit1' name='"+back_to+"' onclick='side_links(\"Display_Edit1\",\""+table_div+"\")' alt='editvendors/editvendors/?VENDOR="+ids[0]+"&titl=Display and Edit Vendor&tabs=editvendors'>Display/Edit</div>";
    doc_s += "<div class='exp_menu' id='Sales_Details1' name='"+back_to+"' onclick='side_links(\"Sales_Details1\",\""+table_div+"\")' alt='create_purchase_order/create_purchase_order?scr="+widt+"&type=off&vendor="+ids[0]+"&titl=Create Purchase Order&tabs=create_purchase_order'>Create PO</div>";
 
   
    doc_s += "</div>";
    doc_s += "</div>";
    var doc_h = $('#'+id).append(doc_s);
    var posiElement = parseInt($('#'+id).offset().top) - parseInt($(window).scrollTop());
    // alert(parseInt($('#'+id).offset().top));
    // alert(parseInt($(window).scrollTop()));
    // alert(posiElement);
    if(parseInt(posiElement) <= 450)
    {
        $('.red_pop').css({
            'margin-top':'-10px',
            'margin-left':'100px', 
            'opacity':'1000px'
        });
    }
    else
    {
        $('.red_pop').css({
            'margin-top':'-10px',  
            'margin-left':'100px',
            'opacity':'1000px'
        });
    }
    /*if(ure<=4)
    {
        $('.red_pop').css({'margin-top':'-105px'});
        if(lent<2)
        {
            $('.red_pop').css({'margin-top':'-60px','margin-left':'100px'});
        }
    }
    if(ure==-1)
    {
        $('.red_pop').css({'margin-top':'0px'});
    }*/
    $('.red_pop').show();
    $('.red_pop').mouseleave(function()
    {
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
        $('.red_pop').remove();
    })
	
}
//............................................................
function cert(id)
{
	
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu' onclick='cert_r(\""+ids[0]+"\")'>Credit Release</div>";

    doc_s += "</div>";
    doc_s +="</div>";
    $('#'+id).append(doc_s);
	
    $('.red_pop').show();
	
    $('.red_pop').mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
	
}


function show_cus_map(id,back_to)
{
    var widt=$(window).width();
	
    var lent=$('#'+id).closest('table').find('tr').length-2;
	
    var ide=$('#'+id).closest('tr').index();
    var ure=lent-ide;
    $('.red_pop').remove();
    var ids=id.split('_');
    var doc_s='';
    doc_s +="<div class='blue_pop'>";
    doc_s +="<div class='red_pop'>";
    doc_s += "<div class='exp_menu' id='Display_Edit1' name='"+back_to+"' onclick='parent.side_links_map(\"editcustomers/editcustomers/?bapiName=BAPI_CUSTOMER_GETLIST&type=off&CUSTOMER_ID="+ids[0]+"&titl=Edit Customers&tabs=editcustomers\")' alt=''>Display/Edit</div>";
    doc_s += "<div class='exp_menu' id='Sales_Details1' onclick='parent.side_links_map(\"search_sales_orders/search_sales_orders?scr="+widt+"&page=sublink&url=search_sales_orders&bapiName=BAPI_SALESORDER_GETLIST&type=off&CUSTOMER_NUMBER="+ids[0]+"&SALES_ORGANIZATION=1000&titl=Search Sales Orders&tabs=search_sales_orders\")' alt=''>Sales Details</div>";
    doc_s += "<div class='exp_menu' id='Post_Incoming1' onclick='parent.side_links_map(\"post_incoming_payment/post_incoming_payment?page=forms&url=post_incoming_payment&bapiName=ZBAPI_ACC_DOCUMENT_POST&type=off&CUSTOMER="+ids[0]+"&titl=Post Incoming Payment&tabs=post_incoming_payment\")' alt=''>Post Incoming Payment</div>";
    doc_s += "</div>";
    doc_s += "</div>";
    var doc_h=$('#'+id).append(doc_s);
    if(ure<=4)
    {
        $('.red_pop').css({
            'margin-top':'-105px'
        });
        if(lent<2)
        {
            $('.red_pop').css({
                'margin-top':'-60px',
                'margin-left':'50px'
            });
        }
    }
    if(ure==-1)
    {
        $('.red_pop').css({
            'margin-top':'0px'
        });
    }
    $('.red_pop').show();
	
    $('.red_pop').mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
    $('#'+id).mouseleave(function()
    {
	  
        $('.red_pop').remove();
    })
	
}
//............................................................




function cert_r(ids,id)
{
	
    //var tr=$('#'+ids).closest('tr');
    //var rowindex=tr.index();
	
	
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)");
    $.ajax({
        type: "POST",
        url: "common/Salesordercreditrelease/?bapiName=ZBAPI_ORDER_CREDIT_RELEASE&I_VBELN="+ids,
        success: function(html) {
            var df= "Order "+ids+" released from credit block";
            $('#loading').hide();
            $("body").css("opacity","1"); 
            jAlert('<b>SAP System message:</b><br>'+html, "Message", function(r)
            {
                if(r)
                {
					var n = html.indexOf("released from credit block");
					// console.log(n);
                    // if(html==df)
					
					/*if(n > 0)
                    {
						$('#'+id).closest('td').closest('tr').remove();
						// $('#loading').show();
						// $("body").css("opacity","0.4"); 
						// $("body").css("filter","alpha(opacity=40)");
						// location.reload();
                    }*/
                }
            });
        }
    });
}


function cert_rr(ids,id)
{
	
    //var tr=$('#'+ids).closest('tr');
    //var rowindex=tr.index();
	
	
    $('#loading').show();
    $("body").css("opacity","0.4"); 
    $("body").css("filter","alpha(opacity=40)");
    $.ajax({
        type: "POST",
        url: "common/Approvesalesorder/?bapiName=approve_sales_order&I_VBELN="+ids,
        success: function(html) {
            var df= "Order "+ids+" released from credit block";
            $('#loading').hide();
            $("body").css("opacity","1"); 
            jAlert('<b>SAP System message:</b><br>'+html, "Message", function(r)
            {
                if(r)
                {
					var n = html.indexOf("released from credit block");
					// console.log(n);
                    // if(html==df)
					
					if(n > 0)
                    {
						$('#'+id).closest('td').closest('tr').remove();
						// $('#loading').show();
						// $("body").css("opacity","0.4"); 
						// $("body").css("filter","alpha(opacity=40)");
						// location.reload();
                    }
                }
            });
        }
    });
}


function cert_deliv(id)
{
	var urls = $('#'+id).attr('alt');
	var resp_type = "";
	
	if(id=='approve1')
	{
		jPrompt1('Release code:', '', 'Enter Release code',function(r){
			// alert(r);
			if(r)
			{
				$('#loading').show();
				$("body").css("opacity","0.4"); 
				$("body").css("filter","alpha(opacity=40)");
				$.ajax({
					type: "POST",
					url:urls+'&PO_REL_CODE='+r,
					async: false,
					success: function(html) 
					{
						var spt = html.split("@");
						resp_type = spt[1];
						
						$('#loading').hide();
						$("body").css("opacity","1"); 
						jAlert('<b>SAP System message:</b><br>'+spt[0], "Message", function() {
							// this is the callback function of the jAlert box
							// we arrive here when the user has clicked "ok"
							// send him to google
							url_reload(resp_type);
						});
					}
				});
			}
		 });
	}
	else
	{
		$('#loading').show();
		$("body").css("opacity","0.4"); 
		$("body").css("filter","alpha(opacity=40)");
		$.ajax({
			type: "POST",
			url: $('#'+id).attr('alt'),
			async: false,
			success: function(html) 
			{
				var spt = html.split("@");
				resp_type = spt[1];
				
				$('#loading').hide();
				$("body").css("opacity","1"); 
				jAlert('<b>SAP System message:</b><br>'+spt[0], "Message", function() {
					// this is the callback function of the jAlert box
					// we arrive here when the user has clicked "ok"
					// send him to google
					url_reload(resp_type);
				});
			}
		});
	}
}
function cert_sales(id)
{
var urls = $('#'+id).attr('alt');
	var resp_type = "";
$('#loading').show();
		$("body").css("opacity","0.4"); 
		$("body").css("filter","alpha(opacity=40)");
		$.ajax({
			type: "POST",
			url: $('#'+id).attr('alt'),
			async: false,
			success: function(html) 
			{
				var spt = html.split("@");
				resp_type = spt[1];
				
				$('#loading').hide();
				$("body").css("opacity","1"); 
				jAlert('<b>SAP System message:</b><br>'+spt[0], "Message", function() {
					// this is the callback function of the jAlert box
					// we arrive here when the user has clicked "ok"
					// send him to google
					url_reload(resp_type);
				});
			}
		});
}
function url_reload(resp_type)
{
	var page = window.location.hash;
	var cur_url = page.replace(/^#/, '');
	if(cur_url == "sales_order_credit_block" && resp_type == "S")
		$(page+'_t').trigger('click');
}

//.............................................................................
$(document).ready(function(e) {
    $(document).mousemove(function(e){
        $.cookie('mouse-y',e.pageY);
    });
    $('.select_item').click(function(){
		
		
        if($(this).hasClass('table_items'))
        {
            $(this).find('.pointers').addClass('pointer');
            $(this).removeClass('table_items');
            $(this).find('input:checkbox').attr('checked', false);
        }
        else
        {
			
            $(this).find('.pointer').addClass('pointers')
            $(this).find('.pointer').removeClass('pointer');
            $(this).addClass('table_items');
            //$(this).addClass('.table_items a');
            $(this).find('input:checkbox').attr('checked', true);
		
        }
		
    })
	
//........................input fields................
	
	
	
	
});
function testy()
{
    $('.utopia-form-box').show();
    parent.gut1();
    $('.edge').hide();
    $('.edge2').hide();
    parent.formsa2();
    parent.jur();
}

function cancel_pop()
{
    $('#block-ui').hide();
    var back_to_visible = $("#back_to").is(':visible');
	if(back_to_visible)
		sort_main_div = "#out_table";
	else
		sort_main_div = "#out_put";
	
    $(sort_main_div).find('#sort_pop').hide();
    $(sort_main_div).find('#fil_pop').hide();
    $(sort_main_div).find('.pos_pop').hide();
	
}

function sear_show_more(id, val, ses, num)
{
	var sess=ses.split('@');
	$('#'+sess[1]+'_num').html(Number(num)+10);
	sear(id, val, ses);
}

function sear(id,val,ses)
{
	$.cookie('sort_col', id);
	var sess=ses.split('@');
    var tbname = $('.tbName_'+sess[1]).val();
    var table_name = $('#'+sess[1]).attr('alt');
    var num = Number($('#'+sess[1]+'_num').html());
	$('.testr').hide();
	$('#srch_show_more').remove();
	$('#'+sess[1]+'_num').before( '<div id="srch_show_more" class="testr">Show more</div>' );
	$('#srch_show_more').html("<img src='images/fb_load.gif'>");
	$('#srch_show_more').attr("onclick", 'sear_show_more("'+id+'", "'+val+'", "'+ses+'", '+num+');');
	$('#srch_show_more').show();
	//$('.testr').html('Show more');
	var params = 'id='+id+'&val='+val+'&ses='+ses+'&table_name='+table_name+'&tbname='+tbname+'&kiu='+num;
    $.ajax({
        type:'POST', 
        url: 'common/searchtable',
        data: params,
        success: function(response) 
        {
            $('#'+sess[1]+'_tbody').html(response);

			var tot_row = Number($('#'+sess[1]+'_row').val());
			
			if(num < tot_row)
				$('#srch_show_more').html("Show more");
			else
				$('#srch_show_more').hide();

        }

    });
}
var valuet=0;
function more_menu()
{
    valuet=valuet+1;
    if (valuet%2 == 0)
    {
        $('#pos_tab').hide();
    }
    else
    {
        $('#pos_tab').show();
    }
			
		
    var mut="";
    var i=0;
    var len=$('.menu_tab').find('li').length;
    $('.menu_tab').find('li').each(function(index, element) {
				
				
        if($(window).width()<600)
        {
					
            if(i==0)
            {
                $(this).addClass('ls_li');
            }
        }
        else
        {
            if(i==3)
            {
                $(this).addClass('ls_li');
            }
        }
        if($(this).css('display')=='none')
        {
            var ids=$(this).attr('id');
            mut+="<div class='tab_sel' alt='"+ids+"'>"+$(this).text()+"</div>";
				
        }
                
        i++;
	
    });
    $('#pos_tab').html(mut);
    $('.tab_sel').click(function(e) {
			
        var idf=$(this).attr('alt');
			
        $('.ls_li').hide();
        $('#'+idf).addClass('ls_li');
        $('#'+idf).show();
        $('#'+idf).children('a').trigger('click');
			
    });
			
}
		
function color_tip()
{
    $('[tip]').colorTip({
        color:'red'
    });
}
		
function ter(addr)
{
    $('.dirst').remove();
    $('.ser_by').remove();
    $('.appl').parent('div').parent('div').parent('div').parent('div').attr('class','rty');
    $('.gm-style-iw').after("<div style='border-left:1px solid #cecece;border-right:1px solid #cecece;background:#fff;width:292px;margin-top:138px;z-index:1000;position:absolute;' class='dirst'><div style='margin-left:13px;'><div class='tofr'><span class='toh'>To here</span><span class='fromh'>From here</span></div><input type='text' name='daddr' class='ito' alt='saddr' style='margin-bottom:5px;padding:3px;'/><span class='go_dir'>GO</span></div></div>");
    $('.toh').click(function(e) {
        $('.ito').attr('name','daddr');
        $('.ito').attr('alt','saddr');
        $('.ito').val("");
        $(this).css({
            color:'#0095CC',
            'text-decoration':'underline'
        });
        $('.fromh').css({
            color:'#000',
            'text-decoration':'none'
        });
    });
    $('.fromh').click(function(e) {
        $('.ito').attr('name','saddr');
        $('.ito').attr('alt','daddr');
        $('.ito').val("");
        $(this).css({
            color:'#0095CC',
            'text-decoration':'underline'
        });
        $('.toh').css({
            color:'#000',
            'text-decoration':'none'
        });
    });
    $('.go_dir').click(function(e) {
        var value=$('.ito').val();
        var name=$('.ito').attr('name');
        var own=$('.ito').attr('alt');
        var url=name+'='+value+'&'+own+'='+addr;
        window.open("https://maps.google.com/maps?"+url, '_blank');
    });
}
function serach_by(addr)
{
    $('.dirst').remove();
    $('.ser_by').remove();
    $('.appl').parent('div').parent('div').parent('div').parent('div').attr('class','rty');
    $('.gm-style-iw').after("<div style='border-left:1px solid #cecece;border-right:1px solid #cecece;background:#fff;width:292px;margin-top:139px;z-index:1000;position:absolute;' class='ser_by'><div style='margin-left:13px;padding-top:3px;'><input type='text' name='saer' class='sert' /><span class='go_sr'>GO</span></div></div>");
    $('.go_sr').click(function(e) {
        var value=$('.sert').val();
        var url='q='+value+'&near='+addr;
        window.open("http://maps.google.com/maps?"+url, '_blank');
    });
	
}
function nearby()
{
    $('.ner').val('');
    $('.back_b').removeClass('btn-primary');
    $('#n_map_list').addClass('btn-primary');
    $('#ser_ty').val('near_map');
    $.ajax({
        type: "POST",
        url: 'common/geolocation',
        success: function(html) {
            // $('#sstate').val(html);
            // var first2 = html.substr(0, 2);
            var first2 = html;
            nearbymap(first2)
        }
    });
}
function nearby_table() 
{
    $('.ner').val('');
    $('#ser_ty').val('near_list');
    $('.back_b').removeClass('btn-primary');
    $('#n_list').addClass('btn-primary');
    $.ajax({
        type: "POST",
        url: 'common/geolocation',
        success: function(html) 
        {
            // alert(html);
			// console.log(html);
            // var first2 = html.substr(0, 2);
            var first2 = html;
            $('#scountry_list').val(first2);
            // submit_form('validation');
            var s_wid = $(window).width();
			if(first2 != "")
				getBapitable('table_today_seach_customer','BAPICUSTOMER_ADDRESSDATA','example','L','show_cus@'+s_wid,'Search_customers','submit');
			else
			{
				$('#maps').html("<h4 style='color:#828282;'>Address Not Found</h4>");
				$('#maps').show();
				$('#tables').hide();
			}
        }
    });
}
function wedthery()
{
    var zipc=$('.en_weath').val();
    $.simpleWeather({
        zipcode: zipc,
        unit: 'f',
        success: function(weather) {
				
            html=  '<h3 class="widget_weth"><img src="images/icons/paragraph_justify.png" class="p_ic"><span class="cutz sub_titles" alt="Weather">Weather</span> <span id="wiget_url" onClick="widget_url()"></span></h3>';
            html += '<h4 style="color:#000;margin-left:10px;">'+weather.city+', '+weather.region+'</h4>';
            html += '<img style="float:left" width="125px " src="'+weather.image+'">';
            html += '<p style="margin-top:0px;">'+weather.temp+'&deg; '+weather.units.temp+'<br /><span>'+weather.currently+'</span></p>';
            html += '<a href="'+weather.link+'" target="_blank">View Forecast &raquo;</a>';
                
            $("#utopia-dashboard-weather").css({
                marginBottom:'20px'
            }).html(html);
            $.ajax({
                type: "POST",
                data:"page=welcome_url&type=zip_code&url="+zipc,
                url: "dashboard/welcomeurls",
                success: function(html) {
                }
            });
        },
        error: function(error) {
            $("#utopia-dashboard-weather").html('<p>'+error+'</p>');
        }
    });

}
function thisrow(id,ids,event)
{
    var table_name=$(id).closest('table').attr('alt');
    //alert(table_name);
    if(event.shiftKey==1&&(table_name=='Sales_Orders_Due_for_Delivery'||table_name=='Delivery_Due_for_Billing')) {
        if($(id).hasClass('table_items'))
        {
            $(id).removeClass('table_items');
            $('.deli_'+ids).attr('checked',false);
	
        }
        else
        {
            $(id).addClass('table_items');
            $('.deli_'+ids).attr('checked',true);
        }
   
    }
    else
    {
        $(id).parent('tbody').children('tr').each(function(index, element) {
				
            if($(this).hasClass('table_items'))
            {
                $(this).removeClass('table_items');
                $(this).find('input[type=checkbox]').attr('checked',false);
				
            }
        });
        if($(id).hasClass('table_items'))
        {
            $(id).removeClass('table_items');
            $('.deli_'+ids).attr('checked',false);
	
        }
        else
        {
            $(id).addClass('table_items');
            $('.deli_'+ids).attr('checked',true);
        }
    }
	

	
	
	
}
function customize()
{	
	
    $('.widgg').removeClass('dis_wd');
    $('.deld_wid').removeClass('dis_wd');
    $('.deld_wid').show();
    $('.cutz').each(function(index, element) 
    {
        var tag='0'
        $(this).parent().children('label').each(function(index, element) {
            tag='2';
        });
        $(this).parent().children('label').find('span').each(function(index, element) {
            tag='1';
            $(this).remove();
        });
        if($(this).children('span:eq(1)').hasClass('notdraggable'))
        {
            //alert($(this).children('span:eq(1)').html())
            var innerhtml=$(this).children('span:eq(1)').html().replace(/:/g,"");
            if(innerhtml!='')
            {
                var value=$(this).children('span:eq(1)').html();
                var srt=value.replace(/:/g,"");
                var clss=$(this).attr('alt');
                var d_clss=clss.replace(/ /g,"_");
                d_clss = clss.replace(/[.]/g,"");
				 d_clss = d_clss.replace(/[`~!@#$%^*()|+\-=?;:'",.<>\{\}\[\]\\\/]/g,"");
                $(this).children('span:eq(1)').html("<input type='text' value='"+srt+"' class='customize_input "+d_clss+"' alt='"+tag+"'>");
                
            }
        }
        else
        {
            $(this).children('span').remove();
            var innerhtml=$(this).html().replace(/:/g,"");
            if(innerhtml!='')
            {			
                var value=$(this).html();
                var srt=value.replace(/:/g,"");
                var clss=$(this).attr('alt');
                var d_clss=clss.replace(/ /g,"_");
				 d_clss = d_clss.replace(/[`~!@#$%^*()|+\-=?;:'",.<>\{\}\[\]\\\/]/g,"");
                $(this).html("<input type='text' value='"+srt+"' class='customize_input "+d_clss+"' alt='"+tag+"'>");
              
            }
        }
		
    });
    $('.edit_customize').hide();
    $('.save_customize').show();
//$('.control-label1').css({'background-color':'green'});
}
function save_customize()
{
    $('.widgg').addClass('dis_wd');
    $('.deld_wid').addClass('dis_wd');
    var datastr='';
    var spl=0;
    $('.customize_input').each(function(index, element) {
        var title=$(this).parent(this).attr('alt');
        datastr +=title +"="+ $(this).val()+",";
        var iChars = "!`@#$%^&*()+=[]\\\';,/{}|\":<>?~";   
        var data=$(this).val();
        for (var i = 0; i < data.length; i++)
        {      
				
            if (iChars.indexOf(data.charAt(i)) != -1)
            {    
					
                jAlert("Your string has special characters. \nThese are not allowed.","Message");
                    
                spl=1;
            } 
        }
				
    });
    if(spl==1)
    {
        return false; 
    }
	 
    dataString="url="+page_url+"&lables="+datastr;
    $.ajax({
        type: "POST",
        data:dataString,
        url: "../lib/save_customize.php",
     
        success: function(html) {
		
            $('.customize_input').each(function(index, element) {
                var tag=$(this).attr('alt');
			 
                var sdt=$(this).val();
                if(tag==1)
                {
                    $(this).parent(this).html(sdt+"<span> * </span>:");
                }
                if(tag==2)
                {
                    $(this).parent(this).html(sdt+":");
                }
                if(tag==0)
                {
                    $(this).parent(this).html(sdt);
                }
            });
            $('.edit_customize').show();
            $('.save_customize').hide();
        }
    });
}

function edit_tiwt() {

    $('#edit_tiwt').replaceWith('<input type="text"  id="tiwt_wel" placeholder="Enter Name">');
    //$('#tiwt_wel').focus();
    $('.my_sms,.my_wel,.my_wid, .utopia-widget-content').click(function()
    {
        $('#tiwt_wel').replaceWith('<span id="edit_tiwt" onClick="edit_tiwt()"></span>');
    })
    $('#tiwt_wel').focusout(function()
    {
        $(this).replaceWith('<span id="edit_tiwt" onClick="edit_tiwt()"></span>');
    });
    $('#tiwt_wel').keydown(function(e) {
        if(e.keyCode=='27')
        {
            $(this).replaceWith('<span id="edit_tiwt" onClick="edit_tiwt()"></span>');
        }
        if(e.keyCode=='13')
        {
            $('#tweets').html('');
            $('#tweets').tweetable({
                username: $(this).val(),
                time: true,
                rotate: true,
                speed: 4000,
                limit: 5,
                replies: false,
			
                failed: "Sorry, twitter is currently unavailable for this user.",
                html5: true,
                onComplete:function($ul){
                    $('time').timeago();
                }
            });
				
            $(this).replaceWith('<span id="edit_tiwt" onClick="edit_tiwt()"></span>');
            $.ajax({
                type: "POST",
                data:"page=welcome_url&type=tiwt&url="+$(this).val(),
                url: "dashboard/welcomeurls",
                success: function(html) {
                }
            });
			
			

        }
    });
}


function edit_url() {

    $('#edit_url').replaceWith('<input type="url"  id="url_wel" placeholder="Enter URL">');
    //$('#url_wel').focus();
    $('.my_sms,.my_twt,.my_wid').click(function()
    {
        $('#url_wel').replaceWith('<span id="edit_url" onClick="edit_url()"></span>');
    })
    $('#url_wel').focusout(function()
    {
        $(this).replaceWith('<span id="edit_url" onClick="edit_url()"></span>');
    });
    $('#url_wel').keydown(function(e) {
        if(e.keyCode=='27')
        {
            $(this).replaceWith('<span id="edit_url" onClick="edit_url()"></span>');
        }
        if(e.keyCode=='13')
        {
            var str=$(this).val();
            var n=str.search("http");
            if(n>-1)
            {
                var urls=str;
            }
            else
            {
                var urls="http://"+str;
            }
			
            var url=urls.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
            if(url)
            {
						
                $('#welcome_if').attr('src',urls);
                $(this).replaceWith('<span id="edit_url" onClick="edit_url()"></span>');
                $.ajax({
                    type: "POST",
                    data:"page=welcome_url&type=welcome&url="+urls,
                    url: "dashboard/welcomeurls",
                    success: function(html) {
					if(html=='E')
					{
					 jAlert("Please Enter valid URL","Meassage",function(r){
                    if(r)
                    {
                        edit_url()
                    }
                });
                return false;
					}
                    }
                });
            }
            else
            {
                jAlert("Please Enter valid URL","Meassage",function(r){
                    if(r)
                    {
                        edit_url()
                    }
                });
                return false;
            }

        }
    });
}
function widget_url()
{
		
    $('#wiget_url').before('<div class="feed_url"><input type="text"  placeholder="Enter zip code" class="en_weath"/></div>');
    //$('.en_weath').focus();
    $('#delete_weather').mouseleave(function(e) {
        $('.feed_url').remove();
    });
    $('.en_weath').keydown(function(e) {
        if(e.keyCode=='13')
        {
            if($('.en_weath').val()!='')
            {
                wedthery();
            }
        }	
    });
}
function feed_url()
{
    $('#feed_url').before('<div class="feed_url"><input type="text" placeholder="Enter RSS Feed URL" class="feed_in"/></div>');
    //$('.feed_in')
    // ();
    $('.news').mouseleave(function(e) {
        $('.feed_url').remove();
    });
    $('.feed_in').keydown(function(e) {
        if(e.keyCode=='13')
        {
			
            var url=$(this).val().match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
            if(url)
            {
                $.ajax({
                    type: "POST",
                    data:"page=welcome_url&type=feed&url="+$(this).val(),
                    url: "dashboard/welcomeurls",
                    success: function(html) {
		  
                        $('.circle').html(html);
                    }
                });
				
            }
            else
            {
                jAlert("Please Enter valid URL","Meassage");
                return false;
            }
			
			
        }
    });
	
}
function numdef(num,id)
{
		
    if(num!="")
    {
        if($.isNumeric(num))
        {
            var str = num;
            while (str.length < 10) {
                str = '0' + str;
            }
            document.getElementById(id).value=str;
        }
	
    }
}
function  remove_class()
{
    $('.widgg').addClass('dis_wd');
    $('.deld_wid').addClass('dis_wd');
	
    $('.customize_input').each(function(index, element) {
        $(this).remove();
    });
} 
function custom_ajaxform(vald,url)
{
	//($('#'+vald).serialize());
	$('#loading').show();

            $("body").css("opacity","0.4");
            $("body").css("filter","alpha(opacity=40)");
	var id='example'
	var div='';
	var num = $('#'+id+'_num').html();
	$.ajax({
		type:'POST',
		data:$('#'+vald).serialize()+'&table=report_text&tec=ZREPORTS&t_id=example&kiu='+num,
		url:url+'/customforms',
		success:function(responce){
			// console.log(responce);
			responce = responce.split('$@$');
			if(responce[0]=='ZT')
			{
				responce[1]='<div style="border:1px solid #FAFAFA;overflow-y:hidden;overflow-x:scroll;" id="t_scrl"></div>'+responce[1];
				$('#report_text').html(responce[1]);
				data_table('example');
				var topwid = $('.top').width();
				$('.table').css({width:topwid+'px'});
				var wids = $('.top').width();
				$('.head_icons').css({ width:wids+'px' });
				$('.reports_text').show();
				$('#example').each(function() {
				$(this).dragtable( {
						placeholder: 'dragtable-col-placeholder test3',
						items: 'thead th div:not( .notdraggable ):not( :has( .dragtable-drag-handle ) ), .dragtable-drag-handle',
						appendTarget: $(this).parent(),
						tableId:id,
						tableSess:'report_text',
						scroll: true
					});
					if($('#t_scrl').length==1)
							{
							$('#t_scrl').insertBefore($('.bottom'));
							$('#t_scrl').append($('#'+id));
							}
				});
				
				// var wids = $('#'+table).width();
				// $('.head_icons').attr('style','width: 990px');
				// $('.head_icons').attr('style','width: '+wids+'px');
			}
			if(responce[0]=='ZP')
			{
				var res = jQuery.parseJSON(responce[1]);
				$.each(res,function(key,val){
					div += '<br>'+val.LINE ;
				});
				$('#report_text').html(div);
			}
			if(responce[0]=='ZR')
			{
				if(responce[1]=='null')
				{
					jAlert(responce[2]);
					$('#loading').hide();
					$("body").css("opacity","1");
					return false;
				}
				div+= ' <input type="hidden" name="subkey" value="subzreports" class="edit-rm"/>';
				var res = jQuery.parseJSON(responce[1]);
				//div += '<br><button class="btn span1 bbt edit-rm" type="bottom" onClick="edit_subt_form()" style="min-width:60px;">Edit</button><br>';
				div += '<div class="span12 edit-rm" style="margin-left:0px !important;"></div>';
				$.each(res,function(key,val){
					div += '<div class="span3 edit-rm" style="margin-left:0px !important;">';
					div += '<fieldset>';
					var radio = val.RADIO;
					var checkbox = val.CHECKBOX;
					var text = val.TEXT;
					var name = val.NAME;
					var length = val.OLENGTH;
					var oblgatory=val.OBLIGATORY;
					div += '<div class="control-group">';
					if(oblgatory=='X')
					{
						div += '<label class="control-label cutz" alt="Production Order" for="date" style="text-align:left !important;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;" title="'+text+'">'+text+' <span>*</span>:</label>';
					}
					else
					{
						div += '<label class="control-label cutz" alt="Production Order" for="date" style="text-align:left !important;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;" title="'+text+'">'+text+':</label>';
					}
					if(radio=='X')
					{
						
						div += '<div style="width:100px"><input  type="radio" name="jform['+name+']"/></div>';
					}
					if(checkbox=='X')
					{
						div += '<div style="width:100px"><input type="checkbox" name="jform['+name+']"/></div>';
					}
					if(checkbox==''&&radio=='')
					{
						div+= '<input type="text" name="jform['+name+']" style="width:150px;" />';
					}
					div += '</div>';
					div += '</fieldset></div>';
				});
				
				$('#customfiles').html(div);
				$('.custms-btn').addClass('cust-submit');
				$("#REPORT_NAME").prop("readonly",true);
			}
			$('#loading').hide();
			$("body").css("opacity","1");
		}
	});
}
function edit_subt_form()
{
	$('#customfiles').html('');
	$('.custms-btn').removeClass('cust-submit');
	$("#REPORT_NAME").prop("readonly",false);
	 $('.reports_text').hide();
	 $('#report_text').html('');
	$('.testr').hide();		
}