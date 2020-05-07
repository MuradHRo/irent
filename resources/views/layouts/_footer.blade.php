<footer id="myFooter" class="mt-3">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3 col-lg-3">
                <img style="max-width: 200px" src="{{asset('uploads/i rent logo 2.1-01.png')}}" alt="">
            </div>
            <div class="pl-5 col-6 col-md-3 col-lg-3">
                <h5>@lang('site.get_started')</h5>
                <ul>
                    <li><a href="{{route('index')}}">@lang('site.home')</a></li>
                    <li><a href="{{route('register')}}">@lang('site.register')</a></li>
                </ul>
            </div>
            <div class="pl-5 col-6 col-md-3 col-lg-3">
                <h5>@lang('site.about_us')</h5>
                <ul>
                    <li><a href="{{route('about_us')}}">@lang('site.about_us')</a></li>
                    <li><a href="{{route('contact_us')}}">@lang('site.contact_us')</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 col-lg-3">
                <div class="social-networks">
                    <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="google"><i class="fa fa-google-plus"></i></a>
                </div>
                <button style="cursor: unset" type="button" class="btn btn-default">@lang('site.contact_us')</button>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <p>@lang('site.copyrights')</p>
    </div>
</footer>