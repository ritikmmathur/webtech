	<head>
	<title>Stock Exchange</title>
		<script src="https://code.highcharts.com/highcharts.src.js"></script>
				<style type="text/css">
			body,a,ul {
				padding: 0px;
				margin: 0 auto;
			}
			h2,table {
				padding: 0px;
				margin: 0px;
			}
			.main-form {
				background-color: #EEE;
				border: 1px solid #CCC;
				margin: 0 auto;
				width: 400px;
				height: 150px;
			}
			.main-form hr {
				border: 1px solid #CCC;
			}
			.main-form h2 {
				text-align: center;
				padding-top: 5px;
			}
			.main-form input {
				border: 1px solid #CCC;
			}
			.main-form .button {
				border-radius: 4px;
			}
			.stock-display {
				border-collapse:collapse;
				border: 1px solid #CCC;
				width: 1000px;
				margin: 0 auto;
				padding: 0px;
			}
			.stock-display img {
				height: 12px;
				padding-left: 5px;
			}
			.stock-display td{
				border-bottom: 1px solid #CCC;
			}
			.stock-display td:nth-child(2n+1) {
				background-color: #EEE;
				width: 30%;
				font-weight: bold;
			}
			.stock-display td:nth-child(2n) {
				background-color: #F8F8F8;
				text-align: center;
				width: 70%;
			}
			.stock-display ul {
				list-style-type: none;
			}
			.stock-display ul li {
				width: 10%;
				float: left;
				display: block;
			}
			.stock-display ul li a{
				text-decoration: none;
				color: blue;
			}
			.stock-display ul li a:hover{
				text-decoration: none;
			}
			.button-link{
				text-decoration: none;
				color: blue;
				border: none;
				background: none;
				cursor: pointer;
				outline: none;
			}
			.button-link:hover{
				text-decoration: none;
			}
		</style>
		<script type="text/javascript">
			function getIndicatorURL(symbol, indicator) {
				return "https://www.alphavantage.co/query?function="+indicator+"&symbol="+symbol+"&interval=daily&time_period=10&series_type=open&apikey=85QVHJTGXCGUW2ZY"; 
			}

			function formattedDate(date) {
				var newDate = new Date(date);
				var month = newDate.getMonth()+1;
				var day = newDate.getDate()+1;
				if(month.length<10) {
					month = "0"+month;
				}
				if(day.length<10){
					day = "0"+day;
				}
				return month+"/"+day;

			}
			function extraArrayForGraph(json, key1, key2) {
				var sampleArray = [];
				var index = 0;
				for(key in json[key1]) {
					var temp =  formattedDate(key);
					sampleArray[temp] = parseFloat(json[key1][key][key2]);
					index++;
					if(index == 121) {
						break;
					}
				}
				return sampleArray;
			}

			function displaySMAGraph(symbol, response) {
				var json = JSON.parse(response);
				var sampleArray = extraArrayForGraph(json, 'Technical Analysis: SMA', 'SMA');
				HighChartLine(symbol, json['Meta Data']['2: Indicator'], "SMA", Object.keys(sampleArray).reverse(), Object.values(sampleArray).reverse());
			}

			function displayEMAGraph(symbol, response) {
				var json = JSON.parse(response);
				var sampleArray = extraArrayForGraph(json, 'Technical Analysis: EMA', 'EMA');
				HighChartLine(symbol, json['Meta Data']['2: Indicator'], "EMA", Object.keys(sampleArray).reverse(), Object.values(sampleArray).reverse());
			}

			function displayRSIGraph(symbol, response) {
				var json = JSON.parse(response);
				var sampleArray = extraArrayForGraph(json, 'Technical Analysis: RSI', 'RSI');
				HighChartLine(symbol, json['Meta Data']['2: Indicator'], "RSI", Object.keys(sampleArray).reverse(), Object.values(sampleArray).reverse());
			}

			function displayADXGraph(symbol, response) {
				var json = JSON.parse(response);
				var sampleArray = extraArrayForGraph(json, 'Technical Analysis: ADX', 'ADX');
				HighChartLine(symbol, json['Meta Data']['2: Indicator'], "ADX", Object.keys(sampleArray).reverse(), Object.values(sampleArray).reverse());
			}

			function displayCCIGraph(symbol, response) {
				var json = JSON.parse(response);
				var sampleArray = extraArrayForGraph(json, 'Technical Analysis: CCI', 'CCI');
				HighChartLine(symbol, json['Meta Data']['2: Indicator'], "CCI", Object.keys(sampleArray).reverse(), Object.values(sampleArray).reverse());
			}

			function displaySTOCHGraph(symbol, response) {
				var json = JSON.parse(response);
				var sampleArray = extraArrayForGraph(json, 'Technical Analysis: STOCH', 'SlowD');
				var Line2Values1 = Object.values(sampleArray).reverse();
				sampleArray = extraArrayForGraph(json, 'Technical Analysis: STOCH', 'SlowK');
				var Line2Values2 = Object.values(sampleArray).reverse();
				HighChartLine2(json['Meta Data']['2: Indicator'],"STOCH",Object.keys(sampleArray).reverse(),symbol + " SlowD", Line2Values1, symbol + " SlowK", Line2Values2);
			}

			function displayMACDGraph(symbol, response) {
				var json = JSON.parse(response);
				var sampleArray = extraArrayForGraph(json, 'Technical Analysis: MACD', 'MACD_Hist');
				var Line3Values1 = Object.values(sampleArray).reverse();
				sampleArray = extraArrayForGraph(json, 'Technical Analysis: MACD', 'MACD_Signal');
				var Line3Values2 = Object.values(sampleArray).reverse();
				sampleArray = extraArrayForGraph(json, 'Technical Analysis: MACD', 'MACD');
				var Line3Values3 = Object.values(sampleArray).reverse();
				HighChartLine3(json['Meta Data']['2: Indicator'],"MACD",Object.keys(sampleArray).reverse(),symbol + " MACD_Hist", Line3Values1, symbol + " MACD_Signal", Line3Values2, symbol + " MACD", Line3Values3);
			}

			function displayBBANDSGraph(symbol, response) {
				var json = JSON.parse(response);
				var sampleArray = extraArrayForGraph(json, 'Technical Analysis: BBANDS', 'Real Upper Band');
				var Line3Values1 = Object.values(sampleArray).reverse();
				sampleArray = extraArrayForGraph(json, 'Technical Analysis: BBANDS', 'Real Lower Band');
				var Line3Values2 = Object.values(sampleArray).reverse();
				sampleArray = extraArrayForGraph(json, 'Technical Analysis: BBANDS', 'Real Middle Band');
				var Line3Values3 = Object.values(sampleArray).reverse();
				HighChartLine3(json['Meta Data']['2: Indicator'],"BBANDS",Object.keys(sampleArray).reverse(),symbol + " Real Upper Band", Line3Values1, symbol + " Real Lower Band", Line3Values2, symbol + " Real Middle Band", Line3Values3);
			}

			function xmlSuccess() {
				this.callback.apply(this, this.arguments);
			}

			function xmlError() {
				console.error(this.statusText); 
			}

			function loadFile(url, callback){
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.callback = callback;
				xmlhttp.arguments = Array.prototype.slice.call(arguments, 2);
				xmlhttp.onload = xmlSuccess;
				xmlhttp.onerror = xmlError;
				xmlhttp.open("GET",url,true);
				xmlhttp.send();
			}

			function showGraph(symbol, indicator) {
				var xmlDoc=this.responseText;
				if(indicator == "SMA") {
					displaySMAGraph(symbol, xmlDoc);
					return;
				}
				if(indicator == "EMA") {
					displayEMAGraph(symbol, xmlDoc);
					return;
				}
				if(indicator == "RSI") {
					displayRSIGraph(symbol, xmlDoc);
					return;
				}
				if(indicator == "ADX") {
					displayADXGraph(symbol, xmlDoc);
					return;
				}
				if(indicator == "CCI") {
					displayCCIGraph(symbol, xmlDoc);
					return;
				}
				if(indicator == "STOCH") {
					displaySTOCHGraph(symbol, xmlDoc);
				}
				if(indicator == "BBANDS") {
					displayBBANDSGraph(symbol, xmlDoc);
				}
				if(indicator == "MACD") {
					displayMACDGraph(symbol, xmlDoc);
				}
			}

			function loadXML(ele){
				var symbol=ele.getAttribute("symbol");
				var indicator = ele.getAttribute("indicator");
				loadFile(getIndicatorURL(symbol,indicator), showGraph, symbol, indicator);
			}
			function loadStockNews(){
				var link = document.getElementById("toggle_link");
				var tableDiv = document.getElementById('stock-display-table');
				if(tableDiv === undefined || tableDiv === null) {
					var data = JSON.parse(link.getAttribute("html-content"));
					var html = "<br><div id='stock-display-table' style='display:none;'><table class='seeking-table' style='background-color: #f8f8f8;border-collapse:collapse;border: 1px solid #CCC;width:1000px;margin:0 auto;padding:0px;'>";
					for(var i=1;i<=5;i++) {
						html = html+"<tr><td style='border-bottom: 1px solid #CCC;'><a style='color:blue;text-decoration:none;' target='_blank' href='"+data[i].link[0]+"'>"+data[i].title[0]+"</a> &emsp;Publicated Time"+data[i].pubDate+"</td></tr>";
					}
					html = html + "</table></div>";
					var div = document.getElementById("toggle_div");
					div.insertAdjacentHTML('afterend', html);
				}
				if(link.getAttribute("toggle") === "show") {
					link.setAttribute("toggle","hide");
					document.getElementById("toggle_image").src="http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Up.png";
					link.innerText = "Click to hide stock news";
					document.getElementById('stock-display-table').style.display="";
				} else {
					link.setAttribute("toggle","show");
					document.getElementById("toggle_image").src="http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png";
					link.innerText = "Click to show stock news";
					document.getElementById('stock-display-table').style.display="none";
				}
			}
			function clearContent(){
				var el = document.getElementById("body");
				var html = "<form method='POST' class='main-form'><h2>Stock Search</h2><hr><table><tr><td>Enter Stock Ticker Symbol:*</td><td><input type='text' name='Symbol' value=''/></td></tr><tr><td></td><td><input class='button' type='submit' name='search' value='Search' /><input class='button' onclick='clearContent()' type='button' name='clear' value='Clear' style='margin-left: 5px;'/></td></tr></table><i>*- Mandatory fields.</i></form>";
				el.innerHTML = html;
			}
		</script>
	</head>
	<body id="body">
		<form method="POST" class="main-form">
			<h2>Stock Search</h2>
			<hr>
			<table>
				<tr>
					<td>
						Enter Stock Ticker Symbol:*
					</td>
					<td>
						<input type="text" name="Symbol" value="<?php echo isset($_POST['Symbol']) ? $_POST['Symbol'] : ''; ?>"/>	
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input class="button" type="submit" name="search" value="Search" />	
						<input class="button" type="button" name="clear" value="Clear" onclick="clearContent()" />	
					</td>
				</tr>
			</table>
			<i>*- Mandatory fields.</i>
		</form>
