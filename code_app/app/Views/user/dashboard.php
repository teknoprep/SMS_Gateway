<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<style>
    .text-muted {
        color: #000 !important;
    }

    .rounded-circle {
        border-radius: 0 !important;
    }
</style>

<div class="container-fluid" id="main-container">
    <div class="row h-100">
        <div class="col-12 col-sm-5 col-md-4 d-flex flex-column" id="chat-list-area" style="position:relative;">

            <!-- Navbar -->
            <div class="row d-flex flex-row align-items-center p-2" id="navbar">
                <!-- <img alt="Profile Photo" class="img-fluid rounded-circle mr-2" style="height:50px; background-color:#fff; cursor:pointer; background-color:#fff;" onclick="showProfileSettings()" id="display-pic"> -->
                <div class="text-white font-weight-bold" id="username"><?= $_SESSION['user']['fullname'] ?></div>

                <div class="nav-item dropdown ml-auto">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v text-white"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(1)" id="editProfileModalClick">Edit Profile</a>
                        <a class="dropdown-item" href="javascript:void(1)" data-toggle="modal" data-target="#sendNewMessageModal">New Messsage</a>
                        <a class="dropdown-item" href="<?php base_url() ?>/user/login/logout">Log Out</a>
                    </div>
                </div>


                <select name="sms_number" id="sms_number" class="form-control select mt-2">


                    <?php foreach ($user_numbers as $row) : ?>

                        <option value="<?= $row->number_id ?>"><?= ($row->number_label) ? $row->number_label . " - " . $row->number : $row->number ?></option>
                    <?php endforeach; ?>
                </select>

            </div>

            <!-- Chat List -->
            <div class="row" id="chat-list" style="overflow:auto;"></div>

            <!-- Profile Settings -->
            <div class="d-flex flex-column w-100 h-100" id="profile-settings">
                <div class="row d-flex flex-row align-items-center p-2 m-0" style="background:#4680ff; min-height:65px;">
                    <i class="fas fa-arrow-left p-2 mx-3 my-1 text-white" style="font-size: 1.5rem; cursor: pointer;" onclick="hideProfileSettings()"></i>
                    <div class="text-white font-weight-bold">Profile</div>
                </div>
                <div class="d-flex flex-column" style="overflow:auto;">
                    <img alt="Profile Photo" class="img-fluid rounded-circle my-5 justify-self-center mx-auto" id="profile-pic">
                    <input type="file" id="profile-pic-input" class="d-none">
                    <div class="bg-white px-3 py-2">
                        <div class="text-muted mb-2"><label for="input-name">Your Name</label></div>
                        <input type="text" name="name" id="input-name" class="w-100 border-0 py-2 profile-input" value="<?= $_SESSION['user']['fullname'] ?>">



                    </div>
                    <div class="text-muted p-3 small">

                    </div>
                    <div class="bg-white px-3 py-2">
                        <div class="text-muted mb-2"><label for="input-about">About</label></div>
                        <input type="text" name="name" id="input-about" value="" class="w-100 border-0 py-2 profile-input">
                    </div>
                </div>

            </div>
        </div>

        <!-- Message Area -->
        <div class="d-none d-sm-flex flex-column col-12 col-sm-7 col-md-8 p-0 h-100" id="message-area">
            <div class="w-100 h-100 overlay"></div>

            <!-- Navbar -->
            <div class="row d-flex flex-row align-items-center p-2 m-0 w-100" id="navbar">
                <div class="d-block d-sm-none">
                    <i class="fas fa-arrow-left p-2 mr-2 text-white" style="font-size: 1.5rem; cursor: pointer;" onclick="showChatList()"></i>
                </div>
                <a href="#"><img src="https://via.placeholder.com/400x400" alt="Profile Photo" class="img-fluid rounded-circle mr-2" style="height:50px;" id="pic"></a>
                <div class="d-flex flex-column">
                    <div class="text-white font-weight-bold" id="name"></div>
                    <div class="text-white small" id="details"></div>

                </div>

                <div class="nav-item dropdown ml-auto">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v text-white"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="javascript:void(1)" id="btnAssignNameModelClick">Assign Name</a>

                    </div>
                </div>


            </div>

            <!-- Messages -->
            <div class="d-flex flex-column" id="messages"></div>

            <!-- Input -->
            <div class="d-none justify-self-end align-items-center flex-row" id="input-area">
                <!--  <a href="#"><i class="far fa-smile text-muted px-3" style="font-size:1.5rem;"></i></a> -->
                <input type="text" name="message" id="input" placeholder="Type a message" class="flex-grow-1 border-0 px-3 py-2 my-3 rounded shadow-sm">
                <i class="fas fa-arrow-circle-right text-muted px-3" style="cursor:pointer;" onclick="sendMessage()"></i>
            </div>

        </div>
    </div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="sendNewMessageModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send New Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post">
                    <div class="form-group">
                        <number>Number</number>
                        <input type="text" name="txtNumber" id="txtNumber" class="form-control">
                    </div>

                    <div class="form-group">
                        <number>Message</number>
                        <input type="text" name="txtMessage" id="txtMessage" class="form-control">
                    </div>

            </div>

            <div class="modal-footer">

                <input type="button" class="btn btn-primary" type="button" value="Send Message" id="btnSendNewMessage" />

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>



    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="editProfileModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= base_url() ?>/user/dashboard/edit_profile" method="post">
                    <div class="form-group">
                        <label>Fullname</label>
                        <input type="text" name="fullname" id="fullname" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

            </div>

            <div class="modal-footer">

                <!-- <input type="button" class="btn btn-primary" type="submit" value="Update Profile" id="btnUpdateProfile" />
 -->
                <button type="submit" class="btn btn-primary" value="Update Profile" id="btnUpdateProfile">Update Profile</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            </form>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="assignNameModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign name to contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post">
                    <div class="form-group">
                        <number>Name</number>
                        <input type="text" name="txtName" id="txtName" class="form-control">
                    </div>
            </div>

            <div class="modal-footer">

                <input type="button" class="btn btn-primary" type="button" value="Save" id="btnAssignName" />

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>



    </div>
</div>


<?= $this->endSection(); ?>