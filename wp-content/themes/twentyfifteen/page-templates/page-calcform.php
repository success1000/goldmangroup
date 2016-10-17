<?php
/**
 * Template Name: Rating Form Page
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php require_once 'config.php' ?>
<?php
$done = array('success' => false, 'message' => 'Some technical issue. Please try later.');
$parents = $conn->query("SELECT * FROM data_information WHERE parent_id = 0 ORDER BY sort ASC");

$parents_rows = array();
while ($row = $parents->fetch_object()) {
    $parents_rows[] = $row;
}

if (isset($_POST['button1id'])) {
    $r = $conn->query("INSERT INTO entries (company, entrepreneur, year_established, status_product_to_market, other_comments, system_ip) VALUES ('{$_POST['company']}','{$_POST['entrepreneur']}','{$_POST['year_established']}','{$_POST['product_to_market']}','{$_POST['other_comments']}','{$_SERVER['REMOTE_ADDR']}')");
    if ($conn->affected_rows > 0) {
        $entry_id = $conn->insert_id;
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'id-') !== FALSE) {
                $t = explode('-', $key);
                $data_id = $t[1];
                if ($conn->query("INSERT INTO rating (data_id, entry_id, rating, system_ip) VALUES ('{$data_id}','{$entry_id}','{$value}','{$_SERVER['REMOTE_ADDR']}')")) {
                    $done = array('success' => true, 'message' => 'Data saved!');
                }
            }
        }
    }
}
?>
<div class="container">
			<div class="">
				<form class="form-horizontal">
				<fieldset>

				<!-- Form Name -->
				<legend>Evaluation Form</legend>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-3 control-label" for="company">Company</label>  
				  <div class="col-md-4">
				  <input id="company" value="<?php echo $data_info->company ?>" readonly="readonly" disabled="disabled" name="company" type="text" placeholder="" class="form-control input-md" required="">
					
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-3 control-label" for="entrepreneur">Entrepreneur</label>  
				  <div class="col-md-4">
				  <input id="entrepreneur" value="<?php echo $data_info->entrepreneur ?>" readonly="readonly" name="entrepreneur" type="text" placeholder="" class="form-control input-md" required="">
					
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-3 control-label" for="year_established">Year Established</label>  
				  <div class="col-md-4">
				  <input id="year_established" value="<?php echo $data_info->year_established ?>" readonly="readonly" name="year_established" type="text" placeholder="" class="form-control input-md" required="">
					
				  </div>
				</div>
				
				
				<!-- Multiple Radios (inline) -->
				<div class="form-group">
				  <label class="col-md-3 control-label" for="product_to_market">Status<br>Product to market</label>
				  <div class="col-md-4"> 
					<select name="product_to_market" disabled="disabled" readonly="readonly">
						<option>Select Option</option>
						<option <?php echo $data_info->status_product_to_market == 1 ? 'selected="selected"' : '' ?> value="Yes">Yes</option>
						<option <?php echo $data_info->status_product_to_market == 0 ? 'selected="selected"' : '' ?> value="No">No</option>
					</select>
				  </div>
				</div>				
				
				<hr>
				
				<div>
					<table class="table table-striped" style="width:55%">
						<thead>
							<tr>
								<th></th>
								<th class="text-center">Category</th>
								<th colspan="2" class="text-center">Weighted</th>
							</tr>
						</thead>
						<tbody>
							<?php if ( count($parents_rows) > 0 ): ?>
							<?php foreach($parents_rows as $row): ?>
							<?php $short_name = str_replace(" ","_",strtolower($row->title)); ?>
							<tr class="<?php echo $short_name ?>">
								<td><?php echo $row->title ?></td>
								<td width="65"></td>				
								<td class="hidden-text"></td>
								<td class="hidden-text"></td>
							</tr>
							<?php endforeach; ?>
							<?php endif; ?>							
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2">Combined Score</th>
								<th class="hidden-text" class="text-right"></th>
								<th class="text-right"></th>
							</tr>
						</tfoot>
					</table>
				</div>
				
				<hr>
				
				<div class="form-group">
				  <label class="col-md-3 control-label"></label>  
				  <div class="col-md-5">
						Rating (1-10)
				  </div>
				</div>											
				
				
<?php if ( count($parents_rows) > 0 ): ?>
<?php foreach($parents_rows as $row): ?>
<?php $short_name = str_replace(" ","_",strtolower($row->title)); ?>
				
<?php echo "<!-- {$row->title} -->"; ?>
<div class="rate<?php echo $row->group_rate > 0 && $row->data_value == 0 ? ' rate-group' : ''  ?>" data-weight="<?php echo $row->group_rate ?>">
	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-3 control-label" for="<?php echo $short_name ?>"><?php echo $row->title ?></label>  
	  <?php if ( $row->group_rate > 0 && $row->data_value > 0 ): ?>
	  <div class="col-md-2">
<?php $rData = false; ?>	  
<?php $data = $conn->query("SELECT * FROM rating WHERE data_id = {$row->id} AND entry_id = ".$id); ?>
	  <?php $rData = $data->fetch_object(); ?>	  
	  <select readonly="readonly" disabled="disabled" id="<?php echo $short_name ?>" name="<?php echo $short_name ?>" data-val="1" type="text" min="1" max="10" class="form-control input-md" required="">
		<option value=""></option>
		<?php for($i=1;$i<=10;$i++): ?>
		<option <?php echo $i == $rData->rating ? 'selected="selected"' : '' ?> value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php endfor; ?>
	  </select>
	  </div>
	  <?php endif; ?>
	</div>							
	<?php $children = $conn->query("SELECT * FROM data_information WHERE parent_id = {$row->id}"); ?>
	<?php
		while ( $child_row = $children->fetch_object()){
		$child_short_name =  str_replace(" ","_",strtolower($child_row->title));
?>
<div class="form-group">
  <label class="col-md-3 control-label" for="<?php echo $child_short_name ?>"><?php echo $child_row->title ?></label>  
  <div class="col-md-2">
  <?php $rData = false; ?>	  
<?php $data = $conn->query("SELECT * FROM rating WHERE data_id = {$child_row->id} AND entry_id = ".$id); ?>
	  <?php $rData = $data->fetch_object();  ?>	    
<?php if ($child_row->data_value > 0 ):?>
  <select readonly="readonly" disabled="disabled" id="<?php echo $child_short_name ?>" name="<?php echo $child_short_name ?>" data-val="<?php echo $child_row->data_value ?>" type="text" min="1" max="10" class="form-control input-md" required="">
	<option value=""></option>
	<?php for($i=1;$i<=10;$i++): ?>
	<option <?php echo $i == $rData->rating ? 'selected="selected"' : '' ?> value="<?php echo $i ?>"><?php echo $i ?></option>
	<?php endfor; ?>
  </select>  
<?php endif; ?>
  </div>
</div>	
<?php			
		}		
	?>
</div>				
<?php endforeach; ?>
<?php endif; ?>
				
				<hr>
				
				<!-- Textarea -->
				<div class="form-group">
				  <label class="col-md-3 control-label" for="other_comments">Other Comments:</label>
				  <div class="col-md-4">                     
					<textarea class="form-control" readonly="readonly" id="other_comments" name="other_comments"><?php echo $data_info->other_comments ?></textarea>
				  </div>
				</div>


				</fieldset>
				</form>
			</div>
		</div>
		
		<script>
			var calculateFlag = false;
			var	secondColumnSum = 100;
			var	thirdColumnSum = 0;
			$("document").ready(function(){
				$(".col-md-2 select").each(function(){
					if ( allDone() ){
						//ss = ( parseFloat($(this).val()) * parseFloat($(this).data("val")) ).toFixed(1);
						//$(this).data("weighted", ss);
						 letsCalculateCategoryPer();
						$("table tfoot th:eq(1)").text( secondColumnSum + "%" );
						$("table tfoot th:eq(2)").text( thirdColumnSum );
					}
				});			
			})
			
			function allDone(){
				aa = 0;
				totalNumbers = $(".col-md-2 select").length;
				$(".col-md-2 select").each(function(){
					if ( $(this).val().length > 0 && $(this).val() > 0 && $(this).val() <= 10 ){
						aa = aa + 1;
					}
				});
				return totalNumbers == aa;
				
			}
			
			function letsCalculateCategoryPer(){
				thirdColumnSum = 0;
				$(".rate").each(function(){
					if ( $(this).hasClass("rate-group") ){
						weightValue = 0;
						$(this).find(".col-md-2 select").each(function(){
							weightValue += ( parseFloat($(this).val()) * parseFloat($(this).data("val")) );						
						})
						
						categoryValue = ( (weightValue) ).toFixed(1);
						groupValue = parseFloat( $(this).data("weight") );
						weightedValue1 = (parseFloat( $(this).data('weight') ) * 100).toFixed(1);
						weightedValue2 = (categoryValue * groupValue).toFixed(1);
						thirdColumnSum = (parseFloat(thirdColumnSum) + parseFloat(weightedValue2)).toFixed(1);
						
						$("." + $(this).find("label").prop("for")).find("td:eq(1)").text( categoryValue );
						$("." + $(this).find("label").prop("for")).find("td:eq(2)").text( weightedValue1 + "%" );
						$("." + $(this).find("label").prop("for")).find("td:eq(3)").text( weightedValue2 );													
					}else{
					
						t = ".col-md-2 select";
						weightValue = ( parseFloat($(this).find(t).val()) * parseFloat($(this).find(t).data("val")) );
						categoryValue = ( (weightValue) ).toFixed(1);						
						groupValue = parseFloat( $(this).data("weight") );
						weightedValue1 = (parseFloat( $(this).data('weight') ) * 100).toFixed(1);
						weightedValue2 = (categoryValue * groupValue).toFixed(1);
						thirdColumnSum = (parseFloat(thirdColumnSum) +  parseFloat(weightedValue2)).toFixed(1);
					
						$("." + $(this).find("label").prop("for")).find("td:eq(1)").text( categoryValue );
						$("." + $(this).find("label").prop("for")).find("td:eq(2)").text( weightedValue1 + "%" );
						$("." + $(this).find("label").prop("for")).find("td:eq(3)").text( weightedValue2 );													
					}
				});
			}
		</script>
        <?php if ($_SERVER['REQUEST_METHOD'] == "POST"): ?>
            <script>

                letsCalculateCategoryPer();
                $("table tfoot th:eq(1)").text(secondColumnSum + "%");
                $("table tfoot th:eq(2)").text(thirdColumnSum);
            </script>
        <?php endif; ?>
    
        

    
		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>