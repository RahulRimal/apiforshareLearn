<!-- Chat system Strats Here -->

<div id="chat-system" class="d-none">
    <div id="chat-box" class="d-flex flex-column justify-content-between text-center bg-white">
        <div class="chat-box-heading p-2 mb-3"
            style="background-color: var(--primary-color); border-top-left-radius: 25px; border-top-right-radius: 25px;">
            <div class="row">
                <div class="user-pic col-2 position-relative">
                    <img src="<?php echo BASE_URI;?>images/Share Your Learning.png" class="circle-avatar-icon">
                    <div class="user-online-status">
                        <div class="user-online-active" style="position: absolute; top: 50%; left: 75%;">
                        </div>
                    </div>
                </div>
                <div class="user-name text-start col-8">
                    <a href="#" class="h6">Rahul Rimal</a>
                    <div class="online-status-text" style="margin-top: -5px;">
                        <p class="active-now-text">Active Now</p>
                    </div>
                </div>
                <div class="chat-box-minimize col-2 d-flex justify-content-center">
                    <i class="fas fa-window-minimize" style="cursor: pointer;" onclick="hideChatBox()"></i>
                </div>
            </div>
        </div>
        <div class="chat-box-body">
            <div class="p-2">
                <!-- Friend Chat message starts here  -->
                <div class="friend-message-text">
                    <div class="chat-message d-flex align-items-center mb-2">
                        <div class="chat-user-pic me-2">
                            <img src="<?php echo BASE_URI;?>images/Share Your Learning.png" class="circle-avatar-icon"
                                style="height: 17px; width: 17px;">
                        </div>
                        <div class="chat-text bg-primary float-left" style="border-radius: 10px; margin-right: 100px;">
                            <div class="p-1">
                                <p class="m-0 text-start">Hello there !!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Friend Chat message ends here  -->

                <!-- User chat message starts here  -->
                <div class="user-message-text">
                    <div class="chat-message d-flex flex-row-reverse align-items-center mb-2">
                        <div class="chat-user-pic ms-2">
                            <img src="<?php echo BASE_URI;?>images/Share Your Learning.png" class="circle-avatar-icon"
                                style="height: 17px; width: 17px;">
                        </div>
                        <div class="chat-text float-left"
                            style="border-radius: 10px; margin-left: 100px; background-color: var(--primary-color);">
                            <div class="p-1">
                                <p class="m-0 text-end">Hello there !!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User chat message ends here  -->
            </div>
        </div>

        <div class="chat-box-footer mb-2">
            <div class="chat-box-type-area">
                <form action="post">
                    <div class="row m-0 justify-content-between">
                        <div class="col-11 p-0">
                            <input type="email" name="newEmail" id="chat-box-input">
                        </div>
                        <div class="col-1 p-0">
                            <i class="fas fa-paper-plane" style="top: 10px; right: 10px; cursor:pointer"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="chat-head" class="d-block">
        <img src="<?php echo BASE_URI;?>images/Share Your Learning.png" class="chat-head-avatar"
            onclick="showChatBox();" style="position: fixed; bottom: 20px; right: 20%; z-index: 1030; cursor: pointer;">
    </div>

</div>

<!-- Chat system Ends Here -->