<?php
namespace Lqdt\OrmJson\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;
use Lqdt\OrmJson\Test\Fixture\DataGenerator;

/**
 * UsersFixture
 */
class AllInOneFixture extends TestFixture
{
    public $connection = 'test';
    public $table = 'objects';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'model_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'attributes' => ['type' => 'json', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'timestamp', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []]
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $amid = 'c22eef21-0468-4e00-a436-f4c90e1c1ed0';
        $cmid = 'c22eef21-0468-4e00-a436-f4c90e1c1ed1';
        $pmid = 'c22eef21-0468-4e00-a436-f4c90e1c1ed2';

        $agenerator = new DataGenerator();
        $agents = $agenerator
          ->seed('allinone')
          ->addFaker('id', 'uuid')
          ->add('model_id', $amid)
          ->addFaker('attributes.name', 'name')
          ->addFaker('attributes.title', 'title')
          ->addFaker('created', 'unixTime')
          ->addCopy('modified', 'created')
          ->generate(10);

        $cgenerator = new DataGenerator();
        $clients = $cgenerator
          ->addFaker('id', 'uuid')
          ->add('model_id', $cmid)
          ->addFaker('attributes.name', 'name')
          ->addFaker('attributes.title', 'title')
          ->addFaker('created', 'unixTime')
          ->addCopy('modified', 'created')
          ->addRandomRelations('attributes.agent_id', $agents)
          ->generate(50);

        $pgenerator = new DataGenerator();
        $profiles = $pgenerator
          ->add('model_id', $pmid)
          ->addFaker('id', 'uuid')
          ->addFaker('attributes.name', 'name')
          ->addFaker('created', 'unixTime')
          ->addCopy('modified', 'created')
          ->addUniqueRelation('attributes.client_id', $clients)
          ->generate(50);

        $this->records = array_merge($agents, $clients, $profiles);

        parent::init();
    }
}