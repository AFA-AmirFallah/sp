<?php


namespace App\voip;

use App\Http\Controllers\APIS\VOIP;
use App\Models\cdr;
use App\myappenv;
use GuzzleHttp\Client;

use function PHPUnit\Framework\isArray;

class Voip_sync
{
    private function get_voip_server_data()
    {
        $voip_sever = myappenv::voip_sever;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $voip_sever . "/sync.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'function' => 'get_rows'
            ),
        ));

        $response = curl_exec($curl);
        return json_decode($response, true);

    }
    private function get_voip_server_all_records()
    {
        $voip_sever = myappenv::voip_sever;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $voip_sever . "/sync.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'function' => 'sync_all_records'
            ),
        ));

        $response = curl_exec($curl);
        return json_decode($response, true);

    }
    private function add_cdr_record_local_db($cdr_item)
    {
        $old_row = cdr::where('uniqueid', $cdr_item['uniqueid'])->first();
        if ($old_row == null) {
            $voip_functions = new VOIP;
            $new_src = $voip_functions->NumberFormater($cdr_item['src']);
            $new_src = $new_src['OutputNumber'];
            $new_dst = $voip_functions->NumberFormater($cdr_item['dst']);
            $new_dst = $new_dst['OutputNumber'];
            $import_data = [
                "calldate" => $cdr_item['calldate'],
                "clid" => $cdr_item['clid'],
                "src" => $new_src,
                "dst" => $new_dst,
                "dcontext" => $cdr_item['dcontext'],
                "channel" => $cdr_item['channel'],
                "dstchannel" => $cdr_item['dstchannel'],
                "lastapp" => $cdr_item['lastapp'],
                "lastdata" => $cdr_item['lastdata'],
                "duration" => $cdr_item['duration'],
                "billsec" => $cdr_item['billsec'],
                "disposition" => $cdr_item['disposition'],
                "amaflags" => $cdr_item['amaflags'],
                "accountcode" => $cdr_item['accountcode'],
                "uniqueid" => $cdr_item['uniqueid'],
                "userfield" => $cdr_item['userfield'],
                "recordingfile" => $this->record_file_fixer($cdr_item['recordingfile']),
                "cnum" => $cdr_item['cnum'],
                "cnam" => $cdr_item['cnam'],
                "outbound_cnum" => $cdr_item['outbound_cnum'],
                "outbound_cnam" => $cdr_item['outbound_cnam'],
                "dst_cnam" => $cdr_item['dst_cnam'],
                "did" => $cdr_item['did'],
            ];
            $import_src = cdr::create($import_data);
            return $import_src->id;
        }
        return $old_row->id;

    }
    private function import_new_data_into_local_db($cdr_arr_src)
    {
        if ($cdr_arr_src == null) {
            echo 'input is null';
            return false;
        }
        if (!isArray($cdr_arr_src)) {
            echo 'input is not array';
            return false;
        }
        $records_id = [];
        foreach ($cdr_arr_src as $cdr_item) {
            $local_id = $this->add_cdr_record_local_db($cdr_item);
            $arr_item = [
                'src_id' => $cdr_item['uniqueid'],
                'local_id' => $local_id
            ];
            array_push($records_id, $arr_item);
        }
        return $records_id;
    }
    private function update_voip_server($records_id)
    {
        $records_id = json_encode($records_id);
        $curl = curl_init();
        $voip_sever = myappenv::voip_sever;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $voip_sever . "/sync.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'function' => 'sync_rows',
                'cdr_ids' => $records_id
            ),
        ));
        $response = curl_exec($curl);
        return $response;
    }

    public function record_file_fixer($record_file) //TODO: fix
    {
        if ($record_file == null || $record_file == '') {
            return $record_file;
        }
        $img = str_replace("/var/spool/asterisk/", "", $record_file);
        $img = str_replace("/var/www/html/", "", $img);
        $voip_sever = myappenv::voip_sever . '/';
        $img = $voip_sever . $img;
        return $img;

    }
    public function sync_with_voip_server()
    {
        if (myappenv::Lic['Voip']) {
            $cdr_array_src = $this->get_voip_server_data();
            $records_id = $this->import_new_data_into_local_db($cdr_array_src);
            $result = $this->update_voip_server($records_id);
            return $result;
        }


    }
    public function sync_all_voice()
    {
        $voice_src = $this->get_voip_server_all_records();
        if ($voice_src == null) {
            echo 'input is null';
            return false;
        }
        if (!isArray($voice_src)) {
            echo 'input is not array';
            return false;
        }
        $items = 0;
        foreach ($voice_src as $cdr_item) {
            $recordingfile = $cdr_item['recordingfile'];
            $recordingfile = $this->record_file_fixer($recordingfile);
            cdr::where('id', $cdr_item['sync_id'])->update(["recordingfile" => $recordingfile]);
            $items++;
        }
        return $items;

    }
}
