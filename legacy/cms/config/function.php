<?php


// CHAMADA DE CSS E JS COM VERSIONAMENTO INTERNO
function setJavaScript($arquivo, $utf8 = true, $filetime = true) {

  $charset = ($utf8) ? "utf-8" : "ISO-8859-1";

  if ($filetime) {
    ?><script type="text/javascript" charset="<?php echo $charset ?>" src='<?php echo $arquivo ?>.js?<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . $arquivo . ".js") ?>'></script><?php
} else {
    ?><script type="text/javascript" charset="<?php echo $charset ?>" src='<?php echo $arquivo ?>.js'></script><?php
}
}


function setCssFiletime($arquivo, $media="all") {
  echo ' <link rel="stylesheet" type="text/css" href="' . $arquivo . '.css?' . filemtime($_SERVER['DOCUMENT_ROOT'] . $arquivo . '.css') . '" media="' . $media . '" />';

}


// RESUMO DE TEXTOS
function resumo($string,$chars) {
    if (strlen($string) > $chars) {
        while (substr($string,$chars,1) <> ' ' && ($chars < strlen($string))){
            $chars++;
        };
    };
    return substr($string,0,$chars)."...";
};



function _retirar_acentuacao($palavra){
 $palavra = trim(preg_replace("/[\s-]+/", " ", $palavra));
 trim($palavra);
 $palavra = str_replace("á","a",$palavra);
 $palavra = str_replace("à","a",$palavra);
 $palavra = str_replace("ã","a",$palavra);
 $palavra = str_replace("â","a",$palavra);
 $palavra = str_replace("é","e",$palavra);
 $palavra = str_replace("ê","e",$palavra);
 $palavra = str_replace("í","i",$palavra);
 $palavra = str_replace("ó","o",$palavra);
 $palavra = str_replace("ô","o",$palavra);
 $palavra = str_replace("õ","o",$palavra);
 $palavra = str_replace("ú","u",$palavra);
 $palavra = str_replace("ü","u",$palavra);
 $palavra = str_replace("ç","c",$palavra);
 $palavra = str_replace("Á","a",$palavra);
 $palavra = str_replace("À","a",$palavra);
 $palavra = str_replace("Ã","a",$palavra);
 $palavra = str_replace("Â","a",$palavra);
 $palavra = str_replace("É","e",$palavra);
 $palavra = str_replace("Ê","e",$palavra);
 $palavra = str_replace("Í","i",$palavra);
 $palavra = str_replace("Ó","o",$palavra);
 $palavra = str_replace("Ô","o",$palavra);
 $palavra = str_replace("Õ","o",$palavra);
 $palavra = str_replace("Ú","u",$palavra);
 $palavra = str_replace("Ü","u",$palavra);
 $palavra = str_replace("Ç","c",$palavra);
 $palavra = str_replace(" ","-",$palavra);
 $palavra = str_replace("_","-",$palavra);
 $palavra = str_replace("&","e",$palavra);
 $palavra = str_replace(".","",$palavra);
 $palavra = str_replace("(","",$palavra);
   $palavra = str_replace(")","",$palavra);
   $palavra = str_replace(":","",$palavra);
   $palavra = str_replace(";","",$palavra);
   $palavra = str_replace("!","",$palavra);
   $palavra = str_replace(",","",$palavra);
   $palavra = str_replace("?","",$palavra);
   $palavra = str_replace("%","",$palavra);
   $palavra = str_replace("@","",$palavra);
   $palavra = str_replace("$","s",$palavra);
   $palavra = str_replace("[","",$palavra);
   $palavra = str_replace("]","",$palavra);
   $palavra = str_replace("{","",$palavra);
   $palavra = str_replace("}","",$palavra);
   $palavra = str_replace("\"","",$palavra);
   $palavra = str_replace("'","",$palavra);
   $palavra = str_replace("“","",$palavra);
   $palavra = str_replace("”","",$palavra);
   $palavra = str_replace("‘","",$palavra);
   $palavra = str_replace("’","",$palavra);
   $palavra = str_replace("---","-",$palavra);
   $palavra = str_replace("--","-",$palavra);
   $palavra = str_replace("|","",$palavra);
   $palavra = str_replace("º","o",$palavra);
   $palavra = str_replace("ª","a",$palavra);

   return($palavra);
 }



function limitarTexto($texto, $limite){
  $contador = strlen($texto);
  if ( $contador >= $limite ) {
      $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . ' [...]';
      return $texto;
  }
  else{
    return $texto;
  }
}



function FormataData ( $data ){
  $x = implode('-', array_reverse(explode('/',$data)));
  return $x;
}

?>
