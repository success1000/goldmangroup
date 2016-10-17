echo '<div id="headerContainer">
  <div id="header">
    <img src="images/logo.jpg">
    <!-- end #header -->
  </div>
</div>
<div id="container">
  <div id="mainContent">
    <h1>Enter Company Information Below</h1>
    <form method="post" action="confirm.php" name="contactEntry">
    <div id="contactInfo">
    <p><strong>Contact Information</strong></p>
        <div class="entry">Your First Name <span class="req">*</span><input type="text" name="firstName" class="entryField"/></div>
        <div class="entry">Your Last Name <span class="req">*</span><input type="text" name="lastName" class="entryField"/></div>
        <div class="entry">Your Email <span class="req">*</span><input type="text" name="contactEmail" class="entryField"/></div>
        <div class="clear"></div>
        <div class="entry">Primary Phone <span class="req">*</span ><input type="text" name="contactPhoneOne" class="entryField"/></div>
        <div class="entry">Alternate Phone <input type="text" name="contactPhoneTwo" class="entryField"/></div>
    </div>
    <div id="companyInfo">
    <p><strong>Company information</strong></p>
        <div class="clear"></div>
        <div class="entryLong">Company Name <span class="req">*</span><input type="text" name="companyName" class="entryFieldLong"/></div>
        <div class="entry">Street Address <span class="req">*</span><input type="text" name="companyStreet" class="entryField"/></div>
        <div class="entry2">Street Address Two <input type="text" name="companyStreetTwo" class="entryField"/></div>
        <div class="clear"></div>
        <div class="entry City">City <span class="req">*</span><input type="text" name="companyCity" class="entryField"/></div>
        <div class="entry">State <span class="req">*</span><select name="companyState">
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
        </select></div>
        <div class="entry">Zip Code <span class="req">*</span><input type="text" name="companyZip" /></div>
        <div class="clear"></div>
        <div class="entry">Website <input type="text" name="companyWeb" /></div>
        <div class="clear"></div>
        <div class="entry Social">Social Media You Use: <input type="checkbox" value="1" name="social1"> Facebook  <input type="checkbox" value="1" name="social2"> Twitter  <input type="checkbox" value="1" name="social3"> LinkedIn  </div>
        <div class="clear"></div>
        <div class="entryShort">Year Established <span class="req">*</span> 
        <select name="yearEstablished">';
            $years = range(date("Y"), date("Y", strtotime("now - 100 years"))); 
            foreach($years as $year){ 
            echo'<option value="'.$year.'">'.$year.'</option>'; 
            } 
        echo '</select>
        </div>
        <div class="entryShort">Are You Incorporated
        <select name="companyInc">
            <option id="yes" value="Yes">Yes</option>
            <option id="yes" value="No">No</option>
            <option id="na" value="N/A">N/A</option>
        </select>
        </div>
        <div class="entry">Number of Employees <input type="text" name="companyEmployees" /></div>
        <div class="entry">Industry <span class="req">*</span>
        <select name="companyIndustry">
        	<option id="1" value="1" >Healthcare</option>
            <option id="2" value="2" >Fashion</option>
            <option id="3" value="3" >Food</option>
            <option id="4" value="4" >Financial Services</option>
            <option id="5" value="5" >IT</option>
            <option id="6" value="6" >Miscellaneous</option>
        </select>
        </div>
        <div class="entryLong textBlock">What do you do? <textarea name="shortBio" class="textArea"></textarea></div>
      </div>
      <input type="submit" name="submitButton" id="submitButton" value="Submit" />
      </form>
	<!-- end #mainContent -->
  </div>
  </div>
  <div id="footer">
    <div id="footerContent">
    	<p>Copyright 2014.  Goldman Financial Group, Inc.  All Rights Reserved.</p>
    </div>
  <!-- end #footer -->
  </div>
<!-- end #container -->
</div>
';