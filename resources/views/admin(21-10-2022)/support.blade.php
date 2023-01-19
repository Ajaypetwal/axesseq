@include('admin.layout.header')

<div class="container-fluid p-0 overflow-hidden">
    <div id="back-panel">
        <div class="row marginZero">
            <!-- Left side end here -->

            @include('admin.layout.sidebar')

            <!-- Right Section start -->
            <main role="main" class="contentPart">
                <div class="">
                    <div class="backbtn">
                        <a href="#" id="sidebar-control"><img
                                src="{{ URL::asset('admin/images/leftarrow.svg') }}"></a>
                        <h1 class="h2"> Support</h1>

                    </div>
                    <div class="responsemsg"></div>
                    <div class="profileinfo">

                        <div class="row">

                            <!-- Messages start here -->
                            <div class="col-lg-5 col-md-5 supp_border_right">
                                <div class="supp_users">
                                    <div class="messages_topbar">

                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" id="inputSuccess2"
                                                placeholder="Message" />
                                            <img src="images/Search.svg" alt="">
                                        </div>
                                    </div>
                                    <nav class="supp_messages_border">
                                        <div class="nav" id="support_nav_tab" role="tablist">
                                            <a class="nav-link active" id="nav-home-tab" data-toggle="tab"
                                                href="#Professionals_supp" role="tab" aria-controls="nav-home"
                                                aria-selected="true">Professionals</a>
                                            <a class="nav-link" id="nav-profile-tab" data-toggle="tab"
                                                href="#Recruiters_supp" role="tab" aria-controls="nav-profile"
                                                aria-selected="false">Recruiters</a>
                                            <a class="nav-link" id="nav-contact-tab" data-toggle="tab"
                                                href="#Companies_supp" role="tab" aria-controls="nav-contact"
                                                aria-selected="false">Companies</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <!-- Professionals messages start here -->
                                        <div class="tab-pane fade show active" id="Professionals_supp" role="tabpanel"
                                            aria-labelledby="nav-home-tab">
                                            <div class="supp_messages">
                                                <?php

                            if(!empty($professionaldata)){
                              foreach ($professionaldata as $user) {
                                //  echo "<pre>";
                                //  print_r($user);
                              ?>
                                                <div class="active_msg mt-4" data-user_id="{{ $user['user_id'] }}"
                                                    data-name="{{ $user['user']->name }}"
                                                    data-email="{{ $user['user']->email }}"
                                                    data-image="{{ $user['user']->image ?? '' }}"
                                                    data-support_id="{{ $user['_id'] ?? '' }}"
                                                    data-ticket_number="{{ $user['ticket_number'] ?? '' }}"data-message="{{ $user['message'] ?? '' }}">
                                                    <div class="supp_msg">

                                                        <div class="img_title">
                                                            <div>
                                                                <?php if($user['user']->image ?? ''){ ?>
                                                                <img src="{{ $user['user']->image ?? '' }}"
                                                                    data-email="{{ $user['user']->image ?? '' }}">
                                                                <?php } else { ?>
                                                                <img src="{{ URL::asset('admin/images/smiley.svg') }}"
                                                                    alt="">
                                                                <?php } ?>


                                                            </div>
                                                            <div class="supp_msg_title">
                                                                <h4>{{ $user['user']->name }}</h4>
                                                                <p>{{ $user['subject'] ?? '' }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="supp_msg_content">
                                                            <p>{{ \Carbon\Carbon::parse($user['created_at'])->diffForHumans() }}
                                                            </p>
                                                            <div class="text-right">
                                                                <!-- <span class="supp_msg_count"></span> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php

                              }

                            }


                             ?>


                                                <!-- message end here -->
                                                <!-- <div class="supp_add_btn">
                          <button>
                            <img src="{{ URL::asset('admin/images/addchat.png') }}" alt="">
                          </button>
                        </div> -->
                                            </div>

                                        </div>
                                        <!-- Professionals messages end here -->

                                        <!-- Recruiters messages start here -->
                                        <div class="tab-pane fade" id="Recruiters_supp" role="tabpanel"
                                            aria-labelledby="nav-profile-tab">
                                            <div class="supp_messages">
                                                <!-- message start here -->

                                                <?php
                        if (is_array($recruiterdata) || is_object($recruiterdata))
                        {


                            foreach ($recruiterdata as $user) {
                             //echo "<pre>";
                             // print_r($user);
                            ?>
                                                <div class="active_msg mt-4" data-user_id="{{ $user['user_id'] }}"
                                                    data-name="{{ $user['user']->name }}"
                                                    data-email="{{ $user['user']->email }}"
                                                    data-image="{{ $user['userImage'] ?? '' }}"
                                                    data-support_id="{{ $user['_id'] ?? '' }}"
                                                    data-ticket_number="{{ $user['ticket_number'] ?? '' }}"data-message="{{ $user['message'] ?? '' }}">
                                                    <div class="supp_msg">

                                                        <div class="img_title">
                                                            <div>
                                                                <?php if($user['userImage'] ?? ''){ ?>
                                                                <img src="{{ $user['userImage'] ?? '' }}"
                                                                    data-email="{{ $user['userImage'] ?? '' }}">
                                                                <?php } else { ?>
                                                                <img src="{{ URL::asset('admin/images/smiley.svg') }}"
                                                                    alt="">
                                                                <?php } ?>


                                                            </div>
                                                            <div class="supp_msg_title">
                                                                <h4>{{ $user['user']->name }}</h4>
                                                                <p>{{ $user['subject'] ?? '' }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="supp_msg_content">
                                                            <p>{{ \Carbon\Carbon::parse($user['created_at'])->diffForHumans() }}
                                                            </p>
                                                            <div class="text-right">
                                                                <!-- <span class="supp_msg_count"></span> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div> <?php } }?>

                                                <!-- <div class="supp_add_btn">
                    <button>
                      <img src="{{ URL::asset('admin/images/addchat.png') }}" alt="">
                    </button>
                  </div>  -->
                                            </div>
                                        </div>

                                        <!-- Recruiters messages end here -->

                                        <!-- Companies messages start here -->
                                        <div class="tab-pane fade" id="Companies_supp" role="tabpanel"
                                            aria-labelledby="nav-contact-tab">
                                            <div class="supp_messages">
                                                <!-- message start here -->
                                                <?php
                            foreach ($organizationdata as $user) {

                            ?>
                                                <div class="active_msg mt-4" data-user_id="{{ $user['user_id'] }}"
                                                    data-name="{{ $user['user']->name }}"
                                                    data-email="{{ $user['user']->email }}"
                                                    data-image="{{ $user['userImage'] ?? '' }}"
                                                    data-support_id="{{ $user['_id'] ?? '' }}"
                                                    data-ticket_number="{{ $user['ticket_number'] ?? '' }}"data-message="{{ $user['message'] ?? '' }}">
                                                    <div class="supp_msg">

                                                        <div class="img_title">
                                                            <div>
                                                                <?php if($user['userImage'] ?? ''){ ?>
                                                                <img src="{{ $user['userImage'] ?? '' }}"
                                                                    data-email="{{ $user['userImage'] ?? '' }}">
                                                                <?php } else { ?>
                                                                <img src="{{ URL::asset('admin/images/smiley.svg') }}"
                                                                    alt="">
                                                                <?php } ?>


                                                            </div>
                                                            <div class="supp_msg_title">
                                                                <h4>{{ $user['user']->name }}</h4>
                                                                <p>{{ $user['subject'] ?? '' }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="supp_msg_content">
                                                            <p>{{ \Carbon\Carbon::parse($user['created_at'])->diffForHumans() }}
                                                            </p>
                                                            <div class="text-right">
                                                                <!-- <span class="supp_msg_count"></span> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div> <?php } ?>
                                                <!-- <div class="supp_add_btn">
                    <button>
                      <img src="{{ URL::asset('admin/images/addchat.png') }}" alt="">
                    </button>
                   </div> -->
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Companies messages end here -->
                                </div>
                            </div>

                            <!-- Chat start here -->
                            <div class="col-lg-7 col-md-7 rightchat-wizard d-none">
                                <div class="supp_chat">
                                    <div class="supp_chat_head_border">
                                        <div class="supp_chat_head">
                                            <div class="supp_name">
                                                <div>
                                                    <img src="{{ URL::asset('admin/images/smiley.svg') }}"
                                                    alt="" class="suseriamge">
                                                    {{-- <img class="suseriamge" src="" alt=""> --}}
                                                </div>
                                                <div class="supp_profile">
                                                    <h4 class="susername">Lisa Emma</h4>
                                                    <p class="suseremail">lisa23@gmail.com</p>
                                                </div>
                                            </div>

                                            <div class="supp_id">
                                                <h4 class="suserticketnumber">Support ID: 1235CA2B2</h4>
                                                <form class="send-notification">
                                                    <div class="form-row">
                                                        <div class="form-group form-check">
                                                            <label class="checkbox-container">Mark as complete
                                                                <input type='hidden' id='headerUserId'>
                                                                <input type='hidden' id='supportid'>
                                                                <input id="check" class="changeticket-status"
                                                                    type="checkbox">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="chat-area">

                                    </div>

                                    <div class="chat_typing mt-4 align-items-center">
                                        <div class="chat_files">
                                            <div class="form-group">
                                                <label for="exampleForm">
                                                    <img src="{{ URL::asset('admin/images/supp_chat_attachment.png') }}"
                                                        id="uploadimage" alt="">

                                                        <input type="file" class="form-control-file gallery-photo-add"
                                                         placeholder="Upload File">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="chat_files">
                                            <div class="form-group">
                                              <label for="exampleFormControlFile2">
                                                <img src="{{ URL::asset('admin/images/img-icon.svg') }}" alt="">
                                                <input type="file" class="form-control-file gallery-photo-add" placeholder="Upload File">
                                              </label>
                                            </div>
                                        </div>
                                        <div class="chtsend">
                                            <div class="write_msg">
                                                <div class="gallery"></div>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" cols="35" rows="1"
                                                    placeholder="Write your message here"></textarea>
                                            </div>
                                            <input type='hidden' id='messageUserId'>
                                            <input type='hidden' id='supportidMessage'>
                                            <input type='hidden' id='isattachment' value="0">
                                            <input type="hidden" class="imagefData">
                                            <button class="sendmainm">
                                                <img src="{{ URL::asset('admin/images/sendchat.png') }}"
                                                    id="chatsupport" class="sendmessagebtn" alt="sendchat">
                                            </button>
                                            <button id="sendattach" class="d-none">
                                                <img src="{{ URL::asset('admin/images/sendchat.png') }}"
                                                     class="sendattach" alt="sendchat">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Chat end here -->
                        </div>



                    </div>
                </div>
        </div>
    </div>
    </main>
    <!-- Right Section end -->

</div>
</div>
</div>

{{-- Attachment Popup --}}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
          <h4 class="modal-title">Upload Attachement</h4>
        </div>
        <div class="modal-body">
            <div class="gallery"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var stuff = [];
        $(function() {
            // Multiple images preview in browser
            var imagesPreview = function(input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                                placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // $('.gallery-photo-add').on('change', function() {
            $(document).on('change', '.gallery-photo-add',function() {
                imagesPreview(this, 'div.gallery');
                $('#isattachment').val(1);
                var user_id = $('#messageUserId').val();
                var support_id = $('#supportidMessage').val();
                var message = $('#exampleFormControlTextarea1').val();
                var filedata = this.files[0];
                var imgtype = filedata.type;
                // var match = ['image/jpeg', 'image/jpg'];

                // if (!(imgtype == match[0]) || (imgtype == match[1])) {
                //     $('#mgs_ta').html(
                //         '<p style="color:red">Plz select a valid type image..only jpg jpeg allowed</p>'
                //         );

                // } else {

                //     $('#mgs_ta').empty();

                // }
                //---image preview

                var reader = new FileReader();

                reader.onload = function(ev) {
                    $('#img_prv').attr('src', ev.target.result).css('width', '150px').css(
                        'height', '150px');
                }
                reader.readAsDataURL(this.files[0]);


                //upload
                var postData = new FormData();
                postData.append('file', this.files[0]);
                postData.append('user_id', user_id);
                postData.append('support_id', support_id);
                // postData.append('message', message);
                let formData = new FormData();
                formData.append('file', $(".gallery-photo-add").val());
                // console.log(postData)

                var isattachment = $('#isattachment').val();
                if(isattachment == 1){
                    $('.sendmainm').addClass('d-none');
                    $('#sendattach').removeClass('d-none');

                    $(document).on('click', '#sendattach', function() {
                        var message = $('#exampleFormControlTextarea1').val();
                        postData.append('message', message);
                        $.ajax({
                        type: 'POST',
                        url: "/createAdminMessage",
                        data: postData,
                        cache: false,
                        async: true,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            var chatWizard = $('.chat-area');
                            response = JSON.parse(response);
                            if (response.success == true) {

                                console.log('attachment');

                                $(chatWizard).scrollTop($(chatWizard)[0].scrollHeight);
                                $(chatWizard).html(response.html);
                                $('#isattachment').val(0);
                                $("#exampleFormControlTextarea1").val('');
                                $('.gallery').html('');
                                $('.sendmainm').removeClass('d-none');
                                $('#sendattach').addClass('d-none');
                            }
                            // $(inputMessage).val('')
                        },
                        error: function(response) {
                            console.log("error");
                        }
                    });
                    })
                }
            });
        });

        $(".active_msg").click(function() {
            $('.changeticket-status').attr('checked', false);
            var user_id = $(this).data('user_id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var image = $(this).data('image');
            var support_id = $(this).data('support_id');
            var ticket_number = $(this).data('ticket_number');
            var message = $(this).data('message');
            var created_at = $(this).data('created_at');
            var chatWizard = $('.chat-area');
            var supp_profile = $('.supp_profile');
            var rightChatArea = $('.rightchat-wizard');
            var susername = $('.susername');
            var suseremail = $('.suseremail');
            var suserticketnumber = $('.suserticketnumber');
            var suseriamge = $('.suseriamge');
            var ticketStatus = '';
            $(rightChatArea).removeClass('d-none');
            //alert(created_at);
            //setInterval(function()
            //  {
            $.ajax({
                type: 'POST',
                url: "/displayTicketMessage",
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                    user_id: user_id,
                    support_id: support_id,
                    name: name,
                    email: email,
                    ticket_number: ticket_number,
                    image: image
                },
                cache: false,
                dataType: "json",
                success: function(response) {
                    // var response = JSON.stringify(response)
                    if (response.success == true) {
                        $(chatWizard).html(response.html);
                        $(suserticketnumber).text(response.ticket_number);
                        $(susername).text(response.name);
                        $(suseremail).text(response.email);
                        if(response.image){
                            $(suseriamge).attr('src', response.image);
                        }
                        $('#messageUserId').val(response.userID);
                        $('#supportid').val(response.support_id);
                        $('#supportidMessage').val(response.support_id);


                        $('#headerUserId').val(response.userID);
                        ticketStatus = response.ticket_status;
                        console.log(ticketStatus);
                        if (ticketStatus == 'Pending') {
                            $('.changeticket-status').attr('checked', false);
                            $('.changeticket-status').attr('disabled', false);
                        } else {
                            $('.changeticket-status').attr('checked', true);
                            $('.changeticket-status').attr('disabled', true);
                        }
                        $(chatWizard).scrollTop($(chatWizard)[0].scrollHeight);
                    } else {
                        $(rightChatArea).addClass('d-none');
                        alert(4545)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
            //}, 50000);


            // var mySecondDiv=$('');

            //$('#appenddata').empty().append(mySecondDiv)
            // $("#appenddata").append(mySecondDiv);
        });
    });
    $(document).on('click', '.changeticket-status', function() {
        var user_id = $("#headerUserId").val();
        var support_id = $("#supportid").val();
        $.ajax({
            type: 'POST',
            url: "/cmplete",
            data: {
                _token: "<?php echo csrf_token(); ?>",
                user_id: user_id,
                support_id: support_id
            },
            cache: false,
            dataType: "json",
            success: function(response) {
                if (response.success == true) {
                    $('.responsemsg').html('<span class="success-resp">' + response.message +
                        '</span>');
                    $('.changeticket-status').attr('disabled', true);
                } else {
                    $('.responsemsg').html('<span class="error-resp">' + response.message +
                        '</span>')
                }

                setTimeout(function() {
                    location.reload(true);
                }, 2000);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $(document).on('click', '#chatsupport', function() {
        var isattachment =   $('#isattachment').val();
        // var user_id= $(this).data('user_id');

        var user_id = $("#messageUserId").val();
        var support_id = $("#supportid").val();
        var message = $("#exampleFormControlTextarea1").val();
        var inputMessage = $("#exampleFormControlTextarea1");
        if (message == '') {
            return false;
        }
        var chatWizard = $('.chat-area');
        var rightChatArea = $('.rightchat-wizard');
        // $(rightChatArea).removeClass('d-none');
        var isattachment =   $('#isattachment').val();
        if(isattachment == 0){
            $('.gallery-photo-add').val();
            $.ajax({
            type: 'POST',
            url: "/createAdminMessage",
            data: {
                _token: "<?php echo csrf_token(); ?>",
                user_id: user_id,
                support_id: support_id,
                message: message
            },
            cache: false,
            dataType: "json",
            success: function(response) {
                console.log('Normal Message');
                if (response.success == true) {
                    $(chatWizard).scrollTop($(chatWizard)[0].scrollHeight);
                    $(chatWizard).html(response.html);
                }
                $(inputMessage).val('');
                $('.gallery-photo-add').val('');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
        }
    });
</script>
@include('admin.layout.footer')
