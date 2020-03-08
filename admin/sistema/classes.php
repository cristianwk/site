<?
header('Content-Type: text/html; charset=utf-8');
// funcoes diversas


function printr($arg, $exit = false) {

	echo "<pre>"; print_r($arg); echo "</pre>"; 
	if ($exit) exit;

}

function formatar_campo($arg, $tipo = 'string') {

	switch ($tipo) {
		case 'string': 
			$arg = ereg_replace("[^a-zA-Z0-9 .]", "", strtr($arg, "�������������������������� ", "aaaaeeiooouucAAAAEEIOOOUUC "));
		break;
		case 'numerico': 
			$arg = ereg_replace("[^0-9.]", "", $arg);
		break;
		case 'arquivo': 
			$arg = ereg_replace("[^a-zA-Z0-9_.]", "", strtr($arg, "�������������������������� ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
		break;
	}

	return $arg;

}

// Classes

class imagem {


	function redimensionar($File, $NewFile, $Porcentagem = 100, $Qualidade = 100) {
       
        $ImageFile = imagecreatefromjpeg ($File);
        $LarguraFile = imagesx($ImageFile);
        $AlturaFile = imagesy($ImageFile);

        $por = $Porcentagem / 100;
        $Largura1 = $LarguraFile*$por;
        $Altura1 = $AlturaFile*$por ;
        $min = min($AlturaFile,$LarguraFile);

		$NewImage = imagecreatetruecolor($Largura1, $Altura1);
		$TempImage = imagecreatetruecolor($LarguraFile, $AlturaFile);
		imagecopy($TempImage, $ImageFile, 0, 0, 0, 0, $LarguraFile, $AlturaFile);
		imagecopyresampled($NewImage, $TempImage, 0, 0, 0, 0,$Largura1,$Altura1,$LarguraFile,$AlturaFile);

        if($formato == "png") {
            imagepng($NewImage,$NewFile);
            chmod($NewFile, 0777);
        } else {
            imagejpeg($NewImage,$NewFile,$Qualidade);
            chmod($NewFile, 0777); 
        }

        return true;
    }

	function arquivos($diretorio, $arquivo, $extensao) {

		$diretorio = trim($diretorio);
		$arquivo = trim($arquivo);
		$extensao = trim($extensao);

		if(substr($diretorio,-1) != '/') $diretorio = $diretorio . '/';
		$arquivos = $arquivo . '.' . $extensao;
		$ls = "ls $diretorio$arquivos";
		$arquivos = shell_exec($ls);
		//$arquivos = (str_replace($diretorio, "", $arquivos));
		$arquivos = explode("\n", trim($arquivos));

		return $arquivos;

	}

	function redimensionar_imagens($diretorio,  $arquivo='*', $extensao='jpg', $proporcao=100, $qualidade=100, $largura, $altura) {

echo "$largura, $altura"; exit;

		$arquivos = $this->arquivos($diretorio, $arquivo, $extensao);

		$novos_arquivos = null;

		foreach ($arquivos as $arquivo) {

			switch ($extensao) {

				case 'jpg': 

					$novo_arquivo = $arquivo.'.jpg';
					if ($this->redimensionar($arquivo,$novo_arquivo, $proporcao, $qualidade)) {
						$novos_arquivos[] = $novo_arquivo;
					}

				break;

				case 'JPG': 

					$novo_arquivo = $arquivo.'.jpg';
					if ($this->redimensionar($arquivo,$novo_arquivo, $proporcao, $qualidade)) {
						$novos_arquivos[] = $novo_arquivo;
					}

				break;

			}

		}

		return trim($novos_arquivos);

	}

} $obj_imagem = new imagem;


class seguranca {

	function excluir_usuario($login) {

		$mesg = null;

		$login = trim($login);
		$linhas = file(ARQ_USUARIOS);
		
		$novo_arquivo = null;
		foreach ($linhas as $linha) {
			$aux = explode(',', $linha);
			if (trim($aux[1]) != $login) $novo_arquivo .= $linha;
		}

		if (false) {
		//if (!$novo_arquivo) {

			$mesg .= "Arquivo vazio";

		} elseif ($arquivo = fopen(ARQ_USUARIOS, 'w')) {

			if (fwrite($arquivo, $novo_arquivo) == false) {

				$mesg .= "N�o gravou no arquivo<br>"; 

			} else {

				$mesg .= "Usu�rio <b>$login</b> exclu�do com sucesso";

			}

		} else $mesg .= "N�o abriu o arquivo<br>";

		return $mesg;

	}

	function alterar_usuario($perfil, $novo_login, $login, $senha, $nome) {

		$mesg = null;

		$login_antigo = $login = trim($login);
		$novo_perfil = trim($perfil);
		$novo_login = trim($novo_login);
		$nova_senha = trim($senha);
		if ($nova_senha) $nova_senha = md5(trim($senha));
		$novo_nome = trim($nome);

		$linhas = file(ARQ_USUARIOS);

		$novo_arquivo = null;

		foreach ($linhas as $linha) {

			$aux = explode(',', $linha);

			if (trim($aux[1]) == $login) {

				if ($novo_perfil) $perfil = $novo_perfil; else $perfil = trim($aux[0]);
				if ($novo_login) $login = $novo_login; else $login = trim($aux[1]);
				if ($nova_senha) $senha = $nova_senha; else $senha = trim($aux[2]);
				if ($novo_nome) $nome = $novo_nome; else $nome = trim($aux[3]);

				$usuario = "$perfil,$login,$senha,$nome\n";

				$novo_arquivo .= $usuario;

			} else {

				$novo_arquivo .= $linha;

			}

		}

		if ($this->usuario_existe($login) and ($login != $login_antigo) ) {

			$mesg .= "Usu�rio <b>$login</b> j� cadastrado";

		} elseif (!$novo_arquivo) {

			$mesg .= 'Arquivo vaziu';

		} elseif ($arquivo = fopen(ARQ_USUARIOS, 'w')) {

			if (fwrite($arquivo, $novo_arquivo) == false) {

				$mesg .= 'N�o gravou<br>'; 

			} else {

					$mesg .= "Usu�rio <b>$login_antigo</b> alterado com sucesso<br>";

					if ($login_antigo != $novo_login and $login_antigo == $_SESSION['login']) $mesg .= "Usu�rio <b>$login_antigo</b> ser� deslogado<br>";

				}

		} else $mesg .= 'N�o abriu o arquivo<br>';

		return $mesg;

	}

	function usuario_existe($login) {
		echo"<br>usuario existe...<br>";
		echo"<pre>";print_r($login);echo"</pre>";
		$usuarios = $this->usuarios();

		if ($usuarios) foreach ($usuarios as $i => $v) if ($i == $login) return true;

		return false;

	}

	function cadastrar_usuario($perfil, $login, $senha, $nome) {

		$mesg = null;

		$perfil = trim($perfil);
		$login = trim($login);
		$senha = md5(trim($senha));
		$nome = trim($nome);

		$usuario = "$perfil,$login,$senha,$nome\n";

		if ($this->usuario_existe($login)) {

			$mesg .= "Usu�rio <b>$login</b> j� cadastrado";

		} elseif ($arquivo = fopen(ARQ_USUARIOS, 'a+')) {

			if (fwrite($arquivo, $usuario) == false) {

				$mesg .= "N�o gravou no arquivo<br>";

			} else {

				$mesg .= "Usu�rio <b>$login</b> cadastrado com sucesso";

			}

		} else $mesg .= "N�o abriu o arquivo<br>";

		return $mesg;

	}

	function usuarios() {

		if ($aux = file(ARQ_USUARIOS)) {

			foreach ($aux as $i => $v) {
				$aux = explode(',',$v);
                if (count($aux) == 4) {
                    $usuarios[$aux[1]]['perfil'] = trim($aux[0]);
                    $usuarios[$aux[1]]['senha'] = trim($aux[2]);
                    $usuarios[$aux[1]]['nome'] = trim($aux[3]);
                }
			}
	
			ksort($usuarios);

			return $usuarios;

		} else {

			return null;

		}


	}

	function validar_usuario($login, $senha) {

		$mesg = null;

		$aux = file(ARQ_USUARIOS);

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

			echo "<meta http-equiv=\"refresh\" content=\"0\" url=\"index.php\">";

        } elseif ($login == 'ancelmo') {

            echo "ancelmo"; exit;

		} elseif ($login and $senha) {

			$mesg .= "Usu�rio n�o autorizado";
			session_destroy();
			echo "<meta http-equiv=\"refresh\" content=\"0\" url=\"index.php\">";

		}

		return $mesg;

	}

}

$obj_seguranca = new seguranca;

class consulta {

	function consutar_servidores_cidades($link_bd, $ID_UF) {

		$sql = "select " .
			"CADASTROS.CIDADE.ID_CIDADE, " .
			"CADASTROS.CIDADE.NM_CIDADE, " .
			"CADASTROS.CIDADE_SERVIDOR.ID_SERVIDOR, " .
			"CADASTROS.TP_SERVIDOR.NM_SERVIDOR " .
		"from CADASTROS.CIDADE " .
			"left join CADASTROS.CIDADE_SERVIDOR using (ID_CIDADE) " .
			"left join CADASTROS.TP_SERVIDOR using (ID_SERVIDOR) " .
		"where CADASTROS.CIDADE.ID_UF = '$ID_UF' " .
		"order by CADASTROS.TP_SERVIDOR.NM_SERVIDOR " .
		";";
		echo "<br>sql: ".$sql;
		$res = mysql_query($sql, $link_bd);
		$rs = null;
		while ($r = mysql_fetch_assoc($res)) {
			if (!$r['NM_SERVIDOR']) $r['NM_SERVIDOR'] = 'Sem servidor associado';
			$rs[$r['NM_SERVIDOR']][$r['ID_CIDADE']] = $r['NM_CIDADE'];
		}

		return ($rs);

	}

	function consutar_servidores_cidades2($link_bd, $ID_UF) {

		$sql = "select " .
			"CADASTROS.CIDADE.ID_CIDADE, " .
			"CADASTROS.CIDADE.NM_CIDADE, " .
			"CADASTROS.CIDADE_SERVIDOR.ID_SERVIDOR, " .
			"CADASTROS.TP_SERVIDOR.NM_SERVIDOR,  " .
			"CADASTROS.TP_SERVIDOR.NM_IP " .
		"from CADASTROS.CIDADE " .
			"left join CADASTROS.CIDADE_SERVIDOR using (ID_CIDADE) " .
			"left join CADASTROS.TP_SERVIDOR using (ID_SERVIDOR) " .
		"where CADASTROS.CIDADE.ID_UF = '$ID_UF' " .
		"order by CADASTROS.TP_SERVIDOR.NM_SERVIDOR, CADASTROS.CIDADE.NM_CIDADE " .
		";";
		$res = mysql_query($sql, $link_bd);
		$rs = null;
		while ($r = mysql_fetch_assoc($res)) {
			if (!$r['NM_SERVIDOR']) $r['NM_SERVIDOR'] = 'Sem servidor associado';
			$rs[$r['NM_SERVIDOR']][$r['NM_IP']][$r['ID_CIDADE']] = $r['NM_CIDADE'];
		}
		
		return ($rs);

	}

}

$obj_consulta = new consulta;




?>