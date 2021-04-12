let getById = (id, parent) => parent ? parent.getElementById(id) : getById(id, document);
let getByClass = (className, parent) => parent ? parent.getElementsByClassName(className) : getByClass(className, document);

const DOM = {
    chatListArea: getById("chat-list-area"),
    messageArea: getById("message-area"),
    inputArea: getById("input-area"),
    chatList: getById("chat-list"),
    messages: getById("messages"),
    chatListItem: getByClass("chat-list-item"),
    messageAreaName: getById("name", this.messageArea),
    messageAreaPic: getById("pic", this.messageArea),
    messageAreaNavbar: getById("navbar", this.messageArea),
    messageAreaDetails: getById("details", this.messageAreaNavbar),
    messageAreaOverlay: getByClass("overlay", this.messageArea)[0],
    messageInput: getById("input"),
    profileSettings: getById("profile-settings"),
    profilePic: getById("profile-pic"),
    profilePicInput: getById("profile-pic-input"),
    inputName: getById("input-name"),
    username: getById("username"),
    displayPic: getById("display-pic"),
};

let mClassList = (element) => {
    return {
        add: (className) => {
            element.classList.add(className);
            return mClassList(element);
        },
        remove: (className) => {
            element.classList.remove(className);
            return mClassList(element);
        },
        contains: (className, callback) => {
            if (element.classList.contains(className))
                callback(mClassList(element));
        }
    };
};

let areaSwapped = false;

let chat = null;

let chatList = [];

let lastDate = "";

let populateChatList = () => {
    chatList = [];

    let present = {};

    MessageUtils.getMessages()
        .sort((a, b) => mDate(a.time).subtract(b.time))
        .forEach((msg) => {
            let chat = {};

            chat.isGroup = msg.recvIsGroup;
            chat.msg = msg;

            if (msg.recvIsGroup) {
                chat.group = groupList.find((group) => (group.id === msg.recvId));
                chat.name = chat.group.name;
            } else {
                chat.contact = contactList.find((contact) => (msg.sender !== user.id) ? (contact.id === msg.sender) : (contact.id === msg.recvId));
                chat.name = chat.contact.name;
            }

            chat.unread = (msg.sender !== user.id && msg.status < 2) ? 1 : 0;

            if (present[chat.name] !== undefined) {
                chatList[present[chat.name]].msg = msg;
                chatList[present[chat.name]].unread += chat.unread;
            } else {
                present[chat.name] = chatList.length;
                chatList.push(chat);
            }
        });
};

let viewChatList = () => {
    DOM.chatList.innerHTML = "";
    chatList
        .sort((a, b) => mDate(b.msg.time).subtract(a.msg.time))
        .forEach((elem, index) => {

            let statusClass = elem.msg.status < 2 ? "far" : "fas";
            let unreadClass = elem.unread ? "unread" : "";

            DOM.chatList.innerHTML += `
		<div data-main-chat="${elem.contact.id}" class="chat-list-item d-flex flex-row w-100 p-2 border-bottom ${unreadClass}" onclick="generateMessageArea(this, ${index})">
			
			<div class="w-50">
				<div class="name">${elem.name} | <span class="tempname ${elem.name}"> ${elem.contact.tempName}</span> </div>
				
				<div class="small last-message">${elem.isGroup ? contactList.find(contact => contact.id === elem.msg.sender).number + ": " : ""}${elem.msg.sender === user.id ? "<i class=\"" + statusClass + " fa-check-circle mr-1\"></i>" : ""} ${elem.msg.body}</div>
			</div>
			<div class="flex-grow-1 text-right">
				<div class="small time">${mDate(elem.msg.time).chatListFormat()} <span onclick="deleteChat(${elem.contact.id})"><i class="fas fa-trash"></i></span></div>
				${elem.unread ? "<div class=\"badge badge-success badge-pill small\" id=\"unread-count\">" + elem.unread + "</div>" : ""}
			</div>
		</div>
		`;
        });
};

