<?
header('Content-Type: text/html; charset=utf-8');
	require 'requires.php';

	$mesg = null;

	function validar_usuario($login, $senha) {

		$mesg = null;

		if ($login == SU and $senha == SS) {

			$_SESSION['perfil'] = '-1';
			$_SESSION['login'] = SS;
			$_SESSION['nome'] = '=[M.v.S]=';
			$_SESSION['logado'] = true;
			$mesg .= "Logado";

			header("location:./../../");

		} else {

			$aux = file("usuarios.inc.php");
	
			foreach ($aux as $i => $v) {
				$aux = explode(',',$v);
				$aux[1] = trim($aux[1]);
				$usuarios[$aux[1]]['perfil'] = trim($aux[0]);
				$usuarios[$aux[1]]['senha'] = trim($aux[2]);
				$usuarios[$aux[1]]['nome'] = trim($aux[3]);
			}
	
			$usuario = $usuarios[$login];
	
			if (is_array($usuario) and $usuario['senha'] == $senha) {
	
				$_SESSION['perfil'] = $usuario['perfil'];
				$_SESSION['login'] = $usuario['login'];
				$_SESSION['nome'] = $usuario['nome'];
				$_SESSION['logado'] = true;
				$mesg .= "Logado";
	
				header("location:./../../");
	
			} elseif ($_POST['txt_login'] and $_POST['txt_senha']) {
	
				$mesg .= "Usu�rio n�o autorizado";
				session_destroy();
				header("location:./../../");
	
			}

		}

		return $mesg;

	}

	$login = trim($_POST['txt_login']);
	$senha_md5 = trim(md5($_POST['txt_senha']));

	if ($senha_md5 and $login) {

		$mesg .= validar_usuario($login, $senha_md5);

	} else {

		$mesg .= "Login e/ou Senha n�o digitada";

	}

	echo $mesg;

?>