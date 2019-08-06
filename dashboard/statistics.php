<?php

/*
Template Name: User Statistics
*/

checklogin('/login/');

global $theuser;

$idbio = getBio($theuser->ID,'id');

/*
*
* Get statistics complete
*
*/
//Get the total landing visits
$dbstats = getStatsBio($idbio,getparams('t'));
//Count them
$totalvisits = count($dbstats);

//Filter for make a map all data
$countrymap = _getCountryMap($dbstats);

//save the clean data map for other use
$countrymapclean = $countrymap;
//Add labels to the map data array
if(is_array($countrymap))
    array_unshift($countrymap,array('Country','Visits'));


// Get all data for links clicked for referal and destination use (ENGAGEMENT)
$clicks = getClicksBio($idbio,getparams('t'));
//Count them
$totalrefs = count($clicks);

//Format the clicks for create the graphic chart
$clickstats = _getClicksStats($clicks);
//Separate the 2 array for create the chart (Labels and Series)
$labelchart = array();
$serieschart = array();

if(is_array($clickstats)){
    foreach ($clickstats as $key => $value) {
        $labelchart[] = date("d-M", strtotime($value[0]));
        $serieschart[] = $value[1];
    }
}

//Get all the referral array
$refs = _getReferal($dbstats);
//Get ll the destination array
$dest = _getDestinations($clicks);

