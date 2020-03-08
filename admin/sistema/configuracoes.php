<?PHP


//echo"<br> eu sou configuracoes<br>";
header('Content-Type: text/html; charset=utf-8');
	// Versoes
	// 1.0 sistema com menu dinamico
	// 2.0 diversas funcionalidades e com login e menu personalizado
	// 3.0 valida��o de usuarios com grava��o em texto
	// 3.1 controle de acesso ao banco de dados
	// 3.2 alteracao e exclusao de usuarios
	// 3.2.1 perfis din�micos
	// 3.2.2 superusuario

    // Definincoes da apresentacao do sistema

	$mostrar = array (
		'get' => true,
		'post' => true,
		'request' => true,
		'session' => true,
		'env' => true,
		'server' => true,
	'');

	$hostname = "consultoriawk";//trim(shell_exec('hostname'));

	define(@HOSTNAME, $hostname);

	if (@HOSTNAME == 'consultoriawk') {
		define(@USAR_BD, true);
		error_reporting(E_ALL & ~E_NOTICE); //E_ALL E_NOTICE E_WARNING
	} else {
		define(@USAR_BD, true);
		error_reporting(~E_ALL); //E_ALL E_NOTICE E_WARNING
	}
	@define(CIDADE, 'Florianopolis');
    @define(HTML_TITLE, 'Sistema Web WkAdmin');
    @define(HTML_TITLE_POPUP, 'Sistema Web Wk popup');
    @define(CABECALHO,HTML_TITLE);
    @define(RODAPE,'WK - Florian&oacute;polis');
    @define(VERSAO,'3.2.1');
	@define(COR01,'#effaFF');
	@define(COR02,'#dFEEEE');
	@define(COR_ERRO,'#990000');
	@define(DIR_SISTEMA, './sistema/');
	@define(ARQ_USUARIOS, DIR_SISTEMA.'usuarios.inc.php');
	@define(SU, 'smvs');
	@define(SS, '7885cabf2cddf4c78278ffb36f4037e1');

	// Local, data, semana

	$aux = date("d.m.Y.w");
	$aux = explode('.', $aux);
	$dia = $aux[0];
	$mes = $aux[1];
	$ano = $aux[2];
	$sem = $aux[3];

	switch ($mes) {
		case "1": $mes = 'Janeiro'; break;
		case "2": $mes = 'Fevereiro'; break;
		case "3": $mes = 'Março'; break;
		case "4": $mes = 'Abril'; break;
		case "5": $mes = 'Maio'; break;
		case "6": $mes = 'Junho'; break;
		case "7": $mes = 'Julho'; break;
		case "8": $mes = 'Agosto'; break;
		case "9": $mes = 'Setembro'; break;
		case "10": $mes = 'Outubro'; break;
		case "11": $mes = 'Novembro'; break;
		case "12": $mes = 'Dezembro'; break;
	}

	switch ($sem) {
		case "0": $sem = 'domingo'; 		$frase = "descanço merecido"; 			break;
		case "1": $sem = 'segunda-feira'; 	$frase = "pegando no tranco"; 			break;
		case "2": $sem = 'terça-feira'; 	$frase = "aquecendo as máquinas"; 		break;
		case "3": $sem = 'quarta-feira'; 	$frase = "a pleno vapor!"; 				break;
		case "4": $sem = 'quinta-feira'; 	$frase = "correria"; 					break;
		case "5": $sem = 'sexta-feira'; 	$frase = "que beleza, só alegria"; 		break;
		case "6": $sem = 'sábado'; 			$frase = "Festa!"; 						break;
	}

	$aux = "$dia de $mes de $ano";

	@define(FRASE, $frase);
	@define(DATA, $aux);
	@define(SEMANA, $sem);

?>