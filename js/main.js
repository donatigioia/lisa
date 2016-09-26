/* ***************************************************************
                  EVENT CALLBACKS
*************************************************************** */
$("#loginForm").on('submit', function(event) {
			login(this) ;
		});

/* ***************************************************************
                     LOGIN & SIGNUP
*************************************************************** */

function login(form){ 
	var send=$(form).serializeObject();
	/*formContent.name=$("#username").val();
	formContent.pw=$("#pw").val();*/
	var url ='login.php';
	$.ajax({
		url: url,
		type: 'post',
		data: JSON.stringify(send),
		success: function(data) {
			var r=JSON.parse(data);
			if(r=="ok"){
				$("#loginError").hide();
				$("#username").val("");
				$("#pw").val("");
				window.open("FileList.php?user="+document.getElementById("username").value+"&msg=Upload your document!"+"&type=info");
			}
			else if(r=="not_exist"){
				$("#loginError").html("Wrong credentials. Try again.").show();
				$("#username").val("");
				$("#pw").val("");

			}
		},
		error: function(e,t,h) {
		}
	});	
}

/* ***************************************************************
   UTILITY
 *************************************************************** */

$.fn.serializeObject = function() {
		    var o = {};
		    var a = this.serializeArray();
		    $.each(a, function() {
			if (o[this.name] !== undefined) {
			    if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			    }
			    o[this.name].push(this.value || '');
			} else {
			    o[this.name] = this.value || '';
			}
		    });
		    return o;
		};