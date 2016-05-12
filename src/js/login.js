let $loginForm = $("#form-login");
let $usernameInput = $("#username");
let $passwordInput = $("#password");
let $rememberMe = $("#remember-me");
let $loginBtn = $("#login-btn"); 
let $loginFailedMsg = $("#login-failed");

$loginFailedMsg.hide();

// Keep form from submitting (refreshing)
$loginForm.on("submit", function() {
  return false;
});

$loginForm.keypress(function(e) {
	if (e.which == 13) {
		$loginBtn.click();
	}
});

$loginBtn.on("click", function() {
  resetLoginFailed();
  
  let username = $usernameInput.val();
  let password = $passwordInput.val();
  
  if (username.length == 0 || password.length == 0) {
    // No need to throw any errors, bootstrap handles validation
    // Just return
    return;
  }
  
  var data = {};
  data.username = username;
  data.password = password;
  data.client_id = "dummy";
  data.grant_type = "password";
  
  $.ajax({
    cache: false,
    type: "POST",
    data: data,
    url: "/login",
    success: function(json) {
      handleSuccess(json);
    },
    error: function(xhr, status, error) {
      handleError(xhr);
    }
  });
});

var handleSuccess = function(data) {
	window.location.href = "/routeForRole";
}

var handleError = function(xhr) {
  if (xhr.status == 401) {
    if (xhr.responseJSON.error_description != undefined) {
      showLoginFailed(xhr.responseJSON.error_description);
    }
  } else {
    alert(xhr.responseText);
  }
}

var shouldRememberLogin = function() {
  return $rememberMe.prop('checked');
}

var showLoginFailed = function(reason) {
  //$loginForm.css("padding", "32px 32px 16px 32px");
  $loginFailedMsg.text(reason);
  $loginFailedMsg.show();
}

var resetLoginFailed = function() {
  //$loginForm.css("padding", "32px");
  $loginFailedMsg.text("");
  $loginFailedMsg.hide();
}