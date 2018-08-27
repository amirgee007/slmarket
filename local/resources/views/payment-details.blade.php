<?php
	use Illuminate\Support\Facades\Route;
$currentPaths= Route::getFacadeRoot()->current()->uri();	
$url = URL::to("/");
$setid=1;
		$setts = DB::table('settings')
		->where('id', '=', $setid)
		->get();
		$headertype = $setts[0]->header_type;
	?>
<!DOCTYPE html>

<html class="no-js"  lang="en">
<head>

		

   @include('style')
   




</head>
<body  class="cnt-home">

  

   
    @include('header')
<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
	<div class="container-fluid">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="<?php echo $url;?>">@lang('languages.home')</a></li>
				<li class='active'>@lang('languages.payment_confirmation')</li>
			</ul>
		</div>
	</div>
</div>



<div class="body-content">
	<div class="container-fluid">
		<div class="my-wishlist-page">
        <div class="row">
                     <div class="col-md-12 col-sm-12">
                    @if(Session::has('success'))

	    <p class="alert alert-success">

	      {{ Session::get('success') }}

	    </p>

	@endif


	
	
 	@if(Session::has('error'))

	    <p class="alert alert-danger">

	      {{ Session::get('error') }}

	    </p>

	@endif
    </div>
    </div>
        
			<div class="row">
           
				<div class="col-md-12 my-wishlist">
	
		
        
        <div class="col-md-12 row"><div class="heading-title">@lang('languages.payment_confirmation')</div></div>
                
       
        
        
        <div class="height20 clearfix"></div>
        
        <div class="table-responsive">
        
       
        <div class="text-center">   
	<div class="clearfix height30"></div>
	<div class="h4 black">
    <label class="black">@lang('languages.price')</label> : <?php echo $amount; ?> <?php echo $currency; ?>
	</div>
	<div class="clear height20"></div>
    
    
    
    <?php if($payment_type=="payhere"){
	
	  if($setts[0]->payhere_mode=="test") { $payurl = "https://sandbox.payhere.lk/pay/checkout"; }
	  if($setts[0]->payhere_mode=="live") { $payurl = "https://www.payhere.lk/pay/checkout"; }
	
	
	$merchants = $setts[0]->payhere_merchant_id;
	?>
    <form method="post" action="<?php echo $payurl;?>">   
    <input type="hidden" name="merchant_id" value="<?php echo $merchants;?>">
    <input type="hidden" name="return_url" value="<?php echo $url;?>/shop_success/<?php echo $order_no;?>">
    <input type="hidden" name="cancel_url" value="<?php echo $url;?>/cancel">
    <input type="hidden" name="notify_url" value="<?php echo $url;?>/cancel">  
    
    <input type="hidden" name="order_id" value="<?php echo $order_no;?>">
    <input type="hidden" name="items" value="<?php echo $product_names;?>">
    <input type="hidden" name="currency" value="<?php echo $currency; ?>">
    <input type="hidden" name="amount" value="<?php echo $amount; ?>"> 
    
    
    
     
    
    
    
    <input type="hidden" name="first_name" value="<?php echo Auth::user()->name;?>">
    <input type="hidden" name="last_name" value="<?php echo Auth::user()->name;?>">
    <input type="hidden" name="email" value="<?php echo Auth::user()->email;?>">
    <input type="hidden" name="phone" value="<?php echo Auth::user()->phone;?>">
    <input type="hidden" name="address" value="<?php echo Auth::user()->address;?>">
    <input type="hidden" name="city" value="<?php echo Auth::user()->country;?>">
    <input type="hidden" name="country" value="<?php echo Auth::user()->country;?>"> 
    
    
    
    <input type="submit" value="Buy Now" class="btn-upper btn btn-primary">   
    </form> 
    
    
    <?php } ?>
    
    
    
    
    
    
    
    
    
    <?php if($payment_type=="paypal"){?>
    <form action="<?php echo $paypal_url; ?>" method="post">

        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
        
        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        
        <!-- Specify details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="<?php echo $product_names;?>">
        <input type="hidden" name="item_number" value="<?php echo $order_no;?>">
        <input type="hidden" name="amount" value="<?php echo $amount; ?>">
        <input type="hidden" name="currency_code" value="<?php echo $currency; ?>">
        
        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='<?php echo $url;?>/cancel'>
		<input type='hidden' name='return' value='<?php echo $url;?>/shop_success/<?php echo $order_no;?>'>
		<input type="submit" name="submit" value="Pay Now" class="btn-upper btn btn-primary">
     
    
    </form>
	<?php } if($payment_type=="stripe"){
		$fprice = $amount * 100;
		?>
        
        <form action="{{ route('stripe_shop_success') }}" method="POST">
	{{ csrf_field() }}
	
	<input type="hidden" name="cid" value="<?php echo $order_no;?>">
	<input type="hidden" name="amount" value="<?php echo $fprice; ?>">
	<input type="hidden" name="currency_code" value="<?php echo $currency; ?>">
	<input type="hidden" name="item_name" value="<?php echo $product_names;?>">
		<script src="https://checkout.stripe.com/checkout.js" 
		class="stripe-button" 
		<?php if($setts[0]->stripe_mode=="test") { ?>
		data-key="<?php echo $setts[0]->test_publish_key; ?>" <?php } ?>
		<?php if($setts[0]->stripe_mode=="live") {  ?>
		data-key="<?php echo $setts[0]->live_publish_key; ?>" 
		<?php }?> 
		data-image="<?php echo $url.'/local/images/media/'.$setts[0]->site_logo;?>" 
		data-name="<?php echo $product_names;?>" 
		data-description="<?php echo $setts[0]->site_name;?>"
		data-amount="<?php echo $fprice; ?>"
		data-currency="<?php echo $currency; ?>"
		/>
		</script>
	</form>
	<?php } if($payment_type=="cash-on-delivery"){ ?>
    
    
    <form class="register-form" role="form" method="POST" action="{{ route('cash-on-delivery') }}" id="formID" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    <input type="hidden" name="cid" value="<?php echo $order_no;?>">
    <input type="submit" name="submit" value="Pay Now" class="btn-upper btn btn-primary">
    
    </form>
    
    <?php } ?>
    
    
        <div class="clear height50"></div>
    </div>
        
        
        
	</div>
</div>			









</div>
		</div>
		</div>
</div>


<div class="height30"></div>

@include('footer')
</body>
</html>
