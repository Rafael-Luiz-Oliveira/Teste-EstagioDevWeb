use teste_desenv_q1;

show tables;

SELECT 
    c.nome_cliente,                    
    c.cpf_cliente,                     
    c.rg_cliente,                      
    c.telmask_cliente,    
    c.email_cliente,                    
    f.url_foto,          
    COUNT(co.id_compra) AS qtd_compras 
FROM clientes c
LEFT JOIN clientes_fotos f 
    ON f.fk_id_cliente_clientes = c.id_cliente
    AND f.ordem_foto = 1                
LEFT JOIN compras co 
    ON co.fk_id_cliente_clientes = c.id_cliente
    AND co.sel_status_compra = 'concluido'  
GROUP BY 
    c.id_cliente, c.nome_cliente, c.cpf_cliente, c.rg_cliente, c.telmask_cliente, c.email_cliente, f.url_foto
ORDER BY c.nome_cliente;
