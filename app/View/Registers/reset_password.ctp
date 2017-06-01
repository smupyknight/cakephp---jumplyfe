
<form action="api/reset_password" id="reset_password" style="width: 60%; margin-left: 20%;">
    <div class="form-group">
        <label>Email *</label>
        <input id="email" name="email" type="text" class="form-control required">
    </div>

    <div class="form-group">
        <label>New Password *</label>
        <input id="password" name="password" type="text" class="form-control required">
    </div>

    <div class="form-group">
        <label>Confirm Password *</label>
        <input id="admin_name" name="admin_name" type="text" class="form-control required">
    </div>
    <input type="button" id="reset_button" class="btn btn-sm btn-primary pull-right" value="Save Change">
</form>

<script>
    jQuery('document').ready(function() {
        jQuery('#reset_button').click(function() {
            var email = jQuery('#email').val();
            var password = jQuery('#password').val();
            $.get('api/reset_password', {'email': email, 'password': password})
            .done(function(data){
                alert("Password reset successfully");
            })
            .fail(function() {
                alert("Error");
            });
        });
    });
</script>