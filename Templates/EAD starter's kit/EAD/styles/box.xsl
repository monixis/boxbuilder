<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns:xlink="http://www.w3.org/1999/xlink">
	<xsl:output method="html"/>
	<xsl:output
	doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
	doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"	/>
	<xsl:template match="ead">
		<html>
			<head>
				<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
				<script type="text/javascript" src="http://library.marist.edu/archives/researchcart/js/eadBox.js"></script>
				<link rel="stylesheet" href="styles/main.css" type="text/css" />
			</head>
			<body>

				<div id="bodyWrapper">
					<div id="header">
						<div id="logo">
							
						</div><!-- /logo -->
					</div><!-- /header -->
					<div id="menu">
						<div id="menuItems"></div><!-- /menuItems -->
					</div><!-- /menu -->
					<div id="noJS">
						<!-- Message to display when Javascript is disabled -->
						<noscript>
							<strong>
								<span>Your browser either does not support JavaScript, or is currently disabled.</span>
								<br/>
								<span>Please enable Javascript or install a Javascript compliant browser.</span>
							</strong>

						</noscript>
					</div><!-- No Javascript -->
					<div id="contentWrapper">
						<div id="bodyContent">
							<xsl:apply-templates select="eadheader"/>
							<div id="tblOptions">
								<a href="#" class="expand">Expand All</a>
								<a href="#" class="collapse">Collapse All</a>
							</div>
							<div id="tblElems">
								<xsl:apply-templates select="archdesc"/>
							</div>
							<div id="footerOptions"></div>	<!-- /footerOptions -->
						</div>

					</div><!-- /contentWrapper  -->

				</div><!-- /bodyWrapper -->

			</body>
		</html>
	</xsl:template>

	<!-- Template for eadheader -->
	<xsl:template match="eadheader">
		<xsl:apply-templates select="filedesc/titlestmt/titleproper"/>
	</xsl:template>
	<xsl:template match="titleproper">
		<title>
			<xsl:value-of select="."/>
		</title>
		<h1 class="heading">
			<xsl:value-of select="."/>
		</h1>

	</xsl:template>

	<!-- Template for archival description -->
	
	<xsl:template match="archdesc">
		<h2 class="heading">
			<xsl:value-of select="did/unittitle"/>
		</h2>
		<xsl:apply-templates select="dsc/c01"/>
	</xsl:template>
	
	
	<xsl:template match="c01">

		<table class="tbl" align="center">
			<xsl:for-each select="note">
				<tr class="Box">
					<td class="caption" colspan="4">
						<xsl:value-of select="."/>
					</td>
				</tr>
			</xsl:for-each>
			<tr class="tbldata">
				<th width="50px">File</th>
				<th width="600px">Contents</th>
				<th width="150px">Date</th>
			</tr>
			
			<xsl:for-each select="c02">
				<tr class="tbldata">
					<td class="tableFont">
						<xsl:value-of select="did/unitid"/>
					</td>
					<td class="data">
						<xsl:value-of select="did/unittitle"/>
					</td>
					<td class="tableFont">
						<xsl:value-of select="did/unitdate"/>
					</td>
					
				</tr>

			</xsl:for-each>

		</table>
		<br />

	</xsl:template>

</xsl:stylesheet>
