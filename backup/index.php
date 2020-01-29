<?php date_default_timezone_set('America/New_York');
$conn = mysqli_connect("localhost", "root", "", "feeds");

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="30">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body> 
 
<div class="container">
  <h2>Basic Panel</h2>
  <div class="panel panel-default">
    <div class="panel-body">A Basic Panel</div>
     <form method="post" id="activity_list_form" enctype="multipart/form-data">
        <div class="form-group">
          <label for="email">Select Excel File:</label>
           <input type="file" name="file" id="import_vendor_file3" required accept=".xls, .xlsx, .csv" /></p>
        </div>
  
         <button type="submit" name="import" value="Import" class="btn btn-default">Import</button>
      </form>
      <br>
 
   
      <a href="export.php" class="form-control">Export</a>
     
   
  <div class="row">    
    <div class="col-md-12">                                                                                     
     <div class="table-responsive"> 
       <form method="post">         
        <table class="table">
          <thead>
            <tr>
             
              <th>Supplier</th>
              <th>Delievery Time</th>
              <th>Block Below</th>
              <th>Block Above</th>
              <th>Include From Time</th>
              <th>Exclude From Time</th>
              <th>Include On day:<br> MON TUE WED THU FRI SAT SUN</th>
              <th>Include Without Image</th>
              <th>Delete</th>
            </tr>
          </thead>
        <tbody id="table_body">
      
     
       
      <?php 
      $query="SELECT * from feeds";

       $result = mysqli_query($conn,$query);
       while($row = mysqli_fetch_array($result)){
        $delievery_time[ $row['id']] = (isset( $row['delievery_time'])) ?  $row['delievery_time'] :'';
        $price[ $row['id']] = (isset( $row['price'])) ?  $row['price'] :'';
           
       }
      $query1="SELECT * from feeds group by supplier";

      $result1 = mysqli_query($conn,$query1);
      while($row1 = mysqli_fetch_array($result1)){
       if($row1 !='')
       $supplier[ $row1['id']] = (isset( $row1['supplier'])) ?  $row1['supplier'] :'';
         
      }
      // echo "<pre>";
      // print_r($supplier);
      $min =  min(array_filter($price,'strlen'));
      $max =  max(array_filter($price,'strlen'));
      $min = (int)round($min);
      $max = (int)round($max);
      $exclude_from_time =array('1'=>1,'2'=>2,'3'=>3,'4'=>'4','5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>'9','10'=>10,'11'=>'11','12'=>'12','13'=>13,'14'=>14,'15'=>15,'16'=>16,'17'=>'17','18'=>18,'19'=>19,'20'=>20,'21'=>21,'22'=>'22','23'=>'23','24'=>'24');
      $include_from_time =array('1'=>1,'2'=>2,'3'=>3,'4'=>'4','5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>'9','10'=>10,'11'=>'11','12'=>'12','13'=>13,'14'=>14,'15'=>15,'16'=>16,'17'=>'17','18'=>18,'19'=>19,'20'=>20,'21'=>21,'22'=>'22','23'=>'23','24'=>'24');
      ?>
   
    <tr id="TextBoxDiv1">
     <?php 

    echo "<td><select name='feeds[0][supplier]' class='form-control supplier'>";
     foreach ($supplier as $key => $value) {
      if($value !='')
        echo "<option value='" . $value ."'>" . $value ."</option>";
     }
    echo "</select></td>";


    echo "<td><select name='feeds[0][delievery_time]' class='form-control delievery_time'>";
     foreach ($delievery_time as $key => $value) {
      if($value !='')
       echo "<option value='" . $value ."'>" . $value ."</option>";
       # code...
     }
    echo "</select></td>";

    
    echo "<td><select name='feeds[0][block_below]' class='form-control block_below'>";
    $i = $min;
    for($i;$i<=$max;$i++){
      if($value !='')
       echo "<option value='" . $i ."'>" . $i ."</option>";
    }
    echo "</select></td>";


    echo "<td><select name='feeds[0][block_above]' class='form-control block_above'>";
 
    $i = $min;
    for($i;$i<=$max;$i++){
      if($value !='')
       echo "<option value='" . $i ."'>" . $i ."</option>";
    }
    echo "</select></td>";


    echo "<td><select name='feeds[0][include_from_time]' class='form-control include_from_time'>";
    foreach ($include_from_time as $key => $value) {
      echo "<option value='" . $key ."'>" . $value ."</option>";
    }
    echo "</select></td>";


    echo "<td><select name='feeds[0][exclude_from_time]' class='form-control exclude_from_time'>";
    foreach ($exclude_from_time as $key => $value) {
      if($value !='')
       echo "<option value='" . $key ."'>" . $value ."</option>";
    }
     echo "</select></td>";
   ?>
  <td>
    <input type="checkbox" name="feeds[0][include_on_monday]" class="include_on_day" value="Mon">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[0][include_on_tuesday]" class="include_on_day" value="Tue">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[0][include_on_wednesday]" class="include_on_day" value="Wed">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[0][include_on_thursday]" class="include_on_day" value="Thu">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[0][include_on_friday]" class="include_on_day" value="Fri">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[0][include_on_saturday]" class="include_on_day" value="Sat">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[0][include_on_sunday]" class="include_on_day" value="Sun">
<!--     <input type="checkbox" name="include_on_day[]" class="include_on_day" value="MON">&nbsp;&nbsp;
    <input type="checkbox" name="include_on_day[]" class="include_on_day" value="TUE">&nbsp;&nbsp;
    <input type="checkbox" name="include_on_day[]" class="include_on_day" value="WED">&nbsp;&nbsp;
    <input type="checkbox" name="include_on_day[]" class="include_on_day" value="THU">&nbsp;&nbsp;
    <input type="checkbox" name="include_on_day[]" class="include_on_day" value="FRI">&nbsp;&nbsp;
    <input type="checkbox" name="include_on_day[]" class="include_on_day" value="SAT">&nbsp;&nbsp;
    <input type="checkbox" name="include_on_day[]" class="include_on_day" value="SUN"> -->
  </td>

  <td><input type="checkbox" name="feeds[0][include_image]" class="include_image"></td> 
<td><a class="removeButton" data-counter="1" data-div="TextBoxDiv1"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
  </tr>
    <!-- </div></div> -->
  </tbody>

  </table>
 

  <input type="submit"  name="search" value="Save">
  </form>
   <button id="add_row">Add Row</button>
  </div>
  </div>
  </div>
<?php 


 	$searh_query = "SELECT * FROM new_feeds";
   	$result = mysqli_query($conn,$searh_query);
    $conditions = array();

	date_default_timezone_set('Europe/Dublin');

	$time_now = time();
      while($row = mysqli_fetch_array($result)){
         $suppliers= (isset( $row['supplier'])) ?  $row['supplier'] :'';
         $delievery_times = (isset( $row['delievery_time'])) ?  $row['delievery_time'] :'';
         $block_belows = (isset( $row['block_below'])) ?  $row['block_below'] :'';
         $block_aboves = (isset( $row['block_above'])) ?  $row['block_above'] :'';
         $include_from_times=(isset( $row['include_from_time'])) ?  $row['include_from_time'] :'';
         $exclude_from_times=(isset( $row['exclude_from_time'])) ?  $row['exclude_from_time'] :'';
         $include_on_monday = (isset( $row['include_on_monday'])) ?  $row['include_on_monday'] :'';
         $include_on_tuesday = (isset( $row['include_on_tuesday'])) ?  $row['include_on_tuesday'] :'';
         $include_on_wednesday = (isset( $row['include_on_wednesday'])) ?  $row['include_on_wednesday'] :'';
         $include_on_thursday = (isset( $row['include_on_thursday'])) ?  $row['include_on_thursday'] :'';
         $include_on_friday = (isset( $row['include_on_friday'])) ?  $row['include_on_friday'] :'';
         $include_on_saturday = (isset( $row['include_on_saturday'])) ?  $row['include_on_saturday'] :'';
         $include_on_sunday = (isset( $row['include_on_sunday'])) ?  $row['include_on_sunday'] :'';
         $current_time = date("H");
         $curre = DateTime::createFromFormat('H',  $current_time)->format("Y-m-d H:i:s");
         $start_time = DateTime::createFromFormat('H',  $include_from_times)->format("Y-m-d H:i:s");
         $end_time = DateTime::createFromFormat('H',  $exclude_from_times)->format("Y-m-d H:i:s");
         // if($end_time == '00:00:00'){
         // 	$end_time = date('Y-m-d H:i:s', strtotime($end_time . ' +1 day'));

         // }
         // echo '6'.$end_time;"<br>";
         // $date = date('2018-12-09');
              $date = date('Y-m-d');

      		$current_day =  date('D', strtotime($date));
 $conditions[] = "price BETWEEN ".$block_belows." AND ".$block_aboves." AND supplier='".$suppliers."' AND delievery_time='".$delievery_times."' AND ('".strtotime($current_day)."'='".strtotime($include_on_monday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_tuesday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_wednesday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_thursday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_friday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_saturday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_sunday)."' )AND 
         ".strtotime($curre)." BETWEEN ".strtotime($start_time)." AND ".strtotime($end_time);

        

           
      }

  if (count($conditions) > 0) {
        $where = " WHERE " . implode(' OR ', $conditions);
      }
      $sql = "SELECT a.supplier, a.delievery_time, COUNT(a.id) AS num
FROM(SELECT * FROM feeds ".$where.") a GROUP BY a.supplier";
      // $sql = $query;
      // if (count($conditions) > 0) {
      //   $sql .= " WHERE " . implode(' OR ', $conditions);
      // }
    // $query = "SELECT * FROM feeds";
    //   $sql = $query;
    
      // echo $sql;die;
          $result = mysqli_query($conn,$sql);
    $array = array();
      while($row = mysqli_fetch_array($result)){
            $array[] = array(
                  'num' =>  (isset($row['num']))? $row['num'] : '',
                  // 'sku' => (isset($row['sku'])) ? $row['sku'] :'',
                  // 'ean' =>  (isset($row['ean'])) ? $row['ean'] :'',
                  // 'price' => (isset($row['price'])) ? $row['price'] :'',
                  // 'url' => (isset($row['url'])) ? $row['url'] :'',
                  'delievery_time' => (isset($row['delievery_time'])) ? $row['delievery_time'] :'',
                  'supplier' => (isset($row['supplier'])) ? $row['supplier'] :'',
            );
           

           
      }
// echo "<Pre>";
// print_r($array);die;

?>
  <div class="">
  	<p> Current Feed Statistics</p>
  	<table class="table">
  		<th>Supplier</th>
	  	<th>Delievery Time</th>
	  	<th>Amount Of products</th>
	  	<tbody>

	  		<?php 
	  		foreach ($array as $key => $value) { ?>
<tr>
	
	<td><?php echo $value['supplier']?></td>
	<td><?php echo $value['delievery_time']?></td>
	<td><?php echo $value['num']?></td>
</tr>	
	  		
	  		<?php }


	  		?>
	  	
	</tbody>
	</table>


  </div>






</body>
</html>



  <?php 

    if(isset($_POST) && !empty($_POST['search'])){
      $value = $_POST;
      //   echo "<pre>";
      // print_r($value);die;
      foreach ($value['feeds'] as $key => $data) {
     
      //   echo "<pre>";
      // print_r($value);
      // die;
          // $suppl = (isset($data['supplier'][$key]))? $data['supplier'][$key] : '';
          // $delievet = (isset($data['delievery_time'][$key]))? $data['delievery_time'][$key] : '';
          // $block_belo = (isset($data['block_below'][$key]))? $data['block_below'][$key] : '';
          // $block_abov = (isset($data['block_above'][$key]))? $data['block_above'][$key] : '';
          // $include_from_ti =(isset($data['include_from_time'][$key]))?$data['include_from_time'][$key] :'';
          // $exclude_from_ti =(isset($data['exclude_from_time'][$key]))?$data['exclude_from_time'][$key] :'';
          // $include_on_monday =(isset($data['include_on_monday'][$key][0]))? $data['include_on_monday'][$key][0] : '';
          // $include_on_tuesday =(isset($data['include_on_tuesday'][$key][0]))? $data['include_on_tuesday'][$key][0] : '';
          // $include_on_wednesday =(isset($data['include_on_wednesday'][$key][0]))? $data['include_on_wednesday'][$key][0] : '';
          // $include_on_thursday =(isset($data['include_on_thursday'][$key][0]))? $data['include_on_thursday'][$key][0] : '';
          // $include_on_friday =(isset($data['include_on_friday'][$key][0]))? $data['include_on_friday'][$key][0] : '';
          // $include_on_saturday =(isset($data['include_on_saturday'][$key][0]))? $data['include_on_saturday'][$key][0] : '';
          // $include_on_sunday =(isset($data['include_on_sunday'][$key][0]))? $data['include_on_sunday'][$key][0] : '';
          

          // $include_ima = (isset($data['include_image'][$key]))? $data['include_image'][$key] : '';
               
    	 $suppl = (isset($data['supplier']))? $data['supplier'] : '';
          $delievet = (isset($data['delievery_time']))? $data['delievery_time'] : '';
          $block_belo = (isset($data['block_below']))? $data['block_below'] : '';
          $block_abov = (isset($data['block_above']))? $data['block_above'] : '';
          $include_from_ti =(isset($data['include_from_time']))?$data['include_from_time'] :'';
          $exclude_from_ti =(isset($data['exclude_from_time']))?$data['exclude_from_time'] :'';
          $include_on_monday =(isset($data['include_on_monday']))? $data['include_on_monday'] : '';
          $include_on_tuesday =(isset($data['include_on_tuesday']))? $data['include_on_tuesday'] : '';
          $include_on_wednesday =(isset($data['include_on_wednesday']))? $data['include_on_wednesday'] : '';
          $include_on_thursday =(isset($data['include_on_thursday']))? $data['include_on_thursday'] : '';
          $include_on_friday =(isset($data['include_on_friday']))? $data['include_on_friday'] : '';
          $include_on_saturday =(isset($data['include_on_saturday']))? $data['include_on_saturday'] : '';
          $include_on_sunday =(isset($data['include_on_sunday']))? $data['include_on_sunday'] : '';
          

          $include_ima = (isset($data['include_image']))? $data['include_image'] : '';
          $sql1 = "insert into new_feeds (supplier, delievery_time, block_below,block_above,include_from_time,exclude_from_time, include_on_monday,include_on_tuesday,include_on_wednesday,include_on_thursday,include_on_friday,include_on_saturday,include_on_sunday,include_image) values ('$suppl','$delievet', '$block_belo','$block_abov','$include_from_ti','$exclude_from_ti', '$include_on_monday','$include_on_tuesday','$include_on_wednesday','$include_on_thursday','$include_on_friday','$include_on_saturday','$include_on_sunday', '$include_ima' )";
                    
                // echo $sql1;die;
          if(mysqli_query($conn, $sql1)){
            // echo "Import successfully";
           
            // die;
          } else{
            echo "Error: ".mysqli_error($conn);
            die;
             
          }
        }
        // header("Refresh:0");
    }
    if(isset($_FILES["file"]["name"])){
      include('PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

       $path = $_FILES["file"]["tmp_name"];
       $object = PHPExcel_IOFactory::load($path);


       $data = array();
       foreach($object->getWorksheetIterator() as $worksheet){
          $highestRow = $worksheet->getHighestRow();
          $highestColumn = $worksheet->getHighestColumn();
          for($row=2; $row<=$highestRow; $row++)
          {
            $name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
            $sku = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $ean = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $price = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $url = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $ndelievery_time = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $nsupplier = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
            $data[] = array(
              'name'  => $name,
              'sku'  => $sku,
              'ean'  => $ean,
              'price'  => $price,
              'url'  => $url,
              'delievery_time'  => $ndelievery_time,
              'supplier'  => $nsupplier
          );
          // } 
         
          }
        }
        if(!empty($data)){
          // echo "<pre>";
          // print_r($data);
          // die;
          foreach ($data as $key => $value) {
            $name =mysqli_real_escape_string($conn,$value['name']);
            $sku =mysqli_real_escape_string($conn,$value['sku']);
            $ean =mysqli_real_escape_string($conn,$value['ean']);
            $price =mysqli_real_escape_string($conn,$value['price']);
            $url =mysqli_real_escape_string($conn,$value['url']);
            $im_delievery_time =mysqli_real_escape_string($conn,$value['delievery_time']);
            $im_supplier =mysqli_real_escape_string($conn,$value['supplier']);

            $name = (isset($name))? $name : '';
            $sku = (isset($sku)) ? $sku :'';
            $ean = (isset($ean)) ? $ean : '';
            $price = (isset($price)) ? $price : '';
            $url = (isset($url)) ? $url : '';
            $im_delievery_time = (isset($im_delievery_time)) ? $im_delievery_time : '';
            $im_supplier = (isset($im_supplier)) ? $im_supplier : '';

       
            // echo $name;
            // die;
            
            $sql = "insert into feeds (name, sku, ean,price,url,delievery_time, supplier) values 
            ('$name','$sku', '$ean','$price','$url','$delievery_time', '$supplier' )";
                
            
            if(mysqli_query($conn, $sql)){
              // echo "Import successfully";
             
              // die;
            } else{
              echo "Error: ".mysqli_error($conn);
              die;
               
            }
          }
          echo "imported";


      }else{
        echo "Error In importing ";
            die; 
      }
    }

?>
<script type="text/javascript">

$(document).ready(function(){

    var counter = 2;
     var check_count = 1;
    $("#add_row").click(function () {

        
  if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
  }   
   
  var newTextBoxDiv = $(document.createElement('tr'))
       .attr("id", 'TextBoxDiv' + counter);
       var supplier = <?php echo json_encode($supplier) ?>;
       var delievery_time = <?php echo json_encode($delievery_time) ?>;
       var min = <?php echo $min ?>;
       var max = <?php echo $max ?>;
       var include_from_time = <?php echo json_encode($include_from_time) ?>;
       var exclude_from_time = <?php echo json_encode($exclude_from_time) ?>;

console.log('hfgh');
console.log(supplier);
  var html = '<td>'+
  '<select name="feeds['+check_count+'][supplier]" id="supplier'+counter+'" class="form-control supplier">'+
      '<option>Select</option>'+
   '</select></td>'+
   '<td><select name="feeds['+check_count+'][delievery_time]" id="delievery_time'+counter+'" class="form-control delievery_time">'+
     '<option>Select</option>'+
     '</select></td>'+
    '<td><select name="feeds['+check_count+'][block_below]" id="block_below'+counter+'" class="form-control block_below">'+
     '<option>Select</option>'+
     '</select></td>'+
     '<td><select name="feeds['+check_count+'][block_above]" id="block_above'+counter+'" class="form-control block_above">'+
     '<option>Select</option>'+
     '</select></td>'+
     '<td><select name="feeds['+check_count+'][include_from_time]" id="include_from_time'+counter+'" class="form-control include_from_time">'+
     '<option>Select</option>'+
     '</select></td>'+
     '<td><select name="feeds['+check_count+'][exclude_from_time]" id="exclude_from_time'+counter+'" class="form-control exclude_from_time">'+
     '<option>Select</option>'+
     '</select></td>'+
     '<td>'+
     '<input type="checkbox" name="feeds['+check_count+'][include_on_monday]" class="include_on_day" id="include_on_day'+counter+'" value="Mon">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_tuesday]" class="include_on_day" id="include_on_day'+counter+'" value="Tue">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_wednesday]" class="include_on_day" id="include_on_day'+counter+'" value="Wed">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_thursday]" class="include_on_day" id="include_on_day'+counter+'" value="Thu">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_friday]" class="include_on_day" id="include_on_day'+counter+'" value="Fri">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_saturday]" class="include_on_day" id="include_on_day'+counter+'" value="Sat">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_sunday]" class="include_on_day" id="include_on_day'+counter+'" value="Sun">'+
  '</td>'+
   '<td><input type="checkbox" name="feeds['+check_count+'][include_image]" id="include_image'+counter+'" class="include_image"></td>'+
      '<td><a class="removeButton" data-counter="'+counter+'" data-div="TextBoxDiv' + counter+'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>'
    ; 
    newTextBoxDiv.after().html(html);

	  newTextBoxDiv.appendTo("#table_body");  
    $.each(supplier, function(i, obj) {
       // console.log(obj);
       if(obj !='')
        $(document).find('#TextBoxDiv' + counter).find('td').find('#supplier' + counter).append($('<option>',{value:obj, text:obj}));
    });
    $.each(delievery_time, function(i, obj) {
       // console.log(obj);
       if(obj !='')
        $(document).find('#TextBoxDiv' + counter).find('td').find('#delievery_time' + counter).append($('<option>',{value:obj, text:obj}));
    });
      
    i = min;
    for(i;i<=max;i++){
     
       // echo "<option value='" +$i +"'>"+i+"</option>";
        $(document).find('#TextBoxDiv' + counter).find('td').find('#block_below' + counter).append($('<option>',{value:i, text:i}));

    }
    j = min;
    for(j;j<=max;j++){
     
       // echo "<option value='" +$i +"'>"+i+"</option>";
        $(document).find('#TextBoxDiv' + counter).find('td').find('#block_above' + counter).append($('<option>',{value:j, text:j}));

    }

    $.each(include_from_time, function(i, obj) {
       // console.log(obj);
       if(obj !='')
        $(document).find('#TextBoxDiv' + counter).find('td').find('#include_from_time' + counter).append($('<option>',{value:i, text:obj}));
    });
    $.each(exclude_from_time, function(i, obj) {
       // console.log(obj);
       if(obj !='')
        $(document).find('#TextBoxDiv' + counter).find('td').find('#exclude_from_time' + counter).append($('<option>',{value:i, text:obj}));
    });


    // $(document).find('#TextBoxDiv2').find('td').find('#test2').val('ffgfff');
      // $(document).find('#TextBoxDiv2').find('td').find('#include_image2').prop("checked", true);


 
        
  	counter++;
  	check_count++;
    });
    $(document).on('click', '.removeButton', function(){


 
      console.log($(this));
      var counter_value = $(this).data('counter');
      var div = $(this).data('div');
      console.log(div);

        if(counter_value<1){
          alert("No more textbox to remove");
          return false;
        }   
        
        counter--;
      
        $("#TextBoxDiv" + counter_value).remove();
      
     });
    
  //    $("#getButtonValue").click(function () {
    
  // var msg = '';
  // for(i=1; i<counter; i++){
  //     msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
  // }
  //       alert(msg);
  //    });
  });
</script>
