<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <title>Chat</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <!--[if IE]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->

    <link href="<?php echo base_url(); ?>content/chat/css/chat_men.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>content/css/jquery.arcticmodal.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>content/chat/css/main.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        function time() {
            var date = new Date();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var seconds = date.getSeconds();
            if (hours < 10) hours = '0' + hours;
            if (minutes < 10) minutes = '0' + minutes;
            if (seconds < 10) seconds = '0' + seconds;
            $('#currenttime').html(hours + ':' + minutes + ':' + seconds);

            setTimeout(time, 1000);
        }

        function smiles() {
            type = $('#smiles_block').attr('data-opened');

            if (type == 'false') {
                $('#smiles_block').show().attr('data-opened', 'true');
            }
            else {
                $('#smiles_block').hide().attr('data-opened', 'false');
            }
        }

        function makePhoto(img) {
            $('#photoModal').attr('src', img);
            $('#showPhotoModal').arcticmodal();
        }
    </script>

    <script>
        var info = {
            url: '<?php echo base_url(); ?>',
            mycamera: 0,
            video: 0,
            room: '<?php echo $room; ?>',
            gender: <?php echo $this->userInfo['sex']; ?>,
            selfId: <?php echo $this->selfId; ?>
        }
    </script>

    <script type="text/javascript" src="<?php echo base_url(); ?>content/js/ion.sound.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>content/chat/js/users.chat.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>content/chat/js/text.chat.js"></script>
    <script type="text/javascript" src="/content/chat/js/video.chat.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>content/js/jquery.arcticmodal-0.3.min.js"></script>

    <script type="text/javascript">
        ion.sound({
            sounds: [
                {
                    name: 'chat_new_message',
                    volume: 0.9
                },
                {
                    name: 'new_notification',
                    volume: 0.5
                }
            ],
            path: '/content/sound/',
            preload: true
        });

        <?php if(!empty($room)) { ?>
        textchat.loadRoom('<?php echo $room; ?>');
        <?php } ?>
    </script>

    <script type="text/javascript">
        function getFlashMovie(movieName) {
            var isIE = navigator.appName.indexOf("Microsoft") != -1;
            return (isIE) ? window[movieName] : document[movieName];
        }

        function onPropertyChange(event) {
            if (event.property == 'nearID') {
                if (event.objectID == 'video1') {
                    videochat.changeNearID(event.newValue);
                    //chatInfo.videoRoom = event.newValue;

                    console.log('NearID was changed', event.newValue);
                }
            }
        }
    </script>
</head>

