<?php
function form_mail($sPara, $sAsunto, $sTexto, $sDe)
{
$bHayFicheros = 0;
$sCabeceraTexto = "";
$sAdjuntos = "";

if ($sDe)$sCabeceras = "From:".$sDe."n";
else $sCabeceras = "";
$sCabeceras .= "MIME-version: 1.0n";
foreach ($_POST as $sNombre => $sValor)
$sTexto = $sTexto."n".$sNombre." = ".$sValor;

foreach ($_FILES as $vAdjunto)
{
if ($bHayFicheros == 0)
{
$bHayFicheros = 1;
$sCabeceras .= "Content-type: multipart/mixed;";
$sCabeceras .= "boundary="--_Separador-de-mensajes_--"n";

$sCabeceraTexto = "----_Separador-de-mensajes_--n";
$sCabeceraTexto .= "Content-type: text/plain;charset=iso-8859-1n";
$sCabeceraTexto .= "Content-transfer-encoding: 7BITn";

$sTexto = $sCabeceraTexto.$sTexto;
}
if ($vAdjunto["size"] > 0)
{
$sAdjuntos .= "nn----_Separador-de-mensajes_--n";
$sAdjuntos .= "Content-type: ".$vAdjunto["type"].";name="".$vAdjunto["name"].""n";;
$sAdjuntos .= "Content-Transfer-Encoding: BASE64n";
$sAdjuntos .= "Content-disposition: attachment;filename="".$vAdjunto["name"].""nn";

$oFichero = fopen($vAdjunto["tmp_name"], 'r');
$sContenido = fread($oFichero, filesize($vAdjunto["tmp_name"]));
$sAdjuntos .= chunk_split(base64_encode($sContenido));
fclose($oFichero);
}
}

if ($bHayFicheros)
$sTexto .= $sAdjuntos."nn----_Separador-de-mensajes_----n";
return(mail($sPara, $sAsunto, $sTexto, $sCabeceras));
}

//cambiar aqui el email
if (form_mail("eduar.mejias26@gmail.com", $_POST[asunto],
"Los datos introducidos en el formulario son:nn", $_POST[email]))
echo "Su formulario ha sido enviado con exito";
?> 