<?php
	function getStockDataQuery($symbol) {
		return "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$symbol."&apikey=85QVHJTGXCGUW2ZY";
	}

	function getIndicatorData($symbol, $indicator) {
		return "https://www.alphavantage.co/query?function=".$indicator."&symbol=".$symbol."&interval=weekly&time_period=10&series_type=open&apikey=85QVHJTGXCGUW2ZY"; 
	}

	function getSeekingAPI($symbol) {
		return "https://seekingalpha.com/api/sa/combined/".$symbol.".xml";
	}

	function getHttpResponse($query) {
		return file_get_contents($query);
	}

	function displayStockData($response, $symbol) {
		$json = json_decode($response,true);
		$firstEntry=array_slice($json['Time Series (Daily)'], 0,1);
		$firstKey=key($firstEntry);
		$secondEntry=array_slice($json['Time Series (Daily)'], 1,1);
		$secondKey=key($secondEntry);
		$close = $firstEntry[$firstKey]['4. close'];
		$open = $firstEntry[$firstKey]['1. open'];
		$prevOpen = $secondEntry[$secondKey]['1. open'];
		$prevClose = $secondEntry[$secondKey]['4. close'];
		$change = $close - $prevClose;
		if($change>=0) {
			$changeSrc="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png";
		} else {
			$changeSrc="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png";
		}
		$changePercentage = ($change/$prevClose)*100;
		$daysRange = $firstEntry[$firstKey]['3. low']."-".$firstEntry[$firstKey]['2. high'];
		$volume = number_format($firstEntry[$firstKey]['5. volume']);
		$timestamp = $firstKey;
		$symbol = isset($_POST['Symbol']) ? $_POST['Symbol'] : ''; 
		echo "<br><br><table class='stock-display'><tr><td>Stock Ticker Symbol</td><td>".$symbol."</td></tr><tr><td>Close</td><td>".$close."</td></tr><tr><td>Open</td><td>".$open."</td></tr><tr><td>Previous Close</td><td>".$prevClose."</td></tr><tr><td>Change</td><td>".round($change,4)."<img src='".$changeSrc."'/></td></tr><tr><td>Change Percent</td><td>".round($changePercentage,2)."%<img src='".$changeSrc."'/></td></tr><tr><td>Day's Range</td><td>".$daysRange."</td></tr><tr><td>Volume</td><td>".$volume."</td></tr><tr><td>Timestamp</td><td>".$timestamp."</td></tr><tr><td>Indicators</td><td><form method='POST'><ul><li><input class='button-link' type='submit' name='Price' value='Price'></li><li><a class='button-link' symbol='".$symbol."' indicator='SMA' onclick='loadXML(this)'>SMA </a></li><li><a class='button-link' symbol='".$symbol."' indicator='EMA' onclick='loadXML(this)'>EMA </a></li><li><a class='button-link' symbol='".$symbol."' indicator='STOCH' onclick='loadXML(this)'>STOCH </a></li><li><a class='button-link' symbol='".$symbol."' indicator='RSI' onclick='loadXML(this)'>RSI </a></li><li><a class='button-link' symbol='".$symbol."' indicator='ADX' onclick='loadXML(this)'>ADX </a></li><li><a class='button-link' symbol='".$symbol."' indicator='CCI' onclick='loadXML(this)'>CCI </a></li><li><a class='button-link' symbol='".$symbol."' indicator='BBANDS' onclick='loadXML(this)'>BBANDS </a></li><li><a class='button-link' symbol='".$symbol."' indicator='MACD' onclick='loadXML(this)'>MACD </a><input type='hidden' name='Symbol' value='".$symbol."'/></form></td></tr></table><br><div style='border: 1px solid #CCC;width:1000px;margin: 0 auto;' id='container'></div>";
	}

	function displaySeekingResponse($response) {
		$xml = new SimpleXMLElement($response);
		$index =0;
		$json = array();
		foreach($xml->channel[0]->item as $item) {
			$index++;
			$json[$index]['title'] =  $item->title;
			$json[$index]['link'] =  $item->link;
			$json[$index]['pubDate'] = date('D, d M Y H:i:s', strtotime($item->pubDate));
			if($index == 5) {
				break;
			}
		}
		echo "<br><div style='color:AAA;width:200px;margin:0 auto;cursor:pointer;' id='toggle_div'><a onclick='loadStockNews()' id='toggle_link' toggle='show' html-content='".json_encode($json,JSON_HEX_APOS)."'> Click here to show stock news</a><br><img onclick='loadStockNews()' id='toggle_image' style='width:30px;padding-left:75px' src='http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png'/></div>";
	}

	function displayPriceGraph($response) {
		$json = json_decode($response, true);
		$arrayKeys = array_keys($json['Time Series (Daily)']);
		$priceValue = array();
		$volumeValue = array();
		$keyValue = array();
		$count = 0;
		$index = 0;
		foreach($arrayKeys as &$key) {
			$keyValue[$index] = date("m/d", strtotime($key));
			$priceValue[$index] = round((float)$json['Time Series (Daily)'][$key]['4. close'],2);
			$volumeValue[$index] = intval($json['Time Series (Daily)'][$key]['5. volume']);
			$index++;
			$count++;
			if($count == 99) {
				break;
			}
		}
		$_POST['PriceKeys'] = array_reverse($keyValue);
		$_POST['PriceTitle'] = "Stock Price (".date("m/d/Y", strtotime($arrayKeys[0])).")";
		$_POST['VolumeValue'] = array_reverse($volumeValue);
		$_POST['PriceValue'] = array_reverse($priceValue);
	}

	function displayStock($indicator) {
		$symbol = $_POST['Symbol'];
		if($symbol == "") {
			$message = "Please Enter a Symbol";
			echo "<script type='text/javascript'>alert('$message');</script>";
		} else {
			$stockResponse = getHttpResponse(getStockDataQuery($symbol));
			$json = json_decode($stockResponse, true);
			if(isset($json['Error Message'])) {
				echo "<br><br><table class='stock-display'><tr><td>Error</td><td>Error:NO record has been found. Please enter a valid symbol.</td></tr></table>";
				return;
			} else {
			displayStockData($stockResponse, $symbol);
			displayPriceGraph($stockResponse);	
			$seekingResponse = getHttpResponse(getSeekingAPI($symbol));
			displaySeekingResponse($seekingResponse);
		}
		}
	}

	if(isset($_POST['search'])) {
		displayStock("Price");
	}

	if(isset($_POST['Price'])) {
		displayStock("Price");
	}

