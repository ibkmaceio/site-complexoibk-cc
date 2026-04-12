<?php
  ###########################################################
  ## Rota3 - www.rota3.com.br                              ##
  ## Programador: Ederson     <ederson@rota3.com.br>       ##
  ###########################################################
  ## Arquivo: config/classeSecao.php                       ##
  ###########################################################


  class db {
    var $id;
    var $dados;
    var $rows;
    var $rowcurr;
    var $res;
	var $assoc;

    function db($bco, $id) {
      $this->rowcurr = 0;
      @mysql_select_db($bco, $id);
      $this->id = $id;
    }

    function consulta($sql) {
      $this->res = @mysql_query($sql, $this->id);
      $this->rows = @mysql_num_rows($this->res);
	  $this->assoc = @mysql_fetch_assoc($this->res);
	  return $this->res;
    }

    function getRows() {
      return ($this->rows);
    }

	function getAssoc() {
      return ($this->assoc);
    }

    function first() {
      $this->rowcurr = 0;
      @mysql_data_seek($this->res, $this->rowcurr);
      $this->dados = @mysql_fetch_array($this->res);
    }

    function next() {
      $this->rowcurr = ($this->rowcurr < $this->rows) ? ++$this->rowcurr : ($this->rows - 1);
      @mysql_data_seek($this->res, $this->rowcurr);
      $this->dados = @mysql_fetch_array($this->res);
    }

    function last() {
      $this->rowcurr = ($this->rows - 1) ;
      @mysql_data_seek($this->res, $this->rowcurr);
      $this->dados = @mysql_fetch_array($this->res);
    }

    function getDados() {
      return ($this->dados);
    }
  }
?>
