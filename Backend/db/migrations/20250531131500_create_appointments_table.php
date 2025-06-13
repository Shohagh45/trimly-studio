<?php

use Phinx\Migration\AbstractMigration;

class CreateAppointmentsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('appointments');

        $table->addColumn('user_id', 'integer')
              ->addColumn('date', 'date')
              ->addColumn('time', 'time')
              ->addColumn('description', 'string', ['limit' => 255])
              ->addTimestamps();

        $table->create();
    }
}
