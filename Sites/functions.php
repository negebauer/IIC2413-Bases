<?php

	class DB 
	{
		// #################### DECLARACION BASES DE DATOS ####################
		public static $dbhost;
		public static $dbname;
		public static $mongo;
		public static $dbm;
		public static $dbp;

		static function init()
		{
			self::$dbhost = "localhost";
			self::$dbname = "test";
			self::$mongo = new MongoClient("mongodb://$dbhost");
			self::$dbm = $mongo->$dbname;
			try {
				self::$dbp = new PDO("pgsql:dbname=grupo5;host=localhost;port=5432;user=grupo5;password=gruponico");
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}

	function verificarUsuario()
    {
    	$esAdmin = false;
		$esAlumno = false;
		$esAlumnoIntercambio = false;
		$esProfesor = false;

        $queryAdmins = "SELECT username
						FROM administrador;";
		
		$queryAlumnos = "SELECT username
						FROM alumno;";
		
		$queryAlumnosIntercambio = "SELECT username
									FROM alumnointercambio;";
		
		$queryProfesores = "SELECT username
							FROM profesor;";
		
		$adminsRowArray = DB::$dbp->query($queryAdmins)->fetchAll();
		$alumnosRowArray = DB::$dbp->query($queryAlumnos)->fetchAll();
		$alumnosIntercambioRowArray = DB::$dbp->query($queryAlumnosIntercambio)->fetchAll();
		$profesoresRowArray = DB::$dbp->query($queryProfesores)->fetchAll();
		
		$admins = [];
		$alumnos = [];
		$alumnosIntercambio = [];
		$profesores = [];
		
		foreach ($adminsRowArray as $admin)
		{
			array_push($admins, $admin[0]);
		}
		foreach ($alumnosRowArray as $alumno)
		{
			array_push($alumnos, $alumno[0]);
		}
		foreach ($alumnosIntercambioRowArray as $alumnoIntercambio)
		{
			array_push($alumnosIntercambio, $alumnoIntercambio[0]);
		}
		foreach ($profesoresRowArray as $profesor)
		{
			array_push($profesores, $profesor[0]);
		}
		
		if (in_array($username, $admins))
		{
			$esAdmin = true;
		}
		elseif (in_array($username, $alumnos))
		{
			$esAlumno = true;
		}
		elseif (in_array($username, $alumnosIntercambio))
		{
			$esAlumnoIntercambio = true;
		}
		elseif (in_array($username, $profesores))
		{
			$esProfesor = true;
		}

		return array ($esAdmin, $esAlumno, $esAlumnoIntercambio, $esProfesor);
    }

?>