-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-11-25 22:55:31
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
-- テーブルの構造 `shelf_positions`
--

CREATE TABLE `shelf_positions` (
  `id` int(11) NOT NULL,
  `shelf_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `selected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `shelf_positions`
--

INSERT INTO `shelf_positions` (`id`, `shelf_id`, `x`, `y`, `width`, `height`, `selected`) VALUES
(1, 1, 100, 100, 100, 50, 0),
(2, 2, 200, 100, 100, 50, 0),
(3, 3, 300, 100, 100, 50, 0),
(4, 4, 400, 100, 100, 50, 0),
(5, 5, 500, 100, 100, 50, 0),
(6, 6, 600, 100, 100, 50, 0),
(7, 10, 50, 150, 50, 100, 0),
(8, 11, 150, 262, 50, 100, 0),
(9, 12, 112, 216, 50, 100, 0),
(10, 15, 175, 250, 50, 100, 0),
(11, 16, 175, 350, 50, 100, 0),
(12, 20, 275, 250, 50, 100, 0),
(13, 21, 275, 350, 50, 100, 0),
(14, 25, 375, 250, 50, 100, 0),
(15, 26, 375, 350, 50, 100, 0),
(16, 30, 475, 250, 50, 100, 0),
(17, 31, 475, 350, 50, 100, 0),
(18, 35, 575, 250, 50, 100, 0),
(19, 36, 575, 350, 50, 100, 0),
(20, 40, 700, 150, 50, 100, 0),
(21, 41, 700, 250, 50, 100, 0),
(22, 42, 700, 350, 50, 100, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `ユーザー名`
--

CREATE TABLE `ユーザー名` (
  `管理ID` int(11) NOT NULL,
  `管理者ID` int(11) NOT NULL,
  `名前` varchar(100) NOT NULL,
  `管理者権限` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `ユーザー名`
--

INSERT INTO `ユーザー名` (`管理ID`, `管理者ID`, `名前`, `管理者権限`) VALUES
(6, 16, '髙原', 'all');

-- --------------------------------------------------------

--
-- テーブルの構造 `ログイン管理`
--

CREATE TABLE `ログイン管理` (
  `管理者ID` int(11) NOT NULL,
  `ユーザー名` varchar(100) NOT NULL,
  `パスワード` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `ログイン管理`
--

INSERT INTO `ログイン管理` (`管理者ID`, `ユーザー名`, `パスワード`) VALUES
(6, 'ttt', '$2y$10$cV230UhRezSM/E4FfiBuWOi1g4qAY9CVW4WOlNeNeKJv0.gBwije.'),
(7, 'rrr', '$2y$10$Gyo41Q6o5Pg/Naod6tiNBuzilTUboGI0mK1RiO0kQyNr0XJV8f/C.'),
(8, 'vvv', '$2y$10$DS4aEym4rN.F.YRUJcH88eVHzXY4vj6RMkHfcUNHDHyU4UXQeZXjG'),
(16, 'bbb', '$2y$10$Eyr8v.7umdIlFvvvKBEcPuhRQF8REgjBxd23FnWK4efM.S.syVPbu');

-- --------------------------------------------------------

--
-- テーブルの構造 `商品`
--

CREATE TABLE `商品` (
  `商品ID` int(11) NOT NULL,
  `商品名` varchar(100) NOT NULL,
  `メーカー` varchar(100) NOT NULL,
  `Janコード` bigint(13) NOT NULL,
  `価格` int(11) NOT NULL,
  `商品説明` varchar(1500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `商品`
--

INSERT INTO `商品` (`商品ID`, `商品名`, `メーカー`, `Janコード`, `価格`, `商品説明`) VALUES
(12, 'aaa', 'morins', 1234567891011, 560, 'lllll'),
(13, 'zzz', 'ccc', 4455475547364, 145, 'qqqqqqqqqqqqq'),
(16, 'vvv', 'zzz', 1475869324152, 145, 'vvvvvvvvvvvvvvvvvv'),
(17, 'xxx', 'zzz', 1475869324152, 145, 'vvvvvvvvvvvvvvvvvv');

-- --------------------------------------------------------

--
-- テーブルの構造 `商品カテゴリー`
--

CREATE TABLE `商品カテゴリー` (
  `商品カテゴリーID` int(11) NOT NULL,
  `商品カテゴリー名` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `商品カテゴリー`
--

INSERT INTO `商品カテゴリー` (`商品カテゴリーID`, `商品カテゴリー名`) VALUES
(1, 'fff');

-- --------------------------------------------------------

--
-- テーブルの構造 `商品詳細`
--

CREATE TABLE `商品詳細` (
  `商品詳細ID` int(11) NOT NULL,
  `商品ID` int(11) NOT NULL,
  `棚ID` int(11) NOT NULL,
  `商品カテゴリーID` int(11) NOT NULL,
  `在庫数` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `基準値`
--

CREATE TABLE `基準値` (
  `基準値ID` int(11) NOT NULL,
  `棚ID` int(11) NOT NULL,
  `商品ID` int(100) NOT NULL,
  `実績` text NOT NULL,
  `時間` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `履歴`
--

CREATE TABLE `履歴` (
  `履歴ID` int(11) NOT NULL,
  `商品名` varchar(100) NOT NULL,
  `棚名` varchar(100) NOT NULL,
  `時間` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `棚`
--

CREATE TABLE `棚` (
  `棚ID` int(11) NOT NULL,
  `商品ID` int(11) NOT NULL,
  `棚番号` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `shelf_positions`
--
ALTER TABLE `shelf_positions`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `ユーザー名`
--
ALTER TABLE `ユーザー名`
  ADD PRIMARY KEY (`管理ID`),
  ADD UNIQUE KEY `管理者ID_2` (`管理者ID`),
  ADD KEY `管理者ID` (`管理者ID`);

--
-- テーブルのインデックス `ログイン管理`
--
ALTER TABLE `ログイン管理`
  ADD PRIMARY KEY (`管理者ID`),
  ADD UNIQUE KEY `ユーザー名` (`ユーザー名`);

--
-- テーブルのインデックス `商品`
--
ALTER TABLE `商品`
  ADD PRIMARY KEY (`商品ID`),
  ADD UNIQUE KEY `商品名` (`商品名`);

--
-- テーブルのインデックス `商品カテゴリー`
--
ALTER TABLE `商品カテゴリー`
  ADD PRIMARY KEY (`商品カテゴリーID`),
  ADD UNIQUE KEY `商品カテゴリー名` (`商品カテゴリー名`);

--
-- テーブルのインデックス `商品詳細`
--
ALTER TABLE `商品詳細`
  ADD PRIMARY KEY (`商品詳細ID`),
  ADD UNIQUE KEY `商品詳細_UNIQUE` (`商品ID`,`棚ID`,`商品カテゴリーID`),
  ADD KEY `商品ID` (`商品ID`),
  ADD KEY `商品カテゴリーID` (`商品カテゴリーID`),
  ADD KEY `棚ID` (`棚ID`);

--
-- テーブルのインデックス `基準値`
--
ALTER TABLE `基準値`
  ADD PRIMARY KEY (`基準値ID`),
  ADD UNIQUE KEY `基準値_unique` (`商品ID`,`棚ID`),
  ADD KEY `棚ID` (`棚ID`);

--
-- テーブルのインデックス `履歴`
--
ALTER TABLE `履歴`
  ADD PRIMARY KEY (`履歴ID`);

--
-- テーブルのインデックス `棚`
--
ALTER TABLE `棚`
  ADD PRIMARY KEY (`棚ID`),
  ADD KEY `商品ID` (`商品ID`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `shelf_positions`
--
ALTER TABLE `shelf_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- テーブルの AUTO_INCREMENT `ユーザー名`
--
ALTER TABLE `ユーザー名`
  MODIFY `管理ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `ログイン管理`
--
ALTER TABLE `ログイン管理`
  MODIFY `管理者ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- テーブルの AUTO_INCREMENT `商品`
--
ALTER TABLE `商品`
  MODIFY `商品ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- テーブルの AUTO_INCREMENT `商品カテゴリー`
--
ALTER TABLE `商品カテゴリー`
  MODIFY `商品カテゴリーID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `商品詳細`
--
ALTER TABLE `商品詳細`
  MODIFY `商品詳細ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `基準値`
--
ALTER TABLE `基準値`
  MODIFY `基準値ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `履歴`
--
ALTER TABLE `履歴`
  MODIFY `履歴ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `棚`
--
ALTER TABLE `棚`
  MODIFY `棚ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `ユーザー名`
--
ALTER TABLE `ユーザー名`
  ADD CONSTRAINT `ユーザー名_ibfk_1` FOREIGN KEY (`管理者ID`) REFERENCES `ログイン管理` (`管理者ID`);

--
-- テーブルの制約 `棚`
--
ALTER TABLE `棚`
  ADD CONSTRAINT `棚_ibfk_1` FOREIGN KEY (`商品ID`) REFERENCES `商品` (`商品ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
