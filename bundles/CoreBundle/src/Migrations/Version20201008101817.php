<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Bundle\CoreBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Exception;

/**
 * @internal
 */
final class Version20201008101817 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        try {
            $this->addSql('DROP VIEW IF EXISTS documents_editables;');
        } catch (Exception $e) {
            $this->write('Could not drop view: ' . $e->getMessage());
        }

        if ($schema->hasTable('documents_elements')) {
            $this->addSql('RENAME TABLE documents_elements TO documents_editables;');
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('RENAME TABLE documents_editables TO documents_elements;');
        $this->addSql('CREATE OR REPLACE VIEW documents_editables AS SELECT * FROM documents_elements;');
    }
}
