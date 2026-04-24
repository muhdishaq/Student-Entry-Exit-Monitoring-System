<?php
error_reporting(0);
session_start();
$config = new controller();
	class controller{

		function __construct(){
			if (isset($_GET['mod'])) {
				$conn = $this->open();
				$action = $this->valdata($conn, $_GET['mod']);

				switch ($action) {

					//---------------- START BASIC PART ----------------
					case 'updateLaporan':
						$this->updateLaporan($conn);
						break;

					case 'permohonanditolak':
						$this->permohonanditolak($conn);
						break;

					case 'permohonanditerima':
						$this->permohonanditerima($conn);
						break;

					case 'wardenpermohonanditolak':
						$this->wardenpermohonanditolak($conn);
						break;

					case 'wardenpermohonanditerima':
						$this->wardenpermohonanditerima($conn);
						break;

					case 'padampengguna':
						$this->padampengguna($conn);
						break;

					case 'tambahpengguna':
						$this->tambahpengguna($conn);
						break;

					case 'kemaskinipengguna':
						$this->kemaskinipengguna($conn);
						break;

					case 'kemaskinipelajar':
						$this->kemaskinipelajar($conn);
						break;

					case 'padampelajar':
						$this->padampelajar($conn);
						break;

					case 'tambahpelajar':
						$this->tambahpelajar($conn);
						break;
						
					case 'permohonanbaru':
						$this->permohonanbaru($conn);
						break;

					case 'login':
						$this->login($conn);
						break;

					case 'logout':
						$this->logout($conn);
						break;

					//---------------- END BASIC PART ----------------
					
				}
			}
		}

        // --------------------------- START BASIC PART ---------------------------
		public function updateLaporan($conn){

			$id = $this->valdata($conn, $_GET['id']);
			$pelajar = $this->getSingleData($conn, 'pelajar', ' id = ' . $id);

			$status = ($pelajar['statuskeluar']) ? 'masuk' : 'keluar';

			$sql = "INSERT INTO report (pelajar_id, status) VALUES (?,?)";
			$stmt = $conn->prepare($sql);
			$stmt->execute([$pelajar['id'], $status]);


			$sqlPelajar = "UPDATE pelajar SET statuskeluar = ? WHERE id = ?";
			$stmtPelajar = $conn->prepare($sqlPelajar);
			$stmtPelajar->execute([ ($pelajar['statuskeluar']) ? 0 : 1, $pelajar['id']]);

			echo "<script>window.location = '../guard/index.php'</script>";
		}

		public function permohonanditolak($conn){
			$id = $this->valdata($conn, $_GET['id']);
			$pengguna = $this->getAuth($conn);

			$sql = "UPDATE permohonan SET permohonan_status_id = 3, pengesahan_oleh = ? WHERE id = ?";
				
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$pengguna['nama'], $id]);

			echo "<script>window.alert('Permohonan ditolak.')</script>";
			echo "<script>window.location = '../ketua-jabatan/index.php'</script>";
		}

		public function permohonanditerima($conn){
			$id = $this->valdata($conn, $_GET['id']);
			$pengguna = $this->getAuth($conn);

			$sql = "UPDATE permohonan SET permohonan_status_id = 2, pengesahan_oleh = ? WHERE id = ?";
				
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$pengguna['nama'], $id]);

			echo "<script>window.alert('Permohonan diterima.')</script>";
			echo "<script>window.location = '../ketua-jabatan/index.php'</script>";
		}

		public function wardenpermohonanditolak($conn){
			$id = $this->valdata($conn, $_GET['id']);
			$pengguna = $this->getAuth($conn);
			
			$isWeekend = $this->isWeekend();
			if($isWeekend){
				$sql = "UPDATE permohonan SET permohonan_status_id = 3, pengesahan_oleh = ? , pengesahan_warden_id = 3 WHERE id = ?";
				
				$stmt = $conn->prepare($sql);
				$rs = $stmt->execute([$pengguna['nama'], $id]);
			} else {
				$sql = "UPDATE permohonan SET pengesahan_warden_id = 3 WHERE id = ?";
				$stmt = $conn->prepare($sql);
				$rs = $stmt->execute([$id]);
			}

			if($rs){
				echo "<script>window.alert('Permohonan ditolak.')</script>";
				echo "<script>window.location = '../warden/index.php'</script>";
			}
		}

		public function wardenpermohonanditerima($conn){
			$id = $this->valdata($conn, $_GET['id']);
			$pengguna = $this->getAuth($conn);
			
			$isWeekend = $this->isWeekend();
			if($isWeekend){
				$sql = "UPDATE permohonan SET permohonan_status_id = 2, pengesahan_oleh = ? , pengesahan_warden_id = 2 WHERE id = ?";
				
				$stmt = $conn->prepare($sql);
				$rs = $stmt->execute([$pengguna['nama'], $id]);
			} else {
				$sql = "UPDATE permohonan SET pengesahan_warden_id = 2 WHERE id = ?";
				$stmt = $conn->prepare($sql);
				$rs = $stmt->execute([$id]);
			}

			if($rs){
				echo "<script>window.alert('Permohonan diterima.')</script>";
				echo "<script>window.location = '../warden/index.php'</script>";
			}
		}

		public function padampengguna($conn){
			$id = $this->valdata($conn, $_GET['id']);
			$sql = "DELETE FROM pengguna WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$id]);
			if($rs){
				echo "<script>window.alert('Pengguna berjaya dipadam.')</script>";
				echo "<script>window.location = '../admin/pengguna.php'</script>";
			}
		}

		public function padampelajar($conn){
			$id = $this->valdata($conn, $_GET['id']);
			$sql = "DELETE FROM pelajar WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$id]);
			if($rs){
				echo "<script>window.alert('Pelajar berjaya dipadam.')</script>";
				echo "<script>window.location = '../admin/pelajar.php'</script>";
			}
		}

		public function isWeekend() {
			$date = date("Y-m-d");
			$weekDay = date('w', strtotime($date));
			return ($weekDay == 0 || $weekDay == 6);
		}

		public function kemaskinipengguna($conn){
			$nama = $this->valdata($conn, $_POST['nama']);
			$role = $this->valdata($conn, $_POST['role']);
			$email = $this->valdata($conn, $_POST['email']);
			$id = $this->valdata($conn, $_POST['id']);

			$sql = "UPDATE pengguna SET nama = ?, role = ?, email = ? WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$nama, $role, $email, $id]);
			if($rs){
				echo "<script>window.alert('pengguna berjaya dikemaskini.')</script>";
				echo "<script>window.location = '../admin/pengguna.php'</script>";
			}
		}

		public function kemaskinipelajar($conn){
			$nama = $this->valdata($conn, $_POST['nama']);
			$nomatrik = $this->valdata($conn, $_POST['no_matrik']);
			$noic = $this->valdata($conn, $_POST['no_ic']);
			$nobilik = $this->valdata($conn, $_POST['no_bilik']);
			$agama = $this->valdata($conn, $_POST['agama']);
			$alamat = $this->valdata($conn, $_POST['alamat']);
			$notel = $this->valdata($conn, $_POST['no_tel']);
			$email = $this->valdata($conn, $_POST['email']);
			$id = $this->valdata($conn, $_POST['id']);

			$sql = "UPDATE pelajar SET nama = ?, no_matrik = ?, no_ic = ?, no_bilik = ?, agama = ?, alamat = ?, no_tel = ?, email = ? WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$nama, $nomatrik, $noic, $nobilik, $agama, $alamat, $notel, $email, $id]);
			if($rs){
				echo "<script>window.alert('Pelajar berjaya dikemaskini.')</script>";
				echo "<script>window.location = '../admin/pelajar.php'</script>";
			}
		}

		public function tambahpelajar($conn){
			$nama = $this->valdata($conn, $_POST['nama']);
			$nomatrik = $this->valdata($conn, $_POST['no_matrik']);
			$noic = $this->valdata($conn, $_POST['no_ic']);
			$nobilik = $this->valdata($conn, $_POST['no_bilik']);
			$agama = $this->valdata($conn, $_POST['agama']);
			$alamat = $this->valdata($conn, $_POST['alamat']);
			$notel = $this->valdata($conn, $_POST['no_tel']);
			$email = $this->valdata($conn, $_POST['email']);
			$password = md5($this->valdata($conn, $_POST['password']));

			$sql = "INSERT INTO pelajar (nama,no_matrik,no_ic,no_bilik,agama,alamat,no_tel,email,password) VALUES
					(?,?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$nama, $nomatrik, $noic, $nobilik, $agama, $alamat, $notel, $email, $password]);
			if($rs){
				echo "<script>window.alert('Pelajar berjaya didaftarkan.')</script>";
				echo "<script>window.location = '../admin/pelajar.php'</script>";
			}
		}

		public function tambahpengguna($conn){
			$nama = $this->valdata($conn, $_POST['nama']);
			$role = $this->valdata($conn, $_POST['role']);
			$email = $this->valdata($conn, $_POST['email']);
			$password = md5($this->valdata($conn, $_POST['password']));

			$sql = "INSERT INTO pengguna (nama,role,email,password) VALUES
					(?,?,?,?)";
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$nama,$role, $email, $password]);
			if($rs){
				echo "<script>window.alert('Pengguna berjaya didaftarkan.')</script>";
				echo "<script>window.location = '../admin/pengguna.php'</script>";
			}
		}

		public function permohonanbaru($conn){
			$tarikhkeluar = $this->valdata($conn, $_POST['tarikh_keluar']);
			$tarikhmasuk = $this->valdata($conn, $_POST['tarikh_masuk']);
			$alasan = $this->valdata($conn, $_POST['alasan']);
			$pelajar = $this->getAuth($conn);

			$sql = "INSERT INTO permohonan (pelajar_id, tarikh_permohonan, tarikh_keluar, tarikh_masuk, alasan) VALUES
					(?,NOW(),?,?,?)";
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$pelajar['id'], $tarikhkeluar, $tarikhmasuk, $alasan]);
			if($rs){
				echo "<script>window.alert('Permohonan berjaya dihantar.')</script>";
				echo "<script>window.location = '../pelajar/index.php'</script>";
			}
		}

		public function checkPermohonan($conn){
			$pelajar = $this->getAuth($conn);

			$sql = "SELECT * FROM permohonan WHERE pelajar_id = ". $pelajar['id'] ." AND permohonan_status_id = 1 OR pengesahan_warden_id = 1";
			$stmt = $conn->prepare($sql);
	        $stmt->execute();
			if ($stmt->rowCount() > 0) {
				return true;
			}

			return false;
		}
        
        public function getCount($conn, $tableName, $where = null){
			$sql = "SELECT count(id) as total FROM $tableName $where";
	        $stmt = $conn->prepare($sql);
	        $stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				return $row;	
			}
        }

		public function getSingleData($conn, $tableName , $query = false, $select = false, $join = false){
			if($query){
				$sql = "SELECT $tableName.* $select FROM $tableName $join WHERE $query";
			} else {
				$sql = "SELECT * FROM $tableName";
			}

	        $stmt = $conn->prepare($sql);
			$stmt->execute();
			
			if ($stmt) {
	        	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					return $row;	
				}
	        } else {
	        	return 0;
	        }
		}
        
        public function getListTableName($conn, $tableName , $query = false, $select = false, $join = false){
			if($query){
				$sql = "SELECT $tableName.* $select FROM $tableName $join WHERE $query";
			} else {
				$sql = "SELECT * FROM $tableName";
			}

	        $stmt = $conn->prepare($sql);
			$stmt->execute();
			
			if ($stmt) {
	        	while($row = $stmt->fetchAll()){
					return $row;
				}
	        } else {
	        	return 0;
	        }
		}
        
        public function getAuth($conn){

			if(isset($_SESSION['pengguna_id'])){
				$id = $_SESSION['pengguna_id'];
				$sql = "SELECT * FROM pengguna WHERE id = :id";
				
				$stmt = $conn->prepare($sql);
				$stmt->bindparam(':id', $id);
				$stmt->execute();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					return $row;	
				}
			} else if(isset($_SESSION['pelajar_id'])) {
				$id = $_SESSION['pelajar_id'];
				$sql = "SELECT * FROM pelajar WHERE id = :id";
				
				$stmt = $conn->prepare($sql);
				$stmt->bindparam(':id', $id);
				$stmt->execute();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					return $row;	
				}
			} else {
				return 0;
			}
		}

		public function register($conn){

			$name = $this->valdata($conn, $_POST['nama']);
			$email = $this->valdata($conn, $_POST['email']);
			$password = $this->valdata($conn, $_POST['password']);
			$password = md5($password);

			$sql = "INSERT INTO pengguna (nama, email, password) VALUES (?,?,?)";
			$stmt = $conn->prepare($sql);
			$rs = $stmt->execute([$name, $email, $password]);
			if($rs){
				echo "<script>window.alert('Berjaya didaftarkan. Sila log masuk.')</script>";
				echo "<script>window.location = '../login.php'</script>";
			}
		}

		public function login($conn){
			$email = $this->valdata($conn,$_POST['email']);
			$encrypted = md5($this->valdata($conn,$_POST['password']));

			//for admin
			$sql = "SELECT * FROM pengguna WHERE email = :email AND password = :encrypted";
	        $stmt = $conn->prepare($sql);
	        $stmt->bindparam(':email', $email);
	        $stmt->bindparam(':encrypted', $encrypted);
	        $stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if($user){
				$_SESSION['pengguna_id'] = $user['id'];
				$_SESSION['pengguna_role'] = $user['role'];

				echo "<script>window.alert('Hai ". $user['nama'] .", Welcome')</script>";

				if($user['role'] == 'admin'){
					echo "<script>window.location = '../admin/index.php'</script>";
				} else if ($user['role'] == 'warden') {
					echo "<script>window.location = '../warden/index.php'</script>";
				} else if ($user['role'] == 'guard') {
					echo "<script>window.location = '../guard/index.php'</script>";
				} else if ($user['role'] == 'ketua jabatan') {
					echo "<script>window.location = '../ketua-jabatan/index.php'</script>";
				}
				
				echo "<script>window.alert('Maaf, Anda tiada role di dalam sistem ini.')</script>";
				echo "<script>window.location = '../login.php'</script>";

			} else {
				$sqlStudent = "SELECT * FROM pelajar WHERE email = :email AND password = :encrypted";
				$stmtStudent = $conn->prepare($sqlStudent);
				$stmtStudent->bindparam(':email', $email);
				$stmtStudent->bindparam(':encrypted', $encrypted);
				$stmtStudent->execute();
				$student = $stmtStudent->fetch(PDO::FETCH_ASSOC);

				
				if($student){
					$_SESSION['pelajar_id'] = $student['id'];

					echo "<script>window.alert('Hai ". $student['nama'] .", Welcome')</script>";
					echo "<script>window.location = '../pelajar/index.php'</script>";
				} else {
					echo "<script>window.alert('username atau kata laluan anda salah, sila masukkan yang betul.')</script>";
					echo "<script>window.location = '../login.php'</script>";
				}
			}
		}

		public function valdata($conn, $inputpost) {
			if (is_array($inputpost) && count($inputpost) > 0) {
				foreach ($inputpost as $input) {
					$inputpost[] = trim($input);
					$inputpost[] = stripslashes($input);
					$inputpost[] = htmlspecialchars($input);
				}
				return $inputpost;
			} else {
				$inputpost = trim($inputpost);
				$inputpost = stripslashes($inputpost);
				$inputpost = htmlspecialchars($inputpost);
				return $inputpost;
			}
		}

		public function logout($conn){
			session_destroy();
			echo "<script>window.location='../'</script>";
		}

		public function open(){
			date_default_timezone_set("Asia/Kuala_Lumpur");

			$conn = "";
			$servername = "localhost";
			$dbname = "sistem-in-out";
			$username = "root";
			$password = "";

			try {
			    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			    // set the PDO error mode to exception
			    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    return $conn;
			}
			catch(PDOException $e)
			    {
			    echo "Connection failed: " . $e->getMessage();
			}
		}
		// --------------------------- END BASIC PART ---------------------------
	}
?>