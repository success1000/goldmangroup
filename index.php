<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
// define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
// require( dirname( __FILE__ ) . '/wp-blog-header.php' );

$conn = mysql_connect("localhost","root","root");
mysql_select_db('newcommon');

$resultFund = mysql_query("SELECT r.resource_type, r.company_id, r.date, c.com_ID, c.com_Name, c.com_City, c.com_State, c.Country FROM wp_bp_resource_featured as r LEFT JOIN wp_bp_company as c ON r.company_id = c.com_ID WHERE r.resource_type = 'Advisor' ORDER BY r.date DESC LIMIT 1");
if (!$resultFund) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$rowFund = mysql_fetch_row($resultFund);

echo '<img src="http://www.startupstowatch.com/wp-content/uploads/2014/03/incu1.png" style=" float: left; " />';
echo '<p style="max-width: 245px; margin-left: 78px; text-align: left; line-height: 20px; "><a href="all-companies/company-template/?id=' . $rowFund[1] . '">' . $rowFund[4] . '</a><br/>';
echo $rowFund[5] . ', ' . $rowFund[6] . '<br/>';
echo $rowFund[7];
echo '<br><br><a href="http://www.startupstowatch.com/resources/all-advisors" style="color:black; ">View All</a> </p>';


echo "___________________________________________________________";

$resultFund = mysql_query("SELECT r.resource_type, r.company_id, r.date, c.com_ID, c.com_Name, c.com_City, c.com_State, c.Country FROM wp_bp_resource_featured as r LEFT JOIN wp_bp_company as c ON r.company_id = c.com_ID WHERE r.resource_type = 'Funding Source' ORDER BY r.date DESC LIMIT 1");
if (!$resultFund) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$rowFund = mysql_fetch_row($resultFund);

echo '<img src="wp-content/uploads/sites/2/2014/03/incu1.png" style=" float: left; " />';
echo '<p style="max-width: 245px; margin-left: 78px; text-align: left; line-height: 20px; "><a href="all-companies/company-template/?id=' . $rowFund[1] . '">' . $rowFund[4] . '</a><br/>';
echo $rowFund[5] . ', ' . $rowFund[6] . '<br/>';
echo $rowFund[7];
echo '<br><br><a href="resources/all-funding-sources" style="color:black; ">View All</a> </p>';