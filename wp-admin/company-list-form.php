<?php

echo "
<div id=\"lunch_1\" class=\"lunchbox\">
<form name=\"compSearch\" method=\"POST\" action=\"\">
<div style=\"float: left; margin-bottom: 10px;\">
Channel<br/>
<select name=\"SW_channel\" style=\"height: 31px;min-width: 242px;\">
<option value=\"All\">All</option>";
?>

<?php query_posts( 'post_type=channel&posts_per_page=10' ); ?>
<?php while ( have_posts() ) : the_post();  ?>

<?php echo '<option value="' .  get_the_title() .'">' . get_the_title() . '</option>';	
endwhile; 
wp_reset_query();
?>

<?php
echo "</select>
</div>
<div style=\"display:inline-block;float:left; max-width:300px; padding-left: 20px;  \">
Stage<br/>
<select name=\"SW_stage\" id=\"stage\" style=\"height: 31px; min-width: 242px; \">
<option value=\"All\">All</option>
<option value=\"1\">Noodling-(Thinking about an idea)</option>
<option value=\"2\">Developing-(Building-Testing)</option>
<option value=\"3\">Selling-(Initial Proof of Concept)</option>
<option value=\"4\">Growing-(Annualized Sales $1.0m+)</option>
</select> 
</div> 
<div style=\"display: inline-block;float:left; max-width:300px; padding-left: 20px; \">
Region<br />
<select name=\"SW_region\" style=\"height: 31px; min-width: 242px;\">
<option value=\"All\">US-All</option>
<option value=\"US-Northeast\">US-Northeast</option>
<option value=\"US-Southeast\">US-Southeast</option>
<option value=\"US-Midwest\">US-Midwest</option>
<option value=\"US-Northwest\">US-Northwest</option>
<option value=\"US-Southwest\">US-Southwest</option>
<option value=\"Canada\">Canada</option>
<option value=\"Mexico\">Mexico</option>
<option value=\"South America\">South America</option>
<option value=\"Europe\">Europe</option>
</select>
</div>
<div style=\"float: left; padding-left: 20px; padding-top: 5px;\">
<span style=\"float:right; padding-top: 15px; padding-bottom: 20px;\" ><input class=\"reg-button small\" name=\"SW_submit\" type=\"submit\" value=\"Search\"></span>
</div>
</form>
</div><div style=\"clear: both;\">";

require 'connect.php';

if (isset($_POST['SW_submit'])){
	$channelUse = $_POST['SW_channel'];
	$stageUse = $_POST['SW_stage'];
	$regionUse = $_POST['SW_region'];
	
	if ($channelUse == "All") {
		$channelPost = "All";
		$channelSend = "";
	}else {
		$channelPost = $channelUse;
		$channelSend = " AND channel = '" . $channelUse . "'";
	}
	
	if ($stageUse == "All") {
		$stagePost = "All";
		$stageSend = "";
	}else {
		$stagePost = $stageUse;
		$stageSend = " AND com_Stage = '" . $stageUse . "'";
	}
	
	if ($regionUse == "All") {
		$regionPost = "All";
		$regionSend = "";
	}else {
		$channelPost = $regionUse;
		$regionSend = " AND com_Geog = '" . $regionUse . "'";
	}
	
	echo "Results displayed are based on the following criteria:  <strong>Channel: <i>" . $channelPost . "</i>,&nbsp;&nbsp;Stage: <i>" . $stagePost . "</i>,&nbsp;&nbsp;Region: <i>" . $regionUse . "</i></strong>.";

	$result1 = mysql_query("SELECT * FROM wp_bp_company WHERE terms = '1'" . $channelSend . $stageSend . $regionSend . "");
	if (!$result1) {
    echo 'Could not run query: ' . mysql_error();
    exit;
	}
	
	$numCompany = mysql_num_rows($result1);
	
	if ($numCompany == 0) {
		echo "<div class=\"comList\" style=\"margin-top: 20px;\">No results match your search. <a href=\"http://www.startupstowatch.com/all-companies/company-listing/\">Search again.</a></div>";
	}
	
	while ($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)) {
	echo "<div class=\"comList\" style=\"margin-top: 20px;\">";
	echo "<div style=\"float: left; margin-right: 15px; width: 50px; height: 50px; background: #999999;\"></div>";
	echo "<div style=\"float: left; width: 510px; margin-right: 15px;\">";
	echo "<a href=\"../wp-admin/company-edit.php?id=" . $row1['com_ID'] . "\"><strong>" . $row1['com_Name'] . "</strong></a>";
	echo "<br/>" . substr($row1['com_ShortBio'], 0, 60) . "..." . "</div>";
	echo "<div style=\"float: left; width: 200px; text-align: right;\">" . $row1['com_City'] . ", " . $row1['com_State'] . "</div>";
	echo "<div style=\"clear: both; height: 0px;\"></div>";
	echo "</div>";
	}
} else {
	$result = mysql_query("SELECT * FROM wp_bp_company WHERE com_memType = '1' OR com_memType = '2'");
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo "<div class=\"comList\" style=\"margin-top: 20px;\">";
	echo "<div style=\"float: left; margin-right: 15px; width: 50px; height: 50px; background: #999999;\"></div>";
	echo "<div style=\"float: left; width: 510px; margin-right: 15px;\">";
	echo "<a href=\"../wp-admin/company-edit.php?id=" . $row['com_ID'] . "\"><strong>" . $row['com_Name'] . "</strong></a>";
	echo "<br/>" . substr($row['com_ShortBio'], 0, 60) . "..." . "</div>";
	echo "<div style=\"float: left; width: 200px; text-align: right;\">" . $row['com_City'] . ", " . $row['com_State'] . "</div>";
	echo "<div style=\"clear: both; height: 0px;\"></div>";
	echo "</div>";
	}
};

?>