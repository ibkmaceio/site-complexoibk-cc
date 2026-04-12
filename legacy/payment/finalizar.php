<?php
//Verifica se foi enviado um metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//Inicia a session
  session_start();

//inclui o arquivo PagSeguroLibrary.php, para utilizamos a biblioteca
  require_once "PagSeguroLibrary/PagSeguroLibrary.php";

  include("../cms/config/classeSGBD.php");
  include("../cms/config/classeDb.php");
  include("../cms/config/config.php");
  include("../cms/config/class.php");

  /***********************************************************************
   *
   * Vamos agora resgatar as informações enviada pelo cliente
   * Para isso utilizarem a função filter_input_array para resgatar e filtrar
   * os dados. O recomendado realizar uma validação, pra verificar
   * se os dados estão de acordo que você espera receber
   **************************************************************************/
  $post = filter_input_array(INPUT_POST,
    array(
      'nome' => FILTER_SANITIZE_STRING,
      'email' => FILTER_SANITIZE_STRING,
      'ddd' => FILTER_SANITIZE_ENCODED,
      'telefone' => FILTER_SANITIZE_STRING,
      'rua' => FILTER_SANITIZE_STRING,
      'numero' => FILTER_SANITIZE_STRING,
      'complemento' => FILTER_SANITIZE_STRING,
      'bairro' => FILTER_SANITIZE_STRING,
      'cidade' => FILTER_SANITIZE_STRING,
      'uf' => FILTER_SANITIZE_STRING,
      'cep' => FILTER_SANITIZE_STRING
    )
  );

  /******************************************************************************
   * Agora vamos vamos integrar com o pagseguro
   *
   ******************************************************************************/

//Instancia a Classe PaymenteRequest
  $pagseguro = new PagSeguroPaymentRequest();

//Informa o tipo de moeda
  $pagseguro->setCurrency('BRL');

  /** Informo o Tipo de Frete:
   * 1 => Encomenda normal (PAC)
   * 2 => SEDEX
   * 3 => Tipo de frete não especificado
   */
  $pagseguro->setShippingType(2);

  /**
   * Informo o código de referência do Pedido.
   * É importante para identificar o pedido, e também caso queira trabalhar
   * com retorno automatico.
   * Se estivesse trabalho com tabelas pra guardar o pedido
   * seria o ID do Pedido.
   * Nesse exemplo irei colocar um valor aleatório
   */
  $pagseguro->setReference(uniqid(true));

  /**
   * Informo os dados do Cliente
   * Nome:
   * Email:
   * DDD:
   * Telefone : (valor numerico , exemplo: 6998522)
   */
  $pagseguro->setSender($post['nome'], $post['email'],
    $post['ddd'], $post['telefone']);

  /**
   * Informo as informações do endereço do cliente
   * CEP
   * Rua
   * Numero
   * Complemento
   * Bairro
   * Cidade
   * Estado
   * Pais
   */
  $pagseguro->setShippingAddress($post['cep'], $post['rua'], $post['numero'],
    $post['complemento'], $post['bairro'],
    $post['cidade'], $post['uf'], 'BRA');

  /**
   * Iremos nessa parte selecionar os produtos e adicionar
   */

//Resgata os ID's, e transforma em string, separado por virgula
  $ids = implode(', ', array_keys($_SESSION['carrinho']));

//Cria SQL para seleciona os produtos, filtrando pelo ID dos produtos
//Dessa maneira irei realizar apenas uma consulta no banco de dados
  $sql = sprintf("SELECT * FROM produtos WHERE id IN (%s)", $ids);

//Executa o SQL
  $query = mysql_query($sql);

//Resgata os valores da tabela produtos
  while ($row = mysql_fetch_assoc($query)) {
    $id = $row['id'];
    $produto = $row['produto'];
    $qtd = $_SESSION['carrinho'][$id];
    $preco = $row['preco'];
    $peso = $row['peso'];

    /**
     * Agora vamos adicionar os produtos.
     * Algo importante é relacionado ao peso do produto.
     * Esse valor terá que ser inteiro. Então 0,300 será 300.
     * As informações a serem adiciona no metodo addItem
     * ID
     * Produto
     * Quantidade
     * Valor
     * Peso
     */
    $pagseguro->addItem($id, $produto, $qtd, $preco, $peso);

  }

  /**
   * Iremos agora utilizar a classe AccountCredentials para adicionar as nossas credencias
   * Quer seria o email cadastrado no pagseguro, e TOKEN gerado no pagseguro
   */
  $credenciais = new PagSeguroAccountCredentials('sacingressosrecife@gmail.com', '79F4ECC023CE4FCA87F7AD553916063B');
  //$credentials = new PagSeguroAccountCredentials("oiromildojunior@yahoo.com.br", "8C195252F5CF427D9AD452FD134D0E32");

  /**
   * Agora vamos adicionar as credenciais informada na classe AccountCredentials
   * Com isso será gerado uma URL para o pagseguro
   *
   */
  $url = $pagseguro->register($credenciais);

//Agora vamos redirecionar para o PagSeguro
  header("Location: $url");

}