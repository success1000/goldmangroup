<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<meta charset="utf-8">

	<!-- Google Chrome Frame for IE -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php wp_title(''); ?></title>

	<!-- mobile meta (hooray!) -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) -->
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
			<![endif]-->
			<!-- or, set /favicon.ico for IE10 win -->
			<meta name="msapplication-TileColor" content="#f01d4f">
			<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

			<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

			<!-- wordpress head functions -->
			<?php wp_head(); ?>
			<!-- end of wordpress head -->

			<!-- drop Google Analytics Here -->
			<!-- end analytics -->
<script type="text/javascript">
var p = jQuery.noConflict();
p(document).ready(function(){
	p("#demo2").als({
		visible_items: 6,
		scrolling_items: 1,
		orientation: "horizontal",
		circular: "yes",
		autoscroll: "no"
	});

        p("#demo1").als({
		visible_items: 1,
		scrolling_items: 1,
		orientation: "horizontal",
		circular: "yes",
		autoscroll: "no"
	});

        p("#demoChannel").als({
		visible_items: 1,
		scrolling_items: 1,
		orientation: "horizontal",
		circular: "yes",
		autoscroll: "no"
	});
});
</script>

<style>#advisor, #incubator, #funding {display:none;}</style>
<script type="text/javascript">
function lunchboxOpen(lunchID) {
document.getElementById('lunch_' + lunchID).style.display = "block";
document.getElementById('clasp_' + lunchID).innerHTML="<a href=\"javascript:lunchboxClose('" + lunchID + "');\">Close Search</a> &uArr;";
document.getElementById('fundingBox').removeAttribute("style");
document.getElementById('advisorBox').removeAttribute("style");
}
function lunchboxClose(lunchID) {
document.getElementById('lunch_' + lunchID).style.display = "none";
document.getElementById('clasp_' + lunchID).innerHTML="<a href=\"javascript:lunchboxOpen('" + lunchID + "');\">Search Listings</a> &dArr;";
}
</script>

<style type="text/css">
    .box{
        padding: 0 0;
        display: none;
        margin-top: 0px;
        clear: both;
    }
</style>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
var j = jQuery.noConflict();
    j(document).ready(function(){
        j(".resAdvance").change(function(){
            j( ".resAdvance option:selected").each(function(){
                if(j(this).attr("value")=="1"){
		    j(".box").hide();
                    j(".funding").show();
		    document.getElementById('fundingBox').style.display = "block";
                }
                if(j(this).attr("value")=="3"){
 		    j(".box").hide();
                    j(".advisor").show();
		    document.getElementById('advisorBox').style.display = "block";
                }
                if(j(this).attr("value")=="0"){
                    j(".box").hide();
                }
                if(j(this).attr("value")=="2"){
                    j(".box").hide();
                }
            });
        }).change();
    });
</script>

<script type="text/javascript">
// function will loop through all input tags and create
// url string from checked checkboxes
function checkbox_test() {
    var counter = 0, // counter for checked checkboxes
        i = 0,       // loop variable
        url = '',    // final url string
        // get a collection of objects with the specified 'input' TAGNAME
        input_obj = document.getElementsByTagName('input');
    // loop through all collected objects
    for (i = 0; i < input_obj.length; i++) {
        // if input object is checkbox and checkbox is checked then ...
        if (input_obj[i].type === 'checkbox' && input_obj[i].checked === true) {
            // ... increase counter and concatenate checkbox value to the url string
            counter++;
            url = url + '&c=' + input_obj[i].value;
        }
    }
    // display url string or message if there is no checked checkboxes
    if (counter > 0) {
        // remove first "&" from the generated url string
        url = url.substr(1);
        // display final url string
        // alert(url);
        // or you can send checkbox values
        window.location.href = '../registration-start-now?' + url; 
    }
    else {
        alert('Please read and agree to our Terms & Conditions.');
    }
}

