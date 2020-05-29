<div id="graph_Sales_order_dashboard" style="display:none;"><section class="utopia-widget barch">
    <div class="utopia-widget-title"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icons/stats_bars.png" class="utopia-widget-icon"><span>Bar chart</span></div><?php
    $TotalCount = "";
    $rowsagt1 = count($_SESSION['table_today']);
    $rowsagt2 = count($_SESSION['table_deliv']);

    $sut = max($rowsagt1,$rowsagt2);
    $s   = $sut;
    $s   = $s/4;
    $sut = $sut+$s;
    ?><div class="utopia-widget-content">
        <table border="0" class="shaw"><tr>
            <td><div class='bar_tip'><ul>
                <li style="border:0px;"><?php echo round($s*5);?></li>
                <li><?php echo round($s*4);?></li>
                <li><?php echo round($s*3);?></li>
                <li><?php echo round($s*2);?></li>
                <li><?php echo round($s*1);?></li>
            </ul></div></td>
            <td><table class="grf"  border="0"><tr>
                <td class="gap"></td>
                <td onClick="show_bar('t1')" style="vertical-align:bottom;cursor:pointer;background:#F9F9F9;" href="#tab1" data-toggle="tab">
                        <div style="width:80px;height:<?php echo ($rowsagt1*180)/$sut;?>px;background:#F8E7B2;width:40px;box-shadow: 5px -5px 5px #c8c8c8;border:1px solid #EDC243;border-bottom:0px;"  tip="Search Sales Order<br><?php echo $rowsagt1;?>" class="blue"></div>
                </td>
                <td class="gap"></td>
                <td onClick="show_bar('t2')" style="vertical-align:bottom;cursor:pointer;background:#F9F9F9;" href="#tab2" data-toggle="tab">
                        <div style="width:80px;height:<?php echo ($rowsagt2*180)/$sut;?>px;background:#cf8bcb;width:40px;box-shadow: 5px -5px 5px #c8c8c8;border:1px solid #8C4D88;border-bottom:0px;"  tip="Delivery List<br><?php echo $rowsagt2;?>" class="blue"></div>
                </td>
                <td class="gap"></td>
            </tr></table></td>						
            <td valign="top" style="padding-top:20px;padding-left:10px;"><table border="0" class="leng">
                <tr><td class="tods"></td><td  style="cursor:pointer;" onClick="show_bar('t1')" href="#tab1" data-toggle="tab">Sales Order</td>
                </tr>
                <tr><td class="bak"></td><td style="cursor:pointer;" onClick="show_bar('t2')" href="#tab2" data-toggle="tab">Delivery List</td></tr>
            </table></td>
        </tr></table>
    </div>
</section></div>