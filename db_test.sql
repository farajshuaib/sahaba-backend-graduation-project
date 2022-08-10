
-- tables

CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `collections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  `banner_image` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_image` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_url` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram_url` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_url` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `istagram_url` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payout_wallet_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blockchain` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_sensitive_content` tinyint NOT NULL DEFAULT '0',
  `creator_earnings` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `category_id_idx` (`category_id`),
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `collections_collaborators` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `collection_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `collection_id_idx` (`collection_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `collaborate_collection_id` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `collaborate_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_url` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_hash` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collection_id` int NOT NULL,
  `creator_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `owner_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `image_url_UNIQUE` (`image_url`),
  UNIQUE KEY `image_hash_UNIQUE` (`image_hash`),
  KEY `collection_id_idx` (`collection_id`),
  CONSTRAINT `collection_id` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `social_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `facebook` varchar(45) DEFAULT NULL,
  `instagram` varchar(45) DEFAULT NULL,
  `twitter` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wallet_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_image` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `role_id` int NOT NULL,
  `socials_id` int DEFAULT NULL,
  PRIMARY KEY (`id`,`wallet_address`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `wallet_address_UNIQUE` (`wallet_address`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `role_id_idx` (`role_id`),
  KEY `socials_id_idx` (`socials_id`),
  CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `socials_id` FOREIGN KEY (`socials_id`) REFERENCES `social_links` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

