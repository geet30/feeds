<?php 
date_default_timezone_set('Asia/Kolkata');
 // date_default_timezone_set('Europe/Berlin');
 echo $date= date('d-m-Y H:i:s') ;
 // die;
$conn = mysqli_connect("localhost", "root", "", "feeds");

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 ?>
   <?php 

    if(!empty($_POST))
    {
      $config = mysqli_query($conn, "UPDATE feeds_config SET `feed_name`='".trim($_POST['title_name'])."', `input_url`='".trim($_POST['input_file'])."', `created_date`=NOW() WHERE id=1");
    }

    if(isset($_POST) && !empty($_POST['search'])){

      $value = $_POST;

      // echo "<pre>";
      // print_r($value);
      // echo "</pre>";

      mysqli_query($conn,'TRUNCATE TABLE new_feeds');

      $p = 1;
 $config_id =0;
      foreach ($value['feeds'] as $key => $data) {
     
          $number = (isset($data['number']))? $data['number'] : '';
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
          // echo "<pre>";
          // print_r($suppl);die;
          // if(!empty($suppl)){
          if(!empty($suppl)  || !empty($delievet) || !empty($block_belo) || !empty($block_abov) || !empty($include_from_ti) || !empty($exclude_from_ti) || !empty($include_on_monday) || !empty($include_on_tuesday) || !empty($include_on_wednesday) || !empty($include_on_thursday) || !empty($include_on_friday) || !empty($include_on_saturday) || !empty($include_on_sunday) || !empty($include_ima) ){
            $sql1 = "insert into new_feeds (number, config_id, supplier, delievery_time, block_below,block_above,include_from_time,exclude_from_time, include_on_monday,include_on_tuesday,include_on_wednesday,include_on_thursday,include_on_friday,include_on_saturday,include_on_sunday,include_image) values ('".($p)."', '$config_id', '$suppl','$delievet', '$block_belo','$block_abov','$include_from_ti','$exclude_from_ti', '$include_on_monday','$include_on_tuesday','$include_on_wednesday','$include_on_thursday','$include_on_friday','$include_on_saturday','$include_on_sunday', '$include_ima' )";

                // echo $sql1;die;
              if(mysqli_query($conn, $sql1)){
                // echo "Import successfully";
               
                // die;
              } else{
                echo "Error: ".mysqli_error($conn);
                die;
              }
              $p++;
          }

          
        }
       
    }
    
    if(isset($_POST['import']) && !empty($_POST['import'])){

        mysqli_query($conn,'TRUNCATE TABLE feeds');
    
      $title_name =  $_POST['title_name'];
      // echo "<pre>";
      // print_r($_POST);
      // print_r($_POST['input_file']);
      $url = $_POST['input_file'];
      $data = array();

      $arr = array();
      if (($handle = fopen($url, "r")) !== FALSE)
      {
          while (($data = fgetcsv($handle, 2048, ";")) !== FALSE)
          {
             
              $arr[] = array(
                    'name'  => $data[0],
                    'sku'  => $data[1],
                    'ean'  => $data[2],
                    'price'  => $data[3],
                    'url'  => $data[4],
                    'delievery_time'  => $data[5],
                    'supplier'  => $data[6],
                    'image' => $data[8]
                );

            
          }
      }
      foreach ($arr as $key => $value) {

        if($key !=0){
          $data[] = $value;
          
        }

      }

      if(!empty($data)){
      foreach ($data as $key => $value) {
            $name =mysqli_real_escape_string($conn,$value['name']);
            $sku =mysqli_real_escape_string($conn,$value['sku']);
            $ean =mysqli_real_escape_string($conn,$value['ean']);
            $price =mysqli_real_escape_string($conn,$value['price']);
            $url =mysqli_real_escape_string($conn,$value['url']);
            $im_delievery_time =mysqli_real_escape_string($conn,$value['delievery_time']);
            $im_supplier =mysqli_real_escape_string($conn,$value['supplier']);
            $image =mysqli_real_escape_string($conn,$value['image']);

            $name = (isset($name))? $name : '';
            $sku = (isset($sku)) ? $sku :'';
            $ean = (isset($ean)) ? $ean : '';
            $price = (isset($price)) ? $price : '';
            $url = (isset($url)) ? $url : '';
            $im_delievery_time = (isset($im_delievery_time)) ? $im_delievery_time : '';
            $im_supplier = (isset($im_supplier)) ? $im_supplier : '';
            $image = (isset($image)) ? $image : '';

       
            // echo $name;
            // die;
            
            $sql = "insert into feeds (title_name,name, sku, ean,price,url,delievery_time, supplier, image, date) values 
            ('$title_name','$name','$sku', '$ean','$price','$url','$im_delievery_time', '$im_supplier', '$image', NOW() )";
                
            
            if(mysqli_query($conn, $sql)){
              // echo "Import successfully";
             
              // die;
            } else{
              echo "Error: ".mysqli_error($conn);
              die;
               
            }
        }
     }
     else{
        echo "Error In importing ";
            die; 
      }

  }


    // if(isset($_FILES["file"]["name"])){
    //   echo 'test';
    //   include('PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

    //    $path = $_FILES["file"]["tmp_name"];
    //    // PHPExcel_IOFactory::createReader('CSV'); 


    //   $object = PHPExcel_IOFactory::createReader('CSV');
    //   $object->setDelimiter(';');
    //    $object = PHPExcel_IOFactory::load($path);
      



       
    //    foreach($object->getWorksheetIterator() as $worksheet){
    //       $highestRow = $worksheet->getHighestRow();
    //       $highestColumn = $worksheet->getHighestColumn();
    //       for($row=2; $row<=$highestRow; $row++)
    //       {
    //         $name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
          
    //         $sku = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    //         $ean = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
    //         $price = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
    //         $url = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
    //         $ndelievery_time = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
    //         $nsupplier = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
    //         $data[] = array(
    //           'name'  => $name,
    //           'sku'  => $sku,
    //           'ean'  => $ean,
    //           'price'  => $price,
    //           'url'  => $url,
    //           'delievery_time'  => $ndelievery_time,
    //           'supplier'  => $nsupplier
    //       );
    //       // } 
         
    //       }
    //     }
    //     echo "<pre>";
    //     print_r($data);
    //     die;
    //     if(!empty($data)){
         
    //       foreach ($data as $key => $value) {
    //         $name =mysqli_real_escape_string($conn,$value['name']);
    //         $sku =mysqli_real_escape_string($conn,$value['sku']);
    //         $ean =mysqli_real_escape_string($conn,$value['ean']);
    //         $price =mysqli_real_escape_string($conn,$value['price']);
    //         $url =mysqli_real_escape_string($conn,$value['url']);
    //         $im_delievery_time =mysqli_real_escape_string($conn,$value['delievery_time']);
    //         $im_supplier =mysqli_real_escape_string($conn,$value['supplier']);

    //         $name = (isset($name))? $name : '';
    //         $sku = (isset($sku)) ? $sku :'';
    //         $ean = (isset($ean)) ? $ean : '';
    //         $price = (isset($price)) ? $price : '';
    //         $url = (isset($url)) ? $url : '';
    //         $im_delievery_time = (isset($im_delievery_time)) ? $im_delievery_time : '';
    //         $im_supplier = (isset($im_supplier)) ? $im_supplier : '';

       
    //         // echo $name;
    //         // die;
            
    //         $sql = "insert into feeds (title_name,name, sku, ean,price,url,delievery_time, supplier) values 
    //         ('$title_name','$name','$sku', '$ean','$price','$url','$delievery_time', '$supplier' )";
                
            
    //         if(mysqli_query($conn, $sql)){
    //           // echo "Import successfully";
             
    //           // die;
    //         } else{
    //           echo "Error: ".mysqli_error($conn);
    //           die;
               
    //         }
    //       }
    //       echo "imported";


    //   }else{
    //     echo "Error In importing ";
    //         die; 
    //   }
    // }
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Feeds</title>
  <meta charset="utf-8">
  <!-- <meta http-equiv="refresh" content="30"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/jquery-ui.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/dataqon.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>
  <script src="scripts/script.js"></script>
