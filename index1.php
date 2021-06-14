<!DOCTYPE html>

<html>
    <head>
        <title>Smart Price</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    </head>
    <body>
        <header class="w3-container w3-teal">
		 <h1>SmartPrice</h1>
		 </header>
		 <div class="w3-container" >

		<form class="w3-container w3-card-4" action="index.php" method="get" >
		</form>
        <div class="w3-row-padding w3-margin-top">
		<?php
        
        include 'simple_html_dom.php';
        ini_set("user_agent" , "Mozilla/3.0\r\nAccept: */*\r\nX-Padding: Foo");
        //comment from here
        $search=$_GET['searchdata'];
        $search_strings= str_replace(' ', '-', $search);
        $position='26';
		$amazon_position='26';    
        $flipkart_position='34';
        $paytm_mall_position='36';
        $tata_cliq_position='57';
        $happi_mobiles_position='51';
		
		$string_insert_with_plus=str_replace(" ", "+", "$search_strings");
        $string_insert_with_20= str_replace(" ","%20", $search_strings);
       
        $test_url='https://www.91mobiles.com/-price-in-india';
        $url = substr($test_url, 0, $position) . $search_strings . substr($test_url, $position);
        //echo $url.'<br>';
		$amazon_url='https://www.amazon.in/s?k=&ref=nb_sb_noss_1';
        $flipkart_url='https://www.flipkart.com/search?q=';
        $paytm_mall_url='https://paytmmall.com/shop/search?q=%20';
        $tata_cliq_url='https://www.tatacliq.com/search/?searchCategory=all&text=%20';
        $happi_mobiles_url='https://www.happimobiles.com/mobiles/all?serach=&q=vivo+v20';
		function stringInsert($str,$insertstr,$pos)
               {
                  $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
                    return $str;
                }
		$amazon_finalurl= stringInsert($amazon_url,$string_insert_with_plus, $amazon_position) ;
        $flipkart_finalurl= stringInsert($flipkart_url,$string_insert_with_plus,$flipkart_position);
        $paytm_mall_final= stringInsert($paytm_mall_url,$string_insert_with_20, $paytm_mall_position);
        $tata_cliq_finalurl= stringInsert($tata_cliq_url,$string_insert_with_20, $tata_cliq_position);
        $happi_mobiles_finalurl= stringInsert($happi_mobiles_url, $string_insert_with_plus, $happi_mobiles_position);
               
        //try
        
        $web= file_get_contents($url);
       $pic= explode('<div class="image_pnl">', $web);
       $pic1= explode('</div>', $pic[1]);
       $pic2= explode('src="', $pic1[0]);
       
       $pic3= explode('"', $pic2[1]);
       $i='https:';
       $result=$i.$pic3[0];
	   
	   $web1= file_get_html($url);
       foreach ($web1->find('h1.h1_pro_head') as $titles)
		{
           $title[]=$titles->plaintext;
        }
	   echo '
         <br>
		<div class="w3-row" style="text-align:center">
		<div class="w3-col l2 w3-row-padding" >
		<div class="w3-card-2" style="background-color:teal;color:white;text-align:justify">
		<br>
        <img style="text-align:justify" src='.$result.'>
        <br>
		<div class="w3-container">
		<h5>'.$title[0].'</h5>
		</div>
		</div>
		</div>
	  ';
	  
	    echo '
		<div class="w3-col l8" >
		<div class="w3-card-2">
		  <table class="w3-table w3-striped w3-bordered w3-card-4">
		  <thead>
		  <tr class="w3-blue">
			<th>Site Name</th>
			<th>Price</th>
			<th>Buy Here</th>
		  </tr>
		  </thead>
		';
		
       
       // $web1= file_get_html($url);
       // foreach ($web1->find('h1.h1_pro_head') as $titles){
           // $title[]=$titles->plaintext;
       // }
       // echo $title[0];
       // echo '<br>';
       foreach ($web1->find('img.img_alt') as $img){
           $images[]=$img->alt;
           
       }
       $names=array_unique($images);
             
       foreach ($web1->find('span.prc') as $prc){
           $prices[]=$prc;
       }
       echo '<br>';
       
       foreach ($prices as $price){
           $amount[]=str_replace('(after PayTM cashback)', '', $price);
		   $site_name=array(5);
		   $site_name[0]=$amazon_finalurl;
		   $site_name[1]=$paytm_mall_final;
		   $site_name[2]=$flipkart_finalurl;
		   $site_name[3]=$tata_cliq_finalurl;
		   $site_name[4]=$happi_mobiles_finalurl;
       }
       for($i=0;$i<count($amount);$i++){
		   echo '
		  <tr>
			<td>'.$names[$i].'</td>
			<td>'.$amount[$i].'</td>
			<td><a href='.$site_name[$i].'>Buy</a></td>
		  </tr>
		  <br>
		  ';
       }
       echo '<br>';
       
       
       foreach ($web1->find('ul.specs_ul') as $tab){
           $table[]=$tab;
       }
       echo '<br>';
       echo $table[0].'<br>';
       echo $table[1].'<br>';
       echo $table[2].'<br>';
       echo $table[3].'<br>';
       //to here - for mobiles
        
        
       //catch
       /* $search_string='asus tuf gaming a15';
       $url1='https://www.91mobiles.com/laptopfinder.php?search=asus%20tuf%20gaming%20a15';
       $web2= file_get_html($url1);
       
       foreach ($web2->find('a.hover_blue_link') as $link){
           if(stripos($link,$search_string)!==false){
               $i='https://www.91mobiles.com/';
               $url2=$i.$link->href;
               echo $url2;
               break;
           }
       } 
        $web= file_get_contents($url2);
       $pic= explode('<div class="image_pnl">', $web);
       $pic1= explode('</div>', $pic[1]);
       $pic2= explode('src="', $pic1[0]);
       
       $pic3= explode('"', $pic2[1]);
       $i='https:';
       $result=$i.$pic3[0];
       echo '
         <br>
         <img style="text-align:center" src='.$result.'>
             <br>
         ';
       $web1= file_get_html($url2);
       foreach ($web1->find('h1.h1_pro_head') as $titles){
           $title[]=$titles->plaintext;
       }
       echo $title[0];
       echo '<br>';
       foreach ($web1->find('img.img_alt') as $img){
           $images[]=$img->alt;
           
       }
       $names=array_unique($images);
             
       foreach ($web1->find('span.prc') as $prc){
           $prices[]=$prc;
       }
       echo '<br>';
       
       foreach ($prices as $price){
           $amount[]=str_replace('(after PayTM cashback)', '', $price);
       }
       for($i=0;$i<count($amount);$i++){
           echo $names[$i].'<br>';
            
           echo $amount[$i];
           echo '<br>';
       }
       echo '<br>';
       
       
       foreach ($web1->find('ul.specs_ul') as $tab){
           $table[]=$tab;
       }
       echo '<br>';
       echo $table[0].'<br>';
       echo $table[1].'<br>';
       echo $table[2].'<br>';
       echo $table[3].'<br>';*/
        ?>
        
    </body>
</html>
