<?php

namespace Plugin\BannerManagement4\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190703085413 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO plg_banner_field (id, name, sort_no, discriminator_type) VALUES (2, "キービジュアル(SP)", 2, "bannerfield")');
    }

    public function down(Schema $schema) : void
    {

    }
}
