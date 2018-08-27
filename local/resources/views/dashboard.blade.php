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


@include('header')


<div class="breadcrumb">
    <div class="container-fluid">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo $url;?>">@lang('languages.home')</a></li>
                <li class='active'>@lang('languages.my_dashboard')</li>
            </ul>
        </div>
    </div>
</div>


<div class="body-content">
    <div class="container-fluid">
        <div class="contact-page">

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
                <div class="col-md-12 col-sm-12">


                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @lang('languages.some_problem')
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

            </div>


            <div class="col-md-12 row">
                <div class="heading-title">@lang('languages.dashboard')</div>
            </div>


            <div class="height10 clearfix"></div>


            <div class="col-md-12" style="display:none;">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#profileSetting" data-toggle="tab">Profile setting</a></li>
                    <li><a href="#billingDetail" data-toggle="tab">Billing detail</a></li>
                    <li><a href="#shippingDetail" data-toggle="tab">Shipping detail</a></li>
                </ul>
            </div>

            <form class="register-form" role="form" method="POST" action="{{ route('dashboard') }}" id="formID"
                  enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="tab-content" style="padding-left:0">
                    <div class="tab-pane active m-t-20" id="profileSetting">

                        <div class="height20 clearfix"></div>

                        <div class="col-md-6 contact-form">


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.username') </label>
                                    <input type="text" placeholder="Username" name="name"
                                           class="form-control unicase-form-control"
                                           value="<?php echo $editprofile[0]->name;?>" readonly>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.phone') </label>
                                    <input type="text" placeholder="Phone" class="form-control unicase-form-control"
                                           name="phone" value="<?php echo $editprofile[0]->phone;?>">
                                    @if ($errors->has('phone'))
                                        <p class="help-block red">
                                            {{ $errors->first('phone') }}
                                        </p>
                                    @endif

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.country') </label>

                                    <select name="country" class="form-control unicase-form-control">

                                        <option value="">Select Country</option>
                                        <?php foreach($countries as $country){?>
                                        <option value="<?php echo $country;?>"
                                                <?php if($editprofile[0]->country == $country){?> selected <?php } ?>><?php echo $country;?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.password') </label>


                                    <input type="text" placeholder="Password" name="password" value=""
                                           class="form-control unicase-form-control">

                                </div>
                            </div>


                            <?php if(Auth::user()->admin == 2){?>
                            <div class="col-md-12">
                                <div class="form-group">


                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.local_shipping_price') </label>
                                    <input type="number" placeholder="Local shipping price" name="local_shipping_price"
                                           class="form-control unicase-form-control"
                                           value="<?php echo $editprofile[0]->local_shipping_price;?>">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.world_shipping_price') </label>
                                    <input type="number" placeholder="World shipping price" name="world_shipping_price"
                                           class="form-control unicase-form-control"
                                           value="<?php echo $editprofile[0]->world_shipping_price;?>">
                                </div>
                            </div>


                            <?php } else {?>
                            <input type="hidden" name="local_shipping_price" value="0">
                            <input type="hidden" name="world_shipping_price" value="0">
                            <?php } ?>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputName">@lang('languages.email') </label>

                                    <input type="text" placeholder="Email" name="email"
                                           class="form-control unicase-form-control"
                                           value="<?php echo $editprofile[0]->email;?>" readonly>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                        </div>


                        <div class="col-md-6 contact-form">


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.gender') </label>
                                    <select name="gender" class="form-control unicase-form-control">

                                        <option value="">Gender</option>
                                        <option value="male"
                                                <?php if($editprofile[0]->gender == "male"){?> selected <?php } ?>>Male
                                        </option>
                                        <option value="female"
                                                <?php if($editprofile[0]->gender == "female"){?> selected <?php } ?>>
                                            Female
                                        </option>
                                    </select>

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.address') </label>


                                    <input type="text" placeholder="Address" name="address"
                                           class="form-control unicase-form-control"
                                           value="<?php echo $editprofile[0]->address;?>">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.about') </label>


                                    <textarea placeholder="About Description" name="about"
                                              class="form-control unicase-form-control"
                                              style="min-height:150px;"><?php echo $editprofile[0]->about;?></textarea>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.profile_photo') </label>

                                    <div class="col-md-3 col-sm-3">
                                        <p><?php

                                            $userphoto = "/media/";
                                            $path = '/local/images' . $userphoto . $editprofile[0]->photo;
                                            if($editprofile[0]->photo != ""){?>
                                            <img src="<?php echo $url . $path;?>"
                                                 class="img_responsive round profile_size" alt="">
                                            <?php } else { ?>
                                            <img src="<?php echo $url . '/local/images/nophoto.jpg';?>"
                                                 class="img_responsive round profile_size" alt="">
                                            <?php } ?></p>
                                    </div>
                                    <div class="col-md-9 col-sm-9">

                                        <input type="file" id="photo" name="photo" class="pic_photo"
                                               class="form-control unicase-form-control">
                                        <p>( @lang('languages.upload_size') : 200 X 200 )</p>
                                        @if ($errors->has('photo'))
                                            <span class="help-block" style="color:red;">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.profile_banner') </label>

                                    <div class="col-md-3 col-sm-3">
                                        <p><?php

                                            $userphoto_two = "/media/";
                                            $path_two = '/local/images' . $userphoto_two . $editprofile[0]->profile_banner;
                                            if($editprofile[0]->profile_banner != ""){?>
                                            <img src="<?php echo $url . $path_two;?>" class="img_responsive banner_size"
                                                 alt="">
                                            <?php } else { ?>
                                            <img src="<?php echo $url . '/local/images/noimage.jpg';?>"
                                                 class="img_responsive banner_size" alt="">
                                            <?php } ?></p>
                                    </div>
                                    <div class="col-md-9 col-sm-9">

                                        <input type="file" id="profile_banner" name="profile_banner" class="pic_photo">
                                        <p>( @lang('languages.upload_size') : 1140 X 370 )</p>
                                        @if ($errors->has('profile_banner'))
                                            <span class="help-block" style="color:red;">
                                        <strong>{{ $errors->first('profile_banner') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>


                    <div class="tab-pane m-t-20" id="billingDetail" style="display:none;">
                        <div class="height20 clearfix"></div>

                        <div class="col-md-6 contact-form">


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.first_name') </label>

                                    <input type="text" placeholder="First Name" name="bill_firstname"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_firstname; ?><?php } ?>">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.last_name') </label>


                                    <input type="text" placeholder="Last Name" name="bill_lastname"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_lastname; ?><?php } ?>">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.company_name') </label>


                                    <input type="text" placeholder="Company Name" name="bill_companyname"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_companyname; ?><?php } ?>">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.email') </label>

                                    <input type="text" placeholder="Email" name="bill_email"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_email; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.phone')</label>


                                    <input type="text" placeholder="Phone" name="bill_phone"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_phone; ?><?php } ?>">

                                </div>
                            </div>


                        </div>


                        <div class="col-md-6 contact-form">


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.select') @lang('languages.country') </label>


                                    <select name="bill_country" class="form-control unicase-form-control">

                                        <option value="">@lang('languages.select') @lang('languages.country')</option>
                                        <?php foreach($countries as $country){?>
                                        <option value="<?php echo $country;?>"
                                                <?php if(!empty($edited_count)){?><?php if($edited[0]->bill_country == $country){?> selected <?php } ?><?php } ?>><?php echo $country;?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.address') </label>
                                    <input type="text" placeholder="Address" name="bill_address"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_address; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.city') </label>


                                    <input type="text" placeholder="City" name="bill_city"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_city; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.state') </label>

                                    <input type="text" placeholder="State" name="bill_state"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_state; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.postcode') </label>


                                    <input type="text" placeholder="Postcode" name="bill_postcode"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->bill_postcode; ?><?php } ?>">


                                </div>
                            </div>


                        </div>


                    </div>


                    <div class="tab-pane m-t-20" id="shippingDetail" style="display:none;">
                        <div class="height20 clearfix"></div>

                        <div class="col-md-6 contact-form">

                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.first_name') </label>

                                    <input type="text" placeholder="First Name" name="ship_firstname"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_firstname; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.last_name') </label>


                                    <input type="text" placeholder="Last Name" name="ship_lastname"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_lastname; ?><?php } ?>">

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.company_name') </label>

                                    <input type="text" placeholder="Company Name" name="ship_companyname"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_companyname; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.email') </label>


                                    <input type="text" placeholder="Email" name="ship_email"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_email; ?><?php } ?>">

                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.phone') </label>

                                    <input type="text" placeholder="Phone" name="ship_phone"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_phone; ?><?php } ?>">


                                </div>
                            </div>


                        </div>


                        <div class="col-md-6 contact-form">

                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.select') @lang('languages.country') </label>

                                    <select name="ship_country" class="form-control unicase-form-control">

                                        <option value="">@lang('languages.select') @lang('languages.country')</option>
                                        <?php foreach($countries as $country){?>
                                        <option value="<?php echo $country;?>"
                                                <?php if(!empty($edited_count)){?><?php if($edited[0]->ship_country == $country){?> selected <?php } ?><?php } ?>><?php echo $country;?></option>
                                        <?php } ?>
                                    </select>


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.address') </label>


                                    <input type="text" placeholder="Address" name="ship_address"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_address; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.city') </label>

                                    <input type="text" placeholder="City" name="ship_city"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_city; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title" for="exampleInputName">@lang('languages.state') </label>


                                    <input type="text" placeholder="State" name="ship_state"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_state; ?><?php } ?>">


                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="info-title"
                                           for="exampleInputName">@lang('languages.postcode') </label>

                                    <input type="text" placeholder="Postcode" name="ship_postcode"
                                           class="form-control unicase-form-control"
                                           value="<?php if (!empty($edited_count)) { ?><?php echo $edited[0]->ship_postcode; ?><?php } ?>">


                                    <input type="hidden" name="savepassword"
                                           value="<?php echo $editprofile[0]->password;?>">
                                    <input type="hidden" name="currentphoto"
                                           value="<?php echo $editprofile[0]->photo;?>">

                                    <input type="hidden" name="currentbanner"
                                           value="<?php echo $editprofile[0]->profile_banner;?>">


                                </div>
                            </div>

                            <input type="hidden" name="id" value="<?php echo $editprofile[0]->id; ?>">
                            <input type="hidden" name="enable_ship" value="1">

                        </div>


                    </div>


                </div>


                <div class="col-md-12 outer-bottom-small m-t-20">
                    <?php if(config('global.demosite') == "yes"){?>
                    <button type="submit" class="btn-upper btn btn-primary">@lang('languages.update')</button>
                    <span class="disabletxt">( <?php echo config('global.demotxt');?> )</span><?php } else { ?>

                    <button id="send" type="submit" class="btn-upper btn btn-primary">@lang('languages.update')</button>
                    <?php } ?>
                </div>


            </form>


        </div>


    </div>


</div>
</div>

<div class="height30"></div>

@include('footer')

</body>
</html>