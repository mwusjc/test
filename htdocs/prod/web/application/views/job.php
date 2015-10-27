<?php

?>

</header>

<main class='job'>
    <div class='row'>
        <div class='col-sm-12'>
            <p id="backto">
                <a href="/careers" class="backtolist"><span class='backtolist-arrow'>&lt; </span><span class='backtolist-copy'>Back to Listings</span></a>
                <h1><?=$details['title']?> - <?=$details['location']?></h1>
            </p>
        </div>
    </div>
    <div class='row'>
        <div class='col-xs-12 col-sm-3'>
            <h3>Job Duties:</h3>
        </div>
        <div class='col-xs-12 col-sm-9'>
            <?=$details['details']['duties']?>
        </div>
    </div>
    <div class='row' style="margin-top: 50px;">
        <div class='col-xs-12 col-sm-3'>
            <h3>Job Requirements:</h3>
        </div>
        <div class='col-xs-12 col-sm-9'>
            <?=$details['details']['requirements']?>
        </div>
    </div>
    <div class='row' style="margin-top: 50px;">
        <div class='col-xs-12 col-sm-3'>
            <h3>Application:</h3>
        </div>
        <div class="col-xs-12 col-sm-9">
            <form>
              <div class="row">
                <div class="col-xs-12 col-sm-6"><input name="first_name" type="text" value="" placeholder="First Name"/></div>
                <div class="col-xs-12 col-sm-6"><input name="last_name" type="text" value="" placeholder="Last Name"/></div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6"><input name="email" type="text" value="" placeholder="Email"/></div>
                <div class="col-xs-12 col-sm-6"><input name="phone" type="text" value="" placeholder="Phone Number"/></div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div style="position:relative;">
                            <a class='btn-file' href='javascript:;'>
                                <span class='label-file' id="upload-resume">Upload Resume</span>
                                <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_resume" size="40"  onchange='$("#upload-resume").html($(this).val());'>
                            </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div style="position:relative;">
                            <a class='btn-file' href='javascript:;'>
                                <span class='label-file' id="upload-coverletter">Upload Coverletter</span>
                                <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_coverletter" size="40"  onchange='$("#upload-coverletter").html($(this).val());'>
                            </a>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12"><input type="submit" value="Submit Application" class="green" style="margin-top: 15px" /></div>
              </div>
            </form>
        </div>          
    </div>
    
</main>
