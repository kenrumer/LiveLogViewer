<?php

  @require_once("../common/include/common.inc");

  $common = new common();
  $to = html_entity_decode(urldecode($common->get_post_string($_POST, 'to')));
  $subject = html_entity_decode(urldecode($common->get_post_string($_POST, 'subject')));
  $filename = html_entity_decode(urldecode($common->get_post_string($_POST, 'filename')));
  $data = html_entity_decode(urldecode($common->get_post_string($_POST, 'filedata')));
  $data = chunk_split(base64_encode($data));
  $ext = substr(strrchr($filename, '.'), 1);
  if ($ext == "") {
    $ext = "txt";
  }
  $filetype = "text/plain";
  $boundary = md5(time());
  $message = "Attachment: $filename";

  $headers = "From: ".$to."\n".
             "Date: ".date('r')."\n".
             "X-Mailer: PHP v".phpversion()."\n".
             "MIME-Version: 1.0\n".
             "Content-Type: multipart/mixed; boundary=\"".$boundary."\";\n".
             "charset=\"iso-8859-1\"\n".
             "Content-Transfer-Encoding: 7bit\n".
             "If you are reading this, then you e-mail client does not support MIME.\n".
             "--".$boundary."\n".
             "Content-Type: text/plain; charset=\"iso-8859-1\"\n".
             "Content-Transfer-Encoding: 7bit\n".
             "\n".
             "Attachment: ".$filename."\n".
             "\n".
             "--".$boundary."\n".
             "Content-Type: application/".$ext."; name=\"".$filename."\"\n".
             "Content-Disposition: attachment;\n".
             "Content-Transfer-Encoding: base64\n".
             "\n".
             $data."\n".
             "\n".
             "--".$boundary."--\n";

  if (mail($to, $subject, $message, $headers)) {
    echo ("message sent successfully");
  } else {
    echo ("failed to send message");
  }

?>
