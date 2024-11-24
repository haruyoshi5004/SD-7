-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-11-24 22:59:13
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `shinadasi`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `商品`
--

CREATE TABLE `商品` (
  `商品ID` int(11) NOT NULL,
  `商品名` varchar(100) NOT NULL,
  `JANコード` int(13) NOT NULL,
  `価格` int(11) NOT NULL,
  `商品説明` varchar(1500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `商品`
--

INSERT INTO `商品` (`商品ID`, `商品名`, `JANコード`, `価格`, `商品説明`) VALUES
(2, 'aaa', 213521652, 560, 'qqqq\r\n');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `商品`
--
ALTER TABLE `商品`
  ADD PRIMARY KEY (`商品ID`),
  ADD UNIQUE KEY `商品名` (`商品名`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `商品`
--
ALTER TABLE `商品`
  MODIFY `商品ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
