	//HTTPS handler
var httpsMode = "enable"; // enable or disable     

//If httpsMode is enable this two variable values are mandatory*, unless leave it
var sslServerKeyFile = '/etc/letsencrypt/live/airfinchscript.com/privkey.pem'; //Full path of the Server SSL Key file in server
var sslServerCrtFile = '/etc/letsencrypt/live/airfinchscript.com/cert.pem'; //Full path of the Server SSL Crt file in server
var sslBundleServerCrtFile = '/etc/letsencrypt/live/airfinchscript.com/fullchain.pem'; //Full path of the Server SSL Crt file in server


var socket = require('socket.io');  
var express = require('express');

if(httpsMode == "disable"){
	var http = require( 'http' );

	var app = express();
	var server = http.createServer( app );
}else{
	var https = require('https');
	var fs = require('fs');

	var httpsOptions = {
		key: fs.readFileSync(sslServerKeyFile),
		cert: fs.readFileSync(sslServerCrtFile),
		ca: fs.readFileSync(sslBundleServerCrtFile) 
	};

	var app = express();

	var server = https.createServer(httpsOptions, app);
}

var io = socket.listen(server);



io.sockets.on( 'connection', function( client ) { 
	console.log( "New client !" );
	
	client.on( 'message', function( data ) {
		console.log( 'inquiry ' + data.inquiryId + 'receiver ' + data.receiverId + " sender :" +data.senderId + " message :" +data.message +" Listing :"+data.listingId );
		
		//io.sockets.emit( 'message', { receiver: data.receiverId, sender: data.senderId, listing: data.listingId, message: data.message } );

		io.sockets.in('/normal/'+ data.inquiryId ).emit( 'message', { inquiry: data.inquiryId, receiver: data.receiverId, sender: data.senderId, listing: data.listingId, message: data.message } );
	});


	client.on( 'messageTyping', function( data ) {
		console.log(data.inquiryId + ' Message Typing received ' + data.senderId + ":" + data.receiverId + ":" + data.message+ ":" + data.listingId );
		//io.sockets.emit( 'messageTyping', { receiver: data.receiverId, sender: data.senderId, message: data.message, listing: data.listingId } );
		io.sockets.in('/normal/'+ data.inquiryId ).emit( 'messageTyping', { receiver: data.receiverId, sender: data.senderId, listing: data.listingId, message: data.message } );
	}); 

	client.on( 'join', function( data ) {
		console.log( 'Message received ' + data.joinId );
		//var joinid = data.inquiryId;
		client.join('/normal/'+data.joinId); 
	});
	
});


//server.listen(8085); 
server.listen(8085, () => console.log('Socket is running...')); 
