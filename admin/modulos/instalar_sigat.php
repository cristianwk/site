<?

    $pg['titulo'] = 'Instalar Sigat';
    $pg['colspan'] = '1';

    $pg['topico'][] = 'wget apt-get source list';
    $pg['texto'][] = "<pre>
<b>wget</b>

linux:~# vim /etc/wgetrc

http_proxy = http://aptget:dudu@10.193.4.253:3128 

<b>apt-get</b>

linux:~# vim /etc/apt/apt.conf

Acquire::http::proxy \"http://aptget:dudu@10.193.4.253:3128\";

<b>Source list</b>

linux:~# vim /etc/apt/sources.list // editar o arquivo source.list 

# deb cdrom: ... // comentar a linha de cdrom
adicione as seguintes linhas
deb http://ftp.br.debian.org/debian/ etch main
deb-src http://ftp.br.debian.org/debian/ etch main
</pre>";

    $pg['topico'][] = 'Pacotes Sigat';
    $pg['texto'][] = "<pre>

<b>Pacotes necess�rios</b>

apt-get -y install ssh
apt-get -y install nmap
apt-get -y install apache2
apt-get -y install php5
apt-get -y install mysql-server 
apt-get -y install php5-mysql
apt-get -y install php5-ldap
apt-get -y install php-fpdf
apt-get -y install openssl
apt-get -y install ssl-cert
apt-get -y install rsync
apt-get -y install sendemail
apt-get -y install ntpdate
apt-get -y install php5-gd
</pre>";

    $pg['topico'][] = 'Fixar IP';
    $pg['texto'][] = "<pre>
<b>Fixar IP</b>

linux:~# vi /etc/network/interfaces -- configuration file for ifup(8), ifdown(8)

# The loopback interface
# automatically added when upgrading
auto lo eth0
iface lo inet loopback
iface eth0 inet static
address 10.193.4.109
netmask 255.255.255.0
network 10.193.x.0
broadcast 10.193.x.255
gateway 10.193.x.254

<b>Configurar o dns</b>

linux:~# vi /etc/resolv.conf

#search cb.sc.gov.br
#nameserver 10.193.4.5
nameserver 4.2.2.2

<b>Reiniciar configura��es de rede</b>
linux:~# /etc/init.d/networking restart 
</pre>";

    $pg['topico'][] = 'Configura&ccedil;&atilde;o do Apache';
    $pg['texto'][] = "<pre>
<b>Configura��es do Apache</b>

linux:~# vi /etc/apache2/apache2.conf

AddDefaultCharset ISO-8859-1 // descomentar ou adicionar a linha

linux:~# vi /etc/apache2/sites-available/default 
e
linux:~# /etc/apache2/sites-available/ssl

Options Indexes FollowSymLinks MultiViews // retirar o Indexes
RedirectMatch ^/$ /sigat/ // Passar o diret�rio padr�o para sigat

</pre>";

    $pg['topico'][] = 'Configura&ccedil;&atilde;o Mysql';
    $pg['texto'][] = "<pre>
<b>Corrigir o aquivo de usu&aacute;rio do debian para o MySQL</b>

linux:~# vi /etc/mysql/debian.cnf

user = usuario
password = senha

linux:~# vi /etc/mysql/my.cnf

# bind-address = 127.0.0.1 // comentar esta linha para aceitar conex�o remota

<b>Banco de Dados</b>

linux:~# mysqldump -u usuario -p --all-databases > arquivo_backup.sql // backup
linux:~# mysql -u usuario -p < arquivo_backup.sql // importar dados

<b>Reiniciar o SGBD</b>

linux:~# /etc/init.d/mysql restart
</pre>";

    $pg['topico'][] = 'Configura&ccedil;&atilde;o do PHP';
    $pg['texto'][] = "<pre>

<b>Configura��o do PHP</b>

linux:~# vi /etc/php5/apache2/php.ini

