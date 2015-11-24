<?php 
if(isset($_POST['submit'])) {
    $to = "jobs@highlandfarms.on.ca";
    $from = $_POST['email'];
    $first = $_POST['first'];
    $last = $_POST['last'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $title = $_POST['title'];
    $id = $_POST['id'];
    $resume = isset($_POST['file_resume_val']) ? $_POST['file_resume_val'] : "";
    $coverletter = isset($_POST['file_coverletter_val']) ? $_POST['file_coverletter_val'] : "";

    $email = "Job application submission:<br/><br/>
                    Job: $id - $title - $location<br/>
                    Name: $first $last<br/>
                    Email: $from<br/>
                    Phone: $phone<br/><br/>
                    Resume/Coverletter attached.

    ";
    send_ses_email($to, "JOB APPLICATION: Submission", $email, $_FILES);
    ?>
    <script type='text/javascript'>
        $(function() {
            $('body').append($("#tpl-product-modal").html());
            $('#detailModal').modal('show');  
        });
    </script>
    <?php
}
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
            <form method="post" action="" enctype="multipart/form-data">
              <div class="row">
	            <input type="hidden" name="location" value="<?=$details['location']?>" />
	            <input type="hidden" name="title" value="<?=$details['title']?>"/>
	            <input type="hidden" name="id" value="<?=$details['id']?>"/>
                <div class="col-xs-12 col-sm-6"><input name="first" type="text" value="" placeholder="First Name"/></div>
                <div class="col-xs-12 col-sm-6"><input name="last" type="text" value="" placeholder="Last Name"/></div>
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
                                <input type="hidden" name="file_resume_val" id="upload-resume-val"/>
                                <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="attachments[]" size="40"  onchange='$("#upload-resume").html($(this).val());$("#upload-resume-val").val($(this).val());' multiple/>
                            </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div style="position:relative;">
                            <a class='btn-file' href='javascript:;'>
                                <span class='label-file' id="upload-coverletter">Upload Cover Letter</span>
                                <input type="hidden" name="file_coverletter_val" id="upload-coverletter-val"/>
                                <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="attachments[]" size="40"  onchange='$("#upload-coverletter").html($(this).val());$("#upload-coverletter-val").val($(this).val());' multiple/>
                            </a>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12"><input name="submit" type="submit" value="Submit Application" class="green" style="margin-top: 15px" /></div>
              </div>
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