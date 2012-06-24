var timeAccuracyMinutes = 5;
var path;
$(function() {
	path = $("#path").val();
	
	init_contact_form();
	init_form();
	init_time();
	init_calendar();
	init_address_autocomplete();
	init_login();
	init_busyness();
	init_confirm_page();
	init_orderlist();
});

function init_contact_form() {
	$(".contact-form form").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		
		var post = {
			firstname:$("#firstname").val(),
			lastname:$("#lastname").val(),
			email:$("#email").val(),
			extra:$("#extra").val()
		};
		
		if(post.firstname.length==0) {
			alert("Įrašykite savo vardą"); return false;
		}
		if(post.lastname.length==0) {
			alert("Įrašykite savo pavardę"); return false;
		}
		if(!validateEmail(post.email)) {
			alert("Įveskite gerą el. pašto adresą, kad galėtume su jumis susiekti."); return false;
		}
		
		$.post(path+"siusti?ajax", post, function(r) {
			form.hide(250);
			$("#contact-thankyou").show(250);
			
		});
	});
}
function validateEmail(email) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
    if( email!=undefined && email!="" && emailPattern.test(email) ) {
        return true;
    } else {
        return false;
    }
}
function init_orderlist() {
	$("#orders").on("click", ".buttons a", function(e) {
		e.preventDefault();
		
		$.post(
			path+"uzsakymai?ajax",
			{ status: this.name, id: $(this).closest("li").data("id") },
			function(response) {
				$("#orders").html(response);
			}
		);
	});  
}

function init_confirm_page() {
	$("#addressField").change(function() {
		$("#addressClone").text(this.value);
	});
}

function init_busyness() {
	var b = $("#busyness");
	if(b.length == 0) return false;
	var h24 = b.find(".empty:first").width();
	var h1 = h24/24;
	var m1 = h1/60;
	var width = 30*m1;
	
	b.find(".day").each(function() {
		var day = $(this);
		var space = day.find(".empty");
		day.find('.ordered').each(function() {
			var val = this.value;
			var hours = parseInt( val.slice(11,13) );
			var mins = parseInt( val.slice(14,16) );
			var date = new Date(val);
			var left =  hours*h1 + mins*m1;
			space.append('<div class="full" style="left:'+left+'px;width:'+width+'px;"></div>');
		});
		space.click(function(e) {
			console.log(e);
			var x = e.pageX - $(this).offset().left;
			var hours = Math.ceil( x / h1 )-1;
			var minutes = Math.round( (x % h1) / m1 );
			$("#timeField").val(leadZeros(hours) +":"+ leadZeros(minutes)).blur();
			//console.log(x, hours, minutes);
		});
	});
}

function init_form() {
	$("#theform").submit(function(e) {
		var error = null;
		var form = $(this);
		form.find("input[type='text']:not(.empty)").each(function() {
			var field = $(this); var val = field.val();
			if(val=="" || val==field.attr("title")) { error = field; return false; }  
		});
		var psw = " ";
		form.find("input[type='password']:not(.empty)").each(function() {
			if(psw==" ") {
				psw = this.value;
			} else if(psw != this.value) {
				error = $(this); psw = ""; 
			}  
		});
		if(error!=null) {
			alert(psw == "" ? "Slaptažodžiai privalo sutapti" : "Nepalikite neužpildytų laukų!");
			error.focus();
			e.preventDefault();
		} else if(form.hasClass("unregistered")) {
			alert("Rezervacija tik registruotiems lankytojams.");
			e.preventDefault();
		}
	});
}

