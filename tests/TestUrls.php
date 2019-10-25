<?php

use PHPUnit\Framework\TestCase;
use eURL\Functions as url;

final class ValidUrls extends TestCase
{
    /**
     * @dataProvider validUrlProvider
     */
	public function testValidUrl($url): void
	{
		$this->assertSame($url, url\e($url));
	}

    /**
     * @dataProvider invalidUrlProvider
     */
	public function testInvalidUrl($url, $expected): void
	{
		$this->assertSame($expected, url\e($url));
	}

	/**
     * @codeCoverageIgnore
     */
    public function validUrlProvider(): array
    {
        return [

			// simple urls
			['http://google.com'],
			['http://google.com#fragment'],
			['http://google.com/#fragment'],
			['http://google.com?q1=v1&q2v2'],
			['http://google.com?q1=v1&q2v2='],
			['http://google.com/?q1=v1&q2v2'],
			['http://google.com/?q1=v1&q2v2='],
			['https://google.com'],
			['https://google.com#fragment'],
			['https://google.com/#fragment'],
			['https://google.com?q1=v1&q2v2'],
			['https://google.com/?q1=v1&q2v2'],
			['http://google.com/page#fragment'],
			['http://google.com/page/#fragment'],
			['http://google.com?q1=v1&q2v2=#fragment'],
			['http://google.com/?q1=v1&q2v2=#fragment'],
			['http://google.com?q1=v1&q2v2#fragment'],
			['http://google.com/?q1=v1&q2v2#fragment'],
			
			// copy and pasted
			['https://stackoverflow.com/questions/2681786/how-to-get-the-last-char-of-a-string-in-php'],
			['https://www.google.com/search?sxsrf=ACYBGNTJ6_E7vGHuXly-wapQEdX0-WR2eg%3A1571805081701&source=hp&ei=mdevXdCQKL685OUPwY-SqAs&q=test&btnK=Pesquisa+Google&oq=mail+url&gs_l=psy-ab.3..0i203l4j0i22i30l6.48741.49673..50184...0.0..0.98.570.8......0....1..gws-wiz.......35i39j0j0i67j0i10i203.wUQYlQVEwxU&ved=0ahUKEwiQwbGcxrHlAhU-HrkGHcGHBLUQ4dUDCAY&uact=5'],
			['https://www.google.com/search?q=test&sxsrf=ACYBGNSqRqbaCthrNVueRbiXQlYaA64AxQ1571808636488&source=lnms&tbm=isch&sa=X&ved=0ahUKEwjo6Lq707HlAhUfGbkGHaM1AacQ_AUIEigB&biw=1920&bih=878#imgrc=fZg5jDE2xDewFM'],
			['https://www.google.com/aclk?sa=L&ai=DChcSEwjA4ZLf07HlAhXECZEKHV5YAOMYABAAGgJjZQ&sig=AOD64_33mdKrF1qaxefqngRdnf_JGHc7Cw&q=&ved=2ahUKEwijgI3f07HlAhWKIbkGHdhuDsUQ0Qx6BAgNEAE&adurl='],
			['https://www.facebook.com/photo.php?fbid=2272467782784102&set=a.378834528814113&type=3&theater'],
			['https://www.google.com/search?sxsrf=ACYBGNTJ6_E7vGHuXly-wapQEdX0-WR2eg%3A1571805081701&source=hp&ei=mdevXdCQKL685OUPwY-SqAs&q=t%C3%A9ste+busca+com+acento&btnK=Pesquisa+Google&oq=mail+url&gs_l=psy-ab.3..0i203l4j0i22i30l6.48741.49673..50184...0.0..0.98.570.8......0....1..gws-wiz.......35i39j0j0i67j0i10i203.wUQYlQVEwxU&ved=0ahUKEwiQwbGcxrHlAhU-HrkGHcGHBLUQ4dUDCAY&uact=5'],
		
			// double enconding
			["http://google.com?v1=1%3C2"],
			["http://google.com?1%3C2=v1"],
			["http://google.com/1%3C2/?te=12&b="],

			// relative
			['/relative'],
			['/relative/test/'],
			['/relative#fragment'],
			['/relative/#fragment'],
			['/relative?q1=v1&q2v2'],
			['/relative?q1=v1&q2v2='],
			['/relative/?q1=v1&q2v2'],
			['/relative/?q1=v1&q2v2='],
			['/relative/page#fragment'],
			['/relative/page/#fragment'],
			['/relative?q1=v1&q2v2=#fragment'],
			['/relative/?q1=v1&q2v2=#fragment'],
			['/relative?q1=v1&q2v2#fragment'],
			['/relative/?q1=v1&q2v2#fragment'],
			['relative'],
			['relative/test/'],
			['relative#fragment'],
			['relative/#fragment'],
			['relative?q1=v1&q2v2'],
			['relative?q1=v1&q2v2='],
			
		];
	}

