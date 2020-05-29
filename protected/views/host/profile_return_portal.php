<script>
$(document).ready(function() {
    <?php
    if(Yii::app()->user->getState("change_pwd"))
    {
        ?>
        $('#profile-form').hide();
        $('#changepass-form').show();
        <?php
    }
    ?>
    $('.change_pass span').click(function()
    {
        $('#profile-form').hide();
        $('#changepass-form').show();
    })

    $('.span4').attr('readonly', 'readonly');
    $('#edit').click(function()
    {
        $(".span4").removeAttr('readonly');
        $('#input04').attr('readonly', 'readonly');
        $('#input05').attr('readonly', 'readonly');
        $('#role').attr('readonly', 'readonly');
        $("#edit").hide();
        $("#submit").show();
        $("#sub_cancel").show();
    });
    
    $('#sub_cancel').click(function()
    {
        $('.span4').attr('readonly', 'readonly');
        $("#edit").show();
        $("#submit").hide();
        $("#sub_cancel").hide();
    });

    $(".theme-changer a").on('click', function() {
        $('link[href*="../utopia-white.css"]').attr("href",$(this).attr('rel'));
        $('link[href*="../utopia-dark.css"]').attr("href",$(this).attr('rel'));
        $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
        $('.user-info').removeClass('user-active');
        $('.user-dropbox').hide();
    });
});

function checkemail()
{
    var val=$('#email_id').val();
    var dataString='page=dublicate&email='+val;
    $.ajax({
        type: "POST",
        url: "../lib/controller.php",
        data: dataString,
        success: function(html) {
            if(html=='This Email Id All Ready Exists')
            {
            $('#email_id').val("");
            $('#email_id').css({
            border:'1px solid red'
            });
            $('#email_check').html(html)
            $('#email_check').css(
            {color:'red'});
            }
        }
    });
}

$(document).ready(function(e) {
    $("#email_id").focus(function () {
        $('#email_id').css({ border:''});
        $('#email_check').html('');
    });
});

$(document).ready(function(){            
    $("#profile-form").validationEngine('attach', {
        onValidationComplete: function(form, status)
        {
            if(status)
            {
                $.ajax({type:'POST',
                    url: '<?php echo Yii::app()->createAbsoluteUrl("host/editprofile"); ?>', 
                    data:form.serialize(), 
                    success: function(response) {
                        var haveUpdateSucces =  '<?=Controller::customize_label(_HAVEUPDATESUCCESS);?>';
                        var succesMessage =  '<?=Controller::customize_label(_SUCCESSMESSAGE);?>';
                        jAlert(haveUpdateSucces, succesMessage,function(r){
                        if(r)
                        {
                            location.reload();
                        } });
                    }
                });
            }
        }
    });
 });

function change_pass()
{
    var val=$('#old_pass').val();
    var pass=$('#new_pass').val();
    var re_p=$('#confirm_pass').val();
    
    if(pass!=re_p)
    {
        $('#new_pass').css({ border:'1px solid red' });        
        $('#confirm_pass').css({border:'1px solid red'}).val('').focus(function(){
            $(this).css({border:'1px solid #cccccc'});
            $('#new_pass').css({border:'1px solid #cccccc'});
            $('#conf_er').hide();
        });
        $('#conf_er').html('Password not match').css({color:'red'});
        return false;
    }
    var dataString='page=newpassword&old_pass='+$.md5(val)+'&new_pass='+$.md5(pass);
    
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::app()->createAbsoluteUrl("host/changepassword"); ?>",
        data: dataString,
        success: function(html) {
             $('#loading').hide(); 
             $("body").css("opacity","1"); 
            if(html=='done')
            {
                var haveUpdateSucces =  '<?=Controller::customize_label(_HAVEUPDATESUCCESS);?>';
                var succesMessage =  '<?=Controller::customize_label(_SUCCESSMESSAGE);?>';
                jAlert(haveUpdateSucces, succesMessage,function(r){
                    if(r)
                    {
                        url_frm = $("#url_frm").val();
                        $('#old_pass').val('');
                        $('#new_pass').val('');
                        $('#confirm_pass').val('');
                        
                        if(url_frm == "host")
                        {
                            window.location.href = 'host';
                            // $('#profile-form').show();
                            // $('#changepass-form').hide();
                        }
                        else
                        {
                            $('#profile-form').show();
                            $('#changepass-form').hide();
                            // $('#prof').hide();
                            // $("#mybtnCancel, #nav_tab, #avl_sys, #profile").show();
                        }
                    }
                });
            }
            else
            {
                $('#old_pass').val('').css({border:'1px solid red'}).focus(function(e) {
                    $(this).css({border:'1px solid #CCCCCC'});
                    $('#error_pass').hide();
                });
                $('#error_pass').show();
                $('#error_pass').html(html).css({color:'red'});
            }
        }
    });
}
</script>
<?php
    $userid = Yii::app()->user->getState("user_id");
    $client = Controller::userDbconnection();
    $doc    = $client->getDoc($userid);
    $user   = $doc->profile;
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.md5.js"></script>
<script type="text/javascript">
$(document).ready(function() {      
    jQuery("#profile-form").validationEngine();
    jQuery("#changepass-form").validationEngine();
});

// $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
function cancel_pass()
{
    $('#profile-form').show();
    $('#changepass-form').hide();
}

$(document).ready(function(e) {
    $("select option").filter(function() {
        return $(this).val() == '<?php echo $user->country; ?>'; 
    }).attr('selected', true);
});
</script>

