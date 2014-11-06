<?xml version="1.0" encoding="ISO_8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/rss">
<xsl:variable name="feedUrl" select="/rss/channel/generator"/>
<html>
<head>
<link rel="stylesheet" href="../css/rss.css" type="text/css"/>
</head>
<body style="margin:0px;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0px;">
	<tr>
		<td style="width:150px; background-image:url(../images/xml/leftborder.jpg); background-repeat: y-repeat;"> </td>
		<td>

			<div id="title" style="text-align: left; margin-left: 20px;">
				<a href="{channel/link}" class="title"><xsl:value-of select="channel/title" /></a>
				<div class="subtitle">RSS Feed powered by ShootOnline.com</div>
			</div>
			
			<div style="background-image: url(../images/xml/orangebar.gif); background-repeat: repeat-x; height: 400px; margin: 10px 20px; border: 1px solid #ccc">
				<table>
					<tr>
						<td class="descTitle">About this Feed:</td>
						<td class="std"><xsl:value-of select="channel/description" /></td>
					</tr>
					<tr>
						<td class="descTitle">Subscribe Now:</td>
						<td class="std">
								<p class="with">...with readers that support <strong>feed://</strong> links</p>
								<blockquote>
									<p>Popular news readers that support feed:// include:</p>
										<ul>
											<li>FeedDemon (Try it today. <a href="http://www.feedburner.com/fb/products/feeddemon-install.exe">Free Download!</a>)</li>
											<li>NetNewsWire</li>
											<li>NewsGator Outlook Edition</li>
											<li>Safari (OS X Tiger)</li>
											<li>SharpReader</li>
											<li>Shrook</li>
										</ul>
									<p><a href="{$feedUrl}" onclick="this.href='feed:'+ encodeURI('{$feedUrl}');return true" class="btn">Subscribe now using <strong>feed://</strong></a></p>
								</blockquote>
								<p class="with">...with web-based readers (click your choice below to subscribe)</p>
								<div id="webreaders" style="vertical-align: bottom;">
									<a class="img" href="#" onclick="this.href='http://add.my.yahoo.com/rss?url='+encodeURI('{$feedUrl}');return true"><img src="http://us.i1.yimg.com/us.yimg.com/i/us/my/addtomyyahoo4.gif" alt="Subscribe with My Yahoo!"/></a>
									<xsl:text disable-output-escaping="yes" >&amp;nbsp;</xsl:text>
									<a class="img" href="#" onclick="this.href='http://www.newsgator.com/ngs/subscriber/subext.aspx?url='+encodeURI('{$feedUrl}');return true"><img src="http://www.newsgator.com/images/ngsub1.gif" alt="Subscribe in NewsGator Online"/></a>
									<xsl:text disable-output-escaping="yes" >&amp;nbsp;</xsl:text>
									<a class="img" href="#" onclick="this.href='http://www.bloglines.com/sub/'+encodeURI('{$feedUrl}');return true"><img src="http://www.bloglines.com/images/sub_modern5.gif" alt="Subscribe with Bloglines"/></a>						
									<xsl:text disable-output-escaping="yes" >&amp;nbsp;</xsl:text>									
								</div>
								
								<p class="with">...with <strong>Universal Subscription Mechanism</strong><span>(<a href="http://www.kbcafe.com/rss/whatisthis.html#whatisusm" target="usm">what's this?</a>)</span></p>
								<blockquote>
								<p><a href="#" onclick="this.href = encodeUSMParam('{$feedUrl}');return true" class="btn">Subscribe now using USM</a></p>
								</blockquote>		
						</td>
					</tr>
				</table>
			</div>

			<xsl:for-each select="channel/item">
				<div class="item">
					<a href="{link}" class="itemTitle"><xsl:value-of select="title"/></a>
					<div class="itemDesc"><xsl:copy-of select="description"/></div>
				</div>
			</xsl:for-each>


			<div id="footer">
				<xsl:value-of select="channel/copyright" />
			</div>
		</td>
		<td style="width:150px; background-image:url(../images/xml/rightborder.jpg); background-repeat: y-repeat;"> </td>
	</tr>
</table>

</body>

</html>

</xsl:template>
</xsl:stylesheet>