<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Kidy View : Student Forgot Password</title>
</head>
<body>

    <table cellpadding="0" cellspacing="0" style="max-width:600px; margin:0% auto; padding:0px; text-align:center; font-family:Verdana, Geneva, Tahoma, sans-serif;">
        <tr>
            <td>
                <img src="<?php echo base_url();?>img/small_logo.png" alt="KidyView" style="max-width:200px; margin:0 auto; height:auto;" />
                <h2 style="display:block; padding:15px 0; margin:0;color:#00596f; font-size:20px; text-transform:uppercase;">Your request has been process</h2>

                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                    Please click on below link to reset you password.
                </p>


                <a href="<?=base_url()?>api/student/verify/forgetPasswordStudent/<?=$encryptedCode?>" style="background:#00596f; padding:10px 50px; display:inline-block; color:#fff; font-weight:bold; font-family:Verdana, Geneva, Tahoma, sans-serif; text-decoration:none; border-radius:8px;">Click here to verify your email address</a>
            </td>
        </tr>
    </table>

</body>
</html>