<?php
date_default_timezone_set("Asia/Taipei");
session_start();

class DB
{

    // 受保護的資料庫
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    protected $pdo;
    protected $table;

    // 便於管控要查找資料庫中的Table
    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, 'root', '');
    }

    // 將陣列以Data形式儲存至tmp
    private function a2s($array)
    {
        foreach ($array as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
        return $tmp;
    }


    function all($where = '', $other = '')
    {
        // global $pdo;
        $sql = "select * from `$this->table` ";

        // 若table有定義且非空將執行下列程式
        if (isset($this->table) && !empty($this->table)) {
            // 如果有追加查找條件將會把where增加至sql語句之後
            if (is_array($where)) {
                if (!empty($where)) {
                    $tmp = $this->a2s($where);
                    $sql .= " where " . join(" && ", $tmp);
                }

            } else {
                // 若無(預設為Null),則輸出為where(即空字串)
                $sql .= " $where";
            }
            $sql .= $other;
            //echo 'all=>'.$sql;
            // $rows = $this->pdo->query($sql)->fetchColumn(PDO::FETCH_CLASS);
            $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } else {
            echo "錯誤:沒有指定的資料表名稱";
        }
    }


    // *count*
    function total($id)
    {

        $sql = "select count(`id`) from `$this->table` ";

        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= " where " . join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= " where `id`='$id'";
        } else {
            echo "錯誤:參數的資料型態比須是數字或陣列";
        }
        //echo 'find=>'.$sql;
        $row = $this->pdo->query($sql)->fetchColumn();
        return $row;
    }

    function find($id)
    {

        $sql = "select * from `$this->table` ";

        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= " where " . join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= " where `id`='$id'";
        } else {
            echo "錯誤:參數的資料型態比須是數字或陣列";
        }
        //echo 'find=>'.$sql;
        $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function save($array)
    {
        if (isset($array['id'])) {
            $this->update($array['id'], $array);
        } else {
            $sql = "insert into `$this->table` ";
            $cols = "(`" . join("`,`", array_keys($array)) . "`)";
            $vals = "('" . join("','", $array) . "')";

            $sql = $sql . $cols . " values " . $vals;
        }
        return $this->pdo->exec($sql);

    }
    protected function update($id, $cols)
    {


        $sql = "update `$this->table` set ";

        if (!empty($cols)) {
            $tmp = $this->a2s($cols);
        } else {
            echo "錯誤:缺少要編輯的欄位陣列";
        }

        $sql .= join(",", $tmp);
        $sql .= " where `id`={$cols['id']}";

        // echo $sql;
        // return $this->pdo->exec($sql);
    }

    protected function insert($values)
    {


        // $sql = "insert into `$this->table` ";
        // $cols = "(`" . join("`,`", array_keys($values)) . "`)";
        // $vals = "('" . join("','", $values) . "')";

        // $sql = $sql . $cols . " values " . $vals;

        //echo $sql;

        // return $this->pdo->exec($sql);
    }
    function q($sql)
    {
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }


    function del($id)
    {

        $sql = "delete from `$this->table` where ";

        if (is_array($id)) {
            $tmp = $this->a2s($id);
            $sql .= join(" && ", $tmp);
        } else if (is_numeric($id)) {
            $sql .= " `id`='$id'";
        } else {
            echo "錯誤:參數的資料型態比須是數字或陣列";
        }
        //echo $sql;

        return $this->pdo->exec($sql);
    }

    function dd($array)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }




}








$student = new DB('students');
$rows = $student->all();
// $rows=$student->find(20);
// $rows=$student->total(20);
$student->dd($rows);



