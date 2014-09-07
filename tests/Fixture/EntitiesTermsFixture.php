<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since  1.0.0
 * @author   Christopher Castro <chris@quickapps.es>
 * @link   http://www.quickappscms.org
 * @license  http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace QuickApps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class EntitiesTermsFixture extends TestFixture {

	public $fields = array (
  '_constraints' => 
  array (
    'primary' => 
    array (
      'type' => 'primary',
      'columns' => 
      array (
        0 => 'id',
      ),
      'length' => 
      array (
      ),
    ),
  ),
  'id' => 
  array (
    'type' => 'biginteger',
    'length' => 20,
    'unsigned' => false,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'autoIncrement' => true,
    'precision' => NULL,
  ),
  'entity_id' => 
  array (
    'type' => 'integer',
    'length' => 20,
    'unsigned' => false,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
    'autoIncrement' => NULL,
  ),
  'term_id' => 
  array (
    'type' => 'integer',
    'length' => 20,
    'unsigned' => false,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
    'autoIncrement' => NULL,
  ),
  'field_instance_id' => 
  array (
    'type' => 'integer',
    'length' => 11,
    'unsigned' => false,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
    'autoIncrement' => NULL,
  ),
  'table_alias' => 
  array (
    'type' => 'string',
    'length' => 30,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
    'fixed' => NULL,
  ),
);

	public $records = array (
);

}

