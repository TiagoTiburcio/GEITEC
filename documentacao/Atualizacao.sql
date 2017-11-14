CREATE TABLE `home_modulo` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `home_pagina` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `codigo_modulo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `codigo_modulo_idx` (`codigo_modulo`),
  CONSTRAINT `codigo_modulo` FOREIGN KEY (`codigo_modulo`) REFERENCES `home_modulo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `home_pagina_perfil` (
  `codigo_pagina` int(11) NOT NULL,
  `codigo_perfil` int(11) NOT NULL,
  PRIMARY KEY (`codigo_pagina`,`codigo_perfil`),
  KEY `codigo_perfil_idx` (`codigo_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `home_perfil` (
  `codigo` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `ativo` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  UNIQUE KEY `descricao_UNIQUE` (`descricao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `home_usuario` (
  `codigo` int(11) NOT NULL,
  `usuario` varchar(45) CHARACTER SET utf8 NOT NULL,
  `senha` varchar(100) CHARACTER SET utf8 NOT NULL,
  `nome` varchar(45) CHARACTER SET utf8 NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `codigo_perfil` int(11) NOT NULL,
  `altera_senha_login` tinyint(4) NOT NULL,
  `usuario_edit` varchar(45) DEFAULT NULL,
  `data_edit` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `id_UNIQUE` (`codigo`),
  UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  KEY `codigo_perfil_idx` (`codigo_perfil`),
  CONSTRAINT `codigo_perfil` FOREIGN KEY (`codigo_perfil`) REFERENCES `home_perfil` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `home_perfil`(`codigo`,`descricao`,`ativo`)VALUES('1','Administrador','1');
INSERT INTO `home_usuario`
(`codigo`,
`usuario`,
`senha`,
`nome`,
`ativo`,
`codigo_perfil`,
`altera_senha_login`,
`usuario_edit`,
`data_edit`)
SELECT `usuario`.`id` as 'codigo',
    `usuario`.`usuario` as 'usuario',
    `usuario`.`senha` as 'senha',
    `usuario`.`nome_usuario` as 'nome',
    `usuario`.`ativo` as 'ativo',
    '1' as 'codigo_perfil',
    '0' as 'altera_senha_login',
    'tiagoc' as 'usuario_edit',
    now() as 'data_edit'
FROM `usuario`;
DROP TABLE `usuario`;

