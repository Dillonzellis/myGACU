<?php
function CalcDealerFee($financed){
 if($financed < 10000){
  $fee = 0;
 }elseif($financed >= 10000 && $financed < 20000){
  $fee = 100;
 }else{
  $fee = 200;
 }
 return $fee;
}
$calculate_html = '';
$rate_add_2 = '';
$term = array(24=>'24 months',36=>'36 months',48=>'48 months',60=>'60 months',72=>'72 months',84=>'84 months');
$creditrating = array('Exceptional Credit'=>'Exceptional Credit (higher than 720)',
      'Excellent Credit'=>'Excellent Credit (680-719)',
      'Good Credit'=>'Good Credit (640-679)',
      'Average Credit'=>'Average Credit (600-639)',
      'Below Average'=>'Below Average (less than 600)');

$theLTV = array('Exceptional Credit'=>115,
      'Excellent Credit'=>110,
      'Good Credit'=>105,
      'Average Credit'=>100,
      'Below Average'=>90);

$errors = array();

$errorstring = '';

$row = array();
// DEFAULT TERMS PER CAMERON
$theterms = array(48,60,72,84);
if(isset($_POST['Submit']) && $_POST['Submit'] == 'Calculate New Loan'){
 // verify the data is correct

 if(isset($_POST['rembalance'])){
  $_POST['rembalance'] = str_replace(",", "", $_POST['rembalance']);
  $_POST['rembalance'] = str_replace('$', "", $_POST['rembalance']);
 }
// if(isset($_POST['curmonthpay'])){
//  $_POST['curmonthpay'] = str_replace(",", "", $_POST['curmonthpay']);
//  $_POST['curmonthpay'] = str_replace('$', "", $_POST['curmonthpay']);
// }
// if(!isset($_POST['loanterm']) || !is_numeric($_POST['loanterm'])){
//  $errors[] = 'Please enter a valid loan term';
// }

 if(!isset($_POST['rembalance']) || !is_numeric($_POST['rembalance'])){
  $errors[] = 'Please enter a valid loan amount';
 }
// if(!isset($_POST['curmonthpay']) || !is_numeric($_POST['curmonthpay'])){
//  $errors[] = 'Please enter a valid currently monthly payment';
// }
 if(isset($_POST['rembalance']) && $_POST['rembalance'] < 5000){
  $errors[] = 'The loan amount must be greater than $5,000.00';
 }

 if(!isset($_POST['vehicleyear']) || !is_numeric($_POST['vehicleyear'])){
  $errors[] = 'Please enter a valid year of vehicle';
 }

 if(!isset($_POST['Creditrating'])){
  $_POST['Creditrating'] = 'Excellent Credit';
 }

 if(count($errors) == 0){
  // CONNECT TO DB FOR RATE
$dblink = mysqli_connect('localhost','MyGAcu','myGADB2021','hallc2');
   // mysql_select_db('hallc2',$dblink);
   foreach($theterms as $termval){
       $qry = "SELECT * FROM gcualoanmatrix WHERE CScore = '".mysqli_real_escape_string($dblink,stripslashes($_POST['Creditrating']))."' 
AND loanTerm = '".mysqli_real_escape_string($dblink,stripslashes($termval))."' LIMIT 1;";
       $res = mysqli_query($dblink,$qry);
       $row[$termval] = mysqli_fetch_assoc($res);
  }

  $calculate_html = '<h3><font face="Verdana, Geneva, sans-serif" color="#0067B1">Results</font></h3>';
  // formula
  $calculate_html .='<p><b><font face="Verdana, Geneva, sans-serif" size="2" color="#0067B1">Rate* based on '.htmlentities($_POST['Creditrating']).' with an amount to finance of $'.number_format($_POST['rembalance'],2).'</font></b></p>';

  foreach($theterms as $termval){
   $period_interest = $row[$termval]['LoanRate'];
   $period_interest = substr($period_interest,1);

   // If car older than 2007, add 2%
   if($_POST['vehicleyear'] < 2017){
    $period_interest = $period_interest+.02;
    $rate_add_2 = ' <font face="Verdana, Geneva, sans-serif" size="2" color="#0067B1">(2.00% added for vehicles older than 2017)</font>';
    $rate_add_2 = ''; // remove the statement per Cameron
   }

   $period_interest_calc = $period_interest/12;

   $c_period_payment  = $_POST['rembalance'] * ($period_interest_calc / (1 - pow((1 + $period_interest_calc), -($termval))));

   //$loan_amount * ($period_interest / (1 - pow((1 + $period_interest), -($total_periods))));
   $yearly_cost = $c_period_payment*12;
  // $yearly_current = $_POST['curmonthpay']*12;
  // $yearly_savings = $yearly_current - $yearly_cost;

   $total_paid        = number_format($c_period_payment * $termval, 2, '.', ',');
   $total_interest    = number_format($c_period_payment * $termval - $_POST['rembalance'], 2, '.', ',');
   $total_principal   = number_format($_POST['rembalance'], 2, '.', ',');

   if($row[$termval]['LoanRate'] == 0 || $row[$termval]['LoanRate'] == ''){

       $calculate_html .= '<p><font face="Verdana, Geneva, sans-serif" size="2" color="#0067B1"><b>An '.$termval.' month payment option is not available for this loan request</font></b></p>';

   }else{

        $calculate_html .= '<p><font face="Verdana, Geneva, sans-serif" size="2" color="#0067B1"><b>Rate:  '.number_format($period_interest*100,2).'%'.$rate_add_2.', '.$termval.' months Payment: $'.number_format($c_period_payment,2).'</font></b></p>';

   }

  }

  $calculate_html .= '<p><form action="?" method="post"><input type="submit" name="return" value="Return to calculator" /></form></p>';

 }else{

  $errorstring .='<p>The follow errors occured:</p><ul>';
  foreach($errors as $value){
   $errorstring .= '<li>'.$value.'';
  }
  $errorstring .='</ul>';
 }

}

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
	<title>MyGeorgia - Auto Loanss</title>



	<meta name="description" content="Like all credit unions, MyGeorgia is a not-for-profit financial cooperative. When you join the credit union, you become a shareholder ??? or an owner ??? of a very unique financial institution. Earnings above the required reserves are returned to you, in the form of lower interest rates on loans and competitive dividends on savings.">



