$(document).ready(function () {
    $(".rating").rating();
    let body=$('body');
    $('.add-selection-btn').on('click',function (e) {
      e.preventDefault();
       var html =`
            <div class="input-group mb-3">
                <input type="text" name="selection[]" class="form-control">
                <div class="input-group-prepend">
                    <button type="button" class="btn btn-danger remove-selection-btn">
                        <i class="fa fa-minus"></i>
                    </button>   
                </div>
            </div>
           `;

       $('#selection-container').append(html);
   });
    body.on('click','.remove-selection-btn',function (e) {
        e.preventDefault();
        $(this).closest('.input-group').remove();
    });



    //ajax show order products
    $('.order-products').on('click',function (e) {
        e.preventDefault();
        let url=$(this).data('url');
        let method=$(this).data('method');

        $.ajax({
            url :url,
            method:method,
            success: function (data) {
                $('#order-product-list').html(data);
            }
        });
    });

});
