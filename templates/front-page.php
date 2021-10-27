    <?php include('includes/header.php');?>


    <main class="my-2">

        <!-- main wide content starts here  -->

        <div class="main-wide-content container-fluid">

        </div>

        <!-- main wide content ends here  -->

        <!-- main narrow content starts here  -->

        <div class="main-content container mt-5">
            <div class="row">
                <!-- Left sidebar starts here  -->
                <?php if(isLoggedIn()):?>
                <div class="left-sidebar d-flex flex-column justify-content-start text-center bg-white p-3 mb-5 col-lg-3" style="height: fit-content;">
                    <?php if(isLoggedIn()):?>
                    <div class=" sidebar-item user-profile-info">
                        <div class="pic-name text-center">
                            <img class="circle-avatar p-1 mt-5"
                                src="<?php echo BASE_URI;?>images/<?php echo $userInfo->picture;?>"
                                alt="">
                            <div class="user-info">
                                <h6 class="user-name"><em><?php echo $userInfo->firstName;?> <?php echo $userInfo->lastName;?></em></h6>
                                <p class="user-desc text-truncate"><?php echo $userInfo->description;?></p>
                            </div>
                        </div>
                        <hr class="m-0">
                    </div>

                    <div class="sidebar-item">
                        <div class="onsale-count">
                            <p>On Sale<br><span><strong><?php echo $sellingPostsCount;?></strong></span></p>
                        </div>
                        <hr class="m-0">
                    </div>
                    <div class="sidebar-item">
                        <div class="buying-count">
                            <p>Buying<br><span><strong><?php echo $buyingPostsCount;?></strong></span></p>
                        </div>
                        <hr class="m-0">
                    </div>
                    <?php endif;?>
                </div>

                <?php endif;?>

                <!-- Left sidebar ends here  -->

                <!-- main center content starts here  -->

                <div class="main-center-content <?php if(isLoggedIn()) echo('col-lg-6'); else echo('col-lg-9');?>">
                    <div class="user-preferred-posts">
                    <?php foreach($allPosts as $post):?>
                    <?php if($post->postType == 0):?>
                    <!-- User post starts here  -->
                    <div class="user-post bg-white position-relative p-3 mb-4 rounded"
                        onclick="location.href = 'post.php?post=<?php echo $post->id;?>';"
                        style="cursor: pointer;">
                        <div class="post-selling-tag p-1">
                            <div class="selling">
                                <h6 class="m-0">Selling</h6>
                            </div>
                        </div>
                        <div class="post-title-status d-flex justify-content-between">
                            <div class="post-title">
                                <a href="post.php?post=<?php echo $post->id;?>">
                                    <h5><?php echo $post->bookName;?></h5>
                                </a>
                            </div>

                            <div class="post-status">
                                <a href="#">
                                    <h5 class="text-success">Available</h5>
                                </a>
                            </div>
                        </div>
                        <div class="post-info-action d-flex justify-content-between align-items-center">
                            <div class="post-info d-flex">
                                <div class="book-author me-5 text-center">
                                    <p class="m-0"><i class="fa fa-user text-muted" aria-hidden="true"></i> Author
                                    </p>
                                    <h6 class="font-italic"><?php echo $post->author;?></h6>
                                </div>
                                <div class="bought-time me-5 text-center">
                                    <p class="m-0"><i class="fa fa-history text-muted" aria-hidden="true"></i>
                                        Bought
                                        Time
                                    </p>
                                    <h6 class="font-italic text-warning">1 Year ago</h6>
                                </div>
                                <div class="book-price me-5 text-center">
                                    <p class="m-0"><i class="fas fa-coins text-muted" aria-hidden="true"></i> Price
                                    </p>
                                    <h6" class="font-italic text-success">Rs. <?php echo $post->price;?></h6>
                                </div>
                            </div>

                            <div class="post-action me-5">
                                <div class="wishlist d-flex flex-column align-items-center">
                                    <a href="#">
                                        <i class="fa fa-shopping-basket" style="color: var(--primary-color);"
                                            aria-hidden="true"></i>
                                    </a>
                                    <a href="#">
                                        <p style="color: var(--primary-color);">Add to Wishlist</p>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="post-desc mt-4">
                            <p class="text-truncate"><?php echo $post->description;?></p>
                        </div>
                    </div>
                    <!-- User post ends here  -->

                    <?php else:?>

                    <!-- User post starts here  -->
                    <div class="user-post bg-white position-relative p-2 mb-4 rounded"
                        onclick="location.href = 'post.php?post=<?php echo $post->id;?>';"
                        style="cursor: pointer;">
                        <div class="post-buying-tag p-1">
                            <div class="buying">
                                <h6 class="m-0">Buying</h6>
                            </div>
                        </div>
                        <div class="post-title-status d-flex justify-content-between">
                            <div class="post-title">
                                <a href="post.php?post=<?php echo $post->id;?>">
                                    <h5><?php echo $post->bookName;?></h5>
                                </a>
                            </div>

                            <!-- <div class="post-status">
                                <a href="#">
                                    <h5 class="text-success">Available</h5>
                                </a>
                            </div> -->
                        </div>
                        <div class="post-info-action d-flex justify-content-between align-items-center">
                            <div class="post-info d-flex">
                                <div class="book-author me-5 text-center">
                                    <p class="m-0"><i class="fa fa-user text-muted" aria-hidden="true"></i> Author
                                    </p>
                                    <h6 class="font-italic"><?php echo $post->author;?></h6>
                                </div>
                                <div class="bought-time me-5 text-center">
                                    <p class="m-0"><i class="fa fa-history text-muted" aria-hidden="true"></i>
                                        Bought
                                        Time
                                    </p>
                                    <h6 class="font-italic text-warning">1 Year ago</h6>
                                </div>
                                <div class="book-price me-5 text-center">
                                    <p class="m-0"><i class="fas fa-coins text-muted" aria-hidden="true"></i> Price
                                    </p>
                                    <h6" class="font-italic text-success">Rs. <?php echo $post->price;?></h6>
                                </div>
                            </div>

                            <div class="post-action me-5">
                                <div class="wishlist d-flex flex-column align-items-center">
                                    <a href="#">
                                        <i class="fa fa-shopping-basket" style="color: var(--primary-color);"
                                            aria-hidden="true"></i>
                                    </a>
                                    <a href="#">
                                        <p style="color: var(--primary-color);">Add to Wishlist</p>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="post-desc mt-4">
                            <p class="text-truncate"><?php echo $post->description;?></p>
                        </div>
                    </div>
                    <!-- User post ends here  -->
                    <?php endif;?>
                    <?php endforeach;?>
                    </div>
                </div>

                <!-- main center content ends here  -->


                <!-- Right sidebar starts here  -->
                <?php include('includes/right-sidebar.php');?>

                <!-- Right sidebar ends here  -->
            </div>

        </div>

        <!-- main narrow content ends here  -->


        <!-- Chat system Strats Here -->
        <?php include('includes/chat-system.php');?>
        <!-- Chat system Ends Here -->

    </main>



    <?php include('includes/footer.php');?>