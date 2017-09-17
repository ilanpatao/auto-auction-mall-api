<!--/////////////////////////////
// Written by: Ilan Patao //
// ilan@dangerstudio.com //
//////////////////////////-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Auto Auction Mall REST API Example</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="https://autotrader-api.herokuapp.com/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://autotrader-api.herokuapp.com/css/mdb.min.css" rel="stylesheet">
    <!-- BST core CSS -->
    <link href="https://autotrader-api.herokuapp.com/js/bootstrap-table.min.css" rel="stylesheet">
</head>

<body>


    <div class="container" style="margin-top:25px;">
        <div class="flex-center flex-column">
            <h1 class="animated fadeIn mb-4">Auto Auction Mall REST API Example</h1>

            <h5 class="animated fadeIn mb-3">Written by: <a href="mailto:ilan@dangerstudio.com" style="text-decoration:none;">Ilan Patao</a> - 09/17/2017</h5>

            <p class="animated fadeIn text-muted"></p>	
			

		<div class="table-responsive" id="results">
        <table id="table"
               data-toggle="table"
			   data-height="625"
			   data-page-size="100"
               data-show-columns="true"
               data-pagination="true"
               data-search="true">
            <thead>
            <tr>
                <th data-field="year" data-sortable="true">Year</th>
				<th data-field="make" data-sortable="true">Make</th>
				<th data-field="model" data-sortable="true">Model</th>
				<th data-field="type" data-sortable="true">BodyStyle</th>
				<th data-field="condition" data-sortable="true">Condition</th>
				<th data-field="color" data-sortable="true">Color</th>
				<th data-field="miles" data-sortable="true">Miles</th>
				<th data-field="vin" data-sortable="true">VIN</th>
				<th data-field="currentbid" data-sortable="true">Current Bid</th>
				<th data-field="bids" data-sortable="true">Total Bids</th>
				<th data-field="buynow" data-sortable="true">Buy Now</th>
				<th data-field="city" data-sortable="true">City</th>
				<th data-field="state" data-sortable="true">State</th>
            </tr>
            </thead>
				
			<?PHP
			
			// Make and loop through the request
			while($i <= 1200) {
				$x = 0;				
				$curl = curl_init();
				
				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://9vmz5hxzr0-dsn.algolia.net/1/indexes/*/queries?&x-algolia-application-id=9VMZ5HXZR0&x-algolia-api-key=a690ed2c1bfe7a3d4d4c2dfc124fb075",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => "{\"requests\":[{\"indexName\":\"prod_aam_auctions\",\"params\":\"query=&maxValuesPerFacet=100&page=".$x."&facets=%5B%22current_bid%22%2C%22odometer%22%2C%22year%22%2C%22make.name%22%2C%22model.name%22%2C%22hierarchical_vehicle.lvl0%22%2C%22hierarchical_vehicle.lvl1%22%2C%22title%22%2C%22vehicleType%22%2C%22bodyStyle%22%2C%22saleType%22%2C%22saleTypes%22%2C%22single_location%22%2C%22location_city_state%22%2C%22extFilters%22%5D&tagFilters=&numericFilters=%5B%22start_date_timestamp%3E%3D1505658072%22%2C%22year%3E%3D1990%22%2C%22year%3C%3D2018%22%5D\"}]}",
				  CURLOPT_HTTPHEADER => array(
					"X-Requested-With: XMLHttpRequest"
				  ),
				));
				
				$response = curl_exec($curl);
				$err = curl_error($curl);
				$jdata = json_decode($response);
				
				curl_close($curl);
				
				$hits = $jdata->results[0]->nbPages;

				// Build the table rows
				foreach ($jdata->results[0]->hits as $key){
					$color = $jdata->results[0]->hits[$x]->color;
					$bodyStyle = $jdata->results[0]->hits[$x]->bodyStyle;
					$buynow = $jdata->results[0]->hits[$x]->buyNow;
					$bidcount = $jdata->results[0]->hits[$x]->bidsCount;
					$currentbid = $jdata->results[0]->hits[$x]->current_bid;
					$image = $jdata->results[0]->hits[$x]->image;
					$condition = $jdata->results[0]->hits[$x]->condition;
					$type = $jdata->results[0]->hits[$x]->vehicleType;
					$miles = $jdata->results[0]->hits[$x]->odometer;
					$city = $jdata->results[0]->hits[$x]->city;
					$state = $jdata->results[0]->hits[$x]->fullState;
					$title = $jdata->results[0]->hits[$x]->name;
					$vin = $jdata->results[0]->hits[$x]->vin;
					$ymm = explode(" ",$title);
					$year = $ymm[0];
					$make = $ymm[1];
					$model = $ymm[2];
					$x = $x + 1;
					
					if (empty($bidcount)){
						$bidcount = "1";
					}
					
					echo "<tr>";
					echo "<td>" . $year . "</td>";
					echo "<td>" . $make . "</td>";
					echo "<td>" . $model . "</td>";
					echo "<td>" . $bodyStyle . "</td>";
					echo "<td>" . $condition . "</td>";
					echo "<td>" . $color . "</td>";
					echo "<td>" . $miles . "</td>";
					echo "<td>" . $vin . "</td>";
					echo "<td>$" . $currentbid . "</td>";
					echo "<td>" . $bidcount . "</td>";
					echo "<td>$" . $buynow . "</td>";
					echo "<td>" . $city . "</td>";
					echo "<td>" . $state . "</td>";
					echo "</tr>";
				}
				$i = $i + 100;
			}	
			
			?>

        </table>
		</div>
		

		
		<center>
				<p class="animated fadeIn text-muted">
					This sample is pulling only a handfull of records. Ideally, you can loop through the entire inventory by increasing the loop variable to 50,000 for example.</b>.
				</p>
							
			<br>Written by: <a href="mailto:ilan@dangerstudio.com" style="text-decoration:none;">Ilan Patao</a> - 09/17/2017
			
		</center>
        </div>
    </div>
    <!-- JQuery -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/mdb.min.js"></script>
    <!-- BST core JavaScript -->
    <script type="text/javascript" src="https://autotrader-api.herokuapp.com/js/bootstrap-table.min.js"></script>
</body>
<script>
$(document).ready(function(){
});
</script>
</html>