display_errors = Off // Dasabilitar mensagens de erros
include_path = \".:/home/bicudo/object_libs/\" // inserir arquivo de configura��o do Sigat
magic_quotes_gpc = Off // desabilitar inclus&atilde;o de caracteres especiais

<b>Reiniciar o servidor Apache</b>

linux:~# /etc/init.d/apache2 restart

</pre>";

    $pg['topico'][] = 'Configura&ccedil;&atilde;o SSL';
    $pg['texto'][] = "<pre>

<b>Configura��o do SSL</b>

linux:~# mkdir /etc/apache2/ssl
linux:~# make-ssl-cert /usr/share/ssl-cert/ssleay.cnf /etc/apache2/ssl/apache.pem

<b>Complete com os dados abaixo:</b>
----------------------------------------
BR
SC
Florianopolis // cidade do servidor
Corpo de Bombeiro Militar de Santa Catarina
Divisao de Tecnologia da Informacao DITI BMSC
10.193.4.109 // IP do servidor ( esse o mais importante )
----------------------------------------

linux:~# su -c 'echo Listen 443 >> /etc/apache2/ports.conf'
linux:~# a2enmod ssl
linux:~# cp /etc/apache2/sites-available/default /etc/apache2/sites-available/ssl

<b>Editar arquivo ssl</b>

linux:~# vim /etc/apache2/sites-available/ssl

NameVirtualHost *:443
&#60;VirtualHost *:443&#62;
ServerAdmin webmaster@localhost
SSLEngine On
SSLCertificateFile /etc/apache2/ssl/apache.pem
DocumentRoot /var/www/
 
<b>Executar na console</b>

linux:~# a2ensite ssl
linux:~# /etc/init.d/apache2 force-reload
</pre>";

    $pg['topico'][] = 'Configura��es Finais';
    $pg['texto'][] = "<pre>
<b>Mudar a senha do servidor</b>

linux:~# passwd

<b>Copiar pasta lib do Sigat</b>

linux:~# rsync -CravzpE root@homolog:/home/bicudo/object_libs/lib /home/bicudo/object_libs/lib

<b>Mudar permiss�o do arquivo de exclus�o do Sigat</b>

linux:~# chown www-data:www-data /home/sigat/excluidos.sigat

<b>Direcionar o Sigat para o banco de dados correto</b>

linux:~# vi /home/bicudo/object_libs/lib/conf/conf_bd.php 

define ('BD_HOST', 'maquina_onde_se_localiza_o_banco_do_sigat');

<b>Copiar arquivo hosts da m�quina de homologa��o</b>

linux:~# scp root@homolog:/etc/hosts /etc/
</pre>";

    $pg['topico'][] = 'Desabilitar Ldap';
    $pg['texto'][] = "<pre>
<b>root# vi /home/bicudo/object_libs/lib/conf/conf_sistema.php</b>

(Adicionar bloco de c�digo abaixo no conf_sistema.php)

/**
*  E obrigatorio usar LDAP para acessar o sistema?
*/
define ('CONF_REQUIRE_LDAP', true);

<b>root# vi /home/bicudo/object_libs/lib/misc/sigat.php</b>

(Alterar a a fun��o checkldapuser para retornar true se CONF_REQUIRE_LDAP for false)

	if (CONF_REQUIRE_LDAP) {
	
		global \$erro_ldap;
		\$erro_ldap=\"\";
		
		... 
		&#60; c�digo completo do validador LDAP &#62;
		...
		
		@ldap_close(\$connect);
		return(false);
	
	} else {
	
		return true;
	
	}

<b>root# vi /home/bicudo/object_libs/lib/class/class_sessao_sigat.php</b>

