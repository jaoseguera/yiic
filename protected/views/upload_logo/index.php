<script>
$(document).ready(function() { 
var options = { 
		target:   '#output',   // target element(s) to be updated with server response 
		beforeSubmit:  beforeSubmit,  // pre-submit callback 
		success:       afterSuccess,  // post-submit callback 
		uploadProgress: OnProgress, //upload progress callback 
		resetForm: false        // reset the form after successful submit 
	};
	
	var flag = true;
	$('#welcome_url').blur(function(){
	var str=$('#welcome_url').val();
	var n=str.startsWith("http");
		if(n)
            {
                var urls=str;
            }
            else
            {
                var urls="http://"+str;
            }
			var url=urls.match(/^https?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
			if(url)
				$(this).val(urls);
			else
			{
			alert("Please enter valid URL.");
			$(this).val(" ");
			}
	});
	$('#subt').click(function()
	{
	
	var urls=$('#welcome_url').val();	
	var imgs=$('#FileInput').val();
	if(urls=='' && imgs=='')
	{
	alert("Please provide at least one input.");
	return false;
	}else if(imgs=='')
	{
		$.ajax({
			type: 'POST', 
			data: 'welcome_url='+urls, 
			url: 'upload_logo/upload',
			success: function(response) 
			{
			$("#output").html(response);
			}
			});
	}else
	{
	$("#validation").ajaxSubmit(options);
	}
	
});




// */
	
	
	//function after succesful file upload (when server response)
	
	function afterSuccess()
	{
		$('#submit-btn').show(); //hide submit button
		$('#loading-img').hide(); //hide submit button
		$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar
		$('#loading').hide();
		$("body").css("opacity", "1");
		
	}
	
	//function to check file size before uploading.
	function beforeSubmit()
	{
		//check whether browser fully supports all File API
		if (window.File && window.FileReader && window.FileList && window.Blob)
		{
			if( !$('#FileInput').val()) //check empty input filed
			{
				$("#output").html("Empty file name. Please provide valid file name.");
				return false;
			}
			
			var fsize = $('#FileInput')[0].files[0].size; //get file size
			var ftype = $('#FileInput')[0].files[0].type; // get file type
			
			//allow file types 
			switch(ftype)
			{
				case 'image/bmp': 
				case 'image/png': 
				case 'image/gif': 
				case 'image/jpeg': 
				case 'image/pjpeg':
					break;
				default:
					$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
					return false;
			}
			
			//Allowed file size is less than 5 MB (1048576)
			if(fsize>5242880) 
			{
				$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
				return false;
			}
			
			$('#submit-btn').hide(); //hide submit button
			$('#loading-img').show(); //hide submit button
			$("#output").html("");
		}
		else
		{
			//Output error to older unsupported browsers that doesn't support HTML5 File API
			$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
			return false;
		}
	}
	
	//progress bar function
	function OnProgress(event, position, total, percentComplete)
	{
		//Progress bar
		$('#progressbox').show();
		$('#progressbar').width(percentComplete + '%') //update progressbar percent complete
		$('#statustxt').html(percentComplete + '%'); //update status text
		if(percentComplete>50)
		{
			$('#statustxt').css('color','#000'); //change status text to white after 50%
		}
	}
	
	//function to format bites bit.ly/19yoIPO
	function bytesToSize(bytes)
	{
	   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	   if (bytes == 0) return '0 Bytes';
	   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
	   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
	}
	
}); 
</script>

<div id='loading'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"></div>
<section id="formElement" class="utopia-widget utopia-form-box section" >
	<div class="row-fluid" >
        <div class="utopia-widget-content">
            <form action="<?php echo Yii::app()->createAbsoluteUrl("upload_logo/upload"); ?>" class="form-horizontal" method="post" enctype="multipart/form-data" id="validation">
				<fieldset>
					<div class="span5 utopia-form-freeSpace myspace">
                        <div class="control-group">
                            <label class="control-label cutz in_custz" for="logo" alt="Logo" ><?php echo Controller::customize_label('Logo');?><span> *</span>:</label>
                            <div class="controls">
                                <input alt="Logo" type="file" class="input-fluid" name="FileInput" autocomplete="off" id="FileInput">
								<br /><br /><br />
								<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
								<div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
								<div id="output"></div>
                            </div>
                        </div>
					<?php	$wel_url = "";
										//$wel_url = "http://www.oncorpus.com";
                                        $companyid 	= Yii::app()->user->getState("company_id");  
										$client 	= Controller::companyDbconnection();
										$comp_doc   = $client->getDoc($companyid);
                                       if(isset($comp_doc->welcome_urls) && $comp_doc->welcome_urls!='')
										{
											$wel_url = $comp_doc->welcome_urls;
										} ?>
						<div class="control-group">
                            <label class="control-label cutz in_custz" for="logo" alt="Logo" ><?php echo Controller::customize_label('Welcome URL');?><span> *</span>:</label>
                            <div class="controls">
						<input class="input-fluid"  id="welcome_url" name="welcome_url"  value="<?php echo $wel_url; ?>" type="url">
						</div>
                        </div>
						<div class="control-group">
							<div class="controls" style="text-align:center">
								<button class="btn btn-primary bbt span6"  type="button" id="subt" tabindex="11">Submit</button>
								<br><br><br><br>
							</div>
						</div>
					</div>
				</fieldset>
            </form>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validationEngine-en.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form.min.js"></script>
<script type="text/javascript">

	

	
</script>