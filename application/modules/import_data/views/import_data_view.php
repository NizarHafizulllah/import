<style type="text/css">
	#drop-zone {
    /*Sort of important*/
    width: 300px;
    /*Sort of important*/
    height: 200px;
    position:absolute;
    left:50%;
    top:100px;
    margin-left:-150px;
    border: 2px dashed rgba(0,0,0,.3);
    border-radius: 20px;
    font-family: Arial;
    text-align: center;
    position: relative;
    line-height: 180px;
    font-size: 20px;
    color: rgba(0,0,0,.3);
}

    #drop-zone input {
        /*Important*/
        position: absolute;
        /*Important*/
        cursor: pointer;
        left: 0px;
        top: 0px;
        /*Important This is only comment out for demonstration purposes.
        opacity:0; */
    }

    /*Important*/
    #drop-zone.mouse-over {
        border: 2px dashed rgba(0,0,0,.5);
        color: rgba(0,0,0,.5);
    }


/*If you dont want the button*/
#clickHere {
    position: absolute;
    cursor: pointer;
    left: 50%;
    top: 50%;
    margin-left: -50px;
    margin-top: 20px;
    line-height: 26px;
    color: white;
    font-size: 12px;
    width: 100px;
    height: 26px;
    border-radius: 4px;
    background-color: #3b85c3;

}

    #clickHere:hover {
        background-color: #4499DD;

    }
</style>


<form action="<?php echo site_url($this->controller."/import") ?>" id="restoreform" enctype="multipart/form-data" method="post"  >
<div id="drop-zone">
    Seret File Disini...
    <div id="clickHere">
    
        atau klik disini..
        <input type="file" name="xlsfile" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
     
    </div>
</div>


<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div class="col-md-12" align="center"><input type="submit" class="btn btn-default" value="IMPORT"></div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</form>
<!-- <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Area Seret File Upload</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <p>Anda Dapat Mendrag File Pada Kotak Ini, Atau klik pada bagian kotak untuk memilih file yang akan di upload.</p>
                  <form action="<?php  echo site_url($this->controller.'/import') ?> " class="dropzone" style="border: 1px solid #e5e5e5; height: 300px; " id="myAwesomeDropzone"></form>

                  <br />
                  <br />
                  <br />
                  <br />
                </div>
              </div>
            </div>
          </div> -->

<script type="text/javascript">
	// $(document).ready(function(){
	// 	Dropzone.options.myAwesomeDropzone = false;
		
	// });

	$(function () {
    var dropZoneId = "drop-zone";
    var buttonId = "clickHere";
    var mouseOverClass = "mouse-over";

    var dropZone = $("#" + dropZoneId);
    var ooleft = dropZone.offset().left;
    var ooright = dropZone.outerWidth() + ooleft;
    var ootop = dropZone.offset().top;
    var oobottom = dropZone.outerHeight() + ootop;
    var inputFile = dropZone.find("input");
    document.getElementById(dropZoneId).addEventListener("dragover", function (e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.addClass(mouseOverClass);
        var x = e.pageX;
        var y = e.pageY;

        if (!(x < ooleft || x > ooright || y < ootop || y > oobottom)) {
            inputFile.offset({ top: y - 15, left: x - 100 });
        } else {
            inputFile.offset({ top: -400, left: -400 });
        }

    }, true);

    if (buttonId != "") {
        var clickZone = $("#" + buttonId);

        var oleft = clickZone.offset().left;
        var oright = clickZone.outerWidth() + oleft;
        var otop = clickZone.offset().top;
        var obottom = clickZone.outerHeight() + otop;

        $("#" + buttonId).mousemove(function (e) {
            var x = e.pageX;
            var y = e.pageY;
            if (!(x < oleft || x > oright || y < otop || y > obottom)) {
                inputFile.offset({ top: y - 15, left: x - 160 });
            } else {
                inputFile.offset({ top: -400, left: -400 });
            }
        });
    }

    document.getElementById(dropZoneId).addEventListener("drop", function (e) {
        $("#" + dropZoneId).removeClass(mouseOverClass);
    }, true);

})
</script>