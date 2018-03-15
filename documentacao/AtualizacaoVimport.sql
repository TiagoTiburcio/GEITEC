CREATE TABLE `circuito_arquivo_import` (
  `nome_arquivo` varchar(100) NOT NULL,
  `num_linha_arquivo` int(11) NOT NULL,
  `site` varchar(10) DEFAULT NULL,
  `nome_cliente` varchar(50) DEFAULT NULL,
  `finalidade` varchar(50) DEFAULT NULL,
  `contrato` varchar(10) DEFAULT NULL,
  `ciclo_faturamento` varchar(15) DEFAULT NULL,
  `num_fatura` varchar(25) DEFAULT NULL,
  `num_nota_fiscal` varchar(25) DEFAULT NULL,
  `cod_ddd` varchar(10) DEFAULT NULL,
  `num_telefone` varchar(15) DEFAULT NULL,
  `designacao` varchar(30) DEFAULT NULL,
  `valor_a_pagar` varchar(15) DEFAULT NULL,
  `tip_logradouro` varchar(20) DEFAULT NULL,
  `nome_local` varchar(30) DEFAULT NULL,
  `nome_logradouro` varchar(30) DEFAULT NULL,
  `num_imovel` varchar(15) DEFAULT NULL,
  `nome_bairro` varchar(20) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `uf` varchar(10) DEFAULT NULL,
  `nome_local2` varchar(30) DEFAULT NULL,
  `tip_logradouro2` varchar(20) DEFAULT NULL,
  `nome_logradouro2` varchar(30) DEFAULT NULL,
  `nome_bairro2` varchar(20) DEFAULT NULL,
  `cep2` varchar(20) DEFAULT NULL,
  `num_imovel2` varchar(15) DEFAULT NULL,
  `uf2` varchar(10) DEFAULT NULL,
  `prod_telefone` varchar(20) DEFAULT NULL,
  `velocidade_circuito` varchar(20) DEFAULT NULL,
  `num_pagina` varchar(10) DEFAULT NULL,
  `num_linha` varchar(10) DEFAULT NULL,
  `data_servico` varchar(15) DEFAULT NULL,
  `cod_servico_descricao_servico` varchar(90) DEFAULT NULL,
  `degrau` varchar(10) DEFAULT NULL,
  `num_tel_origem` varchar(15) DEFAULT NULL,
  `cod_selecao` varchar(12) DEFAULT NULL,
  `ddd_tel_destino` varchar(12) DEFAULT NULL,
  `tel_destino` varchar(16) DEFAULT NULL,
  `hr_qtd_chamada` varchar(16) DEFAULT NULL,
  `duracao` varchar(7) DEFAULT NULL,
  `s` varchar(1) DEFAULT NULL,
  `valor_servico` varchar(13) DEFAULT NULL,
  `aliquota_icms` varchar(13) DEFAULT NULL,
  `conta` varchar(8) DEFAULT NULL,
  `num_detalhe` varchar(11) DEFAULT NULL,
  `cod_l_origem_chamada` varchar(24) DEFAULT NULL,
  `cod_l_destino_chamada` varchar(24) DEFAULT NULL,
  `vencimento` varchar(10) DEFAULT NULL,
  `contestar` varchar(14) DEFAULT NULL,
  `valor_contestar` varchar(14) DEFAULT NULL,
  `localidade` varchar(20) DEFAULT NULL,
  `telefone_origem` varchar(16) DEFAULT NULL,
  `sigla_orgao_analise` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`nome_arquivo`,`num_linha_arquivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `circuito_arquivo_import_temp` (
  `nome_arquivo` varchar(100) NOT NULL,
  `num_linha_arquivo` int(11) NOT NULL,
  `contrato` varchar(15) DEFAULT NULL,
  `num_fatura` varchar(25) DEFAULT NULL,
  `num_nota_fiscal` varchar(25) DEFAULT NULL,
  `cod_ddd` varchar(10) DEFAULT NULL,
  `num_telefone` varchar(15) DEFAULT NULL,
  `designacao` varchar(30) DEFAULT NULL,
  `tip_logradouro` varchar(20) DEFAULT NULL,
  `nome_local` varchar(30) DEFAULT NULL,
  `nome_logradouro` varchar(30) DEFAULT NULL,
  `num_imovel` varchar(15) DEFAULT NULL,
  `nome_bairro` varchar(20) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `uf` varchar(10) DEFAULT NULL,
  `prod_telefone` varchar(20) DEFAULT NULL,
  `velocidade_circuito` varchar(20) DEFAULT NULL,
  `num_pagina` varchar(10) DEFAULT NULL,
  `num_linha` varchar(10) DEFAULT NULL,
  `data_servico` date DEFAULT NULL,
  `cod_servico_descricao_servico` varchar(90) DEFAULT NULL,
  `valor_servico` decimal(11,2) DEFAULT NULL,
  `conta` date DEFAULT NULL,
  `num_detalhe` varchar(11) DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  PRIMARY KEY (`nome_arquivo`,`num_linha_arquivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `circuitos_contas` (
  `designacao` varchar(45) NOT NULL,
  `periodo_ref` date NOT NULL,
  `fatura` varchar(45) DEFAULT NULL,
  `valor_conta` double DEFAULT NULL,
  `nome_arquivo` varchar(45) DEFAULT NULL,
  `num_linha_arquivo` int(11) DEFAULT NULL,
  `vencimento` date DEFAULT NULL,
  KEY `designacao` (`designacao`),
  KEY `periodo` (`periodo_ref`),
  KEY `fatura` (`fatura`,`vencimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `circuitos_contrato` (
  `codigo` varchar(45) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `nome_fornecedor` varchar(45) DEFAULT NULL,
  `descricao_servico` varchar(45) DEFAULT NULL,
  `contrato` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `circuitos_correcao_import` (
  `contrato` varchar(45) NOT NULL,
  `designacao_antes` varchar(45) NOT NULL,
  `designacao_depois` varchar(45) NOT NULL,
  PRIMARY KEY (`contrato`,`designacao_antes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `circuitos_localizacao` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `circuitos_registro_consumo` (
  `codigo` varchar(45) NOT NULL,
  `localizacao` int(11) NOT NULL,
  `codigo_unidade` varchar(60) NOT NULL,
  `data_ativacao` date NOT NULL,
  `velocidade` varchar(45) DEFAULT NULL,
  `tipo_servico` varchar(20) DEFAULT NULL,
  `tip_logradouro` varchar(20) DEFAULT NULL,
  `nome_logradouro` varchar(30) DEFAULT NULL,
  `nome_cidade` varchar(30) DEFAULT NULL,
  `num_imovel` varchar(12) DEFAULT NULL,
  `nome_bairro` varchar(20) DEFAULT NULL,
  `data_ult_ref` date DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `cod_ut` (`codigo_unidade`,`localizacao`,`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `circuitos_tipo_servico` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `circuitos_unidades` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_siig` int(11) NOT NULL,
  `codigo_inep` varchar(30) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `sigla` varchar(60) NOT NULL,
  `codigo_ut_siig` varchar(15) DEFAULT NULL,
  `codigo_unidade_pai` int(11) NOT NULL,
  `codigo_tipo_categoria_unidade` int(11) NOT NULL,
  `zona_localizacao_unidade` varchar(1) DEFAULT NULL,
  `cidade` varchar(45) NOT NULL,
  `ativo` int(2) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `cod_ut` (`codigo_ut_siig`,`codigo_siig`,`cidade`,`ativo`)
) ENGINE=InnoDB AUTO_INCREMENT=2219 DEFAULT CHARSET=utf8;
