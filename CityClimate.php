<?php

$weather ="";
$error = "";
if (array_key_exists("cityName", $_GET)) {
$cityName = str_replace(" ", "_", $_GET['cityName']);
$file = "https://en.wikipedia.org/wiki/".$cityName;
}

if (array_key_exists("cityName", $_GET)) {
  
  // to check if the webpage is available/valid
  $file_headers = @get_headers($file);
   if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $error = "City could not be found <br> src: <a href='".$file."'>".$file."</a>";
   }
  else {
    //get the web page content
  $forecasts = file_get_contents($file);
  
  //split the string/html
  $sectionStart = explode('<h3><span class="mw-headline" id="Climate">Climate</span>', $forecasts);
    
    if (sizeof($sectionStart) > 1) {

      // "1" to get the part after the split point
      $sectionEnd = explode('<table class="wikitable collapsible"', $sectionStart[1]);
     
      if (sizeof($sectionEnd) > 1) {
           $weather = $sectionEnd[0].'<br> src: <a href="'.$file.'">'.$file.'</a>';
      }
    } else {
       $error = "City could not be found <br> src: <a href='".$file."'>".$file."</a>";
      
    }
  }
}

?>

<html>
  <head> 
    
    <title> City's Climate </title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="CityClimate.css">
    
  </head>
  <body>
    
    <div class="container">
      <form>
    <h1> City's Climate</h1> 
    <label for="city"> Enter a city name </label> <br>
    
    <input type="text" id="cityName" name="cityName" placeholder="City's name"> <br>
        <button type="submit" id="submitButton" class="btn btn-primary" name="submitButton">Submit</button>
      </form>
      
       <div id="result">
      <?php
        if ($weather) {
          echo '<div class="alert alert-success" role="alert"> <p> <strong> '.$_GET['cityName'].'</strong></p>'.$weather.'</div>';
        } else if  ($error){
          echo '<div class="alert alert-danger" role="alert"> <p> <strong> '.$_GET['cityName'].'</strong></p>'.$error.'</div>';
        }
        ?>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    
    <script>
      
    </script>
    
  </body>  
</html>