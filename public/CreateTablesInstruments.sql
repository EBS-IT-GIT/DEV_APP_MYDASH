/*
   Tabelas Gestão de Equipamentos AutoLab Industrial
   Desenvolvido por MRI Tecnologia Eletrônica
   Versão para Oracle Server
   ATENÇÃO: Antes de executar este script deve ser executado o script CreateTablesMRI.sql
   Alterações:
   Migração: 05/08/2020
   Modificado: 02/10/2020 alterou campos local_inst e owner_inst de 32 para 64 caracters
*/
CREATE TABLE INSTRUMENTS_REG_INST
(
    ID_INST  		INTEGER      NOT NULL, 			
    COMPANY			INTEGER      NOT NULL,        
    CODE_INST  		VARCHAR(32)  NOT NULL,		
	NAME_INST 		VARCHAR(32)  NOT NULL,		
		
	SERIAL_NUM  	VARCHAR(32),				
	TYPE_INST		INTEGER NOT NULL,				
	MANUF_INST		VARCHAR(32),				
	MODEL_INST		VARCHAR(32),					
	
	LOCAL_INST		VARCHAR(64),				   
	OWNER_INST		VARCHAR(64),					
	
	TYPE_VER		VARCHAR(16),					
	DATE_NEXT_VER	DATE,					
	FREQ_NEXT_VER	INTEGER,     					
	INTER_NEXT_VER	VARCHAR(16),					
	
	TYPE_CAL		VARCHAR(16),					
	DATE_NEXT_CAL	DATE,						
	FREQ_NEXT_CAL	INTEGER,					
	INTER_NEXT_CAL	VARCHAR(16),					
	
	TYPE_MAN		VARCHAR(16),				
	DATE_NEXT_MAN	DATE,					
	FREQ_NEXT_MAN	INTEGER,					
	INTER_NEXT_MAN	VARCHAR(16),				   
	
	UNIT_MEAS		VARCHAR(32),				
	QUANT_MEAS		VARCHAR(32),
	CREATE_DATE		DATE,
	NOTES       	VARCHAR(32),				
	STATUS_INST 	VARCHAR(32),	           
	CANCELED	 	CHAR(1) DEFAULT 'N' NOT NULL,	
    PRIMARY KEY	(ID_INST, COMPANY)
);
CREATE TABLE VER_REG_INST
(
    ID_VER			INTEGER      NOT NULL, 			
	COMPANY			INTEGER      NOT NULL,   	   
	CODE_VER  		VARCHAR(32)  NOT NULL, 			
	
	LAB_VER 		VARCHAR(32)   NOT NULL,		  
	ID_ANALYZER		NUMBER(16,0) NOT NULL,			
	
	DATE_VER		DATE  NOT NULL,				
	DATE_INSERT		DATE  NOT NULL,				
	
	CONCLUSION_VER	VARCHAR(32),				
	ID_ALLEGATION	INTEGER,						
	STATUS_VER		VARCHAR(32),								
	CANCELED	 	CHAR(1) DEFAULT 'N' NOT NULL,   
	ID_INST			INTEGER NOT NULL,				
    PRIMARY KEY	(ID_VER, COMPANY),	
	CONSTRAINT FK_ID_INST_VER 
		FOREIGN KEY  (ID_INST, COMPANY) 
		REFERENCES  INSTRUMENTS_REG_INST(ID_INST, COMPANY) 
);
CREATE TABLE CAL_REG_INST
(
    ID_CAL			INTEGER NOT NULL, 			    
	COMPANY			INTEGER NOT NULL,           
	CODE_CAL  		VARCHAR(32)  NOT NULL, 			
	
	LAB_CAL 		VARCHAR(32)  NOT NULL,		   
	ID_ANALYZER		NUMBER(16,0) NOT NULL,			
	
	DATE_CAL		DATE NOT NULL,				
	DATE_INSERT		DATE NOT NULL,			
	
	RANGE_CAL		VARCHAR(32),					
	RESOLUTION_CAL	VARCHAR(32),					
	CLASS_CAL		VARCHAR(32),			
	POINTS_CAL		VARCHAR(32),				
	UNIT_CAL		VARCHAR(32),				
								
	AMB_TEMP_CAL	VARCHAR(32),				
	AMB_UMI_CAL		VARCHAR(32),					
	AMB_PRESS_CAL	VARCHAR(32),					
	AMB_MASS_CAL	VARCHAR(32),				
	
	STD_TRACE_CAL	VARCHAR(32),					
	
	FILE_PATH_CAL	VARCHAR(128),				
	IMG_PATH_CAL	VARCHAR(64),					
	
	CONCLUSION_CAL	VARCHAR(32),					
	STATUS_CAL		VARCHAR(32),					
	ID_INST			INTEGER NOT NULL,				
	CANCELED	 	CHAR(1) DEFAULT 'N' NOT NULL,   
    PRIMARY KEY	(ID_CAL, COMPANY),		
	
	CONSTRAINT FK_ID_INST_CAL 
		FOREIGN KEY  (ID_INST, COMPANY) 
		REFERENCES  INSTRUMENTS_REG_INST(ID_INST, COMPANY)   
);
CREATE TABLE MOV_REG_INST
(
    ID_MOV			INTEGER NOT NULL, 				
	COMPANY			INTEGER NOT NULL,           	
	CODE_MOV  		VARCHAR(32)  NOT NULL, 			
		
	TYPE_MOV		VARCHAR(32) NOT NULL,			
		
	ORI_MOV 		VARCHAR(32)  NOT NULL,			
	DEST_MOV		VARCHAR(32)  NOT NULL,			
		
	DATE_MOV		DATE  NOT NULL,					
	DATE_PREV_RET	DATE  NOT NULL,				
	DATE_REG_MOV	DATE  NOT NULL,				
		
	STAT_INST_ATU 	VARCHAR(32)  NOT NULL,		
	STAT_INST_NEW 	VARCHAR(32)  NOT NULL,			
		
	OBS_MOV			VARCHAR(32),					
		
	STATUS_MOV		VARCHAR(16),													   
	ID_INST			INTEGER NOT NULL,				
	CANCELED	 	CHAR(1) DEFAULT 'N' NOT NULL, 	
    PRIMARY KEY	(ID_MOV, COMPANY),	
	CONSTRAINT FK_ID_INST_MOV 
		FOREIGN KEY  (ID_INST, COMPANY) 
		REFERENCES  INSTRUMENTS_REG_INST(ID_INST, COMPANY)  
);
CREATE TABLE MAIN_REG_INST
(
    ID_MAIN			INTEGER NOT NULL, 				
	COMPANY			INTEGER NOT NULL,           
	CODE_MAIN  		VARCHAR(32)  NOT NULL, 			
	
	TYPE_MAIN		VARCHAR(32) NOT NULL,	
	
	SUP_MAIN 		VARCHAR(32)  NOT NULL,		
	
	DATE_MAIN		DATE  NOT NULL,				
	DATE_REG_MAIN	DATE  NOT NULL,					
	
	STAT_INST_ATU 	VARCHAR(32)  NOT NULL,			
	STAT_INST_NEW 	VARCHAR(32)  NOT NULL,			
	
	NUM_OS_MAIN		VARCHAR(32),				
	NUM_ORC_MAIN	VARCHAR(32),					
	
	OBS_MAIN		VARCHAR(32),					
	
	STATUS_MAIN		VARCHAR(32),												
	ID_INST			INTEGER NOT NULL,				
	CANCELED	 	CHAR(1) DEFAULT 'N' NOT NULL,  		
    PRIMARY KEY	(ID_MAIN, COMPANY),	
	CONSTRAINT FK_ID_INST_MAIN 
		FOREIGN KEY  (ID_INST, COMPANY) 
		REFERENCES  INSTRUMENTS_REG_INST(ID_INST, COMPANY)   
);

