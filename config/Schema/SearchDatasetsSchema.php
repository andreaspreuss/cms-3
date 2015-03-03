<?php
trait SearchDatasetsSchemaTrait
{

    protected $_fields = [
  '_constraints' => 
  [
    'primary' => 
    [
      'type' => 'primary',
      'columns' => 
      [
        0 => 'id',
      ],
      'length' => 
      [
      ],
    ],
    '20c7abf8d0fa64d704bf663839fa1128' => 
    [
      'type' => 'unique',
      'columns' => 
      [
        0 => 'entity_id',
        1 => 'table_alias',
      ],
      'length' => 
      [
      ],
    ],
  ],
  'id' => 
  [
    'type' => 'integer',
    'length' => 11,
    'unsigned' => false,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'autoIncrement' => true,
    'precision' => NULL,
  ],
  'entity_id' => 
  [
    'type' => 'string',
    'length' => 50,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
    'fixed' => NULL,
  ],
  'table_alias' => 
  [
    'type' => 'string',
    'length' => 50,
    'null' => false,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
    'fixed' => NULL,
  ],
  'words' => 
  [
    'type' => 'text',
    'length' => NULL,
    'null' => true,
    'default' => NULL,
    'comment' => '',
    'precision' => NULL,
  ],
];

    protected $_records = [
  0 => 
  [
    'id' => 1,
    'entity_id' => '1',
    'table_alias' => 'nodes',
    'words' => ' my first article custom meta description lorem ipsum random random quickapps cms site skeletona skeleton for creating web sites with quickappscms http quickappscms org this is an unstable repository and should be treated as an alpha installation install with composer download composer http getcomposer org doc intro md or update composer self update run php composer phar create project s dev quickapps website website name if composer is installed globally run composer create project s dev quickapps website website name after composer is done visit http example com and start quickappscms installation ',
  ],
  1 => 
  [
    'id' => 2,
    'entity_id' => '2',
    'table_alias' => 'nodes',
    'words' => ' curabitur quis ultricies nisl donec eget rutrum nunc vestibulum sit amet faucibus elit quisque accumsan justo suscipit ullamcorper lacus dictum arcu at vehicula enim velit et libero vivamus venenatis lacinia eros ultrices erat interdum vitae aliquam scelerisque leo in tristique tincidunt cum sociis natoque penatibus magnis dis parturient montes nascetur ridiculus mus morbi iaculis nec quam viverra mattis urna consequat augue ',
  ],
];

    public function fields()
    {
        foreach ($this->_fields as $name => $info) {
            if (!empty($info['autoIncrement'])) {
                $this->_fields[$name]['length'] = null;
            }
        }
        return $this->_fields;
    }

    public function records()
    {
        return $this->_records;
    }
}

class SearchDatasetsSchema
{

    use SearchDatasetsSchemaTrait;

}
