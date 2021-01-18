<?php declare(strict_types=1);

namespace Inchoo\ReviewPlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1610439075Review extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1610439075;
    }

    public function update(Connection $connection): void
    {
        // implement update
        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `inchoo_review` (
              `id` BINARY(16) NOT NULL,
              `rating` SMALLINT NOT NULL,
              `title` VARCHAR(255) NOT NULL,
              `review_text` LONGTEXT NOT NULL,
              `display` TINYINT(1) DEFAULT 0,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) DEFAULT NULL,
              `language_id` BINARY(16) NOT NULL,
              `sales_channel_id` BINARY(16) NOT NULL,
              `customer_id` BINARY(16) NOT NULL,  
              PRIMARY KEY (`id`),
              FOREIGN KEY (language_id) REFERENCES `language`(id),
              FOREIGN KEY (sales_channel_id) REFERENCES sales_channel(id),
              FOREIGN KEY (customer_id) REFERENCES customer(id),
                CONSTRAINT UC_Review UNIQUE (language_id, sales_channel_id, customer_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
