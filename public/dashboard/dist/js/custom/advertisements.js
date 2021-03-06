$(document).ready(function () {
    let body=$('body');
    //ajax Questions
    $('#category').on('change',function (e) {
        var category_id= $(this).val();
        console.log($(this).val());
        $.ajax({
            url :'/advertisements/getsubcategories/',
            method:"get",
            data:{'category':category_id},
            success: function (data) {
                $('#sub_categories_list').html(data);
            }
        });
    });
    //ajax Questions
    $('#subcategory').on('change',function (e) {
        var subcategory_id= $(this).val();

        $.ajax({
            url :'/dashboard/advertisements/getquestions/',
            method:"get",
            data:{'subcategory_id':subcategory_id},
            success: function (data) {
                $('#questions_list').html(data);
            }
        });
    });
    // Front
    //ajax Add Comment
    var rating;
    $('.ui.rating')
        .rating('setting', 'onRate', function(value) {
            rating=value;
            $('#add-comment').removeClass('disabled');
    });
    $('#add-comment').on('click',function () {
        var comment=$('#text-comment').val();
        var advertisement=$('#advertisement-comment').val();
        console.log(rating);
        console.log(comment);
        console.log(advertisement);
        $.ajax({
            url: '/advertisements/comment/add/',
            method: "Get",
            data:{'rate':rating,'comment':comment,'advertisement':advertisement},
            success: function (data) {
                $('#comments').append(data);
                $('#form-comment').remove();
            }
        });
    });
    //ajax Delete Comment
    body.on('click','#delete-comment',function () {
        $('.ui.delete-comment.modal')
            .modal({
                closable  : false,
                onDeny    : function(){

                },
                onApprove : function() {
                    var comment = $('#id-comment').val();
                    console.log(comment);
                    $.ajax({
                        url: '/advertisements/comment/delete/',
                        method: "Get",
                        data:{'comment_id':comment},
                        success: function () {
                            $('#my-comment').remove();
                        }
                    });
                }
            })
            .modal('show')
        ;

    });

    // Edit comment
    body.on('click','#edit-comment',function () {
       $('#old-comment').css('display','none');
       $('#text-comment').css('display','block');
       $('#update-comment').css('display','unset');
       $('#rate-comment').rating('enable');
       $('#rate-comment').rating('setting', 'onRate', function(value) {
           rating = value;
       });
    });
    // Ajax
    body.on('click','#update-comment',function () {
        console.log(rating);
        var comment_id = $('#id-comment').val();
        var comment=$('#text-comment').val();
        $.ajax({
            url: '/advertisements/comment/update/',
            method: "Get",
            data:{'rate':rating,'id':comment_id,'comment':comment},
            success: function (data) {
                $('#rate-comment').rating('disable');
                $('#old-comment').text(comment);
                $('#old-comment').css('display','block');
                $('#text-comment').css('display','none');
                $('#update-comment').css('display','none');

            }
        });
    });
    //delete Advertisement
    body.on('click','#mark_unavailable_advertisement',function () {
        $('.ui.mark_unavailable_advertisement.modal')
            .modal({
                closable  : false,
                onDeny    : function(){

                },
                onApprove : function() {

                }
            })
            .modal('show')
        ;
    });
    //delete Advertisement
    body.on('click','#delete-advertisement',function () {
        $('.ui.delete-advertisement.modal')
            .modal({
                closable  : false,
                onDeny    : function(){

                },
                onApprove : function() {

                }
            })
            .modal('show')
        ;
    });
    // Exchange Pictures
    $('.sub-image').on('click',function () {
        let main_image=$('#main-image');
        var src_main = main_image.attr('src');
        main_image.attr('src',$(this).attr('src'));
        $(this).attr('src', src_main);
        console.log(src_main);
    });
    $('.rating.read')
        .rating('disable')
    ;
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).attr('class','img-thumbnail mb-3').css('width','100px').appendTo(placeToInsertImagePreview);
                };

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        $('div.gallery').html('');
        imagesPreview(this, 'div.gallery');
    });

    // toggle subcategories on click Category
    $('.main-category').on('click',function () {
       $(this).next('.sub-categories').slideToggle();
    });

});
