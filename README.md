#[測試用網站](http://52.196.106.57/Exam/index.php "http://52.196.106.57/Exam/")
## 實作簡易存取MySQL底層
###1. 設定及引用
連線的目的、帳號、密碼及DB名稱可在`Config.ini`內設定。
```
[Database]
Server = "連線目的(ip)"
User = "帳號"
Password = "密碼"
Database = "DB名稱"
```

在需要用到的地方引用/lib/DBTool.php，注意相對位置。

Example:
```PHP
<?php 
  include("lib/DBTool.php"); 
?>
```

###2. SQL查詢
先new一個Database物件，會自動帶入連線資料。
```PHP
<?php
  $DB = new Database();
?>
```
查詢使用`Query()`，可以直接傳入SQL。
```PHP
<?php 
  $DB = new Database();
  $result = $DB->Query("select * from table1");
?>
```
也可以用參數化查詢，第二個參數帶一個陣列來傳入參數。
```PHP
<?php 
  $DB = new Database();
  $result = $DB->Query("select * from table1 where col1=:col1 and col2=:col2",
    Array(":col1"=>"123", ":col2"=>"ABC"));
?>
```
回傳的結果會是二重陣列，像是：
```PHP
Array(
  [0] => Array(
            "col1" => "123",
            "col2" => "ABC",
            ...
         ),
  [1] => Array(
            "col1" => "456",
            "col2" => "DEF",
            ...
         )
  ...
)
```

###3. SQL非查詢
使用`ExecuteNonQuery()`，同樣也可用參數化。
```PHP
<?php 
  $DB = new Database();
  $result = $DB->ExecuteNonQuery("insert into table1 (col1, col2) values (:col1, :col2)",
    Array(":col1"=>"123", ":col2"=>"ABC"));
?>
```

目前實作至此。 2016/11/11


####*目前待解決問題：*
* DBTool.php裡面抓Config.ini是使用`根目錄/Exam/Config.ini`，所以架站根目錄多一層或少一層都會抓不到。
* Stored Procedure尚未研究。
