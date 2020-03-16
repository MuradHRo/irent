$(document).ready(function () {
    let body=$('body');
    //ajax show order products
    $('#subcategory').on('change',function (e) {
        var $subcategory_id= $(this).val();
        let method=$(this).data('method');

        $.ajax({
            url :'/dashboard/advertisements/getquestions/',
            method:method,
            data:{'subcategory_id':$subcategory_id},
            success: function (data) {
                $('#questions_list').html(data);
            }
        });
    });

});