	/**
     * @codeCoverageIgnore
     */
    public function invalidUrlProvider(): array
    {
		return [

			// encoding
			["http://google.com?v1=1<2", "http://google.com?v1=1%3C2"],
			["http://google.com?1<2=v1", "http://google.com?1%3C2=v1"],
			["http://goo>:gle.com?v1=12", ""], //Those chars at the domain level makes the url invalid, therefore the result should be empty.
			["http://google.com/1<2/?te=12&b=", "http://google.com/1%3C2/?te=12&b="],

			// without scheme
			['google.com', 'http://google.com'],
			['google.com#fragment', 'http://google.com#fragment'],
			['google.com/#fragment', 'http://google.com/#fragment'],
			['google.com?q1=v1&q2v2', 'http://google.com?q1=v1&q2v2'],
			['google.com/?q1=v1&q2v2=#fragment', 'http://google.com/?q1=v1&q2v2=#fragment'],
			['subdomain.google.com', 'http://subdomain.google.com'],
			['subdomain.google.com#fragment', 'http://subdomain.google.com#fragment'],
			['subdomain.google.com/#fragment', 'http://subdomain.google.com/#fragment'],
			['subdomain.google.com?q1=v1&q2v2', 'http://subdomain.google.com?q1=v1&q2v2'],
			['subdomain.google.com/?q1=v1&q2v2=#fragment', 'http://subdomain.google.com/?q1=v1&q2v2=#fragment'],
			['subdomain.subdomain.google.com', 'http://subdomain.subdomain.google.com'],
			['subdomain.subdomain.google.com#fragment', 'http://subdomain.subdomain.google.com#fragment'],
			['subdomain.subdomain.google.com/#fragment', 'http://subdomain.subdomain.google.com/#fragment'],
			['subdomain.subdomain.google.com?q1=v1&q2v2', 'http://subdomain.subdomain.google.com?q1=v1&q2v2'],
			['subdomain.subdomain.google.com/?q1=v1&q2v2=#fragment', 'http://subdomain.subdomain.google.com/?q1=v1&q2v2=#fragment'],

			// relative enconding
			["/relative?v1=1<2", "/relative?v1=1%3C2"],
			["/relative?1<2=v1", "/relative?1%3C2=v1"],
			["http://goo>:gle.com?v1=12", ""], //Those chars at the domain level makes the url invalid, therefore the result should be empty.
			["/relative/1<2/?te=12&b=", "/relative/1%3C2/?te=12&b="],
			["/relative/1<2/?te=12&b=", "/relative/1%3C2/?te=12&b="],


			// XSS

			//Should escape the path
			['http://example.com/"><script>alert("xss")</script>', 'http://example.com/%22%3E%3Cscript%3Ealert(%22xss%22)%3C/script%3E'],
			["http://example.com/'><script>alert('xss')</script>", "http://example.com/%27%3E%3Cscript%3Ealert(%27xss%27)%3C/script%3E"],

			//Shouldn't accept javascript scheme
			["javascript://test%0Aalert(321)", ''],
			["javascript://alert(1)",'' ],
			[" javascript://alert(1)", ''],

			//Should escape the query string
			["http://google.com?q1=\"<script>alert(1)</script>", "http://google.com?q1=%22%3Cscript%3Ealert(1)%3C/script%3E"],
			["http://google.com/\"<script>alert(1)</script>/?q1", "http://google.com/%22%3Cscript%3Ealert(1)%3C/script%3E/?q1"],
			["http://google.com/#\"<script>alert(1)</script>/?q1", "http://google.com/#%22%3Cscript%3Ealert(1)%3C/script%3E/?q1"],

		];
	}
}
