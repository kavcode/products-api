<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191006184257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE products (
                    id INTEGER NOT NULL AUTO_INCREMENT, 
                    name VARCHAR(255) NOT NULL, 
                    price INTEGER NOT NULL,
                    PRIMARY KEY(id)
                )'
        );

        $this->addSql(
            'CREATE TABLE order_statuses (
                    id INTEGER NOT NULL, 
                    code VARCHAR(255) NOT NULL, 
                    PRIMARY KEY(id)
                )'
        );

        $this->addSql("INSERT INTO order_statuses (id, code) VALUES(1, 'new')");
        $this->addSql("INSERT INTO order_statuses (id, code) VALUES(2, 'payed')");

        $this->addSql(
            'CREATE TABLE orders (
                    id INTEGER NOT NULL AUTO_INCREMENT, 
                    status_id INTEGER NOT NULL, 
                    PRIMARY KEY(id),
                    FOREIGN KEY (status_id) REFERENCES order_statuses(id) ON UPDATE CASCADE ON DELETE RESTRICT 
                )'
        );

        $this->addSql(
            'CREATE TABLE order_products (
                    order_id INTEGER NOT NULL AUTO_INCREMENT, 
                    product_id INTEGER NOT NULL, 
                    PRIMARY KEY(order_id, product_id),
                    FOREIGN KEY (order_id) REFERENCES orders(id) ON UPDATE CASCADE ON DELETE RESTRICT, 
                    FOREIGN KEY (product_id) REFERENCES products(id) ON UPDATE CASCADE ON DELETE RESTRICT 
                )'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE order_products');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE order_statuses');
    }
}