<section id='utopia-wizard-form' class="utopia-widget utopia-form-box">
    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">                    
                    
                     <?php $form = $this->beginWidget('CActiveForm', array(
                        'id'=>'profile-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array( 'class'=>"form-horizontal" ),
                        )); ?>
                    <fieldset style="margin-left: 30px;">

                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'firstname',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'firstname',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'fname', 'placeholder'=>'','tabindex'=>'1','id'=>'input01','value'=>"$user->fname")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'firstname'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'lastname',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'lastname',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'lname', 'placeholder'=>'','tabindex'=>'2','id'=>'input02','value'=>"$user->lname")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'lastname'); ?></span></label>
                            </div>
                        </div>
                        
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'company_name',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'company_name',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'company_name', 'placeholder'=>'','tabindex'=>'4','id'=>'input04','value'=>"$doc->company_name")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'companyname'); ?></span></label>
                            </div>
                        </div>
                        
                        <div class="control-group"><?php 
                            echo $form->labelEx($model,'company_address',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <label><?php echo $form->textField($model,'company_address',array('class'=>'input-fluid validate[required,custom[onlyLetterSp]] span4', 'name'=>'company_address', 'placeholder'=>'','tabindex'=>'4','id'=>'input05','value'=>"$doc->company_address")); ?>
                                <span style="color:red;"><?php echo $form->error($model,'company_address'); ?></span></label>
                            </div>
                        </div>                        
                        <div class="span2" ></div>  
                        <p class="change_pass labels_t"><span><?=_CHANGEPASS?></span></p>
                        <div class="span2" ></div>  

                        <p style="color:red;" class="labels_t" ><?=_REQUIREDFIELD?></p>
                        <div class="span2" ></div>  
                        
                        <?php echo CHtml::Button(_EDIT,array('id'=>'edit','tabindex'=>'9','class'=>'btn btn-primary span2','onclick'=>'','style'=>'width:100px;margin-left:50px;')); ?>
                        <?php echo CHtml::submitButton(_SUBMIT,array('id'=>'submit','tabindex'=>'10','class'=>'btn btn-primary span2','style'=>'width:100px;display:none;float:left;')); ?>
                        <?php echo CHtml::Button(_CANCEL, array('id'=>'sub_cancel','tabindex'=>'10','class'=>'btn span2','style'=>'width:100px;display:none;margin-left:50px;float:left;')); ?>
                    </fieldset>
                     <?php $this->endWidget(); ?>
                    
                     <?php $form1 = $this->beginWidget('CActiveForm', array(
                        'id'=>'changepass-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array( 'onsubmit'=>"return false;", 'class'=>"form-horizontal", 'style'=>"display:none;"),
                        )); ?>
                     <fieldset style="margin-left: 30px;">
                      <input type="hidden" name="url_frm" id="url_frm" value="host" />
                        <div class="flash-error span6" id="error_pass" style="display: none;"></div>
                        <div class="clear"></div>
                    <div class="control-group">
                                <?php echo $form1->labelEx($model,'oldpass',array('class'=>'control-label')); ?>
                                <div class="controls">
                    <label><?php echo $form1->passwordField($model,'oldpass',array('class'=>'input-fluid validate[required,custom[password]] span3', 'name'=>'old_pass', 'placeholder'=>'','tabindex'=>'1','id'=>'old_pass','style'=>'width:220px;')); ?>
                        <span style="color:red;"><?php echo $form->error($model,'oldpass'); ?></span></label>
                                </div>
                            </div>
                         <div class="control-group">
                                <?php echo $form1->labelEx($model,'newpass',array('class'=>'control-label')); ?>
                                <div class="controls">
                    <label><?php echo $form1->passwordField($model,'newpass',array('class'=>'input-fluid validate[required,custom[password]] span3', 'name'=>'new_pass', 'placeholder'=>'','tabindex'=>'1','id'=>'new_pass','style'=>'width:220px;')); ?>
                        <span style="color:red;"><?php echo $form->error($model,'newpass'); ?></span></label>
                                </div>
                            </div>
                     <div class="control-group">
                                <?php echo $form1->labelEx($model,'confirmpass',array('class'=>'control-label')); ?>
                                <div class="controls">
                    <label><?php echo $form1->passwordField($model,'confirmpass',array('class'=>'input-fluid validate[required] span3', 'name'=>'confirm_pass', 'placeholder'=>'','tabindex'=>'1','id'=>'confirm_pass','style'=>'width:220px;')); ?>
                        <span style="color:red;"><?php echo $form->error($model,'confirmpass'); ?></span></label>
                                </div>
                            </div>
                            
                            <div class="span2">&nbsp </div>  
                              <p style="color:red;" class="labels_t"><?=_REQUIREDFIELD?><p>
                <div class="span1">&nbsp </div>  
                             <div class='ch_btn'>
                                 <?php echo CHtml::submitButton(_SUBMIT,array('id'=>'mybtnSubmit','tabindex'=>'17','class'=>'btn btn-primary','onclick'=>'return change_pass();','style'=>'width:100px;')); ?>
                                 <?php echo CHtml::Button(_CANCEL,array('id'=>'mybtnCancel','tabindex'=>'17','class'=>'btn','onclick'=>'cancel_pass();','style'=>'width:100px;')); ?>                               
                               </div>
                                </fieldset>
                        <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</section>