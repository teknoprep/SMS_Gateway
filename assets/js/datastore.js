let MessageUtils;
let contactList;
  let messages;
  let user;

$(document).ready(function(){

  $('#cover-spin').show();
  sms_number = $('#sms_number').val();
  

$('#sms_number').on('change', function() {

  $('#cover-spin').show();
  $('#chat-list').html("");
  sms_number = this.value;

$.ajax({
  url: link + "/user/dashboard/getUserById",
  type: 'GET',
  dataType: "json",
  data: {
    sms_number: sms_number
  }
}).done(function(data) {user = data;}); 


$.ajax({
  type: "GET",
  async: false,
  dataType: 'json',
  url: link + "/user/dashboard/getAllContacts",
  data: {
    sms_number: sms_number
  },
  success: function (data) {
    
      contactList = data;
  },
});


$.ajax({
  type: "GET",
  dataType: 'json',
  url: link + "/user/dashboard/getAllMessages",
  data: {
    sms_number: sms_number
  },
  
  success: function (data) {
   
    messages = data;
  },
});


let groupList = [
  {
    id: 1,
    name: "Programmers",
    members: [1, 3, 5],
    pic: "../assets/images/0923102932_aPRkoW.jpg",
  },
  {
    id: 2,
    name: "Web Developers",
    members: [2,5],
    pic: "../assets/images/1921231232_Ag1asE.png",
  },
  {
    id: 3,
    name: "notes",
    members: [5],
    pic: "../assets/images/8230192232_asdEWq2.png",
  },
]; 

MessageUtils = {
  getByGroupId: (groupId) => {
    return messages.filter((msg) => msg.recvIsGroup && msg.recvId === groupId);
  },
  getByContactId: (contactId) => {
    return messages.filter((msg) => {
      return (
        !msg.recvIsGroup &&
        ((msg.sender === user.id && msg.recvId === contactId) ||
          (msg.sender === contactId && msg.recvId === user.id))
      );
    });
  },
  getMessages: () => {
    return messages;
  },
  changeStatusById: (options) => {
    messages = messages.map((msg) => {
      if (options.isGroup) {
        if (msg.recvIsGroup && msg.recvId === options.id) msg.status = 2;
      } else {
        if (
          !msg.recvIsGroup &&
          msg.sender === options.id &&
          msg.recvId === user.id
        )
          msg.status = 2;
      }
      return msg;
    });
  },
  addMessage: (msg) => {
    msg.id = messages.length + 1;
    messages.push(msg);
  },
};

let init = () => {

    DOM.profilePic.stc = '/assets/images/newlogo.png';
    DOM.profilePic.addEventListener("click", () => DOM.profilePicInput.click());
    DOM.profilePicInput.addEventListener("change", () => console.log(DOM.profilePicInput.files[0]));
    generateChatList();
  
    $('#cover-spin').hide();
  };

setTimeout(() => {
	init();
}, 5000);

}); //end of click function


$.ajax({
  url: link + "/user/dashboard/getUserById",
  type: 'GET',
  dataType: "json",
  data: {
    sms_number: sms_number
  }
}).done(function(data) {
user = data;
}); 


$.ajax({
  type: "GET",
  async: false,
  dataType: 'json',
  url: link + "/user/dashboard/getAllContacts",
  data: {
    sms_number: sms_number
  },
  success: function (data) {
    
      contactList = data;
  },
});


$.ajax({
  type: "GET",
  dataType: 'json',
  url: link + "/user/dashboard/getAllMessages",
  data: {
    sms_number: sms_number
  },
  success: function (data) {
   
    messages = data;
  },
});


let groupList = [
  {
    id: 1,
    name: "Programmers",
    members: [1, 3, 5],
    pic: "../assets/images/0923102932_aPRkoW.jpg",
  },
  {
    id: 2,
    name: "Web Developers",
    members: [2,5],
    pic: "../assets/images/1921231232_Ag1asE.png",
  },
  {
    id: 3,
    name: "notes",
    members: [5],
    pic: "../assets/images/8230192232_asdEWq2.png",
  },
]; 

MessageUtils = {
  getByGroupId: (groupId) => {
    return messages.filter((msg) => msg.recvIsGroup && msg.recvId === groupId);
  },
  getByContactId: (contactId) => {
    return messages.filter((msg) => {
      return (
        !msg.recvIsGroup &&
        ((msg.sender === user.id && msg.recvId === contactId) ||
          (msg.sender === contactId && msg.recvId === user.id))
      );
    });
  },
  getMessages: () => {
    return messages;
  },
  changeStatusById: (options) => {
    messages = messages.map((msg) => {
      if (options.isGroup) {
        if (msg.recvIsGroup && msg.recvId === options.id) msg.status = 2;
      } else {
        if (
          !msg.recvIsGroup &&
          msg.sender === options.id &&
          msg.recvId === user.id
        )
          msg.status = 2;
      }
      return msg;
    });
  },
  addMessage: (msg) => {
    msg.id = messages.length + 1;
    messages.push(msg);
  },
};


let init = () => {

    DOM.profilePic.stc = '/assets/images/newlogo.png';
    DOM.profilePic.addEventListener("click", () => DOM.profilePicInput.click());
    DOM.profilePicInput.addEventListener("change", () => console.log(DOM.profilePicInput.files[0]));
    generateChatList();
    $('#cover-spin').hide();
    
  };

setTimeout(() => {
  init();

}, 3000);

}); //ready function