<body onload="time();">
<div class="l-wrapper">
    <div class="b-header">
        <ul class="b-main-nav b-main-nav__width_large">
            <li class="item"><a class="link" target="_blank" href="/" title="Home">Home</a></li>
            <li class="item"><a class="link" target="_blank" href="/my/letters" title="My messages">My messages</a></li>
            <li class="item"><a class="link" target="_blank" href="/main/logout" title="Logout">Logout</a></li>
        </ul>
        <span class="b-main-name">Welcome, <?php echo $this->userInfo['name']; ?>!</span>
    </div>
    <div class="b-content">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                id="video2" width="240" height="240"
                codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" style="top: 35px;">
            <param name="movie" value="<?php echo base_url(); ?>content/swf/VideoIO.swf"/>
            <param name="quality" value="high"/>
            <param name="bgcolor" value="#000000"/>
            <param name="allowFullScreen" value="true"/>
            <param name="allowScriptAccess" value="always"/>
            <param name="flashVars" value="controls=true"/>
            <embed src="<?php echo base_url(); ?>content/swf/VideoIO.swf" quality="high" bgcolor="#000000"
                   width="320" height="200" name="video2" align="middle"
                   play="true" loop="false" quality="high"
                   allowFullScreen="true"
                   allowScriptAccess="always"
                   flashVars="controls=true"
                   type="application/x-shockwave-flash"
                   pluginspage="http://www.adobe.com/go/getflashplayer">
            </embed>
        </object>
        <div class="b-online-profiles g-box-style">
            <h2 class="b-title-online"><?php echo $lng['main']; ?> (<span
                        id="count"></span> <?php echo $lng['total']; ?>)</h2>
            <input type="text" id="sort" placeholder="Search by name or by ID" onkeypress="users.sort();" class="sort">
            <ul class="list" id="profilecontainer">

            </ul>
            <div id="page-online-men">
                Page:
                <strong id="profilepages"></strong>
            </div>
        </div>
        <div class="b-history-list g-box-style" id="b-history">

            <div class="f_r nav-data">
                <span id="client-date"></span>
                Current time: <span id="currenttime">00:00:00</span>
            </div>
            <div class="f_r nav-data"></div>
            <div style="clear:both"></div>
            <!-- CHAT BODY -->
            <div id="chat_body"></div>
            <!-- //CHAT BODY -->
        </div>

        <div class="b-messages g-box-style">
            <div class="smiles">
                <b class="arrow" id="top_errow" style="position: relative; z-index: 99; display:none;">&#9650;</b>
                <b class="arrow" id="bottom_errow" style="position: relative; z-index: 99;"></b>
                <span style="position: relative; z-index: 99;" id="smiles_btn" onClick="smiles();"><img
                            src="/content/chat/css/chat/sm.jpg"></span>
                <span id="alert_message" style="display:none"></span>
                <div class="b-smiles-wrapper" id="smiles_block" style="display:none;" data-opened="false">
                    <ul class="b-smiles-list">
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/SMILE.gif"
                                                            title=":SMILE:" onclick="textchat.smile(':SMILE:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/SAD.gif"
                                                            title=":SAD:" onclick="textchat.smile(':SAD:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/LAUGH.gif"
                                                            title=":LAUGH:" onclick="textchat.smile(':LAUGH:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/HI.gif"
                                                            title=":HI:" onclick="textchat.smile(':HI:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/WINK.gif"
                                                            title=":WINK:" onclick="textchat.smile(':WINK:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/WOW.gif"
                                                            title=":WOW:" onclick="textchat.smile(':WOW:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/CRY.gif"
                                                            title=":CRY:" onclick="textchat.smile(':CRY:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/HEEHEE.gif" title=":HEEHEE:"
                                    onclick="textchat.smile(':HEEHEE:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/KISS.gif"
                                                            title=":KISS:" onclick="textchat.smile(':KISS:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/SLY.gif"
                                                            title=":SLY:" onclick="textchat.smile(':SLY:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/RED.gif"
                                                            title=":RED:" onclick="textchat.smile(':RED:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/DOUBT.gif"
                                                            title=":BOUBT:" onclick="textchat.smile(':DOUBT:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/SLEEPY.gif" title=":SLEEPY:"
                                    onclick="textchat.smile(':SLEEPY:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/LOVE.gif"
                                                            title=":LOVE:" onclick="textchat.smile(':LOVE:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/EVIL.gif"
                                                            title=":EVIL:" onclick="textchat.smile(':EVIL:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/YAWN.gif"
                                                            title=":YAWN:" onclick="textchat.smile(':YAWN:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/HEART.gif"
                                                            title=":HEART:" onclick="textchat.smile(':HEART:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/SUN.gif"
                                                            title=":SUN:" onclick="textchat.smile(':SUN:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/ROFL.gif"
                                                            title=":ROFL:" onclick="textchat.smile(':ROFL:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/MAKEUP.gif" title=":MAKEUP:"
                                    onclick="textchat.smile(':MAKEUP:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/APPLAUSE.gif" title=":APPLAUSE:"
                                    onclick="textchat.smile(':APPLAUSE:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/YES.gif"
                                                            title=":YES:" onclick="textchat.smile(':YES:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/NO.gif"
                                                            title=":NO:" onclick="textchat.smile(':NO:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/ANGEL.gif"
                                                            title=":ANGEL:" onclick="textchat.smile(':ANGEL:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/FLOWER.gif" title=":FLOWER:"
                                    onclick="textchat.smile(':FLOWER:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/THINK.gif"
                                                            title=":THINK:" onclick="textchat.smile(':THINK:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/TIME.gif"
                                                            title=":TIME:" onclick="textchat.smile(':TIME:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/HAPPYNESS.gif" title=":HAPPYNESS:"
                                    onclick="textchat.smile(':HAPPYNESS:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/CELEBRATION.gif"
                                    title=":CELEBRATION:" onclick="textchat.smile(':CELEBRATION:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/ANGRY.gif"
                                                            title=":ANGRY:" onclick="textchat.smile(':ANGRY:')"></li>
                        <li class="b-smiles-list item"><img src="<?php echo base_url(); ?>content/chat/smiles/OH.gif"
                                                            title=":OH:" onclick="textchat.smile(':OH:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/ITS_NOT_ME.gif"
                                    title=":ITS_NOT_ME:" onclick="textchat.smile(':ITS_NOT_ME:')"></li>
                        <li class="b-smiles-list item"><img
                                    src="<?php echo base_url(); ?>content/chat/smiles/BROKEN_HEART.gif"
                                    title=":BROKEN_HEART:" onclick="textchat.smile(':BROKEN_HEART:')"></li>
                    </ul>
                </div>
            </div>

            <div class="b-message-box">
                <textarea align="left" class="text-field" id="message" placeholder="Type in to chat..."
                          onKeyDown="javascript:if(event.keyCode==13){textchat.send();}"></textarea>
            </div>
        </div>

        <div class="b-contacts-list g-box-style" id="contact_block_wrap">
            <a href="javascript:;" onClick="textchat.sound();" id="sound" style="margin-left: 60px; font-size: 14px;">Turn
                off sound</a><br>
            <h2 class="b-title-contacts">Contact list</h2>
            <div class="b-contact-list-block contactlist">
                <ul id="contact-list" class="b-contacts-list_offline">

                    <li class="item"></li>
                </ul>

                <button onclick="users.clearContact()" class="remove-all-contact-list">Remove contact</button>
                <button onclick="users.clearContacts();" class="remove-all-contact-list2">Remove all</button>
            </div>
        </div>

        <div class="b-contacts-list2 g-box-style" id="user_block_wrap" style="display:none;">
            <div class="b-contact-avatar">
                <img src="" id="user_avatar">
            </div>
            <div class="b-contact-avatar-right">

            </div>
            <div class="b-contact-info-right">

            </div>
            <button onclick="" class="remove-all-contact-list3">Send A Gift</button>
            <button onclick="textchat.close();" class="remove-all-contact-list4">End Chat</button>
        </div>

        <div class="b-my-profile g-box-style" id="lady_my_profile">
            <div id="video-send" class="hide_swf">
                <div class="video">
                    <div id="altContentSend">
                    </div>
                </div>
            </div>

            <div id="profile_wrapper">
                <div id="app">

                    <!-- Video area -->
                    <div id="video-container" v-bind:class="{ fullscreen: fullScreen }">
                        <video ref="theirVideo" id="their-video" autoplay></video>
                        <video ref="myVideo" id="my-video" v-bind:class="{ displayNone: !fullScreen }" muted="true"
                               autoplay></video>
                        <button class="fullscreen" @click="changeFullScreen"><img
                                    src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIxNHB4IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxNCAxNCIgd2lkdGg9IjE0cHgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6c2tldGNoPSJodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2gvbnMiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48dGl0bGUvPjxkZXNjLz48ZGVmcy8+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSI+PGcgZmlsbD0iIzAwMDAwMCIgaWQ9IkNvcmUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0yMTUuMDAwMDAwLCAtMjU3LjAwMDAwMCkiPjxnIGlkPSJmdWxsc2NyZWVuIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyMTUuMDAwMDAwLCAyNTcuMDAwMDAwKSI+PHBhdGggZD0iTTIsOSBMMCw5IEwwLDE0IEw1LDE0IEw1LDEyIEwyLDEyIEwyLDkgTDIsOSBaIE0wLDUgTDIsNSBMMiwyIEw1LDIgTDUsMCBMMCwwIEwwLDUgTDAsNSBaIE0xMiwxMiBMOSwxMiBMOSwxNCBMMTQsMTQgTDE0LDkgTDEyLDkgTDEyLDEyIEwxMiwxMiBaIE05LDAgTDksMiBMMTIsMiBMMTIsNSBMMTQsNSBMMTQsMCBMOSwwIEw5LDAgWiIgaWQ9IlNoYXBlIi8+PC9nPjwvZz48L2c+PC9zdmc+"/>
                        </button>
                    </div>

                    <!-- Steps -->
                    <div class="steps">
                        <!-- Get local audio/video stream -->
                        <div v-if="step1Display" id="step1">
                            <p>Please click `allow` on the top of the screen so we can access your webcam and microphone
                                for calls.</p>
                            <div v-if="step1ErrorDisplay">
                                <p>Failed to access the webcam and microphone.</p>
                                <button class="pure-button pure-button-error" @click="step1Retry">Try again</button>
                            </div>
                        </div>

                        <!-- Make calls to others -->
                        <div v-if="step2Display">
                            <div class="pure-form call">
                                <input type="hidden" v-model="calltoId">
                                <button class="pure-button pure-button-success" @click="makeCall">Call</button>
                            </div>
                        </div>

                        <!-- Call in progress -->
                        <div v-if="step3Display">
                            <p>Currently in call with <span>{{ theirId }}</span></p>
                            <p>
                                <button class="pure-button pure-button-error" @click="endCall">End call</button>
                            </p>
                        </div>

                        <div class="media-buttons">
                            <button class="pure-button pure-button-secondary" @click="changeAudio">{{ audioText }}
                                audio
                            </button>
                            <button class="pure-button pure-button-secondary" @click="changeVideo">{{ videoText }}
                                video
                            </button>
                        </div>
                    </div>

                    <div class="modal" v-if="modalDisplay">
                        <div class="modal-inner">
                            <h3>Receive Call?</h3>
                            <p>
                                Caller browser is {{ callerBrowser }}
                                <span>please use the same browser</span>
                            </p>
                            <button class="pure-button pure-button-success" @click="acceptCall">Accept</button>
                            <button class="pure-button pure-button-error" @click="declineCall">Decline</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="b-bottom-buttons b-bottom-buttons__width_small">
            <input class="b-button-send" type="submit" onclick="textchat.send()" value="Send"/>
        </div>
        <div class="b-bottom-buttons2 b-bottom-buttons__width_small2">
            <input class="b-button-send" type="submit" onclick="$('#sendFileModal').arcticmodal();" value="Send file">
        </div>
    </div>
