<?php

	$nome = $_POST['nome'];
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];
	$empresa = $_POST['empresa'];			
	$data = $_POST['data'];	

	if ( empty($nome) )
	{
		echo "<script>alert('Você não digitou NOME no formulário'); history.go(-1);</script>";
		exit;
	}
	
	if ( empty($telefone) )
	{
		echo "<script>alert('Você não digitou TELEFONE no formulário'); history.go(-1);</script>";
		exit;
	}		
	
	if ( empty($email) )
	{
		echo "<script>alert('Você não digitou E-MAIL no formulário'); history.go(-1);</script>";
		exit;
	}

	if ( empty($info) )
	{
		echo "<script>alert('Você não digitou INFO no formulário'); history.go(-1);</script>";
		exit;
	}

	$to = "cristian@consultoriawk.com";
		
	$headers = "From: $email \n";
	$headers .= "X-Mailer: Contatos para a WK Consultoria\n";

	$hoje = date("Y-m-d"); 
	$hora = date("H:i:s");

	$subject = "[$hoje] - [$hora] : Suporte Técnico";

	$msg  = "[$hoje] - [$hora] : Suporte Técnico";
	$msg .= $nome . "\n";
	$msg .= $email . "\n";
	$msg .= $telefone . "\n";	
	$msg .= $empresa . "\n";
	$msg .= $data . "\n";	
	$msg .= $info . "\n";	

	//mail($to, $subject, $msg, $headers);
	mail($to, $subject, $msg, $headers);
		
	mail($email, $subject, $msg, $headers);

	header("location:http://www.consultoriawk.com");
	exit;

?> 

