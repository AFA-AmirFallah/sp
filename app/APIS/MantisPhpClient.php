<?php

namespace App\APIS;

/**
 * A php client for MantisBT / MantisHub SOAP API.
 */
class MantisPhpClient
{

    public function CreateIssue($summary, $description, $additional_information, $Project, $category , $SourceIP , $UserName)
    {
        switch ($Project) {
            case 1:
                $ProjectStr = 'Shafatel';
                break;
        }
        switch ($category) {
            case 5:
                $categoryStr = 'bugtracker';
                break;
        }
        $TargrtArray = array(
            'summary' => $summary,
            'description' => $description,
            'additional_information' => $additional_information,
            'custom_fields' => [
                0 => [
                  'field' => [
                    'id' => 1,
                    'name' => 'SourceIP',
                  ],
                  'value' => $SourceIP,
                ],
                1 => [
                  'field' => [
                    'id' => 2,
                    'name' => 'UserName',
                  ],
                  'value' => $UserName,
                ],
              ],
            'project' =>
            array(
                'id' => $Project,
                'name' => $ProjectStr,
            ),
            'category' =>
            array(
                'id' => $category,
                'name' => 'bugtracker',
            ),
            'handler' =>
            array(
                'name' => 'vboctor',
            ),
            'SourceIP' =>
            array(
                'value' => 'vboctor',
            ),
            'view_state' =>
            array(
                'id' => 10,
                'name' => 'public',
            ),
            'priority' =>
            array(
                'name' => 'normal',
            ),
            'severity' =>
            array(
                'name' => 'trivial',
            ),
            'reproducibility' =>
            array(
                'name' => 'always',
            ),
            'sticky' => false,
            'tags' =>
            array(
                0 =>
                array(
                    'name' => 'salam',
                ),
            ),
        );
        $CURLOPT_POSTFIELDS = json_encode($TargrtArray);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://bugs.dgkar.com/api/rest/issues',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Nn6-4itd93jx1kUZobLhqXGUZjMStJXi',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return true;
    }
}
