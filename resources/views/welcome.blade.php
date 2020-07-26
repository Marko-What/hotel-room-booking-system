<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	


    <title>Room reservation </title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
		<link rel="stylesheet" href="{{asset('css/main.css')}}">

		<!-- bootstrap cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>  
    
		<!-- jquery cdn -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



{!! htmlScriptTagJsApi(['action' => 'homepage']) !!}
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
span.red { color:red;}
</style>



  </head>



<body>
   

 <a class="nav-link" href="{{ route('admin') }}">admin dashboard</a>

@include('layouts.errors')
@include('layouts.success')
      <form method="post" action="{{url('validation')}}" id="form">

					@csrf

		 <div class="row">
					<div class="col-md-4"></div>
          <div class="form-group col-md-4">	
						<b> obvezno je potrebno izpolniti polja oznacena z zvezdico <span class="red">*</span>  </b>
					</div>
		</div>
				
       <div class="row">

         			<div class="col-md-4"></div>
          <div class="form-group col-md-4">

            <label for="Name">izbira sobe:<span class="red">*</span> </label>

            <select type="text" class="form-control" name="soba" id="soba">

							@foreach($roomsIme as $item)
							 <option value="{{ $item['name'] }}" id="{{ $item['id'] - 1}}" class="roomItemRef">{{ $item["name"] }}</option>
							@endforeach
					
						</select>

          </div>

        </div>






  

        <div class="row">

          <div class="col-md-4"></div>

          <div class="form-group col-md-4">

            <label for="Name">Datum prihoda:<span class="red">*</span> </label>
		          		  <input type="text" id="datepicker" name="datumPrihod">
          </div>

        </div>






			<div class="row">

          <div class="col-md-4"></div>

          <div class="form-group col-md-4">

            <label for="Name">Datum odhoda:<span class="red">*</span> </label>

             <input type="text" id="datepickerA" name="datumOdhod">

          </div>

        </div>


			

  

			<div class="row">

          <div class="col-md-4"></div>

          <div class="form-group col-md-4">

              <label for="Email">Ime in Priimek:<span class="red">*</span> </label>

              <input type="text" class="form-control" name="ImePriimek">

          </div>

        </div>





        <div class="row">

          <div class="col-md-4"></div>

          <div class="form-group col-md-4">

              <label for="Email">vnesite elektronski naslov:<span class="red">*</span> </label>

              <input type="text" class="form-control" name="email">

          </div>

        </div>

  

        <div class="row">

            <div class="col-md-4"></div>

            <div class="form-group col-md-4">

              <label for="Number">vnesite telefonsko številko:<span class="red">*</span> </label>

             	 <input type="text" class="form-control" name="telNumber" >

            </div>

        </div>

  

        <div class="row">

            <div class="col-md-4"></div>

            <div class="form-group col-md-4">

              <label for="Min Length">Opomba sporočilo, neobvezno:</label>

              <input type="text" class="form-control" name="opomba">

            </div>

        </div>

  	

  

        <div class="row">

          <div class="col-md-4"></div>

          <div class="form-group col-md-4" style="margin-top:60px">

            <button type="submit" class="btn btn-success">Rezerviraj</button>

          </div>

        </div>

  

      </form>









    </div>

   


 @include('layouts.contactFormValidation')

 <script>
  $( function(){
			
	
		roo = @json($roo);

	selectId = $("#soba option:selected").attr('id');
	unavailableDates = roo[selectId];


$("#soba").change(function() {
  var id = $(this).children(":selected").attr("id");

		unavailableDates = roo[id];

			$( "#datepicker" ).datepicker({ minDate: -0, maxDate: "+24M +10D", dateFormat: "yy-m-dd", beforeShowDay: unavailable });
				dateA = $( "#datepicker").val();
			$( "#datepickerA" ).datepicker({ minDate: dateA, maxDate: "+24M +10D", dateFormat: "yy-m-dd", beforeShowDay: unavailable });

});

/* end of soba Change*/




 function unavailable(date) { 
        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
        if ($.inArray(dmy, unavailableDates) == -1) {
            return [true, ""];
        } else {
            return [false, "", "Unavailable"];
        }
    }
																																											
		 $( "#datepicker" ).datepicker({ minDate: -0, maxDate: "+24M +10D", dateFormat: "yy-m-d", beforeShowDay: unavailable });
			
				$("#datepicker").change(function(){
			
						$('#datepickerA').val('').datepicker("refresh");
							dateA = $( "#datepicker").val();
					
						$('#datepickerA').datepicker('destroy');
						$( "#datepickerA" ).datepicker({ minDate: dateA, maxDate: "+24M +10D", dateFormat: "yy-m-d", beforeShowDay: unavailable});

						 $(this).valid(); 
				});



					$( "#datepickerA" ).change(function(){
								 $(this).valid(); 
						});

		});



  </script>
 

 


</body>

 

</html>
