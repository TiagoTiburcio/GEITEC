INSERT INTO `sis_geitec`.`redelocal_bloco`
(`codigo`,
`nome`,
`descricao`,
`ativo`)
SELECT `redelocal_bloco`.`codigo`,
    `redelocal_bloco`.`nome`,
    `redelocal_bloco`.`descricao`,
    `redelocal_bloco`.`ativo`
FROM `homo_sis_geitec`.`redelocal_bloco`;


INSERT INTO `sis_geitec`.`redelocal_equip_tipo`
(`codigo`,
`ativo`,
`descricao`,
`data_incl`)
SELECT `redelocal_equip_tipo`.`codigo`,
    `redelocal_equip_tipo`.`ativo`,
    `redelocal_equip_tipo`.`descricao`,
    `redelocal_equip_tipo`.`data_incl`
FROM `homo_sis_geitec`.`redelocal_equip_tipo`;


INSERT INTO `sis_geitec`.`redelocal_marca`
(`codigo`,
`descricao`,
`ativo`,
`data_incl`)
SELECT `redelocal_marca`.`codigo`,
    `redelocal_marca`.`descricao`,
    `redelocal_marca`.`ativo`,
    `redelocal_marca`.`data_incl`
FROM `homo_sis_geitec`.`redelocal_marca`;


INSERT INTO `sis_geitec`.`redelocal_modelo_switch`
(`codigo`,
`codigo_marca`,
`codigo_equip_tipo`,
`descricao`,
`ativo`,
`qtd_portas_eth`,
`qtd_portas_fc`,
`gerenciavel`,
`data_incl`,
`velocidade_padrao_portas`)
SELECT `redelocal_modelo_switch`.`codigo`,
    `redelocal_modelo_switch`.`codigo_marca`,
    `redelocal_modelo_switch`.`codigo_equip_tipo`,
    `redelocal_modelo_switch`.`descricao`,
    `redelocal_modelo_switch`.`ativo`,
    `redelocal_modelo_switch`.`qtd_portas_eth`,
    `redelocal_modelo_switch`.`qtd_portas_fc`,
    `redelocal_modelo_switch`.`gerenciavel`,
    `redelocal_modelo_switch`.`data_incl`,
    `redelocal_modelo_switch`.`velocidade_padrao_portas`
FROM `homo_sis_geitec`.`redelocal_modelo_switch`;


INSERT INTO `sis_geitec`.`redelocal_porta_switch`
(`codigo_switch`,
`codigo_porta_switch`,
`tipo_porta`,
`velocidade`,
`codigo_vlan`,
`observacao`,
`texto_tela`,
`data_alt`)
SELECT `redelocal_porta_switch`.`codigo_switch`,
    `redelocal_porta_switch`.`codigo_porta_switch`,
    `redelocal_porta_switch`.`tipo_porta`,
    `redelocal_porta_switch`.`velocidade`,
    `redelocal_porta_switch`.`codigo_vlan`,
    `redelocal_porta_switch`.`observacao`,
    `redelocal_porta_switch`.`texto_tela`,
    `redelocal_porta_switch`.`data_alt`
FROM `homo_sis_geitec`.`redelocal_porta_switch`;


INSERT INTO `sis_geitec`.`redelocal_rack`
(`codigo`,
`descricao`,
`setor`,
`codigo_bloco`)
SELECT `redelocal_rack`.`codigo`,
    `redelocal_rack`.`descricao`,
    `redelocal_rack`.`setor`,
    `redelocal_rack`.`codigo_bloco`
FROM `homo_sis_geitec`.`redelocal_rack`;


INSERT INTO `sis_geitec`.`redelocal_switch`
(`codigo`,
`codigo_modelo`,
`ip`,
`codigo_rack`,
`numero_empilhamento`,
`empilhado`,
`ativo`,
`data_incl`,
`vlan_padrao`)
SELECT `redelocal_switch`.`codigo`,
    `redelocal_switch`.`codigo_modelo`,
    `redelocal_switch`.`ip`,
    `redelocal_switch`.`codigo_rack`,
    `redelocal_switch`.`numero_empilhamento`,
    `redelocal_switch`.`empilhado`,
    `redelocal_switch`.`ativo`,
    `redelocal_switch`.`data_incl`,
    `redelocal_switch`.`vlan_padrao`
FROM `homo_sis_geitec`.`redelocal_switch`;


INSERT INTO `sis_geitec`.`redelocal_tipo_porta_sw`
(`codigo`,
`descricao`)
SELECT `redelocal_tipo_porta_sw`.`codigo`,
    `redelocal_tipo_porta_sw`.`descricao`
FROM `homo_sis_geitec`.`redelocal_tipo_porta_sw`;


INSERT INTO `sis_geitec`.`redelocal_vlan`
(`codigo`,
`nome`,
`qtd_hosts`,
`descricao`,
`rede`,
`mascara`,
`gateway`)
SELECT `redelocal_vlan`.`codigo`,
    `redelocal_vlan`.`nome`,
    `redelocal_vlan`.`qtd_hosts`,
    `redelocal_vlan`.`descricao`,
    `redelocal_vlan`.`rede`,
    `redelocal_vlan`.`mascara`,
    `redelocal_vlan`.`gateway`
FROM `homo_sis_geitec`.`redelocal_vlan`;
