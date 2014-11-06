<?php   

	class CServer {
		
		/** comment here */
		function CServer() {
			
		}

		/** comment here */
		function getAvgServerLoad() {
			if(file_exists("/proc/loadavg")) {
				$load = file_get_contents("/proc/loadavg");
				$load = explode(' ', $load);
				Return floatval($load[0]);
			}
			else {
				if(function_exists("shell_exec")) {
				$load = explode(' ', `uptime`);
				return floatval($load[count($load)-1]);
				}
			}
		}

}

?>