function init_time() {
	var time = $("#timeField");
	var timeTitle = time.attr("title");
	time.focus(function() {
		var self = $(this);
		if(self.val() == timeTitle) {
			self.val("");
		} 
	});
	time.blur(function() {
		var self = $(this);
		var val = self.val();
		if(val == "") {
			self.val(timeTitle);
		} else {
			//console.log( d );
			//if(val.indexOf(':')==-1) val = val.substr(0,2) + ":" + val.substr(2);
			var time = val.match(/(\d+)(?::(\d\d))?\s*(p?)/) || [0,0,0];
			var hours = parseInt(time[1]) + (time[3] ? 12 : 0);
			var minutes = parseInt(time[2]) || 0;
			minutes = Math.round(minutes / timeAccuracyMinutes) * timeAccuracyMinutes;
			var d = new Date();
			d.setHours(hours);
			d.setMinutes(minutes);
			var timeStr = leadZeros(d.getHours())+":"+leadZeros(d.getMinutes());		
			
			// less than 20 minutes from now can't reserve
			var now = new Date();
			var letThrough = Math.round(now.getTime()/1000)+ 20 * 60;
			var setTo = $("#dateField").datepicker( "getDate" );//" "+timeStr;
			setTo.setHours(hours); setTo.setMinutes(minutes);
			var setToTS = setTo.getTime()/1000;//Date.parse( setTo ); 
			
			if( setToTS  < letThrough ) {
				now.setTime(letThrough*1000);
				timeStr = leadZeros(now.getHours())+":"+leadZeros(now.getMinutes())
				var dateStr = now.getFullYear()+"-"+leadZeros(d.getMonth())+"-"+leadZeros(d.getDate());
				$("#dateField").datepicker( 'setDate', dateStr );
				d = now;
				self.val( timeStr );
			} else {
				self.val( timeStr );
			}
			
			self.data("hours", d.getHours());
			self.data("minutes", d.getMinutes());
		}
	});
	
	// jeigu veiksmas vyksta tituliniame
	var titularDiv = $(".select-time");
	if(titularDiv.length > 0) {
		var timeClone = $("#timeFieldClone");
		
		var sliderHours = titularDiv.find(".slider.hours");
		var textHours = titularDiv.find(".text.hours span");
		var sliderMinutes = titularDiv.find(".slider.minutes");
		var textMinutes = titularDiv.find(".text.minutes span");
		sliderChangeCallback = function(hours, minutes) {
			if(hours==undefined)
				hours = sliderHours.slider("value");
			if(isNaN(hours)) hours = 12;
			if(minutes==undefined)
				minutes = sliderMinutes.slider("value");
			if(isNaN(minutes)) minutes = 0;
			var timeStr = leadZeros(hours) +  ":" + leadZeros(minutes);
			time.val(timeStr);
		};
		sliderHours.slider({
			value:12,
			min: 0,
			max: 23,
			step: 1,
			slide: function( event, ui ) {
				//textHours.html(ui.value);
				//sliderChangeCallback(ui.value, null);
			}
		});
		sliderMinutes.slider({ 
			value: 0,
			min: 0,
			max: 55,
			step: 5,
			slide: function( event, ui ) {
				//textMinutes.html(ui.value);
				//sliderChangeCallback(null, ui.value);
			}
		});
		
		
		time.blur(function() {
			timeClone.val(time.val());
			sliderHours.slider("value", time.data("hours"));
			sliderMinutes.slider("value", time.data("minutes"));
		});
		timeClone.focus(function() {
			titularDiv.show(300);
			time.focus();
		});
		
		//$( "#amount" ).val( "$" + $( "#slider" ).slider( "value" ) );
		
		
		time.focus(function(e) {
			console.log("timeField focus event", e);
			if(titularDiv.hasClass("inactive")) {
				titularDiv.switchClass( "inactive", "active", 1000 );
			}
		});
		titularDiv.focus(function(e) {
			console.log("titularDiv focus event", e);
		})
		
	}
}
function leadZeros(num) {
	var s = "0" + num;
	return s.substr(-2);
}

function init_calendar() {
	var date = $("#dateField"); 
	date.datepicker({
		dateFormat:"yy-mm-dd",
		minDate:0, maxDate: "+1M",
        firstDay: 1,
        dayNamesMin: ["Se", "Pr", "An", "Tr", "Ke", "Pe", "Še"],
        monthNames: ["Sausis", "Vasaris", "Kovas", "Balandis", "Gegužė", "Birželis", "Liepa", "Rugpjūtis", "Rugsėjis", "Spalis", "Lapkritis", "Gruodis"]		
	});
	$(".calendarIcon").click(function(e) {
		e.preventDefault();
		$(this).prevAll('.date').datepicker("show");
	});
}

function init_address_autocomplete() {
	$('.place').each(function() {
		var addr = $(this);
		var addrTitle = addr.attr("title");
		if(addr.val().length==0)
			addr.val(addrTitle);
		addr.focus(function() {
			var self = $(this);
			if(self.val() == addrTitle) self.val("");
		});
		addr.blur(function() {
			var self = $(this);
			var val = self.val();
			if(val == "") {
				self.val(addrTitle);
			}
		});	
	});
}