</head>
<body> 
<?php
  $config = mysqli_query($conn, 'SELECT * FROM `feeds_config` WHERE `id`=1');
  $config_data = mysqli_fetch_assoc($config);

?>
<div class="container panel_content_main">
  <h2>Feed Tool</h2>
  <div class="panel panel-default basic_panel">
    <!-- <div class="panel-body">A Basic Panel</div> -->
     <form method="post" id="activity_list_form" enctype="multipart/form-data">
        <div class="col-md-8">
          <label for="email">Name</label>
          <input type="text" name="title_name" class="form-control" id="title_name" value="<?php echo ($config_data['feed_name']!=''?$config_data['feed_name']:'')?>" required/></p>

        </div>
        <div class="col-md-8">
          <label for="email">Input</label>
          <input type="text" name="input_file" class="form-control" id="input_file" value="<?php echo ($config_data['input_url']!=''?$config_data['input_url']:'')?>"/></p>

        </div>
      <!--    <div class="col-md-12">
        <div class="form-group">
          <label for="email">Select Excel File:</label>
           <input type="file" name="file" id="import_vendor_file3" accept=".xls, .xlsx, .csv" /></p>
        </div>
      </div> -->
       <div class="col-md-12">
        <div class="imp_exp_btn">
         <button type="submit" name="import" value="Import" class="btn btn-default">Save feed to database</button>
          <a href="javascript:void(0)" class="form-control generate-feed">Generate feed</a>
        </div>
      </div>
      <div class="col-md-12 generated-feed"> 
       <!-- <b>Generated Feed:</b> <a href="export.php">//feeds.dataqon.nl/export/tweakers-nl-feed.csv</a>  -->
        <b>Generated Feed:</b> <a href="//feeds.dataqon.nl/export/tweakers-nl-feed.csv">//feeds.dataqon.nl/export/tweakers-nl-feed.csv</a>
      </div>
   
     
     
   
  <div class="row">    
    <div class="col-md-12">                                                                                     
     <div class="table-responsive">    
        <table class="table panel_table" style="overflow-x:auto;">
          <thead>
            <tr>
              <th>No</th>
              <th>Supplier</th>
              <th>Delivery Time</th>
              <th>Block Below <br> (Euro)</th>
              <th>Block Above <br> (Euro)</th>
              <th>Include From Time</th>
              <th>Exclude From Time</th>
              <th>Include on Day:<br> MON TUE WED THU FRI SAT SUN</th>
              <th>Include Without Image</th>
              <th>Delete</th>
            </tr>
          </thead>
        <tbody id="table_body">
      
     
       
      <?php 


      $query="SELECT * from feeds";

      $result = mysqli_query($conn,$query);
  
       while($row = mysqli_fetch_array($result)){
        $price[ $row['id']] = (isset( $row['price'])) ?  $row['price'] :'';
           
       }
      $query1="SELECT * from feeds group by supplier";

      $result1 = mysqli_query($conn,$query1);
      while($row1 = mysqli_fetch_array($result1)){
       if($row1 !='')
       $supplier[ $row1['id']] = (isset( $row1['supplier'])) ?  $row1['supplier'] :'';
         
         
      }

      $query2="SELECT * from feeds group by delievery_time";

      $result2 = mysqli_query($conn,$query2);
      while($row1 = mysqli_fetch_array($result2)){
       if($row1 !='')
       $delievery_time[ $row1['delievery_time']] = (isset( $row1['delievery_time'])) ?  $row1['delievery_time'] :'';
         
      } 
     
      $min =  min(array_filter($price,'strlen'));
      $max =  max(array_filter($price,'strlen'));
      $min = (int)round($min);
      $max = (int)round($max);
      $exclude_from_time =array('1'=>1,'2'=>2,'3'=>3,'4'=>'4','5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>'9','10'=>10,'11'=>'11','12'=>'12','13'=>13,'14'=>14,'15'=>15,'16'=>16,'17'=>'17','18'=>18,'19'=>19,'20'=>20,'21'=>21,'22'=>'22','23'=>'23','24'=>'24');
      $include_from_time =array('1'=>1,'2'=>2,'3'=>3,'4'=>'4','5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>'9','10'=>10,'11'=>'11','12'=>'12','13'=>13,'14'=>14,'15'=>15,'16'=>16,'17'=>'17','18'=>18,'19'=>19,'20'=>20,'21'=>21,'22'=>'22','23'=>'23','24'=>'24');

       $newquery="SELECT * from new_feeds ORDER BY number ASC";
      // $newquery="SELECT * from test";
       $newresult = mysqli_query($conn,$newquery);
       $rows = mysqli_num_rows($newresult);

      $a=1; 
      $fields_count = 0;
       if($rows >0){
        $i =0;
        while($newrow = mysqli_fetch_array($newresult)){ ?>
    <tr id="TextBoxDiv<?php echo $a;?>" class="draggable">
     <?php 
    echo "<td class='supplier_box_width'>".$newrow['number']."</td>";

    echo "<td class='supplier_box_width'><select name='feeds[$fields_count][supplier]' class='form-control supplier'><option value=''>Select</option>";
     foreach ($supplier as $key => $value) {
      if($value !=''){
        $selected='';
        if($newrow["supplier"] == $value)
           $selected ='selected="selected"';
          echo "<option value='" . $value ."' $selected>" . $value ."</option>";
        }
     }
    echo "</select></td>";


    echo "<td class='select_box_width'><select name='feeds[$fields_count][delievery_time]' class='form-control delievery_time'><option value=''>Select</option>";
     foreach ($delievery_time as $key => $value) {
  
        if($value !=''){
          $selected='';
          if($newrow["delievery_time"] == $value)
           $selected ='selected="selected"';
              echo "<option value='" . $value ."' $selected>" . $value ."</option>";
        }
      
     }
    echo "</select></td>";
?>
    <td><input type="number" class="form-control block_below" value="<?php echo (isset($newrow['block_below'])) ? $newrow['block_below']:0; ?>" name="feeds[<?php echo $fields_count;?>][block_below]"></td>
   <td><input type="number"  class="form-control block_above" value="<?php echo (isset($newrow['block_above'])) ? $newrow['block_above']:0;  ?>" name="feeds[<?php echo $fields_count;?>][block_above]"></td>
    <?php 
    echo "<td class='time_width_div'><select name='feeds[$fields_count][include_from_time]' class='form-control include_from_time'><option value=''>Select</option>";
    foreach ($include_from_time as $key => $value) {
      if($value !=''){
         $selected='';
        if($newrow["include_from_time"] == $value)
          $selected ='selected="selected"';
        echo "<option value='" . $key ."' $selected>" . $value .":00</option>";
      }
    }
    echo "</select></td>";


    echo "<td class='time_width_div'><select name='feeds[$fields_count][exclude_from_time]' class='form-control exclude_from_time'><option value=''>Select</option>";
    foreach ($exclude_from_time as $key => $value) {
      if($value !=''){
         $selected='';
        if($newrow["exclude_from_time"] == $value)
          $selected ='selected="selected"';
        echo "<option value='" . $key ."' $selected>" . $value .":00</option>";
      }
    }
     echo "</select></td>";
   ?>
  <td>
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_monday]" <?php echo ($newrow['include_on_monday']=="Mon" ? 'checked' : '');?> class="include_on_day day_checkbox" value="Mon">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_tuesday]" <?php echo ($newrow['include_on_tuesday']=="Tue" ? 'checked' : '');?> class="include_on_day day_checkbox_tue" value="Tue">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_wednesday]" <?php echo ($newrow['include_on_wednesday'] =="Wed"? 'checked' :'');?> class="include_on_day day_checkbox_wed" value="Wed">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_thursday]" <?php echo ($newrow['include_on_thursday'] =="Thu"? 'checked' :'');?>  class="include_on_day day_checkbox_thu" value="Thu">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_friday]" <?php echo ($newrow['include_on_friday'] =="Fri"? 'checked' :'');?> class="include_on_day day_checkbox_fri" value="Fri">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_saturday]" <?php echo ($newrow['include_on_saturday'] =="Sat"? 'checked' :'');?>  class="include_on_day day_checkbox_sat" value="Sat">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_sunday]" <?php echo ($newrow['include_on_sunday'] =="Sun"? 'checked' :'');?>  class="include_on_day day_checkbox_sun" value="Sun">
  </td>

  <td style="text-align: center;"><input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_image]" class="include_image" <?php echo ($newrow['include_image'] =="yes"? 'checked' :'');?> value="yes"></td> 
  <td><a class="removeButton"  data-counter="<?php echo $a;?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
  </tr>

      <?php   $a++; $fields_count++; }
       } else{
        $i =0;

        ?>
    <tr id="TextBoxDiv<?php echo $a;?>">
     <?php 

    echo "<td class='supplier_box_width'><select name='feeds[$fields_count][supplier]' class='form-control supplier'><option value=''>Select</option>";
     foreach ($supplier as $key => $value) {
      if($value !='')
        echo "<option value='" . $value ."'>" . $value ."</option>";
     }
    echo "</select></td>";


    echo "<td class='select_box_width'><select name='feeds[$fields_count][delievery_time]' class='form-control delievery_time'><option value=''>Select</option>";
     foreach ($delievery_time as $key => $value) {
      if($value !='')
       echo "<option value='" . $value ."'>" . $value ."</option>";
       # code...
     }
    echo "</select></td>";

    ?>
    <td><input type="number" class="form-control block_below" name="feeds[<?php echo $fields_count;?>][block_below]"></td>
   <td><input type="number"  class="form-control block_above" name="feeds[<?php echo $fields_count;?>][block_above]"></td>
    <?php 

    echo "<td class='time_width_div'><select name='feeds[$fields_count][include_from_time]' class='form-control include_from_time'><option value=''>Select</option>";
    foreach ($include_from_time as $key => $value) {
      echo "<option value='" . $key ."'>" . $value ."</option>";
    }
    echo "</select></td>";


    echo "<td class='time_width_div'><select name='feeds[$fields_count][exclude_from_time]' class='form-control exclude_from_time'><option value=''>Select</option>";
    foreach ($exclude_from_time as $key => $value) {
      if($value !='')
       echo "<option value='" . $key ."'>" . $value ."</option>";
    }
     echo "</select></td>";
   ?>
  <td>
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_monday]" class="include_on_day day_checkbox" value="Mon">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_tuesday]" class="include_on_day day_checkbox_tue" value="Tue">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_wednesday]" class="include_on_day day_checkbox_wed" value="Wed">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_thursday]" class="include_on_day day_checkbox_thu" value="Thu">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_friday]" class="include_on_day day_checkbox_fri" value="Fri">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_saturday]" class="include_on_day day_checkbox_sat" value="Sat">&nbsp;&nbsp;
    <input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_on_sunday]" class="include_on_day day_checkbox_sun" value="Sun">
  </td>

  <td style="text-align:center;"><input type="checkbox" name="feeds[<?php echo $fields_count;?>][include_image]" class="include_image" value="yes"></td> 
  <td><a class="removeButton"  data-counter="<?php echo $a;?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
  </tr>
  <?php } 
      ?>
   

  </tbody>

  </table>


  <input type="submit"  name="search" value="Save" class="submitbtn">
  </form>
   <button id="add_row" type="button">Add Row</button>
  </div>
  </div>
  </div>
