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
		var dataForarch = [];
		
			$(document).ready(function() {
				var data = " ";
				 
				if (isAPIAvailable()) {
					$('#files').bind('change', handleFileSelect);
				}

				$('#submit').click(function() {
					$('#step3').css('visibilty', 'visible');
				});
				
				$('#convert2Arch').click(function(){
					var archcsv = 'filename,dc.title,dcterms.issued,dc.publisher,dc.contributor,dc.subject,dc.date,dc.description,notes,dcterms.isPartOf,repository,dc.rights,project_website,dc.format\n';
					dataForarch.forEach(function(row) {
           				 archcsv = archcsv + row.join(',');
           				 archcsv = archcsv + "\n";
    				});
    				
    				var hiddenElement = document.createElement('a');
    				hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(archcsv);
    				hiddenElement.target = '_blank';
    				hiddenElement.download = 'metadata.csv';
    				hiddenElement.click();
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
					var x = 0;
					var cond1 = false;
					var	repository = " ";
					var publisher = " ";
					var address = " ";
					var url = " ";
					var collection = " ";
					var date = " ";
					var creator = " ";
					var recordid = " ";
					var title = " ";
					var c1 = " ";
					var c1id = " ";
					var c2 = " ";
					var c2id = " ";
					var c3 = " ";
					var c3id = " ";
					var c4 = " ";
					var c4id = " ";
					var c5 = " ";
					var c5id = " ";
					var c6 = " ";
					var c6id = " ";
					var serieslevel = " ";
					var seriesend = " ";
					var cno = 0;
					var boxlevel = "<c03 level='recordgrp'>";
					var boxlevelend = "</c03>";
					var itemlevel ="<c04 level='item'>";
					var itemlevelend ="</c04>";
					var controlaccess = " ";
					var accessrestrict = " ";
					var userestrict = " ";
					var scopecontent = " ";
					var bioghist = " ";
					var physdesc = " ";
					var collectiondate = " ";
					var language = " ";
					var context = " ";
					var currbox = " ";
					var filename = " ";

			while (data) {
						if (data[x][0].trim() == 'Box') {
							cond1 = true;
							break;
						} else {
							
							repository = data[1][1];
							publisher = data[2][1];
							address = data[3][1];
							//url = data[3][1];
							collection = data[4][1];
							date = data[5][1];
							creator = data[6][1];
							recordid = data[14][1];
							title = data[14][2];
							//physdesc = data[11][1];
							//collectiondate = data[10][1];
							accessrestrict = data[9][1];
							userestrict = data[10][1];
							//scopecontent = data[15][1];
							//bioghist = data[16][1];
							
							context = collection + " - " + data[18][2];
							
							for(var y = 18; y < 25 ; y++){
								if(data[y][0].trim() == 'Sub Series'){
									if (data[y][2].trim()){
										context = context + " - " + data[y][2];
									}
								}
							}
							
							if (language = " "){
								for (var z=1; z<9 ; z++){
									if(data[17][z])
										{
										language = language + "<language>" + data[17][z] + "</language>";		
										}
									}
							}
								
							if(data[7][1].trim()){
								collectiondate = "<unitdatestructured unitdatetype='" + data[7][3].trim() + "'><daterange><fromdate>" + data[7][1].trim() + "</fromdate><todate>" + data[7][2].trim() + "</todate></daterange></unitdatestructured>";
							}else{
								collectiondate = " ";
							}
							
							if(data[8][1].trim()){
								physdesc = "<physdescstructured physdescstructuredtype='" + data[8][3].trim() + "' coverage='" + data[8][4].trim() + "'><quantity>" + data[8][1].trim() + "</quantity><unittype>" + data[8][2].trim() + "</unittype></physdescstructured>";
							}else{
								physdesc = " ";
							}
							
							if(data[11][1].trim()){
								scopecontent = "<scopecontent><p>" + data[11][1].trim() + "</p></scopecontent>";
							}else{
								scopecontent = " ";
							}
							
							if(data[12][1].trim()){
								bioghist = "<bioghist><p>" + data[12][1].trim() + "</p></bioghist>";
							}else{
								bioghist = " ";
							}
							
							if (data[15][1].trim()){
								controlaccess = "<controlaccess><genreform><part>" + data[15][1].trim() + "</part></genreform>";
								if(data[16][1].trim()){
									controlaccess = controlaccess + "<geogname source='" + data[16][3].trim() + "' identifier='" + data[16][2].trim() + "'><part>" + data[16][1].trim() + "</part></geogname></controlaccess>"; 
								}else{
									controlaccess = controlaccess + "</controlaccess>";
								}
							}else if (data[16][1].trim()){
								controlaccess = "<controlaccess><geogname source='" + data[16][3].trim() + "' identifier='" + data[16][2].trim() + "'><part>" + data[16][1].trim() + "</part></geogname></controlaccess>"; 
							}
							/*seriesid = data[8][1];
							series = data[8][2];*/
							serieslevel = "<c01 level='collection'><did><unittitle>" + data[4][1].trim() + "<ptr href='" + data[4][2].trim() + "'></ptr></unittitle></did><c02 level='series'><did><unitid>" + data[18][1].trim() + "</unitid><unittitle>" + data[18][2].trim() + "</unittitle></did>";
							seriesend = "</c02></c01></dsc></archdesc></ead>";						
							for(var j = 19 ; j < 24; j++){
								if(data[j][0].trim() == 'Sub Series'){
									if(data[j][1].trim()){
										cno = j - 16;
										serieslevel = serieslevel + "<c0" + cno + " level='subseries'><did><unitid>" + data[j][1].trim() + "</unitid><unittitle>" + data[j][2].trim() + "</unittitle></did>";
										seriesend = "</c0" + cno + ">" + seriesend ;
										cno = cno + 1;
										if (cno < 10){
											boxlevel = "<c0" + cno + " level='recordgrp'>";
											boxlevelend = "</c0" + cno + ">";
										}else{
											boxlevel = "<c" + cno + "> level='recordgrp'";
											boxlevelend = "</c" + cno + ">";
										}
										cno = cno + 1;
										if(cno < 10){
											itemlevel = "<c0" + cno + " level='item'>";
											itemlevelend = "</c0" + cno + ">";
										}else{
											itemlevel = "<c" + cno + " level='item'>";
											itemlevelend = "</c" + cno + ">";
										}
									}
										
								}
							}
							
						}
						x++;
						
					}
					
					var boxcontents = "<\?xml version='1.0' encoding='UTF-8'?><\?xml-stylesheet type='text/xsl' href='./styles/boxbuilder.xsl'?><ead><!-- EAD3 required element --><control countryencoding='iso3166-1' dateencoding='iso8601' langencoding='iso639-2b' repositoryencoding='iso15511' scriptencoding='iso15924'> <!-- EAD3 required element --><recordid instanceurl='" + url + "'>" + recordid + "</recordid> <!-- EAD3 required element --><filedesc> <!-- EAD3 required element --><titlestmt> <!-- EAD3 required element --><titleproper>" + title + "</titleproper><!-- Required element within titlestmt --></titlestmt><publicationstmt><publisher>" + publisher + "</publisher><date>" + date + "</date><address><addressline>"+ address +"</addressline></address><p><ref href='https://creativecommons.org/publicdomain/zero/1.0/'>CC0 1.0 Universal (CC0 1.0) Public Domain Dedication</ref></p></publicationstmt><notestmt><controlnote><p>"+ context +"</p></controlnote></notestmt></filedesc></control><archdesc level='collection'><!-- EAD3 required element --><did><!-- EAD3 required element --><repository><corpname source='" + data[1][3] + "' identifier='" + data[1][2] + "'><part>"+ repository +"</part></corpname><address><addressline>" + address + "</addressline></address></repository><origination source='" + data[6][3] + "' identifier='" + data[6][2] + "'><!-- Optional EAD3 element, added to comply with DACS requirement for 'Name of Creator(s) Element'. The new <relations> element can satisfy this and expand on it, but as <relations> is experimental, use of <origination> is recommended for now --><persname><part>" + creator + "</part></persname></origination><unittitle>"+ title +"</unittitle><!-- Optional EAD3 element, added to comply with DACS requirement for 'Title Element' --><unitid>"+ recordid +"</unitid> <!-- Optional EAD3 element, added to comply with 'Reference Code Element' of DACS requirement -->" + collectiondate + physdesc + "<langmaterial>" + language + "</langmaterial></did><accessrestrict> <!-- Optional EAD3 element, added to comply with DACS requirement for 'Conditions Governing Access Element' --><p>"+ accessrestrict +"</p></accessrestrict><userestrict> <!-- Optional EAD3 element, added to comply with DACS requirement for 'Conditions Governing Access Element' --><p>"+ userestrict +"</p></userestrict>" + scopecontent + bioghist + controlaccess + "<dsc>";
					//var boxcontents = "<\?xml version='1.0' encoding='UTF-8'?><!DOCTYPE ead PUBLIC \"+//ISBN 1-931666-00-8//DTD ead.dtd (Encoded Archival Description (EAD) Version 2002)//EN\" 'ead.dtd'><\?xml-stylesheet type='text/xsl' href='styles/box.xsl'?><ead><eadheader><eadid countrycode='us' url='" + url + "'>" + seriesid + "</eadid><filedesc><titlestmt><titleproper>" + collection + "</titleproper><author>" + author + "</author></titlestmt><publicationstmt><publisher>" + repository + "</publisher><address><addressline>" + address + "</addressline></address></publicationstmt></filedesc></eadheader><archdesc level='subseries'><did><unitid countrycode='us'>" + seriesid + "</unitid><unittitle>" + title + "</unittitle><unitdate type='inclusive'></unitdate><physdesc><extent></extent></physdesc><repository><corpname>" + repository + "</corpname></repository><langmaterial><language langcode='eng'>English</language></langmaterial></did><dsc type='combined'>";

					boxcontents = boxcontents + serieslevel;

					if (cond1 == true) {
						for (var i = x; i < data.length; i++) {

							if (data[i][0].trim() == 'Box') {

								if (i == x) {
									boxcontents = boxcontents + boxlevel + "<did><container localtype='box'>" + data[i][1].trim() + "</container>";
								} 
								else {
									boxcontents = boxcontents + "</did>" + boxlevelend + boxlevel + "<did><container localtype='box'>" + data[i][1].trim() + "</container>";
								}
								currbox = data[i][1].trim();
								i = i + 1;
							} else {
								if (data[i][0].trim()){
									//boxcontents = boxcontents + itemlevel + "<did><unitid>" + data[i][0].trim() + "</unitid><unittitle>" + data[i][1].trim() + "</unittitle><unitdate label='Date'>" + data[i][2].trim() + "</unitdate></did>" + itemlevelend;
									boxcontents = boxcontents + itemlevel + "<did><unitid>" + data[i][0].trim() + "</unitid><unittitle>" + data[i][1].trim() + "</unittitle>";
									if(data[i][2].trim()){
										var dt = data[i][2].trim();
										var dtlen = dt.length;
										var pos = dt.indexOf("-");
										if (pos == -1){
											boxcontents = boxcontents + "<unitdatestructured><datesingle>" + dt + "</datesingle></unitdatestructured></did>";
										}else{
											var fdate = dt.substring(0, pos);
											var tdate = dt.substring(pos+1, dtlen);
											boxcontents = boxcontents + "<unitdatestructured><daterange><fromdate>" + fdate + "</fromdate><todate>"	+ tdate + "</todate></daterange></unitdatestructured></did>";
										}
									}else{
										boxcontents = boxcontents + "<unitdatestructured><datesingle>Undated</datesingle></unitdatestructured></did>";
									}
									
									if(data[i][6].trim()){
										boxcontents = boxcontents + "<physdescstructured coverage='whole' physdescstructuredtype='materialtype'><dimensions>" + data[i][6].trim() + "</dimensions></physdescstructured>";
									}
									
									if(data[i][7].trim()){
										boxcontents = boxcontents + "<controlaccess><genreform><part>" + data[i][7].trim() + "</part></genreform></controlaccess>";
									}
									
									if(data[i][4].trim()){
										boxcontents = boxcontents + "<dao daotype='" + data[i][5].trim() + "' href='" + data[i][4].trim() + "'></dao>";
									}
									
									if(data[i][3].trim()){
										boxcontents = boxcontents + "<userestrict><p>" + data[i][3].trim() + "</p></userestrict>";
									}

									/* Archivematica csv */
									
									if(data[i][4].trim()){
										filename = "objects/" + currbox + "." + data[i][0].trim() + ".tiff";
										dataForarch.push ([filename, '"' + data[i][1].trim() + '"',  '"' + date + '"', '"' + publisher + '"', '"' + publisher + '"','"' + data[16][1].trim() + '"','"' + data[i][2].trim() + '"', ' ','"' + context + '"','"' + collection + '"','"' + repository + '"','"' + userestrict + '"','"' + data[4][2].trim() + '"','"' + data[i][7].trim() + '"']);								
									}
									

									boxcontents = boxcontents + itemlevelend;
								}
							}
						}
						boxcontents = boxcontents + "</did>" + boxlevelend + seriesend;
						boxcontents = boxcontents.replace(/&/g, "&amp;");

						$('#csvdata').val(boxcontents);
						$('#EADfilename').val(recordid);
						$('#arch').val(dataForarch);
						
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
			<div id="header1" style="padding: 20px;">
				<h1 style="color: #ffffff">Boxbuilder 2.0</h1>
				<p style="text-align: center; margin-top: -15px; font-weight: bold;">WEB BASED TOOL TO GENERATE EAD3 FILES</p>
			</div>
		</div>
		<div class="container_home">

			<div class="divContainer">
				<p style="text-align: center;">This Boxbuilder 2.0 version converts to EAD 3. Please use this <a href='http://library.marist.edu/boxbuilder/ead2002/'>link </a>to use Boxbuilder 1.0 that converts to EAD 2002.</p>
				<div id="step1">
					<h1>Step 1: Download the Boxbuilder 2.0 template available in Google Spreadsheet or in Excel format to catalog the records.</h1>
					<iframe src="https://app.box.com/embed_widget/s/w53n1n3u73p3vh4ffxzb?view=list&sort=name&direction=ASC&theme=gray" width="600" height="300" frameborder="0"allowfullscreen webkitallowfullscreen msallowfullscreen></iframe>
				
					<p>
						Please convert it to a CSV file by using the 'Save as' option in Microsoft Excel or Google Spreadsheet.
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
						<input type="submit" name="submit" value="Convert to EAD 3 and Download the file" class="labels" id="submit" style="margin-left: 99px; width: 400px; margin-top: 12px;" />
					</form>
					<button id="convert2Arch" class="labels" style="margin-left: 99px; width: 400px; margin-top: 12px;" >Convert to Archivematica CSV</button>
				</div>
				<div id="contents">
					<table name="c"></table>
				</div>

				<div id="step3" style="height: auto;">
					<h1>Step 3: Download the EAD Starter's Kit, add the converted EAD file to the 'EAD' folder.</h1>
					<p>
						Feel free to replace the name 'EAD Starter's Kit' with your collection name. Please use firefox to view the files. Google chrome does not render local xml files. It will work once its online.
					</p>
					<p>
						Github repository: <a href='https://github.com/monixis/boxbuilder' target="_blank">https://github.com/monixis/boxbuilder</a>
					</p>
					<p> Please use this <a href='https://goo.gl/forms/ThnN2Xmoqk4bao1B2' target="_blank">google form </a>to register as a Boxbuilder user. It will allow me to keep you updated on the upcoming features and bug fixes.</p>
					<p>Feel free to <a href="mailto:snh.monish@gmail.com?Subject=Boxbuilder" target="_blank">contact me </a>if you have any questions or suggestions to improve Boxbuilder </p>
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
