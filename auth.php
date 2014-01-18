<?php 
    require_once("lib/proxylib.php");

    session_start();
    session_authenticate();
?>
<!DOCTYPE html>  
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"> 
    <head> 
        <title>Web Usage Meter - StudentIT Mobile</title> 

        <link rel='shortcut icon' href='http://sso.its.unimelb.edu.au/sso/favicon.ico'> 
        <meta name='HandheldFriendly' content='true'> 
        <meta name="mobileoptimized" content="0">
        <meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="touch-icon-iphone4.png" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=1;" />

        <link rel='stylesheet' href='css/mobile.css' type='text/css'  media='all'>

        <script type='text/javascript' language='javascript' src='js/jquery-1.4.4.min.js'></script>
        <script type='text/javascript' language='javascript' src='js/uombehaviour.js'></script>
        <script type="text/javascript">
			window.addEventListener("load",function() {
			  // Set a timeout...
			  setTimeout(function(){
				// Hide the address bar!
				window.scrollTo(0, 1);
			  }, 0);
			});
        </script>
    </head> 
    <body id="top">
        <div id="portrait" data-role="page">
            <div class="header" data-role="header"> <a href="#" class="back_btn">Back</a></div>
            <h1 class="page_title">Web Usage Meter</h1>

            <div class="content">
                
                <div class="block_wrap">
                  <h4>&nbsp;</h4>  
               <form name="Login" action="" method="post"> 
                <fieldset>
                    <div class="form_wrap">
                        <div class="inner-content-wrap noBorder">

                            <div class="message" id="jsMsg"> 
                                <h4>Attention</h4>
                                <p>You must have Javascript enabled to log in.</p> 
                            </div>
                            <div class="noPadding noMargin noBorder">
                                <h4>Enter Login Details</h4> 
                            </div> 
                            
                            <?php 
                                if (isset($_GET['auth_err'])) { 
                                    echo "<div id='error'><strong>Authentication Failed</strong><br>Please try again.</div>";
                                }
                            ?>
                            <div  class="noBorder" data-role="fieldcontain">
                            <label for="username">Username</label> 
                            <?php
                                if (isset($_GET['auth_err'])) {
                                        echo '<input type="text" name="username" id="username" value="'. $_GET['auth_err'] .'">';
                                } else {
                                        echo '<input type="text" name="username" id="username" />';
                                }
                            ?>
                            </div>
                            <div class="noBorder" data-role="fieldcontain"> 
                                <label for="password">Password</label> 
                                <input type="password" name="password" id="password" /> 
                            </div>
                            <div class="noBorder" style="margin:10px 0; text-align:center">
                                <button type="submit" id="submitBtn" disabled="disabled" class="disabled">Log in</button>

                            </div>
                        </div><!--.inner-content-wrap -->
                    </div><!--.form_wrap-->
                    <div class="noBorder" style="margin:0 10px 20px 10px; ">
                            <p class="smalltxt"><a href="http://www.its.unimelb.edu.au/support/accounts/passwords" class="smalltxt secondaryAction cancelForm" >Problems logging in?</a> <br>
                            Log in using your unimelb <a href="http://accounts.unimelb.edu.au/" title="Unimelb Username and Password">username and password</a>
                            </p>
                            <p class="smalltxt"><em>By clicking on the <strong>Log in</strong> button, you agree to abide by the terms of use as set in <a href="http://www.unimelb.edu.au/Statutes/pdf/r83r2.pdf">Regulation 8.3.R2</a></em></p> 
                            <p class="credits noMargin noPadding">Backend development by Clement Poh, Student IT</p>
</div>
                </fieldset> 
                <input type="hidden" name="gx_charset" value="UTF-8"></form> 
            </form> 


            </div>   
                
            </div><!-- close .content -->
        </div><!-- close #portrait -->
         
          <div class="local_footer">
              <ul class="local_footer_list">
                <li class="btn_top"><a href="#top" title="Back to Top" data-ajax="false" id="top-of-page">Top</a></li>
                <li class="btn_feedback"><a href="http://m.studentit.unimelb.edu.au/feedback.html" title="Feedback" data-ajax="false">Feedback</a></li>
                <li class="btn_menu"><a href="http://m.studentit.unimelb.edu.au" title="Menu" data-ajax="false">Menu</a></li>
              </ul>
              <p><a href="http://studentit.unimelb.edu.au" title="Student IT non-mobile site">Student IT non-mobile Site > </a></p>
              <p>© copyright 2012</p>
            </div>
            
            <div class="footer">
              <div class="footerlogo">
                <p><a href="http://www.unimelb.edu.au" title="University of Melbourne homepage"><img src="images/unimelb-logo-lge.png" width="80%" alt="UoM logo"></a> </p>
              </div>
              <ul class="footernav-social">
                <li><a href="http://twitter.com/unimelb" title="Unimelb Twitter account"><img src="images/twitter.png"></a></li>
                <li><a href="http://facebook.com/melbuni" title="Unimelb Facebook account"><img src="images/facebook.png"></a></li>
              </ul>
              <ul class="footernav-legals">
                <li><a href="http://www.unimelb.edu.au/disclaimer/" title="Disclaimer and copyright">Disclaimer &amp; copyright</a></li>
                <li><a href="http://www.unimelb.edu.au/accessibility/index.html" title="Accessibility">Accessibility</a></li>
                <li><a href="http://www.unimelb.edu.au/disclaimer/privacy.html" title="Privacy">Privacy</a></li>
              </ul>
              

            </div><!-- /footer --> 
        
           <script type="text/javascript">
		$(document).ready(function() { 
                     $("#top-of-page").bind("click",function(){
                	   $('html, body').stop().animate({ scrollTop : 0 }, 300);
	    		   return false;
                    });
		    $(".back_btn").click(function() {
			history.back();
			return false;
                   });
		});
	    </script>
           
    </body> 
</html>
