<?php

use PayPal\Common\PPUserAgent;

class UserAgentTest extends PHPUnit_Framework_TestCase {
	
	public function testGetValue() {
		$ua = PPUserAgent::getValue("name", "version");
		list($id, $version, $features) = sscanf($ua, "PayPalSDK/%s %s (%s)");
		
		// Check that we pass the useragent in the expected format
		$this->assertNotNull($id);
		$this->assertNotNull($version);
		$this->assertNotNull($features);
		
		$this->assertEquals("name", $id);
		$this->assertEquals("version", $version);
		
		// Check that we pass in these mininal features
		$this->assertThat($features, $this->stringContains("OS="));
		$this->assertThat($features, $this->stringContains("Bit="));
		$this->assertThat($features, $this->stringContains("Lang="));
		$this->assertThat($features, $this->stringContains("V="));
		$this->assertGreaterThan(5, count(explode(';', $features)));
	}
}