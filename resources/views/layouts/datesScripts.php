
<script>

			
	
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




  
	
		



  </script>
