<?php 
    require_once("lib/proxylib.php");
    require_once("lib/access.php");

    session_start();
    is_authenticated();
    log_traffic();
?>
<!DOCTYPE html>  
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"> 
    <head> 
        <title>Web Usage Meter - StudentIT Mobile</title> 

        <meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="touch-icon-iphone4.png" />

	<link rel="shortcut icon" href="http://www.unimelb.edu.au/favicon.ico">
        <meta name='HandheldFriendly' content='true'> 
        <meta name="mobileoptimized" content="0">
        <meta name='viewport' content='height=device-height, width=device-width, initial-scale=1.0, user-scalable=yes'> 

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
                    <h4>Your usage</h4>
                    
                    <div class="form_wrap">
                        <div class="hdImage"></div>
                        
                        <div class="inner-content-wrap">
                            
                            <?php 
                                # Print the usage table for this username.
                                display_usage($_SESSION['username'], 'sit_display');
                            ?>
                
                        </div><!-- end inner-content-wrap -->
                    </div> <!-- end form_wrap -->
                </div> <!-- end block_wrap -->
                
                <div class="noBorder" style="margin-bottom:20px; text-align:center;">
                    <p class="noMargin"><a class="btn_logout" href="auth.php?logout=true">Logout</a></p>
                    <p class="credits">Backend development by Clement Poh, Student IT</p>
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
              
            </div> <!-- /footer --> 
        
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
