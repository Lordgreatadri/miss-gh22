<?php 
    require_once 'config.php';
    $name = "";
    $id   ="";
    $group_alias = "";
    $contestant_id = "";
    $profile = "";
    $category = "";
    // $serverName = "127.0.0.1";
    // $databaseName = "behind_voice"; //
    // $databaseUser = "root";
    // $databasePassword = ''; #"#4kLxMzGurQ7Z~"; Mccg8(3P^tJVnBDsF

    // $database = mysqli_connect($serverName, $databaseUser, $databasePassword, $databaseName);

  
    // var_dump($_REQUEST['me']);
    if(isset($_REQUEST['me']) && !empty($_REQUEST['me'])) 
    {
        // $name = $_GET['me'];
        $id   = $_GET['me'];//q
        $profile = "";
        if (!empty($id)) 
        {
           // $data = mysqli_query($database, "SELECT * FROM contestants WHERE contestant_id ='$id' AND status = 'not_evicted' LIMIT 1");
           //  foreach(   mysqli_fetch_assoc($data) as $row) 
           //  {
           //     $name = $row['contestant_name'];
           //     $profile = $row['thumbnail'];
           //     $group_alias = $row['contestant_num'];
           //     $contestant_id = $row['contestant_id']; 
           //     $category = $row['contestant_region']; 
           //  }
        }
        // var_dump($name);
    
    

?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<html>
<head>
    <title>Miss Ghana [ <?php echo $_GET['q']; ?> ]</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="Lordgreat-Adri Emmanuel">
    <!-- Favicon icon -->
    <link rel="icon" href="../web_vendors/assets/images/auth/favicon.ico" type="image/x-icon">


    <!-- Favicon icon -->
    <link rel="icon" href="../web_vendors/assets/images/auth/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="../web_vendors/bower_components/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="../web_vendors/assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="../web_vendors/assets/icon/icofont/css/icofont.css">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="../web_vendors/assets/icon/feather/css/feather.css">
    <!-- light gallery css -->
    <!--<link rel="stylesheet" type="text/css" href="../web_vendors/bower_components/lightgallery/css/lightgallery.min.css">-->
    <!-- Select 2 css -->
    <link rel="stylesheet" href="../web_vendors/bower_components/select2/css/select2.min.css" />
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="../web_vendors/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../web_vendors/assets/css/jquery.mCustomScrollbar.css">


    <style type="text/css">
    /* CSS used here will be applied after bootstrap.css */

    body { 
    /* background: url('404.jpg') no-repeat center center fixed; 'http://www.bootdey.com/img/Content/bg_element.jpg'*/
     -webkit-background-size: cover;
     -moz-background-size: cover;
     -o-background-size: cover;
     background-size: cover;
    }

    .panel-default {
     opacity: 0.9;
     margin-top:30px;
    }
    .form-group.last {
     margin-bottom:0px;
    }
    .mymodal {
        /*background: rgba(255, 255, 255, 1);*/
        display: flex;
        flex-direction: row;
        justify-content: center;
        justify-items: center;
        align-content: center;
        /*display: none;*/
    }
</style>

</head>
<body style="background: url('banner.png') repeat center center fixed;">

    <script>
    function pressme(){
        $("#testModal").modal('show');//url('404.jpg') no-repeat center center fixed;
    }
</script>
        <div class="container">
            <div class="row">
                <div class="mymodal col-md-8"><button style="margin: 150px;" class="btn btn-success press" onclick="pressme();">Press Me</button></div>
                    <div class="modal  bootstrap snippet  wow zoomIn mymodal" data-keyboard="false"  data-backdrop="static" id="testModal" tabindex="-1" data-wow-duration='0.5s' data-wow-delay='0.3s'>
                        <div class="modal-dialog" >
                            <div class="modal-content">
                                <?php 
                                $id   = $_GET['me'];
                                $data = mysqli_query($database, "SELECT contestant_id, thumbnail, contestant_name FROM contestants WHERE contestant_id ='$id' AND status = 'not_evicted' LIMIT 1");
                                $results = mysqli_fetch_assoc($data);

                                // var_dump($results['thumbnail']);
                                // echo $results['thumbnail'];
                                // foreach( $results as $row) 
                                // {
                                //    // $name = $row['contestant_name'];
                                //    $profile = $row['thumbnail'];
                                //    // $group_alias = $row['contestant_num'];
                                //    // $contestant_id = $row['contestant_id']; 
                                //    // $category = $row['contestant_region']; 
                                // }

                                ?>
                                
                                <div class="modal-header">
                                    <img src="banner.png" style="margin-top: 5px; width: 50px; height: 50px; margin-bottom: 5px; border-radius: 100%;" class="img-fluid" >

                                    <h4 class="modal-title pull-right">Payment Plan for [ <b> <?php echo $_GET['q']; ?> </b> ]</h4>
                                    <button class="close pull-left" data-dismiss="modal">&times;</button>
                                </div>
                                <img src="<?php echo $results['thumbnail']; ?>">
                               <!--  <div class="">
                                    <div class="col-md-8">
                                        <img style="width: 250px; height: 160;" src="<?php// echo $results['thumbnail']; ?>" alt="photo of contestant" class="constant-detail-img contestant-img">
                                    </div>
                                </div> -->
                                <!-- action="process_payment.php"  method="post"<hr style="border: 1px solid silver; width: 100%"> 22.5  -->
                                 <form  name="payment" id="payment" class="payment"  onsubmit="return validateEntryForm();">
                                    <div id="form_div">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="amount">Bulk Vote</label>
                                                <select name="amount" class="form-control amount" id="amount">
                                                    <option value="">select bulk votes</option>
                                                    <option value="1">Gh1.00 => 1 vote</option>
                                                    <option value="5">Gh5 => 5 votes</option>
                                                    <option value="10">Gh10.00 => 10 votes</option>
                                                    <option value="25">Gh25.00 => 25 votes</option>
                                                    <option value="50">Gh50.00 => 50 votes</option>
                                                    <option value="100">Gh100.00 => 100 votes</option>
                                                    <option value="250">Gh250.00 => 250 votes</option>
                                                    <option value="500">Gh500.00 => 500 votes</option>
                                                    <option value="1000">Gh1000.00 => 1000 votes</option>
                                                </select>
                                            </div>

                                            <div class="form-group inline">
                                                <label for="inputUserName">Choose payment option</label> <br>

                                                <label class="radio-inline">
                                                    <input type="radio" name="channel" class="channel" value="mtn-gh" id="mtn-gh" onClick="return checkIfVisacard()">
                                                    <img src="../web_vendors/assets/images/logo_mtn.png" style="margin-top: 0px; margin-bottom: 5px; border-radius: 100%; width: 35px; height: 35px;" class="img-fluid">
                                                </label>

                                               <label class="radio-inline">
                                                    <input type="radio" name="channel" class="channel" value="tigo-gh" id="tigo-gh" onClick="return checkIfVisacard()">
                                                    <img src="airtel_tigo.png" style="margin-top: 0px; margin-bottom: 5px; border-radius: 100%; width: 35px; height: 35px;" class="img-fluid">
                                                </label>

                                                <!-- <label class="radio-inline">
                                                    <input type="radio" name="channel" class="channel" value="airtel-gh" id="airtel-gh" onClick="return checkIfVisacard()">
                                                    <img src="../files/assets/images/logo_airtel.png" style="margin-top: 0px; margin-bottom: 5px; border-radius: 100%; width: 35px; height: 35px;" class="img-fluid">
                                                </label> -->

                                                <label class="radio-inline">
                                                    <input type="radio" name="channel" class="channel" id="rad_voda_token" value="vodafone-gh-ussd" onClick="return checkIfVisacard();">
                                                    <img src="vodafone.png" style="margin-top: 0px; margin-bottom: 5px; border-radius: 100%; width: 35px; height: 35px;" class="img-fluid"><!-- ../files/assets/images/logo_voda.png -->
                                                </label>


                                                <label class="radio-inline">
                                                    <input type="radio" name="channel" class="channel" id="visa_card" value="visa_card" onClick="return checkIfVisacard()">
                                                    <img src="../web_vendors/assets/images/logo_visa.png" style="margin-top: 5px; margin-bottom: 5px; border-radius: 100%; width: 65px; height: 65px;" class="img-fluid">
                                                </label>


                                                 <label class="checkbox-inline" id="termsCheck">
                                                    <small>
                                                        <span style="color: black; ">
                                                        1. Services (voting) once consumed are not refundable. <br>
                                                        2. Voting influences eviction of contestants in the competition and cannot be reversed after vote count has been acknowledged. <br>
                                                        3. Votes cannot be transferred from one contestant to another, therefore, kindly check to confirm you have selected the right contestant’s details.</span>
                                                    </small> <br>
                                                    
                                                    <input type="checkbox" name="terms" class="terms" id="terms"  onClick="return checkIfTermsChecked()">
                                                    <label style="color: blue; font-weight: bold;">Accept and continue</label>
                                                </label>
                                                 
                                                <br>
                                            </div>


                                            <div class="form-group">
                                                <label for="mobile_number" id="mobile_number">Mobile Number</label>
                                                <label for="phone_numb" id="mobile_money_number">Mobile Money Number</label>
                                                <input type="text" class="form-control number" name="number" id="phone_numb" placeholder="mobile number" required="">
                                               
                                            </div>

                                            <button class="btn btn-sm btn-success" type="submit" name="send">Cast Vote</button>
                                        </div>

                                        <div class="modal-footer">
                                           
                                            <input type="hidden" name="contestant_id" id="contestant_id" class="contestant_id"  value="<?php echo $_GET['me']; ?>">
                                             <input type="hidden" name="nominee_name" id="contestant_name" class="nominee_name"  value="<?php echo $_GET['q']; ?>">
                                             <!-- <input type="hidden" name="contestant_num" id="contestant_num"  value="<?php// echo $row['contestant_num']; ?>">
                                             <input type="hidden" name="category" id="category"  value="<?php// echo $row['contestant_region']; ?>"> -->
                                             <input type="hidden" name="api_key" class="api_key" value="33ffc38bcaff137103b94abb0480f966">
                                        </div>

                                    </div>
                                </form>

                                <div class="row" id="opt_div">
                                    <div class="form-group col-md-10 col-sm-10">
                                        <label for="token" style="margin: 10px;">Enter the OTP Token sent to your phone</label>
                                        <input type="text" class="form-control" name="opt_code" id="opt_code" placeholder="Enter OTP Code" style="margin: 10px;" >

                                        <input type="hidden" name="contestant_id" id="contestant_id" class="contestant_id"  value="<?php echo $_GET['me']; ?>">
                                         <input type="hidden" name="nominee_name" id="contestant_name" class="nominee_name"  value="<?php echo $_GET['q']; ?>">
                                         <!-- <input type="hidden" name="contestant_num" id="contestant_num"  value="<?php// echo $row['contestant_num']; ?>">
                                         <input type="hidden" name="category" id="category"  value="<?php// echo $row['contestant_region']; ?>"> -->
                                         <input type="hidden" name="api_key" class="api_key" value="33ffc38bcaff137103b94abb0480f966">
                                    </div>


                                    <div class="form-group col-md-10 col-sm-10" style="margin: 10px;" >
                                        <button class="btn btn-sm btn-primary send_opt"  id="send_opt" name="send_opt">Submit Code</button>
                                    </div>


                                </div>
                                
                                
                            </div>                          
                        </div>                       
                    </div>







                    <!-- terms and Conditions modal -->

                    <div class="modal" data-keyboard="false"  data-backdrop="static" id="termsModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <img src="blacklogo_symbol_black.png" style="margin-top: 5px; margin-bottom: 5px; border-radius: 100%; width: 50px; height: 50px;" class="img-fluid" >

                                    <h4 class="modal-title pull-right text-muted text-info"><strong>Terms and Conditions </strong>  </h4>
                                    <button class="close pull-left" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">

                                           
                                    <p>These are binding for all users of this platform.</p>
                                    <p>
                                    You are responsible for reading and understanding these Terms and Conditions pursuant to which all transactions, or payments via visa on this site are governed.</p>
                                    <div class="tab" style="margin-left:35px;">
                                        1. Services (voting) once consumed are not refundable. <br>

                                        <label> 2. Voting influences eviction of contestants in the competition and cannot be reversed after vote count has been acknowledged.</label>

                                        3. Votes cannot be transferred from one contestant to another, therefore, kindly check to confirm you have selected the right contestant’s details.
                                    </div>
    
    
 
                                </div>      

                                <button class="btn btn-sm " data-dismiss="modal">Close</button>
                                 
                            </div>                          
                        </div>                       
                    </div>
                    <!-- end of terms and Conditions modal -->




    <?php 
        mysqli_close($database); 


        }
        else
        {
            // $id   = $_GET['me'];
            // $data = mysqli_query($database, "SELECT * FROM contestants WHERE contestant_id '$id' LIMIT 1");
            //    while ($row =  mysqli_fetch_assoc($data)) 
            //    {
            //        $name = $row['name'];
            //        var_dump($row);
            //    }
            header("Location: https://bit.ly/missgha");
        }

    ?>



    <script src="admin/assets/js/wow.min.js"></script>                
    <!-- Required Jquery -->
    <script type="text/javascript" src="../web_vendors/bower_components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="../web_vendors/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../web_vendors/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="../web_vendors/bower_components/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="../web_vendors/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="../web_vendors/bower_components/modernizr/js/modernizr.js"></script>
    <script type="text/javascript" src="../web_vendors/bower_components/modernizr/js/css-scrollbars.js"></script>
    <!-- isotope js -->
    <script src="../web_vendors/assets/pages/isotope/jquery.isotope.js"></script>
    <script src="../web_vendors/assets/pages/isotope/isotope.pkgd.min.js"></script>

    <script type="text/javascript" src="../web_vendors/bower_components/i18next/js/i18next.min.js"></script>
    <script type="text/javascript" src="../web_vendors/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="../web_vendors/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="../web_vendors/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
    <!-- Custom js -->

    <script src="../web_vendors/assets/js/pcoded.min.js"></script>
    <script src="../web_vendors/assets/js/vartical-layout.min.js"></script>
    <script src="../web_vendors/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
  
    <script type="text/javascript">
        $(window).on('load', function() {
            var $container = $('.filter-container');
            $container.isotope({
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            var $grid = $('.default-grid').isotope({
                itemSelector: '.default-grid-item',
                masonry: {}
            });
        });
    </script>
    <script type="text/javascript" src="../web_vendors/assets/js/script.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
        <script>
            new WOW().init();

        $(document).ready(function(){
            // $('.voter').on('click',function(){
            //         $("#contestant_id").val($(this).data('contestant-id'));
            //         $("#contestant_name").val($(this).data('contestant-name'));
            //         $("#voteidentifier").val($(this).data('voteidentifier'));

            //         $("#user").html($(this).data('voteidentifier'));

            //         $("#contestant_num").val($(this).data('contestant-num'));
            //         $("#category").val($(this).data('category'));

            //         $("#testModal").modal("toggle");
            //         $("#testModal").modal("show");
            // });

            // document.getElementById('voda_token_div').style.display="none";
            // document.getElementById('voda_token_div').style.display="none";
            // document.getElementById('mobile_number').style.display = 'none';
            //  document.getElementById('opt_div').style.display="none";

            // $("#testModal").modal('show');

            $(':input[type="submit"]').prop('disabled', true);
            // $('.termslink').on('click',function(){

            //     $("#termsModal").modal("toggle");
            //     $("#termsModal").modal("show");
            // });
        });
    </script> 


<script >
    $(document).ready(function(){
        document.getElementById('mobile_number').style.display = 'none';
         document.getElementById('opt_div').style.display="none";

         // document.getElementById('termsCheck').style.display="none";

        $("#testModal").modal('show');

        $(".payment").submit(function(event) {
            event.preventDefault();
            // var amount = $(".amount").val();
            // var channel = $(".channel").val();
            // var api_key = $(".api_key").val();
            // var nominee_name = $(".nominee_name").val();
            // var contestant_id = $(".contestant_id").val();
            // var contestant_num = $("#voteidentifier").val();
            // var number = $(".number").val();


            var amount = $(".amount").val();
            var channel = $(".channel").val();
            var api_key = $(".api_key").val();
            var contestant_name = $(".nominee_name").val();
            var contestant_id = $(".contestant_id").val();
            // var contestant_num = $("#contestant_num").val();
            // var category = $("#category").val();
            var number = $(".number").val();

            //restrict voting if amount is not selected
            if (amount == "") {
                alert('Please select vote plan to continue.');
                return false;
            }//../../miss_ghana_api/

            if(channel =="")
            {
               alert("please select your payment option");
               return false;
            }

            if(number == "")
            {
                alert("please enter mobile money number!");
                return false;
            }

            if(document.getElementById('terms').checked) 
            {}else{
                alert('Please accept terms and condition to continue.');
                $(':input[type="submit"]').prop('disabled', true);
                return false;
            }

            document.getElementById('form_div').style.display = 'none';
            document.querySelector('#opt_div').style.display = 'block';


            if($('.send').on('click')) 
            {
                if (document.getElementById('visa_card').checked)
                {          
                    $.ajax({
                        url: "payment_api/momo/execute_pay.php",
                        type: "POST",
                        // contentType: "application/json",
                        // // Access-Control-Allow-Origin: '*',
                        // dataType: "json",
                        data: {
                            service:"createOrder", 
                            contestant_id:contestant_id,
                            contestant_name:contestant_name,
                            amount:amount,
                            number:number,
                            api_key:api_key,
                            channel:'visa_card',
                            device:"online"
                        },
                        beforeSend: function() {
                            alert("You will receive a payment prompt from MyCediPay.")
                            $('.payment').trigger('reset');
                            $("#testModal").modal('hide');
                        },
                        success:function(response){
                           console.log(response);
     
                          window.location.href = response['Data'];
                        }//JSON.stringify()
                    });
                }else{
                    $.ajax({
                        url: "payment_api/process_opt.php",
                        type: "POST",
                        // contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: {
                            contestant_name:contestant_name,
                            // contestant_num:contestant_num,
                            // category:category,
                            contestant_id:contestant_id,
                            amount:amount,
                            api_key:api_key,
                            number:number,
                            channel:channel,
                            device:'online'
                        },
                        beforeSend: function() {
                            // $('.payment').trigger('reset');
                            // $("#testModal").modal('hide');
                        },
                        success:function(response){
                           console.log(response);

                          alert(response.message);
                          if(response.success == false){
                            $('.payment').trigger('reset');
                            $("#testModal").modal('hide');
                            window.location.reload();
                          }
                          
                          if (response.code == "WARNING") {
                            document.getElementById('page_body').style.display = 'none';
                          }
                        }//JSON.stringify()
                    });
                }
                // return false; 
            }




        if($('.send_opt').on('click')) {
            $('.send_opt').on('click',function(event){
               event.preventDefault();
                
                var amount = $(".amount").val();
                var channel = $(".channel").val();
                var api_key = $(".api_key").val();
                var contestant_name = $(".nominee_name").val();
                var contestant_id = $(".contestant_id").val();
                // var contestant_num = $("#contestant_num").val();
                // var category = $("#category").val();
                var number = $(".number").val();


                const opt_code = $("#opt_code").val();

                if (opt_code == "") {
                    alert("Please provide OPT code sent to your phone");
                    $(".opt_code").focus();
                    return false; 
                }


                $.ajax({
                    url: "payment_api/momo/execute_pay.php",
                    type: "POST",
                    data: {
                        contestant_name:contestant_name,
                        // contestant_num:contestant_num,
                        // category:category,
                        contestant_id:contestant_id,
                        amount:amount,
                        api_key:api_key,
                        number:number,
                        channel:channel,
                        device:'online',
                        opt_code:opt_code
                    },
                    beforeSend: function() {
                        $("#testModal").modal('hide');
                    },
                    success:function(response){
                        // alert("Vote is being process. Check and confirm payment!");
                        alert(response.Data.Message);
                        $('.payment').trigger('reset');
                        window.location.reload();
                    }
                });
            });
        }


        });
    });
</script>

<script >
    function validateEntryForm()
    {
        var amount = document.forms['payment']['amount'];
        var channel = document.forms['payment']['channel'];
        var number = document.forms['payment']['number'];
        // var visa_card = document.forms['payment']['visa_card'];
        var token = document.forms['payment']['token'];


        if(amount.value.trim() =="")
        {
            alert("please select bulk vote");
            return false;
        }

        if(channel.value.trim() =="")
        {
           alert("please select your payment option");
           return false;
        }

        if(channel.value == 'visa_card') 
        {

        }else
        {
            if(number.value.trim() == "")
            {
                alert("please enter mobile money number!");
                return false;
            }
        }
        

        // if(network.value == 'vodafone-gh') 
        // {
        //     if(token.value.trim() == "")
        //     {
        //         alert("please enter vodafone token or dial *110# to generate payment token");
        //         return false;
        //     }
        // }


        if(number.value.trim() != "") 
        {
            if(number.value.trim().length >= 10)
            {
              // return  validatePhoneNumber(phone_number);
            }
        }
    }


    function validatePhoneNumber(contactValue)
    {
        var phonenoFormat = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
        var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        if(contactValue.value.match(phoneno))
        {
           return true;
        }else
        {
            alert("Contact value not valid, enter valid numbers only");
            return false;
        }
    }



    function checkIfTermsChecked(){
        if(document.getElementById('terms').checked) {
            $(':input[type="submit"]').prop('disabled', false);
        }else{
            $(':input[type="submit"]').prop('disabled', true);
        }
    }


    function checkIfVisacard()
    {
        if(document.getElementById('visa_card').checked) 
        {
            alert("You have to accept terms and condition to vote with visa.")

           document.querySelector('#mobile_number').style.display = 'block';
           document.querySelector('#mobile_money_number').style.display = 'none';
            

           // document.getElementById('termsCheck').style.display="block";
           // $(':input[type="submit"]').prop('disabled', true);
           // document.getElementById('send').style.display = 'none';
        }else{
           document.querySelector('#mobile_number').style.display = 'none';
           document.querySelector('#mobile_money_number').style.display = 'block';

           // document.getElementById('termsCheck').style.display="none";
           // // document.getElementById('send').style.display = 'block';
           // $(':input[type="submit"]').prop('disabled', false);
        }    
    }

    function checkIfVodafone()
    {
        if(document.getElementById('rad_voda_token').checked) 
        {
           document.querySelector('#voda_token_div').style.display = 'block';
        }else{
           document.querySelector('#voda_token_div').style.display = 'none';
        }    
    }
</script>         
</body>
</html>