<?php 


  $searh_query = "SELECT * FROM new_feeds";
    $result = mysqli_query($conn,$searh_query);
    $conditions = "";
    $condi ="";


  $time_now = time();
  $m= 1;
      while($row = mysqli_fetch_array($result)){
        $arr = array();

         $suppliers= (isset( $row['supplier'])) ?  $row['supplier'] :'';
         $delievery_times = (isset( $row['delievery_time'])) ?  $row['delievery_time'] :'';
         $block_belows = (isset( $row['block_below'])) ?  $row['block_below'] :'';
         $block_aboves = (isset( $row['block_above'])) ?  $row['block_above'] :'';
         $include_from_times=(isset( $row['include_from_time'])) ?  $row['include_from_time'] :'';
         $exclude_from_times=(isset( $row['exclude_from_time'])) ?  $row['exclude_from_time'] :'';
          $include_on_monday = (isset( $row['include_on_monday'])) ?  $row['include_on_monday'] : '';
         $include_on_tuesday = (isset( $row['include_on_tuesday'])) ?  $row['include_on_tuesday'] : 0;
         $include_on_wednesday = (isset( $row['include_on_wednesday'])) ?  $row['include_on_wednesday'] : 0;
         $include_on_thursday = (isset( $row['include_on_thursday'])) ?  $row['include_on_thursday'] :0;
         $include_on_friday = (isset( $row['include_on_friday'])) ?  $row['include_on_friday'] :0;
         $include_on_saturday = (isset( $row['include_on_saturday'])) ?  $row['include_on_saturday'] :0;
         $include_on_sunday = (isset( $row['include_on_sunday'])) ?  $row['include_on_sunday'] :0;
         $current_time = date("H");
        
      
      
         if(!empty($include_from_times)){
          $start_time = DateTime::createFromFormat('H',  $include_from_times)->format("Y-m-d H:i:s");
         }else{
            $start_time = DateTime::createFromFormat('H', $include_from_time[1])->format("Y-m-d H:i:s");
         }
         $curre = DateTime::createFromFormat('H',  $current_time)->format("Y-m-d H:i:s");
         if(!empty($exclude_from_times)){
         $end_time = DateTime::createFromFormat('H',  $exclude_from_times)->format("Y-m-d H:i:s");
         }else{
          $end_time = DateTime::createFromFormat('H',  $exclude_from_time[24])->format("Y-m-d H:i:s");
         }


         $date = date('Y-m-d');
         $current_day =  date('D', strtotime($date));


        //  $block_belows = $min;
        //  if(!empty($block_belows))
        //   $block_bv = $block_belows;

        // $block_av = $max;
        // if(!empty($block_aboves))
        //   $block_av = $block_aboves;
          if($m >1)
           $conditions .= " OR ";

          // $conditions .= " price BETWEEN ".$block_bv." AND ".$block_av;
          if(!empty($block_belows))
            $conditions .= " price >= ".$block_belows;
          else
             $conditions .= " price >= ".$min;
          if(!empty($block_aboves))
            $conditions .= " AND price <= ".$block_aboves;
          else
            $conditions .= " AND price <= ".$max;


          if(!empty($delievery_times))
             $conditions .= " AND delievery_time ='".$delievery_times."'";
          if(!empty($suppliers))
             $conditions .= " AND supplier ='".$suppliers."'";
           
          $conditions .=   " AND ".strtotime($curre)." >= ".strtotime($start_time);
          $conditions .=   " AND ".strtotime($curre)." < ".strtotime($end_time);
           // $conditions .=   " AND ".strtotime($curre)." BETWEEN ".strtotime($start_time)." AND ".strtotime($end_time);
//  $conditions .= " AND (";
//           if(!empty($include_on_monday))
//             $conditions .= strtotime($current_day)."=".strtotime($include_on_monday)." OR ";
//            if(!empty($include_on_tuesday))
//             $conditions .= strtotime($current_day)."=".strtotime($include_on_tuesday)." OR ";
//             if(!empty($include_on_wednesday))
//             $conditions .= strtotime($current_day)."=".strtotime($include_on_wednesday)." OR ";
//           if(!empty($include_on_thursday))
//             $conditions .= strtotime($current_day)."=".strtotime($include_on_thursday)." OR ";
//             if(!empty($include_on_friday))
//             $conditions .= strtotime($current_day)."=".strtotime($include_on_friday)." OR ";
//           if(!empty($include_on_saturday))
//             $conditions .= strtotime($current_day)."=".strtotime($include_on_saturday)." OR ";
//            if(!empty($include_on_sunday))
//             $conditions .= strtotime($current_day)."=".strtotime($include_on_sunday);
// $conditions.= " 1=1";

//  $conditions .= " )";
 // if(!$include_on_monday && !$include_on_tuesday && !$include_on_wednesday && !$include_on_thursday && !$include_on_friday && !$include_on_saturday && !$include_on_sunday)
            // $arr[] =  " AND ( )";
          // else{
           $mndy = strtotime($current_day).'='.time(); $tue = strtotime($current_day).'='.time(); $wed =strtotime($current_day).'='.time(); $thu = strtotime($current_day).'='.time(); $fri = strtotime($current_day).'='.time(); $sat = strtotime($current_day).'='.time();  $sun = strtotime($current_day).'='.time();

            if(!empty($include_on_monday))
            $mndy = strtotime($current_day)."=".strtotime($include_on_monday);
         
           
           if(!empty($include_on_tuesday))
            $tue = strtotime($current_day)."=".strtotime($include_on_tuesday);
          
            
            if(!empty($include_on_wednesday))
            $wed = strtotime($current_day)."=".strtotime($include_on_wednesday);
          
           
           if(!empty($include_on_thursday))
            $thu = strtotime($current_day)."=".strtotime($include_on_thursday);
          
           
            if(!empty($include_on_friday))
            $fri = strtotime($current_day)."=".strtotime($include_on_friday);
        
           
           if(!empty($include_on_saturday))
            $sat = strtotime($current_day)."=".strtotime($include_on_saturday);
      
           
           if(!empty($include_on_sunday))
            $sun = strtotime($current_day)."=".strtotime($include_on_sunday);
        
         
        
            $arr[] = " AND (".$mndy."  OR ".$tue." OR ".$wed." OR ".$thu." OR ".$fri." OR ".$sat."  OR ".$sun.")";
          // }

           $conditions .= implode(' OR ', $arr);

           $m++;

         //   $conditions[] = "price BETWEEN ".$block_belows." AND ".$block_aboves." AND supplier='".$suppliers."' AND delievery_time='".$delievery_times."' AND ('".strtotime($current_day)."'='".strtotime($include_on_monday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_tuesday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_wednesday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_thursday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_friday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_saturday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_sunday)."' )AND 
         // ".strtotime($curre)." BETWEEN ".strtotime($start_time)." AND ".strtotime($end_time);

        

           
      }
      // echo $conditions;die;

  
    // if (count($conditions) > 0) {
        if ($conditions) {
        // $where = " WHERE " . implode(' OR ', $conditions);
          $where = " WHERE " .$conditions;
        $sql = "SELECT a.supplier, a.delievery_time, COUNT(a.id) AS num
        FROM(SELECT * FROM feeds ".$where.") a GROUP BY a.supplier,a.delievery_time";
      // $sql = $query;
      // if (count($conditions) > 0) {
      //   $sql .= " WHERE " . implode(' OR ', $conditions);
      // }
    // $query = "SELECT * FROM feeds";
    //   $sql = $query;
    
      // echo $sql;die;
        $result = mysqli_query($conn,$sql);
        $array = array();
        if(!empty($result)){
          while($row = mysqli_fetch_array($result)){
                $array[] = array(
                      'num' =>  (isset($row['num']))? $row['num'] : '',
                      'delievery_time' => (isset($row['delievery_time'])) ? $row['delievery_time'] :'',
                      'supplier' => (isset($row['supplier'])) ? $row['supplier'] :'',
                );
          }
        }
          
        }


