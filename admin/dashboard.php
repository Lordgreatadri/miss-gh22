<?php
    require_once 'controllers/db-config.php';
    session_start();
    $session_id = "";
    if (!isset($_SESSION['DUserLoggedIn'])) {
        echo "<script>window.location.href = 'index.php';</script>";
    }

    $session_id = $_SESSION['session_id'];
    $username   = $_SESSION['username'];
    $insertUserQuery = "UPDATE log_hist SET dashboard_tab = 'Dashboard Viewed' WHERE session_id = '$session_id' AND username = '$username'";
    mysqli_query($database, $insertUserQuery);

    include 'includes/header.php';
?>

        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light navbar-custom">
            <a class="navbar-brand" href="#">
                <!-- <img src="assets/img/logo.jpg" alt="logo" class="navbar-logo"> -->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <?php //if($_SESSION['username'] == 'commercial@admin.com'): ?>
                    <?php// else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="contestants.php">Contestants</a>
                    </li>                                          
                    <?php// endif ?>
                    <li class="nav-item">
                        <a class="nav-link" href="votes.php">Voters</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://bit.ly/missgha" target="_blank">Cast Vote</a>
                    </li>

                    <!-- <li class="nav-item">
                        <a class="nav-link" href="gallery.php">Image Upload</a>
                    </li> -->


                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Live Stream</a>
                    </li> -->



                    <!-- <li class="nav-item">
                        <a class="nav-link" href="facebook-live-feed.php">Articles</a>
                    </li> -->

                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid main-div">
            <div class="row">
                <!-- side div live_stream.php-->
                <div class="col-md-2 side-div">
                    <li class="selected"><a href="dashboard.php"><span class="lnr lnr-pie-chart"></span> Dashboard</a></li>
                    <?php if($_SESSION['username'] == 'commercial@admin.com'): ?>
                    <?php else: ?>
                    <li><a href="contestants.php"><span class="lnr lnr-users"></span> Contestants</a></li>
                    <?php endif ?>
                    <li><a href="various-channels.php"><span class="lnr lnr-users"></span> Various Channels</a></li>
                    <li><a href="votes.php"><span class="lnr lnr-thumbs-up"></span> Voters</a></li>


                    <li><a href="https://bit.ly/missgha" target="_blank"><span class="lnr lnr-thumbs-up"></span> Cast Vote</a></li>

                    <!-- <li><a href="gallery.php"><span class="lnr lnr-picture"></span> Image Upload</a></li> -->
                    <!-- <li><a class="nav-link" href="#"><span class="lnr lnr-camera-video"></span> Live Stream</a></li> -->
                    <hr>
                    <li><a href="logout.php"><span class="lnr lnr-power-switch"></span> Logout</a></li>
                </div>

                <!-- main content div -->
                <div class="col-md-10 content-div">
                    <div class="row">
                        <div class="col-md-4 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="dashboard-cont-status-div alert alert-secondary">
                                <div class="dashboard-cont-status-main-div">
                                    <h1 class="number-of-contestants-res"><img src="assets/img/loader.svg"></h1>
                                    <p>Total Contestants</p>
                                </div>
                                <div class="dashboard-cont-status-sub-div">
                                    <div class="text-success">
                                        <h5><small><span class="number-of-remaining-contestants-res"></span> Remaining</small></h5>
                                    </div>

                                    <div class="text-danger">
                                        <h5><small><span class="number-of-evicted-contestants-res"></span> Evicted</small></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-md-2 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="alert alert-light">
                                <h3 class="text-center number-of-sms-votes-res"><img src="assets/img/loader.svg"></h3>
                                <p class="text-center"><small>SMS Votes Count</small></p>
                            </div>
                        </div> -->
                        <div class="col-md-2 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="alert alert-light">
                                <h3 class="text-center number-of-sms-votes-res"><img src="assets/img/loader.svg"></h3>
                                <p class="text-center"><small>Visa Votes Count</small></p>
                            </div>
                        </div>

                        <div class="col-md-2 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="alert alert-warning">
                                <h3 class="text-center number-of-momo-votes-res"><img src="assets/img/loader.svg"></h3>
                                <p class="text-center"><small>MoMo Votes Count</small></p>
                            </div>
                        </div>

                        <div class="col-md-4 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="dashboard-cont-status-div alert alert-success">
                                <div class="dashboard-cont-status-main-div">
                                    <h3 class="number-of-votes-res"><img src="assets/img/loader.svg"></h3>
                                    <p>Total Votes Count</p>
                                </div>
                                <div class="dashboard-cont-status-sub-div">
                                    <div class="text-success">
                                        <h5><small><span class="number-of-valid-votes-res"><img src="assets/img/loader.svg"></span> Valid Votes</small></h5>
                                    </div>

                                    <!-- <div class="text-danger">
                                        <h5><small><span class="number-of-invalid-votes-res"><img src="assets/img/loader.svg"></span> Invalid Votes</small></h5>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    

                    <!-- <div class="row">
                        <div class="col-md-4 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="dashboard-cont-status-div alert alert-secondary">
                                <div class="dashboard-cont-status-main-div">
                                    <h3 class="total-revenue-res"><img src="assets/img/loader.svg"></h3>
                                    <p>Momo Revenue</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="alert alert-light">
                                <h3 class="text-center number-of-visa-votes-res"><img src="assets/img/loader.svg"></h3>
                                <p class="text-center"><small>Visa Votes Count</small></p>
                            </div>
                        </div>

                        <div class="col-md-2 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="alert alert-warning">
                                <h3 class="text-center visa-amount-res"><img src="assets/img/loader.svg"></h3>
                                <p class="text-center"><small>Visa Revenue</small></p>
                            </div>
                        </div>


                        <div class="col-md-4 wow zoomIn" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                            <div class="dashboard-cont-status-div alert alert-success">
                                <div class="dashboard-cont-status-main-div">
                                    <h3 class="total-revenue-amount-res"><img src="assets/img/loader.svg"></h3>
                                    <p>Total Revenue</p>
                                </div>
                                
                            </div>
                        </div>

                    </div>
 -->




                    <br><hr><br>

                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="text-center">Overall Contestant Rankings [<a href="#leaderboard-detail-modal" data-toggle="modal"><small>view full screen</small></a>]  &nbsp;&nbsp; [<a href="controllers/export_contestant-vote.php"><small>export overall votes</small></a>]</h6>
                            <canvas id="leaderboardChart" height="300" width="400"></canvas>
                        </div>
                       <!--  <div class="col-md-6">
                            <h6 class="text-center">Contesants Rankings This Week [<a href="#stats-detail-modal" data-toggle="modal"><small>view full screen</small></a>] &nbsp;&nbsp; [<a href="controllers/export_contestant_weekly.php"><small>export weekly votes</small></a>]</h6>
                            <div class="data-res-placeholder-div">
                                <img src="assets/img/spinner.gif" class="img-fluid data-res-placeholder-div-img">
                                <p class="text-warning"><b>Loading. Please wait...</b></p>
                            </div>
                            <canvas id="weeklyLeaderBoardChart" height="300" width="400"></canvas>
                        </div> -->
                    </div>
                    <br><hr><br>

                    <div class="row">

                        <div class="col-md-6">
                            <h6 class="text-center">Overall Voters Rankings</h6>
                            <canvas id="votersLeaderBoardChart" height="250" width="400"></canvas>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-center">Overall Voters Rankings</h6>
                            <canvas id="votersLeaderBoardBarChart" height="250" width="400"></canvas>
                        </div>
                    </div>

                    <br><hr><br>


                    <div class="row">

                        <div class="col-md-6">
                            <h6 class="text-center">Weekly Highest Voters. <b>[<span class="text-danger 2x">Right click to save image.</span>]</b></h6>
                            <canvas id="votersLeaderBoardPieChart" height="250" width="400"></canvas>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-center">Highest Voters This Week</h6>
                            <canvas id="weeklyVotersLeaderBoardChart" height="250" width="400"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- modal to show the full screen display of the votes for the contestants -->
        <div class="modal fade full-screen-modal" id="stats-detail-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white"><b>Votes statistics for this week</b></h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <canvas id="weeklyLeaderBoardFullScreenChart" height="250" width="400"></canvas>
                </div>
                </div>
            </div>
        </div>

        <!-- modal to show the full screen for the overall votes for the contestants -->
        <div class="modal fade full-screen-modal" id="leaderboard-detail-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white"><b>Conestant Overall Vote Statistics</b></h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <canvas id="leaderBoardFullScreenChart" height="250" width="400"></canvas>
                </div>
                </div>
            </div>
        </div>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/controller.js"></script>
<script>
    getDashboardSummary();
    showLeaderBoardGraph();
    showVotersLeaderBoardGraph();

    showVotersLeaderBoardBarChart();
    showVotersLeaderBoardPiechart();

    showWeeklyVotersRankings();
    // showContestantLeaderBoardForWeek();
    // showContestantModalLeaderBoardForWeek();
    showLeaderBoardModal();
</script>

 