<?php
echo '<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Sign up for iDiscuss account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/Forum/signup.php" method="POST">
          <div class="form-group">
            <label for="signupUsername">Username</label>
            <input maxlength="255" type="text" class="form-control" name="signupUsername" id="signupUsername" aria-describedby="signupUsernameHelp">
          </div>
          <div class="form-group">
            <label for="signupEmail">Email address</label>
            <input maxlength="255" type="signupEmail" class="form-control" name="signupEmail" id="signupEmail" aria-describedby="signupEmailHelp">
          </div>
          <div class="form-group">
            <label for="signupPassword">Password</label>
            <input maxlength="255" type="Password" class="form-control" name="signupPassword" id="signupPassword">
          </div>
          <div class="form-group">
            <label for="signupConfirmPassword">Confirm Password</label>
            <input type="password" class="form-control" name="signupConfirmPassword" id="signupConfirmPassword">
            <small id="signupConfirmPassword" class="form-text text-muted">Please enter the same password as above..</small>
          </div>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>';
?>