<div class="ui search selection dropdown mb-1">
    <input type="hidden" name="sub_category" id="subcategory">
    <i class="dropdown icon"></i>
    <div class="default text">@lang('site.all_sub_categories')</div>
    <div class="menu">
        @foreach($sub_categories as $sub_category)
            <div class="item" data-value="{{$sub_category->id}}"><i class="{{$sub_category->icon}}"></i> {{$sub_category->name}}</div>
        @endforeach
    </div>
</div>
<script>
    //    Dropdown
    $('.ui.dropdown')
        .dropdown()
    ;
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
</script>