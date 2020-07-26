 <!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
	<!-- bootstrap cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>  
    
		<!-- jquery cdn -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

	    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
@include('layouts.navigation')
<h1> testing subdomain route </h1>




<div class="container col-md-12">

@include('layouts.success')
@inject('provider', 'App\Http\Controllers\Controller')


<table class="table">
<thead  class="thead-dark">
<tr>
<th>soba: </th><th>datumPrihod: </th><th>datumOdhod: </th><th>Ime Priimek: </th><th>email: </th><th>telNumber: </th><th>opomba: </th><th>dne rezervacija: </th><th>steviloDni: </th><th>celotniCena: </th>
</tr>
 </thead>	
	<tbody>
	    @foreach($roomsDataLatest as $booking)
	
		<tr>
		   	
		    <td> {{ $provider::getRoomNameById($booking['sobeId']) }} </td>
		    <td> {{ $booking['datumPrihod'] }}</td>
		    <td> {{ $booking['datumOdhod'] }}</td>
		    <td> {{ $booking['ImePriimek'] }}</td>
		    <td> {{ $booking['email'] }}</td>
		    <td> {{ $booking['telNumber'] }}</td>
		    <td> {{ $booking['opomba'] }}</td>
		    <td> {{ $booking['created_at'] }}</td>
		    <td> {{ $booking['steviloDni'] }}</td>
		    <td> {{ $booking['celotniCena'] }}</td>
		    <td><div class=""><a href="{{ url('removeReservation/'.$booking->id) }}">cancel reservazion</a></div></td>
		</tr>
		
		
	    @endforeach
	
	</tbody>

</table>
<div class="pagination">
     {{ $roomsDataLatest->links() }}
</div>
</div>
</body>
</html> 



