<?
  include_once dirname(__FILE__) . "/config/variables.php";
  include_once dirname(__FILE__) . "/config/authpostmaster.php";

  $domquery = "SELECT uid,gid,avscan,spamassassin,quotas,pipe FROM domains WHERE domain_id ='" .$_COOKIE[vexim][2]. "'";
  $domresult = $db->query($domquery);
  $domrow = $domresult->fetchRow();
?>
<html>
  <head>
    <title>Virtual Exim: Manage Users</title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body onLoad="document.adminadd.realname.focus()">
    <? include dirname(__FILE__) . "/config/header.php"; ?>
    <div id="menu">
      <a href="adminuser.php">Manage Accounts</a><br>
      <a href="admin.php">Main Menu</a><br>
      <br><a href="logout.php">Logout</a><br>
    </div>
    <div id="forms">
    <form name="adminadd" method="post" action="adminuseraddsubmit.php">
      <table align="center">
	<tr><td>Name:</td><td><input type="textfield" size="25" name="realname" class="textfield"></td></tr>
	<tr><td>Address:</td><td><input type="textfield" size="25" name="localpart" class="textfield">@<? print $_COOKIE[vexim][1]; ?></td></tr>
	<tr><td>Password:</td><td><input type="password" size="25" name="clear" class="textfield"></td></tr>
	<tr><td>Verify Password:</td><td><input type="password" size="25" name="vclear" class="textfield"></td></tr>
	<? if ($postmasteruidgid == "yes") {
	  print "<tr><td>UID:</td><td><input type=\"textfield\" size=\"25\" name=\"uid\" class=\"textfield\" value=\"$domrow[uid]\"></td></tr>";
	  print "<tr><td>GID:</td><td><input type=\"textfield\" size=\"25\" name=\"gid\" class=\"textfield\" value=\"$domrow[gid]\"></td></tr>"; 
	}
	if ($domrow[quotas] > "0") {
	  print "<tr><td>Mailbox quota ($domrow[quotas] Mb max):</td>";
	  print "<td><input type=\"text\" size=\"5\" name=\"quota\" value=\"$domrow[quotas]\" class=\"textfield\">Mb</td></tr>\n";
	} ?>
	<tr><td>Has domain admin privileges?</td><td><input type="checkbox" name="admin"></td></tr>
	<? if ($domrow[pipe] == "1") {
	     print "<tr><td>Pipe to command:</td><td><input type=\"textfield\" size=\"25\" name=\"smtp\" class=\"textfield\"></td></tr>\n";
	     print "<tr><td colspan=\"2\" style=\"padding-bottom:1em\">Optional: Pipe all mail to a command (e.g. procmail).<br>\n";
	     print "Check box below to enable:</td></tr>\n";
	     print "<tr><td>Enable piped command?</td><td><input type=\"checkbox\" name=\"pipe\"></td></tr>\n";
	   }
 	   if ($domrow[avscan] == "1") {
	     print "<tr><td>Anti-Virus:</td><td><input name=\"avscan\" type=\"checkbox\"></td></tr>";
	   }
	   if ($domrow[spamassassin] == "1") {
	     print "<tr><td>Spamassassin:</td><td><input name=\"spamassassin\" type=\"checkbox\"></td></tr>";
	     print "<tr><td>Spamassassin warn score:</td><td><input name=\"sa_tag\" type=\"text\" class=\"textfield\" value=\"$sa_tag\"></td>
	    		<td>The score at which to mark mail as \"Spam\" but still deliver</td></tr>";
	     print "<tr><td>Spamassassin refuse score:</td><td><input name=\"sa_refuse\" type=\"text\" class=\"textfield\" value=\"$sa_refuse\"></td>
	    		<td>The score at which to refuse potentially spam mail and not deliver</td></tr>";
	   }
	?>
	<tr><td>Enabled:</td><td><input type="checkbox" name="enabled" checked></td></tr>
	<tr><td colspan="2" class="button"><input name="submit" type="submit" value="Submit"></td>
      </table>
    </form>
  </body>
</html>
<!-- Layout and CSS tricks obtained from http://www.bluerobot.com/web/layouts/ -->