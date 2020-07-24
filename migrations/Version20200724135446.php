<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20200724135446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->skipIf($schema->hasTable('thing'));

        $table = $schema->createTable('thing');
        $table->addColumn('id', Types::BIGINT, [
            'unsigned' => true,
            'autoincrement' => true,
        ]);
        $table->addColumn('shape', Types::STRING, [
            'length' => 64,
        ]);
        $table->addColumn('parent_id', Types::BIGINT, [
            'unsigned' => true,
            'default' => null,
            'notnull' => false,
        ]);
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('thing', ['parent_id'], ['id']);
    }

    public function down(Schema $schema) : void
    {
        $this->skipIf(!$schema->hasTable('thing'));
        $schema->dropTable('thing');
    }
}
