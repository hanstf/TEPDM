<?php 
    session_start();
    require 'func.php';

    
$curPage = "matchTrx";    
if (isset($_POST['logout'])){
    session_destroy();
    header('location:index.php');
    exit();
}
if(isset($_SESSION['user'])==false || $_SESSION['user']==""){
    session_destroy();
    header('location:index.php');
    exit();
}
if (isset($_POST['submit'])== true){
    $eachNAPIC = getAllNAPIC($_SESSION['currentPBB']);
    $status = $_POST['status'];
    foreach ($eachNAPIC as $napic){
        $selection = 'us';
        if(isset($_POST[$napic[0]])){
            if ($_POST[$napic[0]] == "selected"){
                $selection = 'y';
            }else if ($_POST[$napic[0]] == "unselected"){
                $selection = 'n';    
            }
        }
        
        updateSelection($selection, $napic[0], $_SESSION['user'], $status, $_SESSION['currentPBB']);
    }
    
}  
?>

<?php 
 
$distinctPBB = getDistinctPBBId();

if(isset($distinctPBB[0]['pbb_id']) == false){
    $_SESSION['currentPBB'] = "empty";
}else{
    $_SESSION['currentPBB'] = $distinctPBB[0]['pbb_id'];
	 //updateTagging('U', $_SESSION['currentPBB'], $_SESSION['user']);
}

?>

