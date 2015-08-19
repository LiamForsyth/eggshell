<?php
    // Prevent running directly:
    if (!defined('PERCH_DB_PREFIX')) exit;

    // Let's go
    $sql = "
    CREATE TABLE IF NOT EXISTS `__PREFIX__eggshell_themes` (
      `themeID` int(11) NOT NULL AUTO_INCREMENT,
      `themeDynamicFields` text,
      PRIMARY KEY (`themeID`)
    ) ENGINE=ISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;";
    
    $sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);
    
    $statements = explode(';', $sql);
    foreach($statements as $statement) {
        $statement = trim($statement);
        if ($statement!='') $this->db->execute($statement);
    }
        
    $sql = 'SHOW TABLES LIKE "'.$this->table.'"';
    $result = $this->db->get_value($sql);

    return $result;
