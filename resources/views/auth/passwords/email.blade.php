@extends('layouts.web')

@section('body')


<style>


/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 25%;
}


</style>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">


                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
				<div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
							<div class="countdown"></div>
							</div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary-2" style="padding:10px 20px">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
				
				<div id="myModal" class="modal">

				  <!-- Modal content -->
				  <div class="modal-content">
					<center>
					<p>Reset link was sent to you mail ID</p>
					<button id="myBtn" class="btn btn-outline-primary-2" style="padding:10px 0px; width:50px;">
                                  Ok 
                                </button>
								</center>
				  </div>

				</div>

				
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    @if (session('status'))
        <script>
	
	// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

	
	  modal.style.display = "block";
            //swal("Reset link was sent to you mail ID");
			
			var timer2 = "2:01";
			var interval = setInterval(function() {


			  var timer = timer2.split(':');
			  //by parsing integer, I avoid all extra string processing
			  var minutes = parseInt(timer[0], 10);
			  var seconds = parseInt(timer[1], 10);
			  --seconds;
			  minutes = (seconds < 0) ? --minutes : minutes;
			  if (minutes < 0) clearInterval(interval);
			  seconds = (seconds < 0) ? 59 : seconds;
			  seconds = (seconds < 10) ? '0' + seconds : seconds;
			  //minutes = (minutes < 10) ?  minutes : minutes;
			  $('.countdown').html('Retry After '+minutes + ':' + seconds);
			  timer2 = minutes + ':' + seconds;
			  
			  if(minutes== -1 ){
				  $('.countdown').html('');
			  }
			  
			}, 1000);
			
        </script>
    @endif



<script>
	// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

	<script>
	$(document).ready(function(){
		if(screen.width > 768){
		
		}else{
			//alert("hello");
			
			$(".modal-content").css("width", "80%");
		}

	});
	</script>






@stop