?>
		<script type="text/javascript">
		<?php if (isset($_POST['PriceKeys'])) : ?>
			Highcharts.chart('container', {
			    chart: {
			        zoomType: 'xy'
			    },
			    title: {
			        text: '<?php echo $_POST["PriceTitle"]; ?>'
			    },
			    subtitle: {
			        text: '<a style="color:blue;" href=" https://www.alphavantage.co/" target="_blank">Source: Alpha Vantage</a>'
			    },
			    xAxis: [{
			        categories: <?php echo json_encode($_POST['PriceKeys'], true); ?>,
			        tickInterval: 5,
			        labels: {
			            style: {
			                fontSize: '8px'
			            }
			        }
			    }],
			    yAxis: [{ // Primary yAxis
			        labels: {
			            format: '{value}',
			        },
			        title: {
			            text: 'Stock Price',
			        },
			    }, { // Secondary yAxis
			        title: {
			            text: 'Volume',
			        },
			        opposite: true
			    }],
			    legend: {
			       layout: 'vertical',
			        align: 'right',
			        verticalAlign: 'middle'
			    },
			    plotOptions: {
			            series: {
			                pointPadding: 0,
			                groupPadding: 0.5,
			            },
		            	area: {
			                fillColor: {
			                    linearGradient: {
			                        x1: 0,
			                        y1: 0,
			                        x2: 0,
			                        y2: 1
			                    },
			                    stops: [
			                        [0, Highcharts.getOptions().colors[8]],
			                        [1, Highcharts.Color(Highcharts.getOptions().colors[8]).setOpacity(0).get('rgba')]
			                    ]
			                },
		        		},
		        		column : {
		        			 borderColor: 'red'
		        		}
			    },
			    series: [{
			        name: '<?php echo $_POST["Symbol"]; ?>',
			        type: 'area',
			        color: 'red',
			        data: <?php echo json_encode($_POST['PriceValue'], true); ?>,
			        tooltip: {
			            valueSuffix: ''
			        }
			    },
			    {
			        name: '<?php echo $_POST["Symbol"]; ?>'+' Volume',
			        type: 'column',
			        color: 'white',
			        yAxis: 1,
			        data: <?php echo json_encode($_POST['VolumeValue'], true); ?>,
			        tooltip: {
			            valueSuffix: ' M'
			        }

			    }]
			});
		<?php endif; ?>
		function HighChartLine(Symbol,LineTitle,LineText,LineKeys,LineValues){
			Highcharts.chart('container', {

			    title: {
			        text: LineTitle
			    },

			    subtitle: {
			        text: '<a style="color:blue;" href=" https://www.alphavantage.co/">Source: Alpha Vantage</a>'
			    },

			    yAxis: {
			        title: {
			            text: LineText
			        }
			    },
			    legend: {
			        layout: 'vertical',
			        align: 'right',
			        verticalAlign: 'middle'
			    },
			    xAxis: {
			        categories: LineKeys,
			        tickInterval:5,
			        labels: {
			            style: {
			                fontSize: '8px'
			            }
			        }
			    },
			    plotOptions: {
			        series: {
			            marker: {
			                enabled: true
			            }
			        }
			    },

			    series: [{
			        name: Symbol,
			        data: LineValues,
			        type: 'line'
			    }],

			    responsive: {
			        rules: [{
			            condition: {
			                maxWidth: 500
			            },
			            chartOptions: {
			                legend: {
			                    layout: 'horizontal',
			                    align: 'center',
			                    verticalAlign: 'bottom'
			                }
			            }
			        }]
			    }

			});
		}
		function HighChartLine2(Line2Title,Line2Text,Line2Keys,Line2Text1, Line2Values1, Line2Text2, Line2Values2){
			Highcharts.chart('container', {
			    title: {
			        text: Line2Title
			    },
			    subtitle: {
			        text: '<a style="color:blue;" href=" https://www.alphavantage.co/">Source: Alpha Vantage</a>'
			    },

			    yAxis: {
			        title: {
			            text: Line2Text
			        }
			    },
			    legend: {
			        layout: 'vertical',
			        align: 'right',
			        verticalAlign: 'middle'
			    },
			    xAxis: {
			        categories: Line2Keys,
			        tickInterval:5,
			        labels: {
			            style: {
			                fontSize: '7px'
			            }
			        },
			    },
			    plotOptions: {
			        series: {
			            marker: {
			                enabled: true
			            }
			        }
			    },

			    series: [{
			        name: Line2Text1,
			        data: Line2Values1,
			        type: 'line'
			    },{
			        name: Line2Text2,
			        data: Line2Values2,
			        type: 'line'
			    }],

			    responsive: {
			        rules: [{
			            condition: {
			                maxWidth: 500
			            },
			            chartOptions: {
			                legend: {
			                    layout: 'horizontal',
			                    align: 'center',
			                    verticalAlign: 'bottom'
			                }
			            }
			        }]
			    }

			});
		}
		function HighChartLine3(Line3Title,Line3Text,Line3Keys,Line3Text1, Line3Values1, Line3Text2, Line3Values2, Line3Text3, Line3Values3){
			Highcharts.chart('container', {
			    title: {
			        text: Line3Title
			    },
			    subtitle: {
			        text: '<a style="color:blue;" href=" https://www.alphavantage.co/">Source: Alpha Vantage</a>'
			    },

			    yAxis: {
			        title: {
			            text: Line3Text
			        }
			    },
			    legend: {
			        layout: 'vertical',
			        align: 'right',
			        verticalAlign: 'middle'
			    },
			    xAxis: {
			        categories: Line3Keys,
			   	 	tickInterval:5,
			        labels: {
			            style: {
			                fontSize: '6.5px'
			            }
			        },
			    },
			    plotOptions: {
			        series: {
			            marker: {
			                enabled: true
			            }
			        }
			    },

			    series: [{
			        name: Line3Text1,
			        data: Line3Values1,
			    },{
			        name: Line3Text2,
			        data: Line3Values2,
			    },{
			        name: Line3Text3,
			        data: Line3Values3,
			    }],

			    responsive: {
			        rules: [{
			            condition: {
			                maxWidth: 700
			            },
			            chartOptions: {
			                legend: {
			                    layout: 'horizontal',
			                    align: 'center',
			                    verticalAlign: 'bottom'
			                }
			            }
			        }]
			    }

			});
		}
		</script>
	</body>
</html>
