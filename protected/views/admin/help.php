<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>thinui (beta), by Emergys</title>
    <link  rel="SHORTCUT ICON" HREF="../img/thinui.ico" />
   
    <meta name="description" content="A complete admin panel theme">
    <meta name="author" content="theemio">


 <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/alerts.css" rel="stylesheet" type="text/css"/>
 <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/utopia.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/alerts.js"></script>
<style>
     .highlight{
        background-image: url("../images/sort_asc1.png"); 
        width:20px;
        height:20px;
                cursor:pointer;
        
    }
   .show_rr td:nth-child(1){
        background: url("../images/sort_desc1.png") no-repeat;
        background-position:bottom 15px left; 
        
        width:20px;
        height:20px;
        cursor:pointer;
        
    }
    .show_row_hide td:nth-child(1){
        background: url('../images/sort_asc1.png') no-repeat;
        background-position:bottom 10px left; 
        
        width:20px;
        height:20px;
        cursor:pointer;
        
    }
    .top
    {
        display:none;
    }
    .bottom
    {
        display:none;
    }

@media all  and (max-width: 1024px) {
[class*="span"],
  .row-fluid [class*="span"] {
    display: block;
    float: none;
    width: auto;
    margin-left: 0;
}
#nav_tab
    {
     position:absolute;
    }
  }
  .table th,.table td{
      display:table-cell !important;
      
  }
  
  .hidden_rows
  {
      border-right:none !important;
width:20px !important;
max-width:20px !important;
text-align:center !important;
background-image:none !important;
  }
 tr.even td.sorting_1 {
    background-color: #fff !important;
}

 
</style>
   
   
    
    <script>
        var n="";
   var tabIndex="";   
function shows(type)
{   
    if(type=='add_sys')
    {
            tabIndex='add_sys';
        $('#'+type+'_nav').css({
            color:'#ff7019'
        });
        $('#avl_sys_nav').css({
            color:'#000'
        });
        $('#add_sys_help_nav').css({
            color:''
        });
    $('#add_sys').show();
    $('#avl_sys').hide();
    $('#sap_sys').hide();
    $('#add_sys_help').hide();  
    $('.edit_sys').hide();
    }
    if(type=='avl_sys')
    {
            tabIndex='avl_sys';
        $('#'+type+'_nav').css({
            color:'#ff7019'
        });
        $('#add_sys_nav').css({
            color:''
        });
        $('#add_sys_help_nav').css({
            color:''
        });
    $('#avl_sys').show();
    $('#add_sys').hide();
    $('#add_sys_help').hide();  
    $('.edit_sys').hide();
    }
    if(type=='add_sys_help')
    { 
            tabIndex='add_sys_help';
        $('#'+type+'_nav').css({
            color:'#ff7019'
        });
        $('#avl_sys_nav').css({
            color:''
        });
        $('#add_sys_nav').css({
            color:''
        });
    $('#add_sys_help').show();      
    $('#add_sys').hide();
    $('#avl_sys').hide();
    $('#sap_sys').hide();
    $('.edit_sys').hide();
    }
    return false;
}

</script>   

    <!--[if IE 8]>
    <link href="../css/ie8.css" rel="stylesheet">
    <![endif]-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<img src="../images/close-help.png" class="help_close">
<img src="../images/help/host.jpg" class="help_thin">
<div class="container-fluid">
<div id="test"></div>


<!-- Header starts -->
<div class="row-fluid">

    <div class="span12">



        <div class="header-top">

            <div class="header-wrapper">

                <a href="#" class="sapin-logo"><img src="../images/thinui-logo-125x50.png"/></a>

                <div class="header-right">

                    <div class="header-divider"> <div class="navbar sidebar-toggle">
                    <div class="container" style="margin-top:-10px;">

                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>

                    </div>
                </div></div>

                    <div class="search-panel header-divider">
                        <div class="search-box">
                            <img src="../img/icons/zoom.png" alt="Search">
                            <form action="" method="post">
                                <input type="text" name="search" placeholder="search"/>
                            </form>
                        </div>
                    </div>


                   <!-- Notification end -->


                    <div class="user-panel header-divider">
                        <div class="user-info" id='admin_u'>
                            <img src="../images/icons/user.png" alt="">
                            <a href="#">admin</a>
                        </div>

                        <div class="user-dropbox" id='d_admin_u'>
                            <ul>
                                <!---<li class="user" ><a href="#" style="color:#cecece;">Profile</a></li>--->
                               <!--- <li class="settings" ><a href="#" style="color:#cecece;">Account Settings</a></li>
                               
                                <li class="theme-changer white-theme"><a href="#" onClick='help_t()'>Help</a></li>-->
                                <li class="logout"><a href='admin_logout.php'>Logout</a></li>
                            </ul>
                        </div>

                    </div><!-- User panel end -->

                </div><!-- End header right -->

            </div><!-- End header wrapper -->

        </div><!-- End header -->

    </div>

</div>

<!-- Header end -->


