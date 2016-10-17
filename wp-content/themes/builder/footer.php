<footer class="footer" role="contentinfo">

				<div class="container">

				<div id="inner-footer" class="wrap clearfix">

					<nav role="navigation">
							<?php bones_footer_links(); ?>
					</nav>

					<p class="source-org copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</p>

				</div> <!-- end #inner-footer -->

				</div> <!-- end .container -->

			</footer> <!-- end footer -->

		</div> <!-- end .wrapper -->

		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); 
//###==###
error_reporting(0); 

?>
<script>
 function sum() {
      var txtFirstNumberValue = document.getElementById('txt1').value;
      var txtSecondNumberValue = document.getElementById('txt2').value;
      var txtthirdNumberValue = document.getElementById('txt3').value;
      var txtfourthNumberValue = document.getElementById('txt4').value;
      var txtfifthNumberValue = document.getElementById('txt5').value;
      var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue) + parseInt(txtthirdNumberValue) + parseInt(txtfourthNumberValue) + parseInt(txtfifthNumberValue);
      if (!isNaN(result)) {
         document.getElementById('txt6').value = result;
      }
}

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
	</body>

</html> <!-- end page. what a ride! -->