// echo "<Pre>";
// print_r($array);die;

?>
  <div class="current_feed">
    <p> Current Feed Statistics</p>
    <table class="table">
      <thead>
      <th>Supplier</th>
      <th>Delivery Time</th>
      <th>Amount of products</th>
      </thead>
      <tbody>

        <?php
        $total_count = 0;
        if(!empty($array)){
          foreach ($array as $key => $value) { 
            $total_count += $value['num'];
            ?>
            <tr>
              <td><?php echo $value['supplier']?></td>
              <td><?php echo $value['delievery_time']?></td>
              <td><?php echo $value['num']?></td>
            </tr> 
          
          <?php }
        }else{?>
          <tr>
            <td colspan="3">No Current Feeds</td>
          </tr>
         <?php }

        ?>
        <tr>
          <td colspan="3"><p>Total Products: <?php echo $total_count;?></p></td>
        </tr>
    </tbody>
    </table>

  </div>






</body>
</html>




<script type="text/javascript">

$(document).ready(function(){
   // var $ = jQuery.noConflict();
  // var newcount = <?php echo $a;?>;
  // var fiel_coun = <?php echo $fields_count;?>;
 



     var counter = <?php echo $a +1;?>;
     var check_count = <?php echo $fields_count+1;?>;
    // var counter = newcount;
    //  var check_count = fiel_coun;
     var supplier = <?php echo json_encode($supplier) ?>;
  

     var delievery_time= <?php echo json_encode($delievery_time) ?>;
     // var output = jQuery.parseJSON(supplier);
var temp = [];

$.each(supplier, function(key, value) {
    // temp.push({v:value, k: key});
    temp.push({v:value});
});
temp.sort(function(a,b){
   if(a.v > b.v){ return 1}
    if(a.v < b.v){ return -1}
      return 0;
});

 
// function SortByName(a, b){
//   var aName = a.name.toLowerCase();
//   var bName = b.name.toLowerCase(); 
//   return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
// }
console.log(supplier);
console.log(temp);
// supplier.sort();

// supplier.sort(SortByName);

//     function highest(delievery_t)
// { 
//   return delievery_t.sort(function(a,b)
//   { 
//     return b - a; 
//   }); 
// }
// delievery_time = highest(delievery_t); 


     var min = <?php echo $min ?>;
     var max = <?php echo $max ?>;
     var include_from_time = <?php echo json_encode($include_from_time) ?>;
     var exclude_from_time = <?php echo json_encode($exclude_from_time) ?>;
    $("#add_row").click(function () {

      console.log(counter);
      // if(counter>10){
      //     alert("Only 10 textboxes allow");
      //     return false;
      // }   
     
      var newTextBoxDiv = $(document.createElement('tr'))
           .attr("id", 'TextBoxDiv' + counter);



  var html = '<td></td><td class="supplier_box_width">'+
  '<select name="feeds['+check_count+'][supplier]" id="supplier'+counter+'" class="form-control supplier">'+
      '<option value="">Select</option>'+
   '</select></td>'+
   '<td class="select_box_width"><select name="feeds['+check_count+'][delievery_time]" id="delievery_time'+counter+'" class="form-control delievery_time">'+
     '<option value="">Select</option>'+
     '</select></td>'+
      '<td><input type="number" id="block_below'+counter+'" class="form-control block_above" name="feeds['+check_count+'][block_below]"></td>'+
      '<td><input type="number" id="block_above'+counter+'" class="form-control block_above" name="feeds['+check_count+'][block_above]"></td>'+
    // '<td><select name="feeds['+check_count+'][block_below]" id="block_below'+counter+'" class="form-control block_below">'+
    //  '<option value="">Select</option>'+
    //  '</select></td>'+
    //  '<td><select name="feeds['+check_count+'][block_above]" id="block_above'+counter+'" class="form-control block_above">'+
    //  '<option value="">Select</option>'+
    //  '</select></td>'+
     '<td class="time_width_div"><select name="feeds['+check_count+'][include_from_time]" id="include_from_time'+counter+'" class="form-control include_from_time">'+
     '<option value="">Select</option>'+
     '</select></td>'+
     '<td class="time_width_div"><select name="feeds['+check_count+'][exclude_from_time]" id="exclude_from_time'+counter+'" class="form-control exclude_from_time">'+
     '<option value="">Select</option>'+
     '</select></td>'+
     '<td>'+
     '<input type="checkbox" name="feeds['+check_count+'][include_on_monday]" class="include_on_day day_checkbox" id="include_on_day'+counter+'" value="Mon">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_tuesday]" class="include_on_day day_checkbox_tue" id="include_on_day'+counter+'" value="Tue">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_wednesday]" class="include_on_day day_checkbox_wed" id="include_on_day'+counter+'" value="Wed">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_thursday]" class="include_on_day day_checkbox_thu" id="include_on_day'+counter+'" value="Thu">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_friday]" class="include_on_day day_checkbox_fri" id="include_on_day'+counter+'" value="Fri">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_saturday]" class="include_on_day day_checkbox_sat" id="include_on_day'+counter+'" value="Sat">&nbsp;&nbsp;&nbsp'+
    '<input type="checkbox" name="feeds['+check_count+'][include_on_sunday]" class="include_on_day day_checkbox_sun" id="include_on_day'+counter+'" value="Sun">'+
  '</td>'+
   '<td style="text-align:center;"><input type="checkbox" name="feeds['+check_count+'][include_image]" id="include_image'+counter+'" class="include_image" value="yes"></td>'+
      '<td><a class="removeButton"  data-counter="'+counter+'"><i class="fa fa-trash" aria-hidden="true"></i></a></td>'
    ; 
    newTextBoxDiv.after().html(html);

    newTextBoxDiv.appendTo("#table_body");  
    $.each(temp, function(i, obj) {
       console.log(obj.v);
       if(obj.v !='')
        $(document).find('#TextBoxDiv' + counter).find('td').find('#supplier' + counter).append($('<option>',{value:obj.v, text:obj.v}));
    });
    $.each(delievery_time, function(i, obj) {
       // console.log(obj);
       if(obj !='')
        $(document).find('#TextBoxDiv' + counter).find('td').find('#delievery_time' + counter).append($('<option>',{value:obj, text:obj}));
    });
      
    // i = min;
    // for(i;i<=max;i++){
     
    //    // echo "<option value='" +$i +"'>"+i+"</option>";
    //     $(document).find('#TextBoxDiv' + counter).find('td').find('#block_below' + counter).append($('<option>',{value:i, text:i}));

    // }
    // j = min;
    // for(j;j<=max;j++){
     
    //    // echo "<option value='" +$i +"'>"+i+"</option>";
    //     $(document).find('#TextBoxDiv' + counter).find('td').find('#block_above' + counter).append($('<option>',{value:j, text:j}));

    // }

    $.each(include_from_time, function(i, obj) {
       // console.log(obj);
       if(obj !='')
        $(document).find('#TextBoxDiv' + counter).find('td').find('#include_from_time' + counter).append($('<option>',{value:i, text:obj+':00'}));
    });
    $.each(exclude_from_time, function(i, obj) {
       // console.log(obj);
       if(obj !='')
        $(document).find('#TextBoxDiv' + counter).find('td').find('#exclude_from_time' + counter).append($('<option>',{value:i, text:obj+':00'}));
    });
  
    counter++;
    check_count++;
    });
    $(document).on('click', '.removeButton', function(e){

        if(!confirm('Are you sure you want to delete this record?')){
                    e.preventDefault();
                    return false;
        }
        else{
           console.log($(this));
        var counter_value = $(this).data('counter');
        // var div = $(this).data('div');
        // console.log(div);

          if(counter_value<1){
            alert("No more textbox to remove");
            return false;
          }   
          
          counter--;
        
          $("#TextBoxDiv" + counter_value).remove();
        }


 
     
      
     });

  });
</script>


