<?php
if (!isset($argv[1])) { echo "請輸入WinSCPPortable.exe位置"; exit(); }
$WinSCP=trim($argv[1]);
$dirBin=dirname(__FILE__);
define('MODULE_FILE', true);
include($dirBin."/config.php");
if (($user=="") || !isset($user) || ($otpKey=="") || !isset($otpKey) ){
 $vbscript = sys_get_temp_dir() . 'prompt_password.vbs';
 file_put_contents(
  $vbscript, 'wscript.echo(InputBox("'
  . addslashes($prompt)
  . '", "", "Edit config.php, and type ACCOUNT and OTP key"))');
 $command = "cscript //nologo " . escapeshellarg($vbscript);
 $password = rtrim(shell_exec($command));	
 exit();
}
if (!isset($passwd) || ($passwd=="")) {
 if ((preg_match('/^win/i', PHP_OS)) && ($vbScript=="no")){
  echo 'Enter password: '; $passwd = exec('hiddeninput.exe'); 
  echo PHP_EOL; 
 }else{
  $passwd=prompt_silent();
 }
}
if (($passwd!="") && ($otpKey!="")){
 if ($waitFor30Seconds=="yes"){
  $time=30-(gmdate("s", time())%30);
  echo "Please wait for ".$time." secnods!\n"; 
  for($i=0;$i<=$time;$i++){ echo $i." "; sleep(1); }
 }
 $cmd=createWinSCPConnection($WinSCP,$ftpIP,$user,$passwd,$otpKey);  passthru($cmd);
}


function createWinSCPConnection($WinSCP,$ip,$user,$passwd,$otpKey){
 $dirBin=dirname(__FILE__);
 include_once($dirBin."/lib/GoogleAuthenticator.php");
 $g = new GoogleAuthenticator(); $googleKey = $g->getCode($otpKey); $passwd=$passwd.$googleKey;
 $cmd=$dirBin."/".$WinSCP." sftp://".$user.":".$passwd."@".$ip;
 return $cmd;
}

   
function prompt_silent($prompt = "Enter Password:") {
  if (preg_match('/^win/i', PHP_OS)) {
    $vbscript = sys_get_temp_dir() . 'prompt_password.vbs';
    file_put_contents(
      $vbscript, 'wscript.echo(InputBox("'
      . addslashes($prompt)
      . '", "", "password here"))');
    $command = "cscript //nologo " . escapeshellarg($vbscript);
    $password = rtrim(shell_exec($command));
    unlink($vbscript);
    return $password;
  } else {
    $command = "/usr/bin/env bash -c 'echo OK'";
    if (rtrim(shell_exec($command)) !== 'OK') {
      trigger_error("Can't invoke bash");
      return;
    }
    $command = "/usr/bin/env bash -c 'read -s -p \""
      . addslashes($prompt)
      . "\" mypassword && echo \$mypassword'";
    $password = rtrim(shell_exec($command));
    echo "\n";
    return $password;
  }
}
?>
