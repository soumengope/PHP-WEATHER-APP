<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $data = false;
    if(isset($_POST['submit'])){
        $city = $_POST['city'];
        if(!empty($city)){
            $api_link = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=5f3953f0a779f082086c8bd10b7eead1";
            $crl = curl_init();
            curl_setopt($crl,CURLOPT_URL,$api_link);
            curl_setopt($crl,CURLOPT_RETURNTRANSFER,true);
            $res = curl_exec($crl);
            curl_close($crl);
            $res = json_decode($res,true);
            $data = true;
        }
    }
    ?>
    <?php
    echo'<div id="main_div">';
        echo '<div id="main_header">WEATHER APPLICATION</div>';
        echo '<div id="search_div">';
            echo '<form method="POST">';
            echo '<input type="text" id="city" name="city" placeholder="Enter City Name">';
            echo '<input type="submit" name="submit" Value="Search" id="submit" name="Submit">';
            echo '</form>';
        echo '</div>';
        ?>
        <?php 
        if(isset($_POST['submit'])){
            if(empty($_POST['city'])){
                echo '<div id="empty_city"> City name can not be empty</div>';
            }
        }
        ?>
        <?php if($data==true){
        if($res['cod'] == "404"){
            echo '<div id="missing_city"> City is not found</div>';
        }else{
            echo '<div id="weather_logo"><img src="https://openweathermap.org/img/wn/';echo $res['weather'][0]['icon'];echo'@2x.png" width="100px" height="100px" alt=""></div>';
            echo '<div id="weather_val">';echo $res['main']['temp']-273.15; echo '&degC'; echo'</div>';
            echo '<div id="weather_desc">';echo $res['weather'][0]['description']; echo'</div>';
            echo '<div id="main_location">';
                echo '<div><img src="location.png" width="20px" height="20px" alt=""></div>';
                echo '<div id="weather_location">';echo $res['name']; echo' , '; echo $res['sys']['country']; echo'</div>';
            echo '</div>';
            echo '<div>';
            echo '<div id="main_bottom">';
                echo '<div id="wind">';
                    echo '<div class="bottom_header">Wind Speed</div>';
                    echo '<div class="bottom_val">';echo $res['wind']['speed'];echo' MPH'; echo'</div>';
                echo '</div>';
                echo '<div id="humadity">';
                    echo '<div class="bottom_header">Humadity</div>';
                    echo '<div class="bottom_val">';echo $res['main']['humidity'];echo ' %'; echo'</div>';
                echo '</div>';
            echo '</div>';
            
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
</body>
</html>
