<?php
use Illuminate\Support\Facades\Route;
$currentPaths = Route::getFacadeRoot()->current()->uri();
$url = URL::to("/");
$setid = 1;
$setts = DB::table('settings')
    ->where('id', '=', $setid)
    ->get();
$headertype = $setts[0]->header_type;
?>
        <!DOCTYPE html>

<html class="no-js" lang="en">
<head>


    @include('style')


</head>
<body class="cnt-home">


<div id="editor"></div>

@include('header')

<!-- ============================================== HEADER : END ============================================== -->
<div class="breadcrumb">
    <div class="container-fluid">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo $url;?>">@lang('languages.home')</a></li>
                <li class='active'>@lang('languages.my_shopping')</li>
            </ul>
        </div>
    </div>
</div>

<div class="body-content outer-top-xs">
    <div class="container-fluid">
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
        <div class="row " id="pcontent">
            <div class="shopping-cart">
                <div class="shopping-cart-table ">
                    <div class="col-md-6">
                        <div class="heading-title"
                             style="border-bottom:none !important;">@lang('languages.my_shopping')</div>
                    </div>
                    <div class="col-md-6 text-right"><a href="<?php echo $url;?>/my-shopping"
                                                        class="btn-upper btn btn-primary">@lang('languages.back_to_my_shopping')</a>

                        <a href="javascript:window.print();" class="btn-upper btn btn-primary"
                           target="_blank">@lang('languages.print_btn')</a>

                    </div>

                    <div class="height20 clearfix"></div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="item">@lang('languages.image')</th>
                                <th class="item" width="150">@lang('languages.product_name')</th>
                                <th class="item">@lang('languages.purchase_id')</th>
                                <th class="item">@lang('languages.attributes')</th>
                                <th class="item">@lang('languages.price_qty')</th>
                                <th class="item">@lang('languages.contact_vendor')</th>
                                <th class="item">@lang('languages.rating_review')</th>


                            </tr>
                            </thead><!-- /thead -->

                            <tbody>

                            <?php if(!empty($viewcount)){?>
                            <?php foreach($viewproduct as $product){

                            $prod_id = $product->prod_token;
                            $product_img_count = DB::table('product_images')
                                ->where('prod_token', '=', $prod_id)
                                ->count();

                            $view_count = DB::table('product')
                                ->where('prod_id', '=', $product->prod_id)
                                ->count();
                            if (!empty($view_count)) {
                                $view_product = DB::table('product')
                                    ->where('prod_id', '=', $product->prod_id)
                                    ->get();
                                $product_names = $view_product[0]->prod_name;
                                $product_slug = $view_product[0]->prod_slug;

                            } else {
                                $product_names = "";
                                $product_slug = "";
                            }
                            ?>
                            <tr>

                                <td class="cart-image">

                                    <?php
                                    if(!empty($product_img_count)){
                                    $product_img = DB::table('product_images')
                                        ->where('prod_token', '=', $prod_id)
                                        ->orderBy('prod_img_id', 'asc')
                                        ->get();



                                    ?>
                                    <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product_slug;?>"
                                       class="entry-thumbnail"><img
                                                src="<?php echo $url;?>/local/images/media/<?php echo $product_img[0]->image;?>"
                                                alt="" class="img_responsive"></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product_slug;?>"
                                       class="entry-thumbnail"><img
                                                src="<?php echo $url;?>/local/images/noimage_box.jpg" alt=""
                                                class="img_responsive"></a>
                                    <?php } ?>


                                </td>

                                <td>
                                    <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product_slug;?>"><?php echo $product_names;?></a>
                                    <?php
                                    if(!empty($view_count))
                                    {
                                    if($view_product[0]->prod_type == "digital"){ if($product->status == "completed"){?>
                                    <br/><br/>
                                    <span style="color:#FF0000;">@lang('languages.download_file'):</span> <a
                                            style="color:#0033CC;"
                                            href="<?php echo $url;?>/local/images/media/<?php echo $view_product[0]->prod_zipfile;?>"
                                            download><?php echo $view_product[0]->prod_zipfile;?></a>

                                    <?php } } } ?>
                                </td>


                                <td class="cart-product-name-info">
                                    <?php echo $product->purchase_token;?>


                                </td>


                                <?php
                                $cats = explode(",", $product->prod_attribute);
                                $value_namer = "";

                                foreach ($cats as $cat) {

                                    $prod_value_count = DB::table('product_attribute_value')
                                        ->where('delete_status', '=', '')
                                        ->where('status', '=', 1)
                                        ->where('value_id', '=', $cat)
                                        ->count();
                                    $prod_value = DB::table('product_attribute_value')
                                        ->where('delete_status', '=', '')
                                        ->where('status', '=', 1)
                                        ->where('value_id', '=', $cat)
                                        ->get();
                                    if (!empty($prod_value_count)) {
                                        ?>
                                                         
                                                         <?php

                                        $prod_type = DB::table('product_attribute_type')
                                            ->where('delete_status', '=', '')
                                            ->where('status', '=', 1)
                                            ->where('attr_id', '=', $prod_value[0]->attr_id)
                                            ->get();


                                        $value_namer .= '<b class="black">' . $prod_type[0]->attr_name . '</b> - ' . $prod_value[0]->attr_value . ', ';
                                    }

                                    ?>
                                               
                                                
                                                <?php

                                }

                                $attri_name = rtrim($value_namer, ', ');






                                ?>


                                <td class="cart-product-edit">
                                    <?php if(!empty($product->prod_attribute)){ ?>
                                    (<?php echo $attri_name;?>)
                                    <?php } ?>

                                </td>


                                <td class="cart-product-quantity">
                                    <?php echo $setts[0]->site_currency . ' ' . number_format($product->price, 2);?>
                                    <br/> <?php echo $product->quantity;?> @lang('languages.qty')
                                </td>

                                <?php
                                $check = DB::table('product_rating')
                                    ->where('user_id', '=', $product->user_id)
                                    ->where('prod_id', '=', $product->prod_id)
                                    ->count();
                                if (!empty($check)) {
                                    $check_view = DB::table('product_rating')
                                        ->where('user_id', '=', $product->user_id)
                                        ->where('prod_id', '=', $product->prod_id)
                                        ->get();
                                    $ratinger = $check_view[0]->rating;

                                } else {
                                    $ratinger = "";
                                }



                                $check_use = DB::table('users')
                                    ->where('id', '=', $product->prod_user_id)
                                    ->count();
                                if (!empty($check_use)) {
                                    $checkers = DB::table('users')
                                        ->where('id', '=', $product->prod_user_id)
                                        ->get();

                                    $prod_usernames = $checkers[0]->name;
                                    $prod_userslug = $checkers[0]->post_slug;
                                } else {
                                    $prod_usernames = "";
                                    $prod_userslug = "";
                                }


                                ?>


                                <td class="cart-product-sub-total"><a
                                            href="<?php echo $url;?>/profile/<?php echo $product->prod_user_id;?>/<?php echo $prod_userslug;?>"
                                            class="theme_color"><?php echo $prod_usernames;?></a></td>
                                <td class="cart-product-grand-total">


                                    <?php if($product->status == "completed"){?>

                                    <a data-toggle="modal" data-target="#myModal<?php echo $product->ord_id;?>"
                                       style="color:#000099; cursor:pointer;">@lang('languages.click_rating_review')</a> <?php if($ratinger == 1){?>
                                    <p class="review-icon">

                                        <i class="fa fa-star yellow" aria-hidden="true"></i>


                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </p><?php } ?>
                                    <?php if($ratinger == 2){?>
                                    <p class="review-icon">

                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>


                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </p><?php } ?>
                                    <?php if($ratinger == 3){?>
                                    <p class="review-icon">

                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>


                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </p><?php } ?>

                                    <?php if($ratinger == 4){?>
                                    <p class="review-icon">

                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>

                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </p><?php } ?>
                                    <?php if($ratinger == 5){?>
                                    <p class="review-icon">

                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>
                                        <i class="fa fa-star yellow" aria-hidden="true"></i>


                                    </p><?php } ?>

                                    <?php } ?>


                                </td>


                            </tr>


                            <div class="modal fade" id="myModal<?php echo $product->ord_id;?>">
                                <div class="modal-dialog modal-lg">
                                    <div class="Quick-view-popup modal-content text-left">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="col-md-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-xs-12 marB30">
                                                            <figure>
                                                                <?php
                                                                if(!empty($product_img_count)){
                                                                $product_img = DB::table('product_images')
                                                                    ->where('prod_token', '=', $prod_id)
                                                                    ->orderBy('prod_img_id', 'asc')
                                                                    ->get();



                                                                ?>
                                                                <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product_slug;?>"><img
                                                                            src="<?php echo $url;?>/local/images/media/<?php echo $product_img[0]->image;?>"
                                                                            alt="" style="width:100%; max-width:350px;"></a>
                                                                <?php } else { ?>
                                                                <a href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product_slug;?>"><img
                                                                            src="<?php echo $url;?>/local/images/noimage_box.jpg"
                                                                            alt="" style="width:100%; max-width:350px;"></a>
                                                                <?php } ?>
                                                            </figure>
                                                        </div>
                                                    </div>
                                                </div>


                                                <form class="form-horizontal" role="form" method="POST"
                                                      action="{{ route('view-shopping') }}" id="RATEID"
                                                      enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="col-md-6 col-sm-6 col-xs-12 padT30">
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div class="caption price-box  marB30">
                                                                    <h3>@lang('languages.rating_review')</h3>
                                                                    <div class="clear height10"></div>
                                                                    <h5 class="color-gray"><a
                                                                                href="<?php echo $url;?>/product/<?php echo $product->prod_id;?>/<?php echo $product_slug;?>"><?php echo $product_names;?></a>
                                                                    </h5>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="user_id"
                                                                   value="<?php echo $product->user_id;?>">
                                                            <input type="hidden" name="prod_id"
                                                                   value="<?php echo $product->prod_id;?>">

                                                            <?php
                                                            $check = DB::table('product_rating')
                                                                ->where('user_id', '=', $product->user_id)
                                                                ->where('prod_id', '=', $product->prod_id)
                                                                ->count();
                                                            if (!empty($check)) {
                                                                $check_view = DB::table('product_rating')
                                                                    ->where('user_id', '=', $product->user_id)
                                                                    ->where('prod_id', '=', $product->prod_id)
                                                                    ->get();

                                                            }
                                                            ?>

                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div class="row">
                                                                    <div class="quantity-box marB30">
                                                                        <div class="col-md-12 col-sm-12">
                                                                            <h4>@lang('languages.rating')</h4>
                                                                            <p class="review-icon">
                                                        
                                                    <span>
                                                    <input type="radio" name="rating" value="5"
                                                           <?php if(!empty($check)){ if($check_view[0]->rating == 5){ ?> checked
                                                           <?php } } ?> required="required">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>

                                                                            </p>

                                                                            <p class="review-icon">
                                                        
                                                    <span>
                                                    <input type="radio" name="rating" value="4"
                                                           <?php if(!empty($check)){ if($check_view[0]->rating == 4){ ?> checked
                                                           <?php } } ?> required="required">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    </span>

                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                            </p>


                                                                            <p class="review-icon">
                                                        
                                                    <span>
                                                    <input type="radio" name="rating" value="3"
                                                           <?php if(!empty($check)){ if($check_view[0]->rating == 3){ ?> checked
                                                           <?php } } ?> required="required">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    </span>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                            </p>


                                                                            <p class="review-icon">
                                                        
                                                    <span>
                                                    <input type="radio" name="rating" value="2"
                                                           <?php if(!empty($check)){ if($check_view[0]->rating == 2){ ?> checked
                                                           <?php } } ?> required="required">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    
                                                    </span>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                            </p>


                                                                            <p class="review-icon">
                                                        
                                                    <span>
                                                    <input type="radio" name="rating" value="1"
                                                           <?php if(!empty($check)){ if($check_view[0]->rating == 1){ ?> checked
                                                           <?php } } ?> required="required">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    
                                                    
                                                    </span>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                                <i class="fa fa-star"
                                                                                   aria-hidden="true"></i>
                                                                            </p>


                                                                        </div>

                                                                        <div class="clear height20"></div>

                                                                        <div class="col-md-10 col-sm-10 ">
                                                                            <h4>@lang('languages.write_a_review')</h4>
                                                                            <textarea rows="3" name="review"
                                                                                      class="form-control unicase-form-control"
                                                                                      required="required"><?php if (!empty($check)) {
                                                                                    echo $check_view[0]->review;
                                                                                } ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 height10"></div>
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <div class="add-to-cart">
                                                                            <input type="submit" name="submit"
                                                                                   value="@lang('languages.submit')"
                                                                                   class="btn-upper btn btn-primary">


                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12 height50"></div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>


                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <?php } } ?>


                            </tbody><!-- /tbody -->
                        </table><!-- /table -->
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
