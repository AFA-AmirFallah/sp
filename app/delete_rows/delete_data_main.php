<?php

namespace App\delete_rows;

use App\Models\delete_data;

class delete_data_main
{

    /**
     * The function `permanent_delete` use for log the delete table rows history to futures recovery or audit 
     * and takes a username, target table, rows to delete, and a note, then
     * stores this information in a database table.
     * 
     * @param username The `username` parameter is a string that represents the username of the user
     * who is performing the permanent delete operation.
     * @param target_table The `target_table` parameter in the `permanent_delete` function refers to
     * the name of the database table from which the rows are being permanently deleted. It is a string
     * variable that should contain the name of the table where the rows are to be deleted permanently.
     * @param rows The `rows` parameter in the `permanent_delete` function is an array that contains
     * the data rows that are to be permanently deleted from the specified target table. This array is
     * then encoded into a JSON string using `json_encode` before being stored in the database along
     * with other information such as the username
     * @param note The `permanent_delete` function takes in the following parameters:
     * 
     * @return An array is being returned with two keys:
     * 1. 'result' with a boolean value of true
     * 2. 'data' with the result of the create operation from the delete_data class
     */
    public function permanent_delete(string $username, string $target_table, array $rows, string $note)
    {
        $rows = json_encode($rows);
        $insert_data = [
            'UserName' => $username,
            'table' =>  $target_table,
            'note' => $note,
            'rows' => $rows
        ];
        $create_result =  delete_data::create($insert_data);
        return [
            'result' => true,
            'data' => $create_result
        ];
    }
}
