<?php 
Class settings{
	public static $dbHost = "localhost";
	public static $dbUser = "pcsdgovp_pcsd_app";
	public static $dbPass = "pcsdapp7611";
	public static $databaseInstall = array(

			array("pcsdgovp_pcsd_app","users","id_number TEXT,user_key VARCHAR(200) NOT NULL,data TEXT,status INT(1) default 1,user_level INT(3),date VARCHAR(64) NOT NULL,last_update TIMESTAMP"),
			
			// document tracking 
			array("pcsdgovp_wp131","wp53_pdt_assignee",""),
			array("pcsdgovp_wp131","wp53_pdt_attachments",""),
			array("pcsdgovp_wp131","wp53_pdt_documents",""),
			array("pcsdgovp_wp131","wp53_pdt_images",""),
			array("pcsdgovp_wp131","wp53_pdt_meta",""),

			//permitting
			array("pcsdgovp_pcsd_app","permitting_accounts","user_name VARCHAR(100),user_pass VARCHAR(200) NOT NULL,data TEXT,status INT(1) default 1,user_level INT(3) default 0,date VARCHAR(64) NOT NULL,last_update TIMESTAMP"),
			array("pcsdgovp_pcsd_app","transactions","user_id INT(11) default 0,name VARCHAR(300),data TEXT ,status INT(1) default 0,date VARCHAR(64) NOT NULL,last_update TIMESTAMP"),
			array("pcsdgovp_pcsd_app","permitting_notifications","user_id INT(11) default 0,name VARCHAR(300),data TEXT ,status INT(1) default 0,date VARCHAR(64) NOT NULL"),
			
			//DATABASE
			array("pcsdgovp_pcsd_app","pab_admin_cases","case_no VARCHAR(64),date_filed VARCHAR(64) NOT NULL,data TEXT ,status INT(2) default 0,date VARCHAR(64) NOT NULL,last_update TIMESTAMP"),
			array("pcsdgovp_pcsd_app","intel","data TEXT ,status INT(1) default 0,date VARCHAR(64) NOT NULL,last_update TIMESTAMP"),
			array("pcsdgovp_pcsd_app","geolocation","data TEXT ,date VARCHAR(64) NOT NULL"),
			array("pcsdgovp_pcsd_app","notification","item_id INT(11) default 0,item_type VARCHAR(200) default '',data TEXT,user_id VARCHAR(200) default '',date VARCHAR(64) NOT NULL,last_update TIMESTAMP"),
			array("pcsdgovp_pcsd_app","permits","type VARCHAR(100) default '',data TEXT,user_id INT(11) default '0',date VARCHAR(64) NOT NULL,last_update TIMESTAMP"),

			//Accounting
			array("pcsdgovp_pcsd_app", "Accounting_JAO", "ObrNo VARCHAR(200), data TEXT,  AllotmentClass VARCHAR(200), Type_Expenses VARCHAR(200), Month_Date VARCHAR(200), Year_Date VARCHAR(200), DIVISION VARCHAR(200)"),
			array("pcsdgovp_pcsd_app", "Accounting_JAO_Budget", "Year VARCHAR(200), Month VARCHAR(200),AllotmentClass VARCHAR(200),Division VARCHAR(200), data TEXT"),

			//Fuel Logs
			array("pcsdgovp_pcsd_app","fuel_logs","trip_ticket_id VARCHAR(64),data TEXT,date VARCHAR(64) NOT NULL,last_update TIMESTAMP"),

				
		);

	public static $initialData = array(
			array( "users", array( "user_key"=>"SHA256:1000:NqGykZzQN3irawfpt8RzIeiVLpLgJxRa:sz8+YAHZ2PKOQweniipasHSkY+KxA/py","data"=>"{}", "id_number"=>"00","status"=>1, "user_level"=>99 ) ),
		);
}
 ?>