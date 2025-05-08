<?php
  echo '<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Log into iDiscuss account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/Forum/login.php" method="POST">
          <div class="form-group">
            <label for="loginUsername">Username</label>
            <input type="text" class="form-control" name="loginUsername" id="loginUsername" aria-describedby="loginUsernameHelp">
          </div>
          <div class="form-group">
            <label for="loginEmail">Email address</label>
            <input type="email" class="form-control" name="loginEmail" id="loginEmail" aria-describedby="loginEmailHelp">
          </div>
          <div class="form-group">
            <label for="loginPassword">Password</label>
            <input type="password" class="form-control" name="loginPassword" id="loginPassword">
            </div>
          <button type="submit" class="btn btn-primary">Log In</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>'
?>