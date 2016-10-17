<?php
date_default_timezone_set("America/New_York");
get_currentuserinfo();

	  
$today = date("Y-m-d H:i:s");
$today1 = date("H-i-s");

require 'connect.php';

if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}

//SUBMIT UPDATED ENTRY
if (!empty($_POST)) {
	
$userName = $_POST['userName'];
$userEmail = $_POST['userEmail'];
$userPass = md5($_POST['userPass']);
$chkCompany = $_POST['checkCompany'];
$chkProvider = $_POST['checkProvider'];

//User Info

$sql = "INSERT INTO wp_users (user_login, user_pass, user_nicename, user_email, user_registered, display_name) VALUES ('".$userName."', '".$userPass."', '".$userName."', '".$userEmail."', '".$today."', '".$userName."')";

$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
	  die('Could not enter data: ' . mysql_error());
	}
echo "<div class=\"errorMess\" style=\"margin-bottom: 10px; border-top: 1px solid #333;border-bottom: 1px solid #333;padding: 5px 0; color: green; font-weight: bold;\">Entered data successfully</div>";

$newId = mysql_insert_id();

$sql2 = "INSERT INTO wp_usermeta (user_id, meta_key, meta_value) VALUES ('".$newId."', 'nickname', '".$userName."'), ('".$newId."', 'rich_editing', 'true'), ('".$newId."', 'comment_shortcuts', 'false'),('".$newId."', 'admin_color', 'fresh'),('".$newId."', 'use_ssl', '0'),('".$newId."', 'show_admin_bar_front', 'true'),('".$newId."', 'wp_capabilities', 'a:1:{s:10:\"subscriber\";b:1;}'),('".$newId."', 'wp_user_level', '0'),('".$newId."', 'dismissed_wp_pointers', 'wp330_toolbar'),('".$newId."', 'default_password_nag', '1')";

$retval1 = mysql_query( $sql2, $conn );
	if(! $retval1 )
	{
	  die('Could not enter data: ' . mysql_error());
	};


//Company and Provider Info
	if ($_POST['checkProvider'] == "1") {
		$mem_TYPE = "2";
	} else {
		$mem_TYPE = "1";
	}

	if ($_POST['provField'] == "0") {
		$prov_TYPE = "Funding Source";
	} elseif ($_POST['provField'] == "1"){
		$prov_TYPE = "Incubator";
	} elseif ($_POST['provField'] == "2"){
		$prov_TYPE = "Advisor";
	};

$companyName = $_POST['companyName'];
$companyStreet = $_POST['companyStreet'];
$companyCity = $_POST['companyCity'];
$companyState = $_POST['companyState'];
$companyZip = $_POST['companyZip'];
$companyPhone = $_POST['Phone1']."-".$_POST['Phone2']."-".$_POST['Phone3'];

$companyWeb = $_POST['companyWeb'];


$companyChannel = $_POST['companyChannel'];
$fundingType = $_POST['fundingType'];
$checkFundType = implode(',', $_POST['checkFundType']);
$incubatorType = $_POST['incubatorType'];
$advisorType = $_POST['advisorType'];
$checkAdvServ = implode(',', $_POST['checkAdvServ']);
$arrAdvServ = explode(",",$checkAdvServ);
$checkProvInd = implode(',', $_POST['checkProvInd']);


$sql3 = "INSERT INTO wp_bp_company (com_UserID, com_memType, com_provType, com_Name, com_Street, com_City, com_State, com_Zip, com_Phone, com_Web, com_FundingType, com_IncubatorType, com_AdvisorType, channel, FundTypeChoice, AdvisorServices, ProviderIndustries) VALUES ('" . $newId . "', '" . $mem_TYPE . "', '" . $prov_TYPE . "', '" . $companyName . "', '" . $companyStreet . "', '" . $companyCity . "', '" . $companyState . "', '" . $companyZip . "', '" . $companyPhone . "', '" . $companyWeb . "', '" . $fundingType . "', '" . $incubatorType . "', '" . $advisorType . "', '" . $companyChannel . "', '" . $checkFundType . "', '" . $checkAdvServ . "', '" . $checkProvInd . "')";

