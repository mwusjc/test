</header>
<main class='careers'>
    <div class='row job-fair-cta'>
      <div class='col-sm-12'>
          <h1 class='job-fair-heading'>Highland Farms Job Fair</h1>

          <div class='row'>
            <div class='col-sm-12 col-md-6'>
              <h2 class='job-fair-subheading-2'>Now Hiring All Positions</h2>

              <p class='job-fair-date'><span class='job-fair-bold'>Monday, 9th of January</span> - <br class='mobile'/>12:30 pm to 3:00 pm</p>
              <p class='job-fair-date'><span class='job-fair-bold'>Tuesday, 10th of January</span> - <br class='mobile'/>9:00 am to 12:00 pm</p>
              <p class='job-fair-date'><span class='job-fair-bold'>Thursday, 12th of January</span> - <br class='mobile'/>5:00 pm to 7:30 pm</p>
              <p class='job-fair-date'><span class='job-fair-bold'>Monday, 16th of January</span> - <br class='mobile'/>9:00 am to 12:00 pm</p>
              <p class='job-fair-date'><span class='job-fair-bold'>Tuesday, 17th of January</span> - <br class='mobile'/>12:30 pm to 3:00 pm</p>

              <p class='job-fair-details'><span class='job-fair-bold'>Please do not email resum&eacute;s.</span> Bring your resum&eacute; to the job fair. Interviews will be conducted on site.</p>
            </div>
            <div class='col-sm-12 col-md-6 job-fair-details-right'>
              <h2 class='job-fair-subheading-2'>New Store Opening In Vaughan</h2>

              <p>
                <span class='new-store-info job-fair-bold'>1490 Major Mackenzie Drive West Unit D5</span>
                <br/>
                (North East Corner of Major Mackenzie Dr. W. and Dufferin St.) Vaughan, Ontario
                <br/>
                <span class='new-store-info job-fair-bold'>416-491-5050 Ext 44600</span>
              </p>
              <img src="/assets/images/seneca-logo.png" alt="Seneca" />
            </div>
          </div>

      </div>
    </div>
    <div class='row'>
        <div class='col-sm-12'>
            <h1>Join Us.</h1>
            <h2>Start fresh with a Career at Highland Farms! </h2>
            <p>We are always looking for driven individuals to join our team. Working at one of our stores is more than a job. It's an opportunity to learn and grow, both personally and professionally, and be a part of the Highland Farms' family.</p>
            <p>Please send your resume to <a href="mailto:jobs@highlandfarms.on.ca" _target="blank" style="display:inline">jobs@highlandfarms.on.ca</a></p>
        </div>
    </div>
    <div class="spacer-20"></div>

    <div class='row'>
        <div class='col-xs-12 col-sm-3'>
            <h2>Scarborough</h2>
            <p>850 Ellesmere Road </br/>
              Scarborough, ON, M1P 2W5 </p>
        </div>
        <div class='col-xs-12 col-sm-9' id='scarborough-careers'>
        </div>
    </div>

    <div class='row' style="margin-top: 20px;">
        <div class='col-xs-12 col-sm-3'>
            <h2>Mississauga</h2>
            <p>50 Matheson Blvd. East </br/>
            Mississauga, ON, L4Z 1N5 </p>
        </div>
        <div class='col-xs-12 col-sm-9' id='mississauga-careers'>
        </div>
    </div>
    
</main>

<script type="text/html" id="tpl-career-listing">
  <a href="/careers/_JOBID_">
    <div class='job-row'>
      <div class='job-row-title'>
        _JOBTITLE_
      </div>
      <div class='job-row-date'>
         Posted _POSTED_
      </div>
      <div class="clearer"></div>
    </div>
  </a>
</script>

<script>

  jQuery(document).ready(function($) {

    hlf.data.careers = JSON.parse(<?php echo $joblistings ?>);
    hlf.careers.renderCareers(hlf.data.careers);
  });

</script>
