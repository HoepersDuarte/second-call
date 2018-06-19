<?php
	require_once PATH_INFRA . '/gerente.php';
	
  	class alcadaAprovacao
  	{
  		private $ai_AlcadaAprovacao;
  		private $idEmpresa;
  		private $ai_AlcadaGeral;
  		private $ai_SetorCargo;
  		private $ordemAprovacao;

  		function __destruct()
  		{
  			
  		}
  		
  		function setIdEmpresa($idEmpresa)
  		{
  			$this->idEmpresa = $idEmpresa;
  		}
  		
  	  	function setAi_AlcadaGeral($ai_AlcadaGeral)
  		{
  			$this->ai_AlcadaGeral = $ai_AlcadaGeral;
  		}
  		
  		function setAi_AlcadaAprovacao($ai_AlcadaAprovacao)
  		{
  			$this->ai_AlcadaAprovacao = $ai_AlcadaAprovacao;
  		}
  		
  		function setAi_SetorCargo($ai_SetorCargo)
  		{
  			$this->ai_SetorCargo = $ai_SetorCargo;
  		}
  		
  		function setOrdemAprovacao($ordemAprovacao)
  		{
  			$this->ordemAprovacao = $ordemAprovacao;
  		}
  		
  		// GET
  		function getIdEmpresa()
  		{
  			return $this->idEmpresa;
  		}
  		
  		function getAi_AlcadaGeral()
  		{
  			return $this->ai_AlcadaGeral;
  		}
  		
  		function getAi_AlcadaAprovacao()
  		{
  			return $this->ai_AlcadaAprovacao;
  		}

  		function getAi_SetorCargo()
  		{
  			return $this->ai_SetorCargo;
  		}
  		
  		function getOrdemAprovacao()
  		{
  			return $this->ordemAprovacao;
  		}
  		
  		function insereAlcadaAprovacao ($idEmpresa, $ai_AlcadaGeral, $ai_SetorCargo, $ordemAprovacao)
  		{
			try 
  			{
				$parametros = array ($idEmpresa, $ai_AlcadaGeral, $ai_SetorCargo, $ordemAprovacao);
				$novo = validaParametros($parametros);
	
				$sql = "INSERT INTO alcadaAprovacao (idEmpresa, ai_AlcadaGeral, ai_SetorCargo, ordemAprovacao)";
				$sql .= " VALUES ('$novo[0]','$novo[1]','$novo[2]','$novo[3]')"; 
	     		geraLog($sql);
  				
				
				$criaAlcadaAprovacao = queryInsert($sql);
				return $criaAlcadaAprovacao;

  			} 
  			catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro ao tentar inserir o registro de Alзada de Aprovaзгo.");
  				exit();
  			}	
  			
  		} 
  		  		
  		function alteraAlcadaAprovacao($ai_AlcadaAprovacao, $ai_SetorCargo, $ordemAprovacao)
	  	{
			try 
  			{
				if (empty($ai_AlcadaAprovacao) OR empty($ai_SetorCargo))
				{
					throw new Exception("Й obrigatуrio informar a ai_AlcadaAprovacao e ai_SetorCargo para Alteraзгo.");
					exit();
				}
				$parametros = array($ai_AlcadaAprovacao, $ai_SetorCargo, $ordemAprovacao);
				$novo = validaParametros($parametros);
				
				$sql = "UPDATE alcadaAprovacao SET  ai_SetorCargo ='$novo[1]' ";
				
				if ($novo[2] != 'NULL')
					$sql .= ", ordemAprovacao = '$novo[2]'";
								
				$sql .= " WHERE ai_AlcadaAprovacao = '$novo[0]' ";
				geraLog($sql);

				
				$alteraAlcadaAprovacao = querySelect($sql);

				unset($alteraAlcadaAprovacao);
  			} 
  			catch (Exception $e) 
  			{
  				throw new Exception("Ocorreu um erro ao tentar alterar o registro de Alзada de Aprovaзгo.");
  				exit();
  			}	
	  	}
  			  	
	  	function excluiAlcadaAprovacao($ai_AlcadaAprovacao)
		{
			if (empty($ai_AlcadaAprovacao))
			{
				throw new Exception("Й obrigatуrio passar os dados ai_AlcadaAprovacao como Parвmetro.");
				exit();
			}
			
			$parametros = array($ai_AlcadaAprovacao);
			$novo = validaParametros($parametros);

			$sql = "DELETE FROM alcadaAprovacao WHERE ai_AlcadaAprovacao ='$novo[0]' ";
			geraLog("Exclui AlcadaAprovacao:" . $sql);

			try 
    	 	{
    	 		
    	 		$consulta = querySelect($sql);
    	 		return $consulta;
    	 	} 
    	 	catch (Exception $e) 
    	 	{
    	 		throw $e;
    	 	}
		}
  		  		
  	}
?>