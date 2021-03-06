<?php
  /* SQL.inc.php
   * Contains common functions for creating and running MySQL queries
  */
  
  /* Quick SQL Functions
  */
  
  // makeSQLEnum([...])
  // Turns [7,14] into "'7', '14'"
  function makeSQLEnum($myarr) {
    if(is_string($myarr)) return $myarr;
    return '\'' . implode($myarr, '\', \'') . '\'';
  }
  
  // makeSQLSelects([...])
  // Turns [7,14] into "`7`, `14`"
  function makeSQLSelects($myarr) {
    if(is_string($myarr)) return $myarr;
    return '`' . implode($myarr, '`, `') . '`';
  }
  
  // filterUserID(userID)
  // Makes the id a string of only numbers
  function filterUserID($userID) {
    return str_replace(['+', '-'], '', filter_var('' . $userID, FILTER_SANITIZE_NUMBER_FLOAT));
  }
  
  
  /* Common SQL Queries
  */
  
  // checkKeyExists($dbConn, "table", "row", "value")
  // Returns a bool of whether a key of the value exists under the row, in that table
  function checkKeyExists($dbConn, $table, $row, $value) {
    $query = '
      SELECT `' . $row . '` FROM `' . $table . '`
      WHERE `' . $row . '` LIKE :value
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':value' => $value));
    $results = $stmnt->fetch(PDO::FETCH_ASSOC);
    return !empty($results);
  }
  
  // getRowValue($dbConn, "table"", "valCol", "keyCol", "keyVal")
  // Returns the single value at a specified column of a specified row
  function getRowValue($dbConn, $table, $valCol, $keyCol, $keyVal) {
    $query = '
      SELECT `' . $valCol . '` FROM `' . $table . '`
      WHERE `' . $keyCol . '` = :myval
    ';
    $stmnt = getPDOStatement($dbConn, $query);
    $stmnt->execute(array(':myval' => $keyVal));
    $result = $stmnt->fetch(PDO::FETCH_OBJ);
    return $result->$valCol;
  }


?>