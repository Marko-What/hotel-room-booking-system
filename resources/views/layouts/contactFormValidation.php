<script>


    $(document).ready(function () {


    $('#form').validate({ // initialize the plugin

        rules: {
						datumOdhod: {

                required: true,
								minlength: 5
            },

						datumPrihod: {

                required: true,
								minlength: 5,

            },
			
					 soba: {

                required: true
            },


            ImePriimek: {

                required: true,
								 minlength: 5,
								 maxlength: 29
            },

            email: {

                required: true,
                email: true

            },

            telNumber: {

                required: true,
                digits: true,
								minlength: 5,
								maxlength: 16

            },

            

        }

    });

});

</script>

