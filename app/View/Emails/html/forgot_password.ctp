<p>Hi <?php echo $data['User']['first_name']; ?>,
    <br /><br />
    Please click on the following link or paste it in the browser's address bar to reset your password.
    <br /><br />
    <a href="<?php echo $data['forgotPasswordKey']; ?>"><?php echo $data['forgotPasswordKey']; ?></a>
    <br /><br />
    <u>Note: Link will be expired in next 2 hrs.</u>
    <br /><br />
    Thanks & Regards,
    <br />
    Team Office Management
</p>