get_header('app');
?>
	<main id="user-account-page">
		<div class="container">
			<h1 class="mb-4">Statistics</h1>

            <nav class="navbar navbar-expand-lg navbar-light bg-white small-shadow rounded mb-5">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsFilterStats" aria-controls="navbarsFilterStats" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsFilterStats">
                    <ul class="navbar-nav selectednav">

                        <li class="nav-item <?php echo (getparams('t') == 'today' || getparams('t') == '') ? "active" : "";?>">
                            <a class="nav-link" href="<?php the_permalink();?>?t=today"><?php _e('Today','growlink');?></a>
                        </li>
                        <li class="nav-item <?php echo (getparams('t') == 'week') ? "active" : "";?>">
                            <a class="nav-link" href="<?php the_permalink();?>?t=week"><?php _e('Last week','growlink');?></a>
                        </li>
                        <li class="nav-item <?php echo (getparams('t') == 'month') ? "active" : "";?>">
                            <a class="nav-link" href="<?php the_permalink();?>?t=month"><?php _e('Last month','growlink');?></a>
                        </li>
                        <li class="nav-item <?php echo (getparams('t') == 'sixmonth') ? "active" : "";?>">
                            <a class="nav-link" href="<?php the_permalink();?>?t=sixmonth"><?php _e('Last 6 month','growlink');?></a>
                        </li>
                    </ul>
                </div>
            </nav>


            <div class="row mt-3">
                <div class="col-md-7">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="text-primary"><?php _e('Total visits','growlink');?></h4>

                            <div id="lineal_stats_div" class="mt-4">
                                <?php if(empty($labelchart)){?>
                                <p><?php _e('There is no data to show.','growlink');?></p>
                                <?php }?>
                            </div>

                            <?php if(!empty($labelchart)){?>
                            <script>
                                new Chartist.Line('#lineal_stats_div', {
                                    labels: <?php echo json_encode($labelchart);?>,
                                    series: [<?php echo json_encode($serieschart);?>]
                                },{
                                    low: 0,
                                    showArea: true,
                                    width: '100%',
                                    height: '300px',
                                    axisY: {
                                        onlyInteger: true,
                                        offset: 20
                                    }
                                });
                            </script>
                            <?php }?>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="mb-3 mb-md-5">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="text-primary"><?php _e('Engagement','growlink');?></h4>
                                <p>
                                    <?php _e('Total visits','growlink');?>: <?php echo $totalvisits;?><br>
                                    <?php _e('Total clicks','growlink');?>: <?php echo $totalrefs;?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        	<div class="row mt-3 mb-5">
                <div class="col-md-7">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="text-primary"><?php _e('Traffic by countries','growlink');?></h4>
                            <div id="map_stats_div" class="mb-4">
                                <?php if(!is_array($countrymap)){?>
                                <p><?php _e('There is no data to show.','growlink');?></p>
                                <?php }?>
                            </div>

                            <?php if(is_array($countrymap)){?>
                            <script>
                            google.charts.load('current', {'packages':['geochart'],'mapsApiKey': 'AIzaSyBDA_HeHcaT3RBvqk1KX4wpNw9PVmlmfyw'});
                            google.charts.setOnLoadCallback(drawRegionsMap);

                            function drawRegionsMap() {
                                var data = google.visualization.arrayToDataTable(
                                <?php echo json_encode($countrymap);?>);

                                var options = {width: "100%",height: window.screen.height%2,colors: ['#F4DDB7','#4137CF']};
                                var chart = new google.visualization.GeoChart(document.getElementById('map_stats_div'));
                                chart.draw(data, options);
                            }
                            </script>
                            <?php }?>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="text-primary"><?php _e('Country Stats','growlink');?></h4>
                            <?php if(is_array($countrymap)):?>
                                <table class="table">
                                    <thead class="thead-light">
                                        <th><?php _e('Country','growlink');?></th>
                                        <th><?php _e('Visits','growlink');?></th>
                                    </thead>
                                    <?php
                                    $i = 0;
                                    foreach ($countrymapclean as $v) {
                                        $i++;
                                        echo "<tr><td><span class='flag-icon flag-icon-".strtolower($v[0])."'></span> " . $v[0] . "</td><td>" . number_format($v[1]/$totalvisits * 100) . "% ($v[1] visits)</td></tr>";
                                        if($i == 6) break;
                                    }?>
                                </table>
                                <a href="#" data-toggle="modal" data-target="#viewcountryvisits-modal" class="btn btn-primary btn-xs d-block">VIEW ALL</a>

                                <div class="modal fade modal-blank" id="viewcountryvisits-modal" tabindex="-1" role="dialog" aria-labelledby="addcontent-modallabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addcontent-modallabel">Visits</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#999"><path d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z"/></svg>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <thead>
                                                    <th><?php _e('Country','growlink');?></th>
                                                    <th><?php _e('Visits','growlink');?></th>
                                                </thead>
                                                <?php
                                                $i = 0;
                                                foreach ($countrymapclean as $v) {
                                                    $i++;
                                                    echo "<tr><td><span class='flag-icon flag-icon-".strtolower($v[0])."'></span> " . $v[0] . "</td><td>" . number_format($v[1]/$totalvisits * 100) . "% ($v[1] visits)</td></tr>";
                                                    if($i == 30) break;
                                                }?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php else :?>
                            <p><?php _e('There is no data to show.','growlink');?></p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referrals and Destinations -->

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="mb-4 text-primary"><?php _e('Top referring sites','growlink');?></h4>
                            <?php if(is_array($refs)):?>
                                <table class="table">
                                    <thead class="thead-light">
                                        <th><?php _e('Sites','growlink');?></th>
                                        <th><?php _e('Average','growlink');?></th>
                                    </thead>
                                    <?php
                                    $i = 0;
                                    foreach ($refs as $v) {
                                        $i++;
                                        echo "<tr><td><span></span> " . $v[0] . "</td><td>" . number_format($v[1]/$totalvisits * 100) . "% ($v[1] visits)</td></tr>";
                                        if($i == 20) break;
                                    }?>
                                </table>

                            <?php else :?>
                            <p><?php _e('There is no data to show.','growlink');?></p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="mb-4 text-primary"><?php _e('Top destination sites','growlink');?></h4>
                            <?php if(is_array($dest)):?>
                                <table class="table">
                                    <thead class="thead-light">
                                        <th><?php _e('Links','growlink');?></th>
                                        <th><?php _e('Average','growlink');?></th>
                                    </thead>
                                    <?php
                                    $i = 0;
                                    foreach ($dest as $v) {
                                        $i++;
                                        echo "<tr><td><span></span> " . $v[0] . "</td><td>" . number_format($v[1]/$totalrefs * 100) . "% ($v[1] visits)</td></tr>";
                                        if($i == 20) break;
                                    }?>
                                </table>

                            <?php else :?>
                            <p><?php _e('There is no data to show.','growlink');?></p>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</main>

<?php get_footer('app');?>