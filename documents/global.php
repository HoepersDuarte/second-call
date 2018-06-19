<?php
	/*	Endereco para atualizacao no localhost */	
	define("PATH_APP","c:/xampp/htdocs/saas215git/app");
	define("PATH_INFRA","c:/xampp/htdocs/saas215git/infra");
	define("PATH_EMPRESA","c:/xampp/htdocs/saas215git/empresas");
	define("PATH_SAAS","/saas215git/");
	
	// definição igual para localhost e para site
    // 1 - mysql / 2 - sqlserver
	define("BANCO","1"); 
	// local - deve enviar e-mail com remetente local.
	// servidor - deve enviar e-mail pela conta da ultralims, e aviso no final do e-mail para respostas.
	define("EMAIL","servidor"); 
	//Variavel para validar usuário no servidor via protocolo LDAP
	define("LDAP","");
	
	define("HOST","localhost");
	
	define ("LANGUAGE","pt_Br");
	
	define("ASSINATURA_SEMLINHA","Aparecida Izelli");
	
 	// Seta o TimeZone
  	date_default_timezone_set('America/Sao_Paulo');
  	// Tira os warnings por causa de nomes de variaveis globais e locais   
  	ini_set('session.bug_compat_warn', 0);
	ini_set('session.bug_compat_42', 0);
	
  	// paginas para acesso pelos links de consulta
	$paginaFormulaCalculo = "../control/empresaControl.php?action=detalhaFormulaCalculo&ai_FormulaCalculo=";
    $paginaAvaliacao = "../control/empresaControl.php?action=detalhaAvaliacao&ai_Avaliacao=";
    $paginaTipoControleCQ = "../control/qualidadeControl.php?action=detalhaTipoControleCQ&ai_TipoControleCQ=";
    $paginaQuebraFichaPor = "../control/empresa3Control.php?action=detalhaQuebraFicha&ai_QuebraFichaPor=";
    
	// cadastros
	$paginaEquipamento = "../control/cadastro2Control.php?action=detalhaEquipamento&ai_Equipamento=";
	$paginaMovimentoEquipamento = "../control/cadastro2Control.php?action=detalhaMovimentoEquipamento&ai_MovimentoEquipamento=";
	$paginaDescricaoAmostra = "../control/cadastroControl.php?action=detalhaDescricaoAmostra&ai_DescricaoAmostra=";
	$paginaProcedimento = "../control/cadastroControl.php?action=detalhaProcedimento&ai_Procedimento=";
	$paginaLegislacao = "../control/cadastroControl.php?action=detalhaLegislacao&ai_Legislacao=";  
	$paginaEnsaioLegislacao = "../control/cadastroControl.php?action=detalhaEnsaioLegislacao&ai_EnsaioLegislacao=";  
    $paginaCondPagto = "../control/cadastroControl.php?action=detalhaCondPagto&ai_CondPagto=";
	$paginaTabPreco = "../control/cadastroControl.php?action=detalhaTabPreco&ai_TabPreco=";
    $paginaPacoteVenda = "../control/cadastroControl.php?action=detalhaPacoteVenda&ai_PacoteVenda=";
	$paginaCelulaRealiz = "../control/cadastroControl.php?action=detalhaCelulaRealiz&ai_CelulaRealiz=";
	$paginaEstabelecimento = "../control/empresaControl.php?action=detalhaEstabelecimento&ai_Estabelecimento=";
	$paginaPadraoRelatorio = "../control/empresaControl.php?action=detalhaPadraoRelatorio&ai_PadraoRelatorio=";
	$paginaLocalPadrao = "../control/empresaControl.php?action=detalhaLocalPadrao&ai_LocalPadrao=";
	$paginaDispositivoMovel = "../control/empresa2Control.php?action=detalhaDispositivoMovel&ai_DispositivoMovel=";
   	$paginaDadosIntegra = "../control/cadastro2Control.php?action=dadosIntegraEquipamento&ai_Equipamento=";	 
   	$paginaUnMedida = "../control/cadastroControl.php?action=detalhaUnMedida&ai_UnMedida=";
   	$paginaDespesaGeral = "../control/empresa3Control.php?action=detalhaDespesaGeral&ai_DespesaGeral=";
   	
	// Servico
	$paginaServico = "../control/servicoControl.php?action=detalhaServicoGeral&ai_Servico=";
	$paginaServicoProposta = "../control/propostaControl.php?action=detalhaServicoPropostaGeral&ai_ServicoProposta=";
	$paginaAgendaTecnica = "../control/servicoControl.php?action=detalhaAgendaTecnica&ai_AgendaTecnica=";
	$paginaSolicitacaoServico = "../control/servicoControl.php?action=detalhaSolicitacaoServico&ai_SolicitacaoServico=";
	$paginaMonitoramentoServico = "../control/servicoControl.php?action=detalhaMonitoramentoSolicitaServico&ai_MonitoramentoServico=";
	
	// ensaio
    $paginaEnsaio = "../control/ensaioControl.php?action=detalhaEnsaioGeral&chamadaDetalhe=global&idEnsaio=";  
    $paginavisualizaImagemEnsaio = "../control/execucaoControl.php?action=visualizaImagemEnsaioAmostra&ai_EnsaioAmostra=";	

	// proposta
    $paginaProposta = "../control/propostaControl.php?action=detalhaPropostaGeral&ai_Proposta=";  
    $paginaPontoProposta = "../control/propostaControl.php?action=detalhaPontoColetaGeral&ai_PontoColetaProposta=";
    $paginaDespesaProposta = "../control/propostaControl.php?action=detalhaDespesaProposta&ai_DespesaProposta=";
    $paginaPagamentoProposta = "../control/propostaControl.php?action=detalhaPagamentoProposta&ai_PagamentoProposta=";
    
    // Aditivo
    $paginaAditivoContrato = "../control/proposta2Control.php?action=detalhaAditivoContrato&ai_AditivoContrato=";
    $paginaFichaAditivo = "../control/proposta2Control.php?action=detalhaFichaAditivo&ai_FichaAditivo=";
    $paginaPontoFichaAditivo = "../control/proposta2Control.php?action=detalhaPontoFichaAditivo&ai_PontoFichaAditivo=";
    $paginaEnsaioFichaAditivo = "../control/proposta2Control.php?action=detalhaEnsaioFichaAditivo&ai_EnsaioFichaAditivo=";
    
    // cliente
    /**/$paginaCliente = "../control/clienteControl.php?action=detalhaClienteGeral&ai_Cliente="; 
    /**/$paginaPessoa = "../control/clienteControl.php?action=detalhaPessoa&idPessoa="; 
    /**/$paginaFornecedor = "../control/clienteControl.php?action=detalhaFornecedorGeral&ai_Fornecedor=";
    $paginaInteressado = "../control/clienteControl.php?action=detalhaInteressado&ai_ClienteInteressado=";
    $paginaDetalheInteressado = "../control/clienteControl.php?action=detalhaClienteInteressado&ai_ClienteSolicitante=";
    
    // ficha
	$paginaFicha = "../control/fichaControl.php?action=detalhaFichaColeta&ai_FichaColeta=";  
    $paginaPontoFicha = "../control/fichaControl.php?action=detalhaPontoFicha&ai_PontoFicha=";
    $paginaPlanoAmostragem = "../control/coletaControl.php?action=detalhaPlanoAmostragem&ai_PlanoAmostragem=";
    // coletas
    $paginaRoteiroColeta = "../control/coletaControl.php?action=detalhaRoteiroColeta&ai_RoteiroColeta=";
    $paginaGrupoPontoColeta = "../control/coletaControl.php?action=detalhaGrupoPontoColeta&ai_GrupoPontoColeta=";
    $paginaPlanoFixo = "../control/coletaControl.php?action=detalhaPlanoFixo&ai_PlanoAmostragemFixo=";
    $paginaPontoColetaCliente = "../control/coletaControl.php?action=detalhaPontoCliente&ai_PontoColetaCliente=";
    $paginaEquipeColeta = "../control/coletaControl.php?action=detalhaEquipeColeta&ai_EquipeColeta=";
    
    // saneamento
    $paginaSistemaDistribuicao = "../control/saneamentoControl.php?action=detalhaSistemaDistribuicao&ai_SistemaDistribuicao=";
    $paginaElementoSaneamento = "../control/saneamentoControl.php?action=detalhaElementoSaneamento&ai_ElementoSaneamento=";
    $paginaMatrizTempoContato = "../control/saneamentoControl.php?action=detalhaMatrizTempoContato&ai_MatrizTempoContato=";
    
	// amostra
    $paginaAmostra = "../control/amostraControl.php?action=detalhaAmostra&ai_Amostra=";  
    /**/$paginaFinanceiro = "../control/financeiroControl.php?action=detalhaFinanceiro&ai_Financeiro=";  
    /**/$paginaAmostraFinanceiro = "../control/financeiroControl.php?action=detalhaAmostraFinanceiro&ai_AmostraFinanceiro=";  
    $paginaAmostraLegislacao = "../control/amostraControl.php?action=detalhaAmostraLegislacao&ai_AmostraLegislacao=";  
    $paginaPessoaAmostra = "../control/cadastro2Control.php?action=dadosPessoaAmostra&ai_PessoaAmostra=";
    $paginavisualizaFoto = "../control/amostraControl.php?action=visualizaFotoAmostra&ai_Amostra=";    
    
    $paginaCertificado = "../control/amostra2Control.php?action=detalhaCertificado&ai_Certificado=";
    $paginaAmostraCertificado = "../control/amostra2Control.php?action=detalhaAmostraCertificado&ai_AmostraCerttificado=";
    $paginaVisualizaFotoCert = "../control/amostra2Control.php?action=visualizaFotoCertificado&ai_Certificado="; 
    
    // execução
	$paginaLote = "../control/loteControl.php?action=detalhaLoteTecnico&ai_LoteTecnico=";  
    $paginaEnsaioAmostra = "../control/execucaoControl.php?action=detalhaEnsaioAmostra&ai_EnsaioAmostra=";  
	
    // analise
    $paginaReferenciaMetodologica = "../control/analiseControl.php?action=detalhaReferenciaMetodologica&ai_ReferenciaMetodologica=";
    $paginaMetodoAnalise = "../control/analiseControl.php?action=detalhaMetodoAnalise&ai_MetodoAnalise=";
    $paginaTipoEquipamento = "../control/analiseControl.php?action=detalhaTipoEquipamento&ai_TipoEquipamento=";  
    $paginaGrupoEquipamento = "../control/analiseControl.php?action=detalhaGrupoEquipamento&ai_GrupoEquipamento=";  
    
    // insumo
    /**/$paginaInsumo = "../control/insumoControl.php?action=detalhaInsumo&ai_Insumo=";
    /**/$paginaSaldoInsumo = "../control/insumoControl.php?action=detalhaSaldoInsumo&ai_SaldoInsumo=";
    $paginaSolicitaInsumo = "../control/insumoControl.php?action=detalhaSolicitaInsumo&ai_SolicitaInsumo=";
    $paginaItemSolicitaInsumo = "../control/insumoControl.php?action=detalhaItemSolicitaInsumo&ai_ItemSolicitaInsumo=";
    $paginaPreparoSolucao = "../control/insumoControl.php?action=detalhaPreparoSolucao&ai_PreparoSolucao=";
    $paginaComponentePreparo = "../control/insumoControl.php?action=detalhaComponentePreparo&ai_ComponentePreparo=";
    $paginaProcessoProdutivo = "../control/insumoControl.php?action=detalhaProcessoProdutivo&ai_ProcessoProdutivo=";
    $paginaNotaFiscal = "../control/insumoControl.php?action=detalhaNotaFiscal&ai_NotaFiscal=";
    
    // gestao
	$paginaDocumento = "../control/gestaoControl.php?action=detalhaDocumento&ai_Documento=";
    $paginaAnaliseCritica = "../control/gestaoControl.php?action=detalhaAnaliseCriticaDocum&ai_AnaliseCriticaDocum=";
    $paginaItemAnaliseCritica = "../control/gestaoControl.php?action=detalhaItemAnaliseCritica&ai_ItemAnaliseCritica=";
    $paginaAprovacaoAnaliseCritica = "../control/gestaoControl.php?action=detalhaAprovacaoAnaliseCritica&ai_AprovacaoAnaliseCritica=";
    $paginaRespostaAvaliacao = "../control/gestaoControl.php?action=detalhaRespostaAvaliacao&ai_RespostaAvaliacao=";
    $paginaHistoricoGenerico = "../control/gestaoControl.php?action=detalhaHistoricoGenerico&ai_HistoricoGenerico=";
    $paginaAcaoQualidade = "../control/gestao3Control.php?action=detalhaAcaoQualidade&ai_AcaoQualidade=";
    $paginaCausaRaiz = "../control/gestao3Control.php?action=detalhaCausaRaiz&ai_CausaRaiz=";
    $paginaPlanoAcao = "../control/gestao3Control.php?action=detalhaPlanoAcao&ai_PlanoAcao=";
    $paginaItemPlano = "../control/gestao3Control.php?action=detalhaItemPlano&ai_ItemPlano=";
    
    // gestao2
    $paginaAtividadeEquipamento = "../control/gestao2Control.php?action=detalhaAtividadeEquipamento&ai_AtividadeEquipamento=";
	$paginaAnaliseOperacaoEquipamento = "../control/gestao2Control.php?action=detalhaAnaliseOperacaoEquipamento&ai_AnaliseOperacaoEquipamento=";
    $paginaCapacitacao = "../control/gestao2Control.php?action=detalhaCapacitacao&ai_Capacitacao=";
    $paginaProfissionalCapacitacao = "../control/gestao2Control.php?action=detalhaProfissionalCapacitacao&ai_ProfissionalCapacitacao=";
    $paginaProfissional = "../control/gestao2Control.php?action=detalhaProfissional&ai_Profissional=";
    $paginaHomologaAquisicao = "../control/gestao2Control.php?action=detalhaHomologaAquisicao&ai_HomologaAquisicao=";

    //consulta gestao
    $paginaAvaliacaoEficacia = "../control/gestao2Control.php?action=detalhaEficaciaTreinamento&ai_ProfissionalCapacitacao=";
    
    // qualidade
    $paginaAmostraCQ = "../control/qualidadeControl.php?action=detalhaAmostraCQ&ai_AmostraCQ=";
    $paginaVariavelValidacao = "../control/qualidadeControl.php?action=detalhaVariavelValidacao&ai_VariavelValidacao=";
    $paginaCartaControle = "../control/qualidadeControl.php?action=detalhaCartaControle&ai_CartaControle=";
    $paginaLimiteCartaControle = "../control/qualidadeControl.php?action=detalhaLimiteCartaControle&ai_LimiteCartaControle=";
    $paginaFolhaDadosCarta = "../control/qualidadeControl.php?action=detalhaFolhaDadosCarta&ai_FolhaDadosCarta=";
    
    //equipamento
    /**/$paginaVisualizaImagemEquip = "../control/cadastro2Control.php?action=visualizaImagemEquipamento&ai_Equipamento=";
    
    // ticket
    /**/$paginaTransportadora = "../control/cargaControl.php?action=detalhaTransportadora&ai_Transportadora=";
    /**/$paginaMotorista = "../control/cargaControl.php?action=detalhaMotorista&ai_Motorista=";
    /**/$paginaVeiculo = "../control/cargaControl.php?action=detalhaVeiculo&ai_Veiculo=";
    
    // relacionamento de variaveis e programas a ser respeitado
    // confirmaColetasDoDia -> ai_Generico = ai_FichaColeta
?>
