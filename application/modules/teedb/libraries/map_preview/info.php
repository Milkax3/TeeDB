<?php
	/*
	 * Info
	 * Get Info data from map file
	 * 
	 * Note: unpack as much as possible at once to reach a better performance
	 */
	class Info{
		
		private $version;
		private $author;
		private $map_version;
		private $credits;
		private $license;
		private $settings;
		
		const TYPE_SIZE = 6;
		
		public function set_version($version){
			$this->version = $version;
		}
		
		public function set_author($author){
			$this->author = $author;
		}
		
		public function set_map_version($map_version){
			$this->map_version = $map_version;
		}
		
		public function set_credits($credits){
			$this->credits = $credits;
		}
		
		public function set_license($license){
			$this->license = $license;
		}
		
		public function set_settings($settings){
			$this->settings = $settings;
		}
		
	}