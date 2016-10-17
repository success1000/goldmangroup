<?php
if ($row[13] == "Yes"){ $rowFB = "<img src=\"../../wp-content/uploads/sites/2/social/facebook.gif\">";};
if ($row[14] == "Yes"){ $rowTW = "<img src=\"../../wp-content/uploads/sites/2/social/twitter.gif\">";};
if ($row[15] == "Yes"){ $rowLI = "<img src=\"../../wp-content/uploads/sites/2/social/linkedin.gif\">";};

if ($row[18] == "0"){ $rowStage = "Select";}else
if ($row[18] == "1"){ $rowStage = "Noodling-(Thinking about an idea)";}else
if ($row[18] == "2"){ $rowStage = "Developing-(Building-Testing)";}else
if ($row[18] == "3"){ $rowStage = "Selling-(Initial Proof of Concept)";}else
if ($row[18] == "4"){ $rowStage = "Growing-(Annualized Sales $1.0m+)";}

if ($row[35] == "0") { $rowChannel = "Undecided";} else
if ($row[35] == "1") { $rowChannel = "Toys";} else
if ($row[35] == "2") { $rowChannel = "Energy";} else
if ($row[35] == "3") { $rowChannel = "Entertainment";} else
if ($row[35] == "4") { $rowChannel = "Fashion";} else
if ($row[35] == "5") { $rowChannel = "Food";} else
if ($row[35] == "6") { $rowChannel = "Healthcare";} else
if ($row[35] == "7") { $rowChannel = "Mobile Application";} 
?>
