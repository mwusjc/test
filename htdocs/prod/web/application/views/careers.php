</header>
<main class='careers'>
    <div class='row'>
        <div class='col-sm-12'>
            <h1>Join Us.</h1>
            <h2>Start fresh with a Career at Highland Farms! </h2>
            <p>We are always looking for driven individuals to join our team. Working at one of our stores is more than a job. It's an opportunity to learn and grow, both personally and professionally, and be a part of the Highland Farms' family.</p>
            <p>We are always hiring. Please send your resume to <a href="mailto:jobs@highlandfarms.on.ca?subject=Resume from {your name here}" _target="blank" style="display:inline">jobs@highlandfarms.on.ca</a></p>
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
