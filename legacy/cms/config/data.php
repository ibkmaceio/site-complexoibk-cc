<?php

// CONFIGURACAO DE DATAS
$dia 				= date('d');
$mes_completo 		= date('m');
$ano 				= date('Y');
$semana 			= date('w');

switch ($mes_completo){
	case 1:  $mes_completo = "Janeiro"; 			break;
	case 2:  $mes_completo = "Fevereiro"; 		break;
	case 3:  $mes_completo = "Março"; 			break;
	case 4:  $mes_completo = "Abril"; 			break;
	case 5:  $mes_completo = "Maio"; 			break;
	case 6:  $mes_completo = "Junho"; 			break;
	case 7:  $mes_completo = "Julho"; 			break;
	case 8:  $mes_completo = "Agosto"; 			break;
	case 9:  $mes_completo = "Setembro"; 		break;
	case 10: $mes_completo = "Outubro"; 			break;
	case 11: $mes_completo = "Novembro"; 		break;
	case 12: $mes_completo = "Dezembro"; 		break;
}

switch ($semana) {
	case 0: $semana = "Domingo"; 		break;
	case 1: $semana = "Segunda Feira";  break;
	case 2: $semana = "Terça Feira";	break;
	case 3: $semana = "Quarta Feira"; 	break;
	case 4: $semana = "Quinta Feira"; 	break;
	case 5: $semana = "Sexta Feira"; 	break;
	case 6: $semana = "Sábado"; 		break;
}

?>