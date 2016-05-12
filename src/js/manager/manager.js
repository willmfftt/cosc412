$(document).ready(function () {

    /*$("#viewTransaction_table").DataTable(
    {
        data: [[]],
        columns: [
            { title: "ID" },
            { title: "Requester" },
            { title: "Status" },
            { title: "Date" },
			{ title: "Amount"},
			{ title: "Actions"}

        ]
    }
   );*/

    $(document).on("click", ".navLink", navLink_click);
	getPAData();
	getTransactionData();
    $(".navTab").hide();
    $(".navTab").first().show();
});

function navLink_click()
{
    var i = $(this).parent().prevAll().length;
    $(".navTab").hide();
    $(".navTab").eq(i).show();
}

function populatePATable(d)
{
	dummyData_b = $.parseJSON(d)['results']
	console.log(dummyData_b);
	var theData = [];
	var i,j;
	for(i=0;i<dummyData_b.length;i++)
	{
		theData.push([]);
		for(var key in dummyData_b[i]['purchasingAgent'])
		{
			theData[theData.length-1].push(dummyData_b[i]['purchasingAgent'][key]);
		}
		theData[theData.length-1].push("<input type='button' value='test' />");
	}

    $("#viewPA_table").DataTable(
        {
            data: theData,
            columns: [
                { title: "ID" },
                { title: "Name" },
                { title: "Budget" },
                { title: "Actions"}

            ]
        }
       );
}


function populateTransactionTable(d)
{
	dummyData_b = $.parseJSON(d)['results']
	console.log(dummyData_b);
	var theData = [];
	var i,j;
	for(i=0;i<dummyData_b.length;i++)
	{
		theData.push([]);
		for(var key in dummyData_b[i]['transaction'])
		{
			theData[theData.length-1].push(dummyData_b[i]['transaction'][key]);
		}
		theData[theData.length-1].push("<input type='button' value='test' />");
	}

    $("#viewTransaction_table").DataTable(
        {
            data: theData,
            columns: [
                { title: "ID" },
                { title: "Requester" },
                { title: "Status" },
				{ title: "Amount" },
                { title: "Actions"}

            ]
        }
       );
}

function getPAData()
{
	// actually an AJAX call
//	$.ajax(
//		{
//			url:"/Controllers/getPAData.php"
//		}
//	).success(function(res)
//	{
//		populatePATable(res);
//	}).error(function(err)
//	{
//		alert("Something went wrong: " + err);
//	});
}

function getTransactionData()
{
	// actually an AJAX call
//	$.ajax(
//		{
//			url:"/Controllers/getTransactionData.php"
//		}
//	).success(function(res)
//	{
//		populateTransactionTable(res);
//	}).error(function(err)
//	{
//		alert("Something went wrong: " + err);
//	});
}
