<?php

class sgbd
{
  var $id;
  var $nameSGBD;
  var $host;
  var $user;

  function sgbd($bco, $host, $user, $pass)
  {
    $this->id = 0;
    if ($bco == "mysql") {
      $this->id = @mysql_connect($host, $user, $pass);
      if ($this->id) {
        $this->nameSGBD = $bco;
        $this->host = $host;
        $this->user = $user;
      }
    }
  }

  public static function anti_injection($sql, $formUse = true)
  {
    // remove palavras que contenham sintaxe sql
    $sql = preg_replace("/(from|select|insert|delete|where|sleep|onMouseOver|drop table|show tables|#|\*|--|\\\\)/i", "", $sql);
    $sql = trim($sql); //limpa espaços vazio
    $sql = strip_tags($sql); //tira tags html e php
    $sql = filter_var($sql, FILTER_SANITIZE_STRING);
    if (!$formUse || !get_magic_quotes_gpc())
      $sql = addslashes($sql); //Adiciona barras invertidas a uma string
    return $sql;
  }

  function value()
  {
    return ($this->id);
  }

  function close()
  {
    @mysql_close($this->id);
  }
}

?>