$(document).ready(function(){

   $('#productList').delegate('#addToCart', 'click', function(event){
        event.preventDefault()
        var id = $(this).attr('data-id');  
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: 'POST',
          url:  AppHelper.baseUrl+'/add/cart/'+id,
          dataType  : 'json',
          success: function(response){
              if(response.type == "success"){
                 location.reload();
              }else{
                swal("Error", "Something went wrog, please try again later!", "warning", {button: false});
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              swal("Error", "Something went wrog, please try again later!", "warning", {button: false});
          }
        }); 
   });


    $('.js-check :radio').change(function () {
        var check_attr_name = $(this).attr('name');
        if ($(this).is(':checked')) {
            $('input[name='+ check_attr_name +']').closest('.js-check').removeClass('active');
            $(this).closest('.js-check').addClass('active');
        } else {
            item.removeClass('active');
        }
    });


    $('.js-check :checkbox').change(function () {
        var check_attr_name = $(this).attr('name');
        if ($(this).is(':checked')) {
            $(this).closest('.js-check').addClass('active');
        } else {
            $(this).closest('.js-check').removeClass('active');
        }
    });

});