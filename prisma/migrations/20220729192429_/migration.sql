-- CreateTable
CREATE TABLE `categories` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,

    UNIQUE INDEX `id_UNIQUE`(`id`),
    UNIQUE INDEX `name_UNIQUE`(`name`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `collections` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `description` VARCHAR(45) NOT NULL,
    `category_id` INTEGER NOT NULL,
    `banner_image` VARCHAR(45) NOT NULL,
    `logo_image` VARCHAR(45) NOT NULL,
    `website_url` VARCHAR(45) NULL,
    `facebook_url` VARCHAR(45) NULL,
    `telegram_url` VARCHAR(45) NULL,
    `twitter_url` VARCHAR(45) NULL,
    `istagram_url` VARCHAR(45) NULL,
    `payout_wallet_address` VARCHAR(45) NOT NULL,
    `blockchain` VARCHAR(45) NOT NULL,
    `is_sensitive_content` TINYINT NOT NULL DEFAULT 0,
    `creator_earnings` TINYINT NOT NULL,

    UNIQUE INDEX `id_UNIQUE`(`id`),
    INDEX `category_id_idx`(`category_id`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `collections_collaborators` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `collection_id` INTEGER NOT NULL,

    UNIQUE INDEX `id_UNIQUE`(`id`),
    INDEX `collection_id_idx`(`collection_id`),
    INDEX `user_id_idx`(`user_id`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `products` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `image_url` VARCHAR(45) NOT NULL,
    `image_hash` VARCHAR(45) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `title` VARCHAR(45) NOT NULL,
    `description` VARCHAR(45) NOT NULL,
    `collection_id` INTEGER NOT NULL,
    `creator_address` VARCHAR(45) NOT NULL,
    `price` VARCHAR(45) NOT NULL,
    `status` VARCHAR(45) NOT NULL,
    `created_at` DATETIME(0) NOT NULL,
    `updated_at` DATETIME(0) NOT NULL,
    `blockchain` VARCHAR(45) NOT NULL,

    UNIQUE INDEX `id_UNIQUE`(`id`),
    UNIQUE INDEX `image_url_UNIQUE`(`image_url`),
    UNIQUE INDEX `image_hash_UNIQUE`(`image_hash`),
    INDEX `collection_id_idx`(`collection_id`),
    INDEX `user_id_idx`(`user_id`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `users` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `wallet_address` VARCHAR(45) NOT NULL,
    `password` VARCHAR(45) NOT NULL,
    `bio` VARCHAR(255) NULL,
    `banner_image` VARCHAR(45) NULL,
    `facebook_url` VARCHAR(45) NULL,
    `profile_photo` VARCHAR(45) NULL,
    `twitter_url` VARCHAR(45) NULL,
    `telegram_url` VARCHAR(45) NULL,
    `created_at` DATETIME(0) NOT NULL,
    `updated_at` DATETIME(0) NOT NULL,
    `role_id` INTEGER NOT NULL,

    UNIQUE INDEX `id_UNIQUE`(`id`),
    UNIQUE INDEX `email_UNIQUE`(`email`),
    UNIQUE INDEX `wallet_address_UNIQUE`(`wallet_address`),
    INDEX `role_id_idx`(`role_id`),
    PRIMARY KEY (`id`, `email`, `wallet_address`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `roles` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,

    UNIQUE INDEX `id_UNIQUE`(`id`),
    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- AddForeignKey
ALTER TABLE `collections` ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `collections_collaborators` ADD CONSTRAINT `collaborate_collection_id` FOREIGN KEY (`collection_id`) REFERENCES `collections`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `collections_collaborators` ADD CONSTRAINT `collaborate_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `products` ADD CONSTRAINT `collection_id` FOREIGN KEY (`collection_id`) REFERENCES `collections`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `products` ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `users` ADD CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