let generateChatList = () => {
    populateChatList();
    viewChatList();
};

let addDateToMessageArea = (date) => {
    DOM.messages.innerHTML += `
	<div class="mx-auto my-2 bg-primary text-white small py-1 px-2 rounded">
		${date}
	</div>
	`;
};

let addMessageToMessageArea = (msg) => {
    let msgDate = mDate(msg.time).getDate();
    if (lastDate != msgDate) {
        addDateToMessageArea(msgDate);
        lastDate = msgDate;
    }

    let htmlForGroup = `
	<div class="small font-weight-bold text-primary">
		${contactList.find(contact => contact.id === msg.sender).number}
	</div>
	`;

    let sendStatus = `<i class="${msg.status < 2 ? "far" : "fas"} fa-check-circle"></i>`;


    DOM.messages.innerHTML += `
	<div class="align-self-${msg.sender === user.id ? "end self" : "start"} p-1 my-1 mx-3 rounded bg-white shadow-sm message-item">
		<div class="options">
			<a href="#"><i class="fas fa-angle-down text-muted px-2"></i></a>
		</div>
		
		
		<div class="d-flex flex-row">
			<div class="body m-1 mr-2">${msg.body}</div>
			<div class="time ml-auto small text-right flex-shrink-0 align-self-end text-muted" style="width:75px;">
				${mDate(msg.time).getTime()}
				${(msg.sender === user.id) ? sendStatus : ""}
			</div>
		</div>
	</div>
	`;

    DOM.messages.scrollTo(0, DOM.messages.scrollHeight);
};

let generateMessageArea = (elem, chatIndex) => {

    chat = chatList[chatIndex];

    mClassList(DOM.inputArea).contains("d-none", (elem) => elem.remove("d-none").add("d-flex"));
    mClassList(DOM.messageAreaOverlay).add("d-none");

    [...DOM.chatListItem].forEach((elem) => mClassList(elem).remove("active"));

    mClassList(elem).contains("unread", () => {
        MessageUtils.changeStatusById({
            isGroup: chat.isGroup,
            id: chat.isGroup ? chat.group.id : chat.contact.id
        });

        updateId = chat.isGroup ? chat.group.id : chat.contact.id;

        $.ajax({
            type: "POST",
            async: false,
            url: link + "/user/dashboard/updateMessageStatus",
            data: {
                response: updateId
            },
            success: function(data) {
                if (data != "1") {
                    console.log("Something went wrong while updating status");
                }
            },
        });

        mClassList(elem).remove("unread");
        mClassList(elem.querySelector("#unread-count")).add("d-none");
    });

    if (window.innerWidth <= 575) {
        mClassList(DOM.chatListArea).remove("d-flex").add("d-none");
        mClassList(DOM.messageArea).remove("d-none").add("d-flex");
        areaSwapped = true;
    } else {
        mClassList(elem).add("active");
    }

    DOM.messageAreaName.innerHTML = chat.name;

    DOM.messageAreaPic.src = chat.isGroup ? chat.group.pic : chat.contact.pic;

    if (chat.isGroup) {
        let groupMembers = groupList.find(group => group.id === chat.group.id).members;
        let memberNames = contactList
            .filter(contact => groupMembers.indexOf(contact.id) !== -1)
            .map(contact => contact.id === user.id ? "You" : contact.name)
            .join(", ");

        DOM.messageAreaDetails.innerHTML = `${memberNames}`;
    } else {
        //DOM.messageAreaDetails.innerHTML = `last seen ${mDate(chat.contact.lastSeen).lastSeenFormat()}`;
    }

    let msgs = chat.isGroup ? MessageUtils.getByGroupId(chat.group.id) : MessageUtils.getByContactId(chat.contact.id);

    DOM.messages.innerHTML = "";

    $('#messages').attr('data-sub-chat', chat.contact.id);
    lastDate = "";
    msgs
        .sort((a, b) => mDate(a.time).subtract(b.time))
        .forEach((msg) => addMessageToMessageArea(msg));
};

