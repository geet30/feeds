<?php 
   date_default_timezone_set('America/New_York');
   $conn = mysqli_connect("localhost", "root", "", "feeds");

   if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
   }

   $searh_query = "SELECT * FROM new_feeds";
   $result = mysqli_query($conn,$searh_query);
    $conditions = array();

date_default_timezone_set('Europe/Dublin');

// date_default_timezone_set("Asia/Calcutta");
// // CURRENT UNIX TIMESTAMP
$time_now = time();

// // TODAY AT 18:00:00 (24 HOUR) UNIX TIMESTAMP


//  $current_time = date("H:i a");
// $sunrise = "5:42 am";
// $sunset = "6:26 pm";
// $date1 = DateTime::createFromFormat('H:i a', $current_time);
// $date2 = DateTime::createFromFormat('H:i a', $sunrise);
// $date3 = DateTime::createFromFormat('H:i a', $sunset);

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
         //   $end_time = date('Y-m-d H:i:s', strtotime($end_time . ' +1 day'));

         // }
         // echo '6'.$end_time;"<br>";
         // $date = date('2018-12-09');
              $date = date('Y-m-d');

          $current_day =  date('D', strtotime($date));
 $conditions[] = "price BETWEEN ".$block_belows." AND ".$block_aboves." AND supplier='".$suppliers."' AND delievery_time='".$delievery_times."' AND ('".strtotime($current_day)."'='".strtotime($include_on_monday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_tuesday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_wednesday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_thursday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_friday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_saturday)."'  OR '".strtotime($current_day)."'='".strtotime($include_on_sunday)."' )AND 
         ".strtotime($curre)." BETWEEN ".strtotime($start_time)." AND ".strtotime($end_time);

        

           
      }


    $query = "SELECT * FROM feeds";
      $sql = $query;
      if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' OR ', $conditions);
      }

// echo $sql;
// die;
//     if(! empty($block_below) || !empty($block_above)) {
//       foreach ($block_below as $key => $below) {
//             foreach ($block_above as $key => $above) {
//                $conditions[] = "price BETWEEN '".$below."' AND '".$above."'";
//             }
            
//       }
//     }

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
            );
           

           
      }

      // echo "<pre>";
      // print_r($array);
      // die;
       $filename = 'feeds'.date('Ymd').'.csv'; 
       header("Content-Description: File Transfer"); 
       header("Content-Disposition: attachment; filename=$filename"); 
       header("Content-Type: application/csv; ");

      $file = fopen('php://output', 'w');
     
      $header = array("Name","Sku","EAN","Price","URL","Delievery Time","Supplier"); 
      fputcsv($file, $header);
      foreach ($array as $key => $value) {
            // echo "<pre>";
            // print_r($value);die;
            fputcsv($file,$value); 
      }
      // die;
      
      fclose($file); 
       exit;





     

       
 

     ?>