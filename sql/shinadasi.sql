-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-11-12 16:35:09
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
-- テーブルの構造 `マッピング`
--

CREATE TABLE `マッピング` (
  `マッピングID` int(11) NOT NULL,
  `商品ID` int(11) NOT NULL,
  `棚ID` int(11) NOT NULL,
  `X1` int(11) NOT NULL,
  `Y1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- テーブルの構造 `ログイン管理`
--

CREATE TABLE `ログイン管理` (
  `管理者ID` int(11) NOT NULL,
  `ユーザー名` varchar(100) NOT NULL,
  `パスワード` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- テーブルの構造 `商品カテゴリー`
--

CREATE TABLE `商品カテゴリー` (
  `商品カテゴリーID` int(11) NOT NULL,
  `商品カテゴリー名` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `商品名` varchar(100) NOT NULL,
  `棚名` varchar(100) NOT NULL,
  `JANコード` int(13) NOT NULL,
  `実績` text NOT NULL,
  `時間` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `履歴`
--

CREATE TABLE `履歴` (
  `履歴ID` int(11) NOT NULL,
  `商品ID` int(11) NOT NULL,
  `棚ID` int(11) NOT NULL,
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
  `棚名` varchar(100) NOT NULL,
  `相対パス` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `マッピング`
--
ALTER TABLE `マッピング`
  ADD PRIMARY KEY (`マッピングID`),
  ADD UNIQUE KEY `マッピングID` (`マッピングID`),
  ADD KEY `商品ID` (`商品ID`),
  ADD KEY `棚ID` (`棚ID`);

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
  ADD KEY `商品ID` (`商品ID`),
  ADD KEY `商品カテゴリーID` (`商品カテゴリーID`),
  ADD KEY `棚ID` (`棚ID`);

--
-- テーブルのインデックス `基準値`
--
ALTER TABLE `基準値`
  ADD PRIMARY KEY (`基準値ID`),
  ADD KEY `棚ID` (`棚ID`);

--
-- テーブルのインデックス `履歴`
--
ALTER TABLE `履歴`
  ADD PRIMARY KEY (`履歴ID`),
  ADD KEY `商品ID` (`商品ID`),
  ADD KEY `棚ID` (`棚ID`);

--
-- テーブルのインデックス `棚`
--
ALTER TABLE `棚`
  ADD PRIMARY KEY (`棚ID`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `マッピング`
--
ALTER TABLE `マッピング`
  MODIFY `マッピングID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `ユーザー名`
--
ALTER TABLE `ユーザー名`
  MODIFY `管理ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `ログイン管理`
--
ALTER TABLE `ログイン管理`
  MODIFY `管理者ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `商品`
--
ALTER TABLE `商品`
  MODIFY `商品ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `商品カテゴリー`
--
ALTER TABLE `商品カテゴリー`
  MODIFY `商品カテゴリーID` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `商品詳細`
--
ALTER TABLE `商品詳細`
  MODIFY `商品詳細ID` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `棚ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `マッピング`
--
ALTER TABLE `マッピング`
  ADD CONSTRAINT `マッピング_ibfk_1` FOREIGN KEY (`商品ID`) REFERENCES `商品` (`商品ID`),
  ADD CONSTRAINT `マッピング_ibfk_2` FOREIGN KEY (`棚ID`) REFERENCES `棚` (`棚ID`);

--
-- テーブルの制約 `ユーザー名`
--
ALTER TABLE `ユーザー名`
  ADD CONSTRAINT `ユーザー名_ibfk_1` FOREIGN KEY (`管理者ID`) REFERENCES `ログイン管理` (`管理者ID`);

--
-- テーブルの制約 `商品詳細`
--
ALTER TABLE `商品詳細`
  ADD CONSTRAINT `商品ID` FOREIGN KEY (`商品ID`) REFERENCES `商品` (`商品ID`),
  ADD CONSTRAINT `商品カテゴリーID` FOREIGN KEY (`商品カテゴリーID`) REFERENCES `商品カテゴリー` (`商品カテゴリーID`),
  ADD CONSTRAINT `棚ID` FOREIGN KEY (`棚ID`) REFERENCES `棚` (`棚ID`);

--
-- テーブルの制約 `基準値`
--
ALTER TABLE `基準値`
  ADD CONSTRAINT `基準値_ibfk_1` FOREIGN KEY (`棚ID`) REFERENCES `棚` (`棚ID`);

--
-- テーブルの制約 `履歴`
--
ALTER TABLE `履歴`
  ADD CONSTRAINT `履歴_ibfk_1` FOREIGN KEY (`商品ID`) REFERENCES `商品` (`商品ID`),
  ADD CONSTRAINT `履歴_ibfk_2` FOREIGN KEY (`棚ID`) REFERENCES `棚` (`棚ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
