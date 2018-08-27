<!DOCTYPE html>
<html lang="en">
<head>

    

   @include('style')
	




</head>
<body class="index">

    

    <!-- fixed navigation bar -->
    @include('header')

    
     
    
    <header class="custom_header">
		
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<div class="">
						<div class="animate-box" data-animate-effect="fadeIn">
							<h1>Reset Password</h1>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>


	
    	
	
	
	
	
	
	
	<div id="avigher-gallery">
		
		<div class="container-fluid">

            	<div class="container">

                	<div class="wrapper-inner">
	
	
	
    <div class="">
     <div class="col-md-2"></div> 
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if(Session::has('success'))

	    <div class="alert alert-success">

	      {{ Session::get('success') }}

	    </div>

	@endif


	
	
 	@if(Session::has('error'))

	    <div class="alert alert-danger">

	      {{ Session::get('error') }}

	    </div>

	@endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('reset-password') }}" id="formID">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label para black">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control validate[required,custom[email]] text-input radiusoff" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label para black">Change Password</label>

                            <div class="col-md-6">
                                <input id="password" type="text" class="form-control validate[required] text-input radiusoff" name="password" value="{{ old('password') }}">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <input type="hidden" name="password_token" value="<?php echo $id;?>">
                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <div class="col-md-2"></div> 
    </div>

	
	</div>
    </div>
    <div class="clearfix height50"></div>
   </div>
   
   </div>
   
   
   <div class="clearfix height50"></div>
	

      @include('footer')
      
</body>
</html>