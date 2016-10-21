<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Exo+2:400,700' rel='stylesheet' type='text/css'>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>

  <?php echo '<script src="' . get_option( 'siteurl' ) . '/wp-includes/js/jquery-2.1.1.min.js" type="text/javascript" ></script>
  <script src="' . get_option( 'siteurl' ) . '/wp-includes/js/jquery.als-1.5.min.js" type="text/javascript"></script>'; ?>

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

<?php 
$mem_type = $_GET['mem_type'];
if ($mem_type =="1"){
echo '<style>.Provider {display:none;}</style>';
} elseif ($mem_type =="2"){
echo '<style>.Extended, .Financial, .Additional {display:none;}</style>';
};

$prov_type = $_GET['prov_type'];

if ($prov_type == ""){
echo '<style>#advisor, #incubator, #funding {display:none;}</style>';
} elseif ($prov_type =="1"){
echo '<style>#advisor, #incubator {display:none;} #funding {display:block;}</style>';
} elseif ($prov_type =="2"){
echo '<style>#funding, #advisor {display:none;} #incubator{display:block;}</style>';
} elseif ($prov_type =="3"){
echo '<style>#funding, #incubator {display:none;} #advisor{display:block;}</style>';
};

?>

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

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });
});
</script>

<style>
select {width: 150px;}
#width_tmp{display : none;}
</style>

<script type="text/javascript">
var m = jQuery.noConflict();
m(document).ready(function() {
 m('#country').change(function(){
    m("#width_tmp").html(m('#country option:selected').text());
    m(this).width(m("#width_tmp").width()+50); // 30 : the size of the down arrow of the select box 
 });
});
</script>

<script type="text/javascript">
var b = jQuery.noConflict();
b(document).ready(function() {
 b('#state').change(function(){
    b("#width_tmp").html(b('#state option:selected').text());
    b(this).width(b("#width_tmp").width()+50); // 30 : the size of the down arrow of the select box 
 });
});
</script>



<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
var n = jQuery.noConflict();
n(document).ready(function(){
        n("#country").change(function(){
            n( "#country option:selected").each(function(){
                if(n(this).attr("value")=="United States (+1)"){
                    n(".boxs").hide();
                    n(".usField").show();
                } else {
                    n(".boxs").hide();
                    n(".interField").show();
		}                
            });
        }).change();
    });
</script>

<script type="text/javascript">
var g = jQuery.noConflict();
g(document).ready(function(){
        g("#incYes").change(function(){
            g( "#incYes option:selected").each(function(){
                if(g(this).attr("value")=="Yes"){
                    g(".incInput").show();
                } else {
                    g(".incInput").hide();
		}               
            });
        }).change();
    });
</script>

<script type="text/javascript">
var f = jQuery.noConflict();
f(document).ready(function(){ 
    f("input[name=group1]").change(function() {
        var test = f(this).val();
        f("div.desc").hide();
        f("#"+test).show();
    }); 
});
</script>

<?php echo '<script src="' . get_option( 'siteurl' ) . '/wp-includes/js/jquery-1.10.2.min.js"></script>
<script src="' . get_option( 'siteurl' ) . '/wp-includes/js/jquery.form.min.js"></script>'; ?>

<script type="text/javascript">
var d = jQuery.noConflict();

d(document).ready(function() { 
	var options = { 
			target: '#output',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmit,  // pre-submit callback 
			success: afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 d('#MyUploadForm').submit(function() { 
			d(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
}); 

function afterSuccess()
{
	d('#submit-btn').show(); //hide submit button
	d('#loading-img').hide(); //hide submit button

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !d('#imageInput').val()) //check empty input filed
		{
			d("#output").html("Are you kidding me?");
			return false
		}
		
		var fsize = d('#imageInput')[0].files[0].size; //get file size
		var ftype = d('#imageInput')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                d("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			d("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		d('#submit-btn').hide(); //hide submit button
		d('#loading-img').show(); //hide submit button
		d("#output").html("");  
	}
	else
	{
		//Output error to older browsers that do not support HTML5 File API
		d("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

</script>
</head>

<body <?php body_class(); ?>>
<?php if ( is_user_logged_in() ) {
  $current_user = wp_get_current_user();
        echo '<div id="logHead" style="width: 100%; height: 40px; margin-bottom: 10px; background: #333333; color: #fff;">' . '<div style="float: right; margin-top: 12px; margin-right: 10px;">Welcome, ' . esc_html( $current_user->user_login ) . ' | <a href="' . get_option( 'siteurl' ) . '/members" style="color: #fff;">My Profile</a> | ' . '<a href="' . get_option( 'siteurl' ) . '/wp-login.php?action=logout" style="color: #fff;">Log Out</a>' . '</div></div><div style="clear:both;"></div>';
    } else {
        echo "";
    }
?>
<div id="page" class="hfeed site">

<header id="masthead" class="site-header" role="banner">
<div style="float:left; ">
<?php echo '<a href="' . get_option( 'siteurl' ) . '"> <img src="' . get_option( 'siteurl' ) . '/wp-content/uploads/sites/2/2014/03/logo.jpg" style="width:100%; " /></a>';?>
</div>

<!--<div style="float:right; margin-top: 28px;">
  <div id="searchwrapper">
    <div style="float:left; ">
<a href="http://www.startupstowatch.com"><img src="http://www.startupstowatch.com/wp-content/uploads/sites/2/2014/03/house.jpg" style="width: 45px; padding-top: 30px; " /></a>
    </div>
     <div style="float:right; ">
<form action="">
<p style=" font-size: 16px; font-weight: bold; ">SITE SEARCH:</p><br/>
<input type="text" class="searchbox" name="s" value="" size="35"><br>
<input type="image" src="http://www.startupstowatch.com/wp-content/uploads/sites/2/2014/03/search.png" class="searchbox_submit" value="" style=" padding-top: 3px; background-color: white; ">
<input type="submit" class="reg-button small" value="Submit" /> 
</form>
    </div>
  </div>
</div>-->
		

		<?php if ( get_header_image() ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="main" class="wrapper">