$retval2 = mysql_query( $sql3, $conn );
	if(! $retval2 )
	{
	  die('Could not enter data: ' . mysql_error());
	};

$to  = 'goldmric@gmail.com' . ', '; // note the comma
	
// subject - to admin verify
$subject = 'A New Company Registration for ' . $companyName;
	
// message
$message = "A new company has been added to the community.  Details are below." . "<br/><br/>";
$message .= "<br/><br/>";
$message .= "To view the company information, click <a href=\"http://www.startupstowatch.com/wp-admin/company-edit.php?uid=" . $newId . "\">here</a> and login to view.";
	
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									
// Additional headers
$headers .= 'From: StartupsToWatch Team' . ' <connect@startupstowatch.com>' . "\r\n";

// Mail it to Admin
mail($to, $subject, $message, $headers);

$to1  = $userEmail . ', '; // note the comma
	
// subject
$subject1 = 'New Company Registration for ' . $companyName;
	
// message
$message1 = "Welcome, " . $companyName . ", to the StartupsToWatch community.  You are listed as the company administrator and can login with the username: " . $userName . "<br/><br/>";
$message1 .= "<br/><br/>";
$message1 .= "A password has been generated for you and will arrive in separate email.  You will need both to login. <br/><br/>To view your company information, click <a href=\"http://www.startupstowatch.com\">here</a> and login";
	
// To send HTML mail, the Content-type header must be set
$headers1  = 'MIME-Version: 1.0' . "\r\n";
$headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									
// Additional headers
$headers1 .= 'From: StartupsToWatch Team' . ' <connect@startupstowatch.com>' . "\r\n";

// Mail it to new user, username
mail($to1, $subject1, $message1, $headers1);

$to2  = $userEmail . ', '; // note the comma
	
// subject
$subject2 = 'New Company Registration for ' . $companyName;
	
// message
$message2 = "Welcome, " . $companyName . ", to the StartupsToWatch community.  Your password is: " . $userPass . "<br/><br/>";
$message2 .= "<br/><br/>";
$message2 .= "To view your company information, click <a href=\"http://www.startupstowatch.com\">here</a> and login with your ealier provided username and the password above.";
	
// To send HTML mail, the Content-type header must be set
$headers2  = 'MIME-Version: 1.0' . "\r\n";
$headers2 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									
// Additional headers
$headers2 .= 'From: StartupsToWatch Team' . ' <connect@startupstowatch.com>' . "\r\n";

// Mail it to new user, username
mail($to2, $subject2, $message2, $headers2);

header('Location: http://www.startupstowatch.com/wp-admin/company-add-final.php?id=' . $newId);
die();
};

echo '  
<div id="mainContent">
	 <form name="memberForm" method="POST" action="">
		<div id="outer-container" class="tab-container">
		<ul class="etabs">
			<li class="tab"><a href="#userInfo">User Information</a></li>
			<li class="tab"><a href="#companyInfo">Company Information</a></li>
			<li class="tab"><a href="#manageInfo">Management Information</a></li>
			<li class="tab"><a href="#providerInfo">Provider Information</a></li>
  		</ul>
        <div class="panel-container">
			<div id="userInfo">
				<h3>Primary Contact</h3>
				<div class="entryLong">
					<div style="float: left; margin-right: 20px;">User Name <span class="req">*</span><br/><input type="text" name="userName" class="entryFieldLong" value="' . $row[8] . '"/></div>
					<div style="float: left; margin-right: 20px;">Email Address <span class="req">*</span><br/><input type="text" name="userEmail" class="entryField" style="width: 200px;" value="' . $row[9] . '"/></div>
				</div>
				<div style="float: left; margin-right: 20px;">Choose a password <span class="Req">*</span><br/><input type="password" id="txtNewPassword" name="userPass"/></div>
				<div style="float: left; margin-right: 20px;">Confirm password <span class="Req">*</span><br/><input type="password" id="txtConfirmPassword" onChange="checkPasswordMatch();" /></div>
				<div style="float: left; padding-top: 28px;" class="registrationFormAlert" id="divCheckPasswordMatch"></div>
				<div style="clear: both; padding-top: 20px; margin-bottom: 20px;">Will you also registering a company now. <input type="checkbox" class="chkCom" value="1" name="checkCompany" /> No</div>
			</div>
			<div id="companyInfo">
				<h3>Company Information</h3>
				<div class="entryLong">
					<div style="float: left; margin-right: 20px;">Company Name<br/><input type="text" name="companyName" class="entryFieldLong" value="' . $row[0] . '"/></div>
					<div style="float: left; margin-right: 20px;">Street Address<br/><input type="text" name="companyStreet" class="entryField" value="' . $row[1] . '"/></div>
					<div style="float: left; margin-right: 20px;">City<br/><input type="text" name="companyCity" class="entryField" value="' . $row[2] . '"/></div>
					<div style="float: left; margin-right: 20px;">State><br/>
						<select name="companyState">
							<option id="0" value="0">Select</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District Of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
					</div>
					<div style="float: left;">Zip Code<br/><input type="text" name="companyZip" value="' . $row[4] . '"/></div>
				</div>
				<div class="clear"></div>
				<div class="entry" style="clear: both; float: left; margin-top: 10px; margin-bottom:10px;">Country<br/>
				<select id="country" name="country">
				';
				$resultCode = mysql_query("SELECT * FROM wp_countrycodes WHERE Active = '1'");
				if (!$resultCode) {
    				echo 'Could not run query: ' . mysql_error();
    				exit;
				};
	
				while ($row1 = mysql_fetch_array($resultCode, MYSQL_ASSOC)) {
					echo '<option value="' . $row1['Value'] . '" ';
					
					if ($row[8] == $row1['Value']) {
						echo 'selected="selected"';
					};
					
					echo '>' . $row1['Value'] . '</option>';
				};
				
