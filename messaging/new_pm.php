<?php
include('include/config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>New PM</title>
    </head>
    <body>
        <div class="header">
                </div>
<?php
//check if the user is logged
if(isset($_SESSION['username']))
{
$form = true;
$otitle = '';
$orecip = '';
$omessage = '';
//check if the form has been sent
if(isset($_POST['title'], $_POST['recip'], $_POST['message']))
{
        $otitle = $_POST['title'];
        $orecip = $_POST['recip'];
        $omessage = $_POST['message'];
        
        if(get_magic_quotes_gpc())
        {
                $otitle = stripslashes($otitle);
                $orecip = stripslashes($orecip);
                $omessage = stripslashes($omessage);
        }
        // check if all the fields are filled
        if($_POST['title']!='' and $_POST['recip']!='' and $_POST['message']!='')
        {
                //protect the variables
                $title = mysql_real_escape_string($otitle);
                $recip = mysql_real_escape_string($orecip);
                $message = mysql_real_escape_string(nl2br(htmlentities($omessage, ENT_QUOTES, 'UTF-8')));
                //We check if the recipient exists
                $dn1 = mysql_fetch_array(mysql_query('select count(id) as recip, id as recipid, (select count(*) from pm) as npm from users where username="'.$recip.'"'));
                if($dn1['recip']==1)
                {
                        // check if the recipient is not the actual user
                        if($dn1['recipid']!=$_SESSION['userid'])
                        {
                                $id = $dn1['npm']+1;
                                //send the message
                                if(mysql_query('insert into pm (id, id2, title, user1, user2, message, timestamp, user1read, user2read)values("'.$id.'", "1", "'.$title.'", "'.$_SESSION['userid'].'", "'.$dn1['recipid'].'", "'.$message.'", "'.time().'", "yes", "no")'))
                                {
?>
<div class="message">The message has successfully been sent.<br />
<a href="list_pm.php">List of my Personal messages</a></div>
<?php
                                        $form = false;
                                }
                                else
                                {
                                        //Otherwise, say that an error occured
                                        $error = 'An error occurred while sending the message';
                                }
                        }
                        else
                        {
                                //Otherwise, say the user cannot send a message to himself
                                $error = 'You cannot send a message to yourself.';
                        }
                }
                else
                {
                        //Otherwise,say the recipient does not exists
                        $error = 'The recipient does not exists.';
                }
        }
        else
        {
                //Otherwise, say a field is empty
                $error = 'A field is empty. Please fill of the fields.';
        }
}
elseif(isset($_GET['recip']))
{
        //get the username for the recipient if available
        $orecip = $_GET['recip'];
}
if($form)
{
//display a message if necessary
if(isset($error))
{
        echo '<div class="message">'.$error.'</div>';
}
//display the form
?>
<div class="content">
        <h1>New Personal Message</h1>
    <form action="new_pm.php" method="post">
                Please fill the following form to send a Personal message.<br />
        <label for="title">Title</label><input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" id="title" name="title" /><br />
        <label for="recip">Recipient<span class="small">(Username)</span></label><input type="text" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>" id="recip" name="recip" /><br />
        <label for="message">Message</label><textarea cols="40" rows="5" id="message" name="message"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea><br />
        <input type="submit" value="Send" />
    </form>
</div>
<?php
}
}
else
{
        echo '<div class="message">You must be logged to access this page.</div>';
}
?>
                <div class="foot"><a href="list_pm.php">Go to my Personal messages</a> - <a href="http://financetitan.great-site.net/"> Finance Titan</a></div>
        </body>
</html>
