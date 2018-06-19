<?php 

	function conecta()
	{
		try 
		{
			if (session_id() == '')
				session_start();
					
			$banco = $_SESSION['banco'];
			//$conexao = new PDO("sqlsrv:Server=DESKTOP-J469J8O\SQLEXPRESS;Database=ultra215", "sa", "2688root");
			$conexao = new PDO("mysql:host=localhost;dbname=$banco", "root", "2688root") or die("Nao conectou");
			if (BANCO == "2")
				$conexao->setAttribute(PDO::SQLSRV_ATTR_ENCODING,PDO::SQLSRV_ENCODING_SYSTEM );
			return $conexao;
		}
		catch (PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	function fetch($result)
	{
		if (!is_null($result) && (!empty($result)))
			return $result->fetch(PDO::FETCH_ASSOC);
		else return 0;
	}
	
	function fetchArray($result)
	{
		if (!is_null($result) && (!empty($result)))
			return $result->fetch(PDO::FETCH_BOTH);
		else return 0;
	}
	
	function num_rows($result)
	{
		if (!is_null($result) && (!empty($result)))
			return $result->rowCount();
		else return 0;
	}

	function queryInsert($sql)
	{
		if (!is_null($sql) && (!empty($sql)))
		{
			try{
				$conexao = conecta();
				$stmt = $conexao->prepare($sql);
				$stmt->execute(); // = $conexao->query($sql);
				$erro = $stmt->errorInfo();
				if (!empty($erro[1])) {
					geraLog('ERRO COMANDO -> ERROR ' .$erro[1] . ' - ('.$erro[0].')'. ' :' . $erro[2]);
					return false;
				}
				$id = $conexao->lastInsertId();
				return $id;
			}
			catch ( PDOException $error_query )
			{
				geraLog('Erro Comando =>' . date( 'd/m/Y H:i:s' ) . '(' . $error_query->getCode() . '): ' . $error_query->getMessage(). ' | SQL -> ' . $sql);
				return false;
			}
				
		}
		else return null;
	}
	
	
	function querySelect($sql)
	{
		if (!is_null($sql) && (!empty($sql)))
		{
			try {
				$conexao = conecta();
				$stmt = $conexao->prepare($sql);
				$stmt->execute();// = $conexao->query($sql);
				$erro = $stmt->errorInfo();
				if (!empty($erro[1])) {
					geraLog('ERRO COMANDO -> ERROR ' .$erro[1] . ' - ('.$erro[0].')'. ' :' . $erro[2]);
					return false;
				}
				return $stmt;
			}
			catch ( PDOException $error_query )
			{
				geraLog('Erro Comando =>' . date( 'd/m/Y H:i:s' ) . '(' . $error_query->getCode() . '): ' . $error_query->getMessage(). ' | SQL -> ' . $sql);
				return false;
			}
		}
		else return null;
		
	}
	
	function fetch_object($result)
	{
		if (!is_null($result) && (!empty($result)))
			return $result->fetch(PDO::FETCH_OBJ);
		else return 0;
	}
	
	function affected_rows($result)
	{
		if (!is_null($result) && (!empty($result)))
			return $result->rowCount();
		else return 0;
	}
	
	function validaParametros($parametros)
	{
		$conexao = conecta();
		for ($i = 0; $i < sizeof($parametros); $i++)
			$novoParametros[$i] = verificaValor($parametros[$i]);
			
		return $novoParametros;
	}
	
	function funcaoData($campo)
	{
		if (BANCO == "1")
			$result =  "date(" . $campo . ")";
		else $result = "convert(date," . $campo . ")";
		return $result;
	}
		
	function funcaoMd5($valor)
	{
		if (BANCO == "1")
			$string = "md5('" . $valor . "')";
		else $string = "CONVERT(NVARCHAR(32),HashBytes('MD5', '" . $valor . "'),2)";
			return $string;
	}
	
	function funcaoLen($valor)
	{
		if (BANCO == "1")
			$string = "LENGTH(" . $valor . ")";
		else $string = "LEN(" . $valor . ")";
			return $string;
	}
	
	function funcaoADDDATE($dias, $data)
	{
		if (BANCO == "1")
			$string = "ADDDATE(" . $data . "," . $dias . ")";
		else $string = "DATEADD(day, " . $dias . "," . $data . ")";
		return $string;
	}
	
	function funcaoADDDATE_Minutos($minutos, $data)
	{
		if (BANCO == "1")
			$string = "ADDDATE(" . $data . ", INTERVAL " . $minutos . " MINUTE)";
		else $string = "DATEADD(minute, " . $minutos . "," . $data . ")";
		return $string;
	}
	
	function validaHost($acao)
 	{
		// As requisicoes por http não reconhecida, estão bloqueados no apache
		// Se $_SERVER['HTTP_CONNECTION'] == close, entao tem uma requisicao por form via ajax
		
		$close = $_SERVER['HTTP_CONNECTION'];
 		if ($_SERVER['REMOTE_ADDR'] != '187.45.123.98' AND strtoupper($close) == 'CLOSE')
 		{
			@session_start();
			geraLog("Tentativa de Invasão -> IP =>".$_SERVER['REMOTE_ADDR']. ' - '.$close . ' - '. $_SERVER['REQUEST_URI']);
 			require "emailMailer.php";
 			$envia = new email();
 			$to = 'juliocezar@ultralims.com.br';
 			$texto = 'Ultra: Texto ->' . $_SERVER['REMOTE_ADDR']. ' - '.$_SERVER['HTTP_CONNECTION'] . ' - '.$_SERVER['REQUEST_URI'] . ' - Usuario:' . $_SESSION['login_Usuario'] . ' - IP:'.$_SESSION['ip']. ' - ACTION=>'.$acao . ' - Empresa:' . $_SESSION['Empresa_Usuario'];
 			$copia = 'marjorymuller@ultralims.com.br';
 			$copiaOculta = '';
 			$assunto =  'Tentativa de Invasão';
 				
 			$caminho = NULL;
 			$arquivo = NULL;
 			$outrosArquivos = NULL;
 			$envia->send('Ultra LIMS','juliocezar@ultralims.com.br',$to,$caminho,$arquivo,$assunto,$texto,$copia,$copiaOculta,$outrosArquivos);
 			// Invalidar Usuário;
 			if ((isset($_SESSION['login_Usuario'])) && ($_SESSION['login_Usuario'] != ''))
 			{
	 			$sql = 'UPDATE usuario SET dataValidade = "2016-01-01" WHERE idUsuario ='.$_SESSION['login_Usuario'];
	 			querySelect($sql);
 			}
 			echo 'IDENTIFICADA TENTATIVA DE INVASÃO!!! USUÁRIO ESTÁ SENDO EXPURGADO! HOST Original:'.$_SESSION['login_Usuario'] . ' - '.$_SERVER['REMOTE_ADDR']. ' - '.$_SERVER['REQUEST_URI'] . ' - ' . $_SERVER['HTTP_CONNECTION']. '<Br><br>';
 			unset($_SESSION['empresa_Usuario'], $_SESSION['nome_Usuario'], $_SESSION['ai_MenuPerfil'], $_SESSION['login_Usuario']);
 			exit('Tentativa de Invasão - Bloqueado - E-mail enviado!');
			
			
 		}
 	}
 	
 	function verificaValor($valor)
	{
		$m = @strtoupper($valor);
		$select = strripos($m, 'SELECT ');
		$update = strripos($m, 'UPDATE ');
		$delete = strripos($m, 'DELETE ');
		$innerjoin = strripos($m, 'INNER JOIN');
		$outerjoin = strripos($m, 'OUTER JOIN');
		//$union = strripos($m,'UNION '); retirado tambem do if Marjory 29/12/2016
		$drop = strripos($m,'DROP ');
		if (($select == false) && ($update == false) && ($delete == false) && ($innerjoin == false) && ($outerjoin == false) && ($drop == false))
		{
			if (is_numeric($valor))
			{
				return $valor;
			}
				
			if (is_string($valor))
			{
				if ($valor=="%%")
					return 'NULL';
			}
			else
				if (empty($valor) or is_null($valor) or !isset($valor) or ($valor=="%%") or ($valor == "undefined"))
					return 'NULL';
			return $valor;
		}
		else {
			geraLog("Tentativa de Invasão Verificar Valor->" . $valor . ' - Usuario:' . $_SESSION['nome_Usuario']);
			require "emailMailer.php";
			$envia = new email();
			$to = 'juliocezar@ultralims.com.br';
			$texto = 'Texto ->' . $valor . ' - Usuario:' . $_SESSION['nome_Usuario'] . ' - IP:'.$_SESSION['ip'];
			$copia = 'marjorymuller@ultralims.com.br';
			$copiaOculta = '';
			$assunto =  'Tentativa de Invasão';
				
			$caminho = NULL;
			$arquivo = NULL;
			$outrosArquivos = NULL;
			echo $envia->send('Ultra LIMS','juliocezar@ultralims.com.br',$to,$caminho,$arquivo,$assunto,$texto,$copia,$copiaOculta,$outrosArquivos);
			// Invalidar Usuário;
			$sql = 'UPDATE usuario SET dataValidade = "2016-01-01" WHERE idUsuario ='.$_SESSION['login_Usuario'];
			querySelect($sql);
				
			unset($_SESSION['empresa_Usuario'], $_SESSION['nome_Usuario'], $_SESSION['ai_MenuPerfil'], $_SESSION['login_Usuario']);
			echo 'IDENTIFICADA TENTATIVA DE INVASÃO!!! USUÁRIO ESTÁ SENDO EXPURGADO!';
	
			//return 'NULL';
				
		}
	}
	
	function msgBox($msg)
	{
		//$msg = utf8_encode($msg);
		// Simple alert window
		?>
				
		<script type="text/javascript"> 
			alert("<?php echo $msg; ?>"); 
		</script>
		<?php
	}
	
/*	
	function msgBox($tipo,$msg)
	{
		$class = 'messageBox primary';
		if ($tipo == 'alerta')
			$class = 'messageBox primary';
		elseif ($tipo == 'erro')
			$class = 'messageBox warning';
		elseif ($tipo == 'sucesso')
			$class = 'messageBox success';
		
		echo '
			  <div class="fade" id="fade"></div>
				<script src="../../infra/treeview/js/jquery.min.js"></script>
				<div id="msgBox" class="'.$class.'">
					<div class="alert-close">Ã—</div>
					<script>
					  	$(document).ready(function(c) {
							$(".alert-close").on("click", function(c){
								$(this).parent().fadeOut("slow", function(c){
							    	document.getElementById("fade").style.display = "none";
								});
							});	
						});
	  				</script>
						
					<br>'.$msg.'
					
				</div>			
				
			<script>
	    	document.getElementById("fade").style.display = "block";
	    	</script>
				';	
	}
	*/
		
	function somaDiasData($data,$dias)
	// YYYY-MM-DD
	{
	 	$data = str_replace("-","",$data);
	 	$ano = substr ( $data, 0, 4 );
	 	$mes = substr ( $data, 4, 2 );
	 	$dia = substr ( $data, 6, 2 );
	 	$diaSomado = $dia + $dias;
	 	$novaData = @mktime ( 0, 0, 0, $mes, $diaSomado, $ano );
	 	$novaDataComoData = strftime("%Y-%m-%d", $novaData);
	 	return $novaDataComoData;
 	}
 	
	function somaMesesData($data,$meses)
	// YYYY-MM-DD
	{
	 	$data = str_replace("-","",$data);
	 	$ano = substr ( $data, 0, 4 );
	 	$mes = substr ( $data, 4, 2 );
	 	$dia = substr ( $data, 6, 2 );
	 	$mesSomado = $mes + $meses;
	 	if ($mesSomado > 12)
	 	{ 
	 		$mesSomado = $mesSomado - 12;
	 		$ano++;
	 	}
	 	$novaData = @mktime ( 0, 0, 0, $mesSomado, $dia, $ano );
	 	//msgBox($data . " - meses " . $meses . " - mesSomado" . $mesSomado . "- mes" . $mes . "- dia" . $dia . "- ano" . $ano . " - novaData " . strftime("%Y-%m-%d", $novaData));
	 	return strftime("%Y-%m-%d", $novaData);
 	}
 	
 	function subtraiDiasData($data,$dias)
 	// YYYY-MM-DD
 	{
 		$data = str_replace("-","",$data);
 		$ano = substr ( $data, 0, 4 );
 		$mes = substr ( $data, 4, 2 );
 		$dia = substr ( $data, 6, 2 );
 		$novaData = mktime ( 0, 0, 0, $mes, $dia - $dias, $ano );
 		return strftime("%Y-%m-%d", $novaData);
 	}
 	
 	function subtraiDuasDatas($sDataInicial,$sDataFinal)
 	// YYYY-MM-DD
 	{
     	$anoI = substr ( $sDataInicial, 0, 4 );
 	    $mesI = substr ( $sDataInicial, 5, 2 );
 		$diaI = substr ( $sDataInicial, 8, 2 );
     	$anoF = substr ( $sDataFinal, 0, 4 );
 	    $mesF = substr ( $sDataFinal, 5, 2 );
 		$diaF = substr ( $sDataFinal, 8, 2 );
 		//echo "<br>", " Como chegou a data no Gerente.php ", $sDataInicial, " Ano ", $anoI, " Mes ", $mesI, " Dia ", $diaI, "<br>";
 		//echo "<br>", " Como chegou a data no Gerente.php ", $sDataFinal, " Ano ", $anoF, " Mes ", $mesF, " Dia ", $diaF, "<br>";
 		$nDataInicial = mktime(0, 0, 0, $mesI, $diaI, $anoI);  
	  	$nDataFinal = mktime(0, 0, 0, $mesF, $diaF, $anoF);  
	  	//echo "data mktime ", $nDataInicial, " Data final ", $nDataFinal;
	  	return ($nDataInicial > $nDataFinal) ? floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400); 	
 	}
 	
 	function formataMoeda($valor)
 	{
 		$retorno = 'R$ ' . number_format($valor, 2, ',', '.');
 		return $retorno;
 	}
 	
 	function formataInteiro($valor)
 	{
 		$retorno = number_format($valor, 0, ',', '.');
 		return $retorno;
 	}
 	
 	function geraLog($mensagem)
 	{
 		if (isset($_SESSION['geraLog']) and ($_SESSION['geraLog']))
 		{
 			try
 			{
 				$novaMensagemReduzida = substr($mensagem, 0, 80);
 				
 				if (isset($_SESSION['ip']) AND $_SESSION['ip'])
 					$mensagem = $_SESSION['ip'] . " - " . $mensagem;
 				
				if (isset($_SESSION['empresa_Usuario']))
 					$empresa = $_SESSION['empresa_Usuario'];
 				else 
 					$empresa = '1';
 				
 				if (isset($_SESSION['login_Usuario']))
 					$usuario = $_SESSION['login_Usuario'];
 				else 
 					$usuario = 'naoDefinido';
	 			$nomeLog = PATH_EMPRESA . "/" . $empresa . "/log/Log"  . '_' . date('Ymd') . $usuario . '.txt';
	 			$file = fopen($nomeLog  ,"a+");
	 			fwrite($file,date("d-m-Y H:i:s") . ': ' . $mensagem . "\r\n");
	 			fclose($file);
 				
	 			/*
 				if (substr($novaMensagemReduzida,0,10) == 'Dentro do ')
 				{
 					$novaMensagemReduzida = substr($novaMensagemReduzida, 10, 80);
		 			$dataHoje = date('Y-m-d H:i:s');
	  				require_once PATH_APP . '/model/impl/logAcessoImpl.php';
	 				$impl = new logAcesso();
	 				$ai_LogAcesso = $impl->insereLog($_SESSION['empresa_Usuario'], $_SESSION['ai_EstabelecimentoUsuario'], $dataHoje, $_SESSION['ai_Usuario'], $novaMensagemReduzida, $_SESSION['ip'], $novaMensagemReduzida);
 				}
 				*/
 			}
 			catch (Exception $e)
 			{
 				echo 'Ocorreu um erro ao tentar criar o Log. Verifique espaço em disco ou permissão. Erro-> ' . $e->getMessage() ;
 			}
 		}
 		else {
 			$novaMensagemReduzida = substr($mensagem, 0, 80);
 				
 			if (isset($_SESSION['ip']) AND $_SESSION['ip'])
 				$mensagem = $_SESSION['ip'] . " - " . $mensagem;
 			
 			$nomeLog = PATH_EMPRESA . "/log/Log"  . '_' . date('Ymd') . '_AcessoNaoPermitido.txt';
 			$file = fopen($nomeLog  ,"a+");
 			fwrite($file,date("d-m-Y H:i:s") . ': ' . $mensagem . "\r\n");
 			fclose($file);
 		}
 	}
 	
 	function limpaBrowserCache() 
 	{
	    
		// Data no passado
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		
		// Sempre modificado
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		
		// HTTP/1.1
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		
		// HTTP/1.0
		header("Pragma: no-cache");
	}
	
	function validaUsuario()
	{
		if (session_id() == "")
			session_start();
		if (!isset($_SESSION['empresa_Usuario']) or (is_null($_SESSION['empresa_Usuario'])))
		{
			geraLog("Usuário não está logado! Processo Abortado.");
			msgBox("Usuário não está logado! Processo Abortado.");
			$_SESSION['erro'] = 6;
			header('Location:../../public/'.$_SESSION['login']);
		}
		else
		{
			$dataHoje = date('Y-m-d H:i:s');
			if ($_SESSION['dataValidadeUsuario'] <= $dataHoje)
			{
				msgBox("A data de validade expirou para este usuário. Entre em contato com o Administrador.");
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	/*
	function formataValor($valor, $casas=NULL)
	{
		if (!empty($valor) and is_numeric($valor))
		{
			$pos = strpos($valor,".");
			$tam = strlen($valor);
			$decimal = explode(".",$valor);
			
			if ($casas == NULL)
			{
				$casas = $tam - ($pos+1);
				if (substr ( $decimal[1], 5, 1 ) == '0')
				{
					$casas = $casas - 1;
					if (substr ( $decimal[1], 4, 1 ) == '0')
					{
						$casas = $casas - 1;
						if (substr ( $decimal[1], 3, 1 ) == '0')
						{
							$casas = $casas - 1;
							if (substr ( $decimal[1], 2, 1 ) == '0')
							{
								$casas = $casas - 1;	
								if (substr ( $decimal[1], 1, 1 ) == '0')
								{
									$casas = $casas - 1;	
								}
							}
						}
					}
				}
			}
			$valorConvertido = number_format($valor,$casas,'.',''); 
			return $valorConvertido;
		}
		else return "0,00";
	}
	*/
	
	function formataValor($valor, $casas=NULL)
	{
		if (is_numeric($valor)) {
			$pos = strpos($valor,".");
			$tam = strlen($valor);
			if (is_null($casas))
				$casas = strlen(substr($valor, $pos+1, strlen($valor)));
			
			$decimal = explode(".",$valor);
			$valorConvertido = number_format($valor,$casas,'.','');
			return $valorConvertido;
		}
		else return $valor;
	}
	
	function formataValorRelatorio($valor, $casas=NULL)
	{
		if (!empty($valor))
		{
			$pos = strpos($valor,".");
			$tam = strlen($valor);
			$decimal = explode(".",$valor);
			
			if ($casas == NULL)
			{
				$casas = $tam - ($pos+1);
				if (substr ( $decimal[1], 5, 1 ) == '0')
				{
					$casas = $casas - 1;
					if (substr ( $decimal[1], 4, 1 ) == '0')
					{
						$casas = $casas - 1;
						if (substr ( $decimal[1], 3, 1 ) == '0')
						{
							$casas = $casas - 1;
							if (substr ( $decimal[1], 2, 1 ) == '0')
							{
								$casas = $casas - 1;	
								if (substr ( $decimal[1], 1, 1 ) == '0')
								{
									$casas = $casas - 1;	
								}
							}
						}
					}
				}
			}
			$valorConvertido = number_format($valor,$casas,',','.'); // inverti o ponto e a virgula por causa da obrigatoriedade de clicar no campo, senão ele salva sem os decimais
			return $valorConvertido;
		}
		else return "0,00";
	}
	
	function numeroInteiro($number,$n) 
	{
		// serve pra colocar zeros e deixar o formato do mesmo tamanho, ex: empresa= 1 fica 0001
 		return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
 	}

	function diaSemana($data)
	{  // Traz o dia da semana para qualquer data informada
		$data = converteSoDataTela($data);
		
		$dia =  substr($data,0,2);
		$mes =  substr($data,3,2);
		$ano =  substr($data,6,9);
		$diaSemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		switch($diaSemana)
		{  
			case "0": $diaSemana = "Domingo"; break;  
			case "1": $diaSemana = "Segunda-Feira"; break;  
			case "2": $diaSemana = "Terça-Feira"; break;  
			case "3": $diaSemana = "Quarta-Feira"; break;  
			case "4": $diaSemana = "Quinta-Feira"; break;  
			case "5": $diaSemana = "Sexta-Feira"; break;  
			case "6": $diaSemana = "Sabado"; break;  
		}                
		return $diaSemana;
	}
	
	function formataHora($hora)
	{
		if (BANCO == "2")
		{
			return substr($hora,0,5);
		}
		else 
			return $hora;
	}
	
	function valida_ldap($srv, $usr, $dom, $pwd)
	{
	    $ldap_server = $srv;
	    $auth_user = $usr;
	    $auth_pass = $pwd;
		
	    // Tenta se conectar com o servidor
		
		//$auth_user = $dom . $usr;
		//echo $auth_user . '<br>';
	     if (!($connect = @ldap_connect($ldap_server)))
		 {
	        return FALSE;
		 }
	     elseif (!($bind = @ldap_bind($connect, $auth_user, $auth_pass))) 
	     {
	         // se nao validar retorna false
	         return FALSE;
		 }
		 else 
		 {
	         // se validar retorna true
	         return TRUE;
	     }
	 
	} // fim funcao conectar ldap
	
	function escapaAspas($str)
	{
		$pos = 0;
		$novo = '';
		$pos = strpos($str, '"');
		$total = strlen($str);
		while ($pos > 0)
		{
			$novo .= substr($str, 0, $pos) . '|' . '';
			$str = substr($str,$pos+1,$total);
			$pos = strpos($str, '"');
		}
		if (strlen($str) > 0)
			$novo .= $str;
		return $novo;
	}	
	
	function retiraQuebra($texto)
	{
		$tam = strlen($texto);
		$i = 0;
		while ($i <= $tam)
		{
			if ((ord(substr($texto, $i)) == 13) or 
				(ord(substr($texto, $i)) == 10))
			{
				if ($i == 0)
				{
					$textoNovo = substr($texto, $i+1, $tam-1);
					$i--;
				}
				else
				{ 
					$textoNovo = substr($texto, 0, $i);
					$textoNovo .= substr($texto, $i+1, $tam-1);
					$tam--;
				}
				$texto = $textoNovo;
			}   
			$i++;
		}
		return $texto;
	}
	
	/*
	function textBox($texto)
	{
		// Colocar no cabecalho do HTML a chamada para os seguintes scripts
		//<script type="text/javascript" src="../../infra/textBox/html2xhtml.min.js"></script>
		//<script type="text/javascript" src="../../infra/textBox/richtext_compressed.js"></script>
		
		// Deve-se pegar no Control como $_POST['textBoxDesc']
		//$texto = '1,1-Dicloroeteno';
		
		$text = retiraQuebra($texto);
		$codigo= '<script type="text/javascript">
		      initRTE("../../infra/textBox/images/", "../../infra/textBox/", "", false);
		      var textBoxDesc = new richTextEditor(\'textBoxDesc\');
		      textBoxDesc.html =';
		$codigo .= '\''. $text .'\';
		    textBoxDesc.cmdFormatBlock = true;
		    textBoxDesc.cmdFontName = true;
			textBoxDesc.cmdFontSize = true;
			textBoxDesc.cmdIncreaseFontSize = true;
			textBoxDesc.cmdDecreaseFontSize = true;
			
			textBoxDesc.cmdBold = true;
			textBoxDesc.cmdItalic = true;
			textBoxDesc.cmdUnderline = true;
			textBoxDesc.cmdStrikethrough = true;
			textBoxDesc.cmdSuperscript = true;
			textBoxDesc.cmdSubscript = true;
			
			textBoxDesc.cmdJustifyLeft = true;
			textBoxDesc.cmdJustifyCenter = true;
			textBoxDesc.cmdJustifyRight = true;
			textBoxDesc.cmdJustifyFull = true;
			
			textBoxDesc.cmdInsertHorizontalRule = false;
			textBoxDesc.cmdInsertOrderedList = true;
			textBoxDesc.cmdInsertUnorderedList = true;
			
			textBoxDesc.cmdOutdent = true;
			textBoxDesc.cmdIndent = true;
			textBoxDesc.cmdForeColor = true;
			textBoxDesc.cmdHiliteColor = true;
			textBoxDesc.cmdInsertLink = false;
			textBoxDesc.cmdInsertImage = false;
			textBoxDesc.cmdInsertSpecialChars = false;
			textBoxDesc.cmdInsertTable = false;
			textBoxDesc.cmdSpellcheck = false;
			
			textBoxDesc.cmdCut = true;
			textBoxDesc.cmdCopy = true;
			textBoxDesc.cmdPaste = true;
			textBoxDesc.cmdUndo = true;
			textBoxDesc.cmdRedo = true;
			textBoxDesc.cmdRemoveFormat = true;
			textBoxDesc.cmdUnlink = false;
			
			textBoxDesc.toggleSrc = false;
			
			textBoxDesc.build();
		
		</script>';
		
		echo $codigo;
		
	}
	*/
	
	function exportaWord($html, $arquivo)
	{
		// HTML => Codigo HTML a ser exportado -- IMPORTANTE !!! ==> O codigo nao deve ter invocações de CSS ou Javascript
		// Arquivo => Nome do arquivo a ser gerado - arquivo.docx.
		
		require_once 'word/phpword/PHPWord.php';
		require_once 'word/simplehtmldom/simple_html_dom.php';
		require_once 'word/htmltodocx_converter/h2d_htmlconverter.php';
		require_once 'word/example_files/styles.inc';
		
		// Functions to support this example.
		require_once 'word/documentation/support_functions.inc';
		
		// New Word Document:
		$phpword_object = new PHPWord();
		$section = $phpword_object->createSection();
		
		// HTML Dom object:
		$html_dom = new simple_html_dom();
		$html_dom->load(utf8_encode($html)); //'<html><body>' . $html . '</body></html>');
		// Note, we needed to nest the html in a couple of dummy elements.
		
		// Create the dom array of elements which we are going to work on:
		$html_dom_array = $html_dom->find('html',0)->children();
		
		// We need this for setting base_root and base_path in the initial_state array
		// (below). We are using a function here (derived from Drupal) to create these
		// paths automatically - you may want to do something different in your
		// implementation. This function is in the included file
		// documentation/support_functions.inc.
		$paths = htmltodocx_paths();
		
		// Provide some initial settings:
		$initial_state = array(
				// Required parameters:
				'phpword_object' => &$phpword_object, // Must be passed by reference.
				// 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
				// 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
				'base_root' => $paths['base_root'],
				'base_path' => $paths['base_path'],
				// Optional parameters - showing the defaults if you don't set anything:
				'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.
				'parents' => array(0 => 'body'), // Our parent is body.
				'list_depth' => 0, // This is the current depth of any current list.
				'context' => 'section', // Possible values - section, footer or header.
				'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
				'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
				'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
				'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
				'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
				'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.
		
				// Optional - no default:
				'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
		);
		
		// Convert the HTML and put it into the PHPWord object
		htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);
		
		// Clear the HTML dom object:
		$html_dom->clear();
		unset($html_dom);
		
		// Save File
		$h2d_file_uri = tempnam('', 'htd');
		$objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');
		$objWriter->save($h2d_file_uri);
		
		// Download the file:
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$arquivo);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($h2d_file_uri));
		ob_clean();
		flush();
		$status = readfile($h2d_file_uri);
		unlink($h2d_file_uri);
	}
	
	function exportaExcel($consulta, $arquivo)
	{
		require_once PATH_INFRA . '/excel/Classes/PHPExcel/IOFactory.php';
		// Cria o arquivo, se nao existir
		$file = PATH_EMPRESA . '/' . $_SESSION['empresa_Usuario'] . '/temp/' . $arquivo;
		try 
		{
		    /* Pegar o Nome das Colunas */
		    $cont = $consulta->columnCount();
		    $exc = array();
		    if ($cont <= 40)
		    {
				// Faz load do arquivo, pra gravar dados
				$objPHPExcel = new PHPExcel();
				// So funciona a function abaixo para Excel 5 e 2007.
				$objPHPExcel->getProperties()->setCreator("Ultra Lims Ltda")
							 ->setLastModifiedBy("Modificado por Ultra Lims")
							 ->setTitle("Ultra Lims")
							 ->setSubject("Exportacao - Software Ultra Lims")
							 ->setDescription("Exportacao")
							 ->setKeywords("Ultra Lims")
							 ->setCategory("Ultra Lims");
				$objWorkSheet = $objPHPExcel->getActiveSheet();
			    for ($i=0; $i<$cont; $i++)
			    {
			    	$meta = $consulta->getColumnMeta($i);
			    	$name = $meta['name'];
			    	$name = substr($name, 0,3);
			    	if ($name != 'ai_')
			    	{
				    	$column[] = $meta['name'];
				    	$objWorkSheet->fromArray($column);
			    	}
			    	else $exc[] = $i;
			    }
			    $linha = array(0=>'A',1=>'B',2=>'C',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',18=>'S',19=>'T',20=>'U',
			    21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',26=>'AA',27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',34=>'AI',35=>'AJ',36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO');
			    $lin = 2;
			    while ($row = fetchArray($consulta))
			    {
			    	$x = 0;
			    	for ($i=0; $i<$cont; $i++)
			    	{
			    		$existe = in_array("$i", $exc);
			    		if (!$existe)
			    		{
			    			$colLetra = $linha[$x];
					    	$cel = "$colLetra$lin";
					    	$objPHPExcel->getActiveSheet()->getStyle($cel)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
								//$objPHPExcel->getActiveSheet()->getCell($cel)->setValueExplicit($valorCel, PHPExcel_Cell_DataType::TYPE_NUMERIC);
								//$objWorkSheet->setCellValue($cel,$row[$i]);							
							$valCel = $row[$i];
							if (is_numeric($valCel))
							{
								$valCel = trocaVirgulaPorPonto($valCel);
								$objPHPExcel->getActiveSheet()->getCell($cel)->setValueExplicit($valCel, PHPExcel_Cell_DataType::TYPE_NUMERIC);
							}
							else $objPHPExcel->getActiveSheet()->getCell($cel)->setValueExplicit($valCel, PHPExcel_Cell_DataType::TYPE_STRING);

							//$objWorkSheet->setCellValue($cel,$row[$i]);
					    	$x++;
			    		}
			    		else
			    			$colLetra = $linha[$x];
			    	}
				    $lin++;
			    }
			    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save($file);
		    }
		    else
		    	msgBox('O máximo de campos permitidos é 20. Verifique a rotina de exportação para Excel.');
		}
	    catch (PDOException $e) {
		   print $e->getMessage();
	 	}
	}
	
	function exportaExcelArray($arrayCabecalho, $arrayValores, $arquivo)
	{
		if (is_array($arrayCabecalho) and is_array($arrayValores))
		{
			require_once PATH_INFRA . '/excel/Classes/PHPExcel/IOFactory.php';
			// Cria o arquivo, se nao existir
			$file = PATH_EMPRESA . '/' . $_SESSION['empresa_Usuario'] . '/temp/' . $arquivo;
			try 
			{
				$colunas = count($arrayCabecalho);
				
			    if ($colunas <= 60)
			    {
					// Faz load do arquivo, pra gravar dados
					$objPHPExcel = new PHPExcel();
					// So funciona a function abaixo para Excel 5 e 2007.
					$objPHPExcel->getProperties()->setCreator("Ultra Lims Ltda")
								 ->setLastModifiedBy("Modificado por Ultra Lims")
								 ->setTitle("Ultra Lims")
								 ->setSubject("Exportacao - Software Ultra Lims")
								 ->setDescription("Exportacao")
								 ->setKeywords("Ultra Lims")
								 ->setCategory("Ultra Lims");
					$objWorkSheet = $objPHPExcel->getActiveSheet();
				    $linha = array(0=>'A',1=>'B',2=>'C',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',18=>'S',19=>'T',20=>'U',
				    21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',26=>'AA',27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',34=>'AI',35=>'AJ',36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO',
				    41=>'AP',42=>'AQ',43=>'AR',44=>'AS',45=>'AT',46=>'AU',47=>'AV',48=>'AW',49=>'AX',50=>'AY',51=>'AZ',52=>'BA',53=>'BB',54=>'BC',55=>'BD',56=>'BE',57=>'BF',58=>'BG',59=>'BH',60=>'BI');
				    $lin = 1;
				    $col = 0;
				    // Seta os nomes dos campos.  
				    for ($i=0; $i<$colunas; $i++)
				    {
		    			$colLetra = $linha[$col];
				    	$cel = "$colLetra$lin";
					    	
				    	$objWorkSheet->setCellValue($cel,$arrayCabecalho[$i]);
				    	$col++;
				    }
				    
				    $lin = 2;
				    $linhas = count($arrayValores[0])-1;
				    
			    	for ($i=0; $i<=$linhas; $i++)
			    	{
				    	for ($col=0;$col<$colunas; $col++)
				    	{
				    		$colLetra = $linha[$col];
					    	$cel = "$colLetra$lin";
					    	
					    	$objPHPExcel->getActiveSheet()->getStyle($cel)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
          					//$objPHPExcel->getActiveSheet()->getStyle($cel)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
							$valCel = $arrayValores[$col][$i];
							if (is_numeric($valCel))
							{
								$valCel = trocaVirgulaPorPonto($valCel);
								$objPHPExcel->getActiveSheet()->getCell($cel)->setValueExplicit($valCel, PHPExcel_Cell_DataType::TYPE_NUMERIC);
							}
							else $objPHPExcel->getActiveSheet()->getCell($cel)->setValueExplicit($valCel, PHPExcel_Cell_DataType::TYPE_STRING);
          					//$objWorkSheet->setCellValue($cel,$arrayValores[$col][$i]);
					    	
				    	}
				    	$lin++;
			    	}
			    	
				    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			    	$objWriter->save($file);
			    	
			    }
			    else
			    	msgBox('O máximo de campos permitidos é 60. Verifique a rotina de exportação para Excel.');
			}
		    catch (PDOException $e) {
			   print $e->getMessage();
		 	}
		}
		else 
			throw "O parâmetro passado para a função exportaExcelArray não é um array.";
	}
	
	function importaResultadoExcel($valor, $celulasValor, $celulasResultado, $arquivo, $salvarEm=NULL)
	{
		// $valor -> array que deve conter todos os valores a serem setados na planilha
		// $celulasValor -> celulas que devem receber o valores na variavel $valor, na mesma ordem
		// $celulasResultado -> celulas que devem buscar os resultados, apos o calculo
		// $arquivo -> arquivo a ser lido que dever estar dentro de /infra/excel/planilha
		require_once PATH_INFRA . '/excel/Classes/PHPExcel/IOFactory.php';
		// Cria o arquivo, se nao existir
		
		$fileTeste = PATH_EMPRESA . '/' . $_SESSION['empresa_Usuario'] . '/formula/' . $arquivo;
		$fileTemp = PATH_EMPRESA . '/' . $_SESSION['empresa_Usuario'] . '/temp/' . $arquivo;
		$exec = false;
		$retorno = array();
		if (file_exists($fileTeste))
		{
			$exec = true;
		}
		elseif (file_exists($fileTemp))
		{
			$fileTeste = PATH_EMPRESA . '/' . $_SESSION['empresa_Usuario'] . '/temp/' . $arquivo;
			$exec = true;
		}
		else
		{
			$fileTeste = PATH_INFRA . '/planilhaModelo/' . $arquivo;
			if (file_exists($fileTeste))
				$exec = true;
		}
		
		if ($exec)
		{
			$contValor = count($valor);
			$contCelulas = count($celulasValor);
			if ($contValor == $contCelulas)
			{
				try 
				{
					PHPExcel_Calculation::getInstance()->clearCalculationCache();
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$objPHPExcel = $objReader->load($fileTeste);
					//geraLog('#1 Celulas'.var_export($celulasValor, true));
					//geraLog('#2 Valor'.var_export($valor, true));
						
					$i = 0;
					// Seta os valores nas celulas informadas;
					foreach ($celulasValor as $cel)
					{
						$valCel = $valor[$i];
						$vTam = strlen($valCel);
						if ($vTam == 10)
						{
							if (is_date($valCel))
							{
								$ano = substr($valCel,6,4);
								$mes = substr($valCel,3,2);
								$dia = substr($valCel,0,2);
								try {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel, PHPExcel_Shared_Date::FormattedPHPToExcel($ano,$mes,$dia));
								}
								catch (Exception $e)
								{
									echo 'Erro->' . $e;
									echo '<br>';
									echo 'Celula do erro->' . $cel . '  ### Formula de erro->' . $objPHPExcel->getActiveSheet()->getCell($cel)->getValue();
									echo '<br>';
									print $e->getMessage();
									geraLog('Celula do erro->' . $cel . '  ### Formula de erro->' . $objPHPExcel->getActiveSheet()->getCell($cel)->getValue());
								}
								
							}
							else
							{
								$valCel = trocaVirgulaPorPonto($valor[$i]);
								try {
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel, $valCel);
								}
								catch (Exception $e)
								{
									echo 'Erro->' . $e;
									echo '<br>';
									echo 'Celula do erro->' . $cel . '  ### Formula de erro->' . $objPHPExcel->getActiveSheet()->getCell($cel)->getValue();
									echo '<br>';
									print $e->getMessage();
									geraLog('Celula do erro->' . $cel . '  ### Formula de erro->' . $objPHPExcel->getActiveSheet()->getCell($cel)->getValue());
								}
							}
						}
						else
						{
							$valCel = trocaVirgulaPorPonto($valor[$i]);
							try {
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cel, $valCel);
							}
							catch (Exception $e)
							{
								echo 'Erro->' . $e;
								echo '<br>';
								echo 'Celula do erro->' . $cel . '  ### Formula de erro->' . $objPHPExcel->getActiveSheet()->getCell($cel)->getValue();
								echo '<br>';
								print $e->getMessage();
								geraLog('Celula do erro->' . $cel . '  ### Formula de erro->' . $objPHPExcel->getActiveSheet()->getCell($cel)->getValue());
							}
						}
						$i++;
					}
					// Busca os resultados desejados.
					$i = 0;
					try 
					{
						foreach ($celulasResultado as $resultado)
						{
							$valor = $objPHPExcel->setActiveSheetIndex(0)->getCell($resultado)->getValue();
							// Testando se é uma fórmula,senao dá erro no getCalculated.
							if (strpos($valor,'=') === 0) {
								PHPExcel_Calculation::getInstance()->clearCalculationCache();
								$retorno[$i] = $objPHPExcel->setActiveSheetIndex(0)->getCell($resultado)->getCalculatedValue();
								if (strpos($valor,'\'') !=0 )
								{
									$novo = substr($valor, 2, strlen($valor));
									$nomePlan = substr($novo, 0, strpos($valor,'\''));
									$cel = substr($novo, strpos($valor,'\'')+1, strlen($Novo)); 
									geraLog(" Cel #1: " .$resultado . " Resultado: " . $retorno[$i] . ' - Formula :'. $valor . ' - Planilha:'. $nomePlan . ' - Celula:'.$cel);
								}
								else
									geraLog(" Cel #1: " .$resultado . " Resultado: " . $retorno[$i] . ' - Formula :'. $valor);
							}
							else {
								$retorno[$i] = $valor;
								geraLog(" Cel #2: " .$resultado . " Resultado: " . $retorno[$i]);
							}
							
							$cel = $resultado;
							$i++;
						}
					}
					catch (Exception $e)
					{
						
						echo 'Erro->' . $e;
						echo '<br>';
						echo 'Celula do erro ->' . $cel . '  ### Formula de erro->' . $objPHPExcel->getActiveSheet()->getCell($cel)->getValue();
						echo '<br>';
						echo 'Certifique-se de que todas as fórmulas utilizadas nesta planilha sejam compatíveis com excel 2007';  
						geraLog('Certifique-se de que todas as fórmulas utilizadas nesta planilha sejam compatíveis com excel 2007');  
					}
					
					if ($salvarEm != NULL)
						$file = PATH_EMPRESA . '/' . $_SESSION['empresa_Usuario'] . '/temp/' . $salvarEm;
					else
						$file = PATH_EMPRESA . '/' . $_SESSION['empresa_Usuario'] . '/temp/planilhaCalculada.xlsx';
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->setPreCalculateFormulas(FALSE);
					$objWriter->save($file);
					
					$objPHPExcel->disconnectWorksheets();
					unset($objWriter, $objPHPExcel, $objReader);	
					//geraLog('#3 - Retorno'.var_export($retorno, true));
						
					return $retorno;
				}
			    catch (PDOException $e)
			    {
				   print $e->getMessage();
			 	}
			}
			else msgBox('A quantidade de Celulas, deve ser igual a quantidade de valores.');
			
		}
		else msgBox('O arquivo solicitado não foi encontrado: ' . $arquivo);
		
	}

	function minutosParaHorasMinutos($mins)
	{
		// Se os minutos estiverem negativos
		if ($mins < 0)
			$min = abs($mins);
		else
			$min = $mins;
        // Arredonda a hora
        $h = floor($min / 60);
        $m = ($min - ($h * 60)) / 100;
        $horas = $h + $m;
        // Matemática da quinta série
        // Detalhe: Aqui também pode se usar o abs()
        if ($mins < 0)
        	$horas *= -1;
        // Separa a hora dos minutos
        $sep = explode('.', $horas);
        $h = $sep[0];
        if (empty($sep[1]))
        	$sep[1] = 00;
        	$m = $sep[1];
        // Aqui um pequeno artifício pra colocar um zero no final
        if (strlen($m) < 2)
        	$m = $m . 0;
        	
        return sprintf('%02d:%02d', $h, $m);
	}
	
	function formataValorParaTela($valor)
	{
		$pos = strpos($valor,'.');
        $dig = strlen($valor) - 1 - $pos;
		$valor2 = number_format($valor, $dig, ',', '.');
		return $valor2;
	}
	
	function formataValorParaBanco($valor)
	{
		$pos = strpos($valor,',');
		$dig = strlen($valor) - $pos;
		$valor2 = number_format($valor, $dig, '.', ',');
		return $valor2;
	}
	
	function formataMoedaParaTela($valor)
	{
		if (strpos($valor, "R$") !== false)
			$valor = substr($valor, 3,strlen($valor));
		$source = array(',', '.');
		$replace = array('.', ',');
		$valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
		$valor = number_format((float) $valor, 2, ',', '.');
		return $valor;
	}
	
	function formataMoedaParaBanco($valor)
	{
		if (strpos($valor, "R$") !== false)
			$valor = substr($valor, 3,strlen($valor));
		
		$source = array('.', ',');
		$replace = array('', '.');
		$valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
		return $valor;
	}
	
	/*
	require_once 'pdfPadrao.php';
	require_once 'geraPdf.php';
	
	class pdfPadrao
	{
		private $cabecalho = '';
		private $consulta = '';
		function setCabecalho($cabecalho)
		{
			$this->cabecalho = $cabecalho;
		}
	
		function setConsulta($consulta)
		{
			$this->consulta = $consulta;
		}
		
		function executa()
		{
			if (($this->cabecalho != '') and ($this->consulta != ''))
			{
				$pdf = new pdfPadrao_();
				$pdf->setCabecalho($this->cabecalho);
				$pdf->setConsulta($this->consulta);
				ob_start();
				$pdf->executa();
				$file = ob_get_contents();
				ob_end_clean();
			 	$ok = file_put_contents(PATH_EMPRESA . '/'.$_SESSION['empresa_Usuario'].'/temp/temp.html', $file);
				if ($ok) 
			 	{        
					$geraPdf = new geraPdf(NULL);
					$arquivo = PATH_EMPRESA . "/" . $_SESSION['empresa_Usuario'] . "/temp/teste.pdf";
	    			$complementoRodape = 'Versao:Nao Controlada';
					$geraPdf->executeMostra($file, $arquivo,'P','', $complementoRodape, NULL);
			 	} 
			 	else msgBox('Ocorreu um erro ao gerar o Arquivo.');
			 	
				
			}
			else 
			{
				throw new Exception ('Falta setar um dos parâmetros: Cabecalho ou Consulta');
			}
		}
	}
	*/

	function is_date( $str )
	{ 
	    $data = explode("/",$str);//strtotime( $str ); 
		$retorno = false;
	    $d = @$data[0];
		$m = @$data[1];
		$y = @$data[2];
		try
		{
			if (is_numeric($d) && is_numeric($m) && is_numeric($y)) {
			    if (@checkdate($m, $d, $y)) 
			        $retorno = true;
			 }
		}
		catch (Excepton $e)
		{
			$retorno = false;
		}
		return $retorno; 
	}
			
	function dataParaMiliData($data)
	{
		setTimeZone();
		// msgBox(substr($data,11,2). "-" . substr($data,14,2) . "-" . substr($data,5,2). "-" . substr($data,8,2). "-" . substr($data,0,4));
		// Recebe em formato do banco yyyy/mm/dd hh:mm:ss
		$date1 = mktime(substr($data,11,2), substr($data,14,2), 0, substr($data,5,2), substr($data,8,2), substr($data,0,4));
		return $date1;
	}
	
	function miliDataParaData($mili)
	{
		setTimeZone();
		// converte para formato do banco yyyy/mm/dd hh:mm:ss
		$date1 = date("Y/m/d H:i:s", $mili);
		return $date1;
	}
	function converteDataHoraBanco($data)
	{
		$data2 = substr($data, 0, 10);
		$hora = substr($data, 11, 8);
		$data2 = implode("-",array_reverse(explode("/",$data2)));
		$data2 .= ' ' . $hora;
		return $data2;
	}
	
	function converteSoDataBanco($data)
	{
		$data2 = substr($data, 0, 10);
		$data2 = implode("-",array_reverse(explode("/",$data2)));
		return $data2;
	}
	
	function converteDataHoraTela($data)
	{
		$data2 = substr($data, 0, 10);
		$hora = substr($data, 11, 8);
		//msgBox("veio " . $data . " data separada " . $data2 . " hora " . $hora);
		$data2 = implode("/",array_reverse(explode("-",$data2)));
		$data2 .= ' ' . $hora;
		//msgBox(" final " . $data2);
		return $data2;
	}
		
	function converteSoDataTela($data)
	{
		$data2 = substr($data, 0, 10);
		$hora = substr($data, 11, 8);
		//msgBox("veio " . $data . " data separada " . $data2 . " hora " . $hora);
		$data2 = implode("/",array_reverse(explode("-",$data2)));
		//$data2 .= ' ' . $hora;
		//msgBox(" final " . $data2);
		return $data2;
	}
	function trocaVirgulaPorPonto($valor)
	{
		$pos = strpos($valor,',');
		if ($pos > 0)
			return str_replace(',','.',$valor);
		else return $valor;
	}	
 
	function somaSegundosData($data, $segundos)
	{
		setTimeZone();
		$sec = strtotime($data) + $segundos;
		return date("Y-m-d H:i:s", $sec);
	}
 
	function mascaraNova($val, $mask)
	{
		 $maskared = '';
		 $k = 0;
		 for($i = 0; $i<=strlen($mask)-1; $i++)
		 {
			 if($mask[$i] == '#')
			 {
				 if(isset($val[$k]))
					 $maskared .= $val[$k++];
			 }
			 else
			 {
				 if(isset($mask[$i]))
					 $maskared .= $mask[$i];
			 }
		 }
		 return $maskared;
	}
	
	if (!function_exists('array_column')) 
	{
		function array_column(array $input, $columnKey, $indexKey = null) 
		{
			$array = array();
			foreach ($input as $value) 
			{
				if ( ! isset($value[$columnKey])) 
				{
					trigger_error("Key \"$columnKey\" does not exist in array");
					return false;
				}
				if (is_null($indexKey)) 
				{
					$array[] = $value[$columnKey];
				}
				else 
				{
					if ( ! isset($value[$indexKey])) 
					{
						trigger_error("Key \"$indexKey\" does not exist in array");
						return false;
					}
					if ( ! is_scalar($value[$indexKey])) 
					{
						trigger_error("Key \"$indexKey\" does not contain scalar value");
						return false;
					}
					$array[$value[$indexKey]] = $value[$columnKey];
				}
			}
			return $array;
		}
	}	
	
	function retornaMes($mes)
	{
		switch ($mes)
		{
			case 1 :
				$str = "JAN";
				break;
			case 2 :
				$str = "FEV";
				break;
			case 3 :
				$str = "MAR";
				break;
			case 4 :
				$str = "ABR";
				break;
			case 5 :
				$str = "MAI";
				break;
			case 6 :
				$str = "JUN";
				break;
			case 7 :
				$str = "JUL";
				break;
			case 8 :
				$str = "AGO";
				break;
			case 9 :
				$str = "SET";
				break;
			case 10 :
				$str = "OUT";
				break;
			case 11 :
				$str = "NOV";
				break;
			case 12 :
				$str = "DEZ";
				break;
		}
		return $str;
	}
	
	function retornaMesExtenso($mes)
	{
		switch ($mes)
		{
			case 1 : 
					$str = "Janeiro";
					break;
			case 2 : 
					$str = "Fevereiro";
					break;
			case 3 : 
					$str = "Mar&ccedil;o";
					break;
			case 4 : 
					$str = "Abril";
					break;
			case 5 : 
					$str = "Maio";
					break;
			case 6 : 
					$str = "Junho";
					break;
			case 7 : 
					$str = "Julho";
					break;
			case 8 : 
					$str = "Agosto";
					break;
			case 9 : 
					$str = "Setembro";
					break;
			case 10 : 
					$str = "Outubro";
					break;
			case 11 : 
					$str = "Novembro";
					break;
			case 12 : 
					$str = "Dezembro";
					break;
		}
		return $str;
	}
	
	function diferencaEntreDataHora($date_1 , $date_2 , $differenceFormat = '%a' )
	{
		setTimeZone();
		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);
	
		$interval = date_diff($datetime1, $datetime2);
	
		return $interval->format($differenceFormat);
	
	}
	
	function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
	{
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		$retorno = '';
		$caracteres = '';
		$caracteres .= $lmin;
		if ($maiusculas) $caracteres .= $lmai;
		if ($numeros) $caracteres .= $num;
		if ($simbolos) $caracteres .= $simb;
		$len = strlen($caracteres);
		for ($n = 1; $n <= $tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];
		}
		return $retorno;
	}
	
	function iso8859_converter($array)
	{
		array_walk_recursive($array, function(&$item, $key){
			if(mb_detect_encoding($item, 'UTF-8', true)){
				$item = utf8_decode($item);
			}
		});
	
		return $array;
	}
	
	function sanitizeString($str) {
		 // matriz de entrada
		$str = utf8_decode($str);
	    $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','É','Ê','Í','Ó','Ú','ñ','Ñ','ç','Ç','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º',"'");
	
	    // matriz de saída
	    $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','E','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_',' ');
	
	    // devolver a string
	    $retorno = str_replace($what, $by, $str);
	    return $retorno;
	}	

	function setTimeZone() {
		if (!file_exists(PATH_EMPRESA . '/'.$_SESSION['empresa_Usuario'].'/timeZone.php')) {
			date_default_timezone_set('America/Sao_Paulo');
			geraLog("TIMEZONE => PADRAO - America/Sao_Paulo");
		}
		else {
			include PATH_EMPRESA . '/'.$_SESSION['empresa_Usuario'].'/timeZone.php';
			date_default_timezone_set($timeZone);
			geraLog("TIMEZONE => Encontrou na Empresa - " . $timeZone);
		}
	}