function checkbox_test1() {
    var counter = 0, // counter for checked checkboxes
        i = 0,       // loop variable
        url = '',    // final url string
        // get a collection of objects with the specified 'input' TAGNAME
        input_obj = document.getElementsByTagName('input');
    // loop through all collected objects
    for (i = 0; i < input_obj.length; i++) {
        // if input object is checkbox and checkbox is checked then ...
        if (input_obj[i].type === 'checkbox' && input_obj[i].checked === true) {
            // ... increase counter and concatenate checkbox value to the url string
            counter++;
            url = url + '&c=' + input_obj[i].value;
        }
    }
    // display url string or message if there is no checked checkboxes
    if (counter > 0) {
        // remove first "&" from the generated url string
        url = url.substr(1);
        // display final url string
        // alert(url);
        // or you can send checkbox values
        window.location.href = '../registration-complete?' + url; 
    }
    else {
        alert('Please read and agree to our Terms & Conditions.');
    }
}
</script>

<style type="text/css">
    .box{
        display: none;
    }

    #provider_container div.mainProv {display:none;}
    #fundHead a {cursor: pointer;}
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
var r = jQuery.noConflict();
    r(document).ready(function(){
        r('.chkCom').change(function () {                
     r(".companyInfo").toggle(!this.checked);
  }).change(); //ensure visible state matches initially
  
  r('.chkPro').change(function () {                
     r(".providerInfo").toggle(!this.checked);
  }).change(); //ensure visible state matches initially
});
</script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript">
var s = jQuery.noConflict();
s(window).load(function(){
s(document).ready(function(){
   s("#fundHead a").click(function(){
      var id =  s(this).attr('id');
      id = id.split('_');
      s("#provider_container div.mainProv").hide(); 
      s("#provider_container #menu_"+id[1]).show();
   });
});
});  
</script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.js"></script>
<script type="text/javascript"> 
var f = jQuery.noConflict();
f(window).load(function(){
function checkPasswordMatch() {
    var password = f("#txtNewPassword").val();
    var confirmPassword = f("#txtConfirmPassword").val();

    if (password != confirmPassword)
        f("#divCheckPasswordMatch").html("Passwords do not match!"),
        f("#divCheckPasswordMatch").css("color", "red");
    else
        f("#divCheckPasswordMatch").html("Passwords match."),
        f("#divCheckPasswordMatch").css("color", "green");
}

f(document).ready(function () {
   f("#txtConfirmPassword").keyup(checkPasswordMatch);
});

}); 

</script>

<script type='text/javascript'> 
var e = jQuery.noConflict();

e(window).load(function(){
e(document).ready(function(){  
    
e("a.mylink").each(function(i){
    e(this).click(function(){
         document.getElementById('provField').value = i ;
    }); 
}); 
                       

}); 
}); 

</script>

		</head>

		<body <?php body_class(); ?>>

			<div class="wrapper">

				<header class="header" role="banner">

					<nav role="navigation">
						<div class="navbar navbar-inverse navbar-fixed-top">
							<div class="container">
								<!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>

									<a class="navbar-brand" href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="homepage"><?php bloginfo( 'name' ) ?></a>

								</div>

								<div class="navbar-collapse collapse navbar-responsive-collapse">
									<?php bones_main_nav(); ?>
<div class="navbar-header2">
							
							<?php if ( is_user_logged_in() ) { ?> <a href="<?php bloginfo( 'url' ) ?>/your-profile/">Welcome</a> |<a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Logout</a> | <a href="<?php bloginfo( 'url' ) ?>/contact/" >Contact</a> <?php } else { ?> <a href="<?php bloginfo( 'url' ) ?>/login/"> Login </a> | <a href="<?php bloginfo( 'url' ) ?>/contact/" >Contact</a> <?php } ?>
								</div>
								</div>


							</div>
						</div> 
						
					</nav>

				</header> <!-- end header -->
