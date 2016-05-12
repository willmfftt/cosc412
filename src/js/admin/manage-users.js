$(document).ready(function() {
	getUsersTable();
});

var setupUsersTable = function() {
	$('#usersTable').DataTable();
}

var setupEventHandlers = function() {
	$('#createNewUserBtn').on('click', createNewUser);
}

var getUsersTable = function() {
	$.ajax({
	    cache: false,
	    type: "GET",
	    url: "/admin/getUsersTable",
	    success: function(html) {
	      $('#usersTable').append(html);
	      setupUsersTable();
	      setupEventHandlers();
	    },
	    error: function(xhr, status, error) {
	      alert(xhr.responseText);
	    }
	});
}

var createNewUser = function() {
	var firstname = $('#firstNameInput').val();
	var lastname = $('#lastNameInput').val();
	var emailAddress = $('#emailAddressInput').val();
	var username = $('#usernameInput').val();
	var password = $('#passwordInput').val();
	var passwordConf = $('#passwordConfInput').val();
	var role = $('#accountTypeSelect').val();
	
	if (validateCreateNewUser(firstname, lastname, emailAddress
			, username, password, passwordConf, role)) {
		var data = {};
		data.firstname = firstname;
		data.lastname = lastname;
		data.emailAddress = emailAddress;
		data.username = username;
		data.password = password;
		data.role = role;
		
		$.ajax({
		    cache: false,
		    type: "POST",
		    data: data,
		    url: "/admin/createNewUser",
		    success: function(json) {
		    	var result = JSON.parse(json);
		      if (result.success) {	
			      location.reload();
		      } else {
		    	  // Show error
		      }
		    },
		    error: function(xhr, status, error) {
		      alert(xhr.responseText);
		    }
		});
	} else {
		// Show error
	}
}

var validateCreateNewUser = function(firstname, lastname, emailAddress
		, username, password, passwordConf, role) {
	var valid = true;
	
	if (firstname == undefined 
			|| lastname == undefined 
			|| username == undefined
			|| role == undefined) {
		valid = false;
	}
	
	if (!validateEmail(emailAddress)) {
		valid = false;
	}
	
	if (password != undefined && passwordConf != undefined) {
		if (password !== passwordConf) {
			valid = false;
		}
	} else {
		valid = false;
	}
	
	return valid;
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}