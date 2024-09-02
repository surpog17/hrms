<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent fixed-top">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="#">{{ $page ?? '' }}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto" style="color: #089ac3">
                <li class="nav-item">
                    <a href="{{ route('home') }}"  class="nav-link " style="color: #089ac3" style=" font-weight: bolders">
                        <i class="tim-icons icon-minimal-left" style="color: #089ac3" style=" font-weight: bolder"></i> {{ __('Back to Dashboard') }}
                    </a>
                </li>
             
                <li class="nav-item ">
                    <a href="{{ route('login') }}" class="nav-link" style="color: #089ac3" style=" font-weight: bolder" >
                        <i class="tim-icons icon-single-02" style="color: #fffff" ></i> {{ __('Login') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