function authenticate (\$userlogin, \$passwd, \$rotina)
function get_id_by_login (\$str_login, \$str_pass)

	if (CONF_REQUIRE_LDAP) {

		$sql = \"SELECT ID_USUARIO,ID_PERFIL FROM \".TBL_USUARIO.\" WHERE ID_USUARIO = '$str_login'\";
	
	} else {
	
		$sql = \"SELECT ID_USUARIO,ID_PERFIL FROM \".TBL_USUARIOS.\" WHERE 
		ID_USUARIO = '$str_login' AND PS_SENHA='\".md5($str_pass).\"'\";
	
	}

<b>root# vi /var/www/sigat/modulos/acessos/usuario.php</b>

(Alterar o arquivo para que o campo Senha e Confirme esteja habilitado)

<b>root# vi /var/www/sigat/modulos/acessos/cons_usuario.php</b>
//  frm_cons.psw_ps_senha.disabled=true;
//  frm_cons.psw_ps_senha_confirma.disabled=true;

<b> Arquivos afetados </b>

rsync -CravzpE /home/cbmsc/bibliotecas/lib/conf/conf_sistema.php root@10.193.4.53:/home/bicudo/object_libs/lib/conf/conf_sistema.php
rsync -CravzpE /home/cbmsc/bibliotecas/lib/misc/sigat.php root@10.193.4.53:/home/bicudo/object_libs/lib/misc/sigat.php
rsync -CravzpE /home/cbmsc/bibliotecas/lib/class/class_sessao_sigat.php root@10.193.4.53:/home/bicudo/object_libs/lib/class/class_sessao_sigat.php
rsync -CravzpE /var/www/sigat/modulos/acessos/cons_usuario.php root@10.193.4.53:/var/www/sigat/modulos/acessos/cons_usuario.php
rsync -CravzpE /var/www/sigat/modulos/acessos/usuario.php root@10.193.4.53:/var/www/sigat/modulos/acessos/usuario.php


</pre>";


    $pg['topico'][] = 'CheckList de Instala��o de Servidores SIGAT e E193';
    $pg['texto'][] = "<pre>

1 AP�S INSTALA��O RECOMENDA-SE TESTES. PARA ISSO DEIXAR O SERVIDOR PELO MENOS UMA SEMANA EM OBSERVA��O NA BANCADA.
2 DEVE-SE REALIZAR TESTES DE INSER��O DE SOLICITA��ES PARA TODOS OS TIPOS (PROJETO, MANUTEN��O, FUNCIONAMENTO, HABITE-SE) NO NOVO SERVIDOR A T�TULO DE TESTE!
3 PARA CADA TESTE VERIFICAR NO PHPMYADMIM SE OS MESMO FORAM INSERIDOS COM SUCESSO. VER BANCO SOLICITA��ES. PARA ACHAR AS ULTIMAS INSER��ES BASTA ORDENAR AS 
CHAVES PRIMARIA EM ORDEM DECRESCENTE. PARA CADA TIPO DE SOLICITA��O REPETIR O PROCESSO.
4 NO SISTEMA APROVAR AS SOLICITA��ES PARA SEREM PROTOCOLANDAS E DEVE-SE REALIZAR OS MESMOS TESTE DO ITEM 3. VER NO PHPMYADMIM AS TABELAS DE PROTOCOLAMENTO 
DE CADA TIPO DE SOLICITA��O.
5 FAZER O MESMO DO ITEM 4 PARA VISTORIAS DEFERIDAS. VER TABELAS DE VISTORIAS DE CADA TIPO DE SOLICITA��O.
6 AP�S ESSES TESTES, DEVE-SE REALIZAR NOVO DUMP DO BANCO DE DADOS \"QUENTE\" DO SERVIDOR QUE SER� TROCADO E LEVANTA-LO NO MYSQL. DEVE-SE REALIZAR OS TESTE DE 
COMPARA��O DOS DADOS. COLOCANDO A P�GINA DE VISUALIZA��O DE BUCKUPS A FUNCIONAR PARA COMPARA��O REAL DOS BANCOS! ESSA TELA � IMPORTANTE E N�O DEVER FICAR 
FORA DE OPERA��O EM NENHUM SERVIDOR ATIVO.
7 PARA N�O TER SURPRESAS DE FALTA DE DADOS NO BANCO DE DADOS, TODOS OS UPLOADS NO MYSQL DE BANCO DE DADOS \"QUENTES\" DEVE CONTER O BANCO DE DADOS REAL. OU 
SEJA, FAZER O MYSQLDUMP DO SERVIDOR QUE SER� TROCADO E LEVANTADO NO NOVO SERVIDOR. N�O SE DEVE USAR QUALQUER BANCO MAIS!S� PARA INSTALA��O E CONFIGURA��O 
DO SIGAT N�O SE DEVE USAR QUALQUER OUTRO BANCO QUE N�O SEJA O DO SERVIDOR A SER TROCADO!EXEMPLO: O NOVO SERVIDOR DE FLORIAN�POLIS (TDE1) DEVER� TER O 
MESMO BANCO DE DADOS DE TDE1 DO DIA. AO LEVARTAR O BANCO NO NOVO SERVIDOR O DUMP TEM QUE SER O DO DIA.

