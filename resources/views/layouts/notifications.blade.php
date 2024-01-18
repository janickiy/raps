@if (Session::has('message'))
    <div class="alert warning">
        {!! Session::get('message') !!}
        <span class="close" onclick="this.parentElement.style.display='none'">×</span>
    </div>
@endif

@if (session('success'))
    <div class="alert success">
        {!! session('success') !!}
        <span class="close" onclick="this.parentElement.style.display='none'">×</span>
    </div>
@endif

@if (session('error'))
    <div class="alert danger">
        {!! session('error') !!}
        <span class="close" onclick="this.parentElement.style.display='none'">×</span>
    </div>
@endif
