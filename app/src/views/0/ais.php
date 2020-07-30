<?php
	$login = function($email, $pass){
		$error_txt = '';
		if($this->getHttpVars()->isSetPost("device")){
			$isMobile = $this->getHttpVars()->post("device")=="Android";
		}
		try {
			$sql = sprintf("SELECT id_user,password,key_pass FROM users WHERE username = '%s'",$email);
			$query_re=$this->getDatabase()->Query($sql);
			if($query_re && $query_re->num_rows==1){
				if($user=mysqli_fetch_array($query_re)){
					if($this->Crypt->pass_verify($pass,$user['password'],$user['key_pass'])){
						$this->getSessionManager()->add('id',$user['id_user']);
						echo json_encode(array('status' => 'VALID'));
					}else{
						throw new Exception('contraseña');
					}
				}else{
					throw new Exception('no se puedo hacer consulta');
				}
			}else{
				throw new Exception('datos ceros');
			}
		} catch (Exception $error) {
			echo json_encode(array('status' => 'ERROR','ERROR' => $error->getMessage()));
		}
	};

	if ($this->getHttpVars()->isSetPost('user') && 
		$this->getHttpVars()->isSetPost('pass') &&
		$this->getHttpVars()->post('user')!='' && 
		$this->getHttpVars()->post('pass')!=''
	) {
		$login(
			$this->getHttpVars()->post('user'),
			$this->getHttpVars()->post('pass')

		);
	}else{
		echo json_encode(array('status' => 'ERROR_2'));
	}