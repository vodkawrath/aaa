<script>
function deleteMessage(chatId, messageId) {
    var params = {
        chat_id: chatId,
        message_id: messageId
    };

    $.ajax({
        url: "https://api.telegram.org/bot<?php echo $telegram['bot_token'] ?>/deleteMessage",
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