set define off;
--
DROP MATERIALIZED VIEW APPS.SAE_GL_RAZAO_FINANCEIRO_MV;
--
CREATE MATERIALIZED VIEW SAE_GL_RAZAO_FINANCEIRO_MV 
LOGGING 
TABLESPACE APPS_TS_TX_DATA 
PCTFREE 10 
INITRANS 1 
STORAGE 
( 
  INITIAL 65536 
  NEXT 1048576 
  MINEXTENTS 1 
  MAXEXTENTS UNLIMITED 
  BUFFER_POOL DEFAULT 
) 
NOCOMPRESS 
NO INMEMORY 
NOCACHE 
NOPARALLEL 
USING INDEX 
REFRESH START WITH TO_DATE('23-04-2020 05:00:00', 'DD-MM-YYYY HH24:MI:SS') 
NEXT sysdate + 1    
COMPLETE 
USING DEFAULT LOCAL ROLLBACK SEGMENT 
DISABLE QUERY REWRITE AS 
SELECT *
FROM APPS.SAE_GL_RAZAO_FINANCEIRO_V v
WHERE v.DATA_EFETIVA_CONTAB >=to_date('01/01/2019','DD/MM/YYYY');
--
COMMENT ON MATERIALIZED VIEW SAE_GL_RAZAO_FINANCEIRO_MV IS 'snapshot table for snapshot APPS.SAE_GL_RAZAO_FINANCEIRO_MV';
--
CREATE INDEX SAE_GL_RAZAO_FIN_MV_IN1 ON SAE_GL_RAZAO_FINANCEIRO_MV (CENTRO_CUSTO, CONTA_ORCAMENTARIA, PROGRAMA)
LOGGING 
TABLESPACE APPS_TS_TX_DATA 
PCTFREE 10 
INITRANS 2 
STORAGE 
( 
  INITIAL 65536 
  NEXT 1048576 
  MINEXTENTS 1 
  MAXEXTENTS UNLIMITED 
  BUFFER_POOL DEFAULT 
) 
NOPARALLEL;
--
CREATE INDEX SAE_GL_RAZAO_FIN_MV_IN2 ON SAE_GL_RAZAO_FINANCEIRO_MV (PERIODO)
LOGGING 
TABLESPACE APPS_TS_TX_DATA 
PCTFREE 10 
INITRANS 2 
STORAGE 
( 
  INITIAL 65536 
  NEXT 1048576 
  MINEXTENTS 1 
  MAXEXTENTS UNLIMITED 
  BUFFER_POOL DEFAULT 
) 
NOPARALLEL;
--
CREATE INDEX SAE_GL_RAZAO_FIN_MV_IN3 ON SAE_GL_RAZAO_FINANCEIRO_MV (DATA_EFETIVA_CONTAB)
LOGGING 
TABLESPACE APPS_TS_TX_DATA 
PCTFREE 10 
INITRANS 2 
STORAGE 
( 
  INITIAL 65536 
  NEXT 1048576 
  MINEXTENTS 1 
  MAXEXTENTS UNLIMITED 
  BUFFER_POOL DEFAULT 
) 
NOPARALLEL;
--
GRANT SELECT ON APPS.SAE_GL_RAZAO_FINANCEIRO_MV TO SOFTEXPERT;
GRANT SELECT ON APPS.SAE_GL_RAZAO_FINANCEIRO_MV TO APPS_CONSULT;
--
