<?php
/*
    Template Name: Account
*/
global $uuiduser;
global $current_user;
global $user_id;
global $nb_user_votes;
global $user_full_data;
global $info_user_level;
global $list_t_done;
get_header();
global $user_role;
$list_t_begin   = $user_full_data[0]['list_user_ranking_begin'];
$data_t_created = get_creator_t($user_id);
$list_t_created = $data_t_created[0]['creator_tops'];
?>
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">

            <section class="app-user-view">
                <?php if(!is_user_logged_in()): ?>
                    <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-account" data-v-aa799a9e="">
                        <div class="alert-body d-flex align-items-center justify-content-between">
                            <span><span class="ico">💾</span> Pour sauvegarder et retrouver sur tout tes supports ta progression l'idéal serait de te créer un compte.</span>
                            <div class="btns-alert text-right">
                                <a class="btn btn-outline-white waves-effect mr-1 t-white" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                                    J'ai déjà un compte
                                </a>
                                <a class="btn btn-primary waves-effect" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                                    Excellente idée - je créé mon compte <span class="ico">🎉</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </section>

            <div id="user-profile">
                <div class="row">
                    <div class="col-12">
                        <div class="card profile-header mb-2">

                            <div class="card-img-top cover-profil"></div>

                            <div class="position-relative">
                                <div class="profile-img-container d-flex align-items-center">
                                    <?php
                                    if(is_user_logged_in() && get_avatar_url($user_id, ['size' => '80'])){
                                        $avatar_url = get_avatar_url($user_id, ['size' => '80']);
                                    }
                                    else{
                                        $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
                                    }
                                    ?>
                                    <div class="profile-img">
                                        <img src="<?php echo $avatar_url; ?>" class="avatar img-fluid" alt="Avatar"/>
                                    </div>
                                    <div class="profile-title ml-3">
                                        <h2 class="text-white text-uppercase">
                                            <?php if(is_user_logged_in()): ?>
                                                <?php echo $current_user->display_name; ?>
                                            <?php else: ?>
                                                Anonyme
                                            <?php endif; ?>
                                        </h2>
                                        <p class="text-white">
                                            <span class="ico">🦙</span>
                                            <span class="ico">🧰</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- tabs pill -->
                            <div class="profile-header-nav">
                                <!-- navbar -->
                                <nav class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
                                    <button class="btn btn-icon navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                    </button>

                                    <!-- collapse  -->
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <div class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0">
                                            <ul class="nav nav-pills mb-0">
                                                <li class="nav-item">
                                                    <a class="nav-link font-weight-bold btn btn-primary" href="javascript:void(0)">
                                                        <span class="d-none d-md-block">Récap</span>
                                                        <i data-feather="rss" class="d-block d-md-none"></i>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link font-weight-bold" href="javascript:void(0)">
                                                        <span class="d-none d-md-block">Tops</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link font-weight-bold" href="javascript:void(0)">
                                                        <span class="d-none d-md-block">Créateur</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- edit button -->
                                            <div class="">
                                                <a href="" class="btn btn-outline-primary waves-effect">
                                                    <i data-feather="edit" class="d-block d-md-none"></i>
                                                    <span class="font-weight-bold d-none d-md-block">Editer</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ collapse  -->
                                </nav>
                                <!--/ navbar -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ profile header -->

                <!-- profile info section -->
                <section id="profile-info">
                    <div class="row">
                        <!-- left profile info section -->
                        <div class="col-lg-3 col-12 order-2 order-lg-1">
                            <!-- about -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-75">About</h5>
                                    <p class="card-text">
                                        Tart I love sugar plum I love oat cake. Sweet ⭐️ roll caramels I love jujubes. Topping cake wafer.
                                    </p>
                                    <div class="mt-2">
                                        <h5 class="mb-75">Joined:</h5>
                                        <p class="card-text">November 15, 2015</p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-75">Lives:</h5>
                                        <p class="card-text">New York, USA</p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-75">Email:</h5>
                                        <p class="card-text">bucketful@fiendhead.org</p>
                                    </div>
                                    <div class="mt-2">
                                        <h5 class="mb-50">Website:</h5>
                                        <p class="card-text mb-0">www.pixinvent.com</p>
                                    </div>
                                </div>
                            </div>
                            <!--/ about -->

                            <!-- suggestion pages -->
                            <div class="card">
                                <div class="card-body profile-suggestion">
                                    <h5 class="mb-2">Suggested Pages</h5>
                                    <!-- user suggestions -->
                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/avatars/12-small.png" alt="avatar img" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Peter Reed</h6>
                                            <small class="text-muted">Company</small>
                                        </div>
                                        <div class="profile-star ml-auto"><i data-feather="star" class="font-medium-3"></i></div>
                                    </div>
                                    <!-- user suggestions -->
                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/avatars/1-small.png" alt="avatar" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Harriett Adkins</h6>
                                            <small class="text-muted">Company</small>
                                        </div>
                                        <div class="profile-star ml-auto"><i data-feather="star" class="font-medium-3"></i></div>
                                    </div>
                                    <!-- user suggestions -->
                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/avatars/10-small.png" alt="avatar" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Juan Weaver</h6>
                                            <small class="text-muted">Company</small>
                                        </div>
                                        <div class="profile-star ml-auto"><i data-feather="star" class="font-medium-3"></i></div>
                                    </div>
                                    <!-- user suggestions -->
                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/avatars/3-small.png" alt="avatar img" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Claudia Chandler</h6>
                                            <small class="text-muted">Company</small>
                                        </div>
                                        <div class="profile-star ml-auto"><i data-feather="star" class="font-medium-3"></i></div>
                                    </div>
                                    <!-- user suggestions -->
                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/avatars/5-small.png" alt="avatar img" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Earl Briggs</h6>
                                            <small class="text-muted">Company</small>
                                        </div>
                                        <div class="profile-star ml-auto">
                                            <i data-feather="star" class="profile-favorite font-medium-3"></i>
                                        </div>
                                    </div>
                                    <!-- user suggestions -->
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/avatars/6-small.png" alt="avatar img" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Jonathan Lyons</h6>
                                            <small class="text-muted">Beauty Store</small>
                                        </div>
                                        <div class="profile-star ml-auto"><i data-feather="star" class="font-medium-3"></i></div>
                                    </div>
                                </div>
                            </div>
                            <!--/ suggestion pages -->

                            <!-- twitter feed card -->
                            <div class="card">
                                <div class="card-body">
                                    <h5>Twitter Feeds</h5>
                                    <!-- twitter feed -->
                                    <div class="profile-twitter-feed mt-1">
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="../../../app-assets/images/avatars/5-small.png" alt="avatar img" height="40" width="40" />
                                            </div>
                                            <div class="profile-user-info">
                                                <h6 class="mb-0">Gertrude Stevens</h6>
                                                <a href="javascript:void(0)">
                                                    <small class="text-muted">@tiana59</small>
                                                    <i data-feather="check-circle"></i>
                                                </a>
                                            </div>
                                            <div class="profile-star ml-auto">
                                                <i data-feather="star" class="font-medium-3"></i>
                                            </div>
                                        </div>
                                        <p class="card-text mb-50">I love cookie chupa chups sweet tart apple pie ⭐️ chocolate bar.</p>
                                        <a href="javascript:void(0)">
                                            <small>#design #fasion</small>
                                        </a>
                                    </div>
                                    <!-- twitter feed -->
                                    <div class="profile-twitter-feed mt-2">
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="../../../app-assets/images/avatars/12-small.png" alt="avatar img" height="40" width="40" />
                                            </div>
                                            <div class="profile-user-info">
                                                <h6 class="mb-0">Lura Jones</h6>
                                                <a href="javascript:void(0)">
                                                    <small class="text-muted">@tiana59</small>
                                                    <i data-feather="check-circle"></i>
                                                </a>
                                            </div>
                                            <div class="profile-star ml-auto">
                                                <i data-feather="star" class="font-medium-3 profile-favorite"></i>
                                            </div>
                                        </div>
                                        <p class="card-text mb-50">Halvah I love powder jelly I love cheesecake cotton candy. 😍</p>
                                        <a href="javascript:void(0)">
                                            <small>#vuejs #code #coffeez</small>
                                        </a>
                                    </div>
                                    <!-- twitter feed -->
                                    <div class="profile-twitter-feed mt-2">
                                        <div class="d-flex justify-content-start align-items-center mb-1">
                                            <div class="avatar mr-1">
                                                <img src="../../../app-assets/images/avatars/1-small.png" alt="avatar img" height="40" width="40" />
                                            </div>
                                            <div class="profile-user-info">
                                                <h6 class="mb-0">Norman Gross</h6>
                                                <a href="javascript:void(0)">
                                                    <small class="text-muted">@tiana59</small>
                                                    <i data-feather="check-circle"></i>
                                                </a>
                                            </div>
                                            <div class="profile-star ml-auto">
                                                <i data-feather="star" class="font-medium-3"></i>
                                            </div>
                                        </div>
                                        <p class="card-text mb-50">Candy jelly beans powder brownie biscuit. Jelly marzipan oat cake cake.</p>
                                        <a href="javascript:void(0)">
                                            <small>#sketch #uiux #figma</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/ twitter feed card -->
                        </div>
                        <!--/ left profile info section -->

                        <!-- center profile info section -->
                        <div class="col-lg-6 col-12 order-1 order-lg-2">
                            <!-- post 1 -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                        <!-- avatar -->
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-18.jpg" alt="avatar img" height="50" width="50" />
                                        </div>
                                        <!--/ avatar -->
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Leeanna Alvord</h6>
                                            <small class="text-muted">12 Dec 2018 at 1:16 AM</small>
                                        </div>
                                    </div>
                                    <p class="card-text">
                                        Wonderful Machine· A well-written bio allows viewers to get to know a photographer beyond the work. This
                                        can make the difference when presenting to clients who are looking for the perfect fit.
                                    </p>
                                    <!-- post img -->
                                    <img class="img-fluid rounded mb-75" src="../../../app-assets/images/profile/post-media/2.jpg" alt="avatar img" />
                                    <!--/ post img -->

                                    <!-- like share -->
                                    <div class="row d-flex justify-content-start align-items-center flex-wrap pb-50">
                                        <div class="col-sm-6 d-flex justify-content-between justify-content-sm-start mb-2">
                                            <a href="javascript:void(0)" class="d-flex align-items-center text-muted text-nowrap">
                                                <i data-feather="heart" class="profile-likes font-medium-3 mr-50"></i>
                                                <span>1.25k</span>
                                            </a>

                                            <!-- avatar group with tooltip -->
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-group ml-1">
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Trina Lynes" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Lilian Nenez" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Alberto Glotzbach" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-3.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="George Nordic" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Vinnie Mostowy" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-4.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                </div>
                                                <a href="javascript:void(0)" class="text-muted text-nowrap ml-50">+140 more</a>
                                            </div>
                                            <!-- avatar group with tooltip -->
                                        </div>

                                        <!-- share and like count and icons -->
                                        <div class="col-sm-6 d-flex justify-content-between justify-content-sm-end align-items-center mb-2">
                                            <a href="javascript:void(0)" class="text-nowrap">
                                                <i data-feather="message-square" class="text-body font-medium-3 mr-50"></i>
                                                <span class="text-muted mr-1">1.25k</span>
                                            </a>

                                            <a href="javascript:void(0)" class="text-nowrap">
                                                <i data-feather="share-2" class="text-body font-medium-3 mx-50"></i>
                                                <span class="text-muted">1.25k</span>
                                            </a>
                                        </div>
                                        <!-- share and like count and icons -->
                                    </div>
                                    <!-- like share -->

                                    <!-- comments -->
                                    <div class="d-flex align-items-start mb-1">
                                        <div class="avatar mt-25 mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" alt="Avatar" height="34" width="34" />
                                        </div>
                                        <div class="profile-user-info w-100">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="mb-0">Kitty Allanson</h6>
                                                <a href="javascript:void(0)">
                                                    <i data-feather="heart" class="text-body font-medium-3"></i>
                                                    <span class="align-middle text-muted">34</span>
                                                </a>
                                            </div>
                                            <small>Easy & smart fuzzy search🕵🏻 functionality which enables users to search quickly.</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-1">
                                        <div class="avatar mt-25 mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="Avatar" height="34" width="34" />
                                        </div>
                                        <div class="profile-user-info w-100">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="mb-0">Jackey Potter</h6>
                                                <a href="javascript:void(0)">
                                                    <i data-feather="heart" class="profile-likes font-medium-3"></i>
                                                    <span class="align-middle text-muted">61</span>
                                                </a>
                                            </div>
                                            <small>
                                                Unlimited color🖌 options allows you to set your application color as per your branding 🤪.
                                            </small>
                                        </div>
                                    </div>
                                    <!--/ comments -->

                                    <!-- comment box -->
                                    <fieldset class="form-label-group mb-75">
                                        <textarea class="form-control" id="label-textarea" rows="3" placeholder="Add Comment"></textarea>
                                        <label for="label-textarea">Add Comment</label>
                                    </fieldset>
                                    <!--/ comment box -->
                                    <button type="button" class="btn btn-sm btn-primary">Post Comment</button>
                                </div>
                            </div>
                            <!--/ post 1 -->

                            <!-- post 2 -->
                            <div class="card">
                                <div class="card-body">
                                    <!-- avatar image and title -->
                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-22.jpg" alt="avatar img" height="50" width="50" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Rosa Walters</h6>
                                            <small class="text-muted">11 Dec 2019 at 1:16 AM</small>
                                        </div>
                                    </div>
                                    <!--/ avatar image and title -->
                                    <p class="card-text">
                                        Wonderful Machine· A well-written bio allows viewers to get to know a photographer beyond the work. This
                                        can make the difference when presenting to clients who are looking for the perfect fit.
                                    </p>
                                    <!-- post img -->
                                    <img class="img-fluid rounded mb-75" src="../../../app-assets/images/profile/post-media/25.jpg" alt="avatar img" />
                                    <!--/ post img -->

                                    <!-- like share -->
                                    <div class="row d-flex justify-content-start align-items-center flex-wrap pb-50">
                                        <div class="col-sm-6 d-flex justify-content-between justify-content-sm-start mb-2">
                                            <a href="javascript:void(0)" class="d-flex align-items-center text-muted text-nowrap">
                                                <i data-feather="heart" class="profile-likes font-medium-3 mr-50"></i>
                                                <span>1.25k</span>
                                            </a>

                                            <!-- avatar group with tooltip -->
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-group ml-1">
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Trina Lynes" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Lilian Nenez" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-2.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Alberto Glotzbach" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-3.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="George Nordic" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Vinnie Mostowy" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-4.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                </div>
                                                <a href="javascript:void(0)" class="text-muted text-nowrap ml-50">+271 more</a>
                                            </div>
                                            <!-- avatar group with tooltip -->
                                        </div>

                                        <!-- share and like count and icons -->
                                        <div class="col-sm-6 d-flex justify-content-between justify-content-sm-end align-items-center mb-2">
                                            <a href="javascript:void(0)" class="text-nowrap">
                                                <i data-feather="message-square" class="text-body font-medium-3 mr-50"></i>
                                                <span class="text-muted mr-1">1.25k</span>
                                            </a>

                                            <a href="javascript:void(0)" class="text-nowrap">
                                                <i data-feather="share-2" class="text-body font-medium-3 mx-50"></i>
                                                <span class="text-muted">1.25k</span>
                                            </a>
                                        </div>
                                        <!-- share and like count and icons -->
                                    </div>
                                    <!-- like share -->

                                    <!-- comments -->
                                    <div class="d-flex align-items-start mb-1">
                                        <div class="avatar mt-25 mr-50">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-3.jpg" alt="Avatar" height="34" width="34" />
                                        </div>
                                        <div class="profile-user-info w-100">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="mb-0">Kitty Allanson</h6>
                                                <a href="javascript:void(0)">
                                                    <i data-feather="heart" class="text-body font-medium-3"></i>
                                                    <span class="align-middle text-muted">34</span>
                                                </a>
                                            </div>
                                            <small>Easy & smart fuzzy search🕵🏻 functionality which enables users to search quickly. </small>
                                        </div>
                                    </div>
                                    <!--/ comments -->

                                    <!-- comment text area -->
                                    <fieldset class="form-label-group mb-75">
                                        <textarea class="form-control" id="label-textarea2" rows="3" placeholder="Add Comment"></textarea>
                                        <label for="label-textarea2">Add Comment</label>
                                    </fieldset>
                                    <!--/ comment text area -->
                                    <button type="button" class="btn btn-sm btn-primary">Post Comment</button>
                                </div>
                            </div>
                            <!--/ post 2 -->

                            <!-- post 3 -->
                            <div class="card">
                                <div class="card-body">
                                    <!-- avatar image title -->
                                    <div class="d-flex justify-content-start align-items-center mb-1">
                                        <div class="avatar mr-1">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-15.jpg" alt="avatar img" height="50" width="50" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Charles Watson</h6>
                                            <small class="text-muted">12 Dec 2019 at 1:16 AM</small>
                                        </div>
                                    </div>
                                    <!--/ avatar image title -->

                                    <p class="card-text">
                                        Wonderful Machine· A well-written bio allows viewers to get to know a photographer beyond the work. This
                                        can make the difference when presenting to clients who are looking for the perfect fit.
                                    </p>

                                    <!-- video -->
                                    <iframe src="https://www.youtube.com/embed/6stlCkUDG_s" class="w-100 rounded border-0 height-250 mb-50"></iframe>
                                    <!--/ video -->

                                    <!-- like share -->
                                    <div class="row d-flex justify-content-start align-items-center flex-wrap pb-50">
                                        <div class="col-sm-6 d-flex justify-content-between justify-content-sm-start mb-2">
                                            <a href="javascript:void(0)" class="d-flex align-items-center text-muted text-nowrap">
                                                <i data-feather="heart" class="profile-likes font-medium-3 mr-50"></i>
                                                <span>1.25k</span>
                                            </a>

                                            <!-- avatar group with tooltip -->
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-group ml-1">
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Vinnie Mostowy" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Elicia Rieske" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Julee Rossignol" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-10.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Darcey Nooner" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Elicia Rieske" class="avatar pull-up">
                                                        <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="Avatar" height="26" width="26" />
                                                    </div>
                                                </div>
                                                <a href="javascript:void(0)" class="text-muted text-nowrap ml-50">+264 more</a>
                                            </div>
                                            <!-- avatar group with tooltip -->
                                        </div>

                                        <!-- share and like count and icons -->
                                        <div class="col-sm-6 d-flex justify-content-between justify-content-sm-end align-items-center mb-2">
                                            <a href="javascript:void(0)" class="text-nowrap">
                                                <i data-feather="message-square" class="text-body font-medium-3 mr-50"></i>
                                                <span class="text-muted mr-1">1.25k</span>
                                            </a>

                                            <a href="javascript:void(0)" class="text-nowrap">
                                                <i data-feather="share-2" class="text-body font-medium-3 mx-50"></i>
                                                <span class="text-muted">1.25k</span>
                                            </a>
                                        </div>
                                        <!-- share and like count and icons -->
                                    </div>
                                    <!-- like share -->

                                    <!-- comment -->
                                    <div class="d-flex align-items-start mb-1">
                                        <div class="avatar mt-25 mr-50">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-3.jpg" alt="Avatar" height="34" width="34" />
                                        </div>
                                        <div class="profile-user-info w-100">
                                            <div class="d-flex align-content-center justify-content-between">
                                                <h6 class="mb-0">Kitty Allanson</h6>
                                                <a href="javascript:void(0)">
                                                    <i data-feather="heart" class="text-body font-medium-3"></i>
                                                    <span class="align-middle text-muted">34</span>
                                                </a>
                                            </div>
                                            <small>Easy & smart fuzzy search🕵🏻 functionality which enables users to search quickly.</small>
                                        </div>
                                    </div>
                                    <!-- comment -->

                                    <!-- comment text area -->
                                    <fieldset class="form-label-group mb-75">
                                        <textarea class="form-control" id="label-textarea3" rows="3" placeholder="Add Comment"></textarea>
                                        <label for="label-textarea3">Add Comment</label>
                                    </fieldset>
                                    <!-- comment text area -->
                                    <button type="button" class="btn btn-sm btn-primary">Post Comment</button>
                                </div>
                            </div>
                            <!--/ post 3 -->
                        </div>
                        <!--/ center profile info section -->

                        <!-- right profile info section -->
                        <div class="col-lg-3 col-12 order-3">
                            <!-- latest profile pictures -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-0">Latest Photos</h5>
                                    <div class="row">
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-13.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-02.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-03.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-04.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-05.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-06.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-07.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-08.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-6 profile-latest-img">
                                            <a href="javascript:void(0)">
                                                <img src="../../../app-assets/images/profile/user-uploads/user-09.jpg" class="img-fluid rounded" alt="avatar img" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ latest profile pictures -->

                            <!-- suggestion -->
                            <div class="card">
                                <div class="card-body">
                                    <h5>Suggestions</h5>
                                    <div class="d-flex justify-content-start align-items-center mt-2">
                                        <div class="avatar mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg" alt="avatar" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Peter Reed</h6>
                                            <small class="text-muted">6 Mutual Friends</small>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-icon btn-sm ml-auto">
                                            <i data-feather="user-plus"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-start align-items-center mt-1">
                                        <div class="avatar mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" alt="avtar img holder" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Harriett Adkins</h6>
                                            <small class="text-muted">3 Mutual Friends</small>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm btn-icon ml-auto">
                                            <i data-feather="user-plus"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-start align-items-center mt-1">
                                        <div class="avatar mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" alt="avatar" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Juan Weaver</h6>
                                            <small class="text-muted">1 Mutual Friends</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary btn-icon ml-auto">
                                            <i data-feather="user-plus"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-start align-items-center mt-1">
                                        <div class="avatar mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="avatar img" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Claudia Chandler</h6>
                                            <small class="text-muted">16 Mutual Friends</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary btn-icon ml-auto">
                                            <i data-feather="user-plus"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-start align-items-center mt-1">
                                        <div class="avatar mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="avatar img" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Earl Briggs</h6>
                                            <small class="text-muted">4 Mutual Friends</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary btn-icon ml-auto">
                                            <i data-feather="user-plus"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-start align-items-center mt-1">
                                        <div class="avatar mr-75">
                                            <img src="../../../app-assets/images/portrait/small/avatar-s-10.jpg" alt="avatar img" height="40" width="40" />
                                        </div>
                                        <div class="profile-user-info">
                                            <h6 class="mb-0">Jonathan Lyons</h6>
                                            <small class="text-muted">25 Mutual Friends</small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary btn-icon ml-auto">
                                            <i data-feather="user-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--/ suggestion -->

                            <!-- polls card -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-1">Polls</h5>
                                    <p class="card-text mb-0">Who is the best actor in Marvel Cinematic Universe?</p>

                                    <!-- polls -->
                                    <div class="profile-polls-info mt-2">
                                        <!-- custom radio -->
                                        <div class="d-flex justify-content-between">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="bestActorPoll1" name="bestActorPoll" class="custom-control-input" />
                                                <label class="custom-control-label" for="bestActorPoll1">RDJ</label>
                                            </div>
                                            <div class="text-right">82%</div>
                                        </div>
                                        <!--/ custom radio -->

                                        <!-- progressbar -->
                                        <div class="progress progress-bar-primary my-50">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="58" aria-valuemin="58" aria-valuemax="100" style="width: 82%"></div>
                                        </div>
                                        <!--/ progressbar -->

                                        <!-- avatar group with tooltip -->
                                        <div class="avatar-group my-1">
                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Tonia Seabold" class="avatar pull-up">
                                                <img src="../../../app-assets/images/portrait/small/avatar-s-12.jpg" alt="Avatar" height="26" width="26" />
                                            </div>
                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Carissa Dolle" class="avatar pull-up">
                                                <img src="../../../app-assets/images/portrait/small/avatar-s-5.jpg" alt="Avatar" height="26" width="26" />
                                            </div>
                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Kelle Herrick" class="avatar pull-up">
                                                <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg" alt="Avatar" height="26" width="26" />
                                            </div>
                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Len Bregantini" class="avatar pull-up">
                                                <img src="../../../app-assets/images/portrait/small/avatar-s-10.jpg" alt="Avatar" height="26" width="26" />
                                            </div>
                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="John Doe" class="avatar pull-up">
                                                <img src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="Avatar" height="26" width="26" />
                                            </div>
                                        </div>
                                        <!--/ avatar group with tooltip -->
                                    </div>

                                    <div class="profile-polls-info mt-2">
                                        <div class="d-flex justify-content-between">
                                            <!-- custom radio -->
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="bestActorPoll2" name="bestActorPoll" class="custom-control-input" />
                                                <label class="custom-control-label" for="bestActorPoll2">Chris Hemswort</label>
                                            </div>
                                            <!--/ custom radio -->
                                            <div class="text-right">67%</div>
                                        </div>
                                        <!-- progressbar -->
                                        <div class="progress progress-bar-primary my-50">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="16" aria-valuemin="16" aria-valuemax="100" style="width: 67%"></div>
                                        </div>
                                        <!--/ progressbar -->

                                        <!-- avatar group with tooltips -->
                                        <div class="avatar-group mt-1">
                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Liliana Pecor" class="avatar pull-up">
                                                <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg" alt="Avatar" height="26" width="26" />
                                            </div>
                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Kasandra NaleVanko" class="avatar pull-up">
                                                <img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="Avatar" height="26" width="26" />
                                            </div>
                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="Jonathan Lyons" class="avatar pull-up">
                                                <img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="Avatar" height="26" width="26" />
                                            </div>
                                        </div>
                                        <!--/ avatar group with tooltips-->
                                    </div>
                                    <!--/ polls -->
                                </div>
                            </div>
                            <!--/ polls card -->
                        </div>
                        <!--/ right profile info section -->
                    </div>

                    <!-- reload button -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-sm btn-primary block-element border-0 mb-1">Load More</button>
                        </div>
                    </div>
                    <!--/ reload button -->
                </section>
                <!--/ profile info section -->
            </div>

        </div>
    </div>