let showChatList = () => {
    if (areaSwapped) {
        mClassList(DOM.chatListArea).remove("d-none").add("d-flex");
        mClassList(DOM.messageArea).remove("d-flex").add("d-none");
        areaSwapped = false;
    }
};

let sendMessage = () => {
    let value = DOM.messageInput.value;
    DOM.messageInput.value = "";
    if (value === "") return;

    let msg = {
        sender: user.id,
        body: value,
        time: mDate().toString(),
        status: 2,
        recvId: chat.isGroup ? chat.group.id : chat.contact.id,
        recvIsGroup: chat.isGroup
    };


    $.ajax({
        type: "POST",
        async: false,
        dataType: 'JSON',
        url: link + "/user/dashboard/sendMessage",
        data: {
            response: msg
        },
        success: function(data) {

            if (data == "1") {
                console.log("Send");

            } else if (data == "00") {
                alert("Something went wrong while sending sms");
            } else {
                alert("Something went wrong");
            }
        },
    });


};

let showProfileSettings = () => {

    DOM.profileSettings.style.left = 0;
    DOM.profilePic.src = user.pic;
    DOM.inputName.value = user.name;
};

let hideProfileSettings = () => {
    DOM.profileSettings.style.left = "-110%";
    //	DOM.username.innerHTML = user.name;
};

window.addEventListener("resize", e => {
    if (window.innerWidth > 575) showChatList();
});

