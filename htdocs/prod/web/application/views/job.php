</header>

<main class='job'>
    <div class="row">
        <div class='col-sm-12 text-danger'>
            <?php echo validation_errors(); ?>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12'>
            <p id="backto">
                <a href="/careers" class="backtolist"><span class='backtolist-arrow'>&lt; </span><span class='backtolist-copy'>Back to Listings</span></a>
                <h1 id="job-title-and-location"></h1>
            </p>
        </div>
    </div>
    <div class='row'>
        <div class='col-xs-12 col-sm-3'>
            <h3>Job Duties:</h3>
        </div>
        <div class='col-xs-12 col-sm-9' id='job-duties'>
        </div>
    </div>
    <div class='row' style="margin-top: 50px;">
        <div class='col-xs-12 col-sm-3'>
            <h3>Job Requirements:</h3>
        </div>
        <div class='col-xs-12 col-sm-9' id='job-requirements'>
        </div>
    </div>
    <div class='row' style="margin-top: 50px;">
        <div class='col-xs-12 col-sm-3'>
            <h3>Application:</h3>
        </div>
        <div class="col-xs-12 col-sm-9">
        		<div class="required-fields">* Required Fields</div>
            <form method="post" action="" enctype="multipart/form-data" id="job-application">
              <div class="row">
	            <input type="hidden" name="location" />
	            <input type="hidden" name="title" />
	            <input type="hidden" name="id" />
                <div class="col-xs-12 col-sm-6"><input name="firstName" type="text" value="<?=set_value('firstName')?>" placeholder="First Name*" title="First Name should not be left blank." x-moz-errormessage="First Name should not be left blank." required/></div>
                <div class="col-xs-12 col-sm-6"><input name="lastName" type="text" value="<?=set_value('lastName')?>" placeholder="Last Name*" title="Last Name should not be left blank." x-moz-errormessage="Last Name should not be left blank." required/></div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6"><input name="emailAddress" id="emailAddress" type="email" value="<?=set_value('emailAddress')?>" placeholder="Email*" required/></div>
                <div class="col-xs-12 col-sm-6"><input name="phoneNumber" id="phoneNumber" type="text" value="<?=set_value('phoneNumber')?>" placeholder="Phone Number*" title="Phone Number should not be left blank." x-moz-errormessage="Phone Number should not be left blank." required/></div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div style="position:relative;">
                            <a class='btn-file' href='javascript:;'>
                                <span class='label-file' id="upload-resume">Upload Resume*</span>
                                <input type="hidden" name="file_resume_val" id="upload-resume-val"/>
                                <input type="file" name="resume" id="upload-resume-file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="attachments[]" size="40" onchange='$("#upload-resume").html($(this).val().replace("C:\\fakepath\\", ""));$("#upload-resume-val").val($(this).val().replace("C:\\fakepath\\", ""));' required>
                            </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div style="position:relative;">
                            <a class='btn-file' href='javascript:;'>
                                <span class='label-file' id="upload-coverletter">Upload Cover Letter</span>
                                <input type="hidden" name="file_coverletter_val" id="upload-coverletter-val"/>
                                <input type="file" name="cover" id="upload-coverletter-file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="attachments[]" size="40" onchange='$("#upload-coverletter").html($(this).val().replace("C:\\fakepath\\", ""));$("#upload-coverletter-val").val($(this).val().replace("C:\\fakepath\\", ""));'>
                            </a>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12"><input name="submit" type="submit" value="Submit Application" class="green" style="margin-top: 15px" /></div>
              </div>
              <span class="error" id="form-status"></span>
            </form>
        </div>
    </div>

</main>

<script type='text/html' id='tpl-product-modal'>
<div class="modal fade otu" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-body">
              <div class="row">
                  <div class="col-s-12 text-center">
                      <h3>Successfully Submitted.</h3>
                  </div>
              </div>
              <span class="glyphicon glyphicon-remove close" data-dismiss="modal"></span>
          </div>
      </div>
  </div>
</div>
</script>

<script>
window.addEventListener('load', function () {
      hlf.data.careers = JSON.parse(<?php echo $details ?>);
      hlf.careers.renderSingleCareer(hlf.data.careers);
});
</script>