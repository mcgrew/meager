<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:wfw="http://wellformedweb.org/CommentAPI/" version="1.0">
	<xsl:param name="count" select="0"/>
	<xsl:param name="title" select="/rss/channel/title"/>
	<xsl:output method="html"/>
	<xsl:template match="/">
		<xsl:apply-templates select="/rss/channel"/>
	</xsl:template>
	<xsl:template match="/rss/channel">
		<div class="rss">
			<h3>
				<xsl:value-of select="$title"/>
			</h3>
			<p>
				<xsl:value-of select="description"/>
			</p>
			<ul>
				<xsl:apply-templates select="item"/>
			</ul>
		</div>
	</xsl:template>
	<xsl:template match="/rss/channel/item">
		<xsl:if test="position() &lt;= $count or $count &lt; 1">
			<li>
				<a href="{link}" title="{substring(pubDate, 0, 11)}">
					<xsl:value-of select="title"/>
				</a>
				<p>
					<xsl:value-of select="description" disable-output-escaping="yes"/>
				</p>
			</li>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
