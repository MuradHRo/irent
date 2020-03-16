@if(session('success'))
    <script type="text/javascript">
    $(function() {
        toastr.success('{{session('success')}}');
    });
    </script>
@elseif(session('error'))
    <script type="text/javascript">
        $(function() {
            toastr.error('{{session('error')}}');
        });
    </script>
@endif



