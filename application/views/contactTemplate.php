<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Contact Form</title>
</head>
<body>

    <table cellpadding="0" cellspacing="0" style="max-width:600px; margin:0% auto; padding:0px; text-align:center; font-family:Verdana, Geneva, Tahoma, sans-serif;">
        <tr>
            <td>
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Name :<?= $fname; ?>
                </p>
				<?php if(isset($lname) && $lname!=''){ ?>
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Last Name :<?= $lname; ?>
                </p>
				<?php }if(isset($organization) && $organization!=''){ ?>
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Organization :<?= $organization; ?>
                </p>
                <?php }if(isset($phone) && $phone!=''){ ?>
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Phone :<?= $phone; ?>
                </p>
                <?php }if(isset($email) && $email!=''){ ?>
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Email :<?= $email; ?>
                </p>
				<?php }if(isset($emp_strength) && $emp_strength!=''){ ?>
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Employee Strength :<?= $emp_strength; ?>
                </p>
				<?php }if(isset($owner) && $owner!=''){ ?>
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Owner :<?= $owner; ?>
                </p>
				<?php }if(isset($message) && $message!=''){ ?>
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Message :<?= $message; ?>
                </p>
                <?php } ?>
            </td>
        </tr>
    </table>

</body>
</html>