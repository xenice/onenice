<?php

namespace xenice\theme;

class Model extends Base
{
    protected $db = null;
    protected $filter = '';
    protected $data = [];
    protected $table = '';
    protected $fields = [];
    
    public function __construct($db = null)
    {
        if($db){
            $this->db = $db;
        }
        else{
            global $wpdb;
            $this->db = $wpdb;
        }
        $this->table = $this->db->prefix . $this->table;
    }
    
    public function __call($method, $args)
	{
		if(in_array($method,['where','and','or'])){
			$count = count($args);
			if($count == 2){
				$this->filter .= ' ' . $method . ' `' . $args[0] . '` = ' . $this->format($args[0]);
				$this->data[] = $args[1];
				return $this;
			}
			elseif($count == 3){
				$this->filter .= ' ' . $method . ' `' . $args[0] .'` ' . $args[1] . ' ' . $this->format($args[0]);
				$this->data[] = $args[2];
				return $this;
			}
			
		}
		elseif($method == 'raw'){ // 原始sql条件语句，用法如 raw('and (`key` = %s or `order_sn`= %s)', $key, $order_sn)
		    $this->filter .= ' ' . $args[0];
		    $len = count($args) - 1;
		    for ($i=0; $i< $len; $i++) {
		        $this->data[] = $args[1+$i];
            } 
			return $this;
		}
		elseif($method == 'order'){
			if(count($args) == 1 || count($args) == 2){
			    isset($args[1]) || $args[1] = 'desc';
				if(!strrpos($this->filter, 'order by')){
				    if($args[0] == 'rand'){
				        $this->filter .= ' order by rand()';
				    }
				    else{
    					$this->filter .= ' order by `'.$args[0].'` ' . $args[1];
    					//$this->data[] = $args[0];
				    }
				}
				else{
					$this->filter .= ',`'.$args[0].'` ' . $args[1];
				}
				return $this;
			}
		}
		elseif($method == 'limit'){
			$count = count($args);
			if($count == 1){
				$this->filter .= ' ' . $method . ' %d';
				$this->data[] = $args[0];
				return $this;
			}
			elseif($count == 2){
				$this->filter .= ' ' . $method . ' %d, %d';
				$this->data[] = $args[0];
				$this->data[] = $args[1];
				return $this;
			}
		}
		throw new \Exception('Call to undefined method ' . __class__ . '::' . $method);
	}
	
    public function create()
    {
        $table_name = $this->table;
        $sql = '';
        $str = '';
        foreach($this->fields as $key=>$field)
        {
            $sql .= "`$key` {$field['type']}";
            isset($field['range']) && $sql .= " ({$field['range']}) not null";
            if(isset($field['value'])){
                if($this->format($key) == '%s')
                    $sql .= " default '{$field['value']}'";
                else
                    $sql .= " default {$field['value']}";
            }
            elseif(isset($field['default']))
                $sql .= " default {$field['default']}";
            empty($field['auto']) || $sql .= " AUTO_INCREMENT";
            $sql .=',';
            empty($field['primary']) || $str .= "primary key (`$key`),";
            empty($field['unique']) || $str .= "unique key `$key` (`$key`),";
        }
        $sql .= rtrim($str, ',');
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` ($sql) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
        
    }
    
    public function insert($data)
    {
        $data = Theme::call('before_insert', $data, $this);
        
        $fields = [];
        $values = [];
        $args = [];
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s`", $key);
            $values[] = $this->format($key);
            $args[] = $value;
        }
        $this->data = array_merge($args, $this->data);
        $field = implode(',', $fields);
        $value = implode(',', $values);
        $sql = sprintf("insert into `%s` (%s) values (%s)", $this->table, $field, $value);
        return $this->db->query($this->prepare($sql));
    }
    public function update($data)
    {
        $data = Theme::call('before_update', $data, $this);
        $fields = [];
        $args = [];
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s` = %s", $key, $this->format($key));
            $args[] = $value;
        }
        $this->data = array_merge($args, $this->data);
        $value = implode(',', $fields);
        $sql = sprintf("update `%s` set %s %s", $this->table, $value, $this->filter);
        return $this->db->query($this->prepare($sql));
    }
    
    public function delete()
    {
        
        $sql = sprintf("delete from `%s` %s", $this->table, $this->filter);
        return $this->db->query($this->prepare($sql));
    }
    
    public function first()
    {
        $sql = sprintf("select * from `%s` %s", $this->table, $this->filter);
        $row = $this->db->get_row($this->prepare($sql), ARRAY_A);
        return Theme::call('after_first', $row);
    }
    
    public function select()
    {
        
        $sql = sprintf("select * from `%s` %s", $this->table, $this->filter);
        return $this->db->get_results($this->prepare($sql), ARRAY_A);
    }
    
    public function distinct($cols)
    {
        $sql = sprintf("select distinct %s from `%s` %s", $cols, $this->table, $this->filter);
        return $this->db->get_results($this->prepare($sql), ARRAY_A);
    }
    
    public function count()
    {
        global $wpdb;
        $sql = sprintf("select count(*) from `%s` %s", $this->table, $this->filter);
        $row = $wpdb->get_row(@$this->prepare($sql), ARRAY_A);
        return $row['count(*)']??0;
    }

    
    protected function prepare($sql)
    {
        if(empty($this->data)){
            return $sql;
        }
        array_unshift($this->data, $sql);
		$sql = call_user_func_array([$this->db,'prepare'], $this->data);
		$this->filter = '';
		$this->data = [];
		return $sql;
    }
    
    protected function format($name)
    {
        $type = $this->fields[$name]['type'];
        if(in_array(strtolower($type),['bit','boot','tinyint','smallint','mediumint','int','bigint']))
            return '%d';
        elseif(in_array(strtolower($type),['float','double','decimal']))
            return '%f';
        else
            return '%s';
    }
    
    public function clear()
    {
        
        $sql = sprintf("truncate table `%s`", $this->table);
        return $this->db->query(@$this->prepare($sql));
    }

}