function init_address_autocomplete_test() {
	
	 /*var input = document.getElementById('addressField');
     var autocomplete = new google.maps.places.Autocomplete(input);
     
	//var geocoder = new google.maps.Geocoder();
     google.maps.event.addListener(autocomplete, 'place_changed', function() {
         infowindow.close();
         var place = autocomplete.getPlace();

         var address = '';
         if (place.address_components) {
           address = [(place.address_components[0] &&
                       place.address_components[0].short_name || ''),
                      (place.address_components[1] &&
                       place.address_components[1].short_name || ''),
                      (place.address_components[2] &&
                       place.address_components[2].short_name || '')
                     ].join(' ');
         }*/
         
	var addrField = $("#addressField");
     addrField.autocomplete({
    	 source: function (request, response) {

		 		var params = {
		 				sensor:"false",
		 				input:"Lithuania, Vilnius, "+request.term,
		 				//key:"AIzaSyDjcgzVUoELtCUj7FtAPVZxtJqut_Orheg",
		 				types:"geocode",
		 				language:"lt"
				};
				var url = path + "grouter.php";
				$.getJSON(url,
						params, function(response) {
					console.log(response);
					var results = response.predictions;
					response($.map(results, function(result) {
			      		return result.terms[0].value;
			      	}));
				});
    		 /*$.ajax({
                 url: "http://dev.virtualearth.net/REST/v1/Locations",
                 dataType: "jsonp",
                 data: {
                     key: "AkBNpMAyzHVa_ZtbxS7yCrs-B-MtBf_ddVJqmmFD5cgDMUJY_bWPhJmEdeVtu1iG",
                     include: "queryParse",
                     maxResults: 8,
                     q: /*"Lithuania, Vilnius, " + /request.term
                 },
                 jsonp: "jsonp",
                 success: function (data) {
                     var result = data.resourceSets[0];
                     if (result) {
                         if (result.estimatedTotal > 0) {
                             response($.map(result.resources, function (item) {
                                 return {
                                     data: item,
                                     label: item.name + ' (' + item.address.countryRegion + ')',
                                     value: item.name
                                 }
                             }));
                         } else response(null);
                     }
                 }*/
    	 },
	     select: function (event, ui) {
	         var parts = ui.item.label;
	         
	         addrField.val(parts);
	         console.log(ui);
	         /*split(",")
	             , address1 = parts[0]
	             , address2 = parts.slice(1).join(",").trim();
	         $("#postal").val(address1 + "\n" + address2);*/
	     }
     });
     
     
     /*var options = {
  	address: 'Vilnius '+request.term,
  	//latLng: new google.maps.LatLng(54.697513, 25.242399),
  	bounds:new google.maps.LatLngBounds(
  		    new google.maps.LatLng(54.819506, 25.035757),
  		    new google.maps.LatLng(54.570694, 25.470060)
  		),
		region:"lt"
	};
	
  geocoder.geocode(options, function (results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
      	response($.map(results, function(result) {
      		if ($.inArray("street_address", result.types) >= 0) {
      			return result.formatted_address;
      		}
      	}));
      }
  });*/
}        	 

function init_login() {
	var name = $( "#name" ),
		email = $( "#email" ),
		password = $( "#password" ),
		allFields = $( [] ).add( name ).add( email ).add( password ),
		tips = $( ".validateTips" );

	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

	function checkLength( o, n, min, max, msg ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Length of " + n + " must be between " +
				min + " and " + max + "." );
			return false;
		} else {
			return true;
		}
	}

	function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
	}
	
	$( "#login-form" ).dialog({
		autoOpen: false,
		height: 250,
		width: 260,
		modal: true,
		buttons: {
			"Prisijungti": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );

				//bValid = bValid && checkLength( email, "email", 6, 80, "Blogai įvestas el. pašto adresas." );
				//bValid = bValid && checkLength( password, "password", 2, 50 );

				// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
				bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Blogai įvestas el. pašto adresas." );
				//bValid = bValid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

				if ( bValid ) {
					$.post(path+"login", { email: email.val(), password:password.val() }, function(response) {
						if(response=="1") {
							location.reload();
						} else {
							updateTips("Blogas el. pašto adresas ir/arba slaptažodžis.");
						} 
					});
				}
			},
			"Atšaukti": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});

	$("#login").click(function(e) { e.preventDefault();
		$( "#login-form" ).dialog( "open" );
	});
}