CREATE TABLE TYPE_REG_INST
(
	ID_TYPE_INST 		INTEGER  NOT NULL, 			
	COMPANY			    INTEGER NOT NULL,           	
	NAME_TYPE_INST		VARCHAR(32) NOT NULL,																		 
	DATE_REG_TYPE_INST	DATE  NOT NULL,				
	STATUS_TYPE_INST  	VARCHAR(32) ,
	CANCELED	 		CHAR(1) DEFAULT 'N' NOT NULL,  	
    PRIMARY KEY	(ID_TYPE_INST, COMPANY)	
);

CREATE TABLE VAR_RESULT_INST
(
	ID_VAR_RES		INTEGER NOT NULL, 			
	COMPANY			INTEGER NOT NULL,       
	NAME_VAR_RES	VARCHAR(32) NOT NULL,		
	DESC_VAR_RES	VARCHAR(32),				
	CANCELED	 	CHAR(1) DEFAULT 'N' NOT NULL,
    PRIMARY KEY	(ID_VAR_RES, COMPANY)		
);
CREATE TABLE TRIALS_REG_INST 
(
    ID_TRIAL 			INTEGER NOT NULL,				
	COMPANY			    INTEGER NOT NULL,           	
	ID_TYPE_INST		INTEGER NOT NULL,				
	ID_GROUP_TRIAL		INTEGER NOT NULL,			
		
	TYPE_TRIAL			VARCHAR(32) NOT NULL,		
	
	VALUE_TRIAL			VARCHAR(32) NOT NULL,			
	VAR_RESULT			VARCHAR(32) NOT NULL,			

	MAX_RESULT			VARCHAR(32),					
	MIN_RESULT			VARCHAR(32),				
	MAX_BLOCK_RESULT	VARCHAR(32),					
	MIN_BLOCK_RESULT	VARCHAR(32),			
	CANCELED	 		CHAR(1) DEFAULT 'N' NOT NULL,
    PRIMARY KEY	(ID_TRIAL, COMPANY)																																   
);
CREATE TABLE RESULTS_REG_INST 
(
    ID_RESULT 			INTEGER NOT NULL,				
	COMPANY			    INTEGER NOT NULL,           	
		
	ID_GROUP_RESULT		INTEGER NOT NULL,				
		
	TYPE_RESULT			VARCHAR(32) NOT NULL,	
	ID_PROCESS			INTEGER NOT NULL,			
	
	LAB_RESULT			VARCHAR(32) NOT NULL,		
	ID_ANALYZER			NUMBER(16,0) NOT NULL,		
		
	DATE_RESULT			DATE NOT NULL,				
	VALUE_RESULT		VARCHAR(32) NOT NULL,			
	VAR_RESULT			VARCHAR(32) NOT NULL,		
	MODO_RESULT			VARCHAR(32),					
	ID_INST				INTEGER NOT NULL,
	ID_ALLEGATION		INTEGER,
	CANCELED	 	CHAR(1) DEFAULT 'N' NOT NULL,     
    PRIMARY KEY	(ID_RESULT, COMPANY),		
	CONSTRAINT FK_ID_INST_RESULT 
		FOREIGN KEY  (ID_INST, COMPANY) 
		REFERENCES  INSTRUMENTS_REG_INST(ID_INST, COMPANY)   
);