</div>

<div style="display:none;">
    <div class="box-modal" id="showPhotoModal" style="width: auto; ">
        <div class="box-modal_close arcticmodal-close"><?= $this->lang->line('profile_photo_close') ?></div>
        <img src="" id="photoModal">
    </div>
</div>

<div style="display:none;">
    <div class="box-modal" id="sendFileModal">
        <div class="box-modal_close arcticmodal-close"><?= $this->lang->line('profile_photo_close') ?></div>
        <form action="" enctype="multipart/form-data" method="post" id="newPhoto">
            <input type="hidden" value="" name="chat_name" id="file_chatName">
            <div align="center"><input type="file" name="userfile" accept="image/jpeg">
                <input type="button" class="bt-save" value="Send photo">
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.bt-save').click(function (e) {
            //if ($('input[name="photo"]').val() != '') {
            e.preventDefault();
            var $that = $('#newPhoto');
            formData = new FormData($that.get(0));

            $.ajax({
                url: '/my/chat/sendfile',
                type: 'post',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function (j) {
                    if (j.status == 'success') {
                        $('#chat_body').append(j.html);
                    } else {
                        $('#chat_body').html('<div class="msgbox"><span style="color:#cecece;margin-top:7px;"><i><strong>Chat was closed.</strong></i></span></div>');

                        musers.unloadUser();
                        musers.onlineList();

                        info.room = '';
                    }

                    $('input[name="userfile"]').val('');
                    $.arcticmodal('close');
                    mchat.scrollBottom();
                }
            });
            //}
        });
    });
</script>

<script src="<?php echo base_url(); ?>content/chat/js/vue.min.js"></script>
<script src="<?php echo base_url(); ?>content/chat/js/main.min.js"></script>
</body>
</html>