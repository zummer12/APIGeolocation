<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>IP GeoLocation</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

	<div class="container">
	  <div class="row">
	    <div class="col-sm-4">
		    
			    <label for="ip">IP:</label>
			    <input type="text" id="ip" class="form-control" value="">
		     
	    </div>

	    <div class="col-sm-2">
		    
			    <label for="addIP">Добавить IP</label>
	      		<input type="button" id="addIP" class="btn btn-success form-control" value="Добавить">
		    
	    </div>

        <div class = "col-sm-6">
            <table class="table" id ="table"></table>
        </div>


	  </div>

	</div>


    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

        <script>

	$( document ).ready(function() {
    		
	});

            $("#addIP").click(function () {
                var ip = $('#ip').val();
                $.ajax({
                    dataType: 'json',
                    type: "post",
                    data: { ip : ip },
                    url: "IP.php",
                    success:function(result){
                        $("#table tr").remove();
                        $("#description").html('');
                        $("#table").append($("<tr><th>ID</th><th>IP</th><th>Country</th></tr>"));
                        $.each(result, function(indice, list){

                            $("#table").append($("<tr>").append("<td>" +
                                list.id+"</td>"+"<td>"+list.ip+"<td>"+list.country));
                        });

                    }
                });
            });


          

        </script>

</body>
</html>









