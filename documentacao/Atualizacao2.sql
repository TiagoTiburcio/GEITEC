CREATE TABLE `redelocal_bloco` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `redelocal_equip_tipo` (
  `codigo` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `descricao` varchar(90) NOT NULL,
  `data_incl` datetime NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `redelocal_marca` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(90) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `data_incl` datetime NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `redelocal_modelo_switch` (
  `codigo` int(11) NOT NULL,
  `codigo_marca` int(11) NOT NULL,
  `codigo_equip_tipo` int(11) NOT NULL,
  `descricao` varchar(90) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `qtd_portas_eth` int(11) NOT NULL,
  `qtd_portas_fc` int(11) NOT NULL,
  `gerenciavel` tinyint(1) NOT NULL,
  `data_incl` datetime NOT NULL,
  `velocidade_padrao_portas` int(11) NOT NULL DEFAULT '1000',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `redelocal_porta_switch` (
  `codigo_switch` int(11) NOT NULL,
  `codigo_porta_switch` int(11) NOT NULL,
  `tipo_porta` int(11) NOT NULL,
  `velocidade` varchar(45) NOT NULL,
  `codigo_vlan` int(11) NOT NULL,
  `observacao` varchar(150) DEFAULT NULL,
  `texto_tela` varchar(5) NOT NULL,
  `data_alt` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo_switch`,`codigo_porta_switch`,`tipo_porta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `redelocal_rack` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `setor` varchar(45) NOT NULL,
  `codigo_bloco` int(11) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `redelocal_switch` (
  `codigo` int(11) NOT NULL,
  `codigo_modelo` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `codigo_rack` int(11) NOT NULL,
  `numero_empilhamento` int(11) DEFAULT NULL,
  `empilhado` tinyint(1) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `data_incl` datetime NOT NULL,
  `vlan_padrao` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `redelocal_tipo_porta_sw` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `redelocal_vlan` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `qtd_hosts` int(11) NOT NULL,
  `descricao` varchar(150) DEFAULT NULL,
  `rede` varchar(45) DEFAULT NULL,
  `mascara` varchar(45) DEFAULT NULL,
  `gateway` varchar(45) DEFAULT NULL,
  `cor` varchar(45) DEFAULT '#337ab7',
  `fonte` varchar(45) DEFAULT '#ffffff',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
