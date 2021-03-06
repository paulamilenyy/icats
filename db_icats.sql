CREATE DATABASE IF NOT EXISTS DB_ICATS;
USE DB_ICATS;


--
-- Database: `db_icats`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuarios`
--

CREATE TABLE `tb_usuarios` (
  `USU_CODIGO` int(11) NOT NULL auto_increment PRIMARY KEY,
  `USU_EMAIL` varchar(45) NOT NULL,
  `USU_NOME` varchar(80) NOT NULL,
  `USU_SENHA` varchar(10) NOT NULL,
  `USU_TELEFONE` varchar(45) NOT NULL,
  `USU_FOTO` varchar(40)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_sexos`
--

CREATE TABLE `tb_sexos` (
  `SEX_CODIGO` int(11) NOT NULL auto_increment PRIMARY KEY,
  `SEX_SEXO` varchar(9) NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_sexos `
--

INSERT INTO `tb_sexos` (`SEX_CODIGO`, `SEX_SEXO`) VALUES
(1, 'Feminino'),
(2, 'Masculino');

-- --------------------------------------------------------
--
-- Estrutura da tabela `tb_gatos`
--

CREATE TABLE `tb_gatos` (
  `GAT_CODIGO` int(11) NOT NULL auto_increment PRIMARY KEY,
  `GAT_NOME` varchar(80) NOT NULL,
  `GAT_IDADE` varchar(80) NOT NULL,
  `GAT_USU_CODIGO` int(11) NOT NULL,
  `GAT_SEX_CODIGO` int(11) NOT NULL,
  `GAT_FOTO` varchar(40),
  `GAT_DESCRICAO` varchar(200) NOT NULL,
  
  CONSTRAINT FK_USUGAT FOREIGN KEY (GAT_USU_CODIGO) REFERENCES TB_USUARIOS(USU_CODIGO),
  CONSTRAINT FK_SEXGAT FOREIGN KEY (GAT_SEX_CODIGO) REFERENCES TB_SEXOS(SEX_CODIGO)

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
CREATE TABLE `tb_humores` (
  `HUM_CODIGO` int(11) NOT NULL auto_increment PRIMARY KEY,
  `HUM_HUMOR` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_humores`
--

INSERT INTO `tb_humores` (`HUM_CODIGO`, `HUM_HUMOR`) VALUES
(1, 'Sonolento'),
(2, 'Triste'),
(3, 'Estressado'),
(4, 'Apavorado'),
(5, 'Animado'),
(6, 'Alerta');

-- --------------------------------------------------------
--
-- Estrutura da tabela `tb_estado_saude`
--

CREATE TABLE `tb_est_saude` (
  `EST_CODIGO` int(11) NOT NULL auto_increment PRIMARY KEY,
  `EST_GAT_CODIGO` int(11) NOT NULL,
  `EST_HUM_CODIGO` int(11) NOT NULL,
  `EST_DATA` date NOT NULL,
  `EST_PESO` int(11) NOT NULL,

  CONSTRAINT FK_GATEST FOREIGN KEY (EST_GAT_CODIGO) REFERENCES TB_GATOS(GAT_CODIGO),
  CONSTRAINT FK_HUMEST FOREIGN KEY (EST_HUM_CODIGO) REFERENCES TB_HUMORES(HUM_CODIGO)

) ENGINE=InnoDB DEFAULT CHARSET=latin1;