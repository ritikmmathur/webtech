var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var http = require('https');
var request = require('request');
var parseString = require('xml2js').parseString;

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

var port = process.env.PORT || 8081;   
app.listen(port);
console.log('Listening to port ' + port);

var router = express.Router();   

var request = require('request');

app.get('/', function(req, res){
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  res.send(200, { success: 'status ok' });
});

app.get('/symbol/:symbol/indicator/:indicator', function(req, res){
	var symbol = req.params.symbol;
	var indicator = req.params.indicator;
  var uri = 'https://www.alphavantage.co/query?function='+indicator+'&symbol='+symbol+'&interval=daily&time_period=10&series_type=open&apikey=85QVHJTGXCGUW2ZY';
	res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  request(uri, function (error, response, body) {
    if (!error && response.statusCode == 200) {
      res.send(body);
    } else {
    	res.send(500, { error: 'something went wrong. try again later' });
    }
  })
});

app.get('/symbol/:symbol', function(req, res){
	var symbol = req.params.symbol;
  var uri = 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol='+symbol+'&outputsize=full&apikey=85QVHJTGXCGUW2ZY';
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  request(uri, function (error, response, body) {
    if (!error && response.statusCode == 200) {
      res.send(body);
    } else {
    	res.send(500, { error: 'something went wrong. try again later' });
    }
  })
});

app.get('/news/:symbol', function(req, res){
	var symbol = req.params.symbol;
  var uri = 'https://seekingalpha.com/api/sa/combined/'+symbol+'.xml';
	res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  request(uri, function (error, response, body) {
    if (!error && response.statusCode == 200) {
      parseString(body, function (err, result) {
		 res.send(result);
		});
    } else {
    	res.send(500, { error: 'something went wrong. try again later' });
    }
  })
});

app.get('/list/:input', function(req, res){
	var input = req.params.input;
  var uri = 'http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input='+input;
	res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  request(uri, function (error, response, body) {
    if (!error && response.statusCode == 200) {
      res.send(body);
    } else {
    	res.send(500, { error: 'something went wrong. try again later' });
    }
  })
});

app.use('/news', router);
app.use('/symbol', router);
app.use('/list', router);