<meta name="keywords" content="MyGeorgia, MyGeorgia Credit Union, MyGeorgia, MyGeorgia, georgia credit unions, credit union, savings, loans, credit cards, ATM, debit cards, VISA, debit cards, nonprofit, service">



    



    <!-- /// Favicons ////////  -->



    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/apple-touch-icon-144-precomposed.png">



    











	<!-- /// Template CSS ////////  -->
<link href='https://fonts.googleapis.com/css?family=kanit' rel='stylesheet'>



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/base.css">



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/grid.css">



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/elements.css">



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/layout.css">



    



    <!-- /// Boxed layout ////////  -->



	<!-- <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/boxed.css"> -->







	<!-- /// JS Plugins CSS ////////  -->



	<link rel="stylesheet" href="https://www.mygacu.com/_layout/js/revolutionslider/css/settings.css">



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/js/revolutionslider/css/custom.css">



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/js/bxslider/jquery.bxslider.css">



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/js/magnificpopup/magnific-popup.css">



	<link rel="stylesheet" href="https://www.mygacu.com/_layout/js/itplayer/YTPlayer.css">



    



    <!-- /// Template Skin CSS ////////  -->



	<!-- <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/skins/default.css"> -->



    <!-- <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/skins/blue.css"> -->



    <!-- <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/skins/orange.css"> -->



    <!-- <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/skins/red.css"> -->



    <!-- <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/skins/violet.css"> -->



    



    <!-- /// Google Fonts ////////  -->



    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">



    



    <!-- /// FontAwesome Icons 4.0.3 ////////  -->



	<link rel="stylesheet" href="https://www.mygacu.com/_layout/css/fontawesome/font-awesome.min.css">



    



    <!-- /// Custom Icon Font ////////  -->



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/iconfontcustom/icon-font-custom.css">



    



    <!-- /// Cross-browser CSS3 animations ////////  -->



    <link rel="stylesheet" href="https://www.mygacu.com/_layout/css/animate/animate.min.css">







    <!-- /// Modernizr ////////  --> <script src="https://www.mygacu.com/_layout/js/modernizr-2.6.2.min.js"></script>



 



<!-- Google Tag Manager --> 
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': 
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], 
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); 
})(window,document,'script','dataLayer','GTM-5DLR3MW');</script> 
<!-- End Google Tag Manager -->
</head>



<body>



<div id="left_feedback">



<?php include '../rightbtn.php';?>



</div>



<div id="left_feedbacksm">



