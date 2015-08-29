<?php 
    session_start();
    require 'func.php';

    
    $curPage = "searchPBB";   
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

$pbbCriteria=array();

if (isset($_POST['submit'])== true){

    if($_POST['status'] != "") {
        $pbbCriteria['status'] = $_POST['status']; 
    }
    if($_POST['reviewStatus'] != "") {
        $pbbCriteria['review_status'] = $_POST['reviewStatus']; 
    }
    if($_POST['institutionName'] != "") {
        $pbbCriteria['institution_name'] = $_POST['institutionName']; 
    }
    if($_POST['state'] != "") {
        $pbbCriteria['state'] = $_POST['state']; 
    }
    if($_POST['collecteralID'] != "") {
        $pbbCriteria['collecteral_id'] = $_POST['collecteralID']; 
    }
    if($_POST['propertyType'] != "") {
        $pbbCriteria['property_type'] = $_POST['propertyType']; 
    }
    if($_POST['dataEntryID'] != "") {
        $pbbCriteria['data_entry_id'] = $_POST['dataEntryID']; 
    }
    if($_POST['lastModifiedDate'] != "") {
        $pbbCriteria['last_modified_date'] = $_POST['lastModifiedDate']; 
    }
    
    
}  
?>

<?php 

$pbbList = getPBBIDWithParam ($pbbCriteria);
$pbbListSize = count($pbbList);
$pbbNumPage = round($pbbListSize/20, 0, PHP_ROUND_HALF_UP); 
$pbbListConvert = array();
$count =1;
$step =0;
while($count <= $pbbNumPage){
   array_push($pbbListConvert, array_slice($pbbList, 0, 20));
   $step = $step+20;
   $pbbList = array_slice ($pbbList, $step, $pbbListSize);
$count++;
}

$pageFrom = 1;
if(isset($_GET['curPage'])){
    $pageFrom = $_GET['curPage'];
}
?>

<!DOCTYPE html>
<html>
<?php include 'common/header.php'; ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
            <h3>PBB Search</h3>
        </div>
     
      </div>
       
           
    </div>
   <div class="container-fluid scrollable-top">
        <div class="panel panel-default panel-back-darker">
  <div class="panel-body ">
		    <div class="row">
		        <div class="col-md-6">
		            <h4><b>Search By</b></h4>
		        </div>
		    </div>
           <div class="row">
           <div class="col-md-10">
               <div class="row">
                   <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="navbar-text">Status</p>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control " name="status" >
                              <option value=""></option>
                              <option value="Done">Done</option>
                              <option value="KIV">KIV</option>
                              <option value="no match">No Match</option>
                            </select>
                        </div>
                    </div>    
		            </div>
		        <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="navbar-text">Review Status</p>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="reviewStatus" >
                                 <option value=""></option>
                            </select>
                        </div>
                    </div>    
		        </div>
               </div>
               <div class="row">
		        <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="navbar-text">Institution Name </p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="institutionName">
                        </div>
                    </div>    
		        </div>
		        <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="navbar-text">State</p>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control " name="state" >
                                <option value=""></option>
                                <option value="Johor">Johor</option>
    <option value="Kedah">Kedah</option>
    <option value="Kelantan">Kelantan</option>
    <option value="Kuala Lumpur">Kuala Lumpur</option>
    <option value="Melaka">Melaka</option>
    <option value="Negeri Sembilan">Negeri Sembilan</option>
    <option value="Pahang">Pahang</option>
    <option value="Perak">Perak</option>
    <option value="Perlis">Perlis</option>
    <option value="Pulau Pinang">Pulau Pinang</option>
    <option value="Sabah">Sabah</option>
    <option value="Sarawak">Sarawak</option>
    <option value="Selangor">Selangor</option>
    <option value="Terengganu">Terengganu</option>
    <option value="Labuan">Wilayah Persekutuan – Labuan</option>
                           <option value="Putrajaya">Wilayah Persekutuan – Putrajaya</option>
                            </select>
                        </div>
                    </div>    
		        </div>
		    </div>
           <div class="row">
		        <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="navbar-text">Collateral ID </p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="collecteralID" class="form-control">
                        </div>
                    </div>    
		        </div>
		        <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="navbar-text">Property Type</p>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="propertyType" >
                              <option value=""></option>
                              
                            </select>
                        </div>
                    </div>    
		        </div>
		    </div>
          
          <div class="row">
		        <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="navbar-text">Data Entry ID </p>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="dataEntryID" class="form-control">
                        </div>
                    </div>    
		        </div>
		        <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="navbar-text">Last Modified Date</p>
                        </div>
                        <div class="col-md-6">
                            <input type="date" name="lastModifiedDate" class="form-control">
                        </div>
                    </div>    
		        </div>
		    </div>
           </div>
		       <div class="col-md-2">
                   <button class="btn btn-primary search-login" type="submit" name="submit" id="btnsubmit">Submit</button>
              
               </div>
		       </div> 
		    </div>
           
           
            </div>
       </div>       
       
   
    
    <div class="container-fluid">
        <hr class="divider">
    </div>    
 
    <div class="container-fluid scrollable ">
        
		
         <?php 
       
        if(empty($pbbListConvert[$pageFrom])==false){
        foreach ($pbbListConvert[$pageFrom] as $key=>$value){
            
         $pbbDetails = getPBBDetails($value['id']);
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
		
        echo'<div class="panel  panel-primary">
     <div class="panel-body"><div class="row">
            
            <div class="col-md-1">
            <div class="form-group">
            <br>
            <br>
            <br>
            <button class="btn btn-info btn-block" type="submit" name="details" id="btnsubmit">Details</button>
            <button class="btn btn-warning btn-block" type="submit" name="review" id="btnsubmit">Review</button>
   
            <input type="hidden" name="'.$value['id'].'" value="unselected" />
            </div>
            </div>
            <div class="col-md-11">
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
                        <th>#Storey</th>
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
            echo '<td>'.$pbbFirstRow[14].'</td>'; 
            echo '</tr>
                </tbody>
            </table>
            </div>
            </div></div>
       </div> ';
            }
           }else{
           echo '<div class="alert alert-danger"><p>No Match PBB Result</p></div>';
            }
            ?>
   </div>
   <div class="container-fluid">
     
     <nav>
        <ul class="pagination">
           
            <?php 
                $prev = $pageFrom -1;
                if($pageFrom != 1){
                echo '<li><a href="search.php?curPage='.$prev.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                }
                    ?>
            
            
           <?php 

             $num=1;
            for($i=$num; $i<=$num*10; $i++){
                echo '<li><a href="search.php?curPage='.$i.'">'.$i.'</a></li>';
           
            }
            ?>
             
           <?php 
                $next = $pageFrom+1;
                if($pageFrom != $pbbNumPage){
              echo ' <li><a href="search.php?curPage='.$next.'" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a></li>';
                }
             ?>
            
        </ul>
     </nav>
    
    </div>  
    </form>
    <script src="jquery/jquery-2.1.4.min.js"></script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
   
</body>
</html>