</div>
<!-- END: Content-->

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section class="app-user-view">
                <?php if(!is_user_logged_in()): ?>
                    <div role="alert" aria-live="polite" aria-atomic="true" class="alert alert-account" data-v-aa799a9e="">
                        <div class="alert-body d-flex align-items-center justify-content-between">
                            <span><span class="ico">💾</span> Pour sauvegarder et retrouver sur tout tes supports ta progression l'idéal serait de te créer un compte.</span>
                            <div class="btns-alert text-right">
                                <a class="btn btn-outline-white waves-effect mr-1 t-white" href="<?php the_permalink(get_page_by_path('se-connecter')); ?>">
                                    J'ai déjà un compte
                                </a>
                                <a class="btn btn-primary waves-effect" href="<?php the_permalink(get_page_by_path('creer-mon-compte')); ?>">
                                    Excellente idée - je créé mon compte <span class="ico">🎉</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row match-height">
                    <div class="col-md-6">
                        <div class="card user-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="user-avatar-section">
                                    <div class="d-flex justify-content-start align-items-center content-avatar-name">
                                        <?php
                                        if(is_user_logged_in() && get_avatar_url($user_id, ['size' => '80'])){
                                            $avatar_url = get_avatar_url($user_id, ['size' => '80']);
                                        }
                                        else{
                                            $avatar_url = get_bloginfo('template_directory')."/assets/images/vkrz/ninja.png";
                                        }
                                        ?>
                                        <span class="avatar-picture-max" style="background-image: url(<?php echo $avatar_url; ?>);"></span>
                                        <div class="d-flex flex-column ml-2">
                                            <div class="user-info">
                                                <?php if(is_user_logged_in()): ?>
                                                    <h1 class="mb-0 text-uppercase">
                                                        <?php echo $current_user->display_name; ?>
                                                    </h1>
                                                    <div class="btn-account mt-1">
                                                        <a class="btn btn-outline-primary waves-effect mr-1" href="<?php the_permalink(get_page_by_path('parametres')); ?>">
                                                            Éditer
                                                        </a>
                                                        <a class="btn btn-outline-primary waves-effect" href="<?php echo get_author_posts_url($user_id); ?>">
                                                            Profil public
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <h1 class="mb-0 text-uppercase">
                                                        #FuturChampion
                                                    </h1>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="mb-1">
                                    <span class="ico4">💎</span>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo $nb_user_votes; ?>
                                </h2>
                                <p class="card-text legende">Votes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="mb-1">
                                    <span class="ico4">🏆</span>
                                </div>
                                <h2 class="font-weight-bolder">
                                    <?php echo count($list_t_done); ?>
                                </h2>
                                <p class="card-text legende">Tops terminés</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="pricing-badge text-right">
                                    <div class="badge badge-pill badge-light-primary">
                                        <a href="<?php the_permalink(get_page_by_path('evolution')); ?>">
                                            ?
                                        </a>
                                    </div>
                                </div>
                                <div class="user-level">
                                    <span class="icomax">
                                        <?php echo $info_user_level['level_ico']; ?>
                                    </span>
                                </div>
                                <p class="card-text legende">Niveau actuel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="stats_user">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row avg-sessions pt-50">
                                    <?php
                                    $cat_t = get_terms( array(
                                        'taxonomy'      => 'categorie',
                                        'orderby'       => 'count',
                                        'order'         => 'DESC',
                                        'hide_empty'    => true,
                                    ));
                                    foreach($cat_t as $cat) : ?>
                                        <?php
                                        $tops_in_cat = $cat->count;
                                        $id_cat      = $cat->term_id;
                                        $count_top_done_in_cat = 0; 
                                        foreach($list_t_done as $top_done){
                                            if($id_cat == $top_done['cat_t']){
                                                $count_top_done_in_cat++;
                                            }
                                        }
                                        $percent_done_cat = round($count_top_done_in_cat * 100 / $tops_in_cat);
                                        if($percent_done_cat >= 100){
                                            $classbar = "success";
                                        }
                                        elseif($percent_done_cat < 100 && $percent_done_cat >= 25){
                                            $classbar = "primary";
                                        }
                                        else{
                                            $classbar = "warning";
                                        }
                                        ?>
                                        <div class="col-md-3 mt-1 mb-1">
                                            <p class="mb-50">
                                                <span class="ico2">
                                                    <span class="<?php if($cat->term_id == 2){echo 'rotating';} ?>">
                                                        <?php the_field('icone_cat', 'term_'.$cat->term_id); ?>
                                                    </span>
                                                </span>
                                                <?php echo $cat->name; ?>
                                                <small class="infosmall text-<?php echo $classbar; ?>"><?php echo $count_top_done_in_cat; ?> sur <?php echo $tops_in_cat; ?>
                                                </small>
                                            </p>
                                            <div class="progress progress-bar-<?php echo $classbar; ?>" style="height: 6px">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent_done_cat; ?>" aria-valuemin="<?php echo $percent_done_cat; ?>" aria-valuemax="100" style="width: <?php echo $percent_done_cat; ?>%"></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="basic-tabs-components">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="homeIcon-tab" data-toggle="tab" href="#tab1" aria-controls="home" role="tab" aria-selected="true">
                            Mes Tops à terminer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profileIcon-tab" data-toggle="tab" href="#tab2" aria-controls="profile" role="tab" aria-selected="false">
                            Mes Tops terminés
                        </a>
                    </li>
                    <?php if($user_role == "administrator" || $user_role == "author"): ?>
                        <li class="nav-item">
                            <a class="nav-link" id="profileIcon-tab" data-toggle="tab" href="#tab3" aria-controls="profile" role="tab" aria-selected="false">
                                Mes Tops créés
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1" aria-labelledby="homeIcon-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card invoice-list-wrapper">
                                    <div class="card-datatable table-responsive">
                                        <table class="invoice-list-table table table-c5">
                                            <thead>
                                            <tr>
                                                <th class="">
                                                    <span class="t-rose"><?php echo count($list_t_begin); ?></span> Tops à terminer
                                                </th>
                                                <th class="text-center">
                                                    💎
                                                </th>
                                                <th class="">
                                                    🥇🥈🥉
                                                </th>
                                                <th>
                                                    👀
                                                </th>
                                                <th>

                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($list_t_begin as $r_user) : ?>
                                                <?php if($r_user['nb_votes'] > 0): ?>
                                                    <tr id="top-<?php echo $r_user['id_ranking']; ?>">
                                                        <td>
                                                            <div class="media-body">
                                                                <div class="media-heading">
                                                                    <h6 class="cart-item-title mb-0">
                                                                        <a class="text-body" href="<?php the_permalink($r_user['id_tournoi']); ?>">
                                                                            Top <?php echo $r_user['nb_top']; ?> - <?php echo get_the_title($r_user['id_tournoi']); ?>
                                                                        </a>
                                                                    </h6>
                                                                    <small class="cart-item-by legende">
                                                                        <?php the_field('question_t', $r_user['id_tournoi']); ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo $r_user['nb_votes']; ?> <span class="ico3">💎</span>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $user_top3 = get_user_ranking($r_user['id_ranking']);
                                                            $l=1;
                                                            foreach($user_top3 as $top => $p): ?>

                                                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                    <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                    <img src="<?php echo $illu; ?>" alt="Avatar">
                                                                </div>

                                                            <?php $l++; if($l==4) break; endforeach; ?>
                                                        </td>
                                                        <td>
                                                            <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_tournoi']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le classement mondial">
                                                                <span class="ico">
                                                                    🌍
                                                                </span>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex align-items-center col-actions">
                                                                <a href="<?php the_permalink($r_user['id_tournoi']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Continuer le Top">
                                                                    <span class="ico-action">▶️</span>
                                                                </a>
                                                                <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $r_user['id_ranking']; ?>" class="confirm_delete" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Recommencer le Top">
                                                                    <span class="ico-action">🆕</span>
                                                                </a>
                                                                <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Le Top sera supprimé définitivement 😱" data-idranking="<?php echo $r_user['id_ranking']; ?>" class="confirmDeleteReal" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Abandonner le Top">
                                                                    <span class="ico-action">🚮</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2" aria-labelledby="profileIcon-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card invoice-list-wrapper">
                                    <div class="card-datatable table-responsive">
                                        <table class="invoice-list-table table table-c7">
                                            <thead>
                                            <tr>
                                                <th class="">
                                                    <span class="t-rose"><?php echo count($list_t_done); ?></span> Tops terminés
                                                </th>
                                                <th class="text-right">
                                                    🌟
                                                </th>
                                                <th class="text-right">
                                                    💎
                                                </th>
                                                <th class="">
                                                    🥇🥈🥉
                                                </th>
                                                <th class="cp">
                                                    👯‍ <i class="fal fa-sort-alt"></i>
                                                </th>
                                                <th>
                                                    👀
                                                </th>
                                                <th>

                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($list_t_done as $r_user) : ?>
                                                <?php if($r_user['nb_votes'] > 0): ?>
                                                    <tr id="top-<?php echo $r_user['id_ranking']; ?>">
                                                        <td>
                                                            <div class="media-body">
                                                                <div class="media-heading">
                                                                    <h6 class="cart-item-title mb-0">
                                                                        <a class="text-body" href="<?php the_permalink($r_user['id_tournoi']); ?>">
                                                                            Top <?php echo $r_user['nb_top']; ?> - <?php echo get_the_title($r_user['id_tournoi']); ?>
                                                                        </a>
                                                                    </h6>
                                                                    <small class="cart-item-by legende">
                                                                        <?php the_field('question_t', $r_user['id_tournoi']); ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <div class=card-stars">
                                                                <?php
                                                                $note = get_note($r_user['id_tournoi'], $uuiduser);
                                                                if(isset($note[0]["note"]) && $note[0]["note"] > 0): ?>
                                                                    <div class="startchoicedone" style="display: block; !important">
                                                                        <span class="star_number">
                                                                            <?php echo $note[0]["note"]; ?>
                                                                        </span>
                                                                        <span class="ico">⭐️</span>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="starchoice" data-id-tournament="<?php echo $r_user['id_tournoi']; ?>" data-uuiduser="<?php echo $uuiduser; ?>">
                                                                        <span class="star star-1" data-star="1">⭐️</span>
                                                                        <span class="star star-2" data-star="2">⭐️</span>
                                                                        <span class="star star-3" data-star="3">⭐️</span>
                                                                    </div>
                                                                    <div class="startchoicedone toshow-<?php echo $r_user['id_tournoi']; ?>">
                                                                        <span class="star_number"></span>
                                                                        <span class="ico">⭐️</span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php echo $r_user['nb_votes']; ?> <span class="ico3">💎</span>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $user_top3 = get_user_ranking($r_user['id_ranking']);
                                                            $l=1;
                                                            foreach($user_top3 as $top => $p): ?>

                                                                <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo get_the_title($top); ?>" class="avatartop3 avatar pull-up">
                                                                    <?php $illu = get_the_post_thumbnail_url($top, 'thumbnail'); ?>
                                                                    <img src="<?php echo $illu; ?>" alt="Avatar">
                                                                </div>

                                                                <?php $l++; if($l==4) break; endforeach; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $similar = get_user_percent($r_user['uuid_user'], $r_user['id_tournoi']);
                                                            if($similar[0]['nb_similar'] == 0){
                                                                $wording_similar = "Aucun podium identique à celui-ci";
                                                            }
                                                            else{
                                                                $wording_similar = $similar[0]['nb_similar']." podiums identiques à celui-ci";
                                                            }
                                                            ?>
                                                            <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom" data-original-title="<?php echo $wording_similar; ?>">
                                                                <?php echo $similar[0]['percent']; ?>%
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center col-actions">
                                                                <?php
                                                                if($r_user['typetop'] == "top3"){
                                                                    $wording = "Voir le Top 3";
                                                                }
                                                                else{
                                                                    $wording = "Voir le Top complet";
                                                                }
                                                                ?>
                                                                <a class="mr-1" href="<?php the_permalink($r_user['id_ranking']); ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $wording; ?>">
                                                                    <span class="ico">
                                                                        🏆
                                                                    </span>
                                                                </a>
                                                                <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $r_user['id_tournoi']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le classement mondial">
                                                                    <span class="ico">
                                                                        🌍
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                                <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical font-medium-2">
                                                                        <circle cx="12" cy="12" r="1"></circle>
                                                                        <circle cx="12" cy="5" r="1"></circle>
                                                                        <circle cx="12" cy="19" r="1"></circle>
                                                                    </svg>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Tous les votes de ce Top seront remis à 0" data-idranking="<?php echo $r_user['id_ranking']; ?>" class="confirm_delete dropdown-item" href="#">
                                                                        <span class="ico-action">🆕</span> Recommencer
                                                                    </a>
                                                                    <a data-phrase1="Es-tu sûr de toi ?" data-phrase2="Le Top sera supprimé définitivement 😱" data-idranking="<?php echo $r_user['id_ranking']; ?>" class="confirmDeleteReal dropdown-item" href="#">
                                                                        <span class="ico-action">🚮</span> Supprimer
                                                                    </a>
                                                                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#commentModal-<?php echo $r_user['id_tournoi']; ?>">
                                                                        <span class="ico-action">🆓</span> Commenter
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3" aria-labelledby="profileIcon-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card invoice-list-wrapper">
                                    <div class="card-datatable table-responsive">
                                        <table class="invoice-list-table table table-c5_2">
                                            <thead>
                                            <tr>
                                                <th class="">
                                                    <span class="t-rose"><?php echo count($list_t_created); ?></span> Tops créés
                                                </th>
                                                <th class="text-right">
                                                    🌟
                                                </th>
                                                <th class="text-right">
                                                    💎
                                                </th>
                                                <th class="text-right">
                                                    🏆
                                                </th>
                                                <th>
                                                    Actions
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($list_t_created as $item) : ?>
                                                <tr>
                                                    <td>
                                                        <div class="media-body">
                                                            <div class="media-heading">
                                                                <h6 class="cart-item-title mb-0">
                                                                    <a class="text-body" href="<?php the_permalink($item['top_id']); ?>">
                                                                        Top <?php echo $item['top_title']; ?> - <?php echo $item['top_title']; ?>
                                                                    </a>
                                                                </h6>
                                                                <small class="cart-item-by legende">
                                                                    <?php the_field('question_t', $item['top_id']); ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php if(isset($item['note']) && $item['note'] != ""): ?>
                                                            <?php echo $item['note']; ?> <span class="ico3">⭐️</span>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo $item['top_votes']; ?> <span class="ico3">💎</span>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php echo $item['top_ranks']; ?> <span class="ico3">🏆</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center col-actions">
                                                            <a class="mr-1" href="<?php the_permalink(get_page_by_path('liste-des-tops')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir tous les classements">
                                                                <span class="ico">
                                                                    👀
                                                                </span>
                                                            </a>
                                                            <a class="mr-1" href="<?php the_permalink(get_page_by_path('elo')); ?>?id_top=<?php echo $item['top_id']; ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Voir le classement mondial">
                                                                <span class="ico">
                                                                    🌍
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php foreach($list_t_done as $r_user) : ?>
    <?php if($r_user['nb_votes'] > 0): ?>
        <div class="vertical-modal-ex">
            <div class="modal fade" id="commentModal-<?php echo $r_user['id_tournoi']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Qu'as-tu pensé de ce Top <?php echo get_the_title($r_user['id_tournoi']); ?>?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="form form-vertical form-note" data-id-tournament="<?php echo $r_user['id_tournoi']; ?>" data-uuiduser="<?php echo $uuiduser; ?>">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea class="form-control commentairezone" rows="4" placeholder="Ton commenaire..."></textarea>
                                            <p class="merci">
                                                Un grand Merci pour ce retour <span class="ico">🙏</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer text-center">
                                <button type="submit" class="tohidecta btn btn-primary mr-1 waves-effect waves-float waves-light">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php get_footer(); ?>