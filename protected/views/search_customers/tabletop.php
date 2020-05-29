<div class="labl pos_pop">
    <div class='pos_center'></div>
    <button class="cancel btn" style="width:60px;float:right;margin-right:10px; margin-top:5px;" onClick='cancel_pop()'><?=_CANCEL?></button>
    <button  class="btn"  id="p_ch" onclick="p_ch()" style="width:60px; float:right; margin-top:5px;margin-right:15px;"><?=_SUBMIT?></button>
</div>

<div class="head_icons" style="width:872px;">
    <span id='post' tip="<?=Controller::customize_label(_TABLECOLUMS);?>" class="yellow post_col" onClick="table_cells('example')"></span>
    <table cellpadding='0px' cellspacing='0px' class="table_head"><tr>
        <td><span id='mailto' tip="<?=Controller::customize_label(_SENDAMAIL);?>" class="yellow" onClick="mailto('example_table')"></span></td>
        <td ><span id='tech' tip='<?=Controller::customize_label(_TECHNICALNAMES);?>' class="yellow" onClick="tech('example')"></span></td>
        <td ><span id='sumr' tip="<?=Controller::customize_label(_SUMNETVALUES);?>" class="yellow" onClick="ssum('example')"></span></td>
        <td class="tab_lit"><span id='sort' tip='<?=Controller::customize_label(_MULTISORT);?>' class="yellow" onClick="sorte('example')"></span></td>
        <td><span id='excel' tip=" &nbsp;<?=Controller::customize_label(_EXPORT);?> " class="yellow" onClick="eporte('example_table')"></span></td>
        <td><span id='filtes1' tip='&nbsp; <?=Controller::customize_label(_FILTERS);?> '  class="yellow" onClick="filtes1('example')"></span></td>
    </tr></table>
</div>

<div id="exp_pop" style="display:none;" class="labl">
    <div style='padding:1px;'><h4 style="color:#333333"><?=_EXPORTALL?></h4></div>
    <div class='csv_link exp_link tab_lit' onClick="csv('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
    <div class='excel_link exp_link tab_lit' onClick="excel('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
    <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdf"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
    <div style='padding:1px;'><h4 style="color:#333333"><?=_EXPORTVIEW?></h4></div>
    <div class='csv_link csv_view exp_link tab_lit' onClick="csv_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/csv.png">&nbsp;Csv</div>
    <div class='excel_link excel_view exp_link tab_lit' onClick="excel_view('example_table')" style='padding:1px 1px 1px 10px;'><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/excel.png">&nbsp;Excel</div>
    <div class='pdf_link exp_link'  style='padding:1px 1px 1px 10px;'><a href="<?php echo Yii::app()->createAbsoluteUrl("common/pdfview"); ?>"   target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png">&nbsp;Pdf</a></div>
</div>