LINUX:~# MYSQLDUMP -U USUARIO -P --ALL-DATABASES > ARQUIVO_BACKUP.SQL // BACKUP
LINUX:~# MYSQL -U USUARIO -P < ARQUIVO_BACKUP.SQL // IMPORTAR DADOS

8 NA INSTALA��O RETIRAR DO AR O LINK DE ACESSO AO SISTEMA. \"O SISTEMA EST� EM MANUTEN��O\" E POR ISSO NIGU�M USA AT� SUA LIBERA��O TOTAL.
9 AP�S A M�QUINA SERVIDORA SER ATIVADA DE FATO NA CIDADE , DEVE-SE SOLICITAR AOS USU�RIOS DO SISTEMA - OS BOMBEIROS - QUE AVALIEM OS DADOS E QUE FA�AM UM 
CHEK DAS INFORMA��ES J� INSERIDAS NO SISTEMA.
10 RECOMENDA-SE N�O LIBERAR O LINK DO SERVIDOR PARA FUNCIONAMENTO SEM QUE SE TENHA CERTEZA DE SUA PLENA INTEGRIDADE E O AVAL DOS BMS QUE USAM O SISTEMA. 
11 AP�S A LIBERA��O DADOS NOVOS SER�O INSERIDOS E SUA MANUTEN��O CASO APRESENTE PROBLEMAS REQUER CUIDADOS ESPECIALIZADOS. POR ISSO O SERVIDOR DEVER� SE 
MONITORADO CONSTANTEMENTE.

N�O H� MANEIRA DE IDENTIFICAR PROBLEMAS NO SIGAT OU MYSQL SE N�O FOR POR TESTE HUMANO. AINDA N�O H� UM SCRIPT DE VERIFICA��O DE INTEGRIDADE DO BANCO DE 
DOIS BANCOS PARA O SIGAT. O MESMO PARA O E193. ENT�O M�OS A OBRA. A VERIFICA��O � HUMANA! 

1 SEMANA DE MONITORA��O NA BANCADA
2 TESTES DE INSER��O
3 VALIDA��O NO PHPMYADMIN
4 REALIZAR MYSQLDUMP QUENTE DO SQL DO SERVIDOR A SER SUBSTITUIDO.
5 NA SUBSTITUI��O S� LIBERAR O LINK QUANDO TODAS AS DIRETRIZES FOREM EFETIVADAS.
6 OBSERVA��O � O PONTO CRUCIAL PARA ACHAR ERROS. E USU�RIOS S�O ESPECIALISTAS NISSO. SOLICITEM VERIFICA��O E TESTE DOS USU�RIOS DA \"PONTA\".
</pre>";

require './modulos/corpo.php';
?>