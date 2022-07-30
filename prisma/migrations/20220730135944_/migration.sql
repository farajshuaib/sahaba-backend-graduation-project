/*
  Warnings:

  - The primary key for the `users` table will be changed. If it partially fails, the table could be left without primary key constraint.
  - You are about to drop the column `password` on the `users` table. All the data in the column will be lost.

*/
-- AlterTable
ALTER TABLE `users` DROP PRIMARY KEY,
    DROP COLUMN `password`,
    MODIFY `username` VARCHAR(45) NULL,
    MODIFY `email` VARCHAR(45) NULL,
    ADD PRIMARY KEY (`id`, `wallet_address`);