<!DOCTYPE html>
<html>
<?php include 'common/header.php' ?>

   <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
            <h3>Match Transaction</h3>
        </div>
         <div class="col-md-1 col-md-push-5 margin-large-top">
             <h5><b>Status</b></h5>
         </div>
          <div class="col-md-2 col-md-push-5"><select class="form-control margin-large-top" name="status" id="statusSelection">
              <option></option>
              <option>Done</option>
              <option>KIV</option>
              <option>No Match</option>
            </select>
            </div>
      </div>
       
           
    </div>
   <div class="container-fluid scrollable-top margin-large-top">
      
        <div class="panel panel-default panel-back-darker">
  <div class="panel-body ">
		
         <?php 
        if($_SESSION['currentPBB']!="empty"){
        $pbbDetails = getPBBDetails($_SESSION['currentPBB']);
        $pbbFirstRow = $pbbDetails[0];
		
		$valuation_date = date_parse_from_format("dMY",$pbbFirstRow[4]);
		$build_up_type = $pbbFirstRow[12];
		$land_area_type = $pbbFirstRow[13];
		$build_up = $pbbFirstRow[8];
		$land_area = $pbbFirstRow[7];
		
		if ($build_up_type == 'M'){
			$build_up = $build_up * 10.764;
		}
		if ($build_up_type == 'A'){
			$build_up = $build_up * 43560;
		}
		if ($build_up_type == 'H'){
			$build_up = $build_up * 107639;
		}
		
		if ($land_area_type == 'M'){
			$land_area = $land_area * 10.764;
		}
		if ($land_area_type == 'A'){
			$land_area = $land_area * 43560;
		}
		if ($land_area_type == 'H'){
			$land_area = $land_area * 107639;
		}
		
        echo'<div class="row">
            
          <div class="col-md-12">
          <table class="table table-striped table-hover scroll">
               
             
                <thead>
                    <tr>
                        <th>Collateral ID</th>
                        <th>State</th>
                        <th>Town</th>
                        <th>Sector</th>
                        <th>Property Type</th>
                        <th>Valuation Date</th>
                        <th>Price (RM)</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>';
		   echo '<td>'.$pbbFirstRow[0].'</td>';  
           echo '<td>'.$pbbFirstRow[1].'</td>';  
           echo '<td>'.$pbbFirstRow[2].'</td>';  
           echo '<td>Residential</td>';  
           echo '<td>'.$pbbFirstRow[9].'</td>';  
           echo '<td>'.$valuation_date['day'] . "-" . $valuation_date['month'] ."-". $valuation_date['year'].'</td>';  
           echo '<td>'.$pbbFirstRow[11].'</td>';  
         echo '
                    </tr>
                   
                </tbody>
                <thead>
                   <tr>
                       <th>Scheme</th>
                       <th>Address</th>
                        <th>Project Name</th>
                        <th>Lot Type</th>
                        <th>land Area (sq ft)</th>
                        <th>Built-up Area (sq ft)</th>
                   </tr> 
                </thead>
                <tbody>
                    <tr>';
            echo '<td>'.$pbbFirstRow[10].'</td>';  
            echo '<td>'.$pbbFirstRow[5].'</td>';  
            echo '<td>'.$pbbFirstRow[6].'</td>';  
            echo '<td>---</td>';  
            echo '<td>'.$land_area.'</td>';  
            echo '<td>'.$build_up.'</td>';  
            echo '</tr>
                </tbody>
            </table>
            </div>
            </div>';
            
           }else{
           echo '<div class="alert alert-danger"><p>No Match PBB Result</p></div>';
            }
            ?>
            </div>
       </div>       
       
   </div>
    
    <div class="container-fluid">
        <hr class="divider">
    </div>    
 
    <div class="container-fluid scrollable ">
     

      <?php 
        if($_SESSION['currentPBB']!="empty"){
            $eachNAPIC = getDistinctNAPIC($_SESSION['currentPBB']);
            $step =0;
            foreach ($eachNAPIC as $napic){
			//print_r(date_parse_from_format('yyyy-mm-dd',$napicRow[11]);
            
            echo '<div class="panel  panel-primary">
     <div class="panel-body"><div class="row">
            <div class="col-md-1  ">
            <div class="form-group">
            <label for="selection">Selection</label>
            <br>
            <input type="hidden" name="'.$napic[0].'" value="unselected" />
            <input type="checkbox" id="chk'.$step.'" name="'.$napic[0].'" value="selected" onclick="chkcontrol('.$step.')">
            </div>
            </div>
            <div class="col-md-11">
            <table class="table table-striped table-hover  scroll">
                <thead>
                    <tr>
                        <th>NAPIC Id</th>
                        <th>State</th>
                        <th>Town</th>
                        <th>Sector</th>
                        <th>Property Type</th>
                        <th>Valuation Date</th>
                        
                        <th>Price (RM)</th>
                    </tr>
                </thead>
                <tbody>
                <tr>';
                        
                $napicDetails = getNAPICDetails($napic[0]);
                $napicRow = $napicDetails[0];
				$n_valuation_date = date_parse_from_format("Y-m-d",$napicRow[11]);    
                echo '<td>'.$napicRow[0].'</td>'; 
                echo '<td>'.$napicRow[1].'</td>';
                echo '<td>'.$napicRow[8].'</td>';
                echo '<td>'.$napicRow[10].'</td>';
                echo '<td>'.$napicRow[7].'</td>';
                echo '<td>'.$n_valuation_date['day']."-".$n_valuation_date['month']."-".$n_valuation_date['year'].'</td>';
                echo '<td>'.$napicRow[4].'</td>';
                echo'</tr></tbody>
                
                <thead>
                    <tr>
                        
                        <th>Scheme</th>
                        <th>Address</th>
                        <th>Land Area (sq ft)</th>
                        <th>Built up Area (sq ft)</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>';
                echo '<td>'.$napicRow[9].'</td>'; 
                echo '<td>'.$napicRow[5].'</td>';
                echo '<td>'.$napicRow[6]*10.764.'</td>';
                echo '<td>'.$napicRow[12]*10.764.'</td>';
                echo '<td>A1</td>';
                echo'</tbody>
                </table>
                </div>
                </div>
                </div>
                </div>';
                $step++;
                }
                }else{
            echo '<div class="alert alert-danger"><p>No Match NAPIC Result</p></div>';    
                }
                ?>        
                
         
   </div>
   <div class="container-fluid margin-large-top">
       <button class="btn btn-primary" type="submit" name="submit" id="btnsubmit">Submit</button>
   </div>
   
    </form>
    <script src="jquery/jquery-2.1.4.min.js"></script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script>
        function chkcontrol(j){
            
            var total=0;
            var num = $(':checkbox').length;
            var newOptions = {
                        "Option 1": "Done",
                        "Option 2": "KIV",
                        "Option 3": "No Match"
            };
            for(var i=0; i < num; i++){
                var total = $("input:checked").length;
                $('#btnsubmit').prop('disabled', false);
                //if(total > 5){
                //   alert("Please Check Maximum 5"); 
                //    $('#btnsubmit').prop('disabled', true);
                //    return false;
                //}
                if (total==0){
                   var newOptions = {
                        "Option 1": "KIV",
                        "Option 2": "No Match"
                   };
                }   
                }
            var $el = $("#statusSelection");
                    $el.empty();
                    $.each(newOptions, function(value,key) {
                        $el.append($("<option></option>")
                        .attr("value", key).text(key));
                    });    
            }    
           
        

    </script>
    <script>
    $('#btnsubmit').click(function(event){
            
        var total = $("input:checked").length;
        var status = $('#statusSelection option:selected').text();
       if(status == ""){
           event.preventDefault();
           alert("Status can not be empty"); 
       }
	   
	   if(total > 0 && status == "No Match"){
			event.preventDefault();
           alert("Status can not be No Match when there is a selection");  
		}
		
		if(total > 5 ){
			event.preventDefault();
           alert("Selection cannot be greater than 5");  
		}
		
       if(total == 0 && status == "Done"){
           event.preventDefault();
           alert("Status can not be done when there is no selection");  
       }
    });
    </script>
</body>
</html>
