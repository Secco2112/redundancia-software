<?php

    function request($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "Content-type: application/json",
                "Accept: application/json"
            )
        );
        if(isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] == "127.0.0.1") {
            curl_setopt($ch, CURLOPT_PROXY, "192.168.10.254:3128");
        }

        $result = curl_exec($ch);
        $error = curl_errno($ch);
        if($error === 0) {
            return $result;
        }
        return false;
    }


    function request_viacep($post_code) {
        $url = "https://viacep.com.br/ws/{$post_code}/json/";
        $request = request($url);
        return $request;
    }


    function request_republica($post_code) {
        $url = "http://cep.republicavirtual.com.br/web_cep.php?cep={$post_code}&formato=json";
        $request = request($url);
        return $request;
    }


    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $post_code = $_POST["postcode"];
        $post_code = str_replace("-", "", $post_code);

        $result = request_viacep($post_code);
        if($result) {
            $result = json_decode($result, TRUE);
            $result["servico"] = "ViaCep";
            $result["success"] = true;
            echo json_encode($result);
            die();
        } else {
            $result = request_republica($post_code);
            if($result) {
                $result = json_decode($result, TRUE);
                $result["servico"] = "República Virtual";
                $result["success"] = true;
                echo json_encode($result);
                die();
            } else {
                echo json_encode(["success" => false]);
                die();
            }
        }

    }