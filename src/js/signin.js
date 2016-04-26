let $signinForm = $(".form-signin");
let $usernameInput = $("#inputUsername");
let $passwordInput = $("#inputPassword");
let $formSigninRemember = $("#form-signin-remember");
let $signinBtn = $("#signin-btn"); 
let $signinFailedMsg = $("#signin-failed");

$signinFailedMsg.hide();

// Keep form from submitting (refreshing)
$signinForm.on("submit", function() {
  return false;
});

$signinBtn.on("click", function() {
  resetSigninFailed();
  
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
    url: "Controllers/LoginController.php",
    success: function(json) {
      handleSuccess(json);
    },
    error: function(xhr, status, error) {
      handleError(xhr);
    }
  });
});

var handleSuccess = function(data) {
  alert("OAuth Token: " + data.access_token);
  
  if (shouldRememberSignin()) {
    sessionStorage.clear();
    localStorage.setItem("oauth", JSON.stringify(data));
  } else {
    localStorage.clear();
    sessionStorage.setItem("oauth", JSON.stringify(data));
  }
}

var handleError = function(xhr) {
  if (xhr.status == 401) {
    if (xhr.responseJSON.error_description != undefined) {
      showSigninFailed(xhr.responseJSON.error_description);
    }
  } else {
    alert(xhr.responseText);
  }
}

var shouldRememberSignin = function() {
  return $formSigninRemember.prop('checked');
}

var showSigninFailed = function(reason) {
  $signinForm.css("padding", "32px 32px 16px 32px");
  $signinFailedMsg.text(reason);
  $signinFailedMsg.show();
}

var resetSigninFailed = function() {
  $signinForm.css("padding", "32px");
  $signinFailedMsg.text("");
  $signinFailedMsg.hide();
}