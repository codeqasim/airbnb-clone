//To use nodejs with http enable the below line by removing the // at the start of the line
var socket = io.connect('https://airfinchscript.com:8085');      

//To use nodejs with http command the below line by adding a // at the start of the line
//var socket = io.connect('https://airfinchscript.com:8085', {secure: true});    

var typingTrack = 0;
var timerId;
var livenotifytimer;

$(document).on('keypress', '#contactmessage', function(e) {
	
	var keycode = e.keyCode;
	var keyPress = e;
	var message = $('#contactmessage').val();
	var messageLength = message.length;
	

	if(typingTrack == 0 && keycode != 13 && messageLength < 500){
		var senderId = $('#userid').val();
		var receiverId = $('#hostid').val();
		var listingId = $('#listingid').val();
		var inquiryId = $('#inquiryid').val();
		
		socket.emit('messageTyping', {
			senderId : senderId,
			receiverId: receiverId,
			listingId: listingId,
			inquiryId: inquiryId,
			message : "type"
		});	
		typingTrack = 1;
	}
	
	
	if (keycode == 13) {
		sendMessage();
		return false;
	}

	if (typeof timerId != 'undefined'){
		clearInterval(timerId);
	}

	timerId = setInterval(function() {
		typingTrack = 0;
		var senderId = $('#userid').val();
		var receiverId = $('#hostid').val();
		var listingId = $('#listingid').val();
		var inquiryId = $('#inquiryid').val();
		
		socket.emit('messageTyping', {
			senderId : senderId,
			receiverId: receiverId,
			listingId: listingId,
			inquiryId: inquiryId,
			message : "untype"
		});
		
		clearInterval(timerId);
	},1000);
});

$(document).on('click', ".sendbtn", function() {
	sendMessage();
	return false;
});



socket.on('message', function(data) {	
	var receiverid = $("#userid").val();
	if(receiverid == $.trim(data.receiver)) {   
	    $.ajax({
			url : baseurl + '/user/messages/updatemessage',
			type : "POST",
			data : {
				senderid : data.sender,
				receiverid : data.receiver,
				listingid: data.listing,
				inquiryid: data.inquiry,
				message: data.message,
			},
			success : function(datas) {
				if(datas!="failed") {
					datas = JSON.parse(datas);
					var newMsgContent = constructData('right', datas, 'message');// data.message;
		    		var appendlabel = ".msgbox-"+data.listing+"-"+data.receiver+"-"+data.sender;
		    		$(appendlabel).prepend(newMsgContent);
		    	} 
			}
		});
	}   
});

socket.on('messageTyping', function(data) {
	var accessId = ".live-messages-typing-"+data.listing+"-"+data.receiver+"-"+data.sender;
	var receivingSource = $('#receiverid').val();
	//console.log("Type message: "+data.message+" receiverId: "+data.receiver);
	
	if (data.message == "untype")
		$(accessId).css('opacity',"0");
	else
		$(accessId).css('opacity',"1");
	
});



function constructData(align, data, type) {
	//console.log(data);
	var outputData;
	if(align=='left')
	{
		outputData='<div class="claimleft"><div class="airfcfx-claimleftimgdiv claimleftimgdiv"><span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('+data.userImg+');"></span></div><div class="airfcfx-claimrighttextdiv claimrighttextdiv"><span class="airfcfx-left-chat-arrow"></span><a href="'+data.profileURL+'">'+data.userName+'</a><span class="airfcfx-message-date padleft">'+data.date+'</span><br/><span class="mobmsgalgn">'+data.newMessage+'</span></div></div><div class="clear"></div>';		
		
	}
	if(align=='right')
	{
		outputData='<div class="claimright"><div class="claimdiv"><div class="airfcfx-claimrightimgdiv claimrightimgdiv"><span class="airfcfx-user-icon profile_pict inlinedisplay" style="background-image:url('+data.userImg+');"></span></div><div class="airfcfx-claimlefttextdiv claimlefttextdiv"><span class="airfcfx-right-chat-arrow"></span><span class="airfcfx-message-date padright">'+data.date+'</span><a href="'+data.profileURL+'">'+data.userName+'</a><br /><span class="mobmsgalgn">'+data.newMessage+'</span></div></div></div><div class="clear"></div>';		
	}
	return outputData;


}



function sendMessage() {
	//alert("send btn click");
	senderid = $("#userid").val();
	receiverid = $("#hostid").val();
	messages = $("#contactmessage").val();
	listingid = $("#listingid").val();
	inquiryid = $('#inquiryid').val();
	
	$("#send_msg").attr('data-dismiss','');
	if($.trim(messages) == ""){
		$(".msgerrcls").show();
		$(".msgerrcls").html("Enter Contact Message");
		$("#contactmessage").keydown(function(){
			$(".msgerrcls").hide();
			$(".msgerrcls").html("");
		});
		return false;
	} 

	if($.trim(messages).length > 500)  {
        $(".msgerrcls").show();
        $(".msgerrcls").html("Message should have maximum of 500 characters");
                $("#contactmessage").keydown(function(){
                        $(".msgerrcls").fadeOut('slow');
                            $(".msgerrcls").html("");
                });
        return false; 
   }    
	
	$.ajax({
		type : 'POST',
		url : baseurl + '/user/messages/sendmessage',
		async: false,
		data : {
			senderid : senderid,
			receiverid : receiverid,
			messages : messages,
			listingid : listingid,
			inquiryid: inquiryid
		},
		beforeSend: function() {
			$("#loadingimg").show();
		},          
		success : function(data) { 
			if($.trim(data) == "0") {
				$("#contactmessage").val(""); 
				$(".msgerrcls").show();
				$(".msgerrcls").html("Message not send, Try again.");
				$("#contactmessage").keydown(function(){
					$(".msgerrcls").hide();
					$(".msgerrcls").html("");
				});
				return false;
			} else {
				data = JSON.parse(data);
				var appendData = constructData('left', data, 'message');
				
				socket.emit('message', {
					receiverId : receiverid,
					senderId : senderid,
					listingId : listingid,
					message : data.newMessage,
					inquiryId: inquiryid
				}); 
				var appendlabel = ".msgbox-"+listingid+"-"+senderid+"-"+receiverid;
				$(appendlabel).prepend(appendData);
				
	        	$("#loadingimg").hide();
	        	$("#contactmessage").val("");
	        	$("#send_msg").attr('data-dismiss','modal');
	        }
        }
   });    

}

