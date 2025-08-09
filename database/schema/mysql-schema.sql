/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `almacenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `almacenes` (
  `regcve` int(11) NOT NULL,
  `unicve` int(11) NOT NULL,
  `almcve` int(11) NOT NULL,
  `almnom` varchar(65) NOT NULL,
  `almcnt` int(11) NOT NULL,
  `sucursal` varchar(45) NOT NULL,
  `uninom` varchar(65) NOT NULL,
  `tipo` enum('almacen','uo','sucursal','central') NOT NULL DEFAULT 'almacen',
  PRIMARY KEY (`regcve`,`unicve`,`almcve`),
  KEY `almcnt` (`almcnt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos` (
  `id` bigint(20) NOT NULL,
  `almcnt` int(11) NOT NULL DEFAULT 1,
  `artcve` varchar(255) DEFAULT NULL,
  `artdesc` varchar(255) DEFAULT NULL,
  `prvcve` int(11) NOT NULL DEFAULT 1,
  `artstatus` varchar(2) NOT NULL DEFAULT 'A',
  `category_id` int(11) NOT NULL DEFAULT 1,
  `codbarras` varchar(25) DEFAULT NULL,
  `artmarca` varchar(255) DEFAULT NULL,
  `artestilo` varchar(255) DEFAULT NULL,
  `artcolor` varchar(255) DEFAULT NULL,
  `artseccion` varchar(255) DEFAULT NULL,
  `arttalla` varchar(255) DEFAULT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT 0,
  `artimg` varchar(255) NOT NULL DEFAULT 'imagen.jpg',
  `artprcosto` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `artprventa` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `artpesogrm` varchar(6) NOT NULL DEFAULT '1',
  `artpesoum` varchar(25) NOT NULL DEFAULT 'PZA',
  `artganancia` smallint(6) NOT NULL DEFAULT 0,
  `eximin` smallint(6) NOT NULL DEFAULT 0,
  `eximax` smallint(6) NOT NULL DEFAULT 0,
  `artdetalle` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `avances_indicadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avances_indicadores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `indicador_id` bigint(20) unsigned NOT NULL,
  `almcnt` int(11) NOT NULL,
  `anio` smallint(6) NOT NULL,
  `mes` tinyint(4) NOT NULL CHECK (`mes` between 1 and 12),
  `avance_ventas` decimal(12,2) DEFAULT NULL,
  `avance_toneladas` decimal(12,2) DEFAULT NULL,
  `avance_tiendas` int(11) DEFAULT NULL,
  `avance_personas` int(11) DEFAULT NULL,
  `avance_porcentaje` decimal(5,2) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `almcnt` (`almcnt`),
  CONSTRAINT `avances_indicadores_ibfk_1` FOREIGN KEY (`indicador_id`) REFERENCES `indicadores_pat` (`id`) ON DELETE CASCADE,
  CONSTRAINT `avances_indicadores_ibfk_2` FOREIGN KEY (`almcnt`) REFERENCES `almacenes` (`almcnt`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` bigint(20) unsigned NOT NULL,
  `ctenom` varchar(255) NOT NULL,
  `cterfc` varchar(13) DEFAULT NULL,
  `ctecp` varchar(5) DEFAULT NULL,
  `ctereg` varchar(255) DEFAULT NULL,
  `ctedir` varchar(255) DEFAULT NULL,
  `cteemail` varchar(65) DEFAULT NULL,
  `ctetel` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clientes_ctenom_unique` (`ctenom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `codigos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `codigos` (
  `id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `codigo` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigos_codigo_unique` (`codigo`),
  KEY `codigos_product_id_foreign` (`product_id`),
  CONSTRAINT `codigos_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `directorio_tiendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directorio_tiendas` (
  `regcve` int(2) DEFAULT NULL,
  `sucursal` varchar(29) DEFAULT NULL,
  `unicve` int(1) DEFAULT NULL,
  `uninom` varchar(12) DEFAULT NULL,
  `alm` int(2) DEFAULT NULL,
  `almacen` varchar(34) DEFAULT NULL,
  `almcve` int(4) DEFAULT NULL,
  `edo` int(2) DEFAULT NULL,
  `estado` varchar(19) DEFAULT NULL,
  `mpio` int(3) DEFAULT NULL,
  `municipio` varchar(75) DEFAULT NULL,
  `loc` int(3) DEFAULT NULL,
  `localidad` varchar(68) DEFAULT NULL,
  `bcrp` varchar(47) DEFAULT NULL,
  `Latitud` varchar(17) DEFAULT NULL,
  `Longitud` varchar(17) DEFAULT NULL,
  `canal` int(2) DEFAULT NULL,
  `No_Tienda_Actual` int(3) DEFAULT NULL,
  `No_Tienda_Ori` int(3) DEFAULT NULL,
  `Fecha_Apertura` varchar(10) DEFAULT NULL,
  `Fecha_Autoriza` varchar(10) DEFAULT NULL,
  `Oficio_Autoriza` varchar(20) DEFAULT NULL,
  `Fecha_Autoriza_Consejo` varchar(10) DEFAULT NULL,
  `Oficio_Autoriza_Consejo` varchar(18) DEFAULT NULL,
  `Direccion` varchar(96) DEFAULT NULL,
  `Encargado` varchar(39) DEFAULT NULL,
  `Enc_Sexo` varchar(1) DEFAULT NULL,
  `Enc_FecNac` varchar(10) DEFAULT NULL,
  `Pagare_Monto` decimal(8,2) DEFAULT NULL,
  `Impuestos` decimal(7,2) DEFAULT NULL,
  `Pagare_Fecha` varchar(10) DEFAULT NULL,
  `Cap_Com` decimal(9,2) DEFAULT NULL,
  `Cap_Dic` decimal(8,2) DEFAULT NULL,
  `Cap_Tot` decimal(9,2) DEFAULT NULL,
  `Fecha_Pos` varchar(10) DEFAULT NULL,
  `PedRIT` varchar(1) DEFAULT NULL,
  `Rt_Sup` int(1) DEFAULT NULL,
  `Nom_Sup` varchar(36) DEFAULT NULL,
  `Tipo_Loc` varchar(4) DEFAULT NULL,
  `Energia` varchar(1) DEFAULT NULL,
  `Opc_Unica` varchar(1) DEFAULT NULL,
  `Otrs_Tdas` int(2) DEFAULT NULL,
  `Nva_Imag` varchar(1) DEFAULT NULL,
  `M2AVenta` int(3) DEFAULT NULL,
  `M2Bodega` int(3) DEFAULT NULL,
  `M2Fachada` int(3) DEFAULT NULL,
  `Movimiento` varchar(10) DEFAULT NULL,
  `Fech_Mov_Reap` varchar(10) DEFAULT NULL,
  `Mot_Reaper` varchar(24) DEFAULT NULL,
  `Fch_Audit` varchar(10) DEFAULT NULL,
  `Imp_Res_Audi_Mes` decimal(9,2) DEFAULT NULL,
  `Audit_Realiza_Mes` int(1) DEFAULT NULL,
  `Audit_Acum_Tot` int(2) DEFAULT NULL,
  `Audit_Progra_Mes` int(1) DEFAULT NULL,
  `Audit_Obs` varchar(80) DEFAULT NULL,
  `Asam_Fec` varchar(10) DEFAULT NULL,
  `Asam_Real_Mes` int(1) DEFAULT NULL,
  `Asam_Acum_Tot` int(2) DEFAULT NULL,
  `Asam_Prog_Mes` int(1) DEFAULT NULL,
  `Asam_Tipo` varchar(14) DEFAULT NULL,
  `Asam_AsisT` int(3) DEFAULT NULL,
  `Asam_Observa` varchar(80) DEFAULT NULL,
  `TELEFONIA` varchar(1) DEFAULT NULL,
  `CORREO` varchar(1) DEFAULT NULL,
  `anuncios` varchar(1) DEFAULT NULL,
  `CARNICERIA` varchar(1) DEFAULT NULL,
  `venas` varchar(1) DEFAULT NULL,
  `radio` varchar(1) DEFAULT NULL,
  `servicios` varchar(1) DEFAULT NULL,
  `entrega` varchar(1) DEFAULT NULL,
  `internet` varchar(1) DEFAULT NULL,
  `acopio` varchar(1) DEFAULT NULL,
  `Otro` varchar(2) DEFAULT NULL,
  `Acti_realizados` int(2) DEFAULT NULL,
  `Acti_observa` varchar(80) DEFAULT NULL,
  `Nom_Pre_CRA` varchar(63) DEFAULT NULL,
  `Nom_Pre_Sup_CRA` varchar(59) DEFAULT NULL,
  `Nom_Sec_CRA` varchar(59) DEFAULT NULL,
  `Nom_Sec_Sup_CRA` varchar(60) DEFAULT NULL,
  `Nom_Tes_CRA` varchar(60) DEFAULT NULL,
  `Nom_Vcv_CRA` varchar(60) DEFAULT NULL,
  `Nom_Voc_Gen_CRA` varchar(60) DEFAULT NULL,
  `Fec_CRA` varchar(10) DEFAULT NULL,
  `Vigencia` varchar(10) DEFAULT NULL,
  `Nom_Rep_Con` varchar(36) DEFAULT NULL,
  `Cargo_Rep_Con` varchar(32) DEFAULT NULL,
  `Rep_Estatal` varchar(1) DEFAULT NULL,
  `Rep_Nacional` varchar(7) DEFAULT NULL,
  `Vta_Mes` decimal(8,2) DEFAULT NULL,
  `Bon_Mes` decimal(7,2) DEFAULT NULL,
  `IVA_Mes` decimal(7,2) DEFAULT NULL,
  `VtaNeta_Mes` decimal(8,2) DEFAULT NULL,
  `Vta_Acu` decimal(9,2) DEFAULT NULL,
  `Bon_Acu` decimal(8,2) DEFAULT NULL,
  `IVA_Acu` decimal(8,2) DEFAULT NULL,
  `VtaNeta_Acu` decimal(9,2) DEFAULT NULL,
  `Vta_Mes_Maiz` int(6) DEFAULT NULL,
  `Bon_Mes_Maiz` decimal(7,2) DEFAULT NULL,
  `IVA_Mes_Maiz` int(4) DEFAULT NULL,
  `VtaNeta_Mes_Maiz` decimal(8,2) DEFAULT NULL,
  `Vta_Acu_Maiz` decimal(8,1) DEFAULT NULL,
  `Bon_Acu_Maiz` decimal(8,2) DEFAULT NULL,
  `IVA_Acu_Maiz` int(6) DEFAULT NULL,
  `VtaNeta_Acu_Maiz` decimal(9,2) DEFAULT NULL,
  `Vta_Mes_MaizK` int(5) DEFAULT NULL,
  `Vta_Acu_MaizK` varchar(6) DEFAULT NULL,
  `U_SERV` varchar(1) DEFAULT NULL,
  `OBJ` varchar(1) DEFAULT NULL,
  `IND` varchar(1) DEFAULT NULL,
  `MIDH` varchar(1) DEFAULT NULL,
  `cien` varchar(4) DEFAULT NULL,
  `GDOMARG` varchar(8) DEFAULT NULL,
  `POBLACION` varchar(6) DEFAULT NULL,
  `Fachada` varchar(1) DEFAULT NULL,
  `placa` varchar(1) DEFAULT NULL,
  `vivir` varchar(1) DEFAULT NULL,
  `imagen` varchar(1) DEFAULT NULL,
  `buena` varchar(1) DEFAULT NULL,
  `programas` varchar(1) DEFAULT NULL,
  `corresponsal` varchar(1) DEFAULT NULL,
  `vende` varchar(1) DEFAULT NULL,
  `Mostrador` varchar(1) DEFAULT NULL,
  `Estanteria` varchar(1) DEFAULT NULL,
  `bascula` varchar(1) DEFAULT NULL,
  `rebanadora` varchar(1) DEFAULT NULL,
  `refrigerador` varchar(1) DEFAULT NULL,
  `Senal` varchar(7) DEFAULT NULL,
  `compania` varchar(8) DEFAULT NULL,
  `sistema` varchar(1) DEFAULT NULL,
  `piso` varchar(1) DEFAULT NULL,
  `pered` varchar(1) DEFAULT NULL,
  `techo` varchar(1) DEFAULT NULL,
  `cancelari` varchar(1) DEFAULT NULL,
  `iluminacion` varchar(1) DEFAULT NULL,
  `huevo` varchar(4) DEFAULT NULL,
  `year` smallint(6) DEFAULT NULL,
  `mes` smallint(6) DEFAULT NULL,
  `clave_localidad` int(9) DEFAULT NULL,
  KEY `clave_localidad` (`clave_localidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `directorio_tiendas_ant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directorio_tiendas_ant` (
  `regcve` int(2) DEFAULT NULL,
  `sucursal` varchar(29) DEFAULT NULL,
  `unicve` int(1) DEFAULT NULL,
  `uninom` varchar(12) DEFAULT NULL,
  `alm` int(2) DEFAULT NULL,
  `almacen` varchar(34) DEFAULT NULL,
  `almcve` int(4) DEFAULT NULL,
  `edo` int(2) DEFAULT NULL,
  `estado` varchar(19) DEFAULT NULL,
  `mpio` int(3) DEFAULT NULL,
  `municipio` varchar(75) DEFAULT NULL,
  `loc` int(3) DEFAULT NULL,
  `localidad` varchar(68) DEFAULT NULL,
  `bcrp` varchar(47) DEFAULT NULL,
  `Latitud` varchar(17) DEFAULT NULL,
  `Longitud` varchar(17) DEFAULT NULL,
  `canal` int(2) DEFAULT NULL,
  `No_Tienda_Actual` int(3) DEFAULT NULL,
  `No_Tienda_Ori` int(3) DEFAULT NULL,
  `Fecha_Apertura` varchar(10) DEFAULT NULL,
  `Fecha_Autoriza` varchar(10) DEFAULT NULL,
  `Oficio_Autoriza` varchar(20) DEFAULT NULL,
  `Fecha_Autoriza_Consejo` varchar(10) DEFAULT NULL,
  `Oficio_Autoriza_Consejo` varchar(18) DEFAULT NULL,
  `Direccion` varchar(96) DEFAULT NULL,
  `Encargado` varchar(39) DEFAULT NULL,
  `Enc_Sexo` varchar(1) DEFAULT NULL,
  `Enc_FecNac` varchar(10) DEFAULT NULL,
  `Pagare_Monto` decimal(8,2) DEFAULT NULL,
  `Impuestos` decimal(7,2) DEFAULT NULL,
  `Pagare_Fecha` varchar(10) DEFAULT NULL,
  `Cap_Com` decimal(9,2) DEFAULT NULL,
  `Cap_Dic` decimal(8,2) DEFAULT NULL,
  `Cap_Tot` decimal(9,2) DEFAULT NULL,
  `Fecha_Pos` varchar(10) DEFAULT NULL,
  `PedRIT` varchar(1) DEFAULT NULL,
  `Rt_Sup` int(1) DEFAULT NULL,
  `Nom_Sup` varchar(36) DEFAULT NULL,
  `Tipo_Loc` varchar(4) DEFAULT NULL,
  `Energia` varchar(1) DEFAULT NULL,
  `Opc_Unica` varchar(1) DEFAULT NULL,
  `Otrs_Tdas` int(2) DEFAULT NULL,
  `Nva_Imag` varchar(1) DEFAULT NULL,
  `M2AVenta` int(3) DEFAULT NULL,
  `M2Bodega` int(3) DEFAULT NULL,
  `M2Fachada` int(3) DEFAULT NULL,
  `Movimiento` varchar(10) DEFAULT NULL,
  `Fech_Mov_Reap` varchar(10) DEFAULT NULL,
  `Mot_Reaper` varchar(24) DEFAULT NULL,
  `Fch_Audit` varchar(10) DEFAULT NULL,
  `Imp_Res_Audi_Mes` decimal(9,2) DEFAULT NULL,
  `Audit_Realiza_Mes` int(1) DEFAULT NULL,
  `Audit_Acum_Tot` int(2) DEFAULT NULL,
  `Audit_Progra_Mes` int(1) DEFAULT NULL,
  `Audit_Obs` varchar(80) DEFAULT NULL,
  `Asam_Fec` varchar(10) DEFAULT NULL,
  `Asam_Real_Mes` int(1) DEFAULT NULL,
  `Asam_Acum_Tot` int(2) DEFAULT NULL,
  `Asam_Prog_Mes` int(1) DEFAULT NULL,
  `Asam_Tipo` varchar(14) DEFAULT NULL,
  `Asam_AsisT` int(3) DEFAULT NULL,
  `Asam_Observa` varchar(80) DEFAULT NULL,
  `TELEFONIA` varchar(1) DEFAULT NULL,
  `CORREO` varchar(1) DEFAULT NULL,
  `anuncios` varchar(1) DEFAULT NULL,
  `CARNICERIA` varchar(1) DEFAULT NULL,
  `venas` varchar(1) DEFAULT NULL,
  `radio` varchar(1) DEFAULT NULL,
  `servicios` varchar(1) DEFAULT NULL,
  `entrega` varchar(1) DEFAULT NULL,
  `internet` varchar(1) DEFAULT NULL,
  `acopio` varchar(1) DEFAULT NULL,
  `Otro` varchar(2) DEFAULT NULL,
  `Acti_realizados` int(2) DEFAULT NULL,
  `Acti_observa` varchar(80) DEFAULT NULL,
  `Nom_Pre_CRA` varchar(63) DEFAULT NULL,
  `Nom_Pre_Sup_CRA` varchar(59) DEFAULT NULL,
  `Nom_Sec_CRA` varchar(59) DEFAULT NULL,
  `Nom_Sec_Sup_CRA` varchar(60) DEFAULT NULL,
  `Nom_Tes_CRA` varchar(60) DEFAULT NULL,
  `Nom_Vcv_CRA` varchar(60) DEFAULT NULL,
  `Nom_Voc_Gen_CRA` varchar(60) DEFAULT NULL,
  `Fec_CRA` varchar(10) DEFAULT NULL,
  `Vigencia` varchar(10) DEFAULT NULL,
  `Nom_Rep_Con` varchar(36) DEFAULT NULL,
  `Cargo_Rep_Con` varchar(32) DEFAULT NULL,
  `Rep_Estatal` varchar(1) DEFAULT NULL,
  `Rep_Nacional` varchar(7) DEFAULT NULL,
  `Vta_Mes` decimal(8,2) DEFAULT NULL,
  `Bon_Mes` decimal(7,2) DEFAULT NULL,
  `IVA_Mes` decimal(7,2) DEFAULT NULL,
  `VtaNeta_Mes` decimal(8,2) DEFAULT NULL,
  `Vta_Acu` decimal(9,2) DEFAULT NULL,
  `Bon_Acu` decimal(8,2) DEFAULT NULL,
  `IVA_Acu` decimal(8,2) DEFAULT NULL,
  `VtaNeta_Acu` decimal(9,2) DEFAULT NULL,
  `Vta_Mes_Maiz` int(6) DEFAULT NULL,
  `Bon_Mes_Maiz` decimal(7,2) DEFAULT NULL,
  `IVA_Mes_Maiz` int(4) DEFAULT NULL,
  `VtaNeta_Mes_Maiz` decimal(8,2) DEFAULT NULL,
  `Vta_Acu_Maiz` decimal(8,1) DEFAULT NULL,
  `Bon_Acu_Maiz` decimal(8,2) DEFAULT NULL,
  `IVA_Acu_Maiz` int(6) DEFAULT NULL,
  `VtaNeta_Acu_Maiz` decimal(9,2) DEFAULT NULL,
  `Vta_Mes_MaizK` int(5) DEFAULT NULL,
  `Vta_Acu_MaizK` varchar(6) DEFAULT NULL,
  `U_SERV` varchar(1) DEFAULT NULL,
  `OBJ` varchar(1) DEFAULT NULL,
  `IND` varchar(1) DEFAULT NULL,
  `MIDH` varchar(1) DEFAULT NULL,
  `cien` varchar(4) DEFAULT NULL,
  `GDOMARG` varchar(8) DEFAULT NULL,
  `POBLACION` varchar(6) DEFAULT NULL,
  `Fachada` varchar(1) DEFAULT NULL,
  `placa` varchar(1) DEFAULT NULL,
  `vivir` varchar(1) DEFAULT NULL,
  `imagen` varchar(1) DEFAULT NULL,
  `buena` varchar(1) DEFAULT NULL,
  `programas` varchar(1) DEFAULT NULL,
  `corresponsal` varchar(1) DEFAULT NULL,
  `vende` varchar(1) DEFAULT NULL,
  `Mostrador` varchar(1) DEFAULT NULL,
  `Estanteria` varchar(1) DEFAULT NULL,
  `bascula` varchar(1) DEFAULT NULL,
  `rebanadora` varchar(1) DEFAULT NULL,
  `refrigerador` varchar(1) DEFAULT NULL,
  `Senal` varchar(7) DEFAULT NULL,
  `compania` varchar(8) DEFAULT NULL,
  `sistema` varchar(1) DEFAULT NULL,
  `piso` varchar(1) DEFAULT NULL,
  `pered` varchar(1) DEFAULT NULL,
  `techo` varchar(1) DEFAULT NULL,
  `cancelari` varchar(1) DEFAULT NULL,
  `iluminacion` varchar(1) DEFAULT NULL,
  `huevo` varchar(4) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `mes` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `docdetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docdetas` (
  `id` bigint(20) unsigned NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `movcve` smallint(6) NOT NULL DEFAULT 51,
  `docord` int(11) NOT NULL DEFAULT 0,
  `artcve` varchar(255) DEFAULT NULL,
  `codbarras` varchar(25) DEFAULT NULL,
  `artdesc` varchar(255) DEFAULT NULL,
  `artprcosto` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `artdescto` double(8,2) NOT NULL DEFAULT 0.00,
  `artprventa` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `docimporte` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `artpesogrm` varchar(6) NOT NULL DEFAULT '1',
  `artpesoum` varchar(3) NOT NULL DEFAULT 'PZA',
  `artganancia` smallint(6) NOT NULL DEFAULT 0,
  `doccant` double(8,2) NOT NULL DEFAULT 1.00,
  `docstatus` varchar(2) NOT NULL DEFAULT 'A',
  `docsession` varchar(255) DEFAULT NULL,
  `numberid` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `uuid` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `empresas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresas` (
  `id` bigint(20) unsigned NOT NULL,
  `regnom` varchar(255) NOT NULL,
  `regmun` varchar(125) DEFAULT NULL,
  `regrfc` varchar(255) DEFAULT NULL,
  `regcalle` varchar(255) DEFAULT NULL,
  `regnum` varchar(255) DEFAULT NULL,
  `regcp` varchar(255) DEFAULT NULL,
  `regtel` varchar(255) DEFAULT NULL,
  `regexttel` varchar(5) DEFAULT NULL,
  `regemail` varchar(65) DEFAULT NULL,
  `regloc` varchar(255) DEFAULT NULL,
  `regedo` varchar(255) DEFAULT NULL,
  `regleyenda` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `financial_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_reports` (
  `regcve` smallint(5) unsigned NOT NULL,
  `unicve` tinyint(3) unsigned NOT NULL,
  `num` smallint(5) unsigned NOT NULL,
  `almcve` smallint(5) unsigned NOT NULL,
  `canal_cte` varchar(6) DEFAULT NULL,
  `encargado` varchar(100) DEFAULT NULL,
  `localidad` varchar(30) DEFAULT NULL,
  `capital_diconsa` decimal(12,2) DEFAULT NULL,
  `capital_comunitario` decimal(12,2) DEFAULT NULL,
  `capital_total` decimal(12,2) DEFAULT NULL,
  `ventas_netas` decimal(12,2) DEFAULT NULL,
  `presup_ventas` decimal(12,2) DEFAULT NULL,
  `rot_cap` decimal(4,2) DEFAULT NULL,
  `ventas_vs_presupuesto` decimal(12,2) DEFAULT NULL,
  `bonificacion` decimal(12,2) DEFAULT NULL,
  `anticipos` decimal(12,2) DEFAULT NULL,
  `transito` decimal(12,2) DEFAULT NULL,
  `facturacion07` decimal(12,2) unsigned DEFAULT NULL,
  `facturacion815` decimal(12,2) unsigned DEFAULT NULL,
  `facturacion1621` decimal(12,2) DEFAULT NULL,
  `facturacion2230` decimal(12,2) DEFAULT NULL,
  `facturacion3160` decimal(12,2) unsigned DEFAULT NULL,
  `facturacion60` decimal(12,2) unsigned DEFAULT NULL,
  `s_ventas` decimal(12,2) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `sobrante` decimal(12,2) DEFAULT NULL,
  `faltante` decimal(12,2) unsigned DEFAULT NULL,
  `observaciones` varchar(80) DEFAULT NULL,
  `dias_inv` smallint(5) unsigned DEFAULT NULL,
  `asamblea_fecha` varchar(25) DEFAULT NULL,
  `asistencia` smallint(5) unsigned DEFAULT NULL,
  `asamblea_observaciones` varchar(80) DEFAULT NULL,
  `ruta` tinyint(3) unsigned DEFAULT NULL,
  `supervisor` varchar(39) DEFAULT NULL,
  `dia_surtimiento` varchar(9) DEFAULT NULL,
  `periodo_surtimiento` varchar(10) DEFAULT NULL,
  `ventas_kilos` varchar(4) DEFAULT NULL,
  `ventas_importe` varchar(5) DEFAULT NULL,
  `part_ventas` decimal(5,2) DEFAULT NULL,
  `year` smallint(5) unsigned NOT NULL,
  `mes` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`regcve`,`unicve`,`almcve`,`num`,`year`,`mes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `fondo_ahorros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fondo_ahorros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uo` varchar(65) NOT NULL,
  `ciclo` varchar(65) NOT NULL,
  `expediente` varchar(65) NOT NULL,
  `empleado` varchar(65) NOT NULL,
  `aportacion_empleado` decimal(12,2) NOT NULL DEFAULT 0.00,
  `aportacion_diconsa` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_aportaciones` decimal(12,2) NOT NULL DEFAULT 0.00,
  `interes_ganado` decimal(12,2) NOT NULL DEFAULT 0.00,
  `descto_sindicato` decimal(12,2) NOT NULL DEFAULT 0.00,
  `descto_pension` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_pagar` decimal(12,2) NOT NULL DEFAULT 0.00,
  `situacion` varchar(65) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `indicadores_pat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indicadores_pat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` enum('Pesos','Porcentaje','Numero de Tiendas','Numero de Persona','Numero de Reuniones') NOT NULL DEFAULT 'Pesos',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `indicadores_pat_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  KEY `media_order_column_index` (`order_column`)
) ENGINE=InnoDB AUTO_INCREMENT=39938 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `metas_avances_pat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metas_avances_pat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `regcve` int(11) NOT NULL DEFAULT 47,
  `unicve` int(11) NOT NULL DEFAULT 1,
  `almcnt` int(11) NOT NULL,
  `indicador_id` bigint(20) unsigned NOT NULL,
  `mes` int(11) NOT NULL DEFAULT 0,
  `meta` decimal(12,2) DEFAULT NULL,
  `avance` decimal(12,2) DEFAULT NULL,
  `porcentaje_cumplimiento` decimal(5,2) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indicador_id` (`indicador_id`),
  KEY `almcnt` (`almcnt`),
  CONSTRAINT `metas_avances_pat_ibfk_1` FOREIGN KEY (`indicador_id`) REFERENCES `indicadores_pat` (`id`),
  CONSTRAINT `metas_avances_pat_ibfk_2` FOREIGN KEY (`almcnt`) REFERENCES `almacenes` (`almcnt`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `metas_indicadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metas_indicadores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `indicador_id` bigint(20) unsigned NOT NULL,
  `almcnt` int(11) NOT NULL,
  `concepto` varchar(255) DEFAULT NULL,
  `anio` smallint(6) NOT NULL,
  `mes` tinyint(4) NOT NULL CHECK (`mes` between 1 and 12),
  `meta_ventas` decimal(12,2) DEFAULT NULL,
  `meta_toneladas` decimal(12,2) DEFAULT NULL,
  `meta_tiendas` int(11) DEFAULT NULL,
  `meta_personas` int(11) DEFAULT NULL,
  `meta_porcentaje` decimal(5,2) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_metas_almacen` (`almcnt`),
  CONSTRAINT `fk_metas_almacen` FOREIGN KEY (`almcnt`) REFERENCES `almacenes` (`almcnt`) ON DELETE CASCADE,
  CONSTRAINT `metas_indicadores_ibfk_1` FOREIGN KEY (`indicador_id`) REFERENCES `indicadores_pat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `operational_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operational_reports` (
  `regcve` smallint(6) NOT NULL,
  `unicve` smallint(6) NOT NULL,
  `almcve` smallint(6) NOT NULL,
  `ruta` tinyint(3) unsigned NOT NULL,
  `supervisor` varchar(39) DEFAULT NULL,
  `tiendas` tinyint(3) unsigned DEFAULT NULL,
  `presupuesto_mes` int(10) unsigned DEFAULT NULL,
  `capital_diconsa` decimal(12,2) DEFAULT NULL,
  `total_ventas` decimal(12,2) DEFAULT NULL,
  `facturacion` decimal(12,2) DEFAULT NULL,
  `rotacion0` tinyint(3) unsigned DEFAULT NULL,
  `rotacion01` tinyint(3) unsigned DEFAULT NULL,
  `rotacion115` tinyint(3) unsigned DEFAULT NULL,
  `rotacion15` tinyint(3) unsigned DEFAULT NULL,
  `auditorias_prog` tinyint(3) unsigned DEFAULT NULL,
  `auditorias_real` tinyint(3) unsigned DEFAULT NULL,
  `asambleas_prog` tinyint(3) unsigned DEFAULT NULL,
  `asambleas_real` tinyint(3) unsigned DEFAULT NULL,
  `antiguedad07` tinyint(3) unsigned DEFAULT NULL,
  `antiguedad815` tinyint(3) unsigned DEFAULT NULL,
  `antiguedad1621` tinyint(3) unsigned DEFAULT NULL,
  `antiguedad2230` tinyint(3) unsigned DEFAULT NULL,
  `antiguedad3160` tinyint(3) unsigned DEFAULT NULL,
  `antiguedad60` tinyint(3) unsigned DEFAULT NULL,
  `year` smallint(6) NOT NULL,
  `mes` smallint(6) NOT NULL,
  PRIMARY KEY (`regcve`,`unicve`,`almcve`,`ruta`,`year`,`mes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `docfec` date NOT NULL,
  `sync_date` timestamp NULL DEFAULT NULL,
  `almcnt` int(11) NOT NULL,
  `doccreated` timestamp NULL DEFAULT NULL,
  `docupdated` timestamp NULL DEFAULT NULL,
  `ctecve` int(11) NOT NULL,
  `ctename` varchar(120) NOT NULL,
  `artcve` varchar(50) DEFAULT NULL,
  `artdesc` varchar(255) DEFAULT NULL,
  `presentacion` varchar(6) NOT NULL DEFAULT '1',
  `doccant` int(10) unsigned NOT NULL DEFAULT 0,
  `artprventa` decimal(10,2) unsigned NOT NULL DEFAULT 0.00,
  `importe` decimal(12,2) unsigned NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_order_line` (`order_id`,`artcve`,`almcnt`),
  KEY `orders_order_id_index` (`order_id`),
  KEY `orders_docfec_index` (`docfec`),
  KEY `orders_sync_date_index` (`sync_date`),
  KEY `orders_almcnt_index` (`almcnt`),
  KEY `orders_ctecve_index` (`ctecve`)
) ENGINE=InnoDB AUTO_INCREMENT=625 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `preguntas_verificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas_verificacion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `categoria` varchar(191) NOT NULL,
  `codigo` varchar(191) NOT NULL,
  `descripcion` text NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `almcnt` int(11) DEFAULT 0,
  `artcve` varchar(255) DEFAULT NULL,
  `artdesc` varchar(255) NOT NULL,
  `prvcve` int(11) NOT NULL DEFAULT 1,
  `artstatus` varchar(2) NOT NULL DEFAULT 'A',
  `category_id` bigint(20) unsigned NOT NULL,
  `codbarras` varchar(25) DEFAULT NULL,
  `artmarca` varchar(255) DEFAULT NULL,
  `artestilo` varchar(255) DEFAULT NULL,
  `artcolor` varchar(255) DEFAULT NULL,
  `artseccion` varchar(255) DEFAULT NULL,
  `arttalla` varchar(255) DEFAULT NULL,
  `stock` int(10) unsigned NOT NULL DEFAULT 0,
  `artimg` varchar(255) NOT NULL DEFAULT 'imagen.jpg',
  `artprcosto` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `artprventa` double(8,2) unsigned NOT NULL DEFAULT 0.00,
  `artpesogrm` varchar(6) NOT NULL DEFAULT '1',
  `artpesoum` varchar(25) NOT NULL DEFAULT 'PZA',
  `artganancia` smallint(6) NOT NULL DEFAULT 0,
  `eximin` smallint(6) NOT NULL DEFAULT 0,
  `eximax` smallint(6) NOT NULL DEFAULT 0,
  `artdetalle` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `artcve` (`artcve`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57371 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `promedio_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promedio_ventas` (
  `regcve` int(10) unsigned NOT NULL,
  `unicve` int(10) unsigned NOT NULL,
  `almcve` int(10) unsigned NOT NULL,
  `St` smallint(5) unsigned NOT NULL,
  `Lin` smallint(5) unsigned NOT NULL,
  `Fam` smallint(5) unsigned NOT NULL,
  `Prov` smallint(5) unsigned NOT NULL,
  `TI` smallint(5) unsigned NOT NULL,
  `Clave` int(10) unsigned NOT NULL,
  `Descripcion` varchar(65) NOT NULL,
  `Cap` smallint(5) unsigned NOT NULL,
  `Gram` smallint(5) unsigned NOT NULL,
  `Unidades1` float NOT NULL,
  `Unidades2` float NOT NULL,
  `Unidades3` float NOT NULL,
  `Unidades4` float NOT NULL,
  `Unidades5` float NOT NULL,
  `Unidades6` float NOT NULL,
  `Unidades7` float NOT NULL,
  `Unidades8` float NOT NULL,
  `Unidades9` float NOT NULL,
  `Unidades10` float NOT NULL,
  `Unidades11` float NOT NULL,
  `Unidades12` float NOT NULL,
  `Totales` float NOT NULL,
  `pdm` float(12,2) NOT NULL,
  `pdd` float NOT NULL,
  `Existencia` float NOT NULL,
  `di` float unsigned NOT NULL,
  `pcmb` float NOT NULL,
  `Diferencia` varchar(45) NOT NULL,
  `porcentaje` int(10) unsigned NOT NULL,
  `sinpcmb` int(10) unsigned NOT NULL,
  `tbajas` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`regcve`,`unicve`,`almcve`,`Clave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prvrazon` varchar(255) NOT NULL,
  `prvrfc` varchar(255) DEFAULT NULL,
  `prvdir` varchar(255) DEFAULT NULL,
  `prvtel` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `releases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `releases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `artcve` varchar(255) DEFAULT NULL,
  `almcnt` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `artcve` (`artcve`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `rols`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rols` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telescope_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(255) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telescope_entries_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tiendas_bienestar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiendas_bienestar` (
  `clave_tienda` bigint(11) DEFAULT NULL,
  `Folio` int(4) DEFAULT NULL,
  `clave_localidad` int(9) DEFAULT NULL,
  `Estado` varchar(6) DEFAULT NULL,
  `municipio` varchar(38) DEFAULT NULL,
  `Localidad` varchar(76) DEFAULT NULL,
  `1. Esta funcionando` varchar(76) DEFAULT NULL,
  `2. Motivo` varchar(2) DEFAULT NULL,
  `3.  Es comunitaria` varchar(16) DEFAULT NULL,
  `4. Comit? funciona` varchar(2) DEFAULT NULL,
  `5. ?ltima asamblea` varchar(10) DEFAULT NULL,
  `6. Muro` varchar(16) DEFAULT NULL,
  `7. Techo` varchar(16) DEFAULT NULL,
  `8. Piso` varchar(19) DEFAULT NULL,
  `Foto de Formato` varchar(14) DEFAULT NULL,
  `Foto de Tienda` varchar(29) DEFAULT NULL,
  `Foto de Asamblea` varchar(22) DEFAULT NULL,
  `Verificado` varchar(1) DEFAULT NULL,
  `Fecha de Asamblea` varchar(10) DEFAULT NULL,
  `Hora de Asamblea` varchar(10) DEFAULT NULL,
  `Responsable 1 - CURP` varchar(18) DEFAULT NULL,
  `Responsable 1 - Nombre(s)` varchar(18) DEFAULT NULL,
  `Responsable 1 - Paterno` varchar(19) DEFAULT NULL,
  `Responsable 1 - Materno` varchar(11) DEFAULT NULL,
  `Responsable 1 - Correo` varchar(30) DEFAULT NULL,
  `Responsable 1 - Celular` varchar(49) DEFAULT NULL,
  `Responsable 2 - CURP` varchar(18) DEFAULT NULL,
  `Responsable 2 - Nombre(s)` varchar(18) DEFAULT NULL,
  `Responsable 2 - Paterno` varchar(20) DEFAULT NULL,
  `Responsable 2 - Materno` varchar(11) DEFAULT NULL,
  `Responsable 2 - Correo` varchar(28) DEFAULT NULL,
  `Responsable 2 - Celular` varchar(39) DEFAULT NULL,
  `Modificado` varchar(10) DEFAULT NULL,
  `Modificado Por` varchar(1) DEFAULT NULL,
  `NULL` varchar(1) DEFAULT NULL,
  KEY `clave_localidad` (`clave_localidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `toneladas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `toneladas` (
  `regcve` int(10) unsigned NOT NULL,
  `unicve` int(10) unsigned NOT NULL,
  `almcve` int(10) unsigned NOT NULL,
  `lineacve` int(11) NOT NULL DEFAULT 0,
  `linea` varchar(65) DEFAULT NULL,
  `importe_par` float(12,2) NOT NULL,
  `toneladas` float NOT NULL,
  `year` int(11) NOT NULL DEFAULT 0,
  `mes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `almcnt` int(11) NOT NULL DEFAULT 2039,
  `ip` varchar(25) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `regcve` int(11) NOT NULL DEFAULT 0,
  `unicve` int(11) NOT NULL DEFAULT 0,
  `almcve` int(11) NOT NULL DEFAULT 0,
  `lineacve` int(11) NOT NULL DEFAULT 0,
  `linea` varchar(191) DEFAULT NULL,
  `importe_par` double(12,2) NOT NULL,
  `importe_esp` double(12,2) NOT NULL,
  `year` int(11) NOT NULL DEFAULT 0,
  `mes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8366 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ventas_existencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ventas_existencias` (
  `regcve` int(2) DEFAULT NULL,
  `unicve` int(1) DEFAULT NULL,
  `almcve` int(4) DEFAULT NULL,
  `linea` varchar(20) DEFAULT NULL,
  `venta_pesos` decimal(10,2) DEFAULT NULL,
  `venta_toneladas` decimal(7,3) DEFAULT NULL,
  `existencia_pesos` decimal(10,2) DEFAULT NULL,
  `existencia_toneladas` decimal(7,3) DEFAULT NULL,
  `dias` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `verificacion_respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verificacion_respuestas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `verificacion_id` bigint(20) unsigned NOT NULL,
  `pregunta_id` bigint(20) unsigned DEFAULT NULL,
  `pregunta` varchar(191) NOT NULL,
  `respuesta` tinyint(1) DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verificacion_respuestas_verificacion_id_foreign` (`verificacion_id`),
  KEY `pregunta_id` (`pregunta_id`),
  CONSTRAINT `verificacion_respuestas_verificacion_id_foreign` FOREIGN KEY (`verificacion_id`) REFERENCES `verificaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4744 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `verificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verificaciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL DEFAULT curdate(),
  `almacen` varchar(100) DEFAULT NULL,
  `tienda` varchar(100) DEFAULT NULL,
  `comunidad` varchar(100) DEFAULT NULL,
  `supervisor` varchar(255) DEFAULT NULL,
  `comentarios_adicionales` varchar(125) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `viewimages`;
/*!50001 DROP VIEW IF EXISTS `viewimages`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewimages` AS SELECT
 1 AS `artcve`,
  1 AS `codbarras`,
  1 AS `media_id`,
  1 AS `model_type`,
  1 AS `model_id`,
  1 AS `uuid`,
  1 AS `collection_name`,
  1 AS `name`,
  1 AS `file_name`,
  1 AS `mime_type`,
  1 AS `disk`,
  1 AS `conversions_disk`,
  1 AS `size`,
  1 AS `manipulations`,
  1 AS `custom_properties`,
  1 AS `generated_conversions`,
  1 AS `responsive_images`,
  1 AS `order_column` */;
SET character_set_client = @saved_cs_client;
