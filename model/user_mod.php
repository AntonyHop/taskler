<?
/**
* 
*/
class user extends controller
{
	public $err = array();

	function add($username,$passwort){

		$this->check_form_data($username,$passwort);

		if(!empty($this->get($username))){
			$this->err[] = "Пользователь с таким именем есть";
		}

		if (count($this->err) == 0){
			$this->db->query("INSERT INTO Users (user_login, user_password) VALUES (?s, ?s)",$username,$this->crypt_pass($passwort));
		}

	}



	function check_form_data($username,$passwort){
		if(!preg_match("/^[a-zA-Z0-9]+$/",$username)){
		   array_push($this->err, "Логин может состоять только из букв английского алфавита и цифр");
		}if(!preg_match("/^[a-zA-Z0-9]+$/",$passwort)){
		  array_push($this->err,"Пароль может состоять только из букв английского алфавита и цифр");
		}

		if(strlen($username)<3 or strlen($username)>30){
			array_push($this->err, "Логин должен быть не меньше 3-х символов и не больше 30");
		}
		if(strlen($passwort)<3 or strlen($passwort)>30){
			array_push($this->err, "Пароль должен быть не меньше 5-х символов и не больше 30");
		}
	}

	private function crypt_pass($passwort){
		$hash_pass = sha1(sha1(trim($passwort)));
		return $hash_pass;
	}

	function delete($username){
		$this->db->query("DELETE FROM Users WHERE user_login=?s",$username);
	}

	function ch_passwort($username,$newPass){
		
		$this->db->query("UPDATE Users SET user_password=?s WHERE user_login=?s;",$this->crypt_pass($newPass),$username); 
	}

	function delete_by_id($id){
		$this->db->query("DELETE FROM Users WHERE user_id=?i",$id);
	}

	function ch_passwort_by_id($id,$newPass){
		
		$this->db->query("UPDATE Users SET user_password=?s WHERE user_id=?i;",$this->crypt_pass($newPass),$id); 
	}

	function get($username){
		$res = $this->db->getAll("SELECT * FROM Users WHERE user_login=?s",$username);

		return (isset($res[0]))?$res[0]:false;
	}

	function get_by_id($id){
		$res = $this->db->getAll("SELECT * FROM Users WHERE user_id=?s",$id);
		return $res[0];
	}

	function get_error_list(){
		$line = '';
		if(count($this->err) != 0){
			foreach ($this->err as $r) {
				$line.= "<p>".$r."</p>";
			}
		}else{
			$line = "done";
		}
		return $line;
	}

    function get_error_list_json(){
	    $json = '{';
        if(count($this->err) != 0){
            foreach ($this->err  as $key => $r) {
                    $json.= '"'.$key.'":"'.$r.'",';
            }
            $json = substr($json, 0, -1);
        }
        $json .= '}';
        echo $json;
    }

	function auth($username,$passwort){
		$user = $this->get($username);
		if (isset($user) && $user != array()){
			$check_pass = $this->crypt_pass($passwort);
			if($check_pass == $user["user_password"]){
				$_SESSION["user"]  = array('name' => $user["user_login"], 'level'=> $user["user_level"]);
			}else{
				$this->err[] = "Пароль не верный!";
				return false;
			}
		}else{
			$this->err[] = "Нет такого пользователя!";
			return false;
		}
	}

	function isAuth(){
		if (isset($_SESSION["user"])) return true; else return false;
	}

	function isAdmin(){
		if (isset($_SESSION["user"])){
			if($_SESSION["user"]["level"] == 1){
				return true;
			}
		}
		return false;
	}

	function logout(){
		unset($_SESSION["user"]);
		header("location:/");
	}

}