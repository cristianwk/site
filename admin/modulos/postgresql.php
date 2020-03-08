<?

    $pg['titulo'] = 'PHP';
    $pg['colspan'] = '1';

    $pg['topico'][] = '';
    $pg['texto'][] = '<pre>
	</pre>';

    $pg['topico'][] = 'PostgreSQL 8.4 com codifica��o LATIN1';
    $pg['texto'][] = '<pre>
PostgreSQL com encoding LATIN1

Testado no ubuntu

1� PASSO - Instalar o postgresql-8.4

# apt-get install postgresql-8.4

2� PASSO - Apagar todo o conteudo do diret�rio "/var/lib/postgresql/8.4/main"

# rm -rf /var/lib/postgresql/8.4/main/*

3� PASSO - Fa�a o login com o usu�rio postgres

# su - postgres

4� PASSO - Gerar o novo conteudo do diret�rio "/var/lib/postgresql/8.4/main" com a codifica��o LATIN1

$ /usr/lib/postgresql/8.4/bin/initdb --pgdata=/var/lib/postgresql/8.4/main/ --encoding=LATIN1 --locale=C --username=postgres -W

Obs: vai pedir uma senha para o super-usuario do banco. Digite \'postgres\'.

5� PASSO - Saia do usuario \'postgres\' e crie os links simbolicos

$ exit

# ln -s /etc/postgresql-common/root.crt /var/lib/postgresql/8.4/main/root.crt
# ln -s /etc/ssl/certs/ssl-cert-snakeoil.pem /var/lib/postgresql/8.4/main/server.crt
# ln -s /etc/ssl/private/ssl-cert-snakeoil.key /var/lib/postgresql/8.4/main/server.key

6� PASSO - Reiniciar a maquina

# reboot;
</pre>';

require './modulos/corpo.php';

?>