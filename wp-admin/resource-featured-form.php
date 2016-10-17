<?php
require 'connect.php';

date_default_timezone_set("America/New_York");

//Insert Featured Resource
if (!empty($_POST)) {
	if(isset($_POST['submit1'])) {
	$res_type = "Funding Source";
	$comp_id = $_POST['funding'];
	$date = date_create();
	$date1 = date_format($date, 'Y-m-d H:i:s');
	
	$sql = "INSERT INTO wp_bp_resource_featured (resource_type, company_id, date) VALUES ('" . $res_type . "', '" . $comp_id . "', '" . $date1 . "')";
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
  		die('Could not enter data: ' . mysql_error());
	}
	echo "<div class=\"errorMess\" style=\"margin-bottom: 10px; border-top: 1px solid #333;border-bottom: 1px solid #333;padding: 5px 0; color: green; font-weight: bold;\">Entered Featured Funding Source successfully.</div>";
	}
	
	if(isset($_POST['submit2'])) {
	$res_type = "Incubator";
	$comp_id = $_POST['incubator'];
	$date = date_create();
	$date1 = date_format($date, 'Y-m-d H:i:s');
	
	$sql = "INSERT INTO wp_bp_resource_featured (resource_type, company_id, date) VALUES ('" . $res_type . "', '" . $comp_id . "', '" . $date1 . "')";
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
  		die('Could not enter data: ' . mysql_error());
	}
	echo "<div class=\"errorMess\" style=\"margin-bottom: 10px; border-top: 1px solid #333;border-bottom: 1px solid #333;padding: 5px 0; color: green; font-weight: bold;\">Entered Featured Incubator successfully.</div>";
	}
	
	if(isset($_POST['submit3'])) {
	$res_type = "Advisor";
	$comp_id = $_POST['advisor'];
	$date = date_create();
	$date1 = date_format($date, 'Y-m-d H:i:s');
	
	$sql = "INSERT INTO wp_bp_resource_featured (resource_type, company_id, date) VALUES ('" . $res_type . "', '" . $comp_id . "', '" . $date1 . "')";
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
  		die('Could not enter data: ' . mysql_error());
	}
	echo "<div class=\"errorMess\" style=\"margin-bottom: 10px; border-top: 1px solid #333;border-bottom: 1px solid #333;padding: 5px 0; color: green; font-weight: bold;\">Entered Featured Advisor successfully.</div>";
	}
	
	if(isset($_POST['submit4'])) {
	$res_type = "Company";
	$comp_id = $_POST['company'];
	$date = date_create();
	$date1 = date_format($date, 'Y-m-d H:i:s');
	
	$sql = "INSERT INTO wp_bp_resource_featured (resource_type, company_id, date) VALUES ('" . $res_type . "', '" . $comp_id . "', '" . $date1 . "')";
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
  		die('Could not enter data: ' . mysql_error());
	}
	echo "<div class=\"errorMess\" style=\"margin-bottom: 10px; border-top: 1px solid #333;border-bottom: 1px solid #333;padding: 5px 0; color: green; font-weight: bold;\">Entered Featured Company successfully.</div>";
	}
}

echo 'Here you can select your featured companies to be displayed on the home page.  <strong>Be sure to click "Submit" for each Company.</strong>';

echo '<form method="post" action="">';
//Company
echo '<hr><h3>Featured Company</h3><p>Select the featured Company.</p>';

$result4 = mysql_query("SELECT com_ID, com_Name FROM wp_bp_company WHERE com_memType = '1'");
if (!$result4) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
				
echo '<select id="company" name="company" style="width: 250px; margin-right: 10px;">';

while ($row4 = mysql_fetch_array($result4, MYSQL_ASSOC)) {
	echo '<option value="' . $row4['com_ID'] . '">' . $row4['com_Name'] . '</option>';
	
};

echo '</select><input type="submit" name="submit4" id="submit4" value="Submit Now!">';

//Funding Source
echo '<hr><h3>Featured Funding Source</h3><p>Select the featured Funding Source.</p>';

$result1 = mysql_query("SELECT com_ID, com_Name FROM wp_bp_company WHERE com_memType = '2' AND com_provType = 'Funding Source'");
if (!$result1) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
				
echo '<select id="funding" name="funding" style="width: 250px; margin-right: 10px;">';

while ($row1 = mysql_fetch_array($result1, MYSQL_ASSOC)) {
	echo '<option value="' . $row1['com_ID'] . '">' . $row1['com_Name'] . '</option>';
	
};

echo '</select><input type="submit" name="submit1" id="submit1" value="Submit Now!">';

//Incubator
echo '<hr><h3>Featured Incubator</h3><p>Select the featured Incubator.</p>';

$result2 = mysql_query("SELECT com_ID, com_Name FROM wp_bp_company WHERE com_memType = '2' AND com_provType = 'Incubator'");
if (!$result2) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
				
echo '<select id="incubator" name="incubator" style="width: 250px;margin-right: 10px;">';

while ($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)) {
	echo '<option value="' . $row2['com_ID'] . '">' . $row2['com_Name'] . '</option>';
	
};

echo '</select><input type="submit" name="submit2" id="submit2" value="Submit Now!">';

//Advisor
echo '<hr><h3>Featured Advisor</h3><p>Select the featured Advisor.</p>';

$result3 = mysql_query("SELECT com_ID, com_Name FROM wp_bp_company WHERE com_memType = '2' AND com_provType = 'Advisor'");
if (!$result3) {
	echo 'Could not run query: ' . mysql_error();
	exit;
}
				
echo '<select id="advisor" name="advisor" style="width: 250px; margin-right: 10px;"">';

while ($row3 = mysql_fetch_array($result3, MYSQL_ASSOC)) {
	echo '<option value="' . $row3['com_ID'] . '">' . $row3['com_Name'] . '</option>';
	
};

echo '</select><input type="submit" name="submit3" id="submit3" value="Submit Now!">';

echo '</form>';
?>