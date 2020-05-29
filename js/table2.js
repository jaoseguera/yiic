(function() {
    var flag=false;
    var tid; //table id as defined on html page
    var sheight;
    function ge$(d) {return document.getElementById(d);}
    this.scrollHeader = function() {
        if(flag) {
            return;
        }
		
        var fh=ge$('se');
        var sd=ge$(tid+':se');
        fh.style.left=(0-sd.scrollLeft)+'px';
    };
    function addseDivs() {
        if(ge$(tid+':se')) {
            return;
        }
        var sd=document.createElement("div");
        var tb=ge$(tid);
		
        sd.style.height="100%";
		
        sd.style.overflow='visible';
        sd.style.overflowX='auto';
        sd.style.overflowY='auto';
        
        sd.id=tid+':se';
        sd.onscroll=scrollHeader;
        
        var tb2=tb.cloneNode(true);
		
		
		
        sd.appendChild(tb2);
        tb.parentNode.replaceChild(sd,tb);
        var sd2=document.createElement("div");
        sd2.id='se:OuterDiv';
        sd2.style.cssText='position:relative;width:100%;height:100%;overflow:hidden;overflow-x:hidden;padding:0px;margin:0px;';
        sd2.innerHTML='<div id="se" style="position:relative;width:9999px;padding:0px;margin-left:0px;"><div id="se:content"><font size="3" color="red">Please wait while loading the table..</font></div></div>';
        sd.parentNode.insertBefore(sd2,sd);
    }
    function fxheader() {
		
        if(flag) {return;}
        flag=true;
        var tbDiv=ge$(tid);
        tbDiv.rows[0].style.display='';
        var twp=tbDiv.width;
        var twi=parseInt(twp);
        if(twp.indexOf("%") > 0) {
            twi=((ge$('se:OuterDiv').offsetWidth * twi) / 100)-20;
            twp=twi+'px';
            tbDiv.style.width=twp;
        }
        var oc=tbDiv.rows[0].cells;
        var fh=ge$('se');
        var tb3=tbDiv.cloneNode(true);
		
        tb3.id='se:content';
        tb3.style.marginTop = '0px';
        fh.replaceChild(tb3,ge$('se:content'));
        ge$('se:OuterDiv').style.height=oc[0].offsetHeight+'px';
        tbDiv.style.marginTop = "-" + tbDiv.rows[0].offsetHeight + "px";
        scrollHeader();
        if(tbDiv.offsetHeight < sheight) {
            ge$(tid+':se').style.height=tbDiv.offsetHeight + 'px';
        }
        window.onresize=fxheader;
        flag=false;
    }
    this.fxheaderInit = function(_tid,_sheight) {
		alert('hi');
        tid=_tid;
        sheight=_sheight;
        flag=false;
        addseDivs();
        fxheader();
    };
})();




