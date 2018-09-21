<?php
include_once 'Db.php';
header('Content-Type: application/json');
class IP
{
	
    public static function getInfo(){
        $db = Db::getDataBaseConnection();
        $result = $db->query('SELECT * FROM tb_ip_addresses');
        $i = 0;
        $arr = array();
        while ($row = $result->fetch())
        {
            $arr[$i]['id'] = $row['id'];
            $arr[$i]['ip'] = $row['ip'];
			$arr[$i]['country'] = $row['country'];
            $i++;
        }

        echo json_encode($arr);

    }


    public static function createInfo($ip,$country = ''){
        
        $db = Db::getDataBaseConnection();
        $sql = 'INSERT INTO tb_ip_addresses '
        . '(ip, country)'
        . 'VALUES '
        . '(:ip, :country)';

        $result = $db->prepare($sql);
        $result->bindParam(':ip', $ip, PDO::PARAM_STR);
        $result->bindParam(':country', $country, PDO::PARAM_STR);
    
   
        if ($result->execute()) {
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }
        // Иначе возвращаем 0
        return 0;

    }
	
	//получаем список ip адресов из БД
	public static function getIPList(){
		$db = Db::getDataBaseConnection();
        $result = $db->query('SELECT ip,id FROM tb_ip_addresses');
        $i = 0;
        $arr = array();
        while ($row = $result->fetch())
        {
            $arr[$i]['ip'] = $row['ip'];
			$arr[$i]['id'] = $row['id'];
            $i++;
        }
        return $arr;
	}
	
	
	//Получаем ответ от API
	public static function getCountries($array){
		$db = Db::getDataBaseConnection();
		$ips = [];
		foreach($array as $element => $value){
			$ch = curl_init('http://geoip.nekudo.com/api/'.$value['ip']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			$ips[$value['id']] = json_decode($response);
		}
	
		$sql = "UPDATE tb_ip_addresses
            SET  
                country = :country
            WHERE id = :id";
		
			
			
		$result = $db->prepare($sql);
		

		foreach($ips  as $ip=>$value){
			
			$result->bindParam(':id', $ip, PDO::PARAM_INT);
			$result->bindParam(':country', $value->country->name, PDO::PARAM_STR);
			$result->execute();

		}
	
		
	}



	
}

IP::createInfo($_POST['ip']);
$array = IP::getIPList();
IP::getCountries($array);
IP::getInfo();







