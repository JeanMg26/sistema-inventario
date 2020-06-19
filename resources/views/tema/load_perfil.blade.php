 @if (Auth::user()->rutaimagen == "" || Auth::user()->rutaimagen == null)
 <img class="img-fluid" src="{{ url('/img/user.jpg') }}">
 @else
 <img class="img-fluid" src="/uploads/{{Auth::user()->rutaimagen}}">
 @endif

 <span class="hidden-md-down"> {{ Auth::user()->name }} <i class="far fa-angle-down rotate ml-1"></i></span>