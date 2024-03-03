<script>
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
</script>