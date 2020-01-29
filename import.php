   <?php
     date_default_timezone_set('Asia/Kolkata');
  $conn = mysqli_connect("localhost", "root", "", "feeds");
    $query1="SELECT * from feeds_config";

     $result1 = mysqli_query($conn,$query1);
  
    while($row1 = mysqli_fetch_array($result1)){
            $title_name =  $row1['feed_name'];
      // echo "<pre>";
      // print_r($_POST);
      // print_r($_POST['input_file']);
      $url = $row1['input_url'];

      // echo "<pre>";
      // print_r($row1['feed_name']);
      //  print_r($row1['input_url']);
       if(!empty($url)){
         mysqli_query($conn,'TRUNCATE TABLE feeds');
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
        // $delievery_time[ $row['id']] = (isset( $row['delievery_time'])) ?  $row['delievery_time'] :'';
        // $price[ $row1['id']] = (isset( $row1['price'])) ?  $row1['price'] :'';

           
    }
    die;
  //   if(isset($_POST['import']) && !empty($_POST['import'])){

  //       mysqli_query($conn,'TRUNCATE TABLE feeds');
    
  //     $title_name =  $_POST['title_name'];
  //     // echo "<pre>";
  //     // print_r($_POST);
  //     // print_r($_POST['input_file']);
  //     $url = $_POST['input_file'];
  //     $data = array();

  //     $arr = array();
  //     if (($handle = fopen($url, "r")) !== FALSE)
  //     {
  //         while (($data = fgetcsv($handle, 2048, ";")) !== FALSE)
  //         {
             
  //             $arr[] = array(
  //                   'name'  => $data[0],
  //                   'sku'  => $data[1],
  //                   'ean'  => $data[2],
  //                   'price'  => $data[3],
  //                   'url'  => $data[4],
  //                   'delievery_time'  => $data[5],
  //                   'supplier'  => $data[6],
  //                   'image' => $data[8]
  //               );

            
  //         }
  //     }
  //     foreach ($arr as $key => $value) {

  //       if($key !=0){
  //         $data[] = $value;
          
  //       }

  //     }

  //     if(!empty($data)){
  //     foreach ($data as $key => $value) {
  //           $name =mysqli_real_escape_string($conn,$value['name']);
  //           $sku =mysqli_real_escape_string($conn,$value['sku']);
  //           $ean =mysqli_real_escape_string($conn,$value['ean']);
  //           $price =mysqli_real_escape_string($conn,$value['price']);
  //           $url =mysqli_real_escape_string($conn,$value['url']);
  //           $im_delievery_time =mysqli_real_escape_string($conn,$value['delievery_time']);
  //           $im_supplier =mysqli_real_escape_string($conn,$value['supplier']);
  //           $image =mysqli_real_escape_string($conn,$value['image']);

  //           $name = (isset($name))? $name : '';
  //           $sku = (isset($sku)) ? $sku :'';
  //           $ean = (isset($ean)) ? $ean : '';
  //           $price = (isset($price)) ? $price : '';
  //           $url = (isset($url)) ? $url : '';
  //           $im_delievery_time = (isset($im_delievery_time)) ? $im_delievery_time : '';
  //           $im_supplier = (isset($im_supplier)) ? $im_supplier : '';
  //           $image = (isset($image)) ? $image : '';

       
  //           // echo $name;
  //           // die;
            
  //           $sql = "insert into feeds (title_name,name, sku, ean,price,url,delievery_time, supplier, image, date) values 
  //           ('$title_name','$name','$sku', '$ean','$price','$url','$im_delievery_time', '$im_supplier', '$image', NOW() )";
                
            
  //           if(mysqli_query($conn, $sql)){
  //             // echo "Import successfully";
             
  //             // die;
  //           } else{
  //             echo "Error: ".mysqli_error($conn);
  //             die;
               
  //           }
  //       }
  //    }
  //    else{
  //       echo "Error In importing ";
  //           die; 
  //     }

  // }