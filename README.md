Script de criaçao da tabela no MySQL:
CREATE TABLE `orcamento`.`orcamento_oficina` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cliente` VARCHAR(100) NOT NULL,
  `dta_hora_orcamento` DATETIME NOT NULL,
  `vendedor` VARCHAR(100) NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `valor_orcado` DECIMAL(18,2) NOT NULL,
  PRIMARY KEY (`id`));
