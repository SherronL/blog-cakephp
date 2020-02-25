<?php

use Phinx\Migration\AbstractMigration;

class CreateArticles extends AbstractMigration
{

    public function change()
    {
        $table = $this->table('articles');
		$table->addColumn('title', 'string', [
				            'default' => null,
					                'limit' => 255,
							            'null' => false,
								            ]);
		$table->addColumn('body', 'text', [
				  'default' => null,
				'null' => false,
							        ]);
		        $table->addColumn('created', 'datetime', [
				            'default' => null,
					                'null' => false,
							        ]);
		        $table->addColumn('modified', 'datetime', [
				            'default' => null,
					                'null' => false,
						]);
		$table->addColumn('user_id', 'integer',[
			'default' => null,
			'limit'=> 11,
			'null' => false,
			]);
		$table->create();
    }
}
