$(document).ready(function() {
	setEventHandlers();
	getCongressBudget();
});

var setEventHandlers = function() {
	$('#setBudgetBtn').on('click', setCongressBudget);
}

var getCongressBudget = function() {
	$.ajax({
	    cache: false,
	    type: "GET",
	    url: "/admin/getCongressBudget",
	    success: function(json) {
	      var budget = JSON.parse(json);
	      $('#budget').data('budgetId', budget.budgetId);
	      $('#budget').val(budget.budgetAmount);
	    },
	    error: function(xhr, status, error) {
	      alert(xhr.responseText);
	    }
	});
}

var setCongressBudget = function() {
	hideSuccessMessage();
	
	var data = {};
	data.budgetId = $('#budget').data('budgetId');
	data.budgetAmount = $('#budget').val();
	
	$.ajax({
	    cache: false,
	    type: "POST",
	    data: data,
	    url: "/admin/setCongressBudget",
	    success: function(json) {
	      var status = JSON.parse(json);
	      if (status.success) {
	    	  showSuccessMessage();
	      } else {
	    	  alert(status.reason);
	      }
	    },
	    error: function(xhr, status, error) {
	      alert(xhr.responseText);
	    }
	});
}

var hideSuccessMessage = function() {
	$('#successMsg').hide();
}

var showSuccessMessage = function() {
	$('#successMsg').show();
}