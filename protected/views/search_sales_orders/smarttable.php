<div id="fil_pop">
    <h2 class="h2">Filter</h2>
    <div id='fil_center'>
        <table border="0" id="contnt" width="100%">
            <tr>
                <td width="45%" align="center"><div id="fil_left" class="ptr"></div></td>
                <td width="25px" align="center" class="center">
                <div id="to_left"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/to_left.png" style="cursor:pointer"></div>
                <div id="midd"></div><div id="to_right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/to_right.png" style="cursor:pointer"></div></td>
				
				<td width="45%" align="center"><div id="fil_right" class="ptr"></div></td>
            </tr>
        </table>
        <div id="cont" style="display:none;"></div>
    </div>
    <button class="cancel btn" style="width:90px;float:right;margin-right:10px; margin-top:5px;" onclick="cancel_pop()">Cancel</button>
    <button onClick="filter()" class="btn"  id="subt" style="width:90px; float:right; margin-top:5px;margin-right:20px;">Submit</button>
    <button onClick="push_id()" id="filter_id" class="btn"  style="display:none;width:90px;float:right; margin-top:5px;margin-right:15px;">Filter</button>
</div>

<div id="sort_pop">
    <!--<h2 class="h2">Multi Sorting</h2>-->
    <div id='title' style=" text-align: center"></div><br>
	<h3 style=" text-align: center;margin-top:-30px " ><span>Number of Columns </span>
<span  onclick="htop('1')" style="cursor:pointer" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/delete.png"/></span>&nbsp;<span id="noh"><?php echo $count; ?></span>&nbsp;<span onclick="htop('2')" style="cursor:pointer" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/add.png"/></span>
</h3>
    <div id='sort_center'>
        <table border="0" class="contnt" width="100%">
            <tr>
                <td width="45%" align="center"><div class="fil_left ptr" ></div></td>
                <td width="25px" align="center" class="center"><div class="to_left" style="margin-top:-100px"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/to_left.png" style="cursor:pointer"></div>
                <div class="midd"></div><div class="to_right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/to_right.png" style="cursor:pointer"></div></td>
                
				<td width="45%" align="center"><div class="fil_right ptr"></div></td>
            </tr>
        </table>
        <div class="cont" style="display:none;"></div>
    </div>
    <button class="btn" style="width:90px;float:right;margin-right:30px; margin-top:15px;" onclick="cancel_pop()">Cancel</button>
    <button onClick="sort_ch()" class="btn"  id="stt" style="width:90px; float:right; margin-top:15px;margin-right:20px;">Submit</button>
    <button  onClick="st_id()" id="st_id" class="btn"  style="display:none;width:90px;float:right; margin-top:15px;margin-right:30px;">Sort</button>
</div>

<div style="display:none" class="customsp">
    <ul id="myMenu" class="contextMenu">
        <li class="insert"><a href="#insert">Add New</a></li>        
        <li class="edit"><a href="#edit">Edit</a></li>                    
        <li class="delete"><a href="#delete">Delete</a></li>            
    </ul>
</div>
<div style="display:none;" id="cl_pos"></div>

<script>    
    $('#sort_pop').draggable();
    $('#sort_pop title').css('cursor','move');
    $('#title').mouseover(function () {  $('#sort_pop').draggable(); });
    $('#title').mouseout(function () { $('#sort_pop').draggable("destroy"); });  
</script>