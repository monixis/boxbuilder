<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Boxbuilder</title>
		<meta name="description" content="" />
		<meta name="author" content="Monish.Singh1" />
		<link rel="stylesheet" type="text/css" href="style/main.css" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="jquery.csv.js"></script>
		<script>
			$(document).ready(function() {
				var data = " ";
				if (isAPIAvailable()) {
					$('#files').bind('change', handleFileSelect);
				}

				$('#submit').click(function() {
					$('#step3').css('visibilty', 'visible');
				});

			});

			function isAPIAvailable() {
				// Check for the various File API support.
				if (window.File && window.FileReader && window.FileList && window.Blob) {
					// Great success! All the File APIs are supported.
					return true;
				} else {
					// source: File API availability - http://caniuse.com/#feat=fileapi
					// source: <output> availability - http://html5doctor.com/the-output-element/
					document.writeln('The HTML5 APIs used in this form are only available in the following browsers:<br />');
					// 6.0 File API & 13.0 <output>
					document.writeln(' - Google Chrome: 13.0 or later<br />');
					// 3.6 File API & 6.0 <output>
					document.writeln(' - Mozilla Firefox: 6.0 or later<br />');
					// 10.0 File API & 10.0 <output>
					document.writeln(' - Internet Explorer: Not supported (partial support expected in 10.0)<br />');
					// ? File API & 5.1 <output>
					document.writeln(' - Safari: Not supported<br />');
					// ? File API & 9.2 <output>
					document.writeln(' - Opera: Not supported');
					return false;
				}
			}

			function handleFileSelect(evt) {
				var files = evt.target.files;
				// FileList object
				var file = files[0];

				// read the file metadata
				var output = ''
				output += '<span style="font-weight:bold;">' + escape(file.name) + '</span><br />\n';
				output += ' - FileType: ' + (file.type || 'n/a') + '<br />\n';
				output += ' - FileSize: ' + file.size + ' bytes<br />\n';
				output += ' - LastModified: ' + (file.lastModifiedDate ? file.lastModifiedDate.toLocaleDateString() : 'n/a') + '<br />\n';

				// read the file contents
				printTable(file);

				// post the results
				$('#list').append(output);
			}

			function printTable(file) {
				var reader = new FileReader();
				reader.readAsText(file);
				reader.onload = function(event) {
					var csv = event.target.result;
					data = $.csv.toArrays(csv);
					var html = '';
					var boxcontents = '';
					for (var row in data) {
						html += '<tr>\r\n';
						for (var item in data[row]) {

							html += '<td>' + data[row][item] + '</td>\r\n';
						}
						html += '</tr>\r\n';
					}

					$('#contents').height(400).html(html);

					/*var x = 0;
					 var cond1 = false;
					 while (data) {
					 if (data[x][0] == 'Box') {
					 cond1 = true;
					 break;
					 } else {
					 x++;
					 }
					 }*/

					var x = 0;
					var cond1 = false;
					var repository = " ";
					var address = " ";
					var author = " ";
					var seriesid = " ";
					var title = " ";
					var url = " ";
					var collection = " ";

			/*		while (data) {
						if (data[x][0].trim() == 'Box') {
							cond1 = true;
							break;
						} else if (data[x][0].trim() == 'Repository') {
							repository = data[x][1];
						} else if (data[x][0].trim() == 'Address') {
							address = data[x][1];
						} else if (data[x][0] == 'Author') {
							author = data[x][1];
						} else if (data[x][0] == 'Series Id') {
							seriesid = data[x][1];
						} else if (data[x][0] == 'Title') {
							title = data[x][1];
						} else if (data[x][0] == 'URL') {
							url = data[x][1];
						} else if (data[x][0] == 'Collection') {
							collection = data[x][1];
						}

						x++;
					}

			*/	while (data) {
						if (data[x][0].trim() == 'Box') {
							cond1 = true;
							break;
						} else {
							repository = data[0][1];
							address = data[1][1];
							url = data[2][1];
							collection = data[3][1];
							author = data[4][1];
							seriesid = data[5][1];
							title = data[6][1];
						}

						x++;
					}
					
					var boxcontents = "<\?xml version='1.0' encoding='UTF-8'?><!DOCTYPE ead PUBLIC \"+//ISBN 1-931666-00-8//DTD ead.dtd (Encoded Archival Description (EAD) Version 2002)//EN\" 'ead.dtd'><\?xml-stylesheet type='text/xsl' href='styles/box.xsl'?><ead><eadheader><eadid countrycode='us' url='" + url + "'>" + seriesid + "</eadid><filedesc><titlestmt><titleproper>" + collection + "</titleproper><author>" + author + "</author></titlestmt><publicationstmt><publisher>" + repository + "</publisher><address><addressline>" + address + "</addressline></address></publicationstmt></filedesc></eadheader><archdesc level='subseries'><did><unitid countrycode='us'>" + seriesid + "</unitid><unittitle>" + title + "</unittitle><unitdate type='inclusive'></unitdate><physdesc><extent></extent></physdesc><repository><corpname>" + repository + "</corpname></repository><langmaterial><language langcode='eng'>English</language></langmaterial></did><dsc type='combined'>";

					if (cond1 == true) {
						for (var i = x; i < data.length; i++) {

							if (data[i][0].trim() == 'Box') {

								if (i == x) {
									boxcontents = boxcontents + "<c01><note>" + data[i][1].trim() + "</note>";
								} else {
									boxcontents = boxcontents + "</c01><c01><note>" + data[i][1].trim() + "</note>";
								}

								i = i + 1;
							} else {
								boxcontents = boxcontents + "<c02 level ='file'><did><unitid>" + data[i][0].trim() + "</unitid><unittitle>" + data[i][1].trim() + "</unittitle><unitdate label='Date'>" + data[i][2].trim() + "</unitdate></did></c02>";
								//boxcontents = boxcontents + "<c02 level ='file'><did><unitid>" + data[i][0].trim() + "</unitid><unittitle>" + data[i][1].trim() + "</unittitle><unitdate label='Date'>" + data[i][2].trim() + "</unitdate><physdesc><physfacet type='color'>" + data[i][3].trim() + "</physfacet><physfacet type='format'>" + data[i][4].trim() + "</physfacet></physdesc><note><p>" + data[i][5].trim() + "</p></note></did></c02>";
					
							}

						}
						boxcontents = boxcontents + "</c01></dsc></archdesc></ead>";
						boxcontents = boxcontents.replace(/&/g, "&amp;");

						$('#csvdata').val(boxcontents);
						$('#EADfilename').val(seriesid);
					}

				};
				reader.onerror = function() {
					alert('Unable to read ' + file.fileName);
				};

			}

		</script>
	</head>

	<body>
		<div id="headerContainer">
			<div id="header">

			</div>
		</div>
		<div class="container_home">

			<div class="divContainer">

				<div id="step1">
					<p>Access the <a href='http://library.marist.edu/boxbuilder/'>Boxbuilder 2.0 </a>version that converts to EAD 3.</p>
					<h1>Step 1: Download the Boxbuilder CSV template or use Excel template to catalog the files.</h1>
					<iframe src="https://app.box.com/embed_widget/s/w53n1n3u73p3vh4ffxzb?view=list&sort=name&direction=ASC&theme=gray" width="600" height="300" frameborder="0"allowfullscreen webkitallowfullscreen msallowfullscreen></iframe>
				
					<p>
						If you are using an Excel template, please convert it to a CSV file by using the 'Save as' option in Microsoft Excel or Google Spreadsheet.
					</p>
				</div>

				<div id="step2">
					<h1>Step 2: Select the csv file to encode</h1>
					<form action="boxbuilder2.php" method="post" id="csvfile">
						<label for="file" class="labels">Filename:</label>
						<input type="file" name="files[] multiple" id="files" class="labels">
						<br />
						<input type="hidden" name="csvdata" id="csvdata" />
						<input type="hidden" name="EADfilename" id="EADfilename" />
						<input type="submit" name="submit" value="Convert to EAD 2002 and Download the file" class="labels" id="submit" style="margin-left: 99px; width: 400px; margin-top: 7px;" />
					</form>
				</div>
<div id="contents">
					<table name="c"></table>
				</div>

				<div id="step3" style="height: auto;">
					<h1>Step 3: Download the EAD Starter's Kit, add the converted EAD file to the 'EAD' folder.</h1>
					<p>
						Feel free to replace the name 'EAD Starter's Kit' with your collection name. Please use firefox to view the files. Google chrome does not render local xml files. It will work once its online.
					</p>
				</div>
				<div id="bottom">
			<p style="text-align: center;">This website and the Boxbuilder tool is developed and maintained by <a href="https://www.linkedin.com/in/monishsingh" target="_blank">Monish Singh</a></p>
		</div>
			</div>

		</div>
		
		<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55890383-1', 'auto');
  ga('send', 'pageview');

</script>

	</body>
</html>
