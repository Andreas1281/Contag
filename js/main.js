
                         
                             
                            

                          




// Init
$(document).ready(function() {

	// Activate modal triggers
	$('.modal-trigger').leanModal();

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

  $('select').material_select();
});



function edit(id) {

	$.ajax({
                url: "./php/handle.php?id="+id,
                success: function(result){
                        var data = JSON.parse(result) || jQuery.parseJSON(result)
                        $("#results").empty();
                        for (var val in data) {
                                if ( val == "id" ) { continue; }
				$("#" + val).val(data[val]);
				$("#" + val).focus();
                }
            },
            error: function() { alert("Fehler"); }
        });


$('#modal_edit').openModal();
}




// Request shoptag
function request(id) {
            $.ajax({
                url: "./php/handle.php?id="+id, 
                success: function(result){
                        var data = JSON.parse(result) || jQuery.parseJSON(result)
                        $("#results").empty();
                        for (var val in data) {
                                if ( val == "id" ) { continue; }
                                $("#results").append("<td class='address_item'>" + data[val] + "</td>");
                }
            },
            error: function() { alert("Fehler"); }
        });
}

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
$("#address_data").submit(function() {
    $.ajax({
           type: "POST",
           url: "php/save.php",
           data: $("#address_data").serialize(),
           success: function(data)
           {
                if (data == 0) {  $('#modal_success').openModal(); }
                else {  $('#modal_error').openModal(); }
           },
	   error: function() { alert("Fehler"); }
         });

    return false;
});