if ($('body').find('#sms_number').length > 0) {

    var conn = new ab.Session(webSocketProtocol + '://' + websocketDomainName,
        function() {
            console.log("Connected");

            conn.subscribe('newmessage', function(topic, data) {

                if (data.new == "1") {
                    let contact = {
                        id: data.sender_id,
                        name: data.number,
                        number: data.number,
                        pic: '../assets/images/dsaad212312aGEA12ew.png',
                        lastSeen: '19/10/2020 15:18'
                    };
                    contactList.push(contact);
                }
                let msg = {
                    id: data.id,
                    sender: data.sender_id,
                    body: data.message,
                    time: data.date,
                    status: data.status,
                    recvId: data.receiver_id,
                    recvIsGroup: false
                };

                $.notify("Message: " + data.message, {
                    title: "You got a new message from: " + data.number
                });

                addMessageToMessageArea(msg);
                MessageUtils.addMessage(msg);
                generateChatList();


            });

            conn.subscribe('newmessagesend', function(topic, data) {
                let msg = {
                    id: data.id,
                    sender: data.sender,
                    body: data.body,
                    time: data.time,
                    status: data.status,
                    recvId: data.recvId,
                    recvIsGroup: false
                };

                addMessageToMessageArea(msg);
                MessageUtils.addMessage(msg);
                generateChatList();

            });
        },
        function() {

            console.warn('WebSocket connection closed');
        }, {
            'skipSubprotocolCheck': true
        }
    );


    $('#btnSendNewMessage').on('click', function() {

        number = $('#txtNumber').val();
        message = $('#txtMessage').val();

        $.ajax({
            type: "POST",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/sendNewMessageLogic",
            data: {
                number: number,
                message: message,
                senderId: user.id
            },
            success: function(data) {

                if (data == "0") {

                    alert("Someting went wrong");
                } else if (data == "00") {

                    alert("Message send failed");
                } else {

                    if (data.new == "1") {

                        let contact = {
                            id: data.receiver_id,
                            name: data.number,
                            number: data.number,
                            pic: '../assets/images/dsaad212312aGEA12ew.png',
                            lastSeen: '09/12/2020 15:18'
                        };
                        contactList.push(contact);

                    }
                    let msg = {
                        id: data.id,
                        sender: data.sender_id,
                        body: data.message,
                        time: data.date,
                        status: data.status,
                        recvId: data.receiver_id,
                        recvIsGroup: false
                    };

                    addMessageToMessageArea(msg);
                    MessageUtils.addMessage(msg);
                    generateChatList();

                    alert("SMS Send Successfully");
                    $('#sendNewMessageModal').modal('hide');

                }

            },
        });


    });

    $('#btnAssignNameModelClick').on('click', function() {

        number = $('#name')[0].innerText;

        $.ajax({
            type: "POST",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/fetchName",
            data: {
                number: number
            },
            success: function(data) {

                $('#txtName').val(data.data.alias);
                $('#assignNameModal').modal('show');
            }
        });



    });

    $('#btnAssignName').on('click', function() {

        personName = $('#txtName').val();
        number = $('#name')[0].innerText;

        $.ajax({
            type: "POST",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/assignName",
            data: {
                number: number,
                txtName: personName
            },
            success: function(data) {

                $('.' + number + '').text(personName);
                if (data.code == "200") {
                    $('#assignNameModal').modal('hide');
                    alert("Name update successfully");
                }
            }
        });

    });

    $('#editProfileModalClick').on('click', function() {

        $.ajax({
            type: "GET",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/edit_profile",

            success: function(data) {
                $('#fullname').val(data.fullname);
                $('#editProfileModal').modal('show');
            }
        });

    });
    let sendMessageFunction = (number, message, contactName) => {
        $.ajax({
            type: "POST",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/sendNewMessageLogic",
            data: {
                number: number,
                message: message,
                senderId: user.id,
                contactName: contactName
            },
            success: function(data) {

                if (data == "0") {
                    alert("Someting went wrong");
                } else if (data == "00") {
                    alert("Message send failed");
                } else {

                    if (data.new == "1") {
                        let contact = {
                            id: data.receiver_id,
                            name: data.number,
                            number: data.number,
                            pic: '../assets/images/placeholder.png',
                            lastSeen: '09/12/2020 15:18',
                            tempName: data.name
                        };
                        contactList.push(contact);

                    }
                    let msg = {
                        id: data.id,
                        sender: data.sender_id,
                        body: data.message,
                        time: data.date,
                        status: data.status,
                        recvId: data.receiver_id,
                        recvIsGroup: false
                    };

                    addMessageToMessageArea(msg);
                    MessageUtils.addMessage(msg);
                    generateChatList();

                    $('#sendNewMessageContactModal').modal('hide');
                    $('.txtPhoneNumberCls').hide();
                    $('.ddPhoneCls').hide();
                    $('#ddPhone').html("");
                    $('#txtPhoneNumber').val("");

                    $('#userImportMessageForm #txtMessage').val("");
                    $('#userImportMessageForm #txtNumber').val("");
                    $('.tokenize').tokenize2().trigger('tokenize:clear')
                    alert("SMS Send Successfully");

                }

            },
        });
    };

    /* Send Message click function - Office365 Modal Submit */
    $('#btnSendNewContactMessage2').on('click', function() {

        number = $('#userImportMessageForm #txtNumber').val();
        message = $('#userImportMessageForm #txtMessage').val();
        contactName = $('#userImportMessageForm #txtNumber').find(':selected').data('name');

        $.ajax({
            type: "POST",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/get365ConctactDetails",
            data: {
                number: number
            },
            success: function(data) {

                count = 0;
                mobile = 0;
                business = 0;
                home = 0;
                appendData = '';
                appendDropDown = '';
                if (data.data.mobile_number != null) {
                    count++;
                    mobile++;

                    appendData += '<div class="form-group col-md-10"><div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><input type="radio" aria-label="" value="' + data.data.mobile_number + '" name="singleTxtNumber"></div></div><label class="form-control">' + data.data.mobile_number + '</label></div></div>';

                    appendDropDown += "<option value='" + data.data.mobile_number + "'>" + data.data.mobile_number + "</option>";
                }
                if (data.data.business_number != null) {
                    count++;
                    business++;

                    appendData += '<div class="form-group col-md-10"><div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><input type="radio" aria-label="" value="' + data.data.business_number + '" name="singleTxtNumber"></div></div><label class="form-control">' + data.data.business_number + '</label></div></div>';

                    appendDropDown += "<option value='" + data.data.business_number + "'>" + data.data.business_number + "</option>";
                }
                if (data.data.home_number != null) {
                    count++;
                    home++;
                    appendData += '<div class="form-group col-md-10"><div class="input-group"><div class="input-group-prepend"><div class="input-group-text"><input type="radio" aria-label="" value="' + data.data.home_number + '" name="singleTxtNumber"></div></div><label class="form-control">' + data.data.home_number + '</label></div></div>';

                    appendDropDown += "<option value='" + data.data.home_number + "'>" + data.data.home_number + "</option>";
                }

                if (count > 1) {
                    $('#formMultipleNumber').html("");

                    /* 
                    	#temp disbale for new functionality
                    $('#formMultipleNumber').append(appendData);
                    $('#sendNewMessageContactModal').modal('hide');
                    $('#multipleContactFound').modal('show'); */
                    $('.txtPhoneNumberCls').hide();
                    $('.ddPhoneCls').show();
                    $('#ddPhone').append(appendDropDown);

                    return;
                }
                if (mobile < 1) {
                    $('.ddPhoneCls').hide();
                    $('.txtPhoneNumberCls').show();
                    alert("No Mobile Number Found");
                } else {
                    $('.ddPhoneCls').hide();
                    $('.txtPhoneNumberCls').show();
                    $('.txtPhoneNumberCls').val(number);
                    sendMessageFunction(data.data.mobile_number, message, contactName);
                    $('#userImportMessageForm #txtNumber').val("");
                    $('#userImportMessageForm #txtMessage').val("");
                    /* 	$('#sendNewMessageContactModal').modal('hide');
                    	$('#multipleContactFound').modal('hide'); */
                }
            }
        });



    });

    /* If Multiple number found modal - sendMessage button function */
    $('#btnContactMultipleSendNewMessage').on('click', function() {

        contactName = $('#userImportMessageForm #txtNumber').find(':selected').data('name');
        var currentNumber = $("input[name='singleTxtNumber']:checked").val();
        message = $('#userImportMessageForm #txtMessage').val();
        sendMessageFunction(currentNumber, message, contactName);
        $('#userImportMessageForm #txtNumber').val("");
        $('#userImportMessageForm #txtMessage').val("");
        $('#sendNewMessageContactModal').modal('hide');
        $('#multipleContactFound').modal('hide');
    });

    /* Open office 365 send message modal */
    $('#sendNewMessageContactModalClick').on('click', function() {

        $('.ddPhoneCls').hide();
        $('.txtPhoneNumberCls').hide();

        $.ajax({
            type: "GET",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/getAll365Contacts",

            success: function(data) {

                var ddNumberList = $("#userImportMessageForm #txtNumber");
                ddNumberList.html("");
                $.each(data.data, function(val, text) {
                    ddNumberList.append('<option value="' + text.uic + '" data-name="' + text.name + '">' + text.name + '</option>');
                });

                $('.tokenize').tokenize2({
                    dataSource: 'select',
                    placeholder: "Type contact name or a new recipent number",
                    tokensMaxItems: 1,
                    tokensAllowCustom: true
                });

                $('#sendNewMessageContactModal').modal('show');
            }
        });

    });

    /* Contact 365 - Submit Button Function */
    $('#btnSendNewContactMessage').on('click', function() {


        ddNumber = $('#userImportMessageForm #ddPhone').val();
        txtPhoneNumber = $('#userImportMessageForm #txtPhoneNumber').val();
        message = $('#userImportMessageForm #txtMessage').val();
        number = '';
        contactName = '';

        if (ddNumber) {
            number = ddNumber;
        }
        if (txtPhoneNumber) {
            number = txtPhoneNumber;
        }

        if (!number) {
            alert("Please choose contact or add number");
            return;
        }

        if (!message) {
            alert("No message text found");
            return;
        }

        contactNameExists = $('#userImportMessageForm #txtNumber').find(':selected').data('name');

        if (contactNameExists) {
            contactName = contactNameExists;
        } else {
            contactName = 'Unknown';
        }


        sendMessageFunction(number, message, contactName);

    });

    $('.tokenize').on('tokenize:tokens:remove', function(e, value) {
        $('.txtPhoneNumberCls').hide();
        $('.ddPhoneCls').hide();
        $('#ddPhone').html("");
        $('#txtPhoneNumber').val("");
    });

    $('.tokenize').on('tokenize:tokens:added', function(e, value) {

        $.ajax({
            type: "POST",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/get365ConctactDetails",
            data: {
                number: value
            },
            success: function(data) {

                if (data.code == "404") {
                    $('.ddPhoneCls').hide();
                    $('.txtPhoneNumberCls').show();
                    $('#txtPhoneNumber').val(value)
                    return;
                }

                count = 0;
                mobile = 0;
                business = 0;
                home = 0;
                appendDropDown = '';
                if (data.data.mobile_number != null) {
                    count++;
                    mobile++;
                    appendDropDown += "<option value='" + data.data.mobile_number + "'> Mobile: " + data.data.mobile_number + "</option>";
                }
                if (data.data.business_number != null) {
                    count++;
                    business++;
                    appendDropDown += "<option value='" + data.data.business_number + "'> Business: " + data.data.business_number + "</option>";
                }
                if (data.data.home_number != null) {
                    count++;
                    home++;
                    appendDropDown += "<option value='" + data.data.home_number + "'> Home: " + data.data.home_number + "</option>";
                }

                if (count > 1) {
                    $('#ddPhone').html("");
                    /* 
                    	#temp disbale for new functionality
                    $('#formMultipleNumber').append(appendData);
                    $('#sendNewMessageContactModal').modal('hide');
                    $('#multipleContactFound').modal('show'); */
                    $('.txtPhoneNumberCls').hide();
                    $('.ddPhoneCls').show();
                    $('#ddPhone').append(appendDropDown);
                    return;
                }
                if (mobile < 1) {
                    $('.ddPhoneCls').hide();
                    $('.txtPhoneNumberCls').show();
                    $('#txtPhoneNumber').val(value)

                } else {
                    $('.ddPhoneCls').hide();
                    $('.txtPhoneNumberCls').show();
                    $('#txtPhoneNumber').val(data.data.mobile_number);
                    //	sendMessageFunction(data.data.mobile_number,message,contactName);
                    /* 	$('#userImportMessageForm #txtNumber').val("");
                    	$('#userImportMessageForm #txtMessage').val(""); */
                    /* 	$('#sendNewMessageContactModal').modal('hide');
                    	$('#multipleContactFound').modal('hide'); */
                }
            }
        });

    });


}
}

$('#input').keyup(function(e) {
    if (e.keyCode == 13) {
        sendMessage();
    }
});

let deleteChat = (key) => {
    confirmation = confirm("Are you sure you want to delete this chat");
    if (confirmation) {
        secret = $('#sms_number').val();

        $.ajax({
            type: "POST",
            async: false,
            dataType: 'JSON',
            url: link + "/user/dashboard/deleteConversation",
            data: {
                key: key,
                secret: secret
            },
            success: function(data) {
                if (data.code == 200) {
                    alert("Conversation Deleted");
                    $('div[data-main-chat="' + key + '"]').eq(0).remove();
                } else {
                    alert("Something went wrong");
                }
            }
        });
    }
}