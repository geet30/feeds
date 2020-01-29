<?php  // error_reporting( E_ALL );
?>
<?php 
  date_default_timezone_set('Asia/Kolkata');
  $conn = mysqli_connect("localhost", "root", "", "feeds");

   if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
   }
    $query1="SELECT * from feeds";

     $result1 = mysqli_query($conn,$query1);
  
    while($row1 = mysqli_fetch_array($result1)){
        // $delievery_time[ $row['id']] = (isset( $row['delievery_time'])) ?  $row['delievery_time'] :'';
        $price[ $row1['id']] = (isset( $row1['price'])) ?  $row1['price'] :'';
           
    }
      $min =  min(array_filter($price,'strlen'));
      $max =  max(array_filter($price,'strlen'));
      $min = (int)round($min);
      $max = (int)round($max);

 $include_from_time =array('1'=>1,'2'=>2,'3'=>3,'4'=>'4','5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>'9','10'=>10,'11'=>'11','12'=>'12','13'=>13,'14'=>14,'15'=>15,'16'=>16,'17'=>'17','18'=>18,'19'=>19,'20'=>20,'21'=>21,'22'=>'22','23'=>'23','24'=>'24');
   $searh_query = "SELECT * FROM new_feeds";
   $result = mysqli_query($conn,$searh_query);
      $conditions = "";
    

date_default_timezone_set('Europe/Berlin');

// date_default_timezone_set("Asia/Calcutta");
// // CURRENT UNIX TIMESTAMP
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
         $include_image = (isset( $row['include_image'])) ?  $row['include_image'] :'';
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
          $end_time = DateTime::createFromFormat('H',  $include_from_time[24])->format("Y-m-d H:i:s");
         }

         $date = date('Y-m-d');
         $current_day =  date('D', strtotime($date));

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

          if($include_image =='')
             $conditions .= " AND image !=''";
           
          $conditions .=   " AND ".strtotime($curre)." >= ".strtotime($start_time);
          $conditions .=   " AND ".strtotime($curre)." <= ".strtotime($end_time);
     
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

        

           
      }
      $query = "SELECT * FROM feeds";
      $sql = $query;
       if ($conditions) {
        $sql .= " WHERE " .$conditions;
         // $where = " WHERE " .$conditions;
      }
      // if ($conditions) {
        // $where = " WHERE " . implode(' OR ', $conditions);
        // $where = " WHERE " .$conditions;
        // $sql = "SELECT * FROM feeds ".$where;
      
      // $sql = $query;
      // if (count($conditions) > 0) {
      //   $sql .= " WHERE " . implode(' OR ', $conditions);
      // }
            $result = mysqli_query($conn,$sql);
              $array = array();
                while($row = mysqli_fetch_array($result)){
                      $array[] = array(
                            'name' =>  (isset($row['name']))? $row['name'] : '',
                            'sku' => (isset($row['sku'])) ? $row['sku'] :'',
                            'ean' =>  (isset($row['ean'])) ? $row['ean'] :'',
                            'price' => (isset($row['price'])) ? $row['price'] :'',
                            'url' => (isset($row['url'])) ? $row['url'] :'',
                            'delievery_time' => (isset($row['delievery_time'])) ? $row['delievery_time'] :'',
                            'supplier' => (isset($row['supplier'])) ? $row['supplier'] :'',
                            'image' => (isset($row['image'])) ? $row['image'] :'',
                      );
                     

                     
                }
          

     $filename = 'export/feeds'.date('Y-m-d-H:i:s').'.csv'; 
     // $filename = 'export/tweakers-nl-feed.csv'; 
      // $filename = 'export/tweakers_nl/feed.csv'; 
       // header("Content-Description: File Transfer"); 
       // header("Content-Disposition: attachment; filename=$filename"); 
       // header("Content-Type: application/csv; ");

      // $file = fopen('php://output', 'w+');

       $file = fopen($filename, 'w');
     
      $header = array("Name","Sku","EAN","Price","URL","Delivery Time","Supplier", "Image"); 
      fputcsv($file, $header);
      foreach ($array as $key => $value) {
        fputcsv($file,$value); 
            // fwrite($filename, $value);
        // $location = $_SERVER['DOCUMENT_ROOT'].'/'.$file;

      }
// $content = file_get_contents($file); 
      // file_put_contents($filename, $file);

//   $data = 'somedata';
// $temp_name = 'export/'.$filename;
// if (file_put_contents($temp_name, $file) === FALSE) {
//     // the message print that the file could not be created.
//     print 'The file could not be created.';
// }
// else{
//   echo 'success';
// }
// die('test');
      fclose($file); 
       exit;





     

       
 

     ?>