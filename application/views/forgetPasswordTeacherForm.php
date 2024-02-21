<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Kidy View</title>
    <style>
        form{
            background: #f1f1f1;padding: 20px 10px;
        }
    </style>
</head>
<body>

    <table cellpadding="0" cellspacing="0" style="max-width:600px; margin:0% auto; padding:0px; text-align:center; font-family:Verdana, Geneva, Tahoma, sans-serif;">
        <tr>
            <td>
                <img src="<?php echo base_url();?>img/small_logo.png" alt="KidyView" style="max-width:200px; margin:0 auto; height:auto;" />
                <h2 style="display:block; padding:15px 0; margin:0;color:#00596f; font-size:20px; text-transform:uppercase;"><?=$message;?></h2>
        <?php 
        if($success == FALSE)
        {
        ?>        
                <p style="display:block; padding-bottom:15px; margin:0; color:#454545; font-size:12px;">
                   Please update your password
                </p>
                
                <?php
                if(isset($error))
                {
                    foreach ($error as $er)
                    {?>
                <p style="display:block; padding-bottom:15px; margin:0; color:red; font-size:12px;">
                    <?=$er?>
                </p>
                <?php        
                    }
                    
                }
                ?>
                <form method="post">                
                    <label style="display:block; padding-bottom: 5px; text-align: left;">New Password</label>
                    <input type="password" name="password" style="display:block; padding: 11px;border: 1px solid #545454;width: 93%; margin-bottom: 15px;" required=""/>
                    <label style="display:block; padding-bottom: 5px; text-align: left;">Confirm Password</label>
                    <input type="password" name="confirm_password" style="display:block; padding: 11px;border: 1px solid #545454;width: 93%;" required="" />
                        <input type="submit" name="submit" value="Submit" style="background: #00322d;border: 0;padding: 10px 20px;color: #fff;margin-top: 20px;display: inherit;font-size: 14px;font-weight: bold;"  />  
                       
                </form>
        <?php
        }
        ?>        
            </td>
        </tr>
    </table>

</body>
</html>