<div class="row-fluid" >
    <div class="span2 sidebar-container" >

            <div class="sidebar">

               

         <div class="nav-collapse collapse" id="nav_tab" >



            <ul class="accordion level-1">
              <li class="topli sales_dashbord"><a  href="#" id='avl_sys_nav' onClick="shows_betarequest('avl_sys')" ><span>Beta user requests</span></a></li>
                        
                           
                        </li>
                         <li class="current sales_dashbord"><a  href="#" id='add_sys_nav' onClick="shows_feedback('add_sys')"><span>Feedback</span></a></li>
                        <li class="current sales_dashbord active"><a  href="#" id='add_sys_help_nav' onClick="shows_help('add_sys_help')"><span>Help</span></a></li>
                           
                        </li>
                    </ul>

                </div>

            </div>
        </div>
<!-- Sidebar statrt -->

<!-- Sidebar end -->

<!-- Body start -->
<div class="span10 body-container body_con" >
  



 <div class="row-fluid" >
                <div class="span12" id="avl_sys" >
                    <section class="utopia-widget main_div" >
                        <div class="utopia-widget-title">
                            <img src="../images/icons/window.png" class="utopia-widget-icon">
                            <span>Help</span>
                        </div>

                        <div class="utopia-widget-content">
                        
                        
                            <div class="row-fluid">
                
                                       <div class="utopia-widget-content utopia-form-tabs">
                    <div class="tabbable">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-below1" data-toggle="tab">Pending</a></li>
                            <li><a href="#tab-below2" data-toggle="tab">Closed</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-below1">
                         <?php
                                   $data=json_decode($helpjson,true);  
                                   unset($data['_rev']);
                                   unset($data['_id']);
                        // var_dump($data);
                                   ?>
<table class='table table-striped table-bordered'>
<thead>
<tr>
<th>Name</th><th>Email ID</th><th>Telephone Number</th><th>Created Date</th><th>Status</th>
</tr>
</thead>
<tbody>
<?php
foreach($data as $keys=>$values)
{
    //var_dump($data);
    foreach($values['help'] as $kk=>$vv)
    { if($vv['status']=='pending') {
        $rows[]=$vv['Name']; ?>
        <tr class="show_row show_rr">
        <td><?php echo $vv['Name'];?></td><td><?php echo $vv['EmailId'];?></td><td><?php echo $vv['Telephone'];?></td><td><?php echo $vv['createdDate'];?></td>
        <td><input class="btn close_it" type="button"  name="<?php echo $kk.','.$vv['EmailId'];?>" value="Pending - Close it!"></input></td>
        </tr>
        <tr style="display:none;">
        <td colspan="5"><?php echo $vv['HelpContent'];?></td>
        </tr>
    <?php } }
 }
 if(empty($rows))
 {?>
     <tr>
        <td colspan="5"><?=_NORECORDS?></td>
        </tr>
 <?php }
?>
</tbody>
</table>                     
                            </div>
                            <div class="tab-pane" id="tab-below2">
 <?php
                                   $data=json_decode($helpjson,true);  
                                   unset($data['_rev']);
                                   unset($data['_id']);
                        // var_dump($data);
                                   ?>
<table class='table table-striped table-bordered'>
<thead>
<tr>
<th>Name</th><th>Email ID</th><th>Telephone Number</th><th>Created Date</th>
</tr>
</thead>
<tbody id="status_active">
<?php
foreach($data as $keys=>$values)
{
    //var_dump($data);
    foreach($values['help'] as $kk=>$vv)
    { if($vv['status']=='sent') {?>
        <tr class="show_row show_rr">
        <td><?php echo $vv['Name'];?></td><td><?php echo $vv['EmailId'];?></td><td><?php echo $vv['Telephone'];?></td><td><?php echo $vv['createdDate'];?></td>
        </tr>
        <tr style="display:none;">
        <td colspan="4"><?php echo $vv['HelpContent'];?></td>
        </tr>
    <?php } }
 }
?>
</tbody>
</table>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>

                               
                                
                            </div>
                    </section>
                        </div>
                   
                </div>
 

</div>
</div>

</div>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.dataTables1.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/header.js"></script>
<script>
$(document).ready(function(e) {
    data_table('hiddenTable');
$('.show_row').click(function(){
        if($(this).next('tr').css('display')=='none')
        {
            $(this).removeClass('show_rr').addClass('show_row_hide');
        $(this).next('tr').show();
        }
        else
        {
            $(this).removeClass('show_row_hide').addClass('show_rr');
            $(this).next('tr').hide();
        }
    });
    $('.close_it').click(function() {
        var thiss=$(this);
        var data=$(this).attr('name');
         jConfirm('Are you sure, You want to close this ticket?', 'Confirmation Dialog', function(r) {
             if(r)
             {
            $.ajax({
            type:'POST',
            data:'ids='+data,
            url:'helpactive',
            success:function(html)
            {
                
                var tr=thiss.parent('td').parent('tr');
                var trn=thiss.parent('td').parent('tr').next('tr');
                thiss.parent('td').remove();
                thiss.parent('td').parent('tr').remove();
                thiss.parent('td').parent('tr').next('tr').remove();
                $('#status_active tr:first-child').before(trn);
                $('#status_active tr:first-child').before(tr);
            }
            });
             }
         });
    });
});
function shows_feedback(ids)
{
     window.location.replace('feedback');
}
function shows_betarequest(ids)
{
     window.location.replace('betarequest');
}
function shows_help(ids)
{
     window.location.replace('help');
}
</script>

</body>
</html>
