
// Init
function init() {


	// Activate modal triggers
	$('.modal-trigger').leanModal();

	trigger_init();

	// Awesome select stuff and shit
	$('select').material_select();

	// Dropdown fun
	$('.dropdown-button').dropdown({
      		inDuration: 300,
      		outDuration: 225,
      		constrain_width: false, // Does not change width of dropdown to that of the activator
      		hover: false, // Activate on click
      		alignment: 'left', // Aligns dropdown to left or right edge (works with constrain_width)
      		gutter: 0, // Spacing from edge
      		belowOrigin: false // Displays dropdown below the button
    	});
}

$(document).ready(function() { init(); console.log("Init finished"); });

// Login 
function login() {
	$.ajax({
                url: "./php/login.php",
                success: function(result) { console.log("Response: "+result); location.reload(); },
                error: function() { alert("Error: Server did not respond."); }
        });
}

// Logout
function logout() {

        $.ajax({
                url: "./php/logout.php",
                success: function(result){ console.log("Response: "+result); location.reload(); },
                error: function() { alert("Error: Server did not respond."); }
        });
}

// Load Page
function load(page) {

	$.ajax({
		url: "./php/page.php?p="+page,
                success: function(result){
                        $("#main_content").empty();
			$("#main_content").html(result);
			$('ul.tabs').tabs();
			init();
            	},
            	error: function() { alert("Error: Server did not respond."); }
	});
}

// Load form
function load_form(id,locale) {

        $.ajax({
                url: "./php/forms.php?locale="+locale,
                success: function(form_html){
                       	$("#"+id).html(form_html);
            	},
            	error: function() { alert("Fehler"); }
        });

}

// Update form
function update_form(language,country,form) {

        language = $("#"+language).val();
        country = $("#"+country).val();
        if (!language || !country) return;
        load_form(form,language+"_"+country);
}

// Update select country
function update_country_select(language,country,form) {

	$("#"+country).removeClass("hidden");
	language = $("#"+language).val();
	country_options = $("#"+country+"_"+language).html();
	$("#"+country).html(country_options);

	// Load default country form
	//country_default = $("#"+country+"_"+language).children().eq(1).val();
	//load_form(form,language+"_"+country_default);
}

// Clear form
function clear_form(form) {

	$("#"+form)[0].reset();
	$("#"+form+" input").each(function() {
		// Materialize lable bug workaround
		$(this).focus();
		$(this).blur();
	});
}

// Init triggers for copy buttons
function copy_init() {

	$(".copy").each(function() {

		var client = new ZeroClipboard(this);
		client.on("ready", function(readyEvent) {
  			client.on("aftercopy", function(event) {
    				alert("Copied Contag to clipboard: " + event.data["text/plain"]);
  			});
		});
	});
}

// Get embed code
function embed(id) {
	$("#modal_embed").openModal();
	$("#embed_code").val("<iframe src=\"http://contag.de/?id=" + id + "\"></iframe>");
}


// Edit: Show
function edit_list(hash) {
	$.ajax({
                url: "./php/handle.php?hash="+hash,
                success: function(result){
                        var data = JSON.parse(result) || jQuery.parseJSON(result)
                        for (var val in data) {
				$("#edit_" + val).val(data[val]);
                	}

			// Make labels behave like any sane label would
			$("#edit_form label").each( function() { $(this).addClass("active");});

			$('#modal_edit').openModal();
            	},
            	error: function() { alert("Fehler"); }
        });
}

// Retrieve shoptag
function request(id) {
            $.ajax({
                url: "./php/handle.php?hash="+id,
                success: function(result){
                        var data = JSON.parse(result) || jQuery.parseJSON(result)
                        $("#results").empty();
                        $("#result_info").show();
                        for (var val in data) {
                                if ( val == "id" ) { continue; }
                                $("#results").append("<td class='address_item'>" + data[val] + "</td>");
                }
            },
            error: function() { alert("Fehler"); }
        });
}

function trigger_init() {

// Edit: Save
$("#edit_form").submit(function() {
    console.log("#edit_form submitted");
    $.ajax({
           type: "POST",
           url: "php/edit.php",
           data: $("#edit_form").serialize(),
	   success: function(data) {
		console.log("Status: "+ data);
		$("#modal_edit").hide();
                if (data == 0) {  $('#modal_success').openModal(); }
                else {  $('#modal_error').openModal(); }
           },
	   error: function() { alert("Fehler"); }
    });

    return false;
});

// Shoptag: Admin
$("#shoptag_admin").on("click",function() {

	$.ajax({url: "./php/list.php", 
                success: function(response){
                  $("#test2").html(response);
            },
            error: function() { alert("Fehler"); }
        });
});

// Shoptag: Save
$("#address_form").submit(function() {

    $.ajax({
           type: "POST",
           url: "php/save.php",
           data: $("#address_form").serialize(),
           success: function(data)
           {
                if (data != 0) {  
			$('#modal_success').openModal(); 
			clear_form("address_form");
 	   }
                else {  $('#modal_error').openModal(); }
           },
	   error: function() { alert("Fehler"); }
         });

    return false;
});

}


   

      function DropDown(el) {
        this.dd = el;
        this.initEvents();
      }
      DropDown.prototype = {
        initEvents : function() {
          var obj = this;

          obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            event.stopPropagation();
          }); 
        }
      }

      $(function() {

        var dd = new DropDown( $('#dd') );

        $(document).click(function() {
          // all dropdowns
          $('.wrapper-dropdown-5').removeClass('active');
        });

      });

 
