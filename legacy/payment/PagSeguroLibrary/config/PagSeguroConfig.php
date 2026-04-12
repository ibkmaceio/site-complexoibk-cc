<?php
/**
 * 2007-2014 [PagSeguro Internet Ltda.]
 *
 * NOTICE OF LICENSE
 *
 *Licensed under the Apache License, Version 2.0 (the "License");
 *you may not use this file except in compliance with the License.
 *You may obtain a copy of the License at
 *
 *http://www.apache.org/licenses/LICENSE-2.0
 *
 *Unless required by applicable law or agreed to in writing, software
 *distributed under the License is distributed on an "AS IS" BASIS,
 *WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *See the License for the specific language governing permissions and
 *limitations under the License.
 *
 *  @author    PagSeguro Internet Ltda.
 *  @copyright 2007-2014 PagSeguro Internet Ltda.
 *  @license   http://www.apache.org/licenses/LICENSE-2.0
 */

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = "production"; // production, sandbox
//$PagSeguroConfig['environment'] = "sandbox"; // production, sandbox

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = "diretoria001@adcolconsultoria.com.br";
$PagSeguroConfig['credentials']['token']['production'] = "C6209A5A5AC846A990582FA5640E0179";
// $PagSeguroConfig['credentials']['email'] = "sacingressosrecife@gmail.com";
// $PagSeguroConfig['credentials']['token']['production'] = "79F4ECC023CE4FCA87F7AD553916063B";
//$PagSeguroConfig['credentials']['email'] = "oiromildojunior@yahoo.com.br";
//$PagSeguroConfig['credentials']['token']['production'] = "8C195252F5CF427D9AD452FD134D0E32";
//$PagSeguroConfig['credentials']['token']['sandbox'] = "AA325901B62B4E32A3E0D1EA077D2BDC";

//$PagSeguroConfig['credentials']['token']['sandbox'] = "your_sandbox_pagseguro_token";
//$PagSeguroConfig['credentials']['appId']['production'] = "your__production_pagseguro_application_id";
//$PagSeguroConfig['credentials']['appId']['sandbox'] = "your_sandbox_pagseguro_application_id";
//$PagSeguroConfig['credentials']['appKey']['production'] = "your_production_application_key";
//$PagSeguroConfig['credentials']['appKey']['sandbox'] = "your_sandbox_application_key";

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = false;
// Informe o path completo (relativo ao path da lib) para o arquivo, ex.: ../PagSeguroLibrary/logs.txt
//$PagSeguroConfig['log']['fileLocation'] = "/var/www/html/logs.txt";
