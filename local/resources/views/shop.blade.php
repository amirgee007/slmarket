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
<html lang="en">
<head>

		

   @include('style')
   




</head>
<body class="cnt-home">

@include('header')


<div class="breadcrumb">
  <div class="container-fluid">
    <div class="breadcrumb-inner">
      <ul class="list-inline list-unstyled">
        <li> <a href="<?php echo $url;?>">@lang('languages.home')</a></li>
        <li class='active'>@lang('languages.shop')</li>
      </ul>
    </div>
    
  </div>
  
</div>



<div class="body-content outer-top-xs">
  <div class='container-fluid'>
  
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
    
    
    <div class='row'>
      <div class='col-md-3 sidebar'> 
       
        <div class="sidebar-module-container">
          <div class="sidebar-filter"> 
            <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
            <div class="sidebar-widget wow fadeInUp">
              <h3 class="section-title">@lang('languages.shop_by')</h3>
              <div class="widget-header">
                <h4 class="widget-title">@lang('languages.category')</h4>
              </div>
              <div class="sidebar-widget-body">
                <select onChange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" class="form-control unicase-form-control">
                                <?php if(!empty($category_cnt)){?>
                                <option value="<?php echo $url;?>/shop">@lang('languages.all_category')</option>
                                    <?php foreach($category as $catery){
									
									$wellcount = DB::table('product')
												  ->where('delete_status','=','')
												   ->where('prod_status','=',1)
												   ->where('prod_category','=',$catery->id)
												   ->where('prod_cat_type','=','cat')
												  ->count();
									?>
                                    <option value="<?php echo $url;?>/shop/cat/<?php echo $catery->id;?>/<?php echo $catery->post_slug;?>" <?php if($id==$catery->id){?> selected <?php } ?>><?php echo $catery->cat_name;?> [<?php echo $wellcount;?>]
                                    
                                    <?php
																		$subcat_cnt = DB::table('subcategory')
																			 ->where('delete_status','=','')
																			 ->where('status','=',1)
																			 ->where('cat_id','=',$catery->id)
																			 ->orderBy('subid','asc')
																			 ->count();
																		if(!empty($subcat_cnt))
																		{	 
																		$subcat_get = DB::table('subcategory')
																			 ->where('delete_status','=','')
																			 ->where('status','=',1)
																			 ->where('cat_id','=',$catery->id)
																			 ->orderBy('subid','asc')
																			 ->get();
																		foreach($subcat_get as $subcat)
																		{ 
																		
																		
																		$wellcount_two = DB::table('product')
																					  ->where('delete_status','=','')
																					   ->where('prod_status','=',1)
																					   ->where('prod_category','=',$subcat->subid)
																					   ->where('prod_cat_type','=','subcat')
																					  ->count();
																		?>
                                    <option value="<?php echo $url;?>/shop/subcat/<?php echo $subcat->subid;?>/<?php echo $subcat->post_slug;?>" <?php if($id==$subcat->subid){?> selected <?php } ?>>  - <?php echo $subcat->subcat_name;?> [<?php echo $wellcount_two;?>]</option>
                                    
                                     <?php } } ?>
                                    
                                    
                                    </option>
                                    
                                    <?php } ?>   
                                        
                                    <?php } ?>  
                                </select>
                <!-- /.accordion --> 
              </div>
              <!-- /.sidebar-widget-body --> 
            </div>
            
            
            
            <form class="register-form" role="form" method="POST" action="{{ route('shop') }}" id="formID" enctype="multipart/form-data">{{ csrf_field() }}
            <div class="sidebar-widget wow fadeInUp">
              <div class="widget-header">
                <h4 class="widget-title">@lang('languages.price')</h4>
              </div>
              <div class="sidebar-widget-body m-t-10">
                <?php /*?><div class="price-range-holder"> <span class="min-max"> <span class="pull-left">$200.00</span> <span class="pull-right">$800.00</span> </span>
                  <input type="text" id="amount" style="border:0; color:#666666; font-weight:bold;text-align:center;">
                  <input type="text" class="price-slider" value="" >
                </div><?php */?>
                <ul class="list">
                                        <li><input id="checkbox5" type="radio" name="price" class="unicase-form-control" value="0_50"><label class="radio-label" for="checkbox5">@lang('languages.under') <?php echo $setts[0]->site_currency;?> 50 <span class="pull-right"></span></label><span class=""></span></li>
                                        <li><input id="checkbox7" type="radio" name="price" class="unicase-form-control" value="50_100"><label class="radio-label" for="checkbox7"><?php echo $setts[0]->site_currency;?> 50 - <?php echo $setts[0]->site_currency;?> 100<span class="pull-right"></span></label><span class=""></span></li>
                                        <li><input id="checkbox8" type="radio" name="price" class="unicase-form-control" value="100_200"><label class="radio-label" for="checkbox8"><?php echo $setts[0]->site_currency;?> 100 - <?php echo $setts[0]->site_currency;?> 200 <span class="pull-right"></span></label><span class=""></span></li>
                                        <li><input id="checkbox9" type="radio" name="price" class="unicase-form-control" value="200_500"><label class="radio-label" for="checkbox9"><?php echo $setts[0]->site_currency;?> 200 - <?php echo $setts[0]->site_currency;?> 500 <span class="pull-right"></span></label><span class=""></span></li>
                                        <li><input id="checkbox0" type="radio" name="price" class="unicase-form-control" value="500_10000"><label class="radio-label" for="checkbox0">@lang('languages.above') <?php echo $setts[0]->site_currency;?> 500 <span class="pull-right"></span></label><span class=""></span></li>
                                    </ul>
                
                <!-- /.price-range-holder --> 
                 </div>
              <!-- /.sidebar-widget-body --> 
            </div>
            <!-- /.sidebar-widget --> 
            <!-- ============================================== PRICE SILDER : END ============================================== --> 
            <!-- ============================================== MANUFACTURES============================================== -->
            <div class="sidebar-widget wow fadeInUp">
              
              <div class="sidebar-widget-body">
                <?php if(!empty($typers_count)){?>
                 <?php foreach($typers as $type){
				 
				 $value_cnt = DB::table('product_attribute_value')
		            ->where('delete_status','=','')
					->where('status','=',1)
					->where('attr_id','=',$type->attr_id)
					->orderBy('attr_value', 'asc')->count();
				 
				 $value = DB::table('product_attribute_value')
		            ->where('delete_status','=','')
					->where('status','=',1)
					->where('attr_id','=',$type->attr_id)
					->orderBy('attr_value', 'asc')->get();	
				 ?><div>
                                    <h4 class="widget-title"><?php echo $type->attr_name;?></h4>
                                    </div>
                                    <!--//==Product Price List Start==//-->
                                    <ul class="list">
                                    <?php if(!empty($value_cnt)){?>
                                     <?php foreach($value as $values){?>
                                        <li><input id="checkbox1" type="checkbox" name="attribute[]" class="unicase-form-control" value="<?php echo $values->value_id;?>"><label class="radio-label" for="checkbox1"><?php echo $values->attr_value;?> <span class="pull-right"></span></label><span class=""></span></li>
                                        <?php } ?>
                                         <?php } ?>
                                    </ul>
                                    <div class="clearfix height20"></div>
                                    <?php } } ?> 
              </div>
              <div>
               <input type="submit" name="search" class="lnk btn btn-primary" value="@lang('languages.filter')">
               </div>
              <!-- /.sidebar-widget-body --> 
            </div>
            
           
           
            
            <!-- /.sidebar-widget --> 
          <!----------- Testimonials------------->
            <?php /*?><div class="sidebar-widget  wow fadeInUp outer-top-vs ">
              <div id="advertisement" class="advertisement">
                <div class="item">
                  <div class="avatar"><img src="theme/images/member1.png" alt="Image"></div>
                  <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                  <div class="clients_author">John Doe <span>Abc Company</span> </div>
                  <!-- /.container-fluid --> 
                </div>
                <!-- /.item -->
                
                <div class="item">
                  <div class="avatar"><img src="theme/images/member3.png" alt="Image"></div>
                  <div class="testimonials"><em>"</em>Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                  <div class="clients_author">Stephen Doe <span>Xperia Designs</span> </div>
                </div>
                <!-- /.item -->
                
                <div class="item">
                  <div class="avatar"><img src="theme/images/member2.png" alt="Image"></div>
                  <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus port mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                  <div class="clients_author">Saraha Smith <span>Datsun &amp; Co</span> </div>
                  <!-- /.container-fluid --> 
                </div>
                <!-- /.item --> 
                
              </div>
              <!-- /.owl-carousel --> 
            </div><?php */?>
            
            
            </form>
            
            
            
          </div>
          
        </div>
       
      </div>
      <!-- /.sidebar -->
      <div class='col-md-9'> 
        <!-- ========================================== SECTION – HERO ========================================= -->
        
         <div class="row">
        <div class="col-md-12"><div class="heading-title" style="border-bottom:none !important;">@lang('languages.shop')</div></div>
                
        </div>
        
     
        <div class="clearfix filters-container m-t-10">
        
       
        
          <div class="row">
            <div class="col col-sm-2 col-md-2">
              <div class="filter-tabs">
                <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                  <li class="active"> <a data-toggle="tab" href="#grid-container"><i class="icon fa fa-th-large"></i>@lang('languages.grid')</a> </li>
                  <li><a data-toggle="tab" href="#list-container"><i class="icon fa fa-th-list"></i>@lang('languages.list')</a></li>
                </ul>
              </div>
              <!-- /.filter-tabs --> 
            </div>
            <!-- /.col -->
            
            <div class="col col-sm-10 col-md-10 text-right">
            
              <div class="col col-sm-6 col-md-6">
                <div class="lbl-cnt"> <span class="lbl">@lang('languages.sort_by')</span>
                  <div class="fld inline">
                    <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                      <button data-toggle="dropdown" type="button" class="btn dropdown-toggle"> @lang('languages.position') <span class="caret"></span> </button>
                      <ul role="menu" class="dropdown-menu">
                        <li role="presentation"><a href="<?php echo $url;?>/shop">@lang('languages.daufalt')</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/sort/name">@lang('languages.name')</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/sort/price">@lang('languages.price')</a></li>
                        
                      </ul>
                      
                      
                      
                    </div>
                  </div>
                  <!-- /.fld --> 
                </div>
                <!-- /.lbl-cnt --> 
              </div>
              <!-- /.col -->
              <div class="col col-sm-6 col-md-6">
                <div class="lbl-cnt"> <span class="lbl">@lang('languages.show')</span>
                  <div class="fld inline">
                    <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                      <button data-toggle="dropdown" type="button" class="btn dropdown-toggle"> <span class="caret"></span> </button>
                      <ul role="menu" class="dropdown-menu">
                        <li role="presentation"><a href="<?php echo $url;?>/shop">@lang('languages.all')</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/5">5</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/10">10</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/20">20</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/50">50</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/100">100</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/200">200</a></li>
                        <li role="presentation"><a href="<?php echo $url;?>/shop/500">500</a></li>
                        
                      </ul>
                    </div>
                  </div>
                  <!-- /.fld --> 
                </div>
                <!-- /.lbl-cnt --> 
              </div>
              <!-- /.col --> 
            
            
            </div>
            
            
            
          </div>
          <!-- /.row --> 
        </div>
        <div class="search-result-container ">
          <div id="myTabContent" class="tab-content category-list">
            <div class="tab-pane active " id="grid-container">
              <div class="category-product">
                <div class="row">
                
                 <div class="col-md-12 gridlist">
                
                 <?php if(!empty($viewcount)){?>                               
                                <?php 
								$ii = 1;
								foreach($viewproduct as $product){
								
								
								$prod_id = $product->prod_token; 
								 $product_img_count = DB::table('product_images')
													->where('prod_token','=',$prod_id)
													->count();
								?>
                  <div class="col-sm-6 col-md-2 wow fadeInUp">
                    <div class="products">
                      <div class="product">
                        <div class="product-image">
                          <div class="image"> <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>">
                                 <?php 
                                        if(!empty($product_img_count)){					
														$product_img = DB::table('product_images')
																			->where('prod_token','=',$prod_id)
																			
																			->orderBy('prod_img_id','asc')
																			->get();
																			
										if(!empty($product_img[0]->image))
										{								
										?>
                                        <img src="<?php echo $url;?>/local/images/media/<?php echo $product_img[0]->image;?>" alt=""/>
                                        <?php } else { ?>
                                        <img src="<?php echo $url;?>/local/images/noimage_box.jpg" alt=""/>
                                        <?php } } ?>
                                        </a>
                                         </div>
                          <!-- /.image -->
                          
                          <?php if($ii==1){?>
                          <div class="tag new"><span>@lang('languages.new')</span></div>
                          <?php } ?>
                        </div>
                        
                         <?php
							
							
					
		
							
								
          $review_count_03 = DB::table('product_rating')
				->where('prod_id', '=', $product->prod_id)
				->count();
				
				if(!empty($review_count_03))
				{
				$review_value_03 = DB::table('product_rating')
				               ->where('prod_id', '=', $product->prod_id)
				               ->get();
				
				
				$over_03 = 0;
		        $fine_value_03 = 0;
				foreach($review_value_03 as $review){
				if($review->rating==1){$value1 = $review->rating*1;} else { $value1 = 0; }
		if($review->rating==2){$value2 = $review->rating*2;} else { $value2 = 0; }
		if($review->rating==3){$value3 = $review->rating*3;} else { $value3 = 0; }
		if($review->rating==4){$value4 = $review->rating*4;} else { $value4 = 0; }
		if($review->rating==5){$value5 = $review->rating*5;} else { $value5 = 0; }
		
		$fine_value_03 += $value1 + $value2 + $value3 + $value4 + $value5;
		

      $over_03 +=$review->rating;
	  
	  
	  
				}
				if(!empty(round($fine_value_03/$over_03))){ $roundeding_03 = round($fine_value_03/$over_03); } else {
		  $roundeding_03 = 0; }	
				
				
				}
				
				
				
				
				
				if(!empty($review_count_03))
				                               {
	                                           if(!empty($roundeding_03)){
	
	                                           if($roundeding_03==1){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    </span>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </p>';
												}
												if($roundeding_03==2){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
													
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </p>';
												}
												
												if($roundeding_03==3){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
													
                                                    
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </p>';
												}
												
												if($roundeding_03==4){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
											                                                
                                                    
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </p>';
												}
												
												if($roundeding_03==5){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													 <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
											    </p>';
												}
												
												
												}
											    else if(empty($roundeding_03)){  $rateus_new_03 = '
												<p class="review-icon">
                                                    <span>
                                                    
                                                    </span>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													 <i class="fa fa-star" aria-hidden="true"></i>
											    </p>';
												}
												
												}
												
												
												
												$rateus_empty_03 = '
												<p class="review-icon">
                                                    <span>
                                                    
                                                    </span>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													 <i class="fa fa-star" aria-hidden="true"></i>
											    </p>';
												
												
				
				
				
			
				
				?>                       
                                
          
                        
                        
                        
                        
                        
                         <div class="product-info text-center product_names">
                          <h3 class="name"><a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>"><?php echo $product->prod_name;?></a></h3>
                          
                          <div class="product-price">  <?php if(!empty($review_count_03)){ echo $rateus_new_03; } else { echo $rateus_empty_03; }?> </div>
                          <p><?php if(!empty($product->prod_offer_price)){?><span style="text-decoration:line-through; color:#FF0000;" class="fontsize15"><?php echo $setts[0]->site_currency.' '.number_format($product->prod_price,2).' ';?></span> <span class="fontsize15 black"> <?php echo $setts[0]->site_currency.' '.number_format($product->prod_offer_price,2);?></span> <?php } else { ?> <span class="fontsize15 black"><?php echo $setts[0]->site_currency.' '.number_format($product->prod_price,2);?></span> <?php } ?></p>
                          
                          
                        </div>
                        
                        <div class="cart clearfix animate-effect">
                          <div class="action">
                            <ul class="list-unstyled">
                              <li class="add-cart-button btn-group">
                                <a data-toggle="tooltip" class="btn btn-primary icon"  title="Add Cart" href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>"> <i class="fa fa-shopping-cart"></i> </a>
                                
                                <a class="btn btn-primary cart-btn" href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>">@lang('languages.add_to_cart')</a>
                                
                                
                              </li>
                               
                              
                              <?php if(Auth::guest()) { ?>
                                                
                                                <li class="lnk wishlist"><a data-toggle="tooltip" class="add-to-cart" href="javascript:void(0);" onClick="alert('@lang('languages.login_user')');" title="Wishlist"> <i class="icon fa fa-heart"></i> </a></li>
                                                <?php
														} else { 
														
														if(Auth::user()->id!=$product->user_id)
														{
														?>
                              
                              <li class="lnk wishlist"><a data-toggle="tooltip" class="add-to-cart" href="<?php echo $url;?>/wishlist/<?php echo Auth::user()->id;?>/<?php echo $product->prod_token;?>" title="Wishlist"> <i class="icon fa fa-heart"></i> </a> </li>
                              
                               
                                                         <?php } } ?>
                              
                             
                              <li class="lnk">
                              
                              
                              
                                <?php if(Auth::guest()) { ?>
                                                
                                            
                              
                              
                              <a data-toggle="tooltip" class="add-to-cart" href="javascript:void(0);" onClick="alert('@lang('languages.login_user')');" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> 
                              <?php } else {?>
                              
                              <a data-toggle="tooltip" class="add-to-cart" href="<?php echo $url;?>/compare/<?php echo $product->prod_token;?>" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a>
                              
                              <?php } ?>
                              
                              
                               </li>
                              
                            </ul>
                          </div>
                          
                        </div>
                        
                        
                        
                        
                        
                        
                        <!-- /.cart --> 
                      </div>
                      <!-- /.product --> 
                      
                    </div>
                    <!-- /.products --> 
                  </div>
                  <!-- /.item -->
                  
                  <?php  $ii++;} ?>
                       
                   <?php } else { ?> 
                              <div class="height100"></div>
                              <div align="center" class="fontsize24 black">@lang('languages.no_data')</div>
                              <?php } ?>
                  </div>
                  <div class="grid_prodss mtop20"></div>
                  
                </div>
                
                
                <!-- /.row --> 
              </div>
              <!-- /.category-product --> 
              
            </div>
            <!-- /.tab-pane -->
            
            <div class="tab-pane "  id="list-container">
              <div class="category-product">
              
              
              
              <?php if(!empty($viewcount)){?>                               
                                <?php foreach($viewproduct as $product){
								
								
								$prod_id = $product->prod_token; 
								 $product_img_count = DB::table('product_images')
													->where('prod_token','=',$prod_id)
													->count();
								?>
                <div class="category-product-inner wow fadeInUp">
                  <div class="products">
                    <div class="product-list product">
                      <div class="row product-list-row">
                        <div class="col col-sm-2 col-lg-2">
                          <div class="product-image">
                            
                            
                            <div class="image"> <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>">
                                 <?php 
                                        if(!empty($product_img_count)){					
														$product_img = DB::table('product_images')
																			->where('prod_token','=',$prod_id)
																			
																			->orderBy('prod_img_id','asc')
																			->get();
																			
										if(!empty($product_img[0]->image))
										{								
										?>
                                        <img src="<?php echo $url;?>/local/images/media/<?php echo $product_img[0]->image;?>" alt=""/>
                                        <?php } else { ?>
                                        <img src="<?php echo $url;?>/local/images/noimage_box.jpg" alt=""/>
                                        <?php } } ?>
                                        </a>
                                         </div>
                            
                            
                          </div>
                          <!-- /.product-image --> 
                        </div>
                        
                        
                        <?php
							
							
					/************** STAR RATING *************/
		
							
								
          $review_count_03 = DB::table('product_rating')
				->where('prod_id', '=', $product->prod_id)
				->count();
				
				if(!empty($review_count_03))
				{
				$review_value_03 = DB::table('product_rating')
				               ->where('prod_id', '=', $product->prod_id)
				               ->get();
				
				
				$over_03 = 0;
		        $fine_value_03 = 0;
				foreach($review_value_03 as $review){
				if($review->rating==1){$value1 = $review->rating*1;} else { $value1 = 0; }
		if($review->rating==2){$value2 = $review->rating*2;} else { $value2 = 0; }
		if($review->rating==3){$value3 = $review->rating*3;} else { $value3 = 0; }
		if($review->rating==4){$value4 = $review->rating*4;} else { $value4 = 0; }
		if($review->rating==5){$value5 = $review->rating*5;} else { $value5 = 0; }
		
		$fine_value_03 += $value1 + $value2 + $value3 + $value4 + $value5;
		

      $over_03 +=$review->rating;
	  
	  
	  
				}
				if(!empty(round($fine_value_03/$over_03))){ $roundeding_03 = round($fine_value_03/$over_03); } else {
		  $roundeding_03 = 0; }	
				
				
				}
				
				
				
				
				
				if(!empty($review_count_03))
				                               {
	                                           if(!empty($roundeding_03)){
	
	                                           if($roundeding_03==1){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    </span>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </p>';
												}
												if($roundeding_03==2){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
													
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </p>';
												}
												
												if($roundeding_03==3){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
													
                                                    
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </p>';
												}
												
												if($roundeding_03==4){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
											                                                
                                                    
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </p>';
												}
												
												if($roundeding_03==5){ $rateus_new_03 ='
                                                <p class="review-icon">
                                                    <span>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													 <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>
											    </p>';
												}
												
												
												}
											    else if(empty($roundeding_03)){  $rateus_new_03 = '
												<p class="review-icon">
                                                    <span>
                                                    
                                                    </span>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													 <i class="fa fa-star" aria-hidden="true"></i>
											    </p>';
												}
												
												}
												
												
												
												$rateus_empty_03 = '
												<p class="review-icon">
                                                    <span>
                                                    
                                                    </span>
													<i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													<i class="fa fa-star" aria-hidden="true"></i>
													 <i class="fa fa-star" aria-hidden="true"></i>
											    </p>';
												
												
				
				/************** STAR RATING *************/
				
			
				
				?>
                        <!-- /.col -->
                        <div class="col col-sm-10 col-lg-10">
                          <div class="product-info">
                            <h3 class="name"><a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>"><?php echo $product->prod_name;?></a></h3>
                            <div class="rating rateit-small"></div>
                             <div class="product-price">  <?php if(!empty($review_count_03)){ echo $rateus_new_03; } else { echo $rateus_empty_03; }?> </div>
                          <p><?php if(!empty($product->prod_offer_price)){?><span style="text-decoration:line-through; color:#FF0000;" class="fontsize15"><?php echo $setts[0]->site_currency.' '.number_format($product->prod_price,2).' ';?></span> <span class="fontsize15 black"> <?php echo $setts[0]->site_currency.' '.number_format($product->prod_offer_price,2);?></span> <?php } else { ?> <span class="fontsize15 black"><?php echo $setts[0]->site_currency.' '.number_format($product->prod_price,2);?></span> <?php } ?></p>
                            <!-- /.product-price -->
                            <div class="description m-t-10"><?php echo substr($product->prod_desc,0,200);?></div>
                            <div class="cart clearfix animate-effect">
                              <div class="action">
                                <ul class="list-unstyled">
                                  <li class="add-cart-button btn-group">
                                    <button class="btn btn-primary icon" data-toggle="dropdown" type="button"> <i class="fa fa-shopping-cart"></i> </button>
                                    
                                    
                                     <?php if(Auth::guest()) { ?>
                                                        
                                                        <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>" class="btn btn-primary cart-btn">
                                                        <span>@lang('languages.shop_now')</span>
                                                        </a>
                                                        <?php
														} else { 
														
														if(Auth::user()->id==$product->user_id)
														{
														?>
                                                        
                                                        <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>" class="btn btn-primary cart-btn">
                                                        <span>@lang('languages.shop_now')</span>
                                                        </a>
                                                        
                                                        <?php } else if(Auth::user()->id!=$product->user_id){ ?>
                                                        
                                                        <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product->prod_slug;?>" class="btn btn-primary cart-btn">
                                                        <span>@lang('languages.shop_now')</span>
                                                        </a>
                                                        
                                                        <?php } ?>
                                                        <?php } ?>
                                  </li>
                                  
                                  
                                  
                                                    <?php if(Auth::guest()) { ?>
                                                <li class="lnk wishlist"><a href="javascript:void(0);" onClick="alert('@lang('languages.login_user')');" class="add-to-cart"><i class="icon fa fa-heart"></i></a></li>
                                                <?php
														} else { 
														
														if(Auth::user()->id!=$product->user_id)
														{
														?>
                                                       <li class="lnk wishlist"> <a href="<?php echo $url;?>/wishlist/<?php echo Auth::user()->id;?>/<?php echo $product->prod_token;?>"><i class="icon fa fa-heart"></i></a></li>
                                                         <?php } } ?>
                                                    
                                                    
                                  
                                  
                                  <li class="lnk"> 
                                  
                                   <?php if(Auth::guest()) { ?>
                                                
                                            
                              
                              
                              <a data-toggle="tooltip" class="add-to-cart" href="javascript:void(0);" onClick="alert('@lang('languages.login_user')');" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> 
                              <?php } else {?>
                              
                              <a data-toggle="tooltip" class="add-to-cart" href="<?php echo $url;?>/compare/<?php echo $product->prod_token;?>" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a>
                              
                              <?php } ?>
                                  
                                  
                                  </li>
                                  
                                  
                                  
                                </ul>
                              </div>
                              
                            </div>
                           
                            
                          </div>
                         
                        </div>
                       
                      </div>
                     
                     
                    </div>
                    
                  </div>
                   
                </div>
               
               
                <?php } ?>  
                               <?php } else { ?> 
                              <div class="height100"></div>
                              <div align="center" class="fontsize24 black">@lang('languages.no_data')</div>
                              <?php } ?>
               
               
               
               
                
                
                
                
              </div>
              <!-- /.category-product --> 
            </div>
            <!-- /.tab-pane #list-container --> 
          </div>
          <!-- /.tab-content -->
          
          <!-- /.filters-container --> 
          
        </div>
        <!-- /.search-result-container --> 
        
      </div>
      <!-- /.col --> 
    </div>
     
  
</div>

<div class="height20"></div>

@include('footer')
     
</body>
</html>