INSERT INTO VAR_RESULT_INST (ID_VAR_RES, NAME_VAR_RES, DESC_VAR_RES,COMPANY) VALUES (0, 'Referência', NULL,0);
INSERT INTO VAR_RESULT_INST (ID_VAR_RES, NAME_VAR_RES, DESC_VAR_RES,COMPANY) VALUES (1, 'Valor', 'Quando automatico vem do TRD',0);
INSERT INTO VAR_RESULT_INST (ID_VAR_RES, NAME_VAR_RES, DESC_VAR_RES,COMPANY) VALUES (2, 'Erro', NULL,0);
INSERT INTO VAR_RESULT_INST (ID_VAR_RES, NAME_VAR_RES, DESC_VAR_RES,COMPANY) VALUES (3, 'Média', NULL,0);
INSERT INTO VAR_RESULT_INST (ID_VAR_RES, NAME_VAR_RES, DESC_VAR_RES,COMPANY) VALUES (4, 'Desvio Padrão', NULL,0);
INSERT INTO VAR_RESULT_INST (ID_VAR_RES, NAME_VAR_RES, DESC_VAR_RES,COMPANY) VALUES (5, 'Incerteza', NULL,0);
INSERT INTO VAR_RESULT_INST (ID_VAR_RES, NAME_VAR_RES, DESC_VAR_RES,COMPANY) VALUES (6, 'Fator', NULL,0);