echo '			<option value="United States (+1)">United States (+1)</option>
				</select>
				<span id="width_tmp"></span>
				</div>
				<div class="entry usField boxs" style="margin-left: 15px;margin-top: 10px; float: left;">Phone Number<br/>
            (<input style="width: 50px;" maxlength="3" type="text" name="Phone1" />) <input style="width: 50px" maxlength="3" type="text" name="Phone2" />-<input style="width: 100px;" maxlength="4" type="text" name="Phone3" />
            </div>
<div class="entry interField boxs" style="margin-left: 15px; margin-top: 10px;float: left;">Phone Number<br/>
            <input style="width: 250px;" maxlength="15" type="text" name="Phone" />
            </div>
				<div class="entry" style="float: left; margin-left: 15px; margin-top: 10px;">Website<br/><input type="text" name="companyWeb" value=""/></div>
				<div class="entryLong textBlock" style="clear: both; margin-top: 10px;">What do you do?<br/>
        		<textarea name="shortBio" class="textArea" style="width: 400px; height: 100px;"></textarea>
				</div>';
				
			
				echo '<div class=\"entryShort\">Year Established <br/>
					<select name=\"yearEstab\">';
				
				define('DOB_YEAR_START', 1900);
				$current_year = date('Y');
				for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
				{
    			echo "<option value='{$count}'>{$count}</option>";
				}
				
				echo '</select>
        		</div>
				<div class="entryShort" style="clear: both; float: left; margin-top: 10px;">Are You Incorporated?<br/>
        <select name="companyInc">
            <option id="yes" value="Yes">Yes</option>
            <option id="no" value="No">No</option>
            <option id="na" value="N/A">N/A</option>
        </select>
        </div>
        <div class="entry" style="float: left; margin-top: 10px; margin-left: 15px;">Stage <br/>
        <select name="companyStage">
        	<option id="0" value="0" >Select</option>
            <option id="1" value="1" >Noodling-(Thinking about an idea)</option>
            <option id="2" value="2" >Developing-(Building-Testing)</option>
            <option id="3" value="3" >Selling-(Initial Proof of Concept)</option>
            <option id="4" value="4" >Growing-(Annualized Sales $1.0m+)</option>
        </select>
        </div>
		<div class="entry" style="float: left; margin-top: 10px;margin-left: 15px;">Channel<br/>
					<select name="companyChannel">
					<option value="None">None</option>';
					?>
					<?php query_posts( 'post_type=channel&posts_per_page=10' ); ?>
					<?php while ( have_posts() ) : the_post(); ?>
					<option value="<?php the_title() ?>" <?php $chUse = the_title('','',0); if ($chUse == $row[7]) {echo 'selected="selected"';}?>><?php the_title() ?></option>	
					<?php endwhile; ?>
					<?
					echo '</select>
				</div>
		<div class="entry" style="margin-top: 10px; clear: both;">Number of Employees<br/>
        <select name="companyEmp">
        	<option id="1" value="&lt; 25" >&lt; 25</option>
            <option id="2" value="26-50" >26-50</option>
            <option id="3" value="51-75" >51-75</option>
            <option id="4" value="76-100" >76-100</option>
            <option id="5" value="100+" >100+</option>
        </select>
        </div>
        <div class="entry" style="clear: both; margin-top: 10px; float: left;">Do you belong to an incubator? <br/>
        <select name="companyIncBelong">
        	<option id="1" value="Yes" >Yes</option>
            <option id="2" value="No" >No</option>
        </select>
		</div>
        <div class="entry" style="margin-top: 10px; float: left;margin-left: 15px;">If yes, which one? <br/>
		<input type="text" name="companyIncubatorWhich" value=""/>
		</div>
        <div class="entry" style=" clear: both; margin-top: 10px; float: left;">Geography <br/>
        <select name="companyGeog">
            <option id="1" value="US-Northeast" >US-Northeast</option>
            <option id="2" value="US-Southeast" >US-Southeast</option>
            <option id="3" value="US-Midwest" >US-Midwest</option>
            <option id="4" value="US-Northwest" >US-Northwest</option>
            <option id="5" value="US-Southwest" >US-Southwest</option>
            <option id="6" value="International" >International</option>
        </select>
        </div>
			   <div style="padding-top: 20px;margin-top: 10px; clear: both;">Will this company also be joining our Provider Network <input type="checkbox" class="chkPro" value="1" name="checkProvider"/> Yes</div>
			   
	    </div>
		<div id="manageInfo">
		<h3>Management Information</h3>
		<div class="entry">Owners Or Managers (up to 3, including you)?<br/>
        <input class="owner1" style="width: 200px;" type="text" name="owner1_name" placeholder="Owner\'s Name" value="">&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="owner1" style="width: 200px;" type="text" name="owner2_name" placeholder="Owner\'s Name" value="">&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="owner1" style="width: 200px;" type="text" name="owner3_name" placeholder="Owner\'s Name" value=""><br/>

        <input class="owner1" style="width: 200px;" type="text" name="owner1_title" placeholder="Owner\'s Title" value="">&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="owner1" style="width: 200px;" type="text" name="owner2_title" placeholder="Owner\'s Title" value="">&nbsp;&nbsp;&nbsp;&nbsp;
        <input class="owner1" style="width: 200px;" type="text" name="owner3_title" placeholder="Owner\'s Title" value=""><br/>

        <textarea name="owner1_Bio" class="textArea owner1" style="font-size: 13px; width: 200px; height: 100px;" maxlength="250" placeholder="Bio of Owner (250 Char. or Less)"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;
        <textarea name="owner2_Bio" class="textArea owner1" style="font-size: 13px; width: 200px; height: 100px;" maxlength="250" placeholder="Bio of Owner (250 Char. or Less)"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;
        <textarea name="owner3_Bio" class="textArea owner1" style="font-size: 13px; width: 200px; height: 100px;" maxlength="250" placeholder="Bio of Owner (250 Char. or Less)"></textarea>
        </div>
        <hr class="regForm"/>
        <div class="entry">Investors or Advisors (up to 3)?<br/>
        <input class="owner1" style="width: 200px;" type="text" name="adv1_name" placeholder="Advisor\'s Name"  value="">&nbsp;&nbsp;&nbsp;&nbsp;<input class="owner1" style="width: 200px;" type="text" name="adv2_name" placeholder="Advisor\'s Name"  value="">&nbsp;&nbsp;&nbsp;&nbsp;<input class="owner1" style="width: 200px;" type="text" name="adv3_name" placeholder="Advisor\'s Name"  value=""><br/>
        <input class="owner1" style="width: 200px;" type="text" name="adv1_title" placeholder="Advisor\'s Title" value="" >&nbsp;&nbsp;&nbsp;&nbsp;<input class="owner1" style="width: 200px;" type="text" name="adv2_title" placeholder="Advisor\'s Title" value="" >&nbsp;&nbsp;&nbsp;&nbsp;<input class="owner1" style="width: 200px;" type="text" name="adv3_title" placeholder="Advisor\'s Title"  value=""><br/>
        <textarea name="adv1_Bio" class="textArea owner1" style="font-size: 13px; width: 200px; height: 100px;" maxlength="250" placeholder="Other Relationships (250 Char. or Less)"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="adv2_Bio" class="textArea owner1" style="font-size: 13px; width: 200px; height: 100px;" maxlength="250" placeholder="Other Relationships (250 Char. or Less)"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="adv3_Bio" class="textArea owner1" style="font-size: 13px; width: 200px; height: 100px;" maxlength="250" placeholder="Other Relationships (250 Char. or Less)"></textarea>
        </div>
        
			</div>
			<div id="providerInfo">
				<h3>Provider Details</h3>
				<div id="fundHead" style="border-top: 1px solid #333; border-bottom: 1px solid #333; padding: 10px 0; margin-bottom: 10px;">
					 <strong>This section to be filled out only if company registering will be a provider to member companies</strong>
				</div>
				<div id="provider_container">
					Which type of service will the company provide to our members?
					<div id="inner-container" class="tab-container">
						 <ul class="etabs prov">
						   <li class="tab prov"><a href="#menu_Fund">Funding Source</a></li>
						   <li class="tab prov"><a href="#menu_Inc">Incubator</a></li>
						   <li class="tab prov"><a href="#menu_Adv">Advisor</a></li>
						 </ul>
						<div class="panel-container">
							<div id="menu_Fund">
								<strong>Company is registering as a funding source.</strong><br/><br/>
								What type of funding source would the company classify as?<br/>
								<select name="fundingType">
								<option id="0" value="0">Select</option>
								<option id="1" value="Angel Fund" >Angel Fund</option>
								<option id="2" value="Angel Investor" >Angel Investor</option>
								<option id="3" value="Commercial Lender" >Commercial Lender</option>
								<option id="4" value="Intermediary" >Intermediary</option>
								<option id="5" value="Venture Fund" >Venture Fund</option>
								</select>
								<br/><br/>
								<div id="fundOptions">
								Funding Option: (Select all that apply)
								<table>
									<tr>
										<td colspan="5"><input type="checkbox" value="1" name="checkall" onclick="checkedAll();"/> All</td>
									</tr>
									<tr>
										<td><input type="checkbox" value="1" name="checkFundType[]" /> Commercial-Current Asset Based Loan</td>
										<td><input type="checkbox" value="2" name="checkFundType[]" /> Commercial Loan-Term</td>
										<td><input type="checkbox" value="3" name="checkFundType[]" /> Commercial Mortgage</td>
										<td><input type="checkbox" value="4" name="checkFundType[]" /> Credit Card Income Advance</td>
									</tr>
									<tr>
										<td><input type="checkbox" value="5" name="checkFundType[]" /> Equipment Lease</td>
										<td><input type="checkbox" value="6" name="checkFundType[]" /> Line of Credit - Business</td>
										<td><input type="checkbox" value="7" name="checkFundType[]" /> Line of Credit - Personal</td>
										<td><input type="checkbox" value="8" name="checkFundType[]" /> Equity-Common</td>
									</tr>
									<tr>
										<td><input type="checkbox" value="9" name="checkFundType[]" /> Equity-Convertible Debt</td>
										<td><input type="checkbox" value="10" name="checkFundType[]" /> Equity-Limited Partner</td>
										<td><input type="checkbox" value="11" name="checkFundType[]" /> Equity-Preferred</td>
										<td><input type="checkbox" value="12" name="checkFundType[]" /> Home Equity Loan</td>
									</tr>
								</table>
								</div>
								<script type = "text/javascript">
								var checked = false;
								function checkedAll () {
								checked == true? checked = false:checked = true;
								var els = document.getElementById("fundOptions").getElementsByTagName("input");
								var len = els.length;
								for (var i = 0; i < len; i++) {
								els[i].checked = checked;
								}
								}
								</script>
								<div id="fundInd">
								Which Industries does the company invest in? (Select all that apply)<br/>
								<table>
								<tr>
									<td colspan="5"><input type="checkbox" value="1" name="checkall" onclick="checkedAll2();"/> All</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="2" name="checkProvInd[]" /> Consumer Products</td>
									<td><input type="checkbox" value="3" name="checkProvInd[]" /> Distribution</td>
									<td><input type="checkbox" value="4" name="checkProvInd[]" /> Education</td>
									<td><input type="checkbox" value="5" name="checkProvInd[]" /> Energy/Chemical</td>
									<td><input type="checkbox" value="6" name="checkProvInd[]" /> Fashion</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="7" name="checkProvInd[]" /> Film/Entertainment</td>
									<td><input type="checkbox" value="8" name="checkProvInd[]" /> Financial Services</td>
									<td><input type="checkbox" value="9" name="checkProvInd[]" /> Food-Beverage</td>
									<td><input type="checkbox" value="10" name="checkProvInd[]" /> Healthcare</td>
									<td><input type="checkbox" value="11" name="checkProvInd[]" /> Hospitality</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="12" name="checkProvInd[]" /> Insurance</td>
									<td><input type="checkbox" value="13" name="checkProvInd[]" /> IT Hardware</td>
									<td><input type="checkbox" value="14" name="checkProvInd[]" /> IT Software</td>
									<td><input type="checkbox" value="15" name="checkProvInd[]" /> IT Mobile</td>
									<td><input type="checkbox" value="16" name="checkProvInd[]" /> Manufacturing-Non Technical</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="17" name="checkProvInd[]" /> Manufacturing-Technical</td>
									<td><input type="checkbox" value="18" name="checkProvInd[]" /> Music</td>
									<td><input type="checkbox" value="19" name="checkProvInd[]" /> Nonprofit</td>
									<td><input type="checkbox" value="20" name="checkProvInd[]" /> Pharmaceutical</td>
									<td><input type="checkbox" value="21" name="checkProvInd[]" /> Real Estate</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="22" name="checkProvInd[]" /> Restaurant</td>
									<td><input type="checkbox" value="23" name="checkProvInd[]" /> Retail</td>
									<td><input type="checkbox" value="24" name="checkProvInd[]" /> Telecommunication</td>
									<td><input type="checkbox" value="25" name="checkProvInd[]" /> Toy</td>
									<td><input type="checkbox" value="26" name="checkProvInd[]" /> Wholesale Distribution</td>
								</tr>
								</table>
								</div>
								<script type = "text/javascript">
								var checked = false;
								function checkedAll2 () {
								checked == true? checked = false:checked = true;
								var els = document.getElementById("fundInd").getElementsByTagName("input");
								var len = els.length;
								for (var i = 0; i < len; i++) {
								els[i].checked = checked;
								}
								}
								</script>
							</div>
							<div id="menu_Inc">
								<strong>Company is registering as a Incubator.</strong><br/><br/>
								What channel does the company most align to?<br/>
								<select name="incubatorType">
								<option id="0" value="0">Select</option>
								<option id="1" value="Energy" >Energy</option>
								<option id="2" value="Fashion" >Fashion</option>
								<option id="3" value="Food" >Food</option>
								<option id="4" value="Healthcare" >Healthcare</option>
								<option id="5" value="Mobile App" >Mobile App</option>
								<option id="6" value="Technology" >Technology</option>
								<option id="7" value="Toys" >Toys</option>
								<option id="8" value="General" >General</option>
								</select>
								<br/><br/>
								<div id="incInd">
								Which Industries? (Select all that apply)<br/>
								<table>
								<tr>
									<td colspan="5"><input type="checkbox" value="1" name="checkall" onclick="checkedAll3();"/> All</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="2" name="checkProvInd[]" /> Consumer Products</td>
									<td><input type="checkbox" value="3" name="checkProvInd[]" /> Distribution</td>
									<td><input type="checkbox" value="4" name="checkProvInd[]" /> Education</td>
									<td><input type="checkbox" value="5" name="checkProvInd[]" /> Energy/Chemical</td>
									<td><input type="checkbox" value="6" name="checkProvInd[]" /> Fashion</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="7" name="checkProvInd[]" /> Film/Entertainment</td>
									<td><input type="checkbox" value="8" name="checkProvInd[]" /> Financial Services</td>
									<td><input type="checkbox" value="9" name="checkProvInd[]" /> Food-Beverage</td>
									<td><input type="checkbox" value="10" name="checkProvInd[]" /> Healthcare</td>
									<td><input type="checkbox" value="11" name="checkProvInd[]" /> Hospitality</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="12" name="checkProvInd[]" /> Insurance</td>
									<td><input type="checkbox" value="13" name="checkProvInd[]" /> IT Hardware</td>
									<td><input type="checkbox" value="14" name="checkProvInd[]" /> IT Software</td>
									<td><input type="checkbox" value="15" name="checkProvInd[]" /> IT Mobile</td>
									<td><input type="checkbox" value="16" name="checkProvInd[]" /> Manufacturing-Non Technical</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="17" name="checkProvInd[]" /> Manufacturing-Technical</td>
									<td><input type="checkbox" value="18" name="checkProvInd[]" /> Music</td>
									<td><input type="checkbox" value="19" name="checkProvInd[]" /> Nonprofit</td>
									<td><input type="checkbox" value="20" name="checkProvInd[]" /> Pharmaceutical</td>
									<td><input type="checkbox" value="21" name="checkProvInd[]" /> Real Estate</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="22" name="checkProvInd[]" /> Restaurant</td>
									<td><input type="checkbox" value="23" name="checkProvInd[]" /> Retail</td>
									<td><input type="checkbox" value="24" name="checkProvInd[]" /> Telecommunication</td>
									<td><input type="checkbox" value="25" name="checkProvInd[]" /> Toy</td>
									<td><input type="checkbox" value="26" name="checkProvInd[]" /> Wholesale Distribution</td>
								</tr>
								</table>
								</div>
								<script type = "text/javascript">
								var checked = false;
								function checkedAll3 () {
								checked == true? checked = false:checked = true;
								var els = document.getElementById("incInd").getElementsByTagName("input");
								var len = els.length;
								for (var i = 0; i < len; i++) {
								els[i].checked = checked;
								}
								}
								</script>
							</div>
							<div id="menu_Adv"><strong>Company is registering as an advisor.</strong><br/><br/>
								What type of advisor will the company like to be?<br/>
								<select name="advisorType">
								<option id="0" value="0">Select</option>
								<option id="1" value="Accounting Firm" >Accounting Firm</option>
								<option id="4" value="Financial Planning Firm" >Financial Planning Firm</option>
								<option id="4" value="Insurance" >Insurance</option>
								<option id="2" value="Law Firm" >Law Firm</option>
								<option id="3" value="Marketing Firm" >Marketing Firm</option>
								<option id="4" value="Technology Firm" >Technology Firm</option>
								<option id="4" value="Mentor" >Mentor</option>
								<option id="4" value="Other" >Other</option>
								</select>
								<br/><br/>
								<div id="advServ">
								Services: (Select all that apply)
								<table>
								<tr>
									<td colspan="5"><input type="checkbox" value="1" name="checkall" onclick="checkedAll4();"/> All</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="1" name="checkAdvServ[]" /> Accounting-Bookkeeping</td>
									<td><input type="checkbox" value="2" name="checkAdvServ[]" /> Accounting-Financial statement preparation</td>
									<td><input type="checkbox" value="3" name="checkAdvServ[]" /> Accounting-Tax return preparation</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="4" name="checkAdvServ[]" /> Attorney-Employment law</td>
									<td><input type="checkbox" value="5" name="checkAdvServ[]" /> Attorney-Estate planning</td>
									<td><input type="checkbox" value="6" name="checkAdvServ[]" /> Attorney-General Business</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="7" name="checkAdvServ[]" /> Financial Management-Budgeting</td>
									<td><input type="checkbox" value="8" name="checkAdvServ[]" /> Financial Management-Business plan development</td>
									<td><input type="checkbox" value="9" name="checkAdvServ[]" /> Financial Management-Planning</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="10" name="checkAdvServ[]" /> General Business Consultancy</td>
									<td><input type="checkbox" value="11" name="checkAdvServ[]" /> Human Resources</td>
									<td><input type="checkbox" value="12" name="checkAdvServ[]" /> Insurance</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="13" name="checkAdvServ[]" /> Marketing</td>
									<td><input type="checkbox" value="14" name="checkAdvServ[]" /> Web Development-Graphics specialty</td>
									<td><input type="checkbox" value="15" name="checkAdvServ[]" /> Web Development-Programming</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="16" name="checkAdvServ[]" /> Web Development-SEO</td>
									<td><input type="checkbox" value="16" name="checkAdvServ[]" /> Other</td>
									<td></td>
								</tr>
								</table>
								</div>
								<script type = "text/javascript">
								var checked = false;
								function checkedAll4 () {
								checked == true? checked = false:checked = true;
								var els = document.getElementById("advServ").getElementsByTagName("input");
								var len = els.length;
								for (var i = 0; i < len; i++) {
								els[i].checked = checked;
								}
								}
								</script>
								<div id="advInd">
								Industries the company will advise: (Select all that apply)<br/>
								<table>
								<tr>
									<td colspan="5"><input type="checkbox" value="1" name="checkall" onclick="checkedAll5();"/> All</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="2" name="checkProvInd[]" /> Consumer Products</td>
									<td><input type="checkbox" value="3" name="checkProvInd[]" /> Distribution</td>
									<td><input type="checkbox" value="4" name="checkProvInd[]" /> Education</td>
									<td><input type="checkbox" value="5" name="checkProvInd[]" /> Energy/Chemical</td>
									<td><input type="checkbox" value="6" name="checkProvInd[]" /> Fashion</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="7" name="checkProvInd[]" /> Film/Entertainment</td>
									<td><input type="checkbox" value="8" name="checkProvInd[]" /> Financial Services</td>
									<td><input type="checkbox" value="9" name="checkProvInd[]" /> Food-Beverage</td>
									<td><input type="checkbox" value="10" name="checkProvInd[]" /> Healthcare</td>
									<td><input type="checkbox" value="11" name="checkProvInd[]" /> Hospitality</td>
								</tr>
								<tr>
				
									<td><input type="checkbox" value="12" name="checkProvInd[]" /> Insurance</td>
									<td><input type="checkbox" value="13" name="checkProvInd[]" /> IT Hardware</td>
									<td><input type="checkbox" value="14" name="checkProvInd[]" /> IT Software</td>
									<td> <input type="checkbox" value="15" name="checkProvInd[]" /> IT Mobile</td>
									<td><input type="checkbox" value="16" name="checkProvInd[]" /> Manufacturing-Non Technical</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="17" name="checkProvInd[]" /> Manufacturing-Technical</td>
									<td><input type="checkbox" value="18" name="checkProvInd[]" /> Music</td>
									<td><input type="checkbox" value="19" name="checkProvInd[]" /> Nonprofit</td>
									<td><input type="checkbox" value="20" name="checkProvInd[]" /> Pharmaceutical</td>
									<td><input type="checkbox" value="21" name="checkProvInd[]" /> Real Estate</td>
								</tr>
								<tr>
									<td><input type="checkbox" value="22" name="checkProvInd[]" /> Restaurant</td>
									<td><input type="checkbox" value="23" name="checkProvInd[]" /> Retail</td>
									<td><input type="checkbox" value="24" name="checkProvInd[]" /> Telecommunication</td>
									<td><input type="checkbox" value="25" name="checkProvInd[]" /> Toy</td>
									<td><input type="checkbox" value="26" name="checkProvInd[]" /> Wholesale Distribution</td>
								</tr>
								</table>
								</div>
								<script type = "text/javascript">
								var checked = false;
								function checkedAll5 () {
								checked == true? checked = false:checked = true;
								var els = document.getElementById("advInd").getElementsByTagName("input");
								var len = els.length;
								for (var i = 0; i < len; i++) {
								els[i].checked = checked;
								}
								}
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div>';
		?>
		<script type="text/javascript">
  			$('#outer-container, #inner-container').easytabs();
		</script>
<?php echo '<input type="submit" name="Submit" value="Submit">
		</div>
  	</form>
</div><!-- end #mainContent -->
</div><!-- end #container -->
';
?>