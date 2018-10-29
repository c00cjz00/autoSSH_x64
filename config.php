<?php
## ********* 必填 ********** ##
## 台灣杉IP ##
$sshIP="clogin1.twnia.nchc.org.tw"; // or clogin2.twnia.nchc.org.tw , glogin1.twni
$ftpIP="xdata1.twnia.nchc.org.tw"; // or xdata2.twnia.nchc.org.tw
## 台灣杉帳號 ##
$user="c00cjz00"; 
## 台灣杉otp key ##
$otpKey = '';

## ********** 選填 ********* ##
## 此項功能當填寫no時候, 可mask輸入密碼
$vbScript="yes"; //yes or no

## 此項功能當填寫no時候, 將不等候直接登入, 但不保證可順利登入 ##
## 此項功能當填寫yes時候, 最多等候30秒後登入, 保證可順利登入 ##
$waitFor30Seconds="no";  //yes or no

?>
