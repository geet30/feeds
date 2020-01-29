<?php 
   date_default_timezone_set('America/New_York');
   $conn = mysqli_connect("localhost", "root", "", "feeds");

   if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
   }

   $searh_query = "SELECT * FROM new_feeds";
   $result = mysqli_query($conn,$searh_query);
      while($row = mysqli_fetch_array($result)){

         $supplier[]= (isset( $row['supplier'])) ?  $row['supplier'] :'';
         $delievery_time[] = (isset( $row['delievery_time'])) ?  $row['delievery_time'] :'';
         $block_below[] = (isset( $row['block_below'])) ?  $row['block_below'] :'';
         $block_above[] = (isset( $row['block_above'])) ?  $row['block_above'] :'';
         $include_from_time[]=(isset( $row['include_from_time'])) ?  $row['include_from_time'] :'';
         $exclude_from_time[]=(isset( $row['exclude_from_time'])) ?  $row['exclude_from_time'] :'';
         $include_on_day[] = (isset( $row['include_on_day'])) ?  $row['include_on_day'] :'';

           
      }
     

    //Do real escaping here

    $query = "SELECT * FROM feeds";
    $conditions = array();


    if(! empty($block_below) || !empty($block_above)) {
      foreach ($block_below as $key => $below) {
            foreach ($block_above as $key => $above) {
               $conditions[] = "price BETWEEN '".$below."' AND '".$above."'";
            }
            
      }
    }
    if(! empty($supplier)) {
      foreach ($supplier as $key => $value) {
         $conditions[] = "supplier='$value'";
      }
     
      
    }
    
    if(! empty($include_from_time)) {


date_default_timezone_set('Europe/Dublin');

// CURRENT UNIX TIMESTAMP
$time_now = time();

// TODAY AT 18:00:00 (24 HOUR) UNIX TIMESTAMP
$opening_time = DateTime::createFromFormat('H:i:s', '18:00:00')->format("d-M-Y H:i:s"); // 11-May-2018 18:00:00

// TODAY AT 01:30:00 (24 HOUR) UNIX TIMESTAMP
$closing_time = DateTime::createFromFormat('H:i:s', '01:30:00')->format("d-M-Y H:i:s"); // 11-May-2018 01:30:00

// WE ARE CLOSED IF:
// TIME NOW IS AFTER CLOSING TIME TODAY (01:30:00)
// AND TIME NOW IS BEFORE OPENING TIME TODAY (18:00:00)
if($time_now > strtotime($closing_time) && $time_now < strtotime($opening_time))
{
    echo "Sorry, we are closed!";
}
else
{
    echo "We are open, come on in!";
}

//  $current_time = date("H:i a");
// $sunrise = "5:42 am";
// $sunset = "6:26 pm";
// $date1 = DateTime::createFromFormat('H:i a', $current_time);
// $date2 = DateTime::createFromFormat('H:i a', $sunrise);
// $date3 = DateTime::createFromFormat('H:i a', $sunset);


      foreach ($include_from_time as $key => $fromvalue) {
            
            $current_time = date('H');
         $conditions[] =CURDATE()." between ".$fromvalue and $tovalue;
      }
     
      
    }
    

    $sql = $query;
    if (count($conditions) > 0) {
      $sql .= " WHERE " . implode(' OR ', $conditions);
    }
echo $sql;
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

      echo "<pre>";
      print_r($array);
      die;
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