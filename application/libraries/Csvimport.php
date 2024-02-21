<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CodeIgniter CSV Import Class
 *
 * This library will help import a CSV file into
 * an associative array.
 * 
 * This library treats the first row of a CSV file
 * as a column header row.
 * 
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Brad Stinson
 */
class Csvimport {

    var $fields;/** columns names retrieved after parsing */
    var $separator = ',';/** separator used to explode each line */
    var $enclosure = '"';/** enclosure used to decorate each field */
    var $max_row_size = 120400;/** maximum row size to be used for decoding */

    function parse_file($p_Filepath) {

        $file = fopen($p_Filepath, 'r');
        $this->fields = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);
        //print_r($this->fields);die;
        $keys_values = $this->fields;
        $content = array();
        $keys = $this->escape_string($keys_values);
        $i = 1;
        while (($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) != false) {
            //print_r($row);die;
            if ($row != null) {
                if (count($keys) == count($row)) {
                    $arr = array();
                    $new_values = array();
                    //$new_values = $this->escape_string($values);
                    for ($j = 0; $j < count($keys); $j++) {
                        if ($keys[$j] != "") {
                            $arr[$j] = $row[$j];
                        }
                    }
                    $content[$i] = $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }

    function escape_string($data) {
        $result = array();
        foreach ($data as $row) {
            $result[] = str_replace('"', '', $row);
        }
        return $result;
    }

}