<?php include '../rightbtnsm.php';?>



</div>



	



	<noscript>



    	<p class="javascript-required"> 



        	You seem to have Javascript disabled. 



            This website needs javascript in order to function properly.



		</p>



    </noscript>



    	



	<!--[if lte IE 8]>



        <p class="browser-update">



        	You are using an <strong>outdated</strong> browser. Please 



        	<a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">upgrade your browser</a> 



            to improve your experience.



		</p>



    <![endif]-->



 



	<div id="wrap">



    



    <div id="header-top1">&nbsp;</div>



	



		<div id="header-top">



        	



        <!-- /// HEADER-TOP  //////////////////////////////////////////////////////////////////////////////////////////////////////// -->



            



            <div class="row hidden-phone">



            	<div class="span6" id="header-top-widget-area-1">



                	



                    <div class="widget ewf_widget_contact_info">



                    



                    	<ul>



                        	<li>&nbsp;</li>



                            <li>&nbsp;</li>



                        </ul>



                        



                    </div><!-- end .ewf_widget_contact_info -->



                    



                </div><!-- end .span6 -->



                <div class="span6 text-right" id="header-top-widget-area-2">



                	



                    <div class="widget ewf_widget_social_media">



                    



						<div class="fixed">



							



							<?php include '../topicons.php';?>



							



						</div>



                        



                    </div><!-- end .ewf_widget_social_media -->



                    



                </div><!-- end .span6 -->



            </div><!-- end .row -->



            



        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



        



        </div><!-- end #header-top -->



        



        <div id="header">



        



		<!-- /// HEADER  //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->







			<div class="row">



				<div class="span3">



				



					<!-- // Logo // -->



					<a href="https://www.mygacu.com/main.php" id="logo">



                    	<img src="https://www.mygacu.com/_layout/images/logo.png" alt="MyGeorgia CU" class="responsive-img" title="MyGeorgia CU">



                    </a>



				



				</div><!-- end .span3 -->



				<div class="span9"> 



                <?php include '../nav.php';?>



			  </div>



				<!-- end .span9 -->



			</div><!-- end .row -->		







		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->







		</div><!-- end #header -->



		<div id="content">



		



		<!-- /// CONTENT  /////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



            



            <div class="row">



            	<div class="span12">



                	



                    <h1 class="text-uppercase">Auto Loans</h1>



                    



                </div><!-- en .span12 -->



            </div><!-- end .row -->



            <div class="parallax" id="bg-parallax-2">



          <div class="row">



              



              <div class="span12">



                <p><strong>Do you find yourself feeling eager for that new car smell?</strong></p>



                <p><strong>Ever wonder if you could be saving money on your current car payments?</strong></p>



                <p>If you answered &quot;yes&quot; to either of these questions, MyGeorgia can take your new car search or current auto refinance from<br> <strong style="font-size:18px;"><em>0</em></strong> to <strong style="font-size:18px;"><em>60</em></strong> with just a click of a mouse! Through a convenient and secure online connection, our simple-click auto loans allow you to apply for a loan, find your rate, and calculate your payment all within a matter of minutes.</p>



                <p>Of course, if you prefer to work with someone face-to-face, MyGeorgia loan specialists welcome the chance to serve you at one of our local branches.</p>







              <p><strong>Auto Loans with MyGeorgia Credit Union include:</strong></p>



                <div class="vertical-tabs-container fixed">



                  <ul class="tabs-menu fixed">



                    <li> <i class="ifc-megaphone2"></i> <a href="https://www.mygacu.com#content-tab-2-1">GREAT Low Rates</a> </li>



                    <li> <i class="ifc-megaphone2"></i> <a href="https://www.mygacu.com#content-tab-2-2">No Payment for 90 Days!*</a> </li>



                    <li> <i class="ifc-megaphone2"></i> <a href="https://www.mygacu.com#content-tab-2-3">Terms Up To 84 Months*</a> </li>



                    <li> <i class="ifc-megaphone2"></i> <a href="https://www.mygacu.com#content-tab-2-4">Up to 120% Financing Available*</a> </li>



                    <li> <i class="ifc-megaphone2"></i> <a href="https://www.mygacu.com#content-tab-2-5">Second Chance Auto Finance Program</a> </li>



                  </ul>

				

                  <!-- end .tabs-menu -->



                  <div class="tabs">



                    <div class="tab-content" id="content-tab-2-1">



                      <p style="color:#003DA6;">Auto rate as low as 2.99% APR* for 60 months for 2017 or newer. To find your rate and payment <a href="#cal">Click here!</a>*</p>



                      <p style="color:#003DA6;">All rates are not created equal because borrowers are unique. So, call or visit us to discuss your loan needs. Your Annual Percentage Rate (APR) could vary based on your credit history, age of collateral, and the length of term.</p>



                    </div>



                    <!-- end .tab-content -->



                    <div class="tab-content" id="content-tab-2-2">



                      <p style="color:#003DA6;">Many financing companies require your first payment to be made 30 days after purchasing your new car. Not at MyGeorgia! We allow our members to wait up to 90 days to make their first payment. For example, if you get your loan in January, your first payment won't be due until April! Call or visit us to discuss your loan needs.</p>



                      <p style="color:#003DA6;">*Interest will accrue for the 90 days. This offer does not apply to existing loans financed with MyGeorgia.</p>



                    </div>



                    <!-- end .tab-content -->



                    <div class="tab-content" id="content-tab-2-3">



                      <p style="color:#003DA6;">We want to make sure you are comfortable with your monthly payment. Because many of us are in different financial situations, you have the option to finance for 2-7 years so you can get your payment just where YOU need it. Just one more way MyGeorgia helps you afford life!</p>



                      <p style="color:#003DA6;">*84-month term available for loans above $20,000 and subject to credit history. See calculator below for pricing.</p>



                    </div>



                    <!-- end .tab-content -->



                    <div class="tab-content" id="content-tab-2-4">



                      <p style="color:#003DA6;">If you owe more than your car's value, you are upside down in your financing (negative equity). Many financing companies will not allow you to finance if there is negative equity. At MyGeorgia, we help our members through all their financing situations. For example, if your car's value is $10,000 but you owe $12,000, you may still be able to get the finance you desire until you are  comfortable.</p>



                      <p style="color:#003DA6;">*All loans subject to normal underwriting guidelines.</p>



                    </div>



                    <!-- end .tab-content -->



                    <div class="tab-content" id="content-tab-2-5">



                      <p style="color:#003DA6;">Whether you have bad credit or a low credit score due to bankruptcy or history of slow pays, MyGeorgia can help you get back on the road AND re-establish your credit during the process. We understand that bad things can happen to good people, and we want to help our members afford an auto loan. Once pre-approved, we help you select a qualifying vehicle and take your term up to 60 months.</p>



                    </div>



                    <!-- end .tab-content -->

					         <!-- end .tab-content -->



                    <div class="tab-content" id="content-tab-2-5">



						<p style="color:#003DA6;"><a href="https://www.mycreditunion.gov/life-events/buying-car " onclick="drawAlert()" target="_blank">Click here</a> for tips on buying a car.</p>



                    </div>



                    <!-- end .tab-content -->



                  </div>



                  <!-- end .tabs -->



                </div>



                <!-- end .vertical-tabs-container -->

				<p>We provide all of the credit union benefits to individuals who live or work in a 8-county region that includes Banks, Dawson, Habersham, Hall, Jackson, Lumpkin, Rabun and White Counties.</p>

				  <p>Call 770-534-4255 and ask for your LOCAL Auto Loan Specialist.</p>



                <p align="center" style="font-size:20px;" id="cal"><strong>What are you waiting for? <a href="https://www.mobicint.net/hco/login/loanapp" target="_blank">APPLY NOW!</a></strong></p>



                <p align="center"><iframe width="560" height="315" src="https://www.youtube.com/embed/hoTbc6Wv9O4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>



              </div>



              <!-- end .span12 -->



              



            </div>



            



            </div>



            



            <div class="parallax" id="bg-parallax-6">



              <div class="parallax-content" style="padding:0px;">







                <div class="parallax-content-inner">



                  <!-- end .row -->



                  <br>



                  <div class="row">



              



              <div class="span8">



                



                <p><?php print $calculate_html ?> <?php print $errorstring ?>



                  <?php if(!isset($calculate_html) || $calculate_html == ''){ ?>



                </p>



                <p style="font-size:18px;" align="center"><strong>Auto Loan Rate &amp; Payment Calculator</strong></p>



                <form action="?" method="post">



                 



					<p align="center"><label for="Creditrating"><strong>Your Credit Score?</strong></label> <?php



print '<select name="Creditrating" id="Creditrating">';



foreach($creditrating as $ratingkey=>$ratingvalue){



 if(isset($_POST['Creditrating']) && $_POST['Creditrating'] == $ratingkey){



  print '<option value="'.$ratingkey.'" selected>'.$ratingvalue.'</option>';



 }else{



  print '<option name="Creditrating" value="'.$ratingkey.'">'.$ratingvalue.'</option>';



 }



}



print '</select>'



?></p>







					<p align="center"><label for="rembalance"><strong>Amount to Finance $</strong></label> <input name="rembalance" type="text" id="rembalance" value="<?php (isset($_POST['rembalance']) && is_numeric($_POST['rembalance'])? print $_POST['rembalance']:print '') ?>" /></p>







					<p align="center"><label for="vehicleyear"><strong>Year of Vehicle</strong></label> <input name="vehicleyear" type="text" id="vehicleyear" maxlength="4" value="<?php (isset($_POST['vehicleyear']) && is_numeric($_POST['vehicleyear'])? print $_POST['vehicleyear']:print '') ?>" />



                      <!--  br>



    Current Monthly Payment 



    $



    <input name="curmonthpay" type="text" id="curmonthpay" value="<?php (isset($_POST['curmonthpay']) && is_numeric($_POST['curmonthpay'])? print $_POST['curmonthpay']:print '') ?>" -->



                      <!--  Term of Loan 



    <select name="loanterm">



  <?php



/*foreach ($term as $termkey=>$termvalue){



 if(isset($_POST['loanterm']) && $_POST['loanterm'] == $termkey){



  print '   <option value="'.$termkey.'" selected>'.$termvalue.'</option>'."\n";



 }else{



  print '   <option value="'.$termkey.'">'.$termvalue.'</option>'."\n";



 }



}



*/



?>



    </select -->



                  </p>



                      



                      <p align="center"><input type="submit" name="Submit" value="Calculate New Loan" /></p>



                      



                </form>



                <p>



                  <?php } ?>



                </p>



              </div>



              <!-- end .span8 -->



              <div class="span4"><p style="padding-top:20px;"><img src="https://www.mygacu.com/_content/calculator.png" border="0" alt="Auto Loan Calculator"></p>



              </div>



              <!-- end .span4 -->



            </div>



            <!-- end .row -->



                </div>



                  <!-- end .row -->



              </div>



                <!-- end .parallax-content-inner -->



          </div>



              <!-- end .parallax-content -->



     



            <!-- end .row -->



            <div class="parallax" id="bg-parallax-1" style="padding:60px 0;">



            <div class="row">



            <div class="span4">&nbsp;</p>



              </div>



              <!-- end .span4 -->



              <div class="span8">



                <p><strong>Boat, RV and Motorcycle Loans</strong></p>



                <p>Whether it's the open road or the open water that calls you, MyGeorgia Credit Union has the ideal loan to help you answer that call! </p>



                <p><strong>From boats and personal watercraft to motorcycles and motor homes, MyGeorgia recreational vehicle financing comprises:</strong></p>



                <ul>



                  <li><strong>Up to 100% MSRP* Financing</strong> (New)</li>



                  <li><strong>Up to 100%* of average retail</strong> (Used)</li>



                  <li>Pay at your own pace, <a href="https://www.mygacu.com/about/locations.php">contact</a> the credit union for rates and terms.</li>



                </ul>



                <p align="center" style="font-size:20px;"><strong>Adventure Awaits! <a href="https://www.mobicint.net/hco/login/loanapp" target="_blank" style="color:#00A7E1;">APPLY NOW!</a></strong></p>



                <p><em>*There's no "one size fits all" in lending. So, call or visit us to discuss your financing needs. Your rate could vary based on your credit history, the age of collateral, and the length of term. Terms and conditions subject to change without notice.</em></p>



                <!-- end .social-media -->



              </div>



              <!-- end .span8 -->



            </div>



            <!-- end .row -->



            </div>



            



		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->







		</div><!-- end #content -->



		<div id="footer">



		  <!-- /// FOOTER     ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->



		  <div id="footer-top">



		    <!-- /// FOOTER-TOP     ///////////////////////////////////////////////////////////////////////////////////////////////// -->



		    <div class="row">



		      <div class="span12" id="footer-top-widget-area-1"></div>



		      <!-- end .span12 -->



	        </div>



		    <!-- end .row -->



		    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



	      </div>



		  <!-- end #footer-top -->



		  <div id="footer-middle">



		    <!-- /// FOOTER-MIDDLE     ////////////////////////////////////////////////////////////////////////////////////////////// -->



		    <div class="row">



		      <div class="span3" id="footer-middle-widget-area-4">



		        <?php include '../footer1.php';?>



	          </div>



		      <!-- end .span3 -->



	        </div>



		    <!-- end .row -->



		    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



	      </div>



		  <!-- end #footer-middle -->



		  <div id="footer-bottom">



		    <!-- /// FOOTER-BOTTOM     ////////////////////////////////////////////////////////////////////////////////////////////// -->



		    <div class="row">



		      <div class="span12 text-center" id="footer-bottom-widget-area-1">



		        <div class="widget widget_text">



		          <div class="textwidget"> 



                  <?php include '../footer2.php';?>



                  </div>



		          <!-- end .textwidget -->



	            </div>



		        <!-- end .widget_text -->



	          </div>



		      <!-- end .span12 -->



	        </div>



		    <!-- end .row -->



		    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



	      </div>



		  <!-- end #footer-bottom -->



		  <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



	  </div>



		<!-- end #footer -->



		



	</div><!-- end #wrap -->



    



    <a id="back-to-top" href="#" aria-label="Back to Top Button">



    	<i class="ifc-up4"></i>



    </a>











    <!-- /// jQuery ////////  --> <script src="https://www.mygacu.com/_layout/js/jquery-2.1.0.min.js"></script>



  



    <!-- /// ViewPort ////////  --> <script src="https://www.mygacu.com/_layout/js/viewport/jquery.viewport.js"></script>



    



    <!-- /// Easing ////////  --> <script src="https://www.mygacu.com/_layout/js/easing/jquery.easing.1.3.js"></script>







    <!-- /// SimplePlaceholder ////////  --> <script src="https://www.mygacu.com/_layout/js/simpleplaceholder/jquery.simpleplaceholder.js"></script>



    



    <!-- /// Superfish Menu ////////  --> <script src="https://www.mygacu.com/_layout/js/superfish/hoverIntent.js"></script> <script src="https://www.mygacu.com/_layout/js/superfish/superfish.js"></script>



    



   	<!-- /// Magnific Popup ////////  --> <script src="https://www.mygacu.com/_layout/js/magnificpopup/jquery.magnific-popup.min.js"></script>



    



    <!-- /// Isotope ////////  --> <script src="https://www.mygacu.com/_layout/js/isotope/isotope.pkgd.min.js"></script> <script src="https://www.mygacu.com/_layout/js/isotope/imagesloaded.pkgd.min.js"></script>



    



    <!-- /// Parallax ////////  --> <script src="https://www.mygacu.com/_layout/js/parallax/jquery.parallax.min.js"></script>







	<!-- /// YTPlayer ////////  --> <script src="https://www.mygacu.com/_layout/js/itplayer/jquery.mb.YTPlayer.js"></script>	



	



	<!-- /// EasyPieChart ////////  --> <script src="https://www.mygacu.com/_layout/js/easypiechart/jquery.easypiechart.min.js"></script>



    



    <!-- /// Easy Tabs ////////  --> <script src="https://www.mygacu.com/_layout/js/easytabs/jquery.easytabs.min.js"></script>	



	



    <!-- /// Waypoints ////////  --> <script src="https://www.mygacu.com/_layout/js/waypoints/waypoints.min.js"></script> <script src="https://www.mygacu.com/_layout/js/waypoints/waypoints-sticky.min.js"></script>



    



    <!-- /// Chart.js ////////  --> <script src="https://www.mygacu.com/_layout/js/chart/chart.js"></script>







	<!-- /// Custom JS ////////  --> <script src="https://www.mygacu.com/_layout/js/plugins.js"></script> <script src="https://www.mygacu.com/_layout/js/scripts.js"></script>



    



    <!-- Monitor tag for Account MyGeorgia (ID: 38), Site MyGeorgiacu.org (ID: 45), Queue Lending (ID: 97) -->



 <script language=javascript src="https://sightmax75R2.sightmaxondemand.com/HALLCO/SightMaxAgentInterface/Monitor.smjs?accountID=38&siteID=45&queueID=97"></script>



	



	<script>



  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){



  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),



  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)



  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');







  ga('create', 'UA-16399578-1', 'auto');



  ga('send', 'pageview');







</script>



</body>



</html>