<?php

?>

</header>

<main class='careers'>
    <div class='row'>
        <div class='col-sm-12'>
            <h1>Join Us.</h1>
            <h2>Start fresh with a Career at Highland Farms! </h2>
            <p>
                We are always looking for driven individuals to join our team. Working at one of our stores is more than a job. It's an opportunity to learn and grow, both personally and professionally, and be a part of the Highland Farms' family.
            </p>
            <p>
                We have two full service supermarkets, so click on the store that is closest to you and start a fresh career with us!
            </p>
        </div>
    </div>
    <div class='row'>
        <div class='col-xs-12 col-sm-3'>
            <h2>Scarborough</h2>    
            <p>850 Ellesmere Road </br/>
              Scarborough, ON, M1P 2W5 </p>
        </div>
        <div class='col-xs-12 col-sm-9'>
            <?php foreach ($joblistings as $job) { ?>
                <?php if ($job['location'] == "Scarborough") { ?>
                <a href="/careers/<?=$job['id']?>">
                    <div class='job-row'>
                        <div class='job-row-title'>
                            <?=$job['title']?>
                        </div>
                        <div class='job-row-date'>
                            Posted <?=$time = date('F n, Y', strtotime($job['date_posted']))?>
                        </div>
                        <div class="clearer"></div>
                    </div>
                </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class='row' style="margin-top: 20px;">
        <div class='col-xs-12 col-sm-3'>
            <h2>Mississauga</h2>
            <p>50 Matheson Blvd. East </br/>
            Mississauga, ON, L4Z 1N5 </p>
        </div>
        <div class='col-xs-12 col-sm-9'>
            <?php foreach ($joblistings as $job) { ?>
                <?php if ($job['location'] == "Mississauga") { ?>
                <a href="/careers/<?=$job['id']?>">
                <div class='job-row'>
                    <div class='job-row-title'>
                        <?=$job['title']?>
                    </div>
                    <div class='job-row-date'>
                        Posted <?=$time = date('F n, Y', strtotime($job['date_posted']))?>
                    </div>
                    <div class="clearer"></div>
                </div>
                </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    
</main>
