<?

    $pg['titulo'] = 'Desenvolvimento de Páginas';
    $pg['colspan'] = '1';

    $pg['topico'][] = 'HTML';
    $pg['texto'][] = "<pre>
<b>Abrir Pop Up</b>

window.open(\"arquivo.php\",\"nome_da_janela\",\"parametros\");

Exemplo de parâmetros:
	top=0
	left=0
	screenY=0
	screenX=0
	toolbar=no
	location=no
	directories=no
	status=yes
	menubar=no
	scrollbars=yes
	resizable=no
	width=780
	height=500
	innerwidth=780
	innerheight=500

<b>Ponteiro do mouse</b>
style=\"
    background-color    : #9bd5ff; 
    cursor              : pointer;
    color               : #ff0101;
    font-weight         : bold;\"
    </pre>";

    $pg['topico'][] = 'JavaScript';
    $pg['texto'][] = "<pre>
<b>Marcar e desmarcar todos os checkbox</b>

&#60;script language=\"JavaScript\" type=\"text/javascript\"&#62;

    function marcar_todos(formulario, cbx_controle, cbx_destino) {

        var campos = formulario.elements;

        for(i = 1; i < campos.length; i++) {

            if (campos[i].name.search(cbx_destino) == 0) {

                if(cbx_controle.checked) campos[i].checked = true; else campos[i].checked = false;

            }

        }

&#60;/script&#62;

&#60;html&#62;
    &#60;input type=\"checkbox\" name=\"cbx_todos\" onchange=\"marcar_todos(this.form, this, 'cbx_servidores');\">&nbsp;&#60;b&#62;marcar todos&#60;/b&#62;
&#60;/html&#62;

<b>Função focus() no Firefox</b>

&#60;script language=\"javascript\" type=\"text/javascript\"&#62;//&#60;!--

  function tamconvenio(campo,banco) {

    erro = new String;

    if (banco == 1) {

        if (campo.value.length != 6 && campo.value.length != 7) {

            erro += \"O convênio do Banco do Brasil deve ter 6 ou 7 digitos. Verifique seu convênio!\";
            alert(erro);
            globalvar = campo;
            campo.value = '';
            setTimeout(\"globalvar.focus()\",250);

        }

    }

    else return true;

  } 

//--&#62;&#60;/script&#62;

<b>Janela PopUp</b>

window.open(
    \"rsolic_habitese.php\",
    \"janela\",
    \"top=5000,left=5000,screenY=5000,screenX=5000,toolbar=no,location=no,
    directories=no,status=yes,menubar=no,scrollbars=no,resizable=no,width=1,
    height=1,innerwidth=1,innerheight=1\"
)

    </pre>";

require '../modulos/corpo.php';

?>