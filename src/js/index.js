$('#logoutBtn').on('click', function() {
	$.ajax({
	    cache: false,
	    type: "POST",
	    url: "/logout",
	    success: function(json) {
	    	window.location.href = "/login";
	    },
	    error: function(xhr, status, error) {
	    	alert(xhr.responseText);
	    }
	  });
});