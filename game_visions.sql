-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-04-08 05:25:38
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `game_visions`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `action_log`
--

CREATE TABLE `action_log` (
  `id` int(12) NOT NULL,
  `action_text` varchar(128) NOT NULL,
  `action_result` varchar(128) NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `character_game_data`
--

CREATE TABLE `character_game_data` (
  `id` int(12) NOT NULL,
  `character_id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `character_name` varchar(128) NOT NULL,
  `save_path` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `battle_style` int(11) NOT NULL,
  `tag_set` int(11) NOT NULL,
  `spec_set` int(11) NOT NULL,
  `symbol_set` int(11) NOT NULL,
  `skill_set` int(11) NOT NULL,
  `effects_set` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `character_hand_item`
--

CREATE TABLE `character_hand_item` (
  `id` int(12) NOT NULL,
  `character_data` int(11) NOT NULL,
  `user_class` int(11) NOT NULL,
  `hand_item_name` varchar(128) NOT NULL,
  `hand_item_introduction` varchar(255) NOT NULL,
  `hand_item_image` varchar(128) NOT NULL,
  `item_class` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `character_main_data`
--

CREATE TABLE `character_main_data` (
  `main_id` int(12) NOT NULL,
  `character_id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `character_name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `save_path` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `creater_id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `is_admin` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `character_play_log`
--

CREATE TABLE `character_play_log` (
  `id` int(12) NOT NULL,
  `save_path` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `character_profile_data`
--

CREATE TABLE `character_profile_data` (
  `id` int(12) NOT NULL,
  `character_id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `introduction` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `character_birthday` varchar(128) NOT NULL,
  `character_startday` varchar(128) NOT NULL,
  `character_age` varchar(128) NOT NULL,
  `character_stature` varchar(128) NOT NULL,
  `character_weight` varchar(128) NOT NULL,
  `character_job` varchar(128) NOT NULL,
  `character_special_skill` varchar(128) NOT NULL,
  `character_hobby` varchar(128) NOT NULL,
  `character_introduction` varchar(255) NOT NULL,
  `tag_set_connect` int(11) NOT NULL,
  `image_scenario_connect` varchar(128) NOT NULL,
  `effects_set` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `character_session_data`
--

CREATE TABLE `character_session_data` (
  `id` int(12) NOT NULL,
  `scenario_name` int(12) NOT NULL,
  `position_data` int(12) NOT NULL,
  `action_log_connect` int(12) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `character_spec_set`
--

CREATE TABLE `character_spec_set` (
  `id` int(12) NOT NULL,
  `character_spec_id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `attack` int(11) NOT NULL,
  `toughness` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `technic` int(11) NOT NULL,
  `imagination` int(11) NOT NULL,
  `chase` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `effects_set`
--

CREATE TABLE `effects_set` (
  `id` int(12) NOT NULL,
  `user_class` int(11) NOT NULL,
  `effects_name` varchar(128) NOT NULL,
  `effects_image` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `item_data`
--

CREATE TABLE `item_data` (
  `item_id` int(12) NOT NULL,
  `creater_name` varchar(128) NOT NULL,
  `item_name` varchar(128) NOT NULL,
  `item_introduction` varchar(128) NOT NULL,
  `item_image` varchar(128) NOT NULL,
  `item_type` int(11) NOT NULL,
  `tag_set` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `scenario_data`
--

CREATE TABLE `scenario_data` (
  `id` int(12) NOT NULL,
  `scenario_id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `creater_name` varchar(128) NOT NULL,
  `scenario_name` varchar(128) NOT NULL,
  `scenario_introduction` varchar(128) NOT NULL,
  `scenario_image` varchar(128) NOT NULL,
  `clearbonus_set` int(11) NOT NULL,
  `tag_set` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `scene`
--

CREATE TABLE `scene` (
  `scene_id` int(12) NOT NULL,
  `creater_name` varchar(128) NOT NULL,
  `scene_name` varchar(128) NOT NULL,
  `scene_image` varchar(128) NOT NULL,
  `scene_event_type` int(11) NOT NULL,
  `scene_introduction` varchar(128) NOT NULL,
  `effect_set_connect` int(11) NOT NULL,
  `actor_set_connect` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tag_set` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `scene_set`
--

CREATE TABLE `scene_set` (
  `id` int(12) NOT NULL,
  `scenario_connect` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `scene_connect` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(12) NOT NULL,
  `tag_name` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `tag_set`
--

CREATE TABLE `tag_set` (
  `id` int(12) NOT NULL,
  `tag_connect` int(11) NOT NULL,
  `character_connect` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `users_table`
--

CREATE TABLE `users_table` (
  `id` int(12) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `is_admin` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `action_log`
--
ALTER TABLE `action_log`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `character_game_data`
--
ALTER TABLE `character_game_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `character_image` (`save_path`);

--
-- テーブルのインデックス `character_hand_item`
--
ALTER TABLE `character_hand_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hand_item_image` (`hand_item_image`);

--
-- テーブルのインデックス `character_main_data`
--
ALTER TABLE `character_main_data`
  ADD PRIMARY KEY (`main_id`),
  ADD UNIQUE KEY `save_path` (`save_path`);

--
-- テーブルのインデックス `character_play_log`
--
ALTER TABLE `character_play_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_data_connect` (`save_path`);

--
-- テーブルのインデックス `character_profile_data`
--
ALTER TABLE `character_profile_data`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `character_session_data`
--
ALTER TABLE `character_session_data`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `character_spec_set`
--
ALTER TABLE `character_spec_set`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `effects_set`
--
ALTER TABLE `effects_set`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `effects_image` (`effects_image`);

--
-- テーブルのインデックス `item_data`
--
ALTER TABLE `item_data`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `item_image` (`item_image`);

--
-- テーブルのインデックス `scenario_data`
--
ALTER TABLE `scenario_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scenario_image` (`scenario_image`);

--
-- テーブルのインデックス `scene`
--
ALTER TABLE `scene`
  ADD PRIMARY KEY (`scene_id`),
  ADD UNIQUE KEY `scene_image` (`scene_image`);

--
-- テーブルのインデックス `scene_set`
--
ALTER TABLE `scene_set`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- テーブルのインデックス `tag_set`
--
ALTER TABLE `tag_set`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `action_log`
--
ALTER TABLE `action_log`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `character_game_data`
--
ALTER TABLE `character_game_data`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `character_hand_item`
--
ALTER TABLE `character_hand_item`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `character_main_data`
--
ALTER TABLE `character_main_data`
  MODIFY `main_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `character_play_log`
--
ALTER TABLE `character_play_log`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `character_profile_data`
--
ALTER TABLE `character_profile_data`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `character_session_data`
--
ALTER TABLE `character_session_data`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `character_spec_set`
--
ALTER TABLE `character_spec_set`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `effects_set`
--
ALTER TABLE `effects_set`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `item_data`
--
ALTER TABLE `item_data`
  MODIFY `item_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `scenario_data`
--
ALTER TABLE `scenario_data`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `scene`
--
ALTER TABLE `scene`
  MODIFY `scene_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `scene_set`
--
ALTER TABLE `scene_set`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `tag_set`
--
ALTER TABLE `tag_set`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `users_table`
--
ALTER TABLE `users_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
