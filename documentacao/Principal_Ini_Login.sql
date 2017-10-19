SELECT 
	 u.codigo as u_codigo
	,u.usuario as u_usuario
    ,u.senha as u_senha
    ,u.nome as u_nome
    ,u.ativo as u_ativo
    ,pe.codigo as pe_codigo
    ,pe.descricao as pe_descricao
    ,pe.ativo as pe_ativo
    ,pa.codigo as pa_codigo
    ,pa.descricao as pa_codigo
    ,pa.caminho as pa_caminho
    ,pa.ativo as pa_ativo
    ,m.codigo as m_codigo
    ,m.descricao as m_descricao
    ,m.ativo as m_ativo
FROM home_usuario as u 
	join home_perfil as pe on pe.codigo = u.codigo_perfil
	join home_pagina_perfil as pape on pape.codigo_perfil = pe.codigo
	join home_pagina as pa on pape.codigo_pagina = pa.codigo
	join home_modulo as m on pa.codigo_modulo =  m.codigo
where usuario = 'tiagoc' and u.ativo = '1' and pe.ativo = '1' and pa.ativo = '1' and m.ativo = '1';