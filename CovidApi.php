<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Covid-19 API</title>
  </head>
  <body>
    <h2>Covid-19 data by country</h2>

    <br/><br/>
        <h3 style="text-align: center;">
            Enter Country Name</h3>
        <div style="text-align: center; 
             border: aquamarine groove 5px; width: 40%; 
             margin: 0 auto;">
            <br/>
           
            <form action="CovidApi.php">

                <input type="text" id="location" name="location"/>    
                <button type="submit">Submit</button> 

            </form>

        <?php
            $loc = "";
            if($_SERVER['REQUEST_METHOD'] == "GET" && !empty($_GET['location'])){
                $loc = $_GET['location'];
                $validLocation = preg_match('/^(?![ .]$)[a-zA-Z .]$/', $loc);

                    if($validLocation == 0){
                        //valid name
                        $url = "https://restcountries.eu/rest/v2/name/".urlencode($loc);
                        $urlSpc = str_replace("+", " ", $url);

                        // @ is used to supress warnings
                        if($response = @file_get_contents($urlSpc)){
                            $jsonArray = json_decode($response, true);
                            //var_dump($jsonArray);
                        ?>                      
                            <div class="card" style="width: 18rem;">
                                <img src="..." class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">An item</li>
                                    <li class="list-group-item">A second item</li>
                                    <li class="list-group-item">A third item</li>
                                </ul>
                                <div class="card-body">
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
<?php

                            echo "<h1>".$jsonArray['0']['name']."</h1><br>";
                            echo "<strong>Population: </strong>".$jsonArray['0']['population']."<br>";
                            echo "<strong>Area: </strong>".$jsonArray['0']['area']."<br>";
                            echo "<strong>Currencies: </strong>"; echo loopArray($jsonArray['0']['currencies'])."<br>";
                            echo "<strong>Languages: </strong>"; echo loopArray($jsonArray['0']['languages'])."<br>";
                            echo "<strong>Capital: </strong>".$jsonArray['0']['capital']."<br>";
                            ?>
                                <br />
                                <img src="<?php echo $jsonArray['0']['flag']?>" width="30%" height="30%">
                                <br />
                            <?php
                        }
                    }else{
                        echo "Not a valid name";
                    }
            }

            function loopArray($jsonArray) {
                if($jsonArray){
                    foreach($jsonArray as $value){
                        if(is_array($value)) {
                            loopArray($value);
                        }else{
                            echo $value.", ";
                        }
                    }
                }
            }
        ?>

        </div>
        <?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://covid-193.p.rapidapi.com/statistics",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: covid-193.p.rapidapi.com",
		"x-rapidapi-key: 008c9c8d63msh697dd4e881dd3f1p1a1614jsn693f63c19848"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	//echo $response;
    $response = json_decode($response);

    foreach ($response->response as $response) {
        if ($response->country == $loc){
            echo "<h1>Covid Cases: </h1>";
            echo "<strong>New: </strong>".$response->cases->new."<br/>";            
            echo "<strong>Active: </strong>".$response->cases->active."<br/>";            
            echo "<strong>Critical: </strong>".$response->cases->critical."<br/>";            
            echo "<strong>Recovered: </strong>".$response->cases->recovered."<br/>";
            echo "<strong>Total: </strong>".$response->cases->total."<br/>";
            echo "<h1>Deaths: </h1>";
            echo "<strong>New: </strong>".$response->deaths->new."<br/>";            
            echo "<strong>Total: </strong>".$response->deaths->total."<br/>";  
            echo "<h1>Tests: </h1>";
            echo "<strong>Total: </strong>".$response->tests->total."<br/>";
            echo "<h1>Date and Time: </h1>";
            echo "<strong>Date: </strong>".$response->day."<br/>";  
            echo "<strong>Time: </strong>".$response->time."<br/>";  


          

            }

        }
        
    }
